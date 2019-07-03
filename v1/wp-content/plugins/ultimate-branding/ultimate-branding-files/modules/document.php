<?php
/**
 *
 * @since 2.3.0
 */
if ( ! class_exists( 'ub_document' ) ) {
	class ub_document extends ub_helper {

		protected $option_name  = __CLASS__;

		public function __construct() {
			parent::__construct();
			$this->set_options();
			/**
			 * UB admin actions
			 */
			add_action( 'ultimatebranding_settings_document', array( $this, 'admin_options_page' ) );
			add_filter( 'ultimatebranding_settings_document_process', array( $this, 'update' ) );
			add_action( 'ultimatebranding_deactivate_plugin', array( $this, 'delete_user_data' ) );
			/**
			 * front end
			 */
			add_filter( 'the_content', array( $this, 'the_content' ), PHP_INT_MAX );
			add_filter( 'shortcode_atts_gallery', array( $this, 'shortcode_atts_gallery' ), PHP_INT_MAX, 4 );
		}

		/**
		 * change entry content
		 *
		 * @since 2.3.0
		 */
		public function the_content( $content ) {
			/**
			 * do not change on entries lists
			 */
			if ( ! is_singular() ) {
				return $content;
			}
			/**
			 * entry header
			 */
			$add = $this->get_value( 'configuration', 'entry_header', 'off' );
			if ( 'on' === $add ) {
				$value = $this->get_value( 'entry_header', 'content_meta', '' );
				$content = $value.$content;
			}
			/**
			 * entry footer
			 */
			$add = $this->get_value( 'configuration', 'entry_footer', 'off' );
			if ( 'on' === $add ) {
				$value = $this->get_value( 'entry_footer', 'content_meta', '' );
				$content .= $value;
			}
			return $content;
		}

		/**
		 * change shortcode gallery attributes
		 *
		 * @since 2.3.0
		 */
		public function shortcode_atts_gallery( $out, $pairs, $atts, $shortcode ) {
			$change = $this->get_value( 'configuration', 'shortcode_gallery', 'off' );
			if ( 'off' === $change ) {
				return $out;
			}
			$values = $this->get_value( 'shortcode_gallery' );
			foreach ( $values as $key => $value ) {
				if ( 'do-not-change' === $value ) {
					continue;
				}
				/**
				 * exception for link
				 */
				if ( 'link' === $key && 'attachment' === $value ) {
					$value = '';
				}
				$out[ $key ] = $value;
			}
			return $out;
		}

		/**
		 * set options
		 *
		 * @since 2.3.0
		 */
		protected function set_options() {
			global $UB_network;
			$this->module = 'document';
			$data = array(
				'configuration' => array(
					'title' => __( 'Configuration', 'ub' ),
					'fields' => array(
						'entry_header' => array(
							'type' => 'checkbox',
							'label' => __( 'Before Entry Content', 'ub' ),
							'description' => __( 'Enable to add text before entry content.', 'ub' ),
							'options' => array(
								'on' => __( 'On', 'ub' ),
								'off' => __( 'Off', 'ub' ),
							),
							'default' => 'off',
							'classes' => array( 'switch-button' ),
						),
						'entry_footer' => array(
							'type' => 'checkbox',
							'label' => __( 'After Entry Content', 'ub' ),
							'description' => __( 'Enable to add text after entry content.', 'ub' ),
							'options' => array(
								'on' => __( 'On', 'ub' ),
								'off' => __( 'Off', 'ub' ),
							),
							'default' => 'off',
							'classes' => array( 'switch-button' ),
						),
						'shortcode_gallery' => array(
							'type' => 'checkbox',
							'label' => __( 'Shortcode [gallery]', 'ub' ),
							'description' => __( 'Enable to change defaults for [gallery] shortcode.', 'ub' ),
							'options' => array(
								'on' => __( 'On', 'ub' ),
								'off' => __( 'Off', 'ub' ),
							),
							'default' => 'off',
							'classes' => array( 'switch-button' ),
						),
					),
				),
				'entry_header' => array(
					'title' => __( 'Before Entry Content', 'ub' ),
					'fields' => array(
						'content' => array(
							'type' => 'wp_editor',
							'label' => __( 'Content', 'ub' ),
						),
					),
					'master' => array(
						'section' => 'configuration',
						'field' => 'entry_header',
						'value' => 'on',
					),
				),
				'entry_footer' => array(
					'title' => __( 'After Entry Content', 'ub' ),
					'fields' => array(
						'content' => array(
							'type' => 'wp_editor',
							'label' => __( 'Content', 'ub' ),
						),
					),
					'master' => array(
						'section' => 'configuration',
						'field' => 'entry_footer',
						'value' => 'on',
					),
				),
				'shortcode_gallery' => array(
					'title' => __( 'Shortcode [gallery]', 'ub' ),
					'description' => __( 'Detailed description of gallery shortcode option you can find on the Codex page: <a href="https://codex.wordpress.org/Gallery_Shortcode" target="_blank">Gallery Shortcode</a>.', 'ub' ),
					'fields' => array(
						'orderby' => array(
							'type' => 'radio',
							'label' => __( 'Sort By', 'ub' ),
							'options' => array(
								'do-not-change' => __( 'Do not change', 'ub' ),
								'menu_order' => __( 'Images order set in gallery tab (WP default)', 'ub' ),
								'title' => __( 'Title of image', 'ub' ),
								'post_date' => __( 'Date/time', 'ub' ),
								'rand' => __( 'Randomly', 'ub' ),
								'ID' => __( 'ID of image', 'ub' ),
							),
							'default' => 'do-not-change',
							'description' => __( 'Specify how to sort the display thumbnails.', 'ub' ),
						),
						'order' => array(
							'type' => 'radio',
							'label' => __( 'Sort Order', 'ub' ),
							'options' => array(
								'do-not-change' => __( 'Do not change', 'ub' ),
								'ASC' => __( 'Ascendent (WP default)', 'ub' ),
								'DESC' => __( 'Descended', 'ub' ),
							),
							'default' => 'do-not-change',
							'description' => __( 'Specify the sort order used to display thumbnails.', 'ub' ),
						),
						'columns' => array(
							'type' => 'number',
							'label' => __( 'Columns', 'ub' ),
							'min' => 0,
							'description' => __( 'Specify the number of columns. The gallery will include a break tag at the end of each row, and calculate the column width as appropriate. The default value is 3. If columns is set to 0, no row breaks will be included. ', 'ub' ),
							'default' => 3,
						),
						'size' => array(
							'type' => 'radio',
							'label' => __( 'Thumbnail Size', 'ub' ),
							'options' => array(
								'do-not-change' => __( 'Do not change', 'ub' ),
								'thumbnail' => __( 'Thumbnail (WP default)', 'ub' ),
								'medium' => __( 'Medium', 'ub' ),
								'large' => __( 'Large', 'ub' ),
								'full' => __( 'Full', 'ub' ),
							),
							'default' => 'do-not-change',
							'description' => __( 'Specify the image size to use for the thumbnail display.', 'ub' ),
						),
						'link' => array(
							'type' => 'radio',
							'label' => __( 'Thumbnail Link', 'ub' ),
							'options' => array(
								'do-not-change' => __( 'Do not change', 'ub' ),
								'attachment' => __( 'Attachment page (WP default)', 'ub' ),
								'file' => __( 'Link directly to image file', 'ub' ),
								'none' => __( 'No link', 'ub' ),
							),
							'default' => 'do-not-change',
							'description' => __( 'Specify where you want the image to link.', 'ub' ),
						),
						'itemtag' => array(
							'type' => 'text',
							'label' => __( 'Item Tag', 'ub' ),
							'default' => 'dl',
							'description' => __( 'The name of the XHTML tag used to enclose each item in the gallery.', 'ub' ),
						),
						'icontag' => array(
							'type' => 'text',
							'label' => __( 'Icon Tag', 'ub' ),
							'default' => 'dt',
							'description' => __( 'The name of the XHTML tag used to enclose each thumbnail icon in the gallery.', 'ub' ),
						),
						'captiontag' => array(
							'type' => 'text',
							'label' => __( 'Caption Tag', 'ub' ),
							'default' => 'dd',
							'description' => __( 'The name of the XHTML tag used to enclose each caption.', 'ub' ),
						),
					),
					'master' => array(
						'section' => 'configuration',
						'field' => 'shortcode_gallery',
						'value' => 'on',
					),
				),
			);
			if ( false === $UB_network ) {
				global $_wp_additional_image_sizes;
				if ( is_array( $_wp_additional_image_sizes ) ) {
					foreach ( array_keys( $_wp_additional_image_sizes ) as $name ) {
						$data['shortcode_gallery']['fields']['size']['options'][ $name ] = ucwords( preg_replace( '/[-_]+/', ' ', $name ) );
					}
				}
			}
			$this->options = $data;
		}
	}
}
/**
 * Kick start the module
 */
new ub_document;