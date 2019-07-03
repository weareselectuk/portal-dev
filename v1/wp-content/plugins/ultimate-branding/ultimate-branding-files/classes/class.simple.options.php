<?php
/*
Class Name: Simple Options
Class URI: http://iworks.pl/
Description: Simple option class to manage options.
Version: 1.2.0
Author: Marcin Pietrzak
Author URI: http://iworks.pl/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Copyright (c) 2017-2018 Incsub

this program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA


== CHANGELOG ==

= 1.3.0 =
- Added "html_editor" field type.

= 1.2.1 =
- Added "link" field type.
- Added "readonly" property.

= 1.2.0 =
- Added "checkboxes" field type.
- Added "label_rich" to allow HTML rich label.

= 1.1.0 =
- Added "css_editor" field type.

= 1.0.9 =
- Added default "large-text" class to "textarea" and "email",

= 1.0.8 =
- Added "gallery" field type.

= 1.0.7 =
- Handle multiple value for select.

= 1.0.6 =
- Added sortable option.
- Added ability to hide default information.
- Fixed missing select value.

= 1.0.5 =
- Fixed problem with missing date.

= 1.0.4 =
- Added slave sections.
- Added select & select2 type.
- Added 'before' & 'after' parameter.
- Added 'skip_value' parameter to allow print mempty value.
- Fixed "hidden" field - remove TR/TD wraper.

= 1.0.3 =
- Added extra $value sanitization for wp_editor and textarea.
- Clean up "checkbox" input type.

= 1.0.2 =
- Move section description into "inside" div.

= 1.0.1 =
- Added description for section without fields.

= 1.0.0 =
- Init version.

 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'simple_options' ) ) {

	class simple_options {

		private $loaded = array();

		public function __construct() {
			add_action( 'wp_ajax_simple_option', array( $this, 'ajax' ) );
		}

		/**
		 * Build options boxes.
		 *
		 * @param array $options Options.
		 * @param array $input Data.
		 * @param string $module Current module name.
		 */
		public function build_options( $options, $input, $module ) {
			if ( empty( $options ) ) {
				return;
			}
			$boxes = $this->get_boxes();
			$content = '';
			foreach ( $options as $section_key => $option ) {
				if ( ! isset( $option['fields'] ) ) {
					if ( isset( $option['description'] ) ) {
						$classes = array( 'postbox' );
						if ( isset( $boxes[ $section_key ] ) ) {
							$classes[] = $boxes[ $section_key ];
						}
						$content .= sprintf( '<div class="%s" id="%s">', esc_attr( implode( ' ', $classes ) ), esc_attr( $section_key ) );
						$content .= $this->box_title( $option['title'] );
						$content .= sprintf( '<div class="inside description">%s</div>', wpautop( $option['description'] ) );
						$content .= '</div>';
					}
					continue;
				}
				if ( ! is_array( $option['fields'] ) ) {
					continue;
				}
				if ( empty( $option['fields'] ) ) {
					continue;
				}
				/**
				 * extra & classes
				 */
				$classes = array( 'postbox' );
				$extra = array();
				if ( isset( $option['master'] ) ) {
					$master_fields = array(
						'section' => '',
						'field' => '',
						'value' => '',
					);
					foreach ( $master_fields as $master_field => $master_value ) {
						if ( isset( $option['master'][ $master_field ] ) ) {
							$master_value = $option['master'][ $master_field ];
						}
						$master_fields[ $master_field ] = $master_value;
						$extra[] = sprintf( 'data-master-%s="%s"', $master_field, esc_attr( $master_value ) );
					}
					$value = $this->get_single_value( $options, $input, $master_fields['section'], $master_fields['field'] );
					$classes[] = 'section-is-slave';
					if ( $master_fields['value'] != $value ) {
						$classes[] = 'hidden';
					}
				}
				if ( isset( $boxes[ $section_key ] ) ) {
					$classes[] = $boxes[ $section_key ];
				}
				/**
				 * postbox
				 */
				$classes = array_unique( $classes );
				$content .= sprintf(
					'<div class="%s" id="%s" %s>',
					esc_attr( implode( ' ', $classes ) ),
					esc_attr( $section_key ),
					implode( ' ', $extra )
				);

				$content .= $this->box_title( $option['title'] );
				/**
				 * open inside
				 */
				$content .= '<div class="inside">';
				/**
				 * add description
				 */
				if ( isset( $option['description'] ) && ! empty( $option['description'] ) ) {
					$content .= sprintf( '<p class="description">%s</p>', $option['description'] );
				}
				/**
				 * table
				 */
				$table_classes = array(
					'form-table',
				);
				$sortable = isset( $option['sortable'] ) && $option['sortable'];
				if ( $sortable ) {
					$table_classes[] = 'sortable';
				}
				$content .= sprintf(
					'<table class="%s"><tbody>',
					esc_attr( implode( ' ', $table_classes ) )
				);
				foreach ( $option['fields'] as $id => $data ) {
					/**
					 * field ID
					 */
					$html_id = 'simple_options_'.$section_key.'_'.$id;
					/**
					 * default type
					 */
					if ( ! isset( $data['type'] ) ) {
						$data['type'] = 'text';
					}
					/**
					 * default classes
					 */
					if ( ! isset( $data['classes'] ) ) {
						$data['classes'] = array();
					} else if ( ! is_array( $data['classes'] ) ) {
						$data['classes'] = array( $data['classes'] );
					}
					/**
					 * default class for text field
					 */
					if ( preg_match( '/^(text(area)?|email)$/', $data['type'] ) && empty( $data['classes'] ) ) {
						$data['classes'][] = 'large-text';
					}
					/**
					 * html5.data
					 */
					$extra = array();
					if ( isset( $data['data'] ) ) {
						foreach ( $data['data'] as $data_key => $data_value ) {
							$extra[] = sprintf( 'data-%s="%s"', esc_html( $data_key ), esc_attr( $data_value ) );
						}
					}
					/**
					 * begin table row
					 */
					if ( 'hidden' !== $data['type'] ) {
						$master_data = '';
						$master = isset( $data['master'] )? $data['master']:'';
						if ( is_array( $master ) ) {
							foreach ( $master as $master_field => $master_value ) {
								$master_data .= sprintf( ' data-master-%s="%s"', $master_field, esc_attr( $master_value ) );
							}
							$simple_master = '';
							if ( isset( $master['master'] ) ) {
								$simple_master = ' '.$master['master'];
							}
							$master = 'simple-option-complex-master'.$simple_master;
						}
						$content .= sprintf(
							'<tr class="simple-option simple-option-%s %s" %s>',
							esc_attr( $data['type'] ),
							esc_attr( $master ),
							$master_data
						);
						/**
						 * sortable
						 */
						if ( $sortable ) {
							$content .= '<td><span class="dashicons dashicons-move"></span></td>';
						}
						/**
						 * TH
						 */
						$show = true;
						if ( isset( $option['hide-th'] ) && true === $option['hide-th'] ) {
							$show = false;
						}
						if ( isset( $data['hide-th'] ) && true === $data['hide-th'] ) {
							$show = false;
						}
						if ( $show ) {
							$content .= sprintf(
								'<th scope="row"><label for="%s">%s</label></th>',
								esc_attr( $html_id ),
								isset( $data['label'] )?
								( isset( $data['label_rich'] ) && $data['label_rich'] ? $data['label'] : esc_html( $data['label'] ) ):'&nbsp;'
							);
						}
						if ( isset( $data['hide-th'] ) && true === $data['hide-th'] ) {
							$content .= sprintf( '<td colspan="%d">', $sortable? 3:2 );
						} else {
							$content .= '<td>';
						}
					}

					/**
					 * field name
					 */
					$field_name = sprintf( 'simple_options[%s][%s]', $section_key, $id );
					if ( isset( $data['multiple'] ) && $data['multiple'] ) {
						$field_name .= '[]';
					}
					if ( isset( $data['name'] ) ) {
						$field_name = $data['name'];
					}
					/**
					 * value
					 */
					$value = $this->get_single_value( $options, $input, $section_key, $id );
					/**
					 * before
					 */
					if ( isset( $data['before'] ) ) {
						$content .= $data['before'];
					}
					/**
					 * produce
					 */
					switch ( $data['type'] ) {

						case 'description':
							if ( empty( $data['classes'] ) ) {
								$content .= $data['value'];
							} else {
								$content .= sprintf( '<div class="%s"><p>%s</p></div>', esc_attr( implode( ' ', $data['classes'] ) ), $data['value'] );
							}
						break;

						case 'gallery':
						case 'media':
							if ( ! isset( $this->loaded['media'] ) ) {
								$this->loaded['media'] = true;
								wp_enqueue_media();
								add_action( 'admin_footer', array( $this, 'add_media_template' ) );
							}
							if ( ! is_array( $value ) ) {
								$value = array( array( 'value' => $value ) );
							}
							$content .= $this->image( $section_key, $id, $value, $data['type'] );
						break;

						case 'color':
							$content .= sprintf(
								'<input type="text" name="simple_options[%s][%s]" value="%s" class="ub_color_picker %s" id="%s" />',
								esc_attr( $section_key ),
								esc_attr( $id ),
								esc_attr( $value ),
								isset( $data['class'] ) ? esc_attr( $data['class'] ) : '',
								esc_attr( $html_id )
							);
						break;

						case 'radio':
							$content .= '<ul>';
							foreach ( $data['options'] as $radio_value => $radio_label ) {
								$content .= sprintf(
									'<li><label><input type="%s" name="simple_options[%s][%s]" %s value="%s" />%s</label></li>',
									esc_attr( $data['type'] ),
									esc_attr( $section_key ),
									esc_attr( $id ),
									checked( $value, $radio_value, false ),
									esc_attr( $radio_value ),
									esc_html( $radio_label )
								);
							}
							$content .= '</ul>';
						break;

						case 'checkboxes':
							if ( empty( $value ) || ! is_array( $value ) ) {
								$value = array();
							}
							if ( isset( $data['options'] ) && is_array( $data['options'] ) ) {
								$content .= '<ul>';
								foreach ( $data['options'] as $checkbox_value => $checkbox_label ) {
									$content .= sprintf(
										'<li><label><input type="checkbox" id="%s_%s" name="simple_options[%s][%s][%s]" value="1" class="%s" %s /> %s</label></li>',
										esc_attr( $html_id ),
										esc_attr( $checkbox_value ),
										esc_attr( $section_key ),
										esc_attr( $id ),
										esc_attr( $checkbox_value ),
										isset( $data['classes'] ) ? esc_attr( implode( ' ', $data['classes'] ) ) : '',
										checked( 1, array_key_exists( $checkbox_value, $value ), false ),
										esc_html( $checkbox_label )
									);
								}
								$content .= '</ul>';
							}
							break;

						case 'checkboxes':
							$content .= '<ul>';
							foreach ( $data['options'] as $checkbox_value => $checkbox_label ) {
								$checked = is_array( $value ) && array_key_exists( $checkbox_value, $value );
								$content .= sprintf(
									'<li><label><input type="checkbox" id="%s_%s" name="simple_options[%s][%s][%s]" value="1" class="%s" %s /> %s</label></li>',
									esc_attr( $html_id ),
									esc_attr( $checkbox_value ),
									esc_attr( $section_key ),
									esc_attr( $id ),
									esc_attr( $checkbox_value ),
									isset( $data['classes'] ) ? esc_attr( implode( ' ', $data['classes'] ) ) : '',
									checked( 1, $checked, false ),
									esc_html( $checkbox_label )
								);
							}
							$content .= '</ul>';
							break;

						case 'checkbox':
							$slave = '';
							if ( isset( $data['slave-class'] ) ) {
								$slave = sprintf( 'data-slave="%s"', esc_attr( $data['slave-class'] ) );
								if ( isset( $data['classes'] ) ) {
									$data['classes'][] = 'master-field';
								} else {
									$data['classes'] = array( 'master-field' );
								}
							}
							if ( in_array( 'switch-button', $data['classes'] ) ) {
								if ( ! isset( $this->loaded['switch-button'] ) ) {
									$this->loaded['switch-button'] = true;
									ub_enqueue_switch_button();
								}
								if ( 'on' == $value ) {
									$value = 1;
								}
								$content .= sprintf(
									'<input type="%s" id="%s" name="simple_options[%s][%s]" value="1" class="%s" data-on="%s" data-off="%s" %s %s />',
									esc_attr( $data['type'] ),
									esc_attr( $html_id ),
									esc_attr( $section_key ),
									esc_attr( $id ),
									isset( $data['classes'] ) ? esc_attr( implode( ' ', $data['classes'] ) ) : '',
									esc_attr( $data['options']['on'] ),
									esc_attr( $data['options']['off'] ),
									checked( 1, $value, false ),
									$slave
								);
							} else {
								$content .= sprintf(
									'<label><input type="%s" id="%s" name="simple_options[%s][%s]" value="1" class="%s" %s %s /> %s</label>',
									esc_attr( $data['type'] ),
									esc_attr( $html_id ),
									esc_attr( $section_key ),
									esc_attr( $id ),
									isset( $data['classes'] ) ? esc_attr( implode( ' ', $data['classes'] ) ) : '',
									checked( 1, $value, false ),
									$slave,
									esc_html( isset( $data['checkbox_label'] )? $data['checkbox_label']:'' )
								);
							}
						break;

						case 'textarea':
							if ( ! is_string( $value ) ) {
								$value = '';
							}
							$content .= sprintf(
								'<textarea id="%s" name="simple_options[%s][%s]" class="%s" id="%s">%s</textarea>',
								esc_attr( $html_id ),
								esc_attr( $section_key ),
								esc_attr( $id ),
								isset( $data['classes'] ) ? esc_attr( implode( ' ', $data['classes'] ) ) : '',
								esc_attr( $html_id ),
								esc_attr( stripslashes( $value ) )
							);
						break;

						case 'wp_editor':
							if ( ! is_string( $value ) ) {
								$value = '';
							}
							$wp_editor_id = sprintf( 'simple_options_%s_%s', $section_key, $id );
							$args = array( 'textarea_name' => $field_name, 'textarea_rows' => 9, 'teeny' => true );
							ob_start();
							wp_editor( stripslashes( $value ), $wp_editor_id, $args );
							$content .= ob_get_contents();
							ob_end_clean();
						break;

						/**
						 * select && select2
						 *
						 * @since 1.9.4
						 */
						case 'select':
						case 'select2':
						case 'select2-ajax':
							if ( isset( $data['multiple'] ) && $data['multiple'] ) {
								$extra[] = 'multiple="multiple"';
							}
							if ( preg_match( '/^select2/', $data['type'] ) ) {
								if ( 'select2' == $data['type'] ) {
									$data['classes'][] = 'ub-select2';
								} else {
									$data['classes'][] = 'ub-select2-ajax';
								}
								if ( ! isset( $this->loaded['select2'] ) ) {
									$this->loaded['select2'] = true;
									$version = '4.0.5';
									$file = ub_url( 'external/select2/select2.min.js' );
									wp_enqueue_script( 'select2', $file, array( 'jquery' ), $version, true );
									$file = ub_url( 'external/select2/select2.min.css' );
									wp_enqueue_style( 'select2', $file, array(), $version );
								}
							}
							$select_options = '';
							if ( isset( $data['options'] ) && is_array( $data['options'] ) ) {
								foreach ( $data['options'] as $option_value => $option_label ) {
									$selected = false;
									if ( is_array( $value ) ) {
										$selected = in_array( $option_value, $value );
									} elseif ( $value === $option_value ) {
										$selected = true;
									}
									$select_options .= sprintf(
										'<option value="%s" %s>%s</option>',
										esc_attr( $option_value ),
										selected( $selected, true, false ),
										esc_html( $option_label )
									);
								}
							}
							$content .= sprintf(
								'<select id="%s" name="%s" class="%s" %s>%s</select>',
								esc_attr( $html_id ),
								esc_attr( $field_name ),
								isset( $data['classes'] ) ? esc_attr( implode( ' ', $data['classes'] ) ) : '',
								implode( ' ', $extra ),
								$select_options
							);
						break;

							/**
							 * CSS Editor
							 * @since 1.1.0
							 *
							 * html Editor
							 * @since 1.3.0
							 */
						case 'css_editor':
						case 'html_editor':
							if ( ! is_string( $value ) ) {
								$value = '';
							}
							$data['classes'][] = 'ub_'.$data['type'];
							$content .= sprintf(
								'<textarea id="%s" name="%s" class="%s">%s</textarea>',
								esc_attr( $html_id ),
								esc_attr( $field_name ),
								isset( $data['classes'] ) ? esc_attr( implode( ' ', $data['classes'] ) ) : '',
								esc_attr( stripslashes( $value ) )
							);
						break;

						default:
							switch ( $data['type'] ) {
								case 'date':
									$data['type'] = 'text';
									$data['classes'][] = 'datepicker';
									if ( ! isset( $this->loaded['ui-datepicker'] ) ) {
										$this->loaded['ui-datepicker'] = true;
										wp_enqueue_script( 'jquery-ui-datepicker' );
										wp_localize_jquery_ui_datepicker();
										$this->enqueue_jquery_style();
									}
									if ( ! isset( $data['data'] ) ) {
										$data['data'] = array();
									}
									$alt = 'datepicker-'.md5( serialize( $data ) );
									$extra[] = sprintf( 'data-alt="%s"', esc_attr( $alt ) );
									if ( ! isset( $data['after'] ) ) {
										$data['after'] = '';
									}
									$alt_value = '';
									if ( is_array( $value ) ) {
										if ( isset( $value['alt'] ) ) {
											$alt_value = $value['alt'];
											$value = date_i18n( get_option( 'date_format' ), strtotime( $value['alt'] ) );
										} else {
											$value = '';
										}
									}
									$data['after'] .= sprintf(
										'<input type="hidden" name="%s[alt]" id="%s" value="%s" />',
										esc_attr( $field_name ),
										esc_attr( $alt ),
										esc_attr( $alt_value )
									);
									$field_name .= '[human]';
									break;

								case 'number':
									$data['classes'][] = 'small-text';
									if ( isset( $data['min'] ) ) {
										$extra[] = sprintf( 'min="%d"', $data['min'] );
									}
									if ( isset( $data['max'] ) ) {
										$extra[] = sprintf( 'max="%d"', $data['max'] );
									}
									break;

								case 'button':
								case 'submit':
									$data['classes'][] = 'button';
									if ( isset( $data['value'] ) ) {
										$value = $data['value'];
									}
									if ( isset( $data['disabled'] ) && $data['disabled'] ) {
										$extra[] = 'disabled="disabled"';
									}
									break;

								default:
									if ( isset( $data['value'] ) && empty( $value ) ) {
										$value = $data['value'];
									}
							}
							/**
							 * readonly?
							 */
							if ( isset( $data['readonly'] ) && $data['readonly'] ) {
								$extra[] = 'readonly="readonly"';
							}
							/**
							 * add
							 */
							if ( 'link' === $data['type'] ) {
								/**
								 * since 1.2.1
								 */
								$content .= sprintf(
									'<a href="%s" id="%s" name="%s" class="%s" id="%s" %s >%s</a>',
									isset( $data['href'] )? esc_attr( $data['href'] ):'',
									esc_attr( $html_id ),
									esc_attr( $field_name ),
									isset( $data['classes'] ) ? esc_attr( implode( ' ', $data['classes'] ) ) : '',
									esc_attr( $html_id ),
									implode( ' ', $extra ),
									esc_html( stripslashes( $value ) )
								);
							} else {
								$content .= sprintf(
									'<input type="%s" id="%s" name="%s" value="%s" class="%s" id="%s" %s />',
									esc_attr( $data['type'] ),
									esc_attr( $html_id ),
									esc_attr( $field_name ),
									esc_attr( stripslashes( $value ) ),
									isset( $data['classes'] ) ? esc_attr( implode( ' ', $data['classes'] ) ) : '',
									esc_attr( $html_id ),
									implode( ' ', $extra )
								);
							}
						break;
					}
					/**
					 * after
					 */
					if ( isset( $data['after'] ) ) {
						$content .= $data['after'];
					}

					if ( in_array( 'ui-slider', $data['classes'] ) ) {
						$ui_slider_data = array(
							'data-target-id' => esc_attr( $html_id ),
						);
						foreach ( array( 'min', 'max' ) as $tmp_key ) {
							if ( isset( $data[ $tmp_key ] ) ) {
								$ui_slider_data[ 'data-'.$tmp_key ] = $data[ $tmp_key ];
							}
						}
						$ui_slider_data_string = '';
						foreach ( $ui_slider_data as $k => $v ) {
							$ui_slider_data_string .= sprintf( ' %s="%s"', $k, esc_attr( $v ) );
						}
						$content .= sprintf( '<div class="ui-slider" %s></div>', $ui_slider_data_string );
						if ( ! isset( $this->loaded['ui-slider'] ) ) {
							$this->loaded['ui-slider'] = true;
							wp_enqueue_script( 'jquery-ui-slider' );
							$this->enqueue_jquery_style();
						}
					}
					if ( isset( $data['description'] ) && ! empty( $data['description'] ) ) {
						$content .= sprintf( '<p class="description">%s</p>', $data['description'] );
					}
					if ( isset( $data['default'] ) ) {
						$show = true && ! is_array( $data['default'] );
						if ( isset( $data['default_hide'] ) && $data['default_hide'] ) {
							$show = false;
						}
						if ( $show ) {
							$default = $data['default'];
							if ( isset( $data['options'] ) && isset( $data['options'][ $default ] ) ) {
								$default = $data['options'][ $data['default'] ];
							}
							if ( ! empty( $default ) || is_numeric( $default ) ) {
								$message = sprintf(
									__( 'Default is: <code><strong>%s</strong></code>', 'ub' ),
									$default
								);
								if ( 'color' == $data['type'] ) {
									$message = sprintf(
										__( 'Default color is: <code><strong>%s</strong></code>', 'ub' ),
										$data['default']
									);
								}
								$content .= sprintf( '<p class="description description-default">%s</p>', $message );
							}
						}
					}
					if ( 'hidden' !== $data['type'] ) {
						$content .= '</td>';
						$content .= '</tr>';
					}
				}
				$content .= '</tbody>';
				/**
				 * section options, table foot
				 */
				$table_footer = '';
				/**
				 * add reset
				 */
				$show = true;
				if ( isset( $option['hide-reset'] ) && true === $option['hide-reset'] ) {
					$show = false;
				}
				if ( $show ) {
					$table_footer .= '<span class="simple-option-reset-section">';
					$table_footer .= sprintf(
						'<a href="#" data-nonce="%s" data-section="%s" data-question="%s" data-network="%d">%s</a>',
						esc_attr( wp_create_nonce( 'reset-section-'.$section_key ) ),
						esc_attr( $section_key ),
						esc_attr(
							sprintf(
								__( 'Are you sure to reset "%s" section?', 'ub' ),
								$option['title']
							)
						),
						is_network_admin(),
						__( 'reset section to default', 'ub' )
					);
					$table_footer .= '</span>';
				}
				/**
				 * table foot content filter
				 *
				 * @since 2.3.0
				 *
				 * @param string $table_footer Current footer.
				 * @param string $module Current module.
				 * @param string $section_key Current section.
				 */
				$table_footer = apply_filters( 'ultimate_branding_options_footer', $table_footer, $module, $section_key );
				/**
				 * check and show options table section footer
				 */
				if ( ! empty( $table_footer ) ) {
					$content .= '<tfoot><tr>';
					$content .= sprintf( '<td colspan="%d">', $sortable? 3:2 );
					$content .= $table_footer;
					$content .= '</td></tr></tfoot>';
				}
				/**
				 * section options table end';
				 */
				$content .= '</table>';
				$content .= '</div>';
				$content .= '</div>';
			}
			/**
			 * wrap
			 */
			if ( ! empty( $content ) ) {
				$content = sprintf(
					'<div class="meta-box-sortables simple-options">%s</div>',
					$content
				);
			} else {
				$content = sprintf(
					'<div class="notice notice-error inline"><p>%s</p></div>',
					__( 'There is no definied options here.', 'ub' )
				);
			}
			return $content;
		}

		/**
		 * Handle admin AJAX requests
		 *
		 * @since 1.8.5
		 */
		public function ajax() {
			/**
			 * handle closed tabs
			 */
			if ( isset( $_REQUEST['close'] ) && isset( $_REQUEST['tab'] ) && isset( $_REQUEST['nonce'] ) ) {
				if ( wp_verify_nonce( $_REQUEST['nonce'], 'boxes' ) ) {
					if ( isset( $_REQUEST['target'] ) ) {
						$user = wp_get_current_user();
						if ( empty( $user ) ) {
							wp_send_json_error();
						}
						$boxes = get_user_meta( $user->ID, 'closedpostboxes_ultimate_branding', true );
						if ( ! is_array( $boxes ) ) {
							$boxes = array();
						}
						if ( ! isset( $boxes[ $_REQUEST['tab'] ] ) ) {
							$boxes[ $_REQUEST['tab'] ] = array();
						}
						$boxes[ $_REQUEST['tab'] ][ $_REQUEST['target'] ] = 'true' == $_REQUEST['close']? 'closed':'open';
						update_user_meta( $user->ID, 'closedpostboxes_ultimate_branding', $boxes );
					}
				}
			}
			/**
			 * handle section reset
			 */
			if ( isset( $_REQUEST['section'] ) && isset( $_REQUEST['tab'] ) && isset( $_REQUEST['nonce'] ) ) {
				if ( wp_verify_nonce( $_REQUEST['nonce'], 'reset-section-'.$_REQUEST['section'] ) ) {
					$option_name = ub_get_option_name_by_module( $_REQUEST['tab'] );
					$success = false;
					if ( 'unknown' == $option_name ) {
						$success = apply_filters( 'ultimatebranding_reset_section', $success, $_REQUEST['tab'], $_REQUEST['section'] );
					} else {
						$value = ub_get_option( $option_name );
						if ( isset( $value[ $_REQUEST['section'] ] ) ) {
							unset( $value[ $_REQUEST['section'] ] );
							ub_update_option( $option_name , $value );
							$success = true;
						}
					}
					if ( $success ) {
						$admin = isset( $_REQUEST['network'] ) && $_REQUEST['network'] ? network_admin_url( 'admin.php' ):admin_url( 'admin.php' );
						$data = array(
							'redirect' => add_query_arg(
								array(
									'msg' => 'reset-section-success',
									'page' => 'branding',
									'tab' => $_REQUEST['tab'],
								),
								$admin
							),
						);
						wp_send_json_success( $data );
					}
				}
			}
			/**
			 * actions with "do"
			 */
			if ( isset( $_REQUEST['do'] ) && isset( $_REQUEST['nonce'] ) ) {
				switch ( $_REQUEST['do'] ) {
					case 'copy':
						$data = $this->helper_ajax_copy();
					break;
				}
			}
			wp_send_json_error( array( 'message' => __( 'Something went wrong!', 'ub' ) ) );
		}

		/**
		 * Helper AJAX copy
		 *
		 * @since 2.3.0
		 */
		private function helper_ajax_copy() {
			if (
				! isset( $_REQUEST['module'] )
				|| ! isset( $_REQUEST['section'] )
				|| ! isset( $_REQUEST['from'] )
			) {
				wp_send_json_error( array( 'message' => __( 'Missing required parameters.', 'ub' ) ) );
			}
			if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'ub-copy-section-settings-' . $_REQUEST['module'] ) ) {
				wp_send_json_error( array( 'message' => __( 'Nope! Security check failed!', 'ub' ) ) );
			}
			$result = $this->copy_settings( $_REQUEST['module'], $_REQUEST['section'], $_REQUEST['from'] );
			if ( $result ) {
				wp_send_json_success();
			}
		}

		/**
		 * Copy settings
		 *
		 * @since 2.3.0
		 */
		private function copy_settings( $to, $section, $from ) {
			$from_data = ub_get_option( $from );
			if ( ! isset( $from_data[ $section ] ) ) {
				wp_send_json_error( array( 'message' => __( 'Source section is not saved yet and there is nothing to copy!', 'ub' ) ) );
			}
			$to_data = ub_get_option( $to );
			if ( ! is_array( $to_data ) ) {
				$to_data = array();
			}
			$to_data[ $section ] = $from_data[ $section ];
			/**
			 * social media exception
			 */
			if ( 'social_media' === $section ) {
				if ( isset( $from_data['_social_media_sortable'] ) ) {
					$to_data['_social_media_sortable'] = $from_data['_social_media_sortable'];
				}
			}
			$result = ub_update_option( $to, $to_data );
			if ( $result ) {
				global $uba;
				$message = array(
					'class' => 'info',
					'message' => __( 'Section data was copied successfully.', 'ub' ),
				);
				$uba->add_message( $message );
			}
			return $result;
		}

		/**
		 * get boxes by current user and tab
		 *
		 * @since 1.8.9
		 */
		public function get_boxes() {
			$boxes = array();
			$user_id = get_current_user_id();
			$boxes = get_user_meta( $user_id, 'closedpostboxes_ultimate_branding', true );
			$tab = isset( $_REQUEST['tab'] )? $_REQUEST['tab']:'dashboard';
			if ( isset( $boxes[ $tab ] ) ) {
				$boxes = $boxes[ $tab ];
			}
			return $boxes;
		}

		/**
		 * get value of specyfic key
		 *
		 * @since 1.9.4
		 */
		private function get_single_value( $options, $input, $section, $field ) {
			$value = null;
			if ( isset( $input[ $section ] ) && isset( $input[ $section ][ $field ] ) ) {
				$value = $input[ $section ][ $field ];
			} else if (
				isset( $options[ $section ] )
				&& isset( $options[ $section ]['fields'] )
				&& isset( $options[ $section ]['fields'][ $field ] )
			) {
				if ( isset( $options[ $section ]['fields'][ $field ]['value'] ) ) {
					$value = $options[ $section ]['fields'][ $field ]['value'];
				} else if ( isset( $options[ $section ]['fields'][ $field ]['default'] ) ) {
					$value = $options[ $section ]['fields'][ $field ]['default'];
				}
			}
			/**
			 * skip value
			 */
			if (
				isset( $options[ $section ]['fields'][ $field ]['skip_value'] )
				&& $options[ $section ]['fields'][ $field ]['skip_value']
			) {
				$value = '';
			}
			return $value;
		}

		/**
		 * Enqueue custom jQuery UI css
		 */
		private function enqueue_jquery_style() {
			$key = 'ub-jquery-ui';
			if ( isset( $this->loaded[ $key ] ) ) {
				return;
			}
			wp_enqueue_style( $key, ub_url( 'assets/css/vendor/jquery-ui.min.css' ), array(), '1.12.1' );
			$this->loaded[ $key ] = true;
		}

		private function image( $section_key, $id, $images, $type ) {
			$output = array(
				'type' => $type,
				'images' => array(),
			);
			$add = empty( $images );;
			$content = '';
			foreach ( $images as $data ) {
				$image = isset( $data['value'] )? $data['value']:null;
				$image_id = $image_src = $disabled = '';
				if ( empty( $image ) ) {
					$image_id = 'time-'.time();
					$disabled = 'disabled';
					$add = false;
				} else if ( preg_match( '/^\d+$/', $image ) ) {
					$image_id = 'attachment-id-'.$image;
					$image_src = wp_get_attachment_image_url( $image );
					$add = true;
				} else if ( is_string( $image ) ) {
					$image_src = $image;
					$image_id = 'file-'.md5( $image );
					$add = true;
				}
				$output['images'][] = array(
					'id' => $id,
					'image_id' => $image_id,
					'section_key' => $section_key,
					'value' => $image,
					'image_src' => $image_src,
					'disabled' => $disabled,
				);
			}
			if ( $add && 'gallery' === $type ) {
				$output['images'][] = array(
					'id' => $id,
					'section_key' => $section_key,
					'disabled' => 'disabled',
				);
			}
			$content .= '<script type="text/javascript">';
			$content .= sprintf( '_ub_option_media_%s_%s', sanitize_title( $section_key ), sanitize_title( $id ) );
			$content .= '=';
			$content .= json_encode( $output );
			$content .= ';</script>';
			$content .= sprintf( '<div class="images" id="ub_option_media_%s_%s"></div>', esc_attr( $section_key ), esc_attr( $id ) );

			return $content;
		}

		public function add_media_template() {
?>
<script type="text/html" id="tmpl-simple-options-media">
    <div class="image-wrapper" data-id="{{{data.id}}}" data-section_key="{{{data.section_key}}}">
        <div class="image-preview-wrapper"><img class="image-preview" src="{{{data.image_src}}}" /></div>
        <a href="#" class="image-reset {{{data.disabled}}}"><?php esc_html_e( 'Remove', 'ub' ); ?></a>
        <input type="button" class="button button-select-image" value="<?php esc_attr_e( 'Browse', 'ub' ); ?>" />
        <input type="hidden" name="simple_options[{{{data.section_key}}}][{{{data.id}}}][]" value="{{{data.value}}}" class="attachment-id" />
    </div>
</script>
<?php
		}

		/**
		 * box title
		 *
		 * @since 2.1.0
		 */
		public function box_title( $title, $after = '' ) {
			$content = '';
			/**
			 * fold
			 */
			$content .= '<button type="button" class="handlediv button-link" aria-expanded="true">';
			$content .= '<span class="screen-reader-text">' . sprintf( __( 'Toggle panel: %s', 'ub' ), esc_html( $title ) ) . '</span>';
			$content .= '<span class="toggle-indicator" aria-hidden="true"></span>';
			$content .= '</button>';
			/**
			 * Section title
			 */
			$content .= sprintf( ' <h2 class="hndle">%s%s</h2>', $title, $after );
			return $content;
		}
	}
}