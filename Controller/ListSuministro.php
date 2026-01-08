<?php
namespace FacturaScripts\Plugins\AquaControl\Controller;

use FacturaScripts\Core\Lib\ExtendedController\ListController;

class ListSuministro extends ListController
{
    public function getPageData(): array
    {
        $data = parent::getPageData();
        $data['title'] = 'Suministros';
        $data['menu'] = 'AquaControl';
        $data['icon'] = 'fa-solid fa-faucet';
        $data['showonmenu'] = true;
        return $data;
    }

    protected function createViews()
    {
        $this->addView('ListSuministro', 'Suministro', 'Suministros', 'fa-solid fa-faucet');
    }
}