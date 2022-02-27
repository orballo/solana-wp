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


function load_solana_web3_library()
{
    echo '<script src="https://unpkg.com/@solana/web3.js@latest/lib/index.iife.js"></script>';
}

function load_solana_login()
{
    wp_enqueue_script('solana-login', plugins_url("/login.js", __FILE__));
    wp_enqueue_style('solana-login', plugins_url("/login.css", __FILE__));
}



add_action('login_enqueue_scripts', 'load_solana_web3_library');
add_action('login_enqueue_scripts', 'load_solana_login');
