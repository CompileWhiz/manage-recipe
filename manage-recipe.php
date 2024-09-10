<?php

/**
 * Plugin Name: Recipe Manager
 * Version: 1.0.0
 * Description: Plugin for Recipe Manager
 * License:     GPL3
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Author: Dainis Aņisimovs
 */
defined('ABSPATH') || die();

define('RECIPE_PLUGIN_VERSION', time());
define('RECIPE_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('RECIPE_PLUGIN_DIR_URL', plugin_dir_url(__FILE__));
define('RECIPE_PLUGIN_ASSETS', trailingslashit(RECIPE_PLUGIN_DIR_URL  . 'assets'));

if (!class_exists('RECIPE_PLUGIN_PLUGIN')) :

    final class RECIPE_MAIN {
        private static $instance;

        private function __construct() {
            add_action('plugins_loaded', [$this, 'init_plugin']);
        }

        public function init_plugin() {
            new Recipe_Manager\Includes\AssetsManager();
            new Recipe_Manager\Includes\Recipe_CPT();
            new Recipe_Manager\Includes\Short_Code();
            new Recipe_Manager\Includes\Ajax();
        }


        public static function instance() {
            if (!isset(self::$instance) && !(self::$instance instanceof RECIPE_MAIN)) {
                self::$instance = new RECIPE_MAIN();
                self::$instance->includes();
            }

            return self::$instance;
        }

        private function includes() {
            require_once RECIPE_PLUGIN_DIR . 'includes/assets-manager.php';
            require_once RECIPE_PLUGIN_DIR . 'includes/cpt.php';
            require_once RECIPE_PLUGIN_DIR . 'includes/short-code.php';
            require_once RECIPE_PLUGIN_DIR . 'includes/ajax.php';
        }
    }

endif;

function recipe_init_plugin() {
    return RECIPE_MAIN::instance();
}

recipe_init_plugin();
