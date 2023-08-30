<?php
// Comprobar si el archivo no es accesible directamente desde la web.
if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Clase MyCustomHeadCode
 * 
 * Este módulo se encarga de cargar el contenido del archivo config.html 
 * e insertarlo en la sección <head> de cada página de la tienda PrestaShop.
 */
class MyCustomHeadCode extends Module {

    /**
     * Constructor del módulo.
     * Define algunos parámetros básicos.
     */
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

    /**
     * Método de instalación del módulo.
     * Registra el hook "displayHeader" para añadir código al <head>.
     * 
     * @return bool True si la instalación fue exitosa, de lo contrario False.
     */
    public function install() {
        return parent::install() && $this->registerHook('displayHeader');
    }

    /**
     * Método de desinstalación del módulo.
     * 
     * @return bool True si la desinstalación fue exitosa, de lo contrario False.
     */
    public function uninstall() {
        return parent::uninstall();
    }

    /**
     * Hook "displayHeader".
     * Lee el contenido del archivo config.html e inserta el código en el <head> 
     * de cada página.
     * 
     * @return string Código HTML.
     */
    public function hookDisplayHeader() {
        $customCode = file_get_contents($this->local_path . 'config.html');
        return $customCode;
    }
}
?>
