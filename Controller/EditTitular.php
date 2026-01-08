<?php
namespace FacturaScripts\Plugins\AquaControl\Controller;

use FacturaScripts\Core\Lib\ExtendedController\EditController;
use FacturaScripts\Plugins\AquaControl\Model\Titular;

class EditTitular extends EditController
{
    public function getModelClassName(): string
    {
        return 'Titular';
    }
    
    public function getPageData(): array
    {
        $data = parent::getPageData();
        $data['title'] = 'Titular';
        $data['menu'] = 'AquaControl';
        $data['icon'] = 'fa-solid fa-user';
        return $data;
    }

    protected function createViews()
    {
        parent::createViews();
        $this->setTabsPosition('top');
    }
}