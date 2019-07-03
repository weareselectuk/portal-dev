<?php
if ( ! class_exists( 'ub_author_box' ) ) {

	/**
	 * Author Box Widget
	 *
	 * @since 2.0.0
	 */
	include_once( dirname( __FILE__ ).'/class-author-box-widget.php' );

	class ub_author_box extends ub_helper {
		protected $option_name = 'ub_author_box';
		private $current_sites = array();

		/**
		 * Constructor
		 *
		 * @since 1.9.7
		 */
		public function __construct() {
			parent::__construct();
			$this->module = 'author-box';
			$this->set_options();
			/**
			 * Admin area
			 */
			add_action( 'ultimatebranding_settings_author_box', array( $this, 'admin_options_page' ) );
			add_filter( 'ultimatebranding_settings_author_box_process', array( $this, 'update' ), 10, 1 );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'widgets_init', array( $this, 'widgets' ) );
			/**
			 * Front end
			 */
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'wp_head', array( $this, 'print_css' ) );
			add_filter( 'the_content', array( $this, 'author_box' ) );
			add_filter( 'author_box', array( $this, 'widget' ) );
			/**
			 * user profile
			 */
			add_action( 'edit_user_profile_update', array( $this, 'save_user_profile' ) );
			add_action( 'edit_user_profile', array( $this, 'add_social_media' ) );
			add_action( 'personal_options_update', array( $this, 'save_user_profile' ) );
			add_action( 'show_user_profile', array( $this, 'add_social_media' ) );
			/**
			 * Social Media Settings
			 *
			 * @since 2.3.0
			 */
			add_filter( 'ub_get_options_social_media_settings', array( $this, 'social_media_settings' ), 10, 3 );
			add_filter( 'ub_get_options_social_media', array( $this, 'social_media' ), 10, 3 );
		}

		/**
		 * Add Settings to Social Media Settings section
		 *
		 * @since 2.3.0
		 */
		public function social_media_settings( $data, $defaults, $module ) {
			if ( $this->module !== $module ) {
				return $data;
			}
			$data['fields'] += array(
				'position' => array(
					'type' => 'radio',
					'label' => __( 'Icons Position', 'ub' ),
					'options' => array(
						'bottom' => __( 'Bottom of the box', 'ub' ),
						'top' => __( 'Top of the box', 'ub' ),
						'under-avatar' => __( 'Under avatar', 'ub' ),
					),
					'default' => 'bottom',
				),
				'background_color' => array(
					'type' => 'color',
					'label' => __( 'Background Color', 'ub' ),
					'default' => '#ddd',
					'master' => 'background',
				),
			);
			$data['master'] = array(
				'section' => 'show',
				'field' => 'social_media',
				'value' => 'on',
			);
			return $data;
		}

		/**
		 * Mofify Settings to Social Media section
		 *
		 * @since 2.3.0
		 */
		public function social_media( $data, $defaults, $module ) {
			if ( $this->module !== $module ) {
				return $data;
			}
			/**
			 * set type
			 */
			$set = array(
				'type' => 'checkbox',
				'options' => array(
					'on' => __( 'Allow', 'ub' ),
					'off' => __( 'Disallow', 'ub' ),
				),
				'default' => 'off',
				'default_hide' => true,
				'classes' => array( 'switch-button' ),
				'master' => 'social-media',
			);
			foreach ( $data['fields'] as $key => $v ) {
				$data['fields'][ $key ] += $set;
			}
			/**
			 * turn on few by default
			 */
			$data['fields']['facebook']['default'] = 'on';
			$data['fields']['twitter']['default'] = 'on';
			$data['fields']['google']['default'] = 'on';
			return $data;
		}

		/**
		 * Register Widgets
		 *
		 * @since 2.0.0
		 */
		public function widgets() {
			register_widget( 'Author_Box_Widget' );
		}

		/**
		 * Set options for module
		 *
		 * @since 1.9.7
		 */
		protected function set_options() {
			$post_types = array();
			$p = get_post_types( array( 'public' => true ), 'objects' );
			foreach ( $p as $key => $data ) {
				$post_types[ $key ] = $data->label;
			}
			$value = $this->get_value( 'show', 'display_name_link', 'on' );
			if ( 'off' === $value ) {
				$this->set_value( 'name_options', 'link', $value );
			}
			/**
			 * options
			 */
			$options = array(
				'show' => array(
					'title' => __( 'General configuration', 'ub' ),
					'fields' => array(
						'mode' => array(
							'type' => 'checkbox',
							'label' => __( 'Add box to content', 'ub' ),
							'options' => array(
								'on' => __( 'On', 'ub' ),
								'off' => __( 'Off', 'ub' ),
							),
							'default' => 'on',
							'classes' => array( 'switch-button' ),
							'description' => __( 'Turn it off if you want to use Author Box widget.', 'ub' ),
						),
						'post_type' => array(
							'type' => 'select2',
							'label' => __( 'Post Types', 'ub' ),
							'options' => $post_types,
							'multiple' => true,
							'classes' => array( 'ub-select2' ),
							'description' => __( 'Please select post types in which the author box will be displayed.', 'ub' ),
							'default' => array( 'post' ),
						),
						'display_name' => array(
							'type' => 'checkbox',
							'label' => __( 'Show name', 'ub' ),
							'options' => array(
								'on' => __( 'Show', 'ub' ),
								'off' => __( 'Hide', 'ub' ),
							),
							'default' => 'on',
							'classes' => array( 'switch-button' ),
						),
						'description' => array(
							'type' => 'checkbox',
							'label' => __( 'Show description', 'ub' ),
							'options' => array(
								'on' => __( 'Show', 'ub' ),
								'off' => __( 'Hide', 'ub' ),
							),
							'default' => 'on',
							'classes' => array( 'switch-button' ),
						),
						'avatar' => array(
							'type' => 'checkbox',
							'label' => __( 'Show avatar', 'ub' ),
							'options' => array(
								'on' => __( 'Show', 'ub' ),
								'off' => __( 'Hide', 'ub' ),
							),
							'default' => 'on',
							'classes' => array( 'switch-button' ),
							'slave-class' => 'avatar-related',
						),
						'social_media' => array(
							'type' => 'checkbox',
							'label' => __( 'Show social media profiles', 'ub' ),
							'description' => __( 'Author can add it on user profile page', 'ub' ),
							'options' => array(
								'on' => __( 'Show', 'ub' ),
								'off' => __( 'Hide', 'ub' ),
							),
							'default' => 'on',
							'classes' => array( 'switch-button' ),
							'slave-class' => 'social-media',
						),
						'entries' => array(
							'type' => 'checkbox',
							'label' => __( 'Show latest entries', 'ub' ),
							'description' => __( 'Add author latests entries', 'ub' ),
							'options' => array(
								'on' => __( 'Show', 'ub' ),
								'off' => __( 'Hide', 'ub' ),
							),
							'default' => 'off',
							'classes' => array( 'switch-button' ),
							'slave-class' => 'entries',
						),
					),
				),
				'box' => array(
					'title' => __( 'Box options', 'ub' ),
					'fields' => array(
						'border' => array(
							'type' => 'checkbox',
							'label' => __( 'Show border', 'ub' ),
							'options' => array(
								'on' => __( 'Show', 'ub' ),
								'off' => __( 'Hide', 'ub' ),
							),
							'default' => 'off',
							'classes' => array( 'switch-button' ),
							'slave-class' => 'border',
						),
						'border_width' => array(
							'type' => 'number',
							'label' => __( 'Border width', 'ub' ),
							'attributes' => array( 'placeholder' => '20' ),
							'default' => 1,
							'min' => 0,
							'classes' => array( 'ui-slider' ),
							'after' => __( 'px', 'ub' ),
							'master' => 'border',
						),
						'border_color' => array(
							'type' => 'color',
							'label' => __( 'Border color', 'ub' ),
							'default' => '#ddd',
							'master' => 'border',
						),
						'border_style' => array(
							'type' => 'radio',
							'label' => __( 'Border style', 'ub' ),
							'default' => 'solid',
							'master' => 'border',
							'options' => $this->css_border_options(),
						),
						'border_radius' => array(
							'type' => 'number',
							'label' => __( 'Radius corners', 'ub' ),
							'description' => __( 'How much would you like to round the border?', 'ub' ),
							'attributes' => array( 'placeholder' => '20' ),
							'default' => 0,
							'min' => 0,
							'classes' => array( 'ui-slider' ),
							'after' => __( 'px', 'ub' ),
							'master' => 'border',
						),
						'background_color' => array(
							'type' => 'color',
							'label' => __( 'Background Color', 'ub' ),
							'default' => 'transparent',
							'master' => 'background',
						),
					),
				),
				'name_options' => array(
					'title' => __( 'Display name options', 'ub' ),
					'fields' => array(
						'link' => array(
							'type' => 'checkbox',
							'label' => __( 'Link name', 'ub' ),
							'description' => __( 'Link author name to author archive.', 'ub' ),
							'options' => array(
								'on' => __( 'Link', 'ub' ),
								'off' => __( 'No', 'ub' ),
							),
							'default' => 'on',
							'classes' => array( 'switch-button' ),
						),
						'counter' => array(
							'type' => 'checkbox',
							'label' => __( 'Show number of posts', 'ub' ),
							'options' => array(
								'on' => __( 'Show', 'ub' ),
								'off' => __( 'Hide', 'ub' ),
							),
							'default' => 'off',
							'classes' => array( 'switch-button' ),
						),
					),
					'master' => array(
						'section' => 'show',
						'field' => 'display_name',
						'value' => 'on',
					),
				),
				'avatar' => array(
					'title' => __( 'Avatar options', 'ub' ),
					'fields' => array(
						'size' => array(
							'type' => 'number',
							'label' => __( 'Size', 'ub' ),
							'description' => __( 'How much would you like to round the border?', 'ub' ),
							'attributes' => array( 'placeholder' => '20' ),
							'default' => 96,
							'min' => 0,
							'max' => 200,
							'classes' => array( 'ui-slider' ),
							'after' => __( 'px', 'ub' ),
						),
						'rounded' => array(
							'type' => 'number',
							'label' => __( 'Radius corners', 'ub' ),
							'description' => __( 'How much would you like to round the border?', 'ub' ),
							'attributes' => array( 'placeholder' => '20' ),
							'default' => 0,
							'min' => 0,
							'classes' => array( 'ui-slider' ),
							'after' => __( 'px', 'ub' ),
						),
						'border' => array(
							'type' => 'number',
							'label' => __( 'Border width', 'ub' ),
							'attributes' => array( 'placeholder' => '20' ),
							'default' => 0,
							'min' => 0,
							'classes' => array( 'ui-slider' ),
							'after' => __( 'px', 'ub' ),
						),
						'border_color' => array(
							'type' => 'color',
							'label' => __( 'Border color', 'ub' ),
							'attributes' => array( 'placeholder' => '20' ),
							'default' => false,
						),
					),
					'master' => array(
						'section' => 'show',
						'field' => 'avatar',
						'value' => 'on',
					),
				),
				'entries_settings' => array(
					'title' => __( 'Entries Settings', 'ub' ),
					'fields' => array(
						'the_same_type' => array(
							'type' => 'checkbox',
							'label' => __( 'Show entries type', 'ub' ),
							'options' => array(
								'on' => __( 'Only the same', 'ub' ),
								'off' => __( 'Any', 'ub' ),
							),
							'default' => 'on',
							'classes' => array( 'switch-button' ),
						),
						'limit' => array(
							'type' => 'number',
							'label' => __( 'Number of entries', 'ub' ),
							'default' => 5,
							'min' => 1,
							'classes' => array( 'ui-slider' ),
						),
						'link_in_new_tab' => $this->get_options_link_in_new_tab( array( 'master' => 'entries' ) ),
						'title_show' => array(
							'type' => 'checkbox',
							'label' => __( 'Show Title', 'ub' ),
							'options' => array(
								'on' => __( 'Yes', 'ub' ),
								'off' => __( 'No', 'ub' ),
							),
							'default' => 'on',
							'classes' => array( 'switch-button' ),
							'slave-class' => 'title-show',
						),
						'title' => array(
							'label' => __( 'Title', 'ub' ),
							'default' => __( 'Read more the same author:', 'ub' ),
							'master' => 'title-show',
						),
					),
					'master' => array(
						'section' => 'show',
						'field' => 'entries',
						'value' => 'on',
					),
				),
				/**
				 * Common: Social Media Settings
				 */
				'social_media_settings' => $this->get_options_social_media_settings(),
				'social_media' => $this->get_options_social_media(),
			);
			/**
			 * return options/
			 */
			$this->options = $options;
		}

		/**
		 * Enqueue needed scripts.
		 *
		 * @since 1.9.7
		 */
		public function enqueue_scripts() {
			/**
			 * load on admin
			 */
			if ( is_admin() ) {
				$screen = get_current_screen();
				$this->load_social_logos_css();
				return;
			}
			/**
			 * Load on frontend
			 */
			$is_allowed_post_type = $this->check_post_type();
			if ( $is_allowed_post_type ) {
				$this->load_social_logos_css();
				$url = ub_files_url( 'modules/author-box/author-box.css' );
				wp_enqueue_style( __CLASS__, $url, array(), $this->build, 'screen' );
			}
		}

		/**
		 * Add social media links to author box.
		 *
		 * @since 1.9.7
		 */
		public function add_social_media( $profileuser ) {
			$data = $this->get_value( 'social_media' );
			$show = isset( $data ) && is_array( $data ) && ! empty( $data );
			if ( ! $show ) {
				return;
			}
			$content = '';
			$options = $this->options['social_media']['fields'];
			$order = $this->get_value( '_social_media_sortable' );
			$value = get_user_meta( $profileuser->ID, 'ub_author_box', true );
			foreach ( $order as $key ) {
				if ( ! isset( $data[ $key ] ) ) {
					continue;
				}
				if ( empty( $data[ $key ] ) || 'off' === $data[ $key ] ) {
					continue;
				}
				if ( preg_match( '/^(mail|wp-profile-)/', $key ) ) {
					continue;
				}
				$content .= sprintf( '<tr class="user-author-box user-author-box-%s">', esc_attr( $key ) );
				$content .= sprintf( '<th><label for="user-author-box-%s">%s</label></th>', esc_attr( $key ), esc_html( $options[ $key ]['label'] ) );
				$content .= sprintf(
					'<td><input type="text" id="user-author-box-%s" class="regular-text" value="%s" name="ub_author_box[%s]" /></td>',
					esc_attr( $key ),
					esc_attr( isset( $value[ $key ] )? $value[ $key ]:'' ),
					esc_attr( $key )
				);
				$content .= '</tr>';
				unset( $data[ $key ] );
			}
			foreach ( $data as $key => $value ) {
				if ( ! isset( $data[ $key ] ) ) {
					continue;
				}
				if ( empty( $data[ $key ] ) || 'off' === $data[ $key ] ) {
					continue;
				}
				if ( preg_match( '/^(mail|wp-profile-)/', $key ) ) {
					continue;
				}
				$content .= sprintf( '<tr class="user-author-box user-author-box-%s">', esc_attr( $key ) );
				$content .= sprintf( '<th><label for="user-author-box-%s">%s</label></th>', esc_attr( $key ), esc_html( $options[ $key ]['label'] ) );
				$content .= sprintf(
					'<td><input type="text" id="user-author-box-%s" class="regular-text" value="%s" name="ub_author_box[%s]" /></td>',
					esc_attr( $key ),
					esc_attr( isset( $value[ $key ] )? $value[ $key ]:'' ),
					esc_attr( $key )
				);
				$content .= '</tr>';
				unset( $data[ $key ] );
			}
			if ( empty( $content ) ) {
				return;
			}
			printf( '<h2>%s</h2>', esc_html__( 'Social Media profiles', 'ub' ) );
			echo '<table class="form-table"><tbody>';
			echo $content;
			echo '</tbody></table>';
		}

		/**
		 * Save user profile
		 *
		 * @since 1.9.7
		 */
		public function save_user_profile( $user_id ) {
			if ( current_user_can( 'edit_user', $user_id ) && isset( $_POST['ub_author_box'] ) ) {
				$value = array_filter( $_POST['ub_author_box'] );
				$result = add_user_meta( $user_id, 'ub_author_box', $value, true );
				if ( false === $result ) {
					update_user_meta( $user_id, 'ub_author_box', $value );
				}
			}
		}

		/**
		 * Handle entry content
		 *
		 * @since 1.9.7
		 */
		public function author_box( $content ) {
			$is_on = $this->get_value( 'show', 'mode' );
			if ( 'off' === $is_on ) {
				return $content;
			}
			return $this->box( $content );
		}

		/**
		 * handle filter "author_box".
		 *
		 * @since 2.0.0
		 */
		public function widget() {
			return $this->box();
		}

		/**
		 * add author box
		 *
		 * @since 1.9.7
		 */
		private function box( $content = '' ) {
			/**
			 * Check allowed post types.
			 */
			$is_allowed_post_type = $this->check_post_type();
			if ( ! $is_allowed_post_type ) {
				return $content;
			}
			$user_id = get_the_author_meta( 'ID' );
			$box_content = '';
			/**
			 * social media
			 */
			$social_media = $this->get_social_media_content();
			$social_media_position = $this->get_value( 'social_media_settings', 'position', 'bottom' );
			/**
			 * Gravatar
			 */
			$show = $this->get_value( 'show', 'avatar', false );
			if ( 'on' == $show ) {
				$size = $this->get_value( 'avatar', 'size', 96 );
				$box_content .= sprintf( '<div class="ub-author-box-avatar" style="min-width: %dpx;">', $size );
				$box_content .= get_avatar( $user_id, $size );
				if ( 'under-avatar' === $social_media_position ) {
					$box_content .= $social_media;
				}
				$box_content .= '</div>';
			}
			/**
			 * name
			 */

			$part = '';
			$show = $this->get_value( 'show', 'display_name', false );
			if ( 'on' == $show ) {
				$value = get_the_author_meta( 'display_name' );
				$link = $this->get_value( 'name_options', 'link', 'on' );
				if ( 'on' == $link ) {
					$value = sprintf(
						'<a href="%s">%s</a>',
						get_author_posts_url( get_the_author_meta( 'ID' ) ),
						$value
					);
				}
				$show = $this->get_value( 'name_options', 'counter', false );
				if ( 'on' === $show ) {
					$args = array(
						'author' => get_the_author_meta( 'ID' ),
						'post_type' => get_post_type(),
						'fields' => 'ids',
						'nopaging' => true,
					);
					$type = $this->get_value( 'entries_settings', 'the_same_type', 'on' );
					if ( 'off' === $type ) {
						$args['post_type'] = 'any';
					}
					$the_query = new WP_Query( $args );
					$number = count( $the_query->posts );
					$value .= sprintf( ' (%d)', number_format_i18n( $number ) );
				}
				$part .= sprintf( '<h4>%s</h4>', $value );
			}
			/**
			 * description
			 */
			$show = $this->get_value( 'show', 'description', false );
			if ( 'on' == $show ) {
				$description = get_the_author_meta( 'user_description' );
				if ( $description ) {
					$part .= sprintf( '<div class="description">%s</div>', wpautop( $description ) );
				}
			}
			/**
			 * last entries
			 */
			$show = $this->get_value( 'show', 'entries', false );
			if ( 'on' === $show ) {
				$args = array(
					'exclude' => get_the_ID(),
					'author' => get_the_author_meta( 'ID' ),
					'posts_per_page' => $this->get_value( 'entries_settings', 'limit', 5 ),
					'post_type' => get_post_type(),
				);
				$type = $this->get_value( 'entries_settings', 'the_same_type', 'on' );
				if ( 'off' === $type ) {
					$args['post_type'] = 'any';
				}
				$entries = '';
				$the_query = new WP_Query( $args );
				if ( $the_query->have_posts() ) {
					$target = $this->get_value( 'entries_settings', 'link_in_new_tab', false );
					$target = ( 'on' === $target )? ' target="_blank"':'';
					while ( $the_query->have_posts() ) {
						$the_query->the_post();
						$entries .= sprintf(
							'<li><a href="%s"%s>%s</a></li>',
							get_the_permalink(),
							$target,
							get_the_title()
						);
					}
					wp_reset_postdata();
				}
				wp_reset_query();
				if ( ! empty( $entries ) ) {
					$part .= '<div class="ub-author-box-more">';
					$show = $this->get_value( 'entries_settings', 'title_show', 'on' );
					if ( 'on' === $show ) {
						$title = $this->get_value( 'entries_settings', 'title', '' );
						if ( ! empty( $title ) ) {
							$part .= sprintf( '<h4>%s</h4>', $title );
						}
					}
					$part .= sprintf( '<ul>%s</ul>', $entries );
					$part .= '</div>';
				}
			}
			/**
			 * wrap description
			 */
			if ( ! empty( $part ) ) {
				$box_content .= sprintf( '<div class="ub-author-box-desc">%s</div>', $part );
			}
			/**
			 * wrap box content
			 */
			if ( ! empty( $box_content ) ) {
				$box_content = sprintf( '<div class="ub-author-box-content">%s</div>', $box_content );
			}
			/**
			 * social_media
			 */
			if ( ! empty( $social_media ) ) {
				switch ( $social_media_position ) {
					case 'top':
						$box_content = $social_media . $box_content;
					break;
					case 'bottom':
						$box_content .= $social_media;
				}
			}
			/**
			 * wrap all
			 */
			if ( ! empty( $box_content ) ) {
				$content .= sprintf( '<div class="ub-author-box">%s</div>', $box_content );
			}
			return $content;
		}

		/**
		 * Social media helper
		 *
		 * @since 1.9.9
		 */
		private function get_social_media_content() {
			$content = '';
			$show = $this->get_value( 'show', 'social_media', false );
			if ( 'on' != $show ) {
				return $content;
			}
			/**
			 * open link target
			 */
			$target = $this->get_value( 'social_media_settings', 'social_media_link_in_new_tab', false );
			$target = ( 'on' === $target )? ' target="_blank"':'';
			/**
			 * process
			 */
			$social = $this->get_social_media_array();
			$sm = '';
			$data = $this->get_value( 'social_media' );
			$value = get_the_author_meta( 'ub_author_box' );
			if ( empty( $value ) ) {
				$value = array();
			}
			$value['wp-profile-website'] = get_the_author_meta( 'user_url' );
			$value['mail'] = get_the_author_meta( 'user_email' );
			$order = $this->get_value( '_social_media_sortable' );
			/**
			 * show icons?
			 */
			$icons = $this->get_value( 'social_media_settings', 'type' );
			/**
			 * class pattern
			 */
			$pattern = 'off' === $icons? '':'social-logo social-logo-%s';
			if ( ! empty( $order ) && is_array( $order ) ) {
				foreach ( $order as $key ) {
					if ( ! isset( $data[ $key ] ) ) {
						continue;
					}
					if ( empty( $data[ $key ] ) || 'off' === $data[ $key ] ) {
						continue;
					}
					if ( isset( $value[ $key ] ) ) {
						$v = trim( $value[ $key ] );
						if ( $v ) {
							$class = sprintf( $pattern, $key );
							switch ( $key ) {
								case 'wp-profile-website':
									$class = sprintf( $pattern, 'share' );
									$social[ $key ] = array( 'label' => __( 'Website', 'ub' ) );
								break;
								case 'mail':
									$v = 'mailto:'.$v;
								break;
							}
							$sm .= sprintf(
								'<li class="ub-social-%s"><a href="%s"%s><span class="%s">%s</span></a></li>',
								esc_attr( $key ),
								esc_url( $v ),
								$target,
								esc_attr( $class ),
								'off' === $icons? esc_html( $social[ $key ]['label'] ):''
							);
						}
					}
					unset( $data[ $key ] );
				}
			}
			if ( ! empty( $data ) && is_array( $data ) ) {
				foreach ( $data as $key => $value ) {
					if ( ! isset( $data[ $key ] ) ) {
						continue;
					}
					if ( empty( $data[ $key ] ) || 'off' === $data[ $key ] ) {
						continue;
					}
					if ( isset( $value[ $key ] ) ) {
						$v = trim( $value[ $key ] );
						if ( $v ) {
							$class = sprintf( $pattern, $key );
							switch ( $key ) {
								case 'wp-profile-website':
									$class = sprintf( $pattern, 'share' );
								break;
								case 'mail':
									$v = 'mailto:'.$v;
								break;
							}
							$sm .= sprintf(
								'<li class="ub-social-%s"><a href="%s"%s>span class="%s">%s</span></a></li>',
								esc_attr( $key ),
								esc_url( $v ),
								$target,
								esc_attr( $class ),
								'off' === $icons? esc_html( $social[ $key ]['label'] ):''
							);
						}
					}
				}
			}
			if ( $sm ) {
				$classes = 'social-media';
				$show = $this->get_value( 'social_media_settings', 'colors', false );
				if ( 'on' == $show ) {
					$classes .= ' use-color';
				}
				$content .= sprintf( '<ul class="%s">%s</ul>', esc_attr( $classes ), $sm );
			}
			return $content;
		}

		/**
		 * Print custom CSS
		 *
		 * @since 1.9.7
		 */
		public function print_css() {
			/**
			 * Check allowed post types.
			 */
			$is_allowed_post_type = $this->check_post_type();
			if ( ! $is_allowed_post_type ) {
				return;
			}
			$value = ub_get_option( $this->option_name );
			if ( $value == 'empty' ) {
				$value = '';
			}
			if ( empty( $value ) ) {
				return;
			}
			printf( '<style type="text/css" id="%s">', esc_attr( __CLASS__ ) );
			/**
			 * box border
			 */
			if ( isset( $value['box'] ) ) {
				$v = $value['box'];
				echo '.ub-author-box {';
				if ( isset( $v['border'] ) && 'on' === $v['border'] ) {
					$width = isset( $v['border_width'] )? $v['border_width']:1;
					$color = isset( $v['border_color'] )? $v['border_color']:'solid';
					$style = isset( $v['border_style'] )? $v['border_style']:'#ddd';
					printf( 'border: %dpx %s %s;', esc_attr( $width ), esc_attr( $style ), esc_attr( $color ) );
					if ( isset( $v['border_radius'] ) && '0' != $v['border_radius'] ) {
						$this->border_radius( $v['border_radius'] );
					}
					echo 'overflow: hidden;';
				} else {
					echo 'border:none;';
				}
				echo '}';
				$this->css_background_color_from_data( 'box', 'background_color', '.ub-author-box' );
			}
			/**
			 * avatar
			 */
			if ( isset( $value['avatar'] ) ) {
				$v = $value['avatar'];
				echo '.ub-author-box .ub-author-box-content img {';
				/**
				 * rounded_form
				 */
				if ( isset( $v['rounded'] ) && '0' != $v['rounded'] ) {
					$this->border_radius( $v['rounded'] );
				}
				if ( isset( $v['border'] ) ) {
					$color = isset( $v['border_color'] )? $v['border_color']:'transparent';
					printf( 'border: %dpx solid %s;', $v['border'], esc_attr( $color ) );
				}
				echo '}';
			}
			/**
			 * social media
			 */
			$this->css_background_color_from_data( 'social_media_settings', 'background_color', '.ub-author-box .social-media' );
			echo '</style>';
		}

		/**
		 * modify option name
		 *
		 * @since 1.9.7
		 */
		public function get_module_option_name( $option_name, $module ) {
			if ( is_string( $module ) && $this->module == $module ) {
				return $this->option_name;
			}
			return $option_name;
		}

		/**
		 * Check allowed post types.
		 *
		 * @since 1.9.7
		 */
		private function check_post_type() {
			if ( is_admin() ) {
				return false;
			}
			if ( is_singular() ) {
				$allowed_post_types = $this->get_value( 'show', 'post_type', false );
				if ( empty( $allowed_post_types ) ) {
					return false;
				}
				$post_type = get_post_type();
				return in_array( $post_type, $allowed_post_types );
			}
			return false;
		}

		/**
		 * Add css border radius.
		 */
		private function border_radius( $radius ) {
			$radius = intval( $radius );
			if ( 1 > $radius ) {
				return;
			}
?>
-webkit-border-radius: <?php echo esc_attr( $radius ); ?>px;
-moz-border-radius: <?php echo esc_attr( $radius ); ?>px;
border-radius: <?php echo esc_attr( $radius ); ?>px;
<?php
		}
	}
}
new ub_author_box();
