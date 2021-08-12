<?php
/**
 * Plugin Name: Woofall - WooCommerce Elementor Addons + Builder
 * Description: The WooCommerce elements library for Elementor page builder plugin for WordPress.
 * Plugin URI:  https://wordpress.org/plugins/woofall-addons/
 * Version:     1.0.0
 * Author:      Themepaste
 * Author URI:  https://themepaste.com/
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: woofall
 * WC tested up to: 5.5.2
 * Elementor tested up to: 3.3.1
 * Elementor Pro tested up to: 3.3.4
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Autoloader File
require_once __DIR__ . '/vendor/autoload.php';


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

    /**
     * Minimum Elementor Version
     *
     * @since 1.0.0
     *
     * @var string Minimum Elementor version required to run the plugin.
     */
    const MINIMUM_ELEMENTOR_VERSION = '3.3.1';

    /**
     * Minimum PHP Version
     *
     * @since 1.0.0
     *
     * @var string Minimum PHP version required to run the plugin.
     */
    const MINIMUM_PHP_VERSION = '5.6';

    /** Singleton *************************************************************/

    /**
     * On Plugins Loaded
     *
     * Checks if Elementor has loaded, and performs some compatibility checks.
     * If All checks pass, inits the plugin.
     *
     * Fired by `plugins_loaded` action hook.
     *
     * @since 1.0.0
     *
     * @access public
     */

    /**
     * On Plugins Loaded
     *
     * Checks if Elementor has loaded, and performs some compatibility checks.
     * If All checks pass, inits the plugin.
     *
     * Fired by `plugins_loaded` action hook.
     *
     * @since 1.0.0
     *
     */
    private function __construct() {
        $this->define_constants();

        register_activation_hook( __FILE__, [ $this, 'activate' ] );

        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
    }

    /**
     * Compatibility Checks
     *
     * Checks if the installed version of Elementor meets the plugin's minimum requirement.
     * Checks if the installed PHP version meets the plugin's minimum requirement.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function is_compatible()
    {

        // Check if Elementor installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
            return false;
        }

        // Check for required Elementor version
        if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
            return false;
        }

        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
            return false;
        }

    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have compatible installed or activated.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function admin_notice_missing_main_plugin()
    {
        if (isset($_GET['activate'])) {
            $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor */
                esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'woofall'),
                '<strong>' . esc_html__('Woofall', 'woofall') . '</strong>',
                '<strong>' . esc_html__('Elementor', 'woofall') . '</strong>'
            );
            printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
        }
        unset($_GET['activate']);
    }

    /**
     * Check elementor version
     */
    public function admin_notice_minimum_elementor_version()
    {

        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
        /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'woofall'),
            '<strong>' . esc_html__('Woofall', 'woofall') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'woofall') . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);

    }


    /**
     * Check server php versions
     */
    public function admin_notice_minimum_php_version()
    {

        if (isset($_GET['activate'])) unset($_GET['activate']);

        $message = sprintf(
        /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'woofall'),
            '<strong>' . esc_html__('Woofall', 'woofall') . '</strong>',
            '<strong>' . esc_html__('PHP', 'woofall') . '</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);

    }

    /**
     * Main Woofall Instance
     *
     * Insures that only one instance of Woofall exists in memory at any one
     * time. Also prevents needing to define globals all over the place.
     */

    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
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
    public function init_plugin() {
        new Themepaste\WoofallAddons\Admin\Admin();
        new Themepaste\WoofallAddons\Frontend\Frontend();
        new Themepaste\WoofallAddons\Includes\Includes();
    }

    /**
     * Activate Log to database
     */
    public function activate() {
        $installed = get_option( 'woofall_addons_installed' );

        if ( ! $installed ) {
            update_option( 'woofall_addons_installed', time() );
        }

        update_option( 'woofall_addons_version', WOOFALL_VERSION );
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