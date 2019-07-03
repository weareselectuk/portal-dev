<?php

if ( ! class_exists( 'ub_rebranded_meta_widget' ) ) {
	class ub_rebranded_meta_widget extends ub_helper {

		public function __construct() {
			add_action( 'widgets_init', array( $this, 'register' ) );
			add_action( 'ultimatebranding_settings_widgets', array( $this, 'admin_options_page' ) );
		}

		/**
		 * set options
		 *
		 * @since 2.1.0
		 */
		protected function set_options() {
			$content = '';
			$content .= __( 'There are no settings for this module. It simply added ability to setup site tagline during creation.', 'ub' );
			$content .= PHP_EOL.PHP_EOL;
			$content .= sprintf(
				'<img src="%s" alt="" />',
				esc_url( ub_files_url( 'modules/rebranded-meta-widget-files/images/exampleimage.png' ) )
			);
			$this->options = array(
				'ub_rebranded_meta_widget' => array(
					'title' => __( 'Rebranded Meta Widget', 'ub' ),
					'description' => $content,
				),
			);
		}

		public function register() {
			unregister_widget( 'WP_Widget_Meta' );
			register_widget( 'ub_WP_Widget_Rebranded_Meta' );
		}
	}
}
new ub_rebranded_meta_widget;

class ub_WP_Widget_Rebranded_Meta extends WP_Widget {

	public function __construct() {
		$widget_ops = array( 'classname' => 'widget_meta', 'description' => __( 'Log in/out, admin, feed and powered-by links', 'ub' ) );
		parent::__construct( 'meta', __( 'Meta', 'ub' ), $widget_ops );
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Meta', 'ub' ) : $instance['title'], $instance, $this->id_base );
		echo $before_widget;
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		if ( function_exists( 'get_blog_option' ) && function_exists( 'get_current_site' ) ) {
			$current_site = get_current_site();
			$blog_id = (isset( $current_site->blog_id )) ? $current_site->blog_id : UB_MAIN_BLOG_ID;
			$global_site_link = 'http://'. $current_site->domain . $current_site->path;
			$global_site_name = get_blog_option( $blog_id, 'blogname' );
		} else {
			$global_site_link = get_option( 'home' );
			$global_site_name = get_option( 'blogname' );
		}
?>
            <ul>
            <?php wp_register(); ?>
            <li><?php wp_loginout(); ?></li>
            <li><a href="<?php bloginfo( 'rss2_url' ); ?>" title="<?php echo esc_attr( __( 'Syndicate this site using RSS 2.0', 'ub' ) ); ?>"><?php _e( 'Entries <abbr title="Really Simple Syndication">RSS</abbr>', 'ub' ); ?></a></li>
            <li><a href="<?php bloginfo( 'comments_rss2_url' ); ?>" title="<?php echo esc_attr( __( 'The latest comments to all posts in RSS', 'ub' ) ); ?>"><?php _e( 'Comments <abbr title="Really Simple Syndication">RSS</abbr>', 'ub' ); ?></a></li>
            <li><a href="<?php echo $global_site_link; ?>" title="<?php echo esc_attr( sprintf( __( 'Powered by %s', 'ub' ), $global_site_name ) ); ?>"><?php echo esc_attr( $global_site_name ) ?></a></li>
            <?php wp_meta(); ?>
            </ul>
<?php
		echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		return $instance;
	}

	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = strip_tags( $instance['title'] );
?>
            <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
<?php
	}
}
