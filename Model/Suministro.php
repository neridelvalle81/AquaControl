<?php
namespace FacturaScripts\Plugins\AquaControl\Model;

use FacturaScripts\Core\Model\Base\ModelClass;
use FacturaScripts\Core\Model\Base\ModelTrait;

class Suministro extends ModelClass
{
    use ModelTrait;

    public $id;
    public $idtitular;
    public $codigo;
    public $direccion;
    public $tarifa = 'residencial';
    public $estado = 'activo';
    public $observaciones;
    public $activo = true;
    public $created_at;
    public $updated_at;

    public static function primaryColumn(): string
    {
        return 'id';
    }

    public static function tableName(): string
    {
        return 'ac_suministros';
    }

    public function clear()
    {
        parent::clear();
        $this->tarifa = 'residencial';
        $this->estado = 'activo';
        $this->activo = true;
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
    }
}