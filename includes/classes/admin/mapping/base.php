<?php
/**
 * GatherContent Plugin
 *
 * @package GatherContent Plugin
 */

namespace GatherContent\Importer\Admin\Mapping;

use GatherContent\Importer\Base as Plugin_Base;

/**
 * Class for managing syncing template items.
 *
 * @since 3.0.0
 */
abstract class Base extends Plugin_Base {

	/**
	 * The mapping ID.
	 *
	 * @var integer
	 */
	protected $mapping_id = 0;

	/**
	 * The Account ID.
	 *
	 * @var integer
	 */
	protected $account_id;

	/**
	 * The Account Slug.
	 *
	 * @var integer
	 */
	protected $account_slug;

	/**
	 * The Project ID.
	 *
	 * @var integer
	 */
	protected $project;

	/**
	 * The Template ID.
	 *
	 * @var integer
	 */
	protected $template;

	/**
	 * The Structure UUID.
	 *
	 * @var string
	 */
	protected $structure_uuid;

	/**
	 * Constructor
	 *
	 * @param array $args Arguments.
	 *
	 * @since 3.0.0
	 *
	 */
	public function __construct( array $args ) {
		$this->mapping_id     = $args['mapping_id'];
		$this->account_id     = $args['account_id'];
		$this->account_slug   = $args['account_slug'];
		$this->project        = $args['project'];
		$this->template       = $args['template'];
		$this->structure_uuid = $args['structure_uuid'];
	}

	/**
	 * The page-specific script ID to enqueue.
	 *
	 * @return string
	 * @since  3.0.0
	 *
	 */
	abstract protected function script_id();

	/**
	 * The page-specific Form_Section section UI callback.
	 *
	 * @return void
	 * @since  3.0.0
	 *
	 */
	abstract protected function ui_page();

	/**
	 * Get the localizable data array.
	 *
	 * @return array Array of localizable data
	 * @since  3.0.0
	 *
	 */
	abstract protected function get_localize_data();

	/**
	 * Gets the underscore templates array.
	 *
	 * @return array
	 * @since  3.0.0
	 *
	 */
	abstract protected function get_underscore_templates();

	/**
	 * The Form_Section section UI callback.
	 *
	 * @return void
	 * @since  3.0.0
	 *
	 */
	public function ui() {
		if ( false === $this->ui_page() ) {
			return;
		}

		// Hook in the underscores templates.
		add_action( 'admin_footer', array( $this, 'footer_mapping_js_templates' ) );

		add_filter( 'cwby_localized_data', array( $this, 'localize_data' ) );

		$script_id = $this->script_id();

		wp_enqueue_style( 'wp-pointer' );
		\GatherContent\Importer\enqueue_script( $script_id, $script_id, array( 'wp-pointer', 'gathercontent' ) );
	}

	/**
	 * Output the underscore templates in the footer.
	 *
	 * @return void
	 * @since  3.0.0
	 *
	 */
	public function footer_mapping_js_templates() {
		foreach ( $this->get_underscore_templates() as $template_id => $view_args ) {
			echo '<script type="text/html" id="' . esc_attr( $template_id ) . '">';
			$this->view( $template_id, $view_args );
			echo '</script>';
		}
	}

	/**
	 * Add to the localized data array.
	 *
	 * @param array $data Array of localizable data.
	 *
	 * @return array       Modified array of data.
	 * @since  3.0.0
	 *
	 */
	public function localize_data( $data ) {
		return array_merge( $data, $this->get_localize_data() );
	}

	/**
	 * Get's the default <select> options for a Post column.
	 *
	 * @param string $col Post column.
	 *
	 * @return array       Array of <select> options.
	 * @since  3.0.0
	 *
	 */
	protected function get_default_field_options( $col ) {
		$select_options = array();

		switch ( $col ) {
			case 'post_author':
				$value          = 1;
				$user           = $this->get_value( 'post_author' )
					? get_user_by( 'id', absint( $this->get_value( 'post_author' ) ) )
					: wp_get_current_user();
				$select_options = $user->user_login;
				break;
			case 'post_status':
				$select_options = array(
					'publish'  => __( 'Published', 'content-workflow-by-bynder' ),
					'draft'    => __( 'Draft', 'content-workflow-by-bynder' ),
					'pending'  => __( 'Pending', 'content-workflow-by-bynder' ),
					'private'  => __( 'Private', 'content-workflow-by-bynder' ),
					'nochange' => __( 'Do not change', 'content-workflow-by-bynder' ),
				);
				break;
			case 'post_type':
				foreach ( $this->post_types() as $type ) {
					$select_options[ $type->name ] = $type->labels->singular_name;
				}
				break;
		}

		return $select_options;
	}

