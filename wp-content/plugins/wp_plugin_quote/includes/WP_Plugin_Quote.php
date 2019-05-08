<?php

class WP_Plugin_Quote{


    /**
     * A reference to an instance of this class.
     *
     * @since 1.0.0
     * @var   object
     */
    private static $instance = null;

    /**
     * Sets up needed actions/filters for the plugin to initialize.
     *
     * @since 1.0.0
     */
    public function __construct() {

        // Register activation and deactivation hook.
        register_activation_hook( __FILE__, array( $this, 'activation'     ) );
        register_deactivation_hook( __FILE__, array( $this, 'deactivation' ) );
    }

    /**
     * On plugin activation.
     *
     * @since 1.0.0
     */
    function activation() {
        WP_Plugin_Quote_Registration::register();
        WP_Plugin_Quote_Registration::register_taxonomy();

        flush_rewrite_rules();
    }

    /**
     * On plugin deactivation.
     *
     * @since 1.0.0
     */
    function deactivation() {
        flush_rewrite_rules();
    }

    /**
     * Returns the instance.
     *
     * @since  1.0.0
     * @return object
     */
    public static function get_instance() {

        // If the single instance hasn't been set, set it now.
        if ( null == self::$instance )
            self::$instance = new self;

        return self::$instance;
    }
}