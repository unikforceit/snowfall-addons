<?php

namespace UnikForce\WoomentorAddons\Frontend;

/**
 * Class Frontend
 * @package UnikForce\WoomentorAddons\Frontend
 */
class Frontend
{
    function __construct()
    {
        add_action('elementor/frontend/after_enqueue_styles', array($this, 'elementor_load_style'), 10);
        add_action('elementor/frontend/after_register_scripts', array($this, 'elementor_load_script'), 10);
    }
    /**
     * Load Frontend Style
     *
     */
    public function elementor_load_style()
    {
        foreach (glob(WOOMENTOR_PLUGIN_DIR_NAME . 'assets/css/*.css') as $file) {
            $filename = substr($file, strrpos($file, '/') + 1);
            wp_enqueue_style($filename, WOOMENTOR_ADDONS_PL_URL . 'assets/css/' . $filename, array(), filemtime(WOOMENTOR_PLUGIN_DIR_NAME . 'assets/css/' . $filename), 'all');
        }
        //wp_enqueue_style( 'woomentor', WOOMENTOR_ADDONS_PL_URL . 'assets/css/woomentor.css', array(), WOOMENTOR_VERSION, 'all');

    }
    /**
     * Load Frontend Scripts
     *
     */
    public function elementor_load_script()
    {
        foreach (glob(WOOMENTOR_PLUGIN_DIR_NAME . 'assets/js/*.js') as $file) {
            $filename = substr($file, strrpos($file, '/') + 1);
            wp_enqueue_script($filename, WOOMENTOR_ADDONS_PL_URL . 'assets/js/' . $filename, array('jquery'), filemtime(WOOMENTOR_PLUGIN_DIR_NAME . 'assets/js/' . $filename), true);
        }
    }

}