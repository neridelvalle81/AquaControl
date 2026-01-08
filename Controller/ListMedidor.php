<?php
namespace FacturaScripts\Plugins\AquaControl\Controller;

use FacturaScripts\Core\Lib\ExtendedController\ListController;

class ListMedidor extends ListController
{
    public function getPageData(): array
    {
        $data = parent::getPageData();
        $data['title'] = 'Medidores';
        $data['menu'] = 'AquaControl';
        $data['icon'] = 'fa-solid fa-gauge';
        $data['showonmenu'] = true;
        return $data;
    }

    protected function createViews()
    {
        $this->addView('ListMedidor', 'Medidor', 'Medidores', 'fa-solid fa-gauge');
    }
}