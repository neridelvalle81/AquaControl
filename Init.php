<?php
namespace FacturaScripts\Plugins\AquaControl;

use FacturaScripts\Core\Base\DataBase;
use FacturaScripts\Core\Base\DataBase\DataBaseMigrator;
use FacturaScripts\Core\Base\InitClass as BaseInitClass;

class Init extends BaseInitClass
{
    public function init()
    {
        // Se ejecuta al activar el plugin
        $this->toolBox()->i18n()->addNecessaryFiles('AquaControl');
    }

    public function update()
    {
        // Se ejecuta al actualizar el plugin
        $this->init();
        
        // Ejecutar migraciones según versión
        $this->runMigrations();
    }
    
    private function runMigrations()
    {
        $database = new DataBase();
        $migrator = new DataBaseMigrator($database);
        
        // Obtener versión actual instalada
        $installedVersion = $this->getInstalledVersion();
        
        // Ejecutar migraciones según versión
        if (version_compare($installedVersion, '1.0', '<')) {
            $this->migrationTo1_0($migrator);
        }
        
        if (version_compare($installedVersion, '1.1', '<')) {
            $this->migrationTo1_1($migrator);
        }
        
        // Actualizar versión en base de datos
        $this->saveVersion('1.1');
    }
    
    private function getInstalledVersion(): string
    {
        $database = new DataBase();
        $sql = "SELECT value FROM fs_vars WHERE name = 'AquaControlVersion'";
        $result = $database->select($sql);
        
        return empty($result) ? '0' : $result[0]['value'];
    }
    
    private function saveVersion(string $version): void
    {
        $database = new DataBase();
        $sql = "REPLACE INTO fs_vars (name, value) VALUES ('AquaControlVersion', '" . $version . "')";
        $database->exec($sql);
    }
    
    private function migrationTo1_0(DataBaseMigrator $migrator): void
    {
        // Crear tablas iniciales (v1.0)
        $sql = "
        CREATE TABLE IF NOT EXISTS ac_titulares (
            id INT(11) NOT NULL AUTO_INCREMENT,
            codcliente VARCHAR(10) NOT NULL,
            codigo VARCHAR(20) DEFAULT NULL,
            nombre VARCHAR(150) NOT NULL,
            documento VARCHAR(30) DEFAULT NULL,
            telefono VARCHAR(50) DEFAULT NULL,
            direccion VARCHAR(255) DEFAULT NULL,
            activo TINYINT(1) DEFAULT 1,
            observaciones TEXT DEFAULT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY fk_titulares_cliente (codcliente),
            CONSTRAINT fk_titulares_cliente FOREIGN KEY (codcliente) 
                REFERENCES clientes(codcliente) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

        CREATE TABLE IF NOT EXISTS ac_suministros (
            id INT(11) NOT NULL AUTO_INCREMENT,
            idtitular INT(11) NOT NULL,
            codigo VARCHAR(30) DEFAULT NULL,
            direccion VARCHAR(255) DEFAULT NULL,
            tarifa VARCHAR(20) DEFAULT 'residencial',
            estado VARCHAR(20) DEFAULT 'activo',
            observaciones TEXT DEFAULT NULL,
            activo TINYINT(1) DEFAULT 1,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY idx_suministro_titular (idtitular),
            CONSTRAINT fk_suministros_titular FOREIGN KEY (idtitular) 
                REFERENCES ac_titulares(id) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

        CREATE TABLE IF NOT EXISTS ac_medidores (
            id INT(11) NOT NULL AUTO_INCREMENT,
            idsuministro INT(11) NOT NULL,
            numero VARCHAR(50) NOT NULL,
            marca VARCHAR(50) DEFAULT NULL,
            fecha_instalacion DATE DEFAULT NULL,
            estado VARCHAR(20) DEFAULT 'activo',
            activo TINYINT(1) DEFAULT 1,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY idx_medidor_suministro (idsuministro),
            CONSTRAINT fk_medidores_suministro FOREIGN KEY (idsuministro) 
                REFERENCES ac_suministros(id) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

        CREATE TABLE IF NOT EXISTS ac_lecturas (
            id INT(11) NOT NULL AUTO_INCREMENT,
            idmedidor INT(11) NOT NULL,
            fecha DATE NOT NULL,
            lectura_anterior INT(11) NOT NULL DEFAULT 0,
            lectura_actual INT(11) NOT NULL DEFAULT 0,
            consumo INT(11) GENERATED ALWAYS AS (lectura_actual - lectura_anterior) STORED,
            estado VARCHAR(20) DEFAULT 'pendiente',
            observaciones TEXT DEFAULT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY unique_medidor_fecha (idmedidor, fecha),
            KEY idx_lectura_medidor (idmedidor),
            CONSTRAINT fk_lecturas_medidor FOREIGN KEY (idmedidor) 
                REFERENCES ac_medidores(id) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
        ";
        
        $migrator->addSql($sql);
        $migrator->run();
    }
    
    private function migrationTo1_1(DataBaseMigrator $migrator): void
    {
        // Ejemplo: agregar nuevas columnas en v1.1
        $sql = "
        ALTER TABLE ac_suministros 
        ADD COLUMN IF NOT EXISTS tipo_suministro VARCHAR(30) DEFAULT 'agua' AFTER tarifa,
        ADD COLUMN IF NOT EXISTS zona VARCHAR(50) DEFAULT NULL AFTER direccion;
        
        ALTER TABLE ac_lecturas
        ADD COLUMN IF NOT EXISTS anomalia BOOLEAN DEFAULT FALSE AFTER estado,
        ADD COLUMN IF NOT EXISTS observacion_anomalia TEXT DEFAULT NULL AFTER anomalia;
        
        CREATE TABLE IF NOT EXISTS ac_facturacion (
            id INT(11) NOT NULL AUTO_INCREMENT,
            idsuministro INT(11) NOT NULL,
            periodo VARCHAR(7) NOT NULL COMMENT 'Formato YYYY-MM',
            consumo_m3 INT(11) NOT NULL,
            importe_total DECIMAL(10,2) NOT NULL,
            estado VARCHAR(20) DEFAULT 'pendiente',
            fecha_facturacion DATE DEFAULT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY unique_suministro_periodo (idsuministro, periodo),
            KEY idx_facturacion_suministro (idsuministro),
            CONSTRAINT fk_facturacion_suministro FOREIGN KEY (idsuministro) 
                REFERENCES ac_suministros(id) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
        ";
        
        $migrator->addSql($sql);
        $migrator->run();
    }
}