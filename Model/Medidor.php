<?php
namespace FacturaScripts\Plugins\AquaControl\Model;

use FacturaScripts\Core\Model\Base\ModelClass;
use FacturaScripts\Core\Model\Base\ModelTrait;
use FacturaScripts\Core\Base\DataBase\DataBaseWhere;

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

    public function url(string $type = 'auto', string $list = 'List'): string
    {
        return parent::url($type, 'ListMedidor');
    }

    public function getSuministro(): ?Suministro
    {
        $suministro = new Suministro();
        return $suministro->get($this->idsuministro) ? $suministro : null;
    }

    public function getLecturas(): array
    {
        $lectura = new Lectura();
        $where = [new DataBaseWhere('idmedidor', $this->id)];
        $order = ['fecha' => 'DESC'];
        return $lectura->all($where, $order);
    }

    public function getUltimaLectura(): ?Lectura
    {
        $lectura = new Lectura();
        $where = [new DataBaseWhere('idmedidor', $this->id)];
        $order = ['fecha' => 'DESC', 'created_at' => 'DESC'];
        $lectura->loadFromCode('', $where, $order);
        return $lectura->primaryColumnValue() ? $lectura : null;
    }

    public function clear()
    {
        parent::clear();
        $this->estado = 'activo';
        $this->activo = true;
        $this->fecha_instalacion = date('Y-m-d');
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
    }

    public function test(): bool
    {
        if (empty($this->numero)) {
            $this->toolBox()->i18nLog()->warning('El número de medidor es requerido');
            return false;
        }

        if (empty($this->idsuministro)) {
            $this->toolBox()->i18nLog()->warning('Debe seleccionar un suministro');
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