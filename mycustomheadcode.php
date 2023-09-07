<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Clase MyCustomHeadCode
 * 
 * Módulo para cargar contenido personalizado desde un archivo HTML 
 * e insertarlo en la sección <head> de cada página de PrestaShop.
 */
class MyCustomHeadCode extends Module {

    public function __construct() {
        $this->name = 'mycustomheadcode'; 
        $this->tab = 'front_office_features';
        $this->version = '1.3';
        $this->author = 'Jesús Fernández Ávila';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = ['min' => '1.6', 'max' => _PS_VERSION_];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('My Custom Head Code');
        $this->description = $this->l('Añade código personalizado en el <head> de todas las páginas.');
        $this->confirmUninstall = $this->l('¿Estás seguro de que deseas desinstalar?');
    }

    public function install() {
        return parent::install() && $this->registerHook('displayHeader');
    }

    public function uninstall() {
        return parent::uninstall();
    }

    public function hookDisplayHeader() {
        $filePath = $this->local_path . 'config.html';
        if (file_exists($filePath)) {
            $customCode = file_get_contents($filePath);
            return $customCode;
        }
        return ''; // Retorna una cadena vacía si el archivo no existe
    }
}
