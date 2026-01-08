<?php
namespace FacturaScripts\Plugins\AquaControl\Model;

use FacturaScripts\Core\Model\Base\ModelClass;
use FacturaScripts\Core\Model\Base\ModelTrait;

class Medidor extends ModelClass
{
    use ModelTrait;

    public $id;
    public $idsuministro;
    public $numero;
    public $marca;
    public $fecha_instalacion;
    public $estado = 'activo';
    public $activo = true;
    public $created_at;
    public $updated_at;

    public static function primaryColumn(): string
    {
        return 'id';
    }

    public static function tableName(): string
    {
        return 'ac_medidores';
    }

    public function clear()
    {
        parent::clear();
        $this->estado = 'activo';
        $this->activo = true;
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
    }
}