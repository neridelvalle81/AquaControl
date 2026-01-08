<?php
namespace FacturaScripts\Plugins\AquaControl\Model;

use FacturaScripts\Core\Model\Base\ModelClass;
use FacturaScripts\Core\Model\Base\ModelTrait;
use FacturaScripts\Core\Base\DataBase\DataBaseWhere;

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

    public function url(string $type = 'auto', string $list = 'List'): string
    {
        return parent::url($type, 'ListSuministro');
    }

    public function getTitular(): ?Titular
    {
        $titular = new Titular();
        return $titular->get($this->idtitular) ? $titular : null;
    }

    public function getMedidores(): array
    {
        $medidor = new Medidor();
        $where = [new DataBaseWhere('idsuministro', $this->id)];
        return $medidor->all($where);
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

    public function getMedidorActual(): ?Medidor
    {
        $medidor = new Medidor();
        $where = [
            new DataBaseWhere('idsuministro', $this->id),
            new DataBaseWhere('activo', true)
        ];
        $medidor->loadFromCode('', $where);
        return $medidor->primaryColumnValue() ? $medidor : null;
    }

    public function test(): bool
    {
        if (empty($this->idtitular)) {
            $this->toolBox()->i18nLog()->warning('Debe seleccionar un titular');
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