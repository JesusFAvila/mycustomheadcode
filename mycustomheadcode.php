<?php

// Evita el acceso directo al archivo desde la web.
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

    // Propiedad para almacenar el código en caché.
    private $customCodeCache = null;

    public function __construct() {
        $this->name = 'mycustomheadcode'; 
        $this->tab = 'front_office_features';
        $this->version = '1.4';
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

    /**
     * Hook "displayHeader".
     * Si el código no está en caché, lee el contenido del archivo config.html.
     * 
     * @return string Código HTML.
     */
    public function hookDisplayHeader() {
        // Si el código no está en caché, lo leemos del archivo.
        if (is_null($this->customCodeCache)) {
            $filePath = $this->local_path . 'config.html';
            if (file_exists($filePath)) {
                $this->customCodeCache = file_get_contents($filePath);
            } else {
                // Registra un error si el archivo no se encuentra.
                PrestaShopLogger::addLog('MyCustomHeadCode: No se pudo encontrar el archivo config.html', 3, null, null, null, true);
                $this->customCodeCache = '';
            }
        }
        return $this->customCodeCache;
    }
}
