<?php
/*
Plugin Name:  Quickchart QR Code Short URLS
Plugin URI: https://github.com/tyler71/yourls-quickchart-qr-code
Description: Add suffix to shorturls to display QR Code
Version: 1.0
Author: tyler71
Author URI: https://github.com/tyler71/yourls-quickchart-qr-code
*/

// Based on https://yourls.org/docs/development/examples/qrcode

// Plugin settings page etc.
yourls_add_action( 'plugins_loaded', 'qr_code_add_settings' );
function qr_code_add_settings() {
    yourls_register_plugin_page( 'qr_code_settings', 'Qr Code Settings', 'qr_code_add_settings_page' );
}

function qr_code_add_settings_page() {
    $quickchart_url = yourls_get_option('quickchart_url', 'https://quickchart.io');

    // Check if form was submitted
    if( isset( $_POST['qr_suffix'] ) ) {
        // If so, verify nonce
        yourls_verify_nonce( 'qr_code_settings' );
        // and process submission if nonce is valid
        qr_code_setting_update();
    }

    $qr_suffix = yourls_get_option('qr_suffix', '/qr');
    $nonce = yourls_create_nonce( 'qr_code_settings' );

    echo <<<HTML
        <main>
            <h2>QR Code Settings</h2>
            <form method="post">
            <input type="hidden" name="nonce" value="$nonce" />
            <p>
                <label>Suffix</label>
                <input type="string" name="qr_suffix" value="$qr_suffix" />
            </p>
            <p>
                <label>Quickchart Url</label>
                <input type="string" name="quickchart_url" value="$quickchart_url" />
            </p>
            <p><input type="submit" value="Save" class="button" /></p>
            </form>
        </main>
HTML;
}

function qr_code_setting_update() {
    $qr_suffix = $_POST['qr_suffix'];

    if( $qr_suffix ) {
        if( is_string( $qr_suffix ) ) {
            yourls_update_option( 'qr_suffix', strval( $qr_suffix ) );
        } else {
            echo "Error: Length given was not a string.";
        }
    } else {
        echo "Error: No length value given.";
    }

    $quickchart_url = $_POST['quickchart_url'];

    if( $quickchart_url ) {
        if( is_string( $quickchart_url ) ) {
            yourls_update_option( 'quickchart_url', strval( $quickchart_url ) );
        } else {
            echo "Error: Length given was not a string.";
        }
    } else {
        echo "Error: No length value given.";
    }
}

// Kick in if the loader does not recognize a valid pattern
yourls_add_action('redirect_keyword_not_found', 'yourls_qrcode', 1);

function yourls_qrcode( $request ) {
    // Get authorized charset in keywords and make a regexp pattern
    $pattern = yourls_make_regexp_pattern( yourls_get_shorturl_charset() );

    // Shorturl is like bleh.qr?
    if( preg_match( "@^([$pattern]+)" . yourls_get_option("qr_suffix") . "?/?$@", $request[0], $matches ) ) {
        // this shorturl exists?
        $keyword = yourls_sanitize_keyword( $matches[1] );
        if( yourls_is_shorturl( $keyword ) ) {
            // Show the QR code then!
            header('Location: ' . yourls_get_option('quickchart_url') . '/qr?text='.YOURLS_SITE.'/'.$keyword);
            exit;
        }
    }
}
