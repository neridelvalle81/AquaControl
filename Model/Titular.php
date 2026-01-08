<?php
namespace FacturaScripts\Plugins\AquaControl\Model;

use FacturaScripts\Core\Model\Base\ModelClass;
use FacturaScripts\Core\Model\Base\ModelTrait;
use FacturaScripts\Core\Base\DataBase\DataBaseWhere;

class Titular extends ModelClass
{
    use ModelTrait;

    public $id;
    public $codcliente;
    public $codigo;
    public $nombre;
    public $documento;
    public $telefono;
    public $direccion;
    public $activo = true;
    public $observaciones;
    public $created_at;
    public $updated_at;

    public static function primaryColumn(): string
    {
        return 'id';
    }

    public static function tableName(): string
    {
        return 'ac_titulares';
    }

    public function url(string $type = 'auto', string $list = 'List'): string
    {
        return parent::url($type, 'ListTitular');
    }

    public function getCliente()
    {
        $cliente = new \FacturaScripts\Core\Model\Cliente();
        return $cliente->get($this->codcliente);
    }

    public function getSuministros(): array
    {
        $suministro = new Suministro();
        $where = [new DataBaseWhere('idtitular', $this->id)];
        return $suministro->all($where);
    }

    public function clear()
    {
        parent::clear();
        $this->activo = true;
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
    }

    public function test(): bool
    {
        if (empty($this->nombre)) {
            $this->toolBox()->i18nLog()->warning('El nombre es requerido');
            return false;
        }

        return parent::test();
    }

    public function saveUpdate(): bool
    {
        $this->updated_at = date('Y-m-d H:i:s');
        return parent::saveUpdate();
    }
}