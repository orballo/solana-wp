<?php

/**
 * Plugin Name:       Solana WP
 * Plugin URI:        https://github.com/orballo/solana-wp
 * Description:       Solana for WordPress
 * Version:           0.1.0
 * Author:            Orballo
 * Author URI:        https://orballo.dev
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://github.com/orballo/solana-wp
 * Text Domain:       solana-wp
 * Domain Path:       /languages
 */

function consolelog($content)
{
    error_log(print_r($content, true));
}

function filter_out_scripts_and_styles_in_login($todo)
{
    global $pagenow;

    if ($pagenow === 'wp-login.php') {
        return ['solana-login'];
    }

    return $todo;
}

function load_solana_login()
{
    wp_enqueue_script('solana-login', plugins_url('/build/login.js', __FILE__));
    wp_enqueue_style('solana-login', plugins_url('/build/login.css', __FILE__));
}

function remove_body_class()
{
    return [];
}

add_action('login_enqueue_scripts', 'load_solana_login');
// add_filter('print_styles_array', 'filter_out_scripts_and_styles_in_login');
// add_filter('print_scripts_array', 'filter_out_scripts_and_styles_in_login');
// add_filter('login_body_class', 'remove_body_class');

// add_filter('pre_http_request', function ($preempt, $parsed_args, $url) {
//     consolelog($preempt);
//     consolelog($parsed_args);
//     consolelog($url);
//     return $preempt;
// });
