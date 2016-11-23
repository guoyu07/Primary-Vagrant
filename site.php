<?php
/**
 * Generate site configurations easily from the command line.
 *
 * @version 0.0.1
 * @author  Chris Wiegman <info@chriswiegman.com>
 */

$short_args = 'd::';  // Primary domain name.
$long_args  = array(
	'list::', // List existing sites.
	'create::', // Use to create a site.
	'delete::', // Use to delete a site.
	'domain::', // Primary domain name.
	'database::', // Override database name.
	'alias::', // Server alias(es).
	'root::', // The root directory to map.
	'apacheroot::', // The apache docroot
);

$options = getopt( $short_args, $long_args );

// Find out if we're creating, listing or deleting a site.
if ( ! isset( $options['create'] ) && ! isset( $options['list'] ) && ! isset( $options['delete'] ) && ! isset( $options['help'] ) ) {

	fwrite( STDERR, 'You must specify "create," "delete," "list" or "help" when using this command.' . PHP_EOL );
	exit( 1 );

}

// Execute help functions.
if ( isset( $options['help'] ) ) {
	exit();
}

// Execute list functions.
if ( isset( $options['list'] ) ) {
	exit();
}

// Execute create functions.
if ( isset( $options['create'] ) ) {

	// Make sure we have a domain name.
	if ( ! isset( $options['domain'] ) && ! isset( $options['d'] ) ) {

		echo 'Enter a domain name for the site:';

		$domain = fopen( 'php://stdin', 'r' );

		$options['domain'] = trim( fgets( $domain ) );

		fclose( $domain );

	} elseif ( ! isset( $options['domain'] ) ) {

		$options['domain'] = trim( $options['d'] );

	}

	// Setup the site folder information.
	$options['site_folder'] = dirname( __FILE__ ) . '/user-data/sites/' . $options['domain'];

	// Create the directory or die if it already exists.
	if ( ! is_dir( $options['site_folder'] ) ) {

		mkdir( $options['site_folder'] );

	} else {

		fwrite( STDERR, 'A site with this domain already seems to exist. Please use a different site name or delete the existing site first.' . PHP_EOL );
		exit( 1 );

	}

	// Make sure we have a valid site root.
	if ( ! isset( $options['root'] ) ) {
		$options['root'] = $options['site_folder'];
	}

	// Make sure we have a valid apache doc root.
	if ( ! isset( $options['apacheroot'] ) ) {
		$options['apacheroot'] = $options['site_folder'];
	}

	print_r( $options );

	exit();

}

// Execute delete functions.
if ( isset( $options['delete'] ) ) {
	exit();
}