	/**
	 * Gets the columns from the posts table for the <select> option.
	 *
	 * @return array Array of <select> options.
	 * @since  3.0.0
	 *
	 */
	protected function post_options() {
		static $options = null;

		if ( null !== $options ) {
			return $options;
		}

		global $wpdb;

		$options      = array();
		$table_name   = $wpdb->prefix . 'posts';
		$post_columns = $wpdb->get_col( "DESC {$wpdb->prefix}posts", 0 );

		foreach ( $post_columns as $col ) {
			if ( ! $this->post_column_option_is_blacklisted( $col ) ) {
				$options[ $col ] = $this->post_column_label( $col );
			}
		}

		return $options;
	}

	/**
	 * Gets a list of unique keys from the postmeta table. Value is cached for a day.
	 *
	 * @return array Array of keys to be used in a backbone collection.
	 * @since  3.0.0
	 *
	 */
	protected function custom_field_keys() {
		global $wpdb;

		$meta_keys = get_transient( 'cwby_importer_custom_field_keys' );

		if ( ! $meta_keys || $this->_get_val( 'delete-trans' ) ) {
			// Retrieve custom field keys to include in the Custom Fields weight table select.
			$meta_keys = $wpdb->get_col(
				"
				SELECT meta_key
				FROM $wpdb->postmeta
				WHERE meta_key NOT LIKE '_oembed_%'
				GROUP BY meta_key
			"
			);

			set_transient( 'cwby_importer_custom_field_keys', $meta_keys, DAY_IN_SECONDS );
		}

		// Allow devs to filter this list.
		$meta_keys = array_unique( apply_filters( 'cwby_importer_custom_field_keys', $meta_keys ) );

		// Sort the keys alphabetically.
		if ( $meta_keys ) {
			natcasesort( $meta_keys );
		} else {
			$meta_keys = array();
		}

		/**
		 * Fields which should not be shown in the UI for meta-keys.
		 *
		 * @var array
		 */
		$meta_keys_blacklist = apply_filters(
			'cwby_importer_custom_field_keys_blacklist',
			array(
				'_wp_attachment_image_alt' => 1,
				'_wp_attachment_metadata'  => 1,
				'_wp_attached_file'        => 1,
				'_edit_lock'               => 1,
				'_edit_last'               => 1,
				'_thumbnail_id'            => 1,
				'_wp_page_template'        => 1,
				'_gc_account'              => 1,
				'_gc_account_id'           => 1,
				'_gc_project'              => 1,
				'_gc_template'             => 1,
				'_gc_pull_items'           => 1,
				'_gc_push_items'           => 1,
				'_gc_mapped_item_id'       => 1,
				'_gc_mapping_id'           => 1,
				'_gc_mapped_meta'          => 1,
				// legacy.
				'gc_file_id'               => 1,
			)
		);

		$keys = array();
		foreach ( array_values( $meta_keys ) as $column ) {
			if ( ! isset( $meta_keys_blacklist[ $column ] ) ) {
				$keys[] = array( 'value' => $column );
			}
		}

		return $keys;
	}

	/**
	 * Only allow a certain set of post-table columns to be mappable .
	 *
	 * @param string $col Post table column.
	 *
	 * @return bool        Whether column passed the blacklist check.
	 * @since  3.0.0
	 *
	 */
	protected function post_column_option_is_blacklisted( $col ) {
		return in_array(
			$col,
			array(
				'ID',
				'to_ping',
				'pinged',
				'post_mime_type',
				'comment_count',
				'post_content_filtered',
				'guid',
				'post_type',
				'post_type',
			),
			true
		);
	}

