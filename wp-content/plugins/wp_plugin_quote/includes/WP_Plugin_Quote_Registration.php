<?php


class WP_Plugin_Quote_Registration{

    /**
     * A reference to an instance of this class.
     *
     * @since 1.0.0
     * @var   object
     */
    private static $instance = null;

    /**
     * Sets up needed actions/filters.
     *
     * @since 1.0.0
     */
    public function __construct() {

        // Adds the testimonials post type.
        add_action( 'init', array( __CLASS__, 'register' ) );
        add_action( 'init', array( __CLASS__, 'register_taxonomy' ) );

        add_action( 'post.php',          array( $this, 'add_post_formats_support' ) );
        add_action( 'load-post.php', array( $this, 'add_post_formats_support' ) );
        add_action( 'load-post-new.php', array( $this, 'add_post_formats_support' ) );

        // Removes rewrite rules and then recreate rewrite rules.
        // add_action( 'init', array( $this, 'rewrite_rules' ) );

    }

    public function rewrite_rules() {
        flush_rewrite_rules();
    }

    /**
     * Register the custom post type.
     *
     * @since 1.0.0
     * @link http://codex.wordpress.org/Function_Reference/register_post_type
     */
    public static function register() {

        $labels = array(
            'name'               => __( 'Quote', 'wp-plugin-quote' ),
            'singular_name'      => __( 'Quote list', 'wp-plugin-quote' ),
            'add_new'            => __( 'Add Item', 'wp-plugin-quote' ),
            'add_new_item'       => __( 'Add Quote Item', 'wp-plugin-quote' ),
            'edit_item'          => __( 'Edit Quote Item', 'wp-plugin-quote' ),
            'new_item'           => __( 'New Quote Item', 'wp-plugin-quote' ),
            'view_item'          => __( 'View Quote Item', 'wp-plugin-quote' ),
            'search_items'       => __( 'Search Quote Items', 'wp-plugin-quote' ),
            'not_found'          => __( 'No Quote Items found', 'wp-plugin-quote' ),
            'not_found_in_trash' => __( 'No Quote Items found in trash', 'wp-plugin-quote' ),
        );

        $supports = array(
            'title',
            'editor',
            'thumbnail',
            'revisions',
            'page-attributes',
            'post-formats',
        );

        $args = array(
            'labels'          => $labels,
            'supports'        => $supports,
            'public'          => true,
            'capability_type' => 'post',
            'rewrite'         => array( 'slug' => 'wp-plugin-quote', ), // Permalinks format
            'menu_position'   => null,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'       => ( version_compare( $GLOBALS['wp_version'], '3.8', '>=' ) ) ? 'dashicons-welcome-view-site' : '',
            'can_export'      => true,
            'has_archive'     => true,
            'taxonomies'      => array( 'post_format' )
        );


        $args = apply_filters( 'wp_plugin_quote_post_type_args', $args );

        register_post_type( "quote", $args );
    }

    /**
     * Post formats.
     *
     * @since 1.0.0
     * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
     */
    public function add_post_formats_support() {
        global $typenow;

        if ( "quote" != $typenow ) {
            return;
        }

        $args = apply_filters( 'wp_plugin_quote_add_post_formats_support', array( 'image', 'gallery', 'audio', 'video', ) );

        add_post_type_support( "quote", 'post-formats', $args );
        add_theme_support( 'post-formats', $args );
    }

    /**
     * Register the custom taxonomy.
     *
     * @since 1.0.0
     * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
     */
    public static function register_taxonomy() {
        // Register the category taxonomy
        $category_taxonomy_labels = array(
            'label'				=> __( 'Authors', 'quote-author' ),
            'singular_name'		=> __( 'Author', 'quote-author' ),
            'menu_name'			=> __( 'All Authors', 'quote-author' ),
            'add_new_item'		=> __( 'Add New Author', 'quote-author' ),
            'all_items'			=> __( 'All Authors', 'quote-author' ),
            'name'				=> __( 'Authors', 'quote-author' ),
            'update_item'		=> __( 'Update Author', 'quote-author' ),
            'new_item_name'		=> __( 'New Author Name', 'quote-author' ),
            'search_items'		=> __( 'Search Authors', 'quote-author' ),
            'parent_item'		=> __( 'Parent Author', 'quote-author' ),
            'parent_item_colon' => __( 'Parent Author:', 'quote-author' ),
            'edit_item'			=> __( 'Edit Author:', 'quote-author' ),
        );

        $category_taxonomy_args = array(
            'labels'		=> $category_taxonomy_labels,
            'hierarchical'	=> true,
            'rewrite'		=> true,
            'query_var'		=> true,
        );

        register_taxonomy( 'quote-author', "quote", $category_taxonomy_args );
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

WP_Plugin_Quote_Registration::get_instance();