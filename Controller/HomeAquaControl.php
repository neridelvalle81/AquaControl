<?php
namespace FacturaScripts\Plugins\AquaControl\Controller;

use FacturaScripts\Core\Lib\ExtendedController\ListController;

class HomeAquaControl extends ListController
{
    public function getPageData(): array
    {
        $data = parent::getPageData();
        $data['title'] = 'AquaControl';
        $data['menu'] = 'AquaControl';
        $data['icon'] = 'fa-solid fa-droplet';
        $data['showonmenu'] = true;
        return $data;
    }

    protected function createViews()
    {
        $this->addView('ListTitular', 'Titular', 'Titulares', 'fa-solid fa-user');
        $this->addSearchFields('ListTitular', ['nombre', 'documento']);
    }

    protected function loadData($viewName, $view)
    {
        // Método requerido
    }
}