<?php
if ( ! class_exists( 'ub_maintenance' ) ) {

	class ub_maintenance extends ub_helper {
		protected $option_name = 'ub_maintenance';
		private $current_sites = array();
		protected $file = __FILE__;

		public function __construct() {
			parent::__construct();
			$this->module = 'maintenance';
			$this->set_options();
			add_action( 'ultimatebranding_settings_maintenance', array( $this, 'admin_options_page' ) );
			add_filter( 'ultimatebranding_settings_maintenance_process', array( $this, 'update' ), 10, 1 );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'wp_ajax_ultimatebranding_maintenance_search_sites', array( $this, 'search_sites' ) );

			/**
			 * use, depend on status
			 */
			$status = $this->get_value( 'mode', 'mode' );
			if ( 'off' !== $status ) {
				add_action( 'template_redirect', array( $this, 'output' ), 0 );
				add_filter( 'rest_authentication_errors', array( $this, 'only_allow_logged_in_rest_access' ) );
			}
			/**
			 * add related config
			 *
			 * @since 2.3.0
			 */
			add_filter( 'ultimate_branding_related_modules', array( $this, 'add_related_background' ) );
			add_filter( 'ultimate_branding_related_modules', array( $this, 'add_related_logo' ) );
			add_filter( 'ultimate_branding_related_modules', array( $this, 'add_related_social_media_settings' ) );
			add_filter( 'ultimate_branding_related_modules', array( $this, 'add_related_social_media' ) );
		}

		/**
		 * modify option name
		 *
		 * @since 1.9.2
		 */
		public function get_module_option_name( $option_name, $module ) {
			if ( is_string( $module ) && $this->module == $module ) {
				return $this->option_name;
			}
			return $option_name;
		}

		protected function set_options() {
			$description = array(
				__( 'A Coming Soon should be used when a domain is new and you are building out the site.', 'ub' ),
				__( 'Maintenance should only be used when your established site is truly down for maintenance.', 'ub' ),
				__( 'Maintenance Mode returns a special header code (503) to notify search engines that your site is currently down so it does not negatively affect your site’s reputation.', 'ub' ),
			);
			$options = array(
				'mode' => array(
					'title' => __( 'Working mode', 'ub' ),
					'fields' => array(
						'mode' => array(
							'type' => 'radio',
							'label' => __( 'Mode', 'ub' ),
							'options' => array(
								'off' => __( 'Off', 'ub' ),
								'coming-soon' => __( 'Coming Soon', 'ub' ),
								'maintenance' => __( 'Maintenance', 'ub' ),
							),
							'default' => 'off',
							'description' => implode( ' ', $description ),
						),
					),
				),
				/**
				 * Common: Document
				 */
				'document' => $this->common_options_document(),
				/**
				 * Common: Logo
				 */
				'logo' => $this->get_options_logo(
					array(
						'url' => '',
						'alt' => '',
						'margin_bottom' => 0,
					)
				),
				/**
				 * Common: Background
				 */
				'background' => $this->get_options_background(),
				/**
				 * Timer
				 */
				'timer' => array(
					'title' => __( 'Countdown Timer', 'ub' ),
					'fields' => array(
						'use' => array(
							'type' => 'checkbox',
							'label' => __( 'Use Timer', 'ub' ),
							'description' => __( 'Would you like to use timer?', 'ub' ),
							'options' => array(
								'on' => __( 'On', 'ub' ),
								'off' => __( 'Off', 'ub' ),
							),
							'default' => 'off',
							'classes' => array( 'switch-button' ),
							'slave-class' => 'timer-related',
						),
						'show' => array(
							'type' => 'checkbox',
							'label' => __( 'Show on front-end', 'ub' ),
							'description' => __( 'Would you like to show the timer?', 'ub' ),
							'options' => array(
								'on' => __( 'Show', 'ub' ),
								'off' => __( 'Hide', 'ub' ),
							),
							'default' => 'on',
							'classes' => array( 'switch-button' ),
							'master' => 'timer-related',
						),
						'till_date' => array(
							'type' => 'date',
							'label' => __( 'Till Date', 'ub' ),
							'master' => 'timer-related',
						),
						'till_time' => array(
							'type' => 'time',
							'label' => __( 'Till Time', 'ub' ),
							'master' => 'timer-related',
						),
						'template' => array(
							'type' => 'select',
							'label' => __( 'Countdown Template', 'ub' ),
							'options' => array(
								'final-countdown' => __( 'Final Countdown', 'ub' ),
								'flipclock' => __( 'FlipClock', 'ub' ),
								'raw' => __( 'Raw', 'ub' ),
							),
							'default' => 'final-countdown',
							'master' => 'timer-related',
						),
					),
				),
				/**
				 * Common: Social Media Settings
				 */
				'social_media_settings' => $this->get_options_social_media_settings(),
				'social_media' => $this->get_options_social_media(),
			);
			/**
			 * multisite options
			 */
			if ( is_multisite() ) {
				$options['mode']['fields']['sites'] = array(
					'type' => 'radio',
					'label' => __( 'Apply To', 'ub' ),
					'options' => array(
						'all' => __( 'All sites', 'ub' ),
						'selected' => __( 'Selected sites', 'ub' ),
					),
					'default' => 'all',
				);
				$nonce_action = $this->get_nonce_action_name( $this->module );
				$args = array();
				$sites = $this->get_current_sites();
				if ( ! empty( $sites ) ) {
					$args = array( 'site__not_in' => $sites );
				}
				$options['sites'] = array(
					'title' => __( 'Sites', 'ub' ),
					'master' => array(
						'section' => 'mode',
						'field' => 'sites',
						'value' => 'selected',
					),
					'fields' => array(
						'sites_html' => array(
							'type' => 'description',
							'label' => __( 'Sites Added', 'ub' ),
							'value' => $this->get_current_set_sites(),
						),
						'sites' => array(
							'type' => 'select',
							'label' => __( 'Add a Site', 'ub' ),
							'multiple' => 'multiple',
							'options' => $this->get_sites( $args ),
							'classes' => array( 'ub-select2' ),
							'after' => sprintf( ' <button class="ub-button ub-add-site">%s</button>', esc_html__( 'Add site', 'ub' ) ),
						),
						'list' => array(
							'type' => 'hidden',
							'multiple' => true,
							'skip_value' => true,
						),
					),
				);
			}
			$this->options = $options;
		}

		/**
		 * get current sites html
		 */
		private function get_current_set_sites() {
			$content = '<ul id="ub_maintenance_selcted_sites">';
			$sites = $this->get_current_sites();
			if ( ! empty( $sites ) ) {
				$sites = get_sites( array( 'site__in' => $sites ) );
				foreach ( $sites as $site ) {
					$content .= sprintf( '<li id="site-%d">', esc_attr( $site->blog_id ) );
					$content .= sprintf( '<input type="hidden" name="simple_options[sites][list][]" value="%d" />', esc_attr( $site->blog_id ) );
					$blog = get_blog_details( $site->blog_id );
					$content .= esc_html( sprintf( '%s (%s)', $blog->blogname, $blog->siteurl ) );
					$content .= sprintf( ' <a href="#">%s</a>', esc_html__( 'remove site', 'ub' ) );
					$content .= '</li>';
				}
			}
			$content .= '</ul>';
			return $content;
		}
		/**
		 * get and set current sites
		 */
		private function get_current_sites() {
			if ( empty( $this->current_sites ) ) {
				$sites = $this->get_value( 'sites', 'list' );
				if ( ! empty( $sites ) ) {
					$this->current_sites = array_filter( $sites );
				}
			}
			return $this->current_sites;
		}
		/**
		 * Wraper for get_sites() wp-ms-function function.
		 */
		private function get_sites( $args = array() ) {
			$results = array(
				'-1' => esc_html__( 'Select a site', 'ub' ),
			);
			$sites = get_sites( $args );
			if ( empty( $sites ) ) {
				return array();
			}
			foreach ( $sites as $site ) {
				$blog = get_blog_details( $site->blog_id );
				$results[ $blog->blog_id ] = esc_html( sprintf( '%s (%s)', $blog->blogname, $blog->siteurl ) );
			}
			return $results;
		}

		/**
		 * Display the coming soon page
		 */
		public function output() {
			/**
			 * do not render for logged users
			 */
			$logged = is_user_logged_in();
			if ( $logged ) {
				return;
			}
			/**
			 * check status
			 */
			$status = $this->get_value( 'mode', 'mode' );
			if ( 'off' == $status ) {
				return;
			}
			/**
			 * check sites options
			 */
			$sites = $this->get_value( 'mode', 'sites' );
			if ( 'selected' == $sites ) {
				$sites = $this->get_current_sites();
				if ( empty( $sites ) ) {
					return;
				}
				$blog_id = get_current_blog_id();
				if ( ! in_array( $blog_id, $sites ) ) {
					return;
				}
			}
			/**
			 * set data
			 */
			$head = '';
			$distance = $use_timer = false;
			$body_classes = array(
				'ultimate-branding-maintenance',
			);
			/**
			 * javascript, check time;
			 */
			$v = $this->get_value( 'timer' );
			if (
				isset( $v['use'] )
				&& 'on' == $v['use']
				&& isset( $v['show'] )
				&& 'on' == $v['show']
				&& isset( $v['till_date'] )
				&& isset( $v['till_date']['alt'] )
			) {
				$distance = $this->get_distance();
				if ( 1 > $distance ) {
					return;
				}
				$use_timer = true;
				$body_classes[] = 'has-counter';
			}
			/**
			 *  set headers
			 */
			if ( 'maintenance' == $status ) {
				header( 'HTTP/1.1 503 Service Temporarily Unavailable' );
				header( 'Status: 503 Service Temporarily Unavailable' );
				header( 'Retry-After: 86400' ); // retry in a day
				$maintenance_file = WP_CONTENT_DIR.'/maintenance.php';
				if ( ! empty( $enable_maintenance_php ) and file_exists( $maintenance_file ) ) {
					include_once( $maintenance_file );
					exit();
				}
			}
			// Prevetn Plugins from caching
			// Disable caching plugins. This should take care of:
			//   - W3 Total Cache
			//   - WP Super Cache
			//   - ZenCache (Previously QuickCache)
			if ( ! defined( 'DONOTCACHEPAGE' ) ) {
				define( 'DONOTCACHEPAGE', true );
			}
			if ( ! defined( 'DONOTCDN' ) ) {
				define( 'DONOTCDN', true );
			}
			if ( ! defined( 'DONOTCACHEDB' ) ) {
				define( 'DONOTCACHEDB', true );
			}
			if ( ! defined( 'DONOTMINIFY' ) ) {
				define( 'DONOTMINIFY', true );
			}
			if ( ! defined( 'DONOTCACHEOBJECT' ) ) {
				define( 'DONOTCACHEOBJECT', true );
			}
			header( 'Cache-Control: max-age=0; private' );
			$template = $this->get_template();
			$this->set_data();
			/**
			 * Add defaults.
			 */
			if ( empty( $this->data['document']['title'] ) && empty( $this->data['document']['content'] ) ) {
				$this->data['document']['title'] = __( 'We&rsquo;ll be back soon!', 'ub' );
				$this->data['document']['content'] = __( 'Sorry for the inconvenience but we&rsquo;re performing some maintenance at the moment. We&rsquo;ll be back online shortly!', 'ub' );
				if ( 'coming-soon' == $status ) {
					$this->data['document']['title'] = __( 'Coming Soon', 'ub' );
					$this->data['document']['content'] = __( 'Stay tuned!', 'ub' );
				}
				$this->data['document']['content_meta'] = $this->data['document']['content'];
			}
			foreach ( $this->data as $section => $data ) {
				foreach ( $data as $name => $value ) {
					if ( empty( $value ) ) {
						$value = '';
					}
					if ( ! is_string( $value ) ) {
						$value = '';
					}
					if ( ! empty( $value ) ) {
						switch ( $section ) {
							case 'document':
								switch ( $name ) {
									case 'title':
										$show = $this->get_value( 'document', 'title_show' );
										if ( 'off' === $show ) {
											$value = '';
										} else {
											$value = sprintf( '<h1>%s</h1>', esc_html( $value ) );
										}
									break;
									case 'content_meta':
										$show = $this->get_value( 'document', 'content_show' );
										if ( 'off' === $show ) {
											$value = '';
										} else {
											$value = sprintf( '<div class="content">%s</div>', $value );
										}
									break;
								}
							break;
						}
					}
					$re = sprintf( '/{%s_%s}/', $section, $name );
					$template = preg_replace( $re, stripcslashes( $value ), $template );
				}
			}
			/**
			 * Common: Social Media
			 */
			$result = $this->common_options_social_media();
			$social_media = $result['social_media'];
			$body_classes = array_merge( $body_classes, $result['body_classes'] );
			$head .= $result['head'];
			$template = preg_replace( '/{social_media}/', $social_media, $template );
			/**
			 * css & javascript
			 */
			$css = $javascript = '';
			/**
			 * Common: Document
			 */
			$css .= $this->common_css_document();
			/**
			 * Background Color
			 */
			$v = $this->get_value( 'background', 'color' );
			if ( ! empty( $v ) ) {
				$css .= sprintf( 'html{%s}', $this->css_background_color( $v ) );
			}
			/**
			 * Common Background
			 *
			 * @since 2.3.0
			 */
			ob_start();
			$this->css_background_common();
			$head .= ob_get_contents();
			ob_end_clean();
			/**
			 * Logo
			 */
			$logo = '';
			ob_start();
			$this->css_logo_common( '#logo' );
			$logo_css = ob_get_contents();
			ob_end_clean();
			if ( ! empty( $logo_css ) ) {
				$logo = '<div id="logo">';
				$url = $this->get_value( 'logo', 'url' );
				if ( ! empty( $url ) ) {
					$alt = $this->get_value( 'logo', 'alt', '' );
					$logo .= sprintf(
						'<a href="%s" title="%s">%s</a>',
						esc_url( $url ),
						esc_attr( $alt ),
						esc_html( $alt )
					);
				}
				$logo .= '</div>';
				$head .= sprintf( '<style id="ub-logo-css" type="text/css">%s</style>', $logo_css );
			}
			/**
			 * timer template
			 */
			$timer_template = '';
			if ( $use_timer ) {
				$timer = $this->get_value( 'timer', 'template' );
				if ( empty( $timer ) ) {
					$timer = 'raw';
				}
				$timer_template = $this->get_template( $timer );
				switch ( $timer ) {
					case 'raw':
						$head .= $this->get_head_raw();
					break;
					case 'final-countdown':
						$re = array(
						'DAYS' => __( 'Days', 'ub' ),
						'HOURS' => __( 'Hours', 'ub' ),
						'MINUTES' => __( 'Minutes', 'ub' ),
						'SECONDS' => __( 'Seconds', 'ub' ),
						);
						$keys = array_keys( $re );
						$values = array_values( $re );
						$timer_template = str_replace( $keys, $values, $timer_template );
						$head .= $this->get_head_final_countdown();
					break;
					case 'flipclock':
						$head .= $this->get_head_flipclock();
						$d = intval( $this->get_distance() );
						$timer_template = preg_replace( '/{distance}/', $d, $timer_template );
						$language = strtolower( substr( get_bloginfo( 'language' ), 0, 2 ) );
						$timer_template = preg_replace( '/{language}/', $language, $timer_template );
					break;
				}
			}
			$template = preg_replace( '/{countdown}/', $timer_template, $template );

			/**
			 * head
			 */
			$head .= $this->enqueue( 'maintenance.css' );
			$template = preg_replace( '/{head}/', $head, $template );
			/**
			 * logo
			 */
			$template = preg_replace( '/{logo}/', $logo, $template );
			/**
			 * replace javascript
			 */
			$template = preg_replace( '/{javascript}/', $javascript, $template );
			/**
			 * replace css
			 */
			$template = preg_replace( '/{css}/', $css, $template );
			/**
			 * replace site data
			 */
			$template = preg_replace( '/{title}/', get_bloginfo( 'name' ), $template );
			$template = preg_replace( '/{language}/', get_bloginfo( 'language' ), $template );
			/**
			 * body classes
			 */
			$template = preg_replace( '/{body_class}/', implode( ' ', $body_classes ), $template );
			echo $template;
			exit();
		}

		function only_allow_logged_in_rest_access( $access ) {
			/**
			 * check status
			 */
			$status = $this->get_value( 'mode', 'mode' );
			if ( 'off' == $status ) {
				return $access;
			}
			$current_WP_version = get_bloginfo( 'version' );
			if ( version_compare( $current_WP_version, '4.7', '>=' ) ) {
				if ( ! is_user_logged_in() ) {
					return new WP_Error( 'rest_cannot_access', __( 'Only authenticated users can access the REST API.', 'ub' ), array( 'status' => rest_authorization_required_code() ) );
				}
			}
			return $access;
		}

		/**
		 * enqueue_scripts
		 */
		public function enqueue_scripts() {
			$tab = get_query_var( 'ultimate_branding_tab' );
			if ( $this->module != $tab ) {
				return;
			}
			/**
			 * module js
			 */
			$file = ub_files_url( 'modules/maintenance/assets/maintenance.js' );
			wp_register_script( __CLASS__, $file, array( 'jquery' ), $this->build, true );
			$localize = array(
				'remove' => __( 'remove site', 'ub' ),
			);
			wp_localize_script( __CLASS__, __CLASS__, $localize );
			/**
			 * jQuery select2
			 */
			$version = '4.0.5';
			$file = ub_url( 'external/select2/select2.min.js' );
			wp_enqueue_script( 'select2', $file, array( __CLASS__, 'jquery' ), $version, true );
			$file = ub_url( 'external/select2/select2.min.css' );
			wp_enqueue_style( 'select2', $file, array(), $version );
		}

		public function search_sites() {
			if ( ! is_multisite() ) {
				wp_send_json_error();
			}
			$user_id = isset( $_REQUEST['user_id'] )? $_REQUEST['user_id']:0;
			$search = isset( $_REQUEST['q'] )? $_REQUEST['q']:null;
			$nonce = isset( $_REQUEST['_wpnonce'] )? $_REQUEST['_wpnonce']:null;
			/**
			 * check values
			 */
			if ( empty( $search ) || empty( $nonce ) ) {
				wp_send_json_error();
			}
			/**
			 * Check nonce
			 */
			$nonce_action = $this->get_nonce_action_name( $this->module, $user_id );
			$verify = wp_verify_nonce( $nonce, $nonce_action );
			if ( ! $verify ) {
				wp_send_json_error();
			}
			$args = array(
				'search' => $search,
			);
			$results = array();
			$sites = get_sites( $args );
			foreach ( $sites as $site ) {
				$blog = get_blog_details( $site->blog_id );
				$results[] = array(
					'blog_id' => $blog->blog_id,
					'blogname' => $blog->blogname,
					'siteurl' => $blog->siteurl,
				);
			}
			wp_send_json_success( $results );
		}

		/**
		 * get head of Raw Countdown Timer
		 *
		 * @since 1.9.9
		 */
		private function get_head_raw() {
			/**
			 * check timer
			 */
			$distance = $this->get_distance();
			return '
<script type="text/javascript">
var distance = '.$distance.';
var ultimate_branding_counter = setInterval(function() {
    var days = Math.floor( distance / ( 60 * 60 * 24));
    var hours = Math.floor((distance % ( 60 * 60 * 24)) / ( 60 * 60));
    var minutes = Math.floor((distance % ( 60 * 60)) / ( 60));
    var seconds = Math.floor((distance % ( 60)));
    var value = "";
    if ( 0 < days ) {
        value += days + "'._x( 'd', 'day letter of timer', 'ub' ).'" + " ";
    }
    if ( 0 < hours ) {
        value += hours + "'._x( 'h', 'hour letter of timer', 'ub' ).'" + " ";
    }
    if ( 0 < minutes ) {
        value += minutes + "'._x( 'm', 'minute letter of timer', 'ub' ).'" + " ";
    }
    if ( 0 < seconds ) {
        value += seconds + "'._x( 's', 'second letter of timer', 'ub' ).'";
    }
    if ( "" == value ) {
        value = "'.__( 'We are back now!', 'ub' ).'";
    }
    document.getElementById("counter").innerHTML = value;
    if (distance < 0) {
        window.location.reload();
    }
    distance--;
}, 1000);
</script>';
		}


		/**
		 * Final Countdown assets
		 *
		 * @since 1.9.9
		 */
		private function get_head_final_countdown() {
			$head = '';
			$head .= $this->enqueue( 'jquery/jquery.js', false, true );
			$head .= $this->enqueue( 'vendor/jquery-final-countdown/js/kinetic.js', '5.1.0' );
			$head .= $this->enqueue( 'vendor/jquery-final-countdown/js/jquery.final-countdown.min.js' );
			$head .= "<script type=\"text/javascript\">
jQuery(document).ready(function($) {
    $('.countdown').final_countdown({
        'end': ".$this->get_distance( 'raw' ).",
        'now': ".time().'
    }, function() {
        window.location.reload();
    });
});
</script>';
			return $head;
		}

		/**
		 * FlipClock assets
		 *
		 * @since 1.9.9
		 */
		private function get_head_flipclock() {
			$head = '';
			$head .= $this->enqueue( 'jquery/jquery.js', false, true );
			$head .= $this->enqueue( 'vendor/flipclock/flipclock.min.js', '2018-04-12' );
			$head .= $this->enqueue( 'vendor/flipclock/flipclock.css', '2018-04-12' );
			return $head;
		}

		/**
		 * calculate distance to open site
		 *
		 * @since 1.9.9
		 */
		private function get_distance( $mode = 'difference' ) {
			$v = $this->get_value( 'timer' );
			if (
				isset( $v['use'] )
				&& 'on' == $v['use']
				&& isset( $v['show'] )
				&& 'on' == $v['show']
				&& isset( $v['till_date'] )
				&& isset( $v['till_date']['alt'] )
			) {
				$date = $v['till_date']['alt'].' '.(isset( $v['till_time'] )? $v['till_time']:'00:00');
				$timestamp = strtotime( $date );
				$gmt_offsset = get_option( 'gmt_offset' );
				if ( ! empty( $gmt_offsset ) ) {
					$timestamp -= HOUR_IN_SECONDS * intval( $gmt_offsset );
				}
				if ( 'raw' === $mode ) {
					return $timestamp;
				}
				$distance = $timestamp - time();
				if ( 0 > $distance ) {
					$value = $this->get_value();
					$value['mode']['mode'] = 'off';
					$this->update_value( $value );
					return 0;
				}
				return $distance;
			}
			return 0;
		}
	}
}
new ub_maintenance();
