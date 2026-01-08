<?php
namespace FacturaScripts\Plugins\AquaControl\Controller;

use FacturaScripts\Core\Lib\ExtendedController\EditController;
use FacturaScripts\Plugins\AquaControl\Model\Lectura;

class EditLectura extends EditController
{
    public function getModelClassName(): string
    {
        return 'Lectura';
    }
    
    public function getPageData(): array
    {
        $data = parent::getPageData();
        $data['title'] = 'Lectura';
        $data['menu'] = 'AquaControl';
        $data['icon'] = 'fa-solid fa-list';
        return $data;
    }

    protected function createViews()
    {
        parent::createViews();
        $this->setTabsPosition('top');
    }
}