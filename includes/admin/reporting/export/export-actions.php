<?php
/**
 * Exports Actions
 *
 * These are actions related to exporting data from Give
 *
 * @package     Give
 * @subpackage  Admin/Export
 * @copyright   Copyright (c) 2016, WordImpress
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Process the download file generated by a batch export
 *
 * @since 1.5
 * @return void
 */
function give_process_batch_export_download() {

	if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'give-batch-export' ) ) {
		wp_die( __( 'Nonce verification failed', 'easy-digital-downloads' ), __( 'Error', 'easy-digital-downloads' ), array( 'response' => 403 ) );
	}

	require_once GIVE_PLUGIN_DIR . 'includes/admin/reporting/export/class-batch-export.php';

	do_action( 'give_batch_export_class_include', $_REQUEST['class'] );

	$export = new $_REQUEST['class'];
	$export->export();

}

add_action( 'give_download_batch_export', 'give_process_batch_export_download' );

/**
 * Exports earnings for a specified time period
 * 
 * Give_Earnings_Export class.
 *
 * @since 1.5
 * @return void
 */
function give_export_earnings() {
	require_once GIVE_PLUGIN_DIR . 'includes/admin/reporting/class-export-earnings.php';

	$earnings_export = new Give_Earnings_Export();

	$earnings_export->export();
}

add_action( 'give_earnings_export', 'give_export_earnings' );


/**
 * Export all the customers to a CSV file.
 *
 * Note: The WordPress Database API is being used directly for performance
 * reasons (workaround of calling all posts and fetch data respectively)
 *
 * @since 1.5
 * @return void
 */
function give_export_all_customers() {
	require_once GIVE_PLUGIN_DIR . 'includes/admin/reporting/class-export-customers.php';

	$customer_export = new Give_Customers_Export();

	$customer_export->export();
}

add_action( 'give_email_export', 'give_export_all_customers' );

/**
 * Exports all the downloads to a CSV file using the Give_Export class.
 *
 * @since 1.5
 * @return void
 */
function give_export_all_downloads_history() {
	require_once GIVE_PLUGIN_DIR . 'includes/admin/reporting/class-export-download-history.php';

	$file_download_export = new Give_Download_History_Export();

	$file_download_export->export();
}

add_action( 'give_downloads_history_export', 'give_export_all_downloads_history' );

/**
 * Add a hook allowing extensions to register a hook on the batch export process
 *
 * @since  1.5
 * @return void
 */
function give_register_batch_exporters() {
	if ( is_admin() ) {
		do_action( 'give_register_batch_exporter' );
	}
}

add_action( 'plugins_loaded', 'give_register_batch_exporters' );

/**
 * Register the payments batch exporter
 * @since  1.5
 */
function give_register_payments_batch_export() {
	add_action( 'give_batch_export_class_include', 'give_include_payments_batch_processer', 10, 1 );
}

add_action( 'give_register_batch_exporter', 'give_register_payments_batch_export', 10 );

/**
 * Loads the payments batch process if needed
 *
 * @since  1.5
 *
 * @param  string $class The class being requested to run for the batch export
 *
 * @return void
 */
function give_include_payments_batch_processer( $class ) {

	if ( 'Give_Batch_Payments_Export' === $class ) {
		require_once GIVE_PLUGIN_DIR . 'includes/admin/reporting/export/class-batch-export-payments.php';
	}

}

/**
 * Register the customers batch exporter
 * @since  1.5.2
 */
function give_register_customers_batch_export() {
	add_action( 'give_batch_export_class_include', 'give_include_customers_batch_processer', 10, 1 );
}

add_action( 'give_register_batch_exporter', 'give_register_customers_batch_export', 10 );

/**
 * Loads the customers batch process if needed
 *
 * @since  1.5.2
 *
 * @param  string $class The class being requested to run for the batch export
 *
 * @return void
 */
function give_include_customers_batch_processer( $class ) {

	if ( 'Give_Batch_Customers_Export' === $class ) {
		require_once GIVE_PLUGIN_DIR . 'includes/admin/reporting/export/class-batch-export-customers.php';
	}

}

/**
 * Register the download products batch exporter
 *
 * @since  1.5
 */
function give_register_downloads_batch_export() {
	add_action( 'give_batch_export_class_include', 'give_include_downloads_batch_processer', 10, 1 );
}

add_action( 'give_register_batch_exporter', 'give_register_downloads_batch_export', 10 );

/**
 * Loads the file downloads batch process if needed
 *
 * @since  1.5
 *
 * @param  string $class The class being requested to run for the batch export
 *
 * @return void
 */
function give_include_downloads_batch_processer( $class ) {

	if ( 'Give_Batch_Forms_Export' === $class ) {
		require_once GIVE_PLUGIN_DIR . 'includes/admin/reporting/export/class-batch-export-downloads.php';
	}

}