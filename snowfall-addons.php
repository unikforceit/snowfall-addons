<?php
/**
 * Plugin Name: Woofall - WooCommerce Elementor Addons + Builder
 * Description: The WooCommerce elements library for Elementor page builder plugin for WordPress.
 * Plugin URI:  https://wordpress.org/plugins/woofall-addons/
 * Version:     1.0.0
 * Author:      Themepaste
 * Author URI:  https://themepaste.com/
 * License:     GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain: woofall
 * WC tested up to: 5.5.2
 * Elementor tested up to: 3.3.1
 * Elementor Pro tested up to: 3.3.4
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Autoloader File
require_once (__DIR__ . '/vendor/autoload.php');
include_once(ABSPATH . 'wp-admin/includes/plugin.php');

/**
 * Class Woofall
 */
final class WOOFALL_ADDONS
{
    /**
     * Plugin Version
     *
     * @since 1.0.0
     *
     * @var string The plugin version.
     */
    const VERSION = '1.0.0';

    /** Singleton *************************************************************/

    private function __construct()
    {

        $this->define_constants();

        register_activation_hook(__FILE__, [$this, 'activate']);

        add_action('plugins_loaded', [$this, 'init_plugin']);
    }

    /**
     * Main Woofall Instance
     *
     * Insures that only one instance of Woofall exists in memory at any one
     * time. Also prevents needing to define globals all over the place.
     */

    public static function init()
    {
        static $instance = false;

        if (!$instance) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * @return mixed
     */
    public function define_constants()
    {
        define('WOOFALL_VERSION', self::VERSION);
        define('WOOFALL_ADDONS_PL_ROOT', __FILE__);
        define('WOOFALL_ADDONS_PL_URL', plugins_url('/', WOOFALL_ADDONS_PL_ROOT));
        define('WOOFALL_ADDONS_PL_PATH', plugin_dir_path(WOOFALL_ADDONS_PL_ROOT));
        define('WOOFALL_ADDONS_DIR_URL', plugin_dir_url(WOOFALL_ADDONS_PL_ROOT));
        define('WOOFALL_PLUGIN_BASE', plugin_basename(WOOFALL_ADDONS_PL_ROOT));
        define('WOOFALL_PLUGIN_DIR_NAME', dirname(__FILE__) . '/');
        define('WOOFALL_ITEM_NAME', 'Woofall - WooCommerce Elementor Addons + Builder');
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin()
    {

        new Themepaste\WoofallAddons\Admin\Admin();
        new Themepaste\WoofallAddons\Frontend\Frontend();
        new Themepaste\WoofallAddons\Includes\Includes();

    }

    /**
     * Activate Log to database
     */
    public function activate()
    {

        $installed = get_option('woofall_addons_installed');

        if (!$installed) {
            update_option('woofall_addons_installed', time());
        }

        update_option('woofall_addons_version', WOOFALL_VERSION);
    }

    /**
     * Throw error on object clone
     *
     * The whole idea of the singleton design pattern is that there is a single
     * object therefore, we don't want the object to be cloned.
     */
    public function __clone()
    {
        // Cloning instances of the class is forbidden
        _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'woofall'), '1.0.0');
    }

    /**
     * Disable unserializing of the class
     *
     */
    public function __wakeup()
    {
        // Unserializing instances of the class is forbidden
        _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'woofall'), '1.0.0');
    }

}

function WOOFALL_ADDONS_INIT()
{
    return WOOFALL_ADDONS::init();
}

// Get WooFall Addons Running
WOOFALL_ADDONS_INIT();