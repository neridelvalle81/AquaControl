<?php
namespace FacturaScripts\Plugins\AquaControl\Controller;

use FacturaScripts\Core\Lib\ExtendedController\PanelController;

class HomeAquaControl extends PanelController
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
        // Panel de inicio/dashboard
        // $this->addHtmlView('Dashboard', 'Dashboard', 'Home', 'dashboard');
        // Temporalmente vacío hasta crear la vista
    }

    protected function loadData($viewName, $view)
    {
        // Método requerido por BaseController
        switch ($viewName) {
            // Puedes cargar datos específicos para cada vista aquí
        }
    }

    public function execAfterAction($action)
    {
        parent::execAfterAction($action);
    }
}