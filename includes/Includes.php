<?php

namespace Themepaste\WoofallAddons\Includes;

class Includes
{
    function __construct()
    {
        add_action('elementor/widgets/widgets_registered', array($this, 'elementor_load_widgets'));
    }

    /**
     * Include required files
     *
     */
    public function elementor_load_widgets()
    {
        foreach (glob(WOOFALL_ADDONS_PL_PATH . 'includes/widgets/*/control.php') as $file) {
            include_once $file;
        }
    }
}