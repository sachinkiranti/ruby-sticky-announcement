<?php
/**
 * Plugin Name: Ruby Sticky Announcement
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function ruby_sticky_announcement_settings_page() {
    add_options_page(
        __( 'Ruby Sticky Announcement', 'ruby-sticky-announcement' ),
        __( 'Ruby Sticky Announcement', 'ruby-sticky-announcement' ),
        'manage_options',
        'ruby-sticky-announcement',
        'ruby_sticky_announcement_settings_page_html'
    );
}

add_action( 'admin_menu', 'ruby_sticky_announcement_settings_page' );

function ruby_sticky_announcement_settings_page_html() {
    printf(
        '<div class="wrap" id="ruby-sticky-announcement-settings">%s</div>',
        esc_html__( 'Loading…', 'ruby-sticky-announcement' )
    );
}

function enqueue_react_jsx_runtime_polyfill() {

}

add_action('admin_enqueue_scripts', 'enqueue_react_jsx_runtime_polyfill');


function ruby_sticky_announcement_settings_page_enqueue_assets( $admin_page ) {
    if ( 'settings_page_ruby-sticky-announcement' !== $admin_page ) {
        return;
    }

    $asset_file = plugin_dir_path( __FILE__ ) . 'build/index.asset.php';

    if ( ! file_exists( $asset_file ) ) {
        return;
    }

    $asset = include $asset_file;

    wp_enqueue_script(
        'ruby-sticky-announcement-initsss-script',
        plugins_url( 'build/index.js', __FILE__ ),
        $asset['dependencies'],
        $asset['version'],
        array(
            'in_footer' => true,
        )
    );

    wp_enqueue_style( 'wp-components' );
}

add_action( 'admin_enqueue_scripts', 'ruby_sticky_announcement_settings_page_enqueue_assets' );

function ruby_sticky_announcement_settings() {
    $default = array(
        'message' => __( 'Hello, World!', 'ruby-sticky-announcement' ),
        'display' => true,
        'size'    => 'medium',
    );
    $schema  = array(
        'type'       => 'object',
        'properties' => array(
            'message' => array(
                'type' => 'string',
            ),
            'display' => array(
                'type' => 'boolean',
            ),
            'size'    => array(
                'type' => 'string',
                'enum' => array(
                    'small',
                    'medium',
                    'large',
                    'x-large',
                ),
            ),
        ),
    );

    register_setting(
        'options',
        'ruby_sticky_announcement',
        array(
            'type'         => 'object',
            'default'      => $default,
            'show_in_rest' => array(
                'schema' => $schema,
            ),
        )
    );
}

add_action( 'init', 'ruby_sticky_announcement_settings' );

function ruby_sticky_announcement_front_page() {
    $options = get_option( 'ruby_sticky_announcement' );

    if ( ! $options['display'] ) {
        return;
    }

    $css = WP_Style_Engine::compile_css(
        array(
            'background' => 'var(--wp--preset--color--vivid-purple, #9b51e0)',
            'color'      => 'var(--wp--preset--color--white, #ffffff)',
            'padding'    => 'var(--wp--preset--spacing--20, 1.5rem)',
            'font-size'  => $options['size'],
        ),
        ''
    );

    printf(
        '<div style="%s">%s</div>',
        esc_attr( $css ),
        esc_html( $options['message'] )
    );
}

add_action( 'wp_body_open', 'ruby_sticky_announcement_front_page' );