<?php

namespace Recipe_Manager\Includes;

defined('ABSPATH') || die();

class AssetsManager {
    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    public function enqueue_scripts() {
        wp_enqueue_style(
            'public',
            RECIPE_PLUGIN_ASSETS . 'css/public.css',
            null,
            RECIPE_PLUGIN_VERSION,
            'all'
        );
        wp_enqueue_style(
            'glightbox',
            RECIPE_PLUGIN_ASSETS . 'css/glightbox.min.css',
            null,
            RECIPE_PLUGIN_VERSION,
            'all'
        );
        wp_enqueue_style(
            'slick',
            RECIPE_PLUGIN_ASSETS . 'css/slick.css',
            null,
            RECIPE_PLUGIN_VERSION,
            'all'
        );


        //Js
        wp_enqueue_script(
            'public',
            RECIPE_PLUGIN_ASSETS . 'js/frontend.js',
            ['jquery'],
            RECIPE_PLUGIN_VERSION,
            true
        );
        wp_enqueue_script(
            'glightbox',
            RECIPE_PLUGIN_ASSETS . 'js/glightbox.min.js',
            ['jquery'],
            RECIPE_PLUGIN_VERSION,
            true
        );
        wp_enqueue_script(
            'slick',
            RECIPE_PLUGIN_ASSETS . 'js/slick.min.js',
            ['jquery'],
            RECIPE_PLUGIN_VERSION,
            true
        );

        wp_localize_script(
            'public',
            'ajax_helper',
            [
                'security'       => wp_create_nonce('recipe_security'),
                'ajaxurl'        => admin_url('admin-ajax.php'),
            ]
        );
    }
}
