<?php
namespace FacturaScripts\Plugins\AquaControl\Model;

use FacturaScripts\Core\Model\Base\ModelClass;
use FacturaScripts\Core\Model\Base\ModelTrait;

class Lectura extends ModelClass
{
    use ModelTrait;

    public $id;
    public $idmedidor;
    public $fecha;
    public $lectura_anterior = 0;
    public $lectura_actual = 0;
    public $consumo = 0;
    public $estado = 'pendiente';
    public $observaciones;
    public $created_at;

    public static function primaryColumn(): string
    {
        return 'id';
    }

    public static function tableName(): string
    {
        return 'ac_lecturas';
    }

    public function url(string $type = 'auto', string $list = 'List'): string
    {
        return parent::url($type, 'ListLectura');
    }

    public function getMedidor(): ?Medidor
    {
        $medidor = new Medidor();
        return $medidor->get($this->idmedidor) ? $medidor : null;
    }

    public function calcularConsumo(): void
    {
        $this->consumo = $this->lectura_actual - $this->lectura_anterior;
        
        if ($this->consumo < 0) {
            $this->toolBox()->i18nLog()->warning('lectura-actual-menor-anterior');
            $this->consumo = 0;
        }
    }

    public function test(): bool
    {
        if (empty($this->fecha)) {
            $this->toolBox()->i18nLog()->warning('fecha-requerida');
            return false;
        }

        if ($this->lectura_actual < $this->lectura_anterior) {
            $this->toolBox()->i18nLog()->warning('lectura-actual-menor-anterior');
            return false;
        }

        $this->calcularConsumo();
        return parent::test();
    }

    public function clear()
    {
        parent::clear();
        $this->fecha = date('Y-m-d');
        $this->estado = 'pendiente';
        $this->created_at = date('Y-m-d H:i:s');
        
        if (!empty($this->idmedidor)) {
            $medidor = $this->getMedidor();
            if ($medidor) {
                $ultimaLectura = $medidor->getUltimaLectura();
                $this->lectura_anterior = $ultimaLectura ? $ultimaLectura->lectura_actual : 0;
            }
        }
    }

    public function saveUpdate(): bool
    {
        $this->calcularConsumo();
        return parent::saveUpdate();
    }

    public function saveInsert(): bool
    {
        $this->calcularConsumo();
        return parent::saveInsert();
    }
}