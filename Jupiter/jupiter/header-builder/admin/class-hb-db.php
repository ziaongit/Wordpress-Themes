<?php
/**
 * Header Builder: HB_DB class.
 *
 * @since 5.9.0
 * @package Header_Builder
 */

/**
 * Class file for handling AJAX requests from the frond builder. Retrieve and save data to the
 * options table.
 *
 * @author Reza Marandi <ross@artbees.net>
 *
 * @since 5.9.0 Introduced by Medhi S. from Reza Marandi. Update to use wp_send_json_success and
 *              wp_send_json_error.
 * @since 5.9.6 Add function to store DB Structure version.
 * @since 5.9.8 Remove version compare function, move it to HB_Migration.
 */
class HB_DB {
	/**
	 * Constructor.
	 *
	 * @since 5.9.0
	 *
	 * Create custom handlers for your own custom AJAX requests.
	 */
	public function __construct() {
		add_action( 'wp_ajax_abb_header_builder_store_data', array( &$this, 'store_data' ) );
		add_action( 'wp_ajax_abb_header_builder_retrieve_data', array( &$this, 'retrieve_data' ) );
	}

	/**
	 * Saves entire JSON data into "artbees_header_builder" option in WP Options table.
	 *
	 * @since 5.9.0
	 *
	 * @throws Exception On empty $_POST['fn_data'].
	 */
	public function store_data() {
		try {

			// WARNING: @todo Fix security issue: nonces. We can't create nonce on React.
			$fn_data = $_POST['fn_data']; // WPCS: CSRF ok.

			if ( empty( $fn_data ) ) {
				throw new Exception( 'Data field value is empty , Please check it.' );
			}

			update_option( 'artbees_header_builder' , str_replace( '\"', '"', $fn_data ) );

			wp_send_json_success(
				array(
					'message' => 'Successful',
					'data' => array(),
				)
			);
		} catch ( Exception $e ) {
			wp_send_json_error(
				array(
					'message' => $e->getMessage(),
					'data' => array(),
				)
			);
		}
	}

	/**
	 * Retrieves "artbees_header_builder" option in WP Options table from WP Options table
	 * and sents it over to front end as JSON data.
	 *
	 * @since 5.9.0
	 *
	 * @throws Exception On empty $_POST['fn_data'].
	 */
	public function retrieve_data() {
		try {
			$fn_data = get_option( 'artbees_header_builder' );

			if ( empty( $fn_data ) ) {
				throw new Exception( 'Data is empty.' );
			}
			wp_send_json_success(
				array(
					'message' => 'Successful',
					'data' => $fn_data,
				)
			);

		} catch ( Exception $e ) {
			wp_send_json_error(
				array(
					'message' => $e->getMessage(),
					'data' => array(),
				)
			);
		}
	}
}

new HB_DB();
