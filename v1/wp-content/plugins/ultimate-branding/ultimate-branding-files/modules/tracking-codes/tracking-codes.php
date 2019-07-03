<?php
if ( ! class_exists( 'ub_tracking_codes' ) ) {

	class ub_tracking_codes extends ub_helper {

		protected $option_name = 'ub_tracking_codes';

		public function __construct() {
			parent::__construct();
			$this->set_options();
			/**
			 * handle
			 */
			add_action( 'ultimatebranding_settings_tracking_codes', array( $this, 'admin_options_page' ) );
			add_filter( 'ultimatebranding_settings_tracking_codes_process', array( $this, 'update' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'tracking-codes_after_title', array( $this, 'add_button' ) );
			if ( $this->module === $this->tab ) {
				add_filter( 'ultimatebranding_update_branding_page', '__return_false' );
			}
			add_action( 'wp_ajax_ub_tracking_codes_search_site', array( $this, 'ajax_search_sites' ) );
			/**
			 * frontend
			 */
			add_action( 'loop_start', array( $this, 'target_begin_of_body' ), 0 );
			add_action( 'wp_footer', array( $this, 'target_footer' ), PHP_INT_MAX );
			add_action( 'wp_head', array( $this, 'target_head' ), PHP_INT_MAX );
		}

		/**
		 * Handle AJAX search
		 *
		 * @since 2.3.0
		 */
		public function ajax_search_sites() {
			$nonce = filter_input( INPUT_GET, '_wpnonce', FILTER_SANITIZE_STRING );
			if ( ! wp_verify_nonce( $nonce, 'ub_tracking_codes_search_site' ) ) {
				return array();
			}
			$q = filter_input( INPUT_GET, 'q', FILTER_SANITIZE_STRING );
			if ( empty( $q ) ) {
				return array();
			}
			$data = $this->get_value();
			$args = array(
				'search' => $q,
			);
			$results = $this->get_sites_by_args( $args );
			wp_send_json_success( $results );
		}

		/**
		 * Use get_sites() helper.
		 *
		 * @since 2.3.0
		 */
		private function get_sites_by_args( $args, $mode = 'search' ) {
			$results = array();
			if ( ! function_exists( 'get_sites' ) ) {
				return $results;
			}
			$args['orderby'] = 'domain';
			$sites = get_sites( $args );
			foreach ( $sites as $site ) {
				$details = get_blog_details( $site->blog_id );
				if ( 'search' === $mode ) {
					$results[] = array(
					'id' => $site->blog_id,
					'title' => $site->blogname,
					'subtitle' => $site->siteurl,
					);
				} else {
					$results[ $site->blog_id ] = $site->blogname;
				}
			}
			return $results;
		}

		/**
		 * Get data by target
		 *
		 * @since 2.3.0
		 *
		 * @param string $target Target for tracking code.
		 */
		private function get_data( $target ) {
			$results = array();
			$data = $this->get_value();
			if ( empty( $data ) ) {
				return;
			}
			foreach ( $data as $one ) {
				/**
				 * ignore inactive
				 */
				if ( ! isset( $one['tracking_active'] ) || 'on' !== $one['tracking_active'] ) {
					continue;
				}
				/**
				 * ignore not HEAD section
				 */
				if ( ! isset( $one['tracking_place'] ) || $target !== $one['tracking_place'] ) {
					continue;
				}
				/**
				 * ignore empty
				 */
				if ( ! isset( $one['tracking_code'] ) || empty( $one['tracking_code'] ) ) {
					continue;
				}
				/**
				 * check filters
				 */
				$show = $this->check_filters( $one );
				if ( false === $show ) {
					continue;
				}
				/**
				 * YES! Show it.
				 */
				$results[] = $one;
			}
			/**
			 * print it!
			 */
			foreach ( $results as $one ) {
				$this->debug( $one['tracking_id'], __CLASS__ );
				echo stripslashes( $one['tracking_code'] );
				$this->debug( $one['tracking_id'], __CLASS__, false );
			}
			return $results;
		}

		/**
		 * Get data for head
		 *
		 * @since 2.3.0
		 */
		public function target_head() {
			$this->get_data( 'head' );
		}

		/**
		 * Get data for body
		 *
		 * @since 2.3.0
		 */
		public function target_begin_of_body() {
			$this->get_data( 'body' );
		}

		/**
		 * Get data for footer
		 *
		 * @since 2.3.0
		 */
		public function target_footer() {
			$this->get_data( 'footer' );
		}

		/**
		 * Get current actio
		 *
		 * @since 2.3.0
		 *
		 * @return string $action Current action.
		 */
		private function get_action() {
			$action = filter_input( INPUT_GET, 'ub_tc_action', FILTER_SANITIZE_STRING );
			if ( empty( $action ) ) {
				$action = filter_input( INPUT_POST, 'ub_tc_action', FILTER_SANITIZE_STRING );
			} elseif ( 'edit' === $action ) {
				if (
					isset( $_POST['simple_options'] )
					&& isset( $_POST['simple_options']['tracking'] )
					&& isset( $_POST['simple_options']['tracking']['ub_tc_action'] )
					&& 'save' === $_POST['simple_options']['tracking']['ub_tc_action']
				) {
					$action = 'save';
				}
			}
			return $action;
		}

		/**
		 * Set options
		 *
		 * @since 2.3.0
		 */
		protected function set_options() {
			$this->module = 'tracking-codes';
		}

		/**
		 * Update tracking code.
		 *
		 * @since 2.3.0
		 *
		 * @param boolean $status
		 */
		public function update( $status ) {
			return true;
		}

		/**
		 * Update by status.
		 *
		 * @since 2.3.0
		 */
		public function update_by_status() {
			$id = filter_input( INPUT_GET, 'id', FILTER_SANITIZE_STRING );
			if ( empty( $id ) ) {
				$message = __( 'Missing or wrong Tracking Code ID.', 'ub' );
				$this->notice( $message, 'error', true );
				return;
			}
			$action = $this->get_action();
			$nonce = filter_input( INPUT_GET, '_wpnonce', FILTER_SANITIZE_STRING );
			$nonce_name = $this->get_nonce_name( $id, $action );
			if ( ! wp_verify_nonce( $nonce, $nonce_name ) ) {
				$message = __( 'Security check fails.', 'ub' );
				$this->notice( $message, 'error', true );
				return;
			}
			$message = '';
			$data = $this->get_value();
			if ( ! isset( $data[ $id ] ) ) {
				$message = __( 'Missing or wrong Tracking Code ID.', 'ub' );
				$this->notice( $message, 'error', true );
				return;
			}
			switch ( $action ) {
				case 'activate':
					$data[ $id ]['tracking_active'] = 'on';
					$message = sprintf(
						esc_html__( 'Tracking Code %s was activated.', 'ub' ),
						$this->bold( $data[ $id ]['tracking_title'] )
					);
				break;
				case 'deactivate':
					$data[ $id ]['tracking_active'] = 'off';
					$message = sprintf(
						esc_html__( 'Tracking Code %s was deactivated.', 'ub' ),
						$this->bold( $data[ $id ]['tracking_title'] )
					);
				break;
				case 'delete':
					$message = sprintf(
						esc_html__( 'Tracking Code %s was deleted.', 'ub' ),
						$this->bold( $data[ $id ]['tracking_title'] )
					);
					unset( $data[ $id ] );
				break;
				case 'duplicate':
					if ( isset( $data[ $id ] ) ) {
						$one = $data[ $id ];
						$one['tracking_title'] .= esc_html__( ' (copy)', 'ub' );
						$one['tracking_active'] = 'off';
						$new_id = md5( serialize( $one ) . time() );
						$one['tracking_id'] = $new_id;
						$data[ $new_id ] = $one;
						$message = sprintf(
							esc_html__( 'Tracking Code %s was duplicated. New code %s is inactive.', 'ub' ),
							$this->bold( $data[ $id ]['tracking_title'] ),
							$this->bold( $data[ $new_id ]['tracking_title'] )
						);
					}
				break;
			}
			$this->update_value( $data );
			if ( ! empty( $message ) ) {
				$this->notice( $message, 'success', true );
			}
		}

		/**
		 * Handle admin page for "Tracking Codes" module.
		 *
		 * @since 2.3.0
		 */
		public function admin_options_page() {
			$action = $this->get_action();
			switch ( $action ) {
				case 'edit':
					$this->edit();
				break;
				case 'new':
					if ( empty( $_POST ) ) {
						$this->form_add();
					} else {
						$this->save();
					}
				break;
				case 'save':
					$this->save();
					break;
				case 'duplicate':
				case 'delete':
				case 'activate':
				case 'deactivate':
					$this->update_by_status();
				default:
					$this->get_list();
			}
		}

		/**
		 * Save tracking code data.
		 *
		 * @since 2.3.0
		 */
		private function save() {
			$options = $this->get_options_for_single();
			$input = array();
			if ( isset( $_POST['simple_options'] ) ) {
				$input = $_POST['simple_options'];
			};
			$data = array();
			foreach ( $options as $section_key => $section_data ) {
				foreach ( $section_data['fields'] as $key => $field ) {
					$value = isset( $input[ $section_key ][ $key ] ) ? $input[ $section_key ][ $key ]:'';
					if ( isset( $field['type'] ) && 'checkbox' === $field['type'] ) {
						$value = $value? 'on':'off';
					}
					if ( 'code' !== $key && ! is_array( $value ) ) {
						$value = filter_var( $value, FILTER_SANITIZE_STRING );
					}
					$data[ $section_key.'_'.$key ] = $value;
				}
			}
			$saved = $this->get_value();
			$message = esc_html__( 'Tracking Code %s was updated.', 'ub' );
			if ( empty( $data['tracking_id'] ) ) {
				$message = esc_html__( 'Tracking Code %s was created.', 'ub' );
				$data['tracking_id'] = md5( serialize( $data ) . time() );
			}
			$saved[ $data['tracking_id'] ] = $data;
			$this->update_value( $saved );
			$action = $this->get_action();
			$message = sprintf( $message, $this->bold( $data['tracking_title'] ) );
			$this->notice( $message, 'success', true );
			$this->edit( $data['tracking_id'] );
		}

		/**
		 * Show edit form.
		 *
		 * @since 2.3.0
		 */
		private function form_edit( $data ) {
			$options = $this->get_options_for_single();
			$data['ub_tc_action'] = 'save';
			$simple_options = new simple_options();
			echo $simple_options->build_options( $options, $data, $this->module );
		}

		/**
		 * Helper for edit for for new elements.
		 *
		 * @since 2.3.0
		 */
		private function form_add() {
			$data = array(
				'tracking' => array(
					'ub_tc_action' => 'save',
					'id' => 0,
					'title' => '',
				),
			);
			$this->form_edit( $data );
		}

		/**
		 * Helper for edit for alredy existing elements.
		 *
		 * @since 2.3.0
		 */
		private function edit( $id = false ) {
			if ( empty( $id ) ) {
				$id = filter_input( INPUT_GET, 'id', FILTER_SANITIZE_STRING );
			}
			if ( empty( $id ) ) {
				add_filter( 'ultimatebranding_settings_panel_show_submit', '__return_false' );
				$message = __( 'Missing or wrong Tracking Code ID.', 'ub' );
				$this->notice( $message, 'error', true );
				return;
			}
			$data = $this->get_value();
			if ( ! isset( $data[ $id ] ) ) {
				add_filter( 'ultimatebranding_settings_panel_show_submit', '__return_false' );
				$message = __( 'You attempted to edit an item that doesn’t exist. Perhaps it was deleted?', 'ub' );
				$this->notice( $message, 'error', true );
				return;
			}
			$edit = array();
			foreach ( $data[ $id ] as $key => $value ) {
				$keys = explode( '_', $key );
				$section_key = array_shift( $keys );
				$key = implode( '_', $keys );
				if ( ! isset( $edit[ $section_key ] ) ) {
					$edit[ $section_key ] = array();
				}
				$edit[ $section_key ][ $key ] = $value;
			}
			$this->form_edit( $edit );
		}

		/**
		 * Get list of trackin codes.
		 *
		 * @since 2.3.0
		 */
		private function get_list() {
			add_filter( 'ultimatebranding_settings_panel_show_submit', '__return_false' );
			include_once dirname( __FILE__ ) . '/tracking-codes-list-table.php';
			$list = new ub_tracking_codes_list_table( $this );
			//Fetch, prepare, sort, and filter our data...
			$list->prepare_items();
			$this->uba->show_messages();
			$list->views();
			$list->display();
		}

		/**
		 * Set ioptions for tracking code.
		 *
		 * @since 2.3.0
		 */
		public function get_options_for_single() {
			global $wp_roles, $UB_network;
			$options = array(
				'tracking' => array(
					'title' => __( 'Tracking Code', 'ub' ),
					'fields' => array(
						'id' => array( 'type' => 'hidden' ),
						'ub_tc_action' => array( 'type' => 'hidden' ),
						'title' => array(
							'label' => __( 'Name', 'ub' ),
						),
						'active' => array(
							'type' => 'checkbox',
							'label' => __( 'Active', 'ub' ),
							'options' => array(
								'on' => __( 'On', 'ub' ),
								'off' => __( 'Off', 'ub' ),
							),
							'default' => 'off',
							'classes' => array( 'switch-button' ),
							'slave-class' => 'tracking-active-related',
						),
						'code' => array(
							'type' => 'html_editor',
							'label' => __( 'Tracking Code', 'ub' ),
							'master' => 'tracking-active-related',
						),
						'place' => array(
							'type' => 'radio',
							'label' => __( 'Position', 'ub' ),
							'options' => array(
								'head' => __( 'In the HEAD tag.', 'ub' ),
								'body' => __( 'In the BODY tag.', 'ub' ),
								'footer' => __( 'Before &lt;/BODY&gt; tag.', 'ub' ),
							),
							'default' => 'head',
							'master' => 'tracking-active-related',
						),
					),
					'hide-reset' => true,
				),
				'filters' => array(
					'title' => __( 'Filters', 'ub' ),
					'fields' => array(
						'active' => array(
							'type' => 'checkbox',
							'label' => __( 'Use Filters', 'ub' ),
							'options' => array(
								'on' => __( 'On', 'ub' ),
								'off' => __( 'Off', 'ub' ),
							),
							'default' => 'off',
							'classes' => array( 'switch-button' ),
							'slave-class' => 'filter-active-related',
						),
						'users' => array(
							'type' => 'select2',
							'label' => __( 'Users', 'ub' ),
							'options' => array(
								'logged' => __( 'Only logged users', 'ub' ),
								'anonymous' => __( 'Only non logged users', 'ub' ),
							),
							'master' => 'filter-active-related',
							'multiple' => true,
							'description' => esc_html__( 'You can choose logged status and/or user role.', 'ub' ),
						),
						'authors' => array(
							'type' => 'select2',
							'label' => __( 'Authors', 'ub' ),
							'options' => array(),
							'master' => 'filter-active-related',
							'multiple' => true,
							'description' => esc_html__( 'This filter will be used only on single entry.', 'ub' ),
						),
						'archives' => array(
							'type' => 'select2',
							'label' => __( 'Content Type', 'ub' ),
							'options' => $this->get_location_data(),
							'master' => 'filter-active-related',
							'multiple' => true,
						),
					),
					'master' => array(
						'section' => 'tracking',
						'field' => 'active',
						'value' => 'on',
					),
					'hide-reset' => true,
				),
			);
			/**
			 * Add users roles
			 */
			foreach ( $wp_roles->roles as $slug => $data ) {
				$options['filters']['fields']['users']['options'][ 'wp:role:'.$slug ] = $data['name'];
			}
			if ( $UB_network ) {
				$options['filters']['fields']['users']['options']['wp:role:super'] = __( 'Super Admin', 'ub' );
			}
			natcasesort( $options['filters']['fields']['users']['options'] );
			/**
			 * Add authors
			 */
			$args = array(
				'fields' => array( 'ID', 'display_name' ),
				'orderby' => 'display_name',
			);
			if ( $UB_network ) {
				$args['blog_id'] = 0;
			} else {
				$args['who'] = 'authors';
			}
			$users = get_users( $args );
			foreach ( $users as $user ) {
				$options['filters']['fields']['authors']['options'][ $user->ID ] = $user->display_name;
			}
			/**
			 * Add superadmins
			 */
			if ( $UB_network ) {
				$users = get_super_admins();
				foreach ( $users as $login ) {
					$user = get_user_by( 'login', $login );
					if ( is_a( $user, 'WP_User' ) ) {
						$options['filters']['fields']['authors']['options'][ $user->data->ID ] = $user->data->display_name;
					}
				}
				natcasesort( $options['filters']['fields']['authors']['options'] );
				/**
				 * add select sites
				 */
				$options['sites'] = array(
					'title' => __( 'Sites', 'ub' ),
					'description' => __( 'When you need use code on selected subsites.', 'ub' ),
					'fields' => array(
						'active' => array(
							'type' => 'checkbox',
							'label' => __( 'Where to show', 'ub' ),
							'options' => array(
								'on' => __( 'Selected', 'ub' ),
								'off' => __( 'All', 'ub' ),
							),
							'default' => 'off',
							'classes' => array( 'switch-button' ),
							'slave-class' => 'sites-active-related',
						),
						'sites' => array(
							'type' => 'select2-ajax',
							'label' => __( 'Sites', 'ub' ),
							'options' => $this->get_curent_sites(),
							'master' => 'sites-active-related',
							'multiple' => true,
							'description' => esc_html__( 'You can choose subsite to show.', 'ub' ),
							'data' => array(
								'user-id' => get_current_user_id(),
								'action' => 'ub_tracking_codes_search_site',
								'nonce' => wp_create_nonce( 'ub_tracking_codes_search_site' ),
							),
						),
					),
					'hide-reset' => true,
				);
			}
			/**
			 * return
			 */
			return $options;
		}

		private function get_curent_sites() {
			$id = filter_input( INPUT_GET, 'id', FILTER_SANITIZE_STRING );
			if ( empty( $id ) ) {
				return array();
			}
			$data = $this->get_value();
			if ( ! isset( $data[ $id ] ) ) {
				return array();
			}
			if ( ! isset( $data[ $id ]['sites_sites'] ) || empty( $data[ $id ]['sites_sites'] ) ) {
				return array();
			}
			$args = array(
				'site__in' => $data[ $id ]['sites_sites'],
			);
			return $this->get_sites_by_args( $args, 'assoc' );
		}

		/**
		 * enqueue_scripts
		 */
		public function enqueue_scripts() {
			if ( $this->module != $this->tab ) {
				return;
			}
			/**
			 * module js
			 */
			$file = ub_files_url( 'modules/tracking-codes/assets/tracking-codes.js' );
			wp_register_script( __CLASS__, $file, array( 'jquery' ), $this->build, true );
			$localize = array(
				'delete' => __( 'Delete selected tracking code?', 'ub' ),
				'bulk_delete' => __( 'Delete selected tracking codes?', 'ub' ),
			);
			wp_enqueue_script( __CLASS__ );
			wp_localize_script( __CLASS__, __CLASS__, $localize );
			/**
			 * module css
			 */
			$file = ub_files_url( 'modules/tracking-codes/assets/tracking-codes.css' );
			wp_enqueue_style( __CLASS__, $file );
		}

		/**
		 * Get nonce name.
		 *
		 * @since 2.3.0
		 *
		 * @return string nonce name
		 */
		public function get_nonce_name( $id, $action = 'edit' ) {
			return sprintf( 'ultimate_branding_%s_%d', $action, $id );
		}

		/**
		 * Check visibility by filter.
		 *
		 * @since 2.3.0
		 *
		 * @param array $data Configuration data of single tracking code.
		 * @return boolean show or hide value.
		 */
		private function check_filters( $data ) {
			$show = true;
			/**
			 * Handle only Main Query and leave the admin alone!
			 */
			if ( ! is_main_query() || is_admin() ) {
				return $show;
			}
			/**
			 * Subsite limit
			 */
			if ( isset( $data['sites_sites'] ) && is_array( $data['sites_sites'] ) ) {
				$blog_id = get_current_blog_id();
				$show = in_array( $blog_id, $data['sites_sites'] );
			}
			/**
			 * Filters are off or misconfigured
			 */
			if ( ! isset( $data['filters_active'] ) || 'on' !== $data['filters_active'] ) {
				return $show;
			}
			/**
			 * filter by user
			 */
			if ( $show && isset( $data['filters_users'] ) ) {
				$show = $this->filter_by_user( $data['filters_users'] );
			}
			/**
			 * filter by author
			 */
			if ( $show && isset( $data['filters_authors'] ) ) {
				$show = $this->filter_by_author( $data['filters_authors'] );
			}
			/**
			 * filter by archive
			 */
			if ( $show && isset( $data['filters_archives'] ) ) {
				$show = $this->filter_by_archive( $data['filters_archives'] );
			}
			/**
			 * By default return true
			 */
			return $show;
		}

		/**
		 * Check visibility by filter.
		 *
		 * @since 2.3.0
		 *
		 * @param array $data Configuration data of single tracking code.
		 * @return boolean show or hide value.
		 */
		private function filter_by_user( $filter ) {
			if ( ! is_array( $filter ) || empty( $filter ) ) {
				return true;
			}
			$logged = is_user_logged_in();
			if ( in_array( 'anonymous', $filter ) && ! $logged ) {
				return true;
			}
			if ( in_array( 'logged', $filter ) && $logged ) {
				return true;
			}
			$roles = array();
			foreach ( $filter as $one ) {
				if ( preg_match( '/^wp:role:(.+)$/', $one, $mataches ) ) {
					$roles[] = $mataches[1];
				}
			}
			if ( ! empty( $roles ) && ! $logged ) {
				return false;
			}
			$user = wp_get_current_user();
			foreach ( $roles as $role ) {
				if ( 'super' === $role ) {
					return is_super_admin();
				}
				if ( in_array( $role, $user->roles ) ) {
					return true;
				}
			}
			return false;
		}

		/**
		 * Check visibility by filter.
		 *
		 * @since 2.3.0
		 *
		 * @param array $data Configuration data of single tracking code.
		 * @return boolean show or hide value.
		 */
		private function filter_by_author( $filter ) {
			if ( ! is_array( $filter ) || empty( $filter ) ) {
				return true;
			}
			if ( ! is_singular() ) {
				return false;
			}
			global $post;
			return in_array( $post->post_author, $filter );
		}

		/**
		 * Check visibility by filter.
		 *
		 * @since 2.3.0
		 *
		 * @param array $data Configuration data of single tracking code.
		 * @return boolean show or hide value.
		 */
		private function filter_by_archive( $filter ) {
			if ( ! is_array( $filter ) || empty( $filter ) ) {
				return true;
			}
			/**
			 * 404
			 */
			if ( in_array( '404', $filter ) && is_404() ) {
				return true;
			}
			/**
			 * author archive
			 */
			if ( in_array( 'authors', $filter ) && is_author() ) {
				return true;
			}
			/**
			 * category archive
			 */
			if ( in_array( 'category', $filter ) && is_category() ) {
				return true;
			}
			/**
			 * tag archive
			 */
			if ( in_array( 'tags', $filter ) && is_tag() ) {
				return true;
			}
			/**
			 * The Home Page
			 */
			if ( in_array( 'home', $filter ) && is_front_page() && is_home() ) {
				return true;
			}
			/**
			 * The Front Page
			 */
			if ( in_array( 'front', $filter ) && is_front_page()  ) {
				return true;
			}
			/**
			 * The Blog Page
			 */
			if ( in_array( 'blog', $filter ) && is_home() ) {
				return true;
			}
			/**
			 * The Single Post Page
			 */
			if ( in_array( 'single', $filter ) && is_single() ) {
				return true;
			}
			/**
			 * The Sticky Post Page
			 */
			if ( in_array( 'sticky', $filter ) && is_single() && is_sticky() ) {
				return true;
			}
			/**
			 * The Page
			 */
			if ( in_array( 'page', $filter ) && is_page() ) {
				return true;
			}
			/**
			 * The archive
			 */
			if ( in_array( 'archive', $filter ) && is_archive() ) {
				return true;
			}
			/**
			 * The search
			 */
			if ( in_array( 'search', $filter ) && is_search() ) {
				return true;
			}
			/**
			 * The attachment
			 */
			if ( in_array( 'attachment', $filter ) && is_attachment() ) {
				return true;
			}
			/**
			 * The singular
			 */
			if ( in_array( 'singular', $filter ) && is_singular() ) {
				return true;
			}
			return false;
		}

		/**
		 * Populates the response object for the "get-location" ajax call.
		 * Location data defines where a custom sidebar is displayed, i.e. on which
		 * pages it is used and which theme-sidebars are replaced.
		 *
		 * @since  2.3.0
		 * @return array $archive_type Array of Archive types.
		 */
		private function get_location_data() {
			$archive_type = array(
				'attachment' => __( 'Any Attachment Page', 'ub' ),
				'archive' => __( 'Any Archive Page', 'ub' ),
				'sticky' => __( 'Sticky Post', 'ub' ),
				'singular' => __( 'Any Entry Page', 'ub' ),
				'page' => __( 'Single Page', 'ub' ),
				'single' => __( 'Single Post', 'ub' ),
				'front' => __( 'Front Page', 'ub' ),
				'home' => __( 'Home Page', 'ub' ),
				'blog' => __( 'Blog Page', 'ub' ),
				'search' => __( 'Search Results', 'ub' ),
				// '404' => __( 'Not Found (404)', 'ub' ), currently we can not handle 404 page, because we use `loop_start` filter.
				'authors' => __( 'Any Author Archive', 'ub' ),
			);
			$all = get_taxonomies( array( 'public' => true, '_builtin' => true ), 'object' );
			foreach ( $all as $taxonomy ) {
				$default_taxonomies[] = $taxonomy->labels->singular_name;
				switch ( $taxonomy->name ) {
					case 'post_format':
					break;
					case 'post_tag':
						/**
					 * this a legacy and backward compatibility
					 */
						$archive_type['tags'] = sprintf( __( '%s Archives', 'ub' ), $taxonomy->labels->singular_name );
					break;
					case 'category':
						$archive_type[ $taxonomy->name ] = sprintf( __( '%s Archives', 'ub' ), $taxonomy->labels->singular_name );
					break;
				}
			}
			/**
			 * sort array by values
			 */
			asort( $archive_type );
			return $archive_type;
		}

		/**
		 * Add "Add New" button after title.
		 *
		 * @since 2.3.0
		 */
		public function add_button() {
			printf(
				'<a href="%s" class="page-title-action">%s</a>',
				add_query_arg( 'ub_tc_action', 'new' ),
				esc_html__( 'Add New', 'ub' )
			);
		}

		/**
		 * Allow to get value from provate/protection function.
		 *
		 * @since 2.3.0
		 */
		public function local_get_value() {
			$codes = $this->get_value();
			if ( empty( $codes ) ) {
				return array();
			}
			return $codes;
		}

		/**
		 * Allow to update value from provate/protection function.
		 *
		 * @since 2.3.0
		 */
		public function local_update_value( $value ) {
			return $this->update_value( $value );
		}
	}
}
new ub_tracking_codes;