	/**
	 * Maps the post-table's column names to a human-readable value.
	 *
	 * @param string $col Post table column.
	 *
	 * @return string      Human readable value if we have one.
	 * @since  3.0.0
	 *
	 */
	protected function post_column_label( $col ) {
		switch ( $col ) {
			case 'ID':
				return __( 'Author', 'content-workflow-by-bynder' );
			case 'post_author':
				return __( 'Author', 'content-workflow-by-bynder' );
			case 'post_date':
				return __( 'Post Date', 'content-workflow-by-bynder' );

				return 'post_date';
			case 'post_date_gmt':
				return __( 'Post Date (GMT)', 'content-workflow-by-bynder' );
			case 'post_content':
				return __( 'Post Content', 'content-workflow-by-bynder' );
			case 'post_title':
				return __( 'Post Title', 'content-workflow-by-bynder' );
			case 'post_excerpt':
				return __( 'Post Excerpt', 'content-workflow-by-bynder' );
			case 'post_status':
				return __( 'Post Status', 'content-workflow-by-bynder' );
			case 'comment_status':
				return __( 'Comment Status', 'content-workflow-by-bynder' );
			case 'ping_status':
				return __( 'Ping Status', 'content-workflow-by-bynder' );
			case 'post_password':
				return __( 'Post Password', 'content-workflow-by-bynder' );
			case 'post_name':
				return __( 'Post Name (Slug)', 'content-workflow-by-bynder' );
			case 'post_modified':
				return __( 'Post Modified Date', 'content-workflow-by-bynder' );
			case 'post_modified_gmt':
				return __( 'Post Modified Date (GMT)', 'content-workflow-by-bynder' );
			case 'post_parent':
				return __( 'Post Parent', 'content-workflow-by-bynder' );
			case 'menu_order':
				return __( 'Menu Order', 'content-workflow-by-bynder' );
			case 'post_type':
				return __( 'Post Type', 'content-workflow-by-bynder' );
			default:
				return $col;
		}
	}

	/**
	 * Get all post-types and related taxonomies.
	 *
	 * @return array  Array of post-types w/ thier taxonomies.
	 * @since  3.0.0
	 *
	 */
	protected function post_types() {
		static $post_types = null;

		if ( null !== $post_types ) {
			return $post_types;
		}

		$post_types = array_map( 'get_post_type_object', \GatherContent\Importer\available_mapping_post_types() );

		foreach ( $post_types as $index => $type ) {
			$type->taxonomies = array();
			foreach ( get_object_taxonomies( $type->name, 'objects' ) as $tax ) {
				if ( 'post_format' === $tax->name ) {
					$tax->label = __( 'Post Formats', 'content-workflow-by-bynder' );
				}

				$type->taxonomies[] = $tax;
			}

			$post_types[ $index ] = $type;
		}

		return $post_types;
	}

	/**
	 * Get a specific value from the array of values stored to the template-mapping post.
	 *
	 * @param string $key Array key to check.
	 * @param callable $callback Callback to send data through.
	 * @param mixed $default Default value if value doesn't exist.
	 *
	 * @return mixed              Value of field.
	 * @since  3.0.0
	 *
	 */
	protected function get_value( $key, $callback = null, $default = null ) {
		static $values = null;

		if ( null === $values ) {
			$values = $this->stored_values();
		}

		$value = isset( $values[ $key ] ) ? $values[ $key ] : $default;

		return $callback && $value ? $callback( $value ) : $value;
	}

	/**
	 * Get the stored mapping values from the template-mapping post's content field.
	 *
	 * @return array  Array of values.
	 * @since  3.0.0
	 *
	 */
	protected function stored_values() {
		$values = array();

		if ( $this->mapping_id && ( $json = get_post_field( 'post_content', $this->mapping_id ) ) ) {

			$json = json_decode( $json, 1 );

			if ( is_array( $json ) ) {
				$values = $json;

				if ( isset( $values['mapping'] ) && is_array( $values['mapping'] ) ) {
					$mapping = $values['mapping'];
					unset( $values['mapping'] );
					$values += $mapping;
				}
			}
		}

		$stored_values = $values;

		return $stored_values;
	}

}
