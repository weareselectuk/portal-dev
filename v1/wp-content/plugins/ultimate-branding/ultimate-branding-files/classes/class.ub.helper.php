<?php
/*
Copyright 2017-2018 Incsub (email: admin@incsub.com)
 */

if ( ! class_exists( 'ub_helper' ) ) {

	class ub_helper{
		protected $options = array();
		protected $data = null;
		protected $option_name = 'unknown';
		protected $url;
		protected $build;
		protected $tab;
		protected $tab_name;
		protected $deprecated_version = false;
		protected $file = __FILE__;
		protected $uba;
		protected $old_option_name;
		/**
		 * Debug mode?
		 *
		 * @since 2.3.0
		 */
		protected $debug = false;

		/**
		 * Module name
		 *
		 * @since 1.9.4
		 */
		protected $module = 'ub_helper';

		public function __construct() {
			/**
			 * Set Ultimate Branding version
			 */
			if ( empty( $this->build ) ) {
				global $ub_version;
				$this->build = $ub_version;
			}
			/**
			 * set debug when WP_DEBUG or WPMUDEV_BETATEST
			 */
			$debug = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) || ( defined( 'WPMUDEV_BETATEST' ) && WPMUDEV_BETATEST );
			$this->debug = apply_filters( 'ultimatebranding_debug', $debug );
			/**
			 * Check is deprecated?
			 */
			if (
				! empty( $this->deprecated_version )
				&& false === $this->deprecated_version
				/**
				 * avoid to compare with development version
				 */
				&& ! preg_match( '/^PLUGIN_VER/', $this->build )
			) {
				$compare = version_compare( $this->deprecated_version, $this->build );
				if ( 1 > $compare ) {
					return;
				}
			}
			/**
			 * admin
			 */
			if ( is_admin() ) {
				global $uba;
				$params = array(
					'page' => 'branding',
				);
				if ( is_a( $uba, 'UltimateBrandingAdmin' ) ) {
					$this->tab = $params['tab'] = $uba->get_current_tab();
					$this->uba = $uba;
				}
				$this->url = add_query_arg(
					$params,
					is_network_admin() ? network_admin_url( 'admin.php' ) : admin_url( 'admin.php' )
				);
			}
			add_filter( 'ultimate_branding_options_names', array( $this, 'add_option_name' ) );
			add_filter( 'ultimate_branding_get_option_name', array( $this, 'get_module_option_name' ), 10, 2 );
			/**
			 * Add data copy
			 */
			add_filter( 'ultimate_branding_options_footer', array( $this, 'add_copy_options' ), 10, 3 );
			/**
			 * Upgrade plugin settings.
			 *
			 * @since 2.3.0
			 */
			add_action( 'init', array( $this, 'upgrade_plugin_settings' ), 5 );
			/**
			 * Rename option name.
			 *
			 * @since 2.3.0
			 */
			add_action( 'init', array( $this, 'rename_option_name' ), 9 );
		}

		public function add_option_name( $options ) {
			if ( ! in_array( $this->option_name, $options ) ) {
				$options[] = $this->option_name;
			}
			return $options;
		}

		/**
		 * @since 1.9.1 added parameter $default
		 *
		 * @param mixed $default default value return if we do not have any.
		 */
		protected function get_value( $section = null, $name = null, $default = null ) {
			$this->set_data();
			$data = $value = $this->data;
			if ( ! empty( $section ) ) {
				if ( empty( $name ) && isset( $value[ $section ] ) ) {
					$data = $value[ $section ];
				} else {
					/**
					 * If default is empty, then try to return default defined by
					 * configuration.
					 *
					 * @since 1.9.5
					 */
					if (
						null === $default
						&& isset( $this->options )
						&& isset( $this->options[ $section ] )
						&& isset( $this->options[ $section ]['fields'] )
						&& isset( $this->options[ $section ]['fields'][ $name ] )
						&& isset( $this->options[ $section ]['fields'][ $name ]['default'] )
					) {
						$data = $this->options[ $section ]['fields'][ $name ]['default'];
					} else {
						$data = $default;
					}
					if ( isset( $value[ $section ] ) ) {
						if ( empty( $name ) ) {
							$data = $value[ $section ];
						} else if ( isset( $value[ $section ][ $name ] )
						) {
							if ( is_string( $value[ $section ][ $name ] ) ) {
								$data = stripslashes( $value[ $section ][ $name ] );
							} else {
								$data = $value[ $section ][ $name ];
							}
						}
					}
				}
			}
			$data = apply_filters( 'ub_get_value', $data, $this->module, $section, $name );
			return $data;
		}

		/**
		 * set value
		 *
		 * @since 2.1.0
		 *
		 * @param string $key key
		 * @param string $subkey subkey
		 * @param mixed $value Value to store.
		 */
		protected function set_value( $key, $subkey, $value = null ) {
			$data = $this->get_value();
			if ( null === $value ) {
				if ( isset( $data[ $key ] ) && isset( $data[ $key ][ $subkey ] ) ) {
					unset( $data[ $key ][ $subkey ] );
				}
			} else {
				if ( ! isset( $data[ $key ] ) ) {
					$data[ $key ] = array();
				}
				$data[ $key ][ $subkey ] = $value;
			}
			$this->update_value( $value );
		}

		public function admin_options_page() {
			$this->set_options();
			$this->set_data();
			$simple_options = new simple_options();
			do_action( 'ub_helper_admin_options_page_before_options', $this->option_name );
			echo $simple_options->build_options( $this->options, $this->data, $this->module );
		}

		protected function set_data() {
			if ( null === $this->data ) {
				$value = ub_get_option( $this->option_name );
				if ( 'empty' !== $value ) {
					$this->data = $value;
				}
			}
		}

		/**
		 * Update settings
		 *
		 * @since 1.8.6
		 */
		public function update( $status ) {
			$value = $_POST['simple_options'];
			if ( $value == '' ) {
				$value = 'empty';
			}
			/**
			 * check empty options
			 */
			if ( empty( $this->options ) ) {
				$msg = sprintf( 'Ultimate Branding Admin: empty options array for %s variable. Please contact with plugin developers.', $this->option_name );
				error_log( $msg, 0 );
				return;
			}
			foreach ( $this->options as $section_key => $section_data ) {
				if ( ! isset( $section_data['fields'] ) ) {
					continue;
				}
				if ( isset( $section_data['sortable'] ) && isset( $value[ $section_key ] ) ) {
					$value[ '_'.$section_key.'_sortable' ] = array_keys( $value[ $section_key ] );
				}
				foreach ( $section_data['fields'] as $key => $data ) {
					if ( ! isset( $data['type'] ) ) {
						$data['type'] = 'text';
					}
					switch ( $data['type'] ) {
						case 'media':
							if ( isset( $value[ $section_key ][ $key ] ) && is_array( $value[ $section_key ][ $key ] ) ) {
								$value[ $section_key ][ $key ] = array_shift( $value[ $section_key ][ $key ] );
								$image = wp_get_attachment_image_src( $value[ $section_key ][ $key ], 'full' );
								if ( false !== $image ) {
									$value[ $section_key ][ $key.'_meta' ] = $image;
								}
							}
						break;
						case 'gallery':
							if ( isset( $value[ $section_key ][ $key ] ) && is_array( $value[ $section_key ][ $key ] ) ) {
								$gallery = array();
								foreach ( $value[ $section_key ][ $key ] as $id ) {
									if ( empty( $id ) ) {
										continue;
									}
									$one = array(
										'value' => $id,
										'meta' => array( $id ),
									);
									if ( preg_match( '/^\d+$/', $id ) ) {
										$image = wp_get_attachment_image_src( $id, 'full' );
										if ( false !== $image ) {
											$one['meta'] = $image;
										}
									}
									$gallery[] = $one;
								}
								$value[ $section_key ][ $key ] = $gallery;
							}
						break;
						case 'checkbox':
							if ( isset( $value[ $section_key ][ $key ] ) ) {
								$value[ $section_key ][ $key ] = 'on';
							} else {
								$value[ $section_key ][ $key ] = 'off';
							}
							break;
							/**
							 * save extra data if field is a wp_editor
							 */
						case 'wp_editor':
							$value[ $section_key ][ $key.'_meta' ] = wpautop( do_shortcode( stripslashes( $value[ $section_key ][ $key ] ) ) );
							break;
					}
				}
			}
			return $this->update_value( $value );
		}

		/**
		 * Update whole value
		 *
		 * @since 1.9.5
		 */
		protected function update_value( $value ) {
			ub_update_option( $this->option_name , $value );
			$this->data = $value;
			return true;
		}

		/**
		 * get base url
		 *
		 * @since 1.8.9
		 */
		protected function get_base_url() {
			$url = '';
			if ( ! is_admin() ) {
				return $url;
			}
			$screen = get_current_screen();
			if ( ! is_object( $screen ) ) {
				return $url;
			}
			$args = array(
				'page' => $screen->parent_base,
			);
			if ( isset( $_REQUEST['tab'] ) ) {
				$args['tab'] = $_REQUEST['tab'];
			}
			if ( is_network_admin() ) {
				$url = add_query_arg( $args, network_admin_url( 'admin.php' ) );
			} else {
				$url = add_query_arg( $args, admin_url( 'admin.php' ) );
			}
			return $url;
		}

		/**
		 * Admin notice wrapper
		 *
		 * @since 1.8.9
		 * @since 2.3.0 added the `inline` argument.
		 *
		 * @param string $message Message to display
		 * @param string $class WP Notice type class.
		 * @param boolean $inline Add inline class?
		 */
		protected function notice( $message, $class = 'info', $inline = false ) {
			$allowed = array( 'error', 'warning', 'success', 'info' );
			if ( in_array( $class, $allowed ) ) {
				$class = ' notice-'.$class;
			} else {
				$class = '';
			}
			if ( $inline ) {
				$class .= ' inline';
			}
			printf(
				'<div class="notice%s"><p>%s</p></div>',
				esc_attr( $class ),
				$message
			);
		}

		/**
		 * Handle filter for option name, it should be overwrite by module
		 * method.
		 *
		 * @since 1.9.2
		 */
		public function get_module_option_name( $option_name, $module ) {
			if ( $module === $this->module ) {
				return $this->option_name;
			}
			return $option_name;
		}

		/**
		 * Remove "Save Changes" button from page.
		 *
		 * @since 1.9.2
		 */
		public function disable_save() {
			add_filter( 'ultimatebranding_settings_panel_show_submit', '__return_false' );
		}

		/**
		 * get nonce action
		 *
		 * @since 1.9.4
		 *
		 * @param string $name nonce name
		 * @param integer $user_id User ID.
		 * @return nonce action name
		 */
		protected function get_nonce_action_name( $name = 'default', $user_id = 0 ) {
			if ( 0 === $user_id ) {
				$user_id = get_current_user_id();
			}
			$nonce_action = sprintf(
				'%s_%s_%d',
				__CLASS__,
				$name,
				$user_id
			);
			return $nonce_action;
		}

		/**
		 * Load SocialLogos style.
		 * https://wpcalypso.wordpress.com/devdocs/design/social-logos
		 *
		 * @since 1.9.7
		 */
		protected function load_social_logos_css() {
			$url = $this->get_social_logos_css_url();
			wp_enqueue_style( 'SocialLogos', $url, array(), '2.0.0', 'screen' );
		}

		/**
		 * Get SocialLogos style URL.
		 * https://wpcalypso.wordpress.com/devdocs/design/social-logos
		 *
		 * @since 1.9.7
		 */
		protected function get_social_logos_css_url() {
			$url = ub_url( 'external/icon-font/social-logos.css' );
			return $url;
		}

		/**
		 * SocialLogos social icons.
		 * https://wpcalypso.wordpress.com/devdocs/design/social-logos
		 *
		 * @since 1.9.7
		 */
		protected function get_social_media_array() {
			$social = array(
				'amazon'      => array( 'label' => __( 'Amazon', 'ub' ) ),
				'blogger'     => array( 'label' => __( 'Blogger', 'ub' ) ),
				'codepen'     => array( 'label' => __( 'CodePen', 'ub' ) ),
				'dribbble'    => array( 'label' => __( 'Dribbble', 'ub' ) ),
				'dropbox'     => array( 'label' => __( 'Dropbox', 'ub' ) ),
				'eventbrite'  => array( 'label' => __( 'Eventbrite', 'ub' ) ),
				'facebook'    => array( 'label' => __( 'Facebook', 'ub' ) ),
				'flickr'      => array( 'label' => __( 'Flickr', 'ub' ) ),
				'foursquare'  => array( 'label' => __( 'Foursquare', 'ub' ) ),
				'ghost'       => array( 'label' => __( 'Ghost', 'ub' ) ),
				'github'      => array( 'label' => __( 'Github', 'ub' ) ),
				'google'      => array( 'label' => __( 'G+', 'ub' ) ),
				'instagram'   => array( 'label' => __( 'Instagram', 'ub' ) ),
				'linkedin'    => array( 'label' => __( 'LinkedIn', 'ub' ) ),
				'mail'        => array( 'label' => __( 'Mail', 'ub' ) ),
				'pinterest'   => array( 'label' => __( 'Pinterest', 'ub' ) ),
				'pocket'      => array( 'label' => __( 'Pocket', 'ub' ) ),
				'polldaddy'   => array( 'label' => __( 'Polldaddy', 'ub' ) ),
				'reddit'      => array( 'label' => __( 'Reddit', 'ub' ) ),
				'skype'       => array( 'label' => __( 'Skype', 'ub' ) ),
				'spotify'     => array( 'label' => __( 'Spotify', 'ub' ) ),
				'squarespace' => array( 'label' => __( 'Squarespace', 'ub' ) ),
				'stumbleupon' => array( 'label' => __( 'Stumbleupon', 'ub' ) ),
				'telegram'    => array( 'label' => __( 'Telegram', 'ub' ) ),
				'tumblr'      => array( 'label' => __( 'Tumblr', 'ub' ) ),
				'twitter'     => array( 'label' => __( 'Twitter', 'ub' ) ),
				'vimeo'       => array( 'label' => __( 'Vimeo', 'ub' ) ),
				'whatsapp'    => array( 'label' => __( 'Whatsapp', 'ub' ) ),
				'wordpress'   => array( 'label' => __( 'WordPress', 'ub' ) ),
				'xanga'       => array( 'label' => __( 'Xanga', 'ub' ) ),
				'youtube'     => array( 'label' => __( 'Youtube', 'ub' ) ),
			);
			return $social;
		}

		/**
		 * Replace URL with protocol with related URL.
		 *
		 * @since 1.9.7
		 *
		 * @param string $url URL
		 * @return string $url
		 */
		protected function make_relative_url( $url ) {
			if ( empty( $url ) ) {
				return;
			}
			if ( ! is_string( $url ) ) {
				return;
			}
			$re = sprintf( '@^(%s|%s)@', set_url_scheme( home_url(), 'http' ),set_url_scheme( home_url(), 'https' ) );
			$to = set_url_scheme( home_url(), 'relative' );
			return preg_replace( $re, $to, $url );
		}

		/**
		 * CSS border style
		 *
		 * @since 1.9.7
		 */
		protected function css_border_options() {
			$options = array(
				'dotted' => __( 'Dotted', 'ub' ),
				'dashed' => __( 'Dashed', 'ub' ),
				'solid' => __( 'Solid', 'ub' ),
				'double' => __( 'Double', 'ub' ),
				'groove' => __( '3D grooved', 'ub' ),
				'ridge' => __( '3D ridged', 'ub' ),
				'inset' => __( '3D inset', 'ub' ),
				'outset' => __( '3D outset', 'ub' ),
			);
			return $options;
		}

		protected function css_background_color( $color ) {
			if ( empty( $color ) ) {
				$color = 'transparent';
			}
			return sprintf( 'background-color: %s;', $color );
		}

		protected function css_color( $color ) {
			if ( empty( $color ) ) {
				$color = 'inherit';
			}
			return sprintf( 'color: %s;', $color );
		}

		protected function css_width( $width, $units = 'px' ) {
			if ( empty( $width ) ) {
				return '';
			}
			return sprintf( 'width: %s%s;', $width, $units );
		}

		protected function css_height( $height, $units = 'px' ) {
			if ( empty( $height ) ) {
				return '';
			}
			return sprintf( 'height: %s%s;', $height, $units );
		}

		/**
		 * CSS Radius
		 *
		 * @since 2.2.0
		 */
		protected function css_radius( $radius, $units = 'px' ) {
			if ( empty( $radius ) ) {
				return '';
			}
			$keys = array( '-webkit-border-radius', '-moz-border-radius', 'border-radius' );
			$content = '';
			foreach ( $keys as $key ) {
				$content .= sprintf( '%s: %s%s;', $key, esc_attr( $radius ), esc_attr( $units ) );
			}
			return $content;
		}

		/**
		 * CSS color.
		 *
		 * @since 1.9.6
		 *
		 * @param array $section Configuration section.
		 * @param string $key Configuration key.
		 * @param string $selector CSS selector.
		 * @param boolean $echo Print or return data.
		 *
		 */
		protected function css_color_from_data( $section, $key, $selector, $echo = true ) {
			$css = '';
			$value = $this->get_value( $section, $key );
			if ( ! empty( $value ) ) {
				$css .= sprintf( '%s{color:%s}', $selector, $value );
				if ( $this->debug ) {
					$css .= PHP_EOL;
				}
			}
			if ( $echo ) {
				echo $css;
				return;
			}
			return $css;
		}

		/**
		 * CSS background color.
		 *
		 * @since 1.9.6
		 *
		 * @param array $section Configuration section.
		 * @param string $key Configuration key.
		 * @param string $selector CSS selector.
		 * @param boolean $echo Print or return data.
		 *
		 */
		protected function css_background_color_from_data( $section, $key, $selector, $echo = true ) {
			return $this->css_background_transparency( $section, $key, 100, $selector, $echo );
		}

		/**
		 * CSS background color with transparency.
		 *
		 * @since 1.9.6
		 *
		 * @param array $section Configuration section.
		 * @param string $key Configuration key.
		 * @param number $transparency CSS transparency.
		 * @param string $selector CSS selector.
		 * @param boolean $echo Print or return data.
		 *
		 */
		protected function css_background_transparency( $section, $key, $transparency, $selector, $echo = true ) {
			$css = '';
			$bg_color = $this->get_value( $section, $key );
			$bg_transparency = $this->get_value( $section, $key );
			if ( $bg_color ) {
				$css .= $selector;
				$css .= '{';
				if ( 0 < $bg_transparency && 100 !== $bg_transparency ) {
					$bg_color = $this->convert_hex_to_rbg( $bg_color );
					$css .= sprintf( 'background-color:rgba(%s,%0.2f)', implode( ',', $bg_color ), $bg_transparency / 100 );
				} else {
					$css .= sprintf( 'background-color:%s', $bg_color );
				}
				$css .= '}';
				if ( $this->debug ) {
					$css .= PHP_EOL;
				}
			}
			if ( $echo ) {
				echo $css;
				return;
			}
			return $css;
		}

		protected function css_opacity( $data, $key, $selector ) {
			if ( isset( $data[ $key ] ) && ! empty( $data[ $key ] ) ) {
				printf( '%s{opacity:%0.2f}', $selector, $data[ $key ] / 100 );
				if ( $this->debug ) {
					echo PHP_EOL;
				}
			}
		}

		protected function css_hide( $data, $key, $selector ) {
			if ( isset( $data[ $key ] ) && 'off' == $data[ $key ] ) {
				printf( '%s{display:none}', $selector );
				if ( $this->debug ) {
					echo PHP_EOL;
				}
			}
		}

		/**
		 * Produce common CSS for document settings.
		 *
		 * @input string $section Section of data.
		 *
		 * @since 2.3.0
		 *
		 */
		protected function common_css_document( $section = 'document' ) {
			$css = '';
			$css .= $this->css_background_transparency( $section, 'background', 'background_transparency', '.page', false );
			$css .= $this->css_color_from_data( $section, 'color', '.page', false );
			$css .= '.page{';
			if ( isset( $section['width'] ) && ! empty( $section['width'] ) ) {
				$css .= $this->css_width( $section['width'] );
			} else {
				$css .= $this->css_width( 100, '%' );
			}
			$css .= '}';
			return $css;
		}

		/**
		 * Prepare COMMON css background!
		 *
		 * @since 2.3.0
		 *
		 * @param string $selector HTML element selector.
		 */
		protected function css_background_common( $selector = 'html' ) {
			$data = $this->get_value( 'background' );
			$javascript = $css = '';
			/**
			 * background-color
			 */
			$css .= $this->css_background_color_from_data( 'background', 'color', $selector, false );
			/**
			 * background-image
			 */
			$show = true;
			if ( isset( $data['show'] ) && 'off' === $data['show'] ) {
				$show = false;
			}
			if ( $show && isset( $data['image'] ) ) {
				$v = $data['image'];
				if ( 0 < count( $v ) && isset( $v[0]['meta'] ) ) {
					$mode = $this->get_value( 'background', 'mode' );
					$id = 0;
					do {
						$id = rand( 0, count( $v ) - 1 );
					} while ( ! isset( $v[ $id ]['meta'] ) );
					$meta = $v[ $id ]['meta'];
					$css .= sprintf('
'.$selector.' {
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    background-image: url(%s);
    background-repeat: no-repeat;
    background-position: 50%%;
    background-attachment: fixed;
    background-color: transparent;
}', $this->make_relative_url( esc_url( $meta[0] ) ) );
					if ( 'slideshow' === $mode && 1 < count( $v ) ) {
						$css .= '
.ub-background-mask {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    top: 0;
    background-repeat: no-repeat;
    background-position: 50%;
    background-attachment: fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    z-index: -1;
}
';
						$images = array();
						foreach ( $v as $one ) {
							if ( isset( $one['meta'] ) ) {
								$images[] = $this->make_relative_url( $one['meta'][0] );
							}
						}
						if ( count( $images ) ) {
							$duration = intval( $this->get_value( 'background', 'duration' ) );
							if ( 0 > $duration ) {
								$duration = 10;
							}
							$duration = MINUTE_IN_SECONDS * $duration * 1000;
							$javascript .= PHP_EOL;
							$javascript .= sprintf( 'var imgs = %s;', json_encode( $images ) );
							$javascript .= PHP_EOL;
							$javascript .= '
var opacity, ub_fade;
var duration = '.intval( $duration ).';
var ub_animate_background = setInterval( function( ) {
    var imgUrl = imgs[Math.floor(Math.random()*imgs.length)];
    var mask = document.getElementsByClassName(\'ub-background-mask\')[0];
    var background_element = document.getElementsByTagName(\''.$selector.'\')[0];
    if ( "undefined" === typeof mask ) {
        var parent = document.getElementsByTagName(\'body\')[0];
        var m = document.createElement("div");
        m.classList.add( "ub-background-mask" );
        parent.insertBefore( m, parent.childNodes[0] );
        mask = document.getElementsByClassName(\'ub-background-mask\')[0];
    }
    if ( "" === background_element.style.backgroundImage ) {
        background_element.style.backgroundImage = \'url(\' + imgs[0] + \')\';
    }
    mask.style.backgroundImage = background_element.style.backgroundImage;
    background_element.style.backgroundImage = \'url(\' + imgUrl + \')\';
    mask.style.opacity = opacity = 1;
    ub_fade = setInterval( function() {
        if ( 0.05 > opacity ) {
            clearTimeout( ub_fade );
            opacity = 1;
            return;
        }
        opacity -= .01;
        mask.style.opacity = opacity;
    }, duration / 20 );
}, duration );
';
						}
					}
				}
			}
			if ( ! empty( $css ) ) {
				echo '<style id="ub-background-css" type="text/css">';
				echo $css;
				echo '</style>';
			}
			if ( ! empty( $javascript ) ) {
				echo '<script id="ub-background-js" type="text/javascript">';
				echo $javascript;
				echo '</script>';
			}
		}

		/**
		 * Prepare COMMON css logo!
		 *
		 * @since 2.3.0
		 *
		 * @param string $selector HTML element selector.
		 *
		 */
		protected function css_logo_common( $selector ) {
			$data = $this->get_value( 'logo' );
			if ( ! isset( $data['show'] ) || 'on' !== $data['show'] ) {
				return;
			}
			/**
			 * rounded_form
			 */
			if ( isset( $data['rounded'] ) && '0' != $data['rounded'] ) {
				echo $selector.', '.$selector.' a ';
?>{
    -webkit-border-radius: <?php echo intval( $data['rounded'] ); ?>px;
    -moz-border-radius: <?php echo intval( $data['rounded'] ); ?>px;
    border-radius: <?php echo intval( $data['rounded'] ); ?>px;
}
<?php
			}
			/**
			 * logo
			 */
			$src = false;
			$width = $height = 'auto';
			if ( isset( $data['image_meta'] ) ) {
				$src = $data['image_meta'][0];
				$image = $data['image_meta'];
				$width = $image[1];
				$height = $image[2];
				if ( isset( $data['width'] ) ) {
					$scale = $data['width'] / $width;
					$width = $data['width'];
					$height = intval( $height * $scale );
				} elseif ( $width > 320 ) {
					$scale = 320 / $width ;
					$height = intval( $height * $scale );
					$width = intval( $width * $scale );
				}
			}
			if ( ! $src ) {
				if ( isset( $data['image'] ) && ! empty( $data['image'] ) ) {
					$src = $data['image'];
					if ( isset( $data['width'] ) ) {
						$height = $width = $data['width'];
					}
				}
			}
			if ( ! empty( $src ) ) {
				echo $selector.', '.$selector.' a ';
?>{
    background-image: url(<?php echo $this->make_relative_url( $src ); ?>);
    background-size: 100%;
    display: block;
    height: <?php echo $height; ?>px;
    margin: 0 auto;
    overflow: hidden;
    text-indent: -9999px;
    width: <?php echo $width; ?>px;
}
<?php
			} else if ( isset( $data['width'] ) ) {
				echo $selector.' a ';
?>{
    background-size: 100%;
    margin: 0 auto;
    height: <?php echo $data['width']; ?>px;
    width: <?php echo $data['width']; ?>px;
}
<?php
			}
			/**
			 * logo_bottom_margin
			 */
			if ( isset( $data['margin_bottom'] ) ) {
				echo $selector.' a ';
?>{
    margin-bottom: <?php echo $data['margin_bottom']; ?>px;
}
<?php
			}
			/**
			 * logo_transparency
			 */
			$this->css_opacity( $data, 'transparency', $selector );
			/**
			 * position
			 */
			if ( isset( $data['position'] ) ) {
				switch ( $data['position'] ) {
					case 'left':
						echo $selector.' { margin-left: 0 }';
					break;
					case 'right':
						echo $selector.' { margin-right: 0 }';
					break;
				}
			}
		}

		/**
		 * Convert color from RGB to HEX.
		 *
		 * @since 1.9.6
		 */
		protected function convert_hex_to_rbg( $hex ) {
			if ( preg_match( '/^#.{6}$/', $hex ) ) {
				return sscanf( $hex, '#%02x%02x%02x' );
			}
			return $hex;
		}

		/**
		 * Helper to enqueue scripts/styles
		 *
		 * @since 1.9.9
		 */
		protected function enqueue( $src, $version = false, $core = false ) {
			if ( $core ) {
				$src = get_site_url().'/wp-includes/js/'.$src;
			} else {
				$src = plugins_url( 'assets/'.$src, $this->file );
			}
			if ( preg_match( '/js$/', $src ) ) {
				return sprintf(
					'<script type="text/javascript" src="%s?version=%s"></script>%s',
					$this->make_relative_url( $src ),
					$version? $version:$this->build,
					PHP_EOL
				);
			}
			if ( preg_match( '/css$/', $src ) ) {
				return sprintf(
					'<link rel="stylesheet" href="%s?version=%s" type="text/css" media="all" />%s',
					$this->make_relative_url( $src ),
					$version? $version:$this->build,
					PHP_EOL
				);
			}
			return '';
		}

		/**
			* get the template
			*
			* @since 2.0.0
		 */
		protected function get_template( $file = 'index' ) {
			$file = sprintf(
				'%s/assets/templates/%s.html',
				dirname( $this->file ),
				sanitize_title( $file )
			);
			if ( is_file( $file ) && is_readable( $file ) ) {
				$file = file_get_contents( $file );
				return $file;
			}
			return __( 'Something went wrong!', 'ub' );
		}

		/**
		 * backgroun options
		 *
		 * @since 2.3.0
		 */
		protected function get_options_background( $defaults = array() ) {
			$data = array(
				'title' => __( 'Background', 'ub' ),
				'fields' => array(
					'color' => array(
						'type' => 'color',
						'label' => __( 'Background Color', 'ub' ),
						'default' => isset( $defaults['color'] )? $defaults['color']:'#210101',
					),
					'show' => array(
						'type' => 'checkbox',
						'label' => __( 'Display Background Images', 'ub' ),
						'description' => __( 'Would you like to use background images?', 'ub' ),
						'options' => array(
							'on' => __( 'Show', 'ub' ),
							'off' => __( 'Hide', 'ub' ),
						),
						'default' => isset( $defaults['show'] )? $defaults['show']:'on',
						'classes' => array( 'switch-button' ),
						'slave-class' => 'ub-default-background-show-related',
					),
					'mode' => array(
						'type' => 'radio',
						'label' => __( 'Multiple Images Mode', 'ub' ),
						'options' => array(
							'slideshow' => __( 'Slideshow', 'ub' ),
							'random' => __( 'Random', 'ub' ),
						),
						'default' => 'slideshow',
						'master' => 'ub-default-background-show-related',
					),
					'image' => array(
						'type' => 'gallery',
						'label' => __( 'Background Image', 'ub' ),
						'description' => __( 'You can upload a background image here. The image will stretch to fit the page, and will automatically resize as the window size changes. You\'ll have the best results by using images with a minimum width of 1024px.', 'ub' ),
						'master' => 'ub-default-background-show-related',
					),
					'duration' => array(
						'type' => 'number',
						'label' => __( 'Slideshow Duration', 'ub' ),
						'description' => __( 'Duration in minutes, we strongly recommended do not use less than 5 minutes.', 'ub' ),
						'default' => 10,
						'min' => 1,
						'max' => 60,
						'after' => __( 'Minutes', 'ub' ),
						'classes' => array( 'ui-slider' ),
						'master' => array(
							'section' => 'background',
							'field' => 'mode',
							'value' => 'slideshow',
							'master' => 'ub-default-background-show-related',
						),
					),
				),
			);
			/**
			 * Allow to change background options.
			 *
			 * @since 2.3.0
			 *
			 * @param array $data Background options data.
			 * @param array $defaults Default values from function.
			 * @param string Current module name.
			 */
			return apply_filters( 'ub_get_options_background', $data, $defaults, $this->module );
		}

		/**
		 * backgroun options
		 *
		 * @since 2.3.0
		 */
		protected function get_options_logo( $defaults = array() ) {
			$data = array(
				'title' => __( 'Logo', 'ub' ),
				'fields' => array(
					'show' => array(
						'type' => 'checkbox',
						'label' => __( 'Display', 'ub' ),
						'description' => __( 'Would you like to show the logo?', 'ub' ),
						'options' => array(
							'on' => __( 'Show', 'ub' ),
							'off' => __( 'Hide', 'ub' ),
						),
						'default' => isset( $defaults['show'] )? $defaults['show']:'on',
						'classes' => array( 'switch-button' ),
						'slave-class' => 'ub-default-logo-related',
					),
					'image' => array(
						'type' => 'media',
						'label' => __( 'Image', 'ub' ),
						'description' => __( 'Upload your own logo.', 'ub' ),
						'master' => 'ub-default-logo-related',
					),
					'width' => array(
						'type' => 'number',
						'label' => __( 'Width', 'ub' ),
						'default' => intval( isset( $defaults['width'] )? $defaults['width']:84 ),
						'min' => 0,
						'max' => 320,
						'classes' => array( 'ui-slider' ),
						'master' => 'ub-default-logo-related',
						'after' => __( 'px', 'ub' ),
					),
					'position' => array(
						'type' => 'radio',
						'label' => __( 'Position', 'ub' ),
						'options' => array(
							'left' => __( 'Left', 'ub' ),
							'center' => __( 'Center', 'ub' ),
							'right' => __( 'Right', 'ub' ),
						),
						'default' => isset( $defaults['show'] )? $defaults['show']:'center',
						'master' => 'logo-related',
					),
					'transparency' => array(
						'type' => 'number',
						'label' => __( 'Opacity', 'ub' ),
						'min' => 0,
						'max' => 100,
						'default' => intval( isset( $defaults['width'] )? $defaults['width']:100 ),
						'classes' => array( 'ui-slider' ),
						'master' => 'ub-default-logo-related',
						'after' => '%',
					),
					'rounded' => array(
						'type' => 'number',
						'label' => __( 'Corners Radius', 'ub' ),
						'description' => __( 'How much would you like to round the border?', 'ub' ),
						'attributes' => array( 'placeholder' => '20' ),
						'default' => intval( isset( $defaults['width'] )? $defaults['width']:0 ),
						'min' => 0,
						'classes' => array( 'ui-slider' ),
						'master' => 'ub-default-logo-related',
						'after' => __( 'px', 'ub' ),
					),
					'url' => array(
						'type' => 'text',
						'label' => __( 'URL', 'ub' ),
						'default' => esc_url( isset( $defaults['url'] )? $defaults['url']:'' ),
						'classes' => array( 'ub-default-logo-related', 'large-text' ),
						'master' => 'ub-default-logo-related',
					),
					'alt' => array(
						'type' => 'text',
						'label' => __( 'Alt Text', 'ub' ),
						'default' => esc_html( isset( $defaults['alt'] )? $defaults['alt']:'' ),
						'classes' => array( 'ub-default-logo-related', 'large-text' ),
						'master' => 'ub-default-logo-related',
					),
					'margin_bottom' => array(
						'type' => 'number',
						'label' => __( 'Bottom Margin', 'ub' ),
						'description' => __( 'The default value will work for most users, but you may change the margin height here.', 'ub' ),
						'attributes' => array( 'placeholder' => '25' ),
						'default' => intval( isset( $defaults['margin_bottom'] )? $defaults['margin_bottom']:0 ),
						'min' => 0,
						'classes' => array( 'ui-slider' ),
						'master' => 'ub-default-logo-related',
						'after' => __( 'px', 'ub' ),
					),
				),
			);
			/**
			 * Allow to change logo options.
			 *
			 * @since 2.3.0
			 *
			 * @param array $data logo options data.
			 * @param array $defaults Default values from function.
			 * @param string Current module name.
			 */
			return apply_filters( 'ub_get_options_logo', $data, $defaults, $this->module );
		}

		/**
		 * Social Media Settings
		 *
		 * @since 2.3.0
		 */
		protected function get_options_social_media_settings( $defaults = array() ) {
			$data = array(
				'title' => __( 'Social Media Settings', 'ub' ),
				'fields' => array(
					'show' => array(
						'type' => 'checkbox',
						'label' => __( 'Show', 'ub' ),
						'description' => __( 'Would you like to show social media?', 'ub' ),
						'options' => array(
							'on' => __( 'Show', 'ub' ),
							'off' => __( 'Hide', 'ub' ),
						),
						'default' => esc_attr( isset( $defaults['show'] )? $defaults['show']:'on' ),
						'classes' => array( 'switch-button' ),
						'slave-class' => 'social-media',
					),
					'colors' => array(
						'type' => 'checkbox',
						'label' => __( 'Colors', 'ub' ),
						'description' => __( 'Would you like show colored icons?', 'ub' ),
						'options' => array(
							'on' => __( 'Colors', 'ub' ),
							'off' => __( 'Monochrome', 'ub' ),
						),
						'default' => esc_attr( isset( $defaults['colors'] )? $defaults['colors']:'off' ),
						'classes' => array( 'switch-button' ),
						'master' => 'social-media',
					),
					'social_media_link_in_new_tab' => array(
						'type' => 'checkbox',
						'label' => __( 'Open Links', 'ub' ),
						'description' => __( 'Would you like open link in new or the same window/tab?', 'ub' ),
						'options' => array(
							'on' => __( 'New', 'ub' ),
							'off' => __( 'The same', 'ub' ),
						),
						'default' => esc_attr( isset( $defaults['social_media_link_in_new_tab'] )? $defaults['social_media_link_in_new_tab']:'off' ),
						'classes' => array( 'switch-button' ),
						'master' => 'social-media',
					),
				),
			);
			/**
			 * Allow to change Social Media Settings options.
			 *
			 * @since 2.3.0
			 *
			 * @param array $data logo options data.
			 * @param array $defaults Default values from function.
			 * @param string Current module name.
			 */
			return apply_filters( 'ub_get_options_social_media_settings', $data, $defaults, $this->module );
		}

		/**
		 * Social Media
		 *
		 * @since 2.3.0
		 */
		protected function get_options_social_media( $defaults = array() ) {
			$data = array(
					'title' => __( 'Social Media', 'ub' ),
					'fields' => array(),
					'sortable' => true,
					'master' => array(
						'section' => 'social_media_settings',
						'field' => 'show',
						'value' => 'on',
					),
			);
			$social = $this->get_social_media_array();
			$order = $this->get_value( '_social_media_sortable' );
			if ( is_array( $order ) ) {
				foreach ( $order as $key ) {
					if ( isset( $social[ $key ] ) ) {
						$data['fields'][ $key ] = $social[ $key ];
						unset( $social[ $key ] );
					}
				}
			}
			$data['fields'] += $social;
			/**
			 * Allow to change Social Media Settings options.
			 *
			 * @since 2.3.0
			 *
			 * @param array $data logo options data.
			 * @param array $defaults Default values from function.
			 * @param string Current module name.
			 */
			return apply_filters( 'ub_get_options_social_media', $data, $defaults, $this->module );
		}

		/**
		 * Common options Social Media
		 *
		 * @since 2.3.0
		 */
		protected function common_options_social_media() {
			$social_media = '';
			$body_classes = array();
			$head = '';
			$data = $this->get_value( 'social_media_settings' );
			if ( isset( $data['show'] ) && 'on' === $data['show'] ) {
				if ( isset( $data['colors'] ) && 'on' === $data['colors'] ) {
					$body_classes[] = 'use-color';
				}
				$target = ( isset( $data['social_media_link_in_new_tab'] ) && 'on' === $data['social_media_link_in_new_tab'] )? ' target="_blank"':'';
				$data = $this->get_value( 'social_media' );
				if ( ! empty( $data ) ) {
					foreach ( $data as $key => $url ) {
						if ( empty( $url ) ) {
							continue;
						}
						$social_media .= sprintf(
							'<li><a href="%s"%s><span class="social-logo social-logo-%s"></span></a></li>%s',
							esc_url( $url ),
							$target,
							esc_attr( $key ),
							$this->debug? PHP_EOL:''
						);
					}
					if ( ! empty( $social_media ) ) {
						$body_classes[] = 'has-social';
						$social_media = sprintf( '<div id="social"><ul>%s</ul></div>', $social_media );
						$head .= sprintf(
							'<link rel="stylesheet" id="social-logos-css" href="%s" type="text/css" media="all" />%s',
							$this->make_relative_url( $this->get_social_logos_css_url() ),
							PHP_EOL
						);
					}
				}
			}
			return array(
				'social_media' => $social_media,
				'body_classes' => $body_classes,
				'head' => $head,
			);
		}

		/**
		 * Get related modules by section
		 *
		 * @since 2.3.0
		 *
		 * @param string $section Section.
		 */
		private function get_related_modules( $section ) {
			global $uba;
			$related = $uba->get_related();
			if ( ! isset( $related[ $section ] ) ) {
				return array();
			}
			if ( 2 > count( $related[ $section ] ) ) {
				return array();
			}
			return $related[ $section ];
		}

		/**
		 * Add copy options.
		 *
		 * Allow top copy selected settings between modules.
		 *
		 * @since 2.3.0
		 *
		 * @param string $content Current footer.
		 * @param string $module Current module.
		 * @param string $section Current section.
		 */
		public function add_copy_options( $content, $module, $section ) {
			$modules = array();
			/**
			 * check current module
			 */
			if ( $module !== $this->module ) {
				return $content;
			}
			/**
			 * get modules
			 */
			$modules = $this->get_related_modules( $section );
			if ( empty( $modules ) ) {
				return $content;
			}
			/**
			 * add
			 */
			$option_name = $this->get_module_option_name( '', $module );
			$content .= sprintf(
				'<div class="ub-copy-section-settings" data-module="%s" data-section="%s" data-nonce="%s"><label>',
				esc_attr( $option_name ),
				esc_attr( $section ),
				wp_create_nonce( 'ub-copy-section-settings-'.$option_name )
			);
			$content .= '<select>';
			$content .= sprintf( '<option value="-1">%s</option>', esc_html__( '-- Copy from --', 'ub' ) );
			foreach ( $modules as $key => $data ) {
				if ( $key === $module ) {
					continue;
				}
				$content .= sprintf(
					'<option value="%s">%s</a>',
					esc_attr( $data['option'] ),
					esc_html( $data['title'] )
				);
			}
			$content .= '</select>';
			$content .= sprintf( '<a href="#" class="button">%s</a>', esc_html__( 'Copy', 'ub' ) );
			$content .= '</label></div>';
			return $content;
		}

		private function add_related( $related, $section ) {
			if ( ! isset( $related[ $section ] ) ) {
				$related[ $section ] = array();
			}
			global $uba;
			$re = sprintf( '@%s@', ub_files_dir( 'modules/' ) );
			$module = preg_replace( $re, '', $this->file );
			$configuration = $uba->get_configuration();
			$title = __( 'Unknown', 'ub' );
			if ( isset( $configuration[ $module ] ) ) {
				if ( isset( $configuration[ $module ]['menu_title'] ) ) {
					$title = $configuration[ $module ]['menu_title'];
				} else if ( isset( $configuration[ $module ]['page_title'] ) ) {
					$title = $configuration[ $module ]['page_title'];
				}
			}
			$related[ $section ][ $this->module ] = array(
				'title' => $title,
				'module' => $module,
				'option' => $this->get_module_option_name( '', $this->module ),
			);
			return $related;
		}

		public function add_related_logo( $related ) {
			return $this->add_related( $related, 'logo' );
		}

		public function add_related_background( $related ) {
			return $this->add_related( $related, 'background' );
		}

		public function add_related_social_media_settings( $related ) {
			return $this->add_related( $related, 'social_media_settings' );
		}

		public function add_related_social_media( $related ) {
			return $this->add_related( $related, 'social_media' );
		}

		/**
		 * Common options Social Media
		 *
		 * @since 2.3.0
		 */
		protected function common_options_document( $defaults = array(), $remove = array() ) {
			$args = array(
				'title' => __( 'Document', 'ub' ),
				'fields' => array(
					'title_show' => array(
						'type' => 'checkbox',
						'label' => __( 'Show Title', 'ub' ),
						'description' => __( 'Would you like to show title?', 'ub' ),
						'options' => array(
							'on' => __( 'On', 'ub' ),
							'off' => __( 'Off', 'ub' ),
						),
						'default' => 'off',
						'classes' => array( 'switch-button' ),
						'slave-class' => 'title',
					),
					'title' => array(
						'label' => __( 'Title', 'ub' ),
						'description' => __( 'Enter a headline for your page.', 'ub' ),
						'default' => '',
						'master' => 'title',
					),
					'content_show' => array(
						'type' => 'checkbox',
						'label' => __( 'Show Content', 'ub' ),
						'description' => __( 'Would you like to show content?', 'ub' ),
						'options' => array(
							'on' => __( 'On', 'ub' ),
							'off' => __( 'Off', 'ub' ),
						),
						'default' => 'off',
						'classes' => array( 'switch-button' ),
						'slave-class' => 'content',
					),
					'content' => array(
						'type' => 'wp_editor',
						'label' => __( 'Content', 'ub' ),
						'master' => 'content',
						'default' => '',
					),
					'color' => array(
						'type' => 'color',
						'label' => __( 'Color', 'ub' ),
						'default' => '#000000',
					),
					'background' => array(
						'type' => 'color',
						'label' => __( 'Background Color', 'ub' ),
						'default' => '#f1f1f1',
					),
					'background_transparency' => array(
						'type' => 'number',
						'label' => __( 'Background Transparency', 'ub' ),
						'min' => 0,
						'max' => 100,
						'default' => 0,
						'classes' => array( 'ui-slider' ),
						'after' => '%',
					),
					'width' => array(
						'type' => 'number',
						'label' => __( 'Width', 'ub' ),
						'default' => 600,
						'min' => 0,
						'max' => 2000,
						'classes' => array( 'ui-slider' ),
					),
				),
			);
			$args = array_replace_recursive( $args, $defaults );
			$args = $this->remove_from_array( $args, $remove );
			return $args;
		}

		private function remove_from_array( $args, $remove ) {
			foreach ( $remove as $section => $one ) {
				if ( is_string( $one ) && isset( $args[ $one ] ) ) {
					unset( $args[ $one ] );
				} else if ( is_array( $one ) && isset( $args[ $section ] ) ) {
					$args[ $section ] = $this->remove_from_array( $args[ $section ], $one );
				}
			}
			return $args;
		}

		/**
		 * rename option name
		 *
		 * @since 2.3.0
		 */
		public function rename_option_name() {
			if ( ! empty( $this->old_option_name ) ) {
				$value = ub_get_option( $this->old_option_name );
				if ( ! empty( $value ) ) {
					$this->update_value( $value );
					ub_delete_option( $this->old_option_name );
				}
			}
		}

		/**
		 * upgrade plugin settinfs
		 *
		 * @since 2.3.0
		 */
		public function upgrade_plugin_settings() {
			/**
			 * turn on custom-login-screen instead custom-login-css
			 */
			$is_active = ub_is_active_module( 'custom-login-css.php' );
			if ( $is_active ) {
				if ( empty( $this->uba ) ) {
					$this->uba = new UltimateBrandingAdmin();
				}
				$this->uba->activate_module( 'custom-login-screen.php' );
			}
		}

		protected function debug( $arg, $module, $start = true ) {
			if ( ! $this->debug ) {
				return;
			}
			$value = is_array( $arg )? serialize( $arg ) : $arg;
			printf(
				'%s<!-- %s: %s [%s] %s -->%s',
				PHP_EOL,
				$start? 'begin':'end',
				'Ultimate Branding',
				$module,
				$value,
				PHP_EOL
			);
		}

		protected function bold( $a ) {
			return sprintf( '<b>%s</b>', $a );
		}

		/**
		 * default options for open link in new tab.
		 *
		 * @since 2.3.0
		 *
		 * @param array $defaults Default paramters.
		 *
		 * @return array $args Array of params.
		 */
		public function get_options_link_in_new_tab( $defaults = array() ) {
			$args = array(
				'type' => 'checkbox',
				'label' => __( 'Open Links', 'ub' ),
				'description' => __( 'Would you like open link in new or the same window/tab?', 'ub' ),
				'options' => array(
					'on' => __( 'New', 'ub' ),
					'off' => __( 'The same', 'ub' ),
				),
				'classes' => array( 'switch-button' ),
				'default' => 'off',
			);
			$args = wp_parse_args( $args, $defaults );
			return $args;
		}
	}
}
