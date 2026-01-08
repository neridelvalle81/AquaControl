<?php
namespace FacturaScripts\Plugins\AquaControl\Model;

use FacturaScripts\Core\Model\Base\ModelClass;
use FacturaScripts\Core\Model\Base\ModelTrait;

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

    public function clear()
    {
        parent::clear();
        $this->activo = true;
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
    }
}