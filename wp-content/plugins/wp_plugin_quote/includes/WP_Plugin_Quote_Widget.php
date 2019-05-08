<?php


class WP_Plugin_Quote_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'wp_plugin_quote_widget',
            'Quote Widget',
            array('description' => 'Quote Widget')
        );

        if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
            //add_action('wp_enqueue_scripts', array( $this, 'add_my_widget_scripts' ));
            //add_action('wp_head', array( $this, 'add_my_widget_style' ) );
        }
    }

    function widget( $args, $instance ){

        $the_query = new WP_Query( array ('post_type'=> 'quote', 'orderby' => 'rand', 'posts_per_page' => '1' ) );
        while ( $the_query->have_posts() ) : $the_query->the_post();
            ?>
                <div>
                    <div>TITLE: <?php the_title();?></div>
                    <div>CONTENT: <?php the_content();?></div>
                    <div>AUTHOR: <?php the_taxonomies();?></div>
                </div>
            <?php
        endwhile;
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title']         = strip_tags( $new_instance['title'] );
        return $instance;
    }

    function form( $instance ) {
        $title       = esc_attr( $instance['title'] );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <?php
    }
}

/**
 * Registers a widget.
 *
 * @since 1.0.0
 */
function wp_plugin_quote_register_widget() {
    register_widget( 'WP_Plugin_Quote_Widget' );
}

add_action( 'widgets_init', 'wp_plugin_quote_register_widget' );
