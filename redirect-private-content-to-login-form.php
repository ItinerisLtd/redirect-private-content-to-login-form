<?php
/**
 * Plugin Name:         Redirect private page to login form
 * Plugin URI:          https://github.com/itinerisltd/redirect-private-content-to-login-form
 * Description:         Redirect private content to login form
 * Version:             0.1.1
 * Requires at least:   5.0
 * Requires PHP:        7.2.0
 * Author:              Itineris Limited
 * Author URI:          https://www.itineris.co.uk/
 * License:             MIT
 * Text Domain:         redirect-private-content-to-login-form
 */

declare(strict_types=1);

namespace Itineris\RedirectPrivateContentToLoginForm;

add_action('template_redirect', function (): void {
    if (! is_404()) {
        return;
    }

    $wpdb = $GLOBALS['wpdb'];
    $wp_query = $GLOBALS['wp_query'];
    $row = $wpdb->get_row($wp_query->request);
    if (! is_object($row)) {
        return;
    }

    $postStatus = $row->post_status ?? null;
    if ('private' !== $postStatus) {
        return;
    }

    $currentUrl = home_url(
        add_query_arg(null, null)
    );
    $loginUrl = wp_login_url($currentUrl);

    wp_safe_redirect($loginUrl);
    exit;
}, 9);
