<?php
namespace FacturaScripts\Plugins\AquaControl\Controller;

use FacturaScripts\Core\Lib\ExtendedController\ListController;

class ListLectura extends ListController
{
    public function getPageData(): array
    {
        $data = parent::getPageData();
        $data['title'] = 'Lecturas';
        $data['menu'] = 'AquaControl';
        $data['icon'] = 'fa-solid fa-list';
        $data['showonmenu'] = true;
        return $data;
    }

    protected function createViews()
    {
        $this->addView('ListLectura', 'Lectura', 'Lecturas', 'fa-solid fa-list');
        $this->addSearchFields('ListLectura', ['estado']);
    }

    protected function loadData($viewName, $view)
    {
        // Método requerido
    }
}