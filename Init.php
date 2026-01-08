<?php
namespace FacturaScripts\Plugins\AquaControl;

use FacturaScripts\Core\Base\InitClass as BaseInitClass;

class Init extends BaseInitClass
{
    public function init()
    {
        $this->toolBox()->i18n()->addNecessaryFiles('AquaControl');
    }

    public function update()
    {
        // Se ejecuta al actualizar
    }
}