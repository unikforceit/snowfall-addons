<?php

namespace Themepaste\SnowfallAddons\Admin;

class Admin
{
    function __construct()
    {
        add_action('elementor/widgets/widgets_registered', array($this, 'elementor_load_widgets'));
        add_action('elementor/frontend/after_register_scripts', array($this, 'elementor_load_script'), 10);
        add_action('elementor/frontend/after_enqueue_styles', array($this, 'elementor_load_style'), 10);
        add_action('elementor/init', array($this, 'elementor_category'));
        add_action('template_redirect',  array($this, 'elementor_template_redirect'), 9);
    }
    

    public function elementor_template_redirect() {
        $instance = \Elementor\Plugin::$instance->templates_manager->get_source('local');
        remove_action('template_redirect', [$instance, 'block_template_frontend']);
    }

    public function elementor_category()
    {
        \Elementor\Plugin::instance()->elements_manager->add_category(
            'snowfall',
            array(
                'title' => __('Snowfall', 'snowfall'),
                'icon' => 'fa fa-plug',
            ),
            1);
    }

    /**
     * Load Frontend Style
     *
     */
    public function  elementor_load_style()
    {
        foreach( glob( SNOWFALL_PLUGIN_DIR_NAME. 'assets/css/*.css' ) as $file ) {
            $filename = substr($file, strrpos($file, '/') + 1);
            wp_enqueue_style( $filename, SNOWFALL_ADDONS_PL_URL . 'assets/css/'.$filename, array(), SNOWFALL_VERSION, 'all');
        }
        //wp_enqueue_style( 'snowfall', SNOWFALL_ADDONS_PL_URL . 'assets/css/snowfall.css', array(), SNOWFALL_VERSION, 'all');

    }

    /**
     * Load Frontend Scripts
     *
     */
    public function  elementor_load_script()
    {
        foreach( glob( SNOWFALL_PLUGIN_DIR_NAME. 'assets/js/*.js' ) as $file ) {
            $filename = substr($file, strrpos($file, '/') + 1);
            wp_enqueue_script( $filename, SNOWFALL_ADDONS_PL_URL . 'assets/js/'.$filename, array('jquery'), SNOWFALL_VERSION, true);
        }
    }


    /**
     * Include required files
     *
     */
    public function  elementor_load_widgets()
    {
        foreach (glob(SNOWFALL_ADDONS_PL_PATH . 'includes/widgets/*/control.php') as $file) {
            include_once $file;
        }
    }

}