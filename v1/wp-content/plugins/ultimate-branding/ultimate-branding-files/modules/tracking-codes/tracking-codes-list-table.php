<?php
if ( ! class_exists( 'ub_tracking_codes_list_table' ) ) {
	if ( ! class_exists( 'WP_List_Table' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
	}
	class ub_tracking_codes_list_table extends WP_List_Table {
		private $url;
		private $ub_tracking_codes;
		private $options;

		/** ************************************************************************
		 * REQUIRED. Set up a constructor that references the parent constructor. We
		 * use the parent reference to set some default configs.
		 ***************************************************************************/
		public function __construct( $ub_tracking_codes ) {
			global $status, $page, $UB_network;
			$this->ub_tracking_codes = $ub_tracking_codes;
			$this->options = $ub_tracking_codes->get_options_for_single();
			//Set parent defaults
			parent::__construct( array(
				'singular'  => 'tracking-code',     //singular name of the listed records
				'plural'    => 'tracking-codes',    //plural name of the listed records
				'ajax'      => false,//does this table support ajax?
			) );
			$args = array(
				'page' => 'branding',
				'tab' => 'tracking-codes',
			);
			if ( $UB_network ) {
				$this->url = add_query_arg( $args, network_admin_url( 'admin.php' ) );
			} else {
				$this->url = add_query_arg( $args, admin_url( 'admin.php' ) );
			}
		}

		/** ************************************************************************
		 * Recommended. This method is called when the parent class can't find a method
		 * specifically build for a given column. Generally, it's recommended to include
		 * one method for each column you want to render, keeping your package class
		 * neat and organized. For example, if the class needs to process a column
		 * named 'tracking_title', it would first see if a method named $this->column_title()
		 * exists - if it does, that method will be used. If it doesn't, this one will
		 * be used. Generally, you should try to use custom column methods as much as
		 * possible.
		 *
		 * Since we have defined a column_title() method later on, this method doesn't
		 * need to concern itself with any column with a name of 'tracking_title'. Instead, it
		 * needs to handle everything else.
		 *
		 * For more detailed insight into how columns are handled, take a look at
		 * WP_List_Table::single_row_columns()
		 *
		 * @param array $item A singular item (one full row's worth of data)
		 * @param array $column_name The name/slug of the column to be processed
		 * @return string Text or HTML to be placed inside the column <td>
		 **************************************************************************/
		public function column_default( $item, $column_name ) {
			switch ( $column_name ) {
				default:
				return $column_name; //Show the whole array for troubleshooting purposes
			}
		}

		public function column_tracking_place( $item ) {
			if ( isset( $item['tracking_place'] ) ) {
				if ( isset( $this->options['tracking']['fields']['place']['options'][ $item['tracking_place'] ] ) ) {
					return $this->options['tracking']['fields']['place']['options'][ $item['tracking_place'] ];
				}
			}
			return __( 'Unknown', 'ub' );
		}

		public function column_filters_active( $item ) {
			$mask = '<span class="ub-filters ub-%s">%s</span>';
			if ( isset( $item['filters_active'] ) && 'on' === $item['filters_active'] ) {
				return sprintf( $mask, 'active', esc_html__( 'Yes', 'ub' ) );
			}
			return sprintf( $mask, 'inactive', esc_html__( 'No', 'ub' ) );
		}

		public function column_tracking_active( $item ) {
			$mask = '<span class="ub-tracking ub-%s">%s</span>';
			if ( isset( $item['tracking_active'] ) && 'on' === $item['tracking_active'] ) {
				return sprintf( $mask, 'active', esc_html__( 'Yes', 'ub' ) );
			}
			return sprintf( $mask, 'inactive', esc_html__( 'No', 'ub' ) );
		}

		/** ************************************************************************
		 * Recommended. This is a custom column method and is responsible for what
		 * is rendered in any column with a name/slug of 'tracking_title'. Every time the class
		 * needs to render a column, it first looks for a method named
		 * column_{$column_title} - if it exists, that method is run. If it doesn't
		 * exist, column_default() is called instead.
		 *
		 * This example also illustrates how to implement rollover actions. Actions
		 * should be an associative array formatted as 'slug'=>'link html' - and you
		 * will need to generate the URLs yourself. You could even ensure the links
		 *
		 *
		 * @see WP_List_Table::::single_row_columns()
		 * @param array $item A singular item (one full row's worth of data)
		 * @return string Text to be placed inside the column <td> (movie title only)
		 **************************************************************************/
		public function column_tracking_title( $item ) {
			$url = add_query_arg( 'id', $item['tracking_id'], $this->url );
			//Build row actions
			$actions = array(
				'edit' => sprintf(
					'<a href="%s">%s</a>',
					add_query_arg( 'ub_tc_action', 'edit', $url ),
					esc_html__( 'Edit', 'ub' )
				),
			);
			/**
			 * status
			 */
			if ( isset( $item['tracking_active'] ) && 'on' === $item['tracking_active'] ) {
				$actions['deactivate'] = sprintf(
					'<a href="%s">%s</a>',
					wp_nonce_url(
						add_query_arg( 'ub_tc_action', 'deactivate', $url ),
						$this->ub_tracking_codes->get_nonce_name( $item['tracking_id'], 'deactivate' )
					),
					esc_html__( 'Deactivate', 'ub' )
				);
			} else {
				$actions['activate'] = sprintf(
					'<a href="%s">%s</a>',
					wp_nonce_url(
						add_query_arg( 'ub_tc_action', 'activate', $url ),
						$this->ub_tracking_codes->get_nonce_name( $item['tracking_id'], 'activate' )
					),
					esc_html__( 'Activate', 'ub' )
				);
			}
			/**
			 * duplicate
			 */
			$actions['duplicate'] = sprintf(
				'<a href="%s">%s</a>',
				wp_nonce_url(
					add_query_arg( 'ub_tc_action', 'duplicate', $url ),
					$this->ub_tracking_codes->get_nonce_name( $item['tracking_id'], 'duplicate' )
				),
				esc_html__( 'Duplicate', 'ub' )
			);
			/**
			 * delete
			 */
			$actions['delete'] = sprintf(
				'<a href="%s">%s</a>',
				wp_nonce_url(
					add_query_arg( 'ub_tc_action', 'delete', $url ),
					$this->ub_tracking_codes->get_nonce_name( $item['tracking_id'], 'delete' )
				),
				esc_html__( 'Delete', 'ub' )
			);
			//Return the title contents
			return sprintf('%1$s %2$s',
				/*$1%s*/ empty( $item['tracking_title'] )? __( '[not set]', 'ub' ):$item['tracking_title'],
				/*$2%s*/ $this->row_actions( $actions )
			);
		}

		/** ************************************************************************
		 * REQUIRED if displaying checkboxes or using bulk actions! The 'cb' column
		 * is given special treatment when columns are processed. It ALWAYS needs to
		 * have it's own method.
		 *
		 * @see WP_List_Table::::single_row_columns()
		 * @param array $item A singular item (one full row's worth of data)
		 * @return string Text to be placed inside the column <td> (movie title only)
		 **************************************************************************/
		public function column_cb( $item ) {
			return sprintf(
				'<input type="checkbox" name="%1$s[]" value="%2$s" />',
				/*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
				/*$2%s*/ $item['tracking_id']                //The value of the checkbox should be the record's id
			);
		}

		/** ************************************************************************
		 * REQUIRED! This method dictates the table's columns and titles. This should
		 * return an array where the key is the column slug (and class) and the value
		 * is the column's title text. If you need a checkbox for bulk actions, refer
		 * to the $columns array below.
		 *
		 * The 'cb' column is treated differently than the rest. If including a checkbox
		 * column in your table you must create a column_cb() method. If you don't need
		 * bulk actions or checkboxes, simply leave the 'cb' entry out of your array.
		 *
		 * @see WP_List_Table::::single_row_columns()
		 * @return array An associative array containing column information: 'slugs'=>'Visible Titles'
		 **************************************************************************/
		public function get_columns() {
			$columns = array(
				'cb'        => '<input type="checkbox" />', //Render a checkbox instead of text
				'tracking_title'     => __( 'Title', 'ub' ),
				'tracking_active' => __( 'Active', 'ub' ),
				'tracking_place' => __( 'Target', 'ub' ),
				'filters_active' => __( 'Filters', 'ub' ),
			);
			return $columns;
		}

		/** ************************************************************************
		 * Optional. If you want one or more columns to be sortable (ASC/DESC toggle),
		 * you will need to register it here. This should return an array where the
		 * key is the column that needs to be sortable, and the value is db column to
		 * sort by. Often, the key and value will be the same, but this is not always
		 * the case (as the value is a column name from the database, not the list table).
		 *
		 * This method merely defines which columns should be sortable and makes them
		 * clickable - it does not handle the actual sorting. You still need to detect
		 * the ORDERBY and ORDER querystring variables within prepare_items() and sort
		 * your data accordingly (usually by modifying your query).
		 *
		 * @return array An associative array containing all the columns that should be sortable: 'slugs'=>array('data_values',bool)
		 **************************************************************************/
		public function get_sortable_columns() {
			$sortable_columns = array(
				'tracking_title'     => array( 'tracking_title',false ),     //true means it's already sorted
			);
			return $sortable_columns;
		}

		/** ************************************************************************
		 * Optional. If you need to include bulk actions in your list table, this is
		 * the place to define them. Bulk actions are an associative array in the format
		 * 'slug'=>'Visible Title'
		 *
		 * If this method returns an empty value, no bulk action will be rendered. If
		 * you specify any bulk actions, the bulk actions box will be rendered with
		 * the table automatically on display().
		 *
		 * Also note that list tables are not automatically wrapped in <form> elements,
		 * so you will need to create those manually in order for bulk actions to function.
		 *
		 * @return array An associative array containing all the bulk actions: 'slugs'=>'Visible Titles'
		 **************************************************************************/
		public function get_bulk_actions() {
			$actions = array(
				'activate' => __( 'Activate', 'ub' ),
				'deactivate' => __( 'Deactivate', 'ub' ),
				'delete' => __( 'Delete', 'ub' ),
				'duplicate' => __( 'Duplicate', 'ub' ),
			);
			return $actions;
		}

		/** ************************************************************************
		 * Optional. You can handle your bulk actions anywhere or anyhow you prefer.
		 * For this example package, we will handle it in the class to keep things
		 * clean and organized.
		 *
		 * @see $this->prepare_items()
		 **************************************************************************/
		public function process_bulk_action() {
			global $uba;
			$ids = $names = array();
			if ( isset( $_POST[ $this->_args['singular'] ] ) && is_array( $_POST[ $this->_args['singular'] ] ) ) {
				$ids = $_POST[ $this->_args['singular'] ];
			}
			if ( empty( $ids ) ) {
				return;
			}
			$message = '';
			$update = true;
			$value = $this->ub_tracking_codes->local_get_value();
			$action = $this->current_action();
			switch ( $action ) {
				case 'activate':
					foreach ( $ids as $id ) {
						if ( isset( $value[ $id ] ) ) {
							$value[ $id ]['tracking_active'] = 'on';
							$names[] = $value[ $id ]['tracking_title'];
						}
					}
					$message = esc_html__( 'Tracking Codes: %s was activated.', 'ub' );
				break;
				case 'deactivate':
					foreach ( $ids as $id ) {
						if ( isset( $value[ $id ] ) ) {
							$value[ $id ]['tracking_active'] = 'off';
							$names[] = $value[ $id ]['tracking_title'];
						}
					}
					$message = esc_html__( 'Tracking Codes: %s was deactivated.', 'ub' );
				break;
				case 'duplicate':
					foreach ( $ids as $id ) {
						if ( isset( $value[ $id ] ) ) {
							$names[] = $value[ $id ]['tracking_title'];
							$one = $value[ $id ];
							$one['tracking_title'] .= esc_html__( ' (copy)', 'ub' );
							$one['tracking_active'] = 'off';
							$new_id = md5( serialize( $one ) . time() );
							$one['tracking_id'] = $new_id;
							$value[ $new_id ] = $one;
						}
					}
					$message = esc_html__( 'Tracking Codes: %s was duplicated. New codes are inactive.', 'ub' );
				break;
				case 'delete':
					foreach ( $ids as $id ) {
						if ( isset( $value[ $id ] ) ) {
							$names[] = $value[ $id ]['tracking_title'];
							unset( $value[ $id ] );
						}
					}
					$message = esc_html__( 'Tracking Codes: %s was deleted', 'ub' );
				break;
				default:
					$update = false;
			}
			if ( $update ) {
				$this->ub_tracking_codes->local_update_value( $value );
				if ( ! empty( $names ) && ! empty( $message ) ) {
					$message = array(
						'class' => 'success inline',
						'message' => sprintf(
							$message,
							implode( ', ', array_map( array( $this, 'bold' ), $names ) )
						),
					);
					$uba->add_message( $message );
				}
			}
		}

		private function bold( $a ) {
			return sprintf( '<b>%s</b>', $a );
		}

		/** ************************************************************************
		 * REQUIRED! This is where you prepare your data for display. This method will
		 * usually be used to query the database, sort and filter the data, and generally
		 * get it ready to be displayed. At a minimum, we should set $this->items and
		 * $this->set_pagination_args(), although the following properties and methods
		 * are frequently interacted with here...
		 *
		 * @global WPDB $wpdb
		 * @uses $this->_column_headers
		 * @uses $this->items
		 * @uses $this->get_columns()
		 * @uses $this->get_sortable_columns()
		 * @uses $this->get_pagenum()
		 * @uses $this->set_pagination_args()
		 **************************************************************************/
		public function prepare_items() {
			global $wpdb; //This is used only if making any database queries
			/**
			 * First, lets decide how many records per page to show
			 */
			$per_page = 20;
			/**
			 * REQUIRED. Now we need to define our column headers. This includes a complete
			 * array of columns to be displayed (slugs & titles), a list of columns
			 * to keep hidden, and a list of columns that are sortable. Each of these
			 * can be defined in another method (as we've done here) before being
			 * used to build the value for our _column_headers property.
			 */
			$columns = $this->get_columns();
			$hidden = array();
			$sortable = $this->get_sortable_columns();
			/**
			 * REQUIRED. Finally, we build an array to be used by the class for column
			 * headers. The $this->_column_headers property takes an array which contains
			 * 3 other arrays. One for all columns, one for hidden columns, and one
			 * for sortable columns.
			 */
			$this->_column_headers = array( $columns, $hidden, $sortable );
			/**
			 * Optional. You can handle your bulk actions however you see fit. In this
			 * case, we'll handle them within our package just to keep things clean.
			 */
			$this->process_bulk_action();
			/**
			 * Instead of querying a database, we're going to fetch the example data
			 * property we created for use in this plugin. This makes this example
			 * package slightly different than one you might build on your own. In
			 * this example, we'll be using array manipulation to sort and paginate
			 * our data. In a real-world implementation, you will probably want to
			 * use sort and pagination data to build a custom query instead, as you'll
			 * be able to use your precisely-queried data immediately.
			 */
			$data = $this->ub_tracking_codes->local_get_value();
			/**
			 * This checks for sorting input and sorts the data in our array accordingly.
			 *
			 * In a real-world situation involving a database, you would probably want
			 * to handle sorting by passing the 'orderby' and 'order' values directly
			 * to a custom query. The returned data will be pre-sorted, and this array
			 * sorting technique would be unnecessary.
			 */
			function usort_reorder( $a, $b ) {
				$orderby = ( ! empty( $_REQUEST['orderby'] )) ? $_REQUEST['orderby'] : 'tracking_title'; //If no sort, default to title
				$order = ( ! empty( $_REQUEST['order'] )) ? $_REQUEST['order'] : 'asc'; //If no order, default to asc
				$result = strcmp( $a[ $orderby ], $b[ $orderby ] ); //Determine sort order
				return ($order === 'asc') ? $result : -$result; //Send final sort direction to usort
			}
			usort( $data, 'usort_reorder' );
			/***********************************************************************
             * ---------------------------------------------------------------------
             * vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
             *
             * In a real-world situation, this is where you would place your query.
             *
             * For information on making queries in WordPress, see this Codex entry:
             * http://codex.wordpress.org/Class_Reference/wpdb
             *
             * ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
             * ---------------------------------------------------------------------
             **********************************************************************/
			/**
			 * REQUIRED for pagination. Let's figure out what page the user is currently
			 * looking at. We'll need this later, so you should always include it in
			 * your own package classes.
			 */
			$current_page = $this->get_pagenum();
			/**
			 * REQUIRED for pagination. Let's check how many items are in our data array.
			 * In real-world use, this would be the total number of items in your database,
			 * without filtering. We'll need this later, so you should always include it
			 * in your own package classes.
			 */
			$total_items = count( $data );
			/**
			 * The WP_List_Table class does not handle pagination for us, so we need
			 * to ensure that the data is trimmed to only the current page. We can use
			 * array_slice() to
			 */
			$data = array_slice( $data,(($current_page -1) * $per_page),$per_page );
			/**
			 * REQUIRED. Now we can add our *sorted* data to the items property, where
			 * it can be used by the rest of the class.
			 */
			$this->items = $data;
			/**
			 * REQUIRED. We also have to register our pagination options & calculations.
			 */
			$this->set_pagination_args( array(
				'total_items' => $total_items,                  //WE have to calculate the total number of items
				'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
				'total_pages' => ceil( $total_items / $per_page ),//WE have to calculate the total number of pages
			) );
		}
	}
}