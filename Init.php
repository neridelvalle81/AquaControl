<?php
/**
 * AquaControl - Plugin para FacturaScripts
 * @package AquaControl
 */

namespace FacturaScripts\Plugins\AquaControl;

use FacturaScripts\Core\Base\InitClass;

class Init extends InitClass
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
    }
}