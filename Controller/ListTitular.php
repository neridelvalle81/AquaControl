<?php
namespace FacturaScripts\Plugins\AquaControl\Controller;

use FacturaScripts\Core\Lib\ExtendedController\ListController;

class ListTitular extends ListController
{
    public function getPageData(): array
    {
        $data = parent::getPageData();
        $data['title'] = 'Titulares';
        $data['menu'] = 'AquaControl';
        $data['icon'] = 'fa-solid fa-user';
        $data['showonmenu'] = true;
        return $data;
    }

    protected function createViews()
    {
        $this->addView('ListTitular', 'Titular', 'Titulares', 'fa-solid fa-user');
    }
}