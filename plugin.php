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

require_once 'vendor/autoload.php';

use Tuupola\Base58;


// Util to log to error.log file.

function consolelog($content)
{
    error_log(print_r($content, true));
}



// Load plugin scripts and styles for UI.

function load_solana_login()
{
    wp_enqueue_script('solana-login', plugins_url('/build/login.js', __FILE__));
    wp_enqueue_style('solana-login', plugins_url('/build/login.css', __FILE__));
}

add_action('login_enqueue_scripts', 'load_solana_login');



// Load plugin endpoints.

function solana_endpoint_sign_in($request)
{
    $message = 'Wordpress Authentication';
    $body = json_decode($request->get_body());
    $public_key = $body->publicKey;
    $signature = $body->signature->data;

    $base58 = new Base58(["characters" => Base58::BITCOIN]);

    $public_key_decoded = $base58->decode($public_key);
    $signature_decoded = pack('C*', ...$signature);

    $verified = sodium_crypto_sign_verify_detached($signature_decoded, $message, $public_key_decoded);

    if ($verified) {
        $user = reset(get_users(array(
            'meta_key' => 'solana_address',
            'meta_value' => $public_key,
            'number' => 1
        )));

        if (!is_wp_error($user)) {
            wp_set_current_user($user->ID);
            wp_set_auth_cookie($user->ID, true, true);

            return new WP_REST_Response(null, 302, array(
                'location' => admin_url()
            ));
        }
    }

    return new WP_REST_Response(null, 401);
}

function load_solana_endpoints()
{
    register_rest_route('solana-wp/v1', '/sign-in', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'solana_endpoint_sign_in'
    ));
}

add_action('rest_api_init', 'load_solana_endpoints');


// Add metaboxes to user for Solana address.

function add_solana_address_to_user($methods)
{
    $methods['solana_address'] = "Solana Address";

    return $methods;
}

add_filter('user_contactmethods', 'add_solana_address_to_user');
