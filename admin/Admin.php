<?php

namespace Themepaste\WoofallAddons\Admin;

/**
 * Class Admin
 * @package Themepaste\WoofallAddons\Admin
 */
class Admin
{
    function __construct()
    {
        add_action('elementor/init', array($this, 'elementor_category'));
        add_action('template_redirect', array($this, 'elementor_template_redirect'), 9);
        //add_filter('plugin_action_links_' . WOOFALL_PLUGIN_BASE, [$this, 'plugins_setting_links']);
        //add_filter('plugin_row_meta', array($this, 'plugin_meta_links'), 10, 2);
        add_filter('admin_footer_text', array($this, 'admin_footer_text'));
        add_action('admin_enqueue_scripts', [$this, 'admin_css']);

        if (!is_plugin_active('elementor/elementor.php')) {
            add_action('admin_notices', [$this, 'elmentor_plugins_missing']);
        }
        if (!is_plugin_active('woocommerce/woocommerce.php')) {
            add_action('admin_notices', [$this, 'woocommerce_plugins_missing']);
        }
    }
    /**
     * Missing Elementor Check
     */
    public function elmentor_plugins_missing()
    {

        if (!current_user_can('install_plugins')) {
            return;
        }
        $screen = get_current_screen();
        if (isset($screen->parent_file) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id) {
            return;
        }
        $plugin = 'elementor/elementor.php';
        $installed_plugins = get_plugins();
        $is_woocommerce_installed = isset($installed_plugins[$plugin]);
        if (!$is_woocommerce_installed) {
            $button_text = 'Install Now!';
            $button_link = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=elementor'), 'install-plugin_elementor');
        } else {
            $button_text = 'Activate Now!';
            $button_link = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin);
        }
        ?>
        <div class="notice notice-warning is-dismissible">
            <p>
                <strong><?php esc_html_e(WOOFALL_ITEM_NAME . ' requires Elementor to be installed and activated.', 'woofall'); ?></strong>
            </p>
            <br>
            <a class="button button-primary"
               href="<?php echo esc_attr($button_link); ?>"><?php esc_html_e($button_text); ?></a>
            <br>
            <br>
        </div>
        <?php
    }

    /**
     * Missing WooCommerce Check
     */
    public function woocommerce_plugins_missing()
    {
        if (!current_user_can('install_plugins')) {
            return;
        }
        $screen = get_current_screen();
        if (isset($screen->parent_file) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id) {
            return;
        }
        $plugin = 'woocommerce/woocommerce.php';
        $installed_plugins = get_plugins();
        $is_woocommerce_installed = isset($installed_plugins[$plugin]);
        if (!$is_woocommerce_installed) {
            $button_text = 'Install Now!';
            $button_link = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=woocommerce'), 'install-plugin_woocommerce');
        } else {
            $button_text = 'Activate Now!';
            $button_link = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin);
        }
        ?>
        <div class="notice notice-warning is-dismissible">
            <p>
                <strong><?php esc_html_e(WOOFALL_ITEM_NAME . ' requires WooCommerce to be installed and activated.', 'woofall'); ?></strong>
            </p>
            <br>
            <a class="button button-primary"
               href="<?php echo esc_attr($button_link); ?>"><?php esc_html_e($button_text); ?></a>
            <br>
            <br>
        </div>
        <?php
    }

    /**
     * Admin css Handler
     */
    public function admin_css()
    {
        wp_enqueue_style('admin-style', WOOFALL_ADDONS_PL_URL . 'assets/css/admin.css', array(), filemtime(WOOFALL_PLUGIN_DIR_NAME . 'assets/css/admin.css'), 'all');
    }

    /**
     * Elementor template block Handler
     */
    public function elementor_template_redirect()
    {
        $instance = \Elementor\Plugin::$instance->templates_manager->get_source('local');
        remove_action('template_redirect', [$instance, 'block_template_frontend']);
    }


    /**
     * Elementor Category Handler
     */
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
     * [plugins_setting_links]
     * @param  [array] $links default plugin action link
     * @return [array] plugin action link
     */
    public function plugins_setting_links($links)
    {
        $settings_link = '<a href="' . admin_url('admin.php?page=woofall') . '">' . esc_html__('Settings', 'woofall') . '</a>';
        array_unshift($links, $settings_link);
        if (!is_plugin_active('woofall-addons-pro/woofall-addons-pro.php')) {
            $links['woofall'] = sprintf('<a href="https://themepaste.com" target="_blank" style="color: #39b54a; font-weight: bold;">' . esc_html__('Go Pro', 'woofall') . '</a>');
        }
        return $links;
    }

    /**
     * Add links to plugin's description in plugins table
     *
     * @param array $links Initial list of links.
     * @param string $file Basename of current plugin.
     *
     * @return array
     */
    function plugin_meta_links($links, $file)
    {
        if (strpos($file, basename(__FILE__))) {
            return $links;
        }

        $links[] = '<a target="_blank" href="https://wordpress.org/support/plugin/woofall-addons" title="' . __('Get help', 'woofall') . '">' . __('Support', 'woofall') . '</a>';
        $links[] = '<a target="_blank" href="https://wordpress.org/support/plugin/woofall-addons/reviews/#new-post" title="' . __('Rate the plugin', 'woofall') . '">' . __('Rate the plugin ★★★★★', 'woofall') . '</a>';

        return $links;
    }

    /**
     * Test if we're on woofall's admin page
     *
     * @return bool
     */
    function is_plugin_page()
    {
        $current_screen = get_current_screen();

        if (!empty($current_screen->id) && $current_screen->id == 'plugins') {
            return true;
        } else {
            return false;
        }
    } // is_plugin_page

    /**
     * Helper function for generating links
     *
     * @param string $placement Optional. UTM content param.
     * @param string $page Optional. Page to link to.
     * @param array $params Optional. Extra URL params.
     * @param string $anchor Optional. URL anchor part.
     *
     * @return string
     */
    function generate_web_link($placement = '', $page = '/', $params = array(), $anchor = '')
    {
        $base_url = 'https://themepaste.com';

        if ('/' != $page) {
            $page = '/' . trim($page, '/') . '/';
        }
        if ($page == '//') {
            $page = '/';
        }

        if ($placement) {
            $placement = trim($placement);
            $placement = '-' . $placement;
        }

        $parts = array_merge(array('ref' => 'wp-reset-free' . $placement), $params);

        if (!empty($anchor)) {
            $anchor = '#' . trim($anchor, '#');
        }

        $out = $base_url . $page . '?' . http_build_query($parts, '', '&amp;') . $anchor;

        return $out;
    } // generate_web_link

    /**
     * Add powered by text in admin footer
     *
     * @param string $text Default footer text.
     *
     * @return string
     */
    function admin_footer_text($text)
    {
        if (!$this->is_plugin_page()) {
            return $text;
        }

        $text = '<i><a href="' . esc_url($this->generate_web_link('admin_footer')) . '" title="' . esc_attr(__('Visit WooFall Addons page for more info', 'woofall')) . '" target="_blank">WooFall Addons</a> v' . WOOFALL_VERSION . '. Please <a target="_blank" href="https://wordpress.org/support/plugin/woofall-addons/reviews/#new-post" title="Rate the plugin">rate the plugin <span>★★★★★</span></a> to help us spread the word. Thank you from the WP Reset team!</i>';

        return $text;
    } // admin_footer_text


}