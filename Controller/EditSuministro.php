<?php
namespace FacturaScripts\Plugins\AquaControl\Controller;

use FacturaScripts\Core\Lib\ExtendedController\EditController;
use FacturaScripts\Plugins\AquaControl\Model\Suministro;

class EditSuministro extends EditController
{
    public function getModelClassName(): string
    {
        return 'Suministro';
    }
    
    public function getPageData(): array
    {
        $data = parent::getPageData();
        $data['title'] = 'Suministro';
        $data['menu'] = 'AquaControl';
        $data['icon'] = 'fa-solid fa-faucet';
        return $data;
    }

    protected function createViews()
    {
        parent::createViews();
        $this->setTabsPosition('top');
    }
}