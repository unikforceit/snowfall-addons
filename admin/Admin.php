<?php

namespace Themepaste\WoofallAddons\Admin;

class Admin
{
    function __construct()
    {
        add_action('elementor/widgets/widgets_registered', array($this, 'elementor_load_widgets'));
        add_action('elementor/frontend/after_register_scripts', array($this, 'elementor_load_script'), 10);
        add_action('elementor/frontend/after_enqueue_styles', array($this, 'elementor_load_style'), 10);
        add_action('elementor/init', array($this, 'elementor_category'));
        add_action('template_redirect',  array($this, 'elementor_template_redirect'), 9);
        add_filter('plugin_action_links_'.WOOFALL_PLUGIN_BASE, [ $this, 'plugins_setting_links' ] );
    }
    

    public function elementor_template_redirect() {
        $instance = \Elementor\Plugin::$instance->templates_manager->get_source('local');
        remove_action('template_redirect', [$instance, 'block_template_frontend']);
    }

    public function elementor_category()
    {
        \Elementor\Plugin::instance()->elements_manager->add_category(
            'woofall',
            array(
                'title' => __('Woofall', 'woofall'),
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
        foreach( glob( WOOFALL_PLUGIN_DIR_NAME. 'assets/css/*.css' ) as $file ) {
            $filename = substr($file, strrpos($file, '/') + 1);
            wp_enqueue_style( $filename, WOOFALL_ADDONS_PL_URL . 'assets/css/'.$filename, array(), WOOFALL_VERSION, 'all');
        }
        //wp_enqueue_style( 'woofall', WOOFALL_ADDONS_PL_URL . 'assets/css/woofall.css', array(), WOOFALL_VERSION, 'all');

    }

    /**
     * Load Frontend Scripts
     *
     */
    public function  elementor_load_script()
    {
        foreach( glob( WOOFALL_PLUGIN_DIR_NAME. 'assets/js/*.js' ) as $file ) {
            $filename = substr($file, strrpos($file, '/') + 1);
            wp_enqueue_script( $filename, WOOFALL_ADDONS_PL_URL . 'assets/js/'.$filename, array('jquery'), WOOFALL_VERSION, true);
        }
    }


    /**
     * Include required files
     *
     */
    public function  elementor_load_widgets()
    {
        foreach (glob(WOOFALL_ADDONS_PL_PATH . 'includes/widgets/*/control.php') as $file) {
            include_once $file;
        }
    }

    /**
     * [plugins_setting_links]
     * @param  [array] $links default plugin action link
     * @return [array] plugin action link
     */
    public function plugins_setting_links( $links ) {
        $settings_link = '<a href="'.admin_url('admin.php?page=woofall#tab=overview').'">'.esc_html__( 'Settings', 'woofall' ).'</a>';
        array_unshift( $links, $settings_link );
        if( !is_plugin_active('woofall-addons-pro/woofall-addons-pro.php') ){
            $links['woofallgo_pro'] = sprintf('<a href="https://themepaste.com" target="_blank" style="color: #39b54a; font-weight: bold;">' . esc_html__('Go Pro','woofall') . '</a>');
        }
        return $links;
    }


}