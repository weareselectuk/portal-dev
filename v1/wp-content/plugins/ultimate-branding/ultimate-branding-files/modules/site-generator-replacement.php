<?php
class ub_site_generator_replacement {

	var $site_generator_replacement_settings_page;
	var $site_generator_replacement_settings_page_long;

	function __construct() {
		add_action( 'ultimatebranding_settings_sitegenerator', array( &$this, 'site_generator_replacement_site_admin_options' ) );
		add_filter( 'ultimatebranding_settings_sitegenerator_process', array( &$this, 'update_site_generator_replacement_site_admin_options' ), 10, 1 );

		add_filter( 'get_the_generator_html', array( &$this, 'site_generator_replacement_content' ), 99, 2 );
		add_filter( 'get_the_generator_xhtml', array( &$this, 'site_generator_replacement_content' ), 99, 2 );
		add_filter( 'get_the_generator_atom', array( &$this, 'site_generator_replacement_content' ), 99, 2 );
		add_filter( 'get_the_generator_rss2', array( &$this, 'site_generator_replacement_content' ), 99, 2 );
		add_filter( 'get_the_generator_rdf', array( &$this, 'site_generator_replacement_content' ), 99, 2 );
		add_filter( 'get_the_generator_comment', array( &$this, 'site_generator_replacement_content' ), 99, 2 );
		add_filter( 'get_the_generator_export', array( &$this, 'site_generator_replacement_content' ), 99, 2 );
		/**
		 * export
		 */
		add_filter( 'ultimate_branding_export_data', array( $this, 'export' ) );
		/**
		 * add options names
		 *
		 * @since 2.1.0
		 */
		add_filter( 'ultimate_branding_options_names', array( $this, 'add_options_names' ) );
	}

	/**
	 * Add option names
	 *
	 * @since 2.1.0
	 */
	public function add_options_names( $options ) {
		$options[] = 'site_generator_replacement';
		$options[] = 'site_generator_replacement_link';
		return $options;
	}

	function site_generator_replacement_content( $gen, $type ) {
		if ( is_multisite() ) {
			$current_site = get_current_site();
		} else {
			$current_site = new stdClass();
			$current_site->site_name = get_bloginfo( 'name' );
			$current_site->domain = get_bloginfo( 'url' );
			$current_site->path = '';
		}

		$global_site_generator = ub_get_option( 'site_generator_replacement' );
		$global_site_link = ub_get_option( 'site_generator_replacement_link' );

		if ( empty( $global_site_generator ) ) {
			$global_site_generator = $current_site->site_name;
		}

		if ( empty( $global_site_link ) ) {
			$global_site_link = 'http://' . $current_site->domain . $current_site->path;
		}

		switch ( $type ) {
			case 'html':
				$gen = '<meta name="generator" content="' . $global_site_generator . '">' . "\n";
			break;
			case 'xhtml':
				$gen = '<meta name="generator" content="' . $global_site_generator . '" />' . "\n";
			break;
			case 'atom':
				$gen = '<generator uri="' . $global_site_link . '" version="' . get_bloginfo_rss( 'version' ) . '">' . $global_site_generator . '</generator>';
			break;
			case 'rss2':
				$gen = '<generator>' . $global_site_link . '?v=' . get_bloginfo_rss( 'version' ) . '</generator>';
			break;
			case 'rdf':
				$gen = '<admin:generatorAgent rdf:resource="' . $global_site_link . '?v=' . get_bloginfo_rss( 'version' ) . '" />';
			break;
			case 'comment':
				$gen = '<!-- generator="' . $global_site_generator . '/' . get_bloginfo( 'version' ) . '" -->';
			break;
			case 'export':
				$gen = '<!-- generator="' . $global_site_generator . '/' . get_bloginfo_rss( 'version' ) . '" created="' . date( 'Y-m-d H:i' ) . '"-->';
			break;
		}
		return $gen;
	}

	function update_site_generator_replacement_site_admin_options( $status ) {

		ub_update_option( 'site_generator_replacement', $_POST['site_generator_replacement'] );
		ub_update_option( 'site_generator_replacement_link', $_POST['site_generator_replacement_link'] );

		if ( $status === false ) {
			return $status;
		} else {
			return true;
		}
	}

	function site_generator_replacement_site_admin_options() {

		global $wpdb, $wp_roles, $current_user;

		$global_site_generator = ub_get_option( 'site_generator_replacement' );
		$global_site_link = ub_get_option( 'site_generator_replacement_link' );

		if ( is_multisite() ) {
			$current_site = get_current_site();
		} else {
			$current_site = new stdClass();

			$current_site->site_name = get_bloginfo( 'name' );
			$current_site->domain = get_bloginfo( 'url' );
			$current_site->path = '';
		}

		if ( empty( $global_site_generator ) ) {
			$global_site_generator = $current_site->site_name;
		}
		if ( empty( $global_site_link ) ) {
			$global_site_link = 'http://' . $current_site->domain . $current_site->path;
		}
?>
        <div class="postbox">
            <h3 class="hndle" style='cursor:auto;'><span><?php _e( 'Site Generator Options', 'ub' ) ?></span></h3>
            <div class="inside">
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">
                            <?php _e( 'Generator Text', 'ub' ) ?>
                        </th>
                        <td>
                            <input type="text" name="site_generator_replacement" id="site_generator_replacement" style="width: 95%" value="<?php echo stripslashes( $global_site_generator ); ?>" />
                            <p class="description"><?php _e( 'Change the "generator" information from WordPress to something you prefer.', 'ub' ); ?></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <?php _e( 'Generator Link', 'ub' ) ?>
                        </th>
                        <td>
                            <input type="text" name="site_generator_replacement_link" id="site_generator_replacement_link" style="width: 95%" value="<?php echo stripslashes( $global_site_link ); ?>" />
                            <p class="description"><?php _e( 'Change the "generator link" from WordPress to something you prefer.', 'ub' ); ?></p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
<?php
	}

	/**
	 * Export data.
	 *
	 * @since 1.8.6
	 */
	public function export( $data ) {
		$this->add_options_names( $options = array() );
		foreach ( $options as $key ) {
			$data['modules'][ $key ] = ub_get_option( $key );
		}
		return $data;
	}
}

new ub_site_generator_replacement();
