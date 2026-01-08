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

    public function clear()
    {
        parent::clear();
        $this->fecha = date('Y-m-d');
        $this->estado = 'pendiente';
        $this->created_at = date('Y-m-d H:i:s');
    }
}