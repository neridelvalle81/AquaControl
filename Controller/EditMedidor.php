<?php
namespace FacturaScripts\Plugins\AquaControl\Controller;

use FacturaScripts\Core\Lib\ExtendedController\EditController;

class EditMedidor extends EditController
{
    public function getModelClassName(): string
    {
        return 'Medidor';
    }
    
    public function getPageData(): array
    {
        $data = parent::getPageData();
        $data['title'] = 'Medidor';
        $data['menu'] = 'AquaControl';
        $data['icon'] = 'fa-solid fa-gauge';
        return $data;
    }

    protected function createViews()
    {
        parent::createViews();
        $this->setTabsPosition('top');
    }
}