<?php
if ( ! class_exists( 'ub_admin_panel_tips' ) ) {
	class ub_admin_panel_tips extends ub_helper {

		private $admin_url = '';
		private $post_type = 'admin_panel_tip';
		private $meta_field_name = '_ub_page';
		private $meta_field_name_till = '_ub_till';
		protected $tab_name = 'admin-panel-tips';

		public function __construct() {
			$this->admin_url = $this->get_admin_url();
			add_action( 'save_post', array( $this, 'save_post' ), 10, 3 );
			add_action( 'save_post', array( $this, 'save_post_till' ), 10, 3 );
			add_action( 'admin_notices', array( $this, 'output' ) );
			add_action( 'profile_personal_options', array( $this, 'profile_option_output' ) );
			add_action( 'personal_options_update', array( $this, 'profile_option_update' ) );
			add_action( 'wp_ajax_ub_admin_panel_tips', array( $this, 'ajax' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'ultimatebranding_settings_admin_panel_tips', array( $this, 'admin_options_page' ) );
			add_filter( 'ultimate_branding_module_url', array( $this, 'change_tab_url' ), 10, 2 );
			add_action( 'init', array( $this, 'custom_post_type' ), 100 );
			/**
			 * Where to display?
			 *
			 * @since 1.8.8
			 */
			add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		}

		protected function set_options() {
			$description = '<ul>';
			$description .= sprintf( '<li>%s</li>', __( 'Please go to site admin and add some tips.', 'ub' ) );
			$description .= sprintf( '<li>%s</li>', __( 'This module has no global configuration.', 'ub' ) );
			$description .= '</ul>';
			$this->options = array(
				'description' => array(
					'title' => __( 'Description', 'ub' ),
					'description' => $description,
				),
			);
		}

		public function custom_post_type() {
			if ( ! is_admin() ) {
				return;
			}
			/**
			 * Do not load on multisite network admin
			 */
			if ( is_multisite() && is_network_admin() ) {
				return;
			}
			/**
			 * Check module is active - it happens on bulk change status
			 */
			if ( false === ub_is_active_module( 'admin-panel-tips/admin-panel-tips.php' ) ) {
				return;
			}
			$labels = array(
				'name'                  => _x( 'Tips', 'Tip General Name', 'ub' ),
				'singular_name'         => _x( 'Tip', 'Tip Singular Name', 'ub' ),
				'menu_name'             => __( 'Tips', 'ub' ),
				'name_admin_bar'        => __( 'Tip', 'ub' ),
				'archives'              => __( 'Tip Archives', 'ub' ),
				'attributes'            => __( 'Tip Attributes', 'ub' ),
				'parent_item_colon'     => __( 'Parent Tip:', 'ub' ),
				'all_items'             => __( 'Tips', 'ub' ),
				'add_new_item'          => __( 'Add New Tip', 'ub' ),
				'add_new'               => __( 'Add New', 'ub' ),
				'new_item'              => __( 'New Tip', 'ub' ),
				'edit_item'             => __( 'Edit Tip', 'ub' ),
				'update_item'           => __( 'Update Tip', 'ub' ),
				'view_item'             => __( 'View Tip', 'ub' ),
				'view_items'            => __( 'View Tips', 'ub' ),
				'search_items'          => __( 'Search Tip', 'ub' ),
				'not_found'             => __( 'Not found', 'ub' ),
				'not_found_in_trash'    => __( 'Not found in Trash', 'ub' ),
				'featured_image'        => __( 'Featured Image', 'ub' ),
				'set_featured_image'    => __( 'Set featured image', 'ub' ),
				'remove_featured_image' => __( 'Remove featured image', 'ub' ),
				'use_featured_image'    => __( 'Use as featured image', 'ub' ),
				'insert_into_item'      => __( 'Insert into item', 'ub' ),
				'uploaded_to_this_item' => __( 'Uploaded to this item', 'ub' ),
				'items_list'            => __( 'Tips list', 'ub' ),
				'items_list_navigation' => __( 'Tips list navigation', 'ub' ),
				'filter_items_list'     => __( 'Filter items list', 'ub' ),
			);
			$args = array(
				'label'                 => __( 'Admin Panel Tips', 'ub' ),
				'description'           => __( 'Tip Description', 'ub' ),
				'labels'                => $labels,
				'supports'              => array( 'title', 'editor' ),
				'hierarchical'          => false,
				'public'                => false,
				'show_ui'               => true,
				'show_in_menu'          => 'branding',
				'show_in_admin_bar'     => false,
				'can_export'            => true,
				'has_archive'           => false,
				'exclude_from_search'   => false,
				'publicly_queryable'    => false,
			);
			register_post_type( $this->post_type, $args );
		}

		public function ajax() {
			$keys = array( 'what', 'nonce', 'id', 'user_id' );
			foreach ( $keys as $key ) {
				if ( ! isset( $_POST[ $key ] ) ) {
					wp_send_json_error();
				}
			}
			$nonce_action = $this->get_nonce_action( $_POST['what'], $_POST['id'], $_POST['user_id'] );
			if ( wp_verify_nonce( $_POST['nonce'], $nonce_action ) ) {
				switch ( $_POST['what'] ) {
					case 'hide':
						update_user_meta( $_POST['user_id'], 'show_tips', 'no' );
						wp_send_json_success();
					case 'dismiss':
						$dismissed_tips = get_user_meta( $_POST['user_id'], 'tips_dismissed', true, array() );
						$dismissed_tips[] = $_POST['id'];
						update_user_meta( $_POST['user_id'], 'tips_dismissed', $dismissed_tips );
						wp_send_json_success();
				}
			}
			wp_send_json_error();
		}

		public function enqueue_scripts() {
			global $ub_version;
			wp_enqueue_style( __CLASS__, plugins_url( 'admin-panel-tips.css', __FILE__ ), array(), $ub_version );
			wp_enqueue_script( __CLASS__, plugins_url( 'admin-panel-tips.js', __FILE__ ), array( 'jquery' ), $ub_version, true );
			$data = array(
				'saving' => __( 'Saving...', 'ub' ),
			);
			wp_localize_script( __CLASS__, __CLASS__, $data );
		}

		public function profile_option_update() {
			global $user_id;
			if ( $_POST['show_tips'] != '' ) {
				update_user_meta( $user_id, 'show_tips', $_POST['show_tips'] );
			}
		}

		public function output() {
			/**
			 * avoid activate/deactivate actions
			 */
			if ( isset( $_GET['updated'] ) || isset( $_GET['activated'] ) ) {
				return;
			}
			/**
			 * do not show tips on Ultimate Branding pages.
			 */
			$screen = get_current_screen();
			if ( 'branding' == $screen->parent_base ) {
				return;
			}
			global $wpdb, $current_site, $current_user;
			//hide if turned off
			$show_tips = get_user_meta( $current_user->ID,'show_tips', true );
			if ( 'no' == $show_tips ) {
				return;
			}
			$current_screen = get_current_screen();
			$meta_query = array(
				'relation' => 'AND',
				array(
					'relation' => 'OR',
					array(
						'key' => $this->meta_field_name,
						'value' => 'everywhere',
					),
					array(
						'key' => $this->meta_field_name,
						'value' => $current_screen->parent_file,
					),
				),
				array(
					'relation' => 'OR',
					array(
						'key' => $this->meta_field_name_till,
						'compare' => 'NOT EXISTS',
					),
					array(
						'key' => $this->meta_field_name_till,
						'value' => time(),
						'compare' => '>',
						'type' => 'NUMERIC',
					),
				),
			);
			$args = array(
				'orderby' => 'rand',
				'posts_per_page' => 1,
				'post_type' => $this->post_type,
				'post_status' => 'publish',
				'meta_query' => $meta_query,
			);
			/**
			 * get closed tips list
			 */
			$post__not_in = get_user_meta( get_current_user_id(), 'tips_dismissed', true );
			if ( ! empty( $post__not_in ) ) {
				if ( ! is_array( $post__not_in ) ) {
					$post__not_in = array( $post__not_in );
				}
				$args['post__not_in'] = $post__not_in;
			}
			/**
			 * get tips
			 */
			$the_query = new WP_Query( $args );
			if ( $the_query->posts ) {
				$post = array_shift( $the_query->posts );
				if ( is_a( $post, 'WP_Post' ) ) {
					printf( '<div class="updated admin-panel-tips" data-id="%d" data-user-id="%d">', esc_attr( $post->ID ), esc_attr( get_current_user_id() ) );
					printf(
						'<p class="apt-action" data-what="dismiss" data-nonce="%s">[ <a href="#" >%s</a> ]</p>',
						esc_attr( wp_create_nonce( $this->get_nonce_action( 'dismiss', $post->ID ) ) ),
						esc_html__( 'Dismiss', 'ub' )
					);
					printf(
						'<p class="apt-action" data-what="hide" data-nonce="%s">[ <a href="#" >%s</a> ]</p>',
						esc_attr( wp_create_nonce( $this->get_nonce_action( 'hide', $post->ID ) ) ),
						esc_html__( 'Hide', 'ub' )
					);
					$title = $post->post_title;
					if ( ! empty( $title ) ) {
						printf( '<h4>%s</h4>', apply_filters( 'the_title', $title ) );
					}
					$content = $post->post_content;
					if ( ! empty( $content ) ) {
						printf( '<div class="apt-content">%s</div>', apply_filters( 'the_content', $content ) );
					}
					echo '</div>';
				}
				wp_reset_postdata();
			}
		}

		public function profile_option_output() {
			global $user_id;
			$show_tips = get_user_meta( $user_id,'show_tips', true );
?>
    <h3><?php _e( 'Tips', 'ub' ) ?></h3>
    <table class="form-table">
    <tr>
        <th><label for="show_tips"><?php _e( 'Show Tips', 'ub' ) ?></label></th>
        <td>
            <select name="show_tips" id="show_tips">
                <option value="yes" <?php if ( $show_tips == '' || $show_tips == 'yes' ) { echo 'selected="selected"'; } ?> ><?php _e( 'Yes', 'ub' ); ?></option>
                <option value="no" <?php if ( $show_tips == 'no' ) { echo 'selected="selected"'; } ?> ><?php _e( 'No', 'ub' ); ?></option>
            </select>
        </td>
    </tr>
    </table>
<?php
		}

		public function manage_output() {
			echo wpautop( __( 'Please go to site admin and add some tips.', 'ub' ) );
		}

		private function get_nonce_action( $what, $id, $user_id = false ) {
			if ( false == $user_id ) {
				$user_id = get_current_user_id();
			}
			$action = sprintf( '%s_%s_%d_%d', __CLASS__, $what, $id, $user_id );
			return $action;
		}

		/**
		 * save meta field
		 *
		 * @since 1.8.6
		 */
		public function save_post( $post_id, $post, $update ) {
			$post_type = get_post_type( $post_id );
			if ( $this->post_type != $post_type ) {
				return;
			}
			/**
			 * check nonce
			 */
			if ( ! isset( $_POST['where_to_display_nonce'] ) || ! wp_verify_nonce( $_POST['where_to_display_nonce'], '_where_to_display_nonce' ) ) {
				return;
			}
			/**
			 * get from edit form
			 */
			$values = array();
			if ( isset( $_POST[ $this->meta_field_name ] ) ) {
				$values = $_POST[ $this->meta_field_name ];
			}
			/**
			 * sanitize defaults
			 */
			if ( empty( $values ) ) {
				$values = array( 'everywhere' );
			}
			/**
			 * get current
			 */
			$current = get_post_meta( $post_id, $this->meta_field_name );
			/**
			 * remove not saved
			 */
			foreach ( $current as $v ) {
				if ( in_array( $v, $values ) ) {
					continue;
				}
				delete_post_meta( $post_id, $this->meta_field_name, $v );
			}
			/**
			 * save new
			 */
			foreach ( $values as $v ) {
				if ( in_array( $v, $current ) ) {
					continue;
				}
				add_post_meta( $post_id, $this->meta_field_name, $v );
			}
		}

		public function where_to_display__get_meta( $value ) {
			global $post;
			$field = get_post_meta( $post->ID, $value, true );
			if ( ! empty( $field ) ) {
				return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
			} else {
				return false;
			}
		}

		/**
		 * Where to display - add_meta_box
		 *
		 * @since 1.8.8
		 */
		public function add_meta_boxes() {
			add_meta_box(
				'where_to_display',
				__( 'Where to display?', 'ub' ),
				array( $this, 'html' ),
				'admin_panel_tip',
				'side',
				'default'
			);
			add_meta_box(
				'till',
				__( 'Display till', 'ub' ),
				array( $this, 'add_till' ),
				'admin_panel_tip',
				'side',
				'default'
			);
		}

		/**
		 * Where to display - html
		 *
		 * @since 1.8.8
		 */
		public function html( $post ) {
			global $menu;
			wp_nonce_field( '_where_to_display_nonce', 'where_to_display_nonce' );
			echo '<p>';
			_e( 'Allow to choose where this tip should be shown:', 'ub' );
			echo '</p>';
			$current = get_post_meta( $post->ID, $this->meta_field_name );
			$checked = in_array( 'everywhere', $current );
			echo '<ul>';
			printf(
				'<li><label><input type="checkbox" name="%s[]" value="everywhere" %s/> %s</label>',
				esc_attr( $this->meta_field_name ),
				checked( $checked, true, false ),
				esc_html__( 'Everywhere (except Branding)', 'ub' )
			);
			foreach ( $menu as $one ) {
				if ( empty( $one[0] ) ) {
					continue;
				}
				/**
				 * disalow on branding pages
				 */
				if ( 'branding' == $one[2] ) {
					continue;
				}
				$checked = in_array( $one[2], $current );
				printf(
					'<li><label><input type="checkbox" name="%s[]" value="%s" %s/> %s</label>',
					esc_attr( $this->meta_field_name ),
					esc_attr( $one[2] ),
					checked( $checked, true, false ),
					esc_html( preg_replace( '/<.+/', '', $one[0] ) )
				);
			}
			echo '</ul>';
		}

		/**
		 * Function return better tab url, handle filter.
		 *
		 * @since 1.9.3
		 *
		 * @param string $url Imput url.
		 * @param array $module Module deta.
		 *
		 * @return string URL.
		 */
		public function change_tab_url( $url, $module ) {
			if ( is_array( $module ) && isset( $module['module'] ) && 'admin-panel-tip' == $module['module'] ) {
				if ( is_multisite() ) {
					if ( ! is_network_admin() ) {
						$url = $this->get_admin_url();
					}
				} else {
					$url = $this->get_admin_url();
				}
			}
			return $url;
		}

		/**
		 * get admin url
		 *
		 * @since 1.9.3
		 *
		 * @return string Admin url for module.
		 */
		private function get_admin_url() {
			$admin_url = add_query_arg(
				array(
					'page' => 'branding',
					'tab' => $this->tab_name,
				),
				is_network_admin()? network_admin_url( 'admin.php' ): admin_url( 'admin.php' )
			);
			$link_to_post_type = false;
			if ( is_multisite() ) {
				if ( is_network_admin() ) {
					$link_to_post_type = true;
				}
			} else {
				$link_to_post_type = true;
			}
			if ( $link_to_post_type ) {
				$admin_url = add_query_arg(
					array(
						'post_type' => $this->post_type,
					),
					admin_url( 'edit.php' )
				);
			}
			return $admin_url;
		}

		/**
		 * Add till
		 *
		 * @since 2.3.0
		 */
		public function add_till( $post ) {
			global $menu;
			wp_nonce_field( '_till_date_nonce', 'till_date_nonce' );
			printf( '<p>%s</p>', esc_html__( 'Till date:', 'ub' ) );
			printf( '<p class="description">%s</p>', esc_html__( 'Leave empty to unlimited tip time.', 'ub' ) );
			$current = get_post_meta( $post->ID, $this->meta_field_name_till, true );
			if ( ! empty( $current ) ) {
				$current = date_i18n( get_option( 'date_format' ), $current );
			}
			$alt = sprintf( '%s_%s', $this->meta_field_name_till, md5( $current ) );
			printf(
				'<input type="text" class="datepicker" name="%s[human]" value="%s" data-alt="%s" data-min="%s" />',
				esc_attr( $this->meta_field_name_till ),
				esc_attr( $current ),
				esc_attr( $alt ),
				esc_attr( date( 'y-m-d', time() ) )
			);
			printf(
				'<input type="hidden" name="%s[alt]" value="%s" id="%s" />',
				esc_attr( $this->meta_field_name_till ),
				esc_attr( $current ),
				esc_attr( $alt )
			);
			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_localize_jquery_ui_datepicker();
			wp_enqueue_style( 'ub-jquery-ui', ub_url( 'assets/css/vendor/jquery-ui.min.css' ), array(), '1.12.1' );
		}

		/**
		 * save till meta field
		 *
		 * @since 2.3.0
		 */
		public function save_post_till( $post_id, $post, $update ) {
			$post_type = get_post_type( $post_id );
			if ( $this->post_type != $post_type ) {
				return;
			}
			/**
			 * check nonce
			 */
			if ( ! isset( $_POST['till_date_nonce'] ) || ! wp_verify_nonce( $_POST['till_date_nonce'], '_till_date_nonce' ) ) {
				return;
			}
			/**
			 * get from edit form
			 */
			$values = array();
			if ( isset( $_POST[ $this->meta_field_name_till ] ) ) {
				$values = $_POST[ $this->meta_field_name_till ];
			}
			delete_post_meta( $post_id, $this->meta_field_name_till );
			if ( isset( $values['human'] ) ) {
				if ( empty( $values['human'] ) ) {
					return;
				}
			} else {
				return;
			}
			if ( ! isset( $values['alt'] ) || empty( $values['alt'] ) ) {
				return;
			}
			$date = strtotime( sprintf( '%s 23:59:59', $values['alt'] ) );
			add_post_meta( $post_id, $this->meta_field_name_till, $date, true );
		}
	}
}

new ub_admin_panel_tips();