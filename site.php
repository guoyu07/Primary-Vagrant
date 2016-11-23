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
	'apacheroot::', // The apache docroot.
	'noprovsion::', //Set the flag to prevent a reload/provision.
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

		$handle = fopen( 'php://stdin', 'r' );

		$options['domain'] = sanitize_file_name( trim( fgets( $handle ) ) );

		fclose( $handle );

	} elseif ( ! isset( $options['domain'] ) ) {

		$options['domain'] = sanitize_file_name( trim( $options['d'] ) );

	}

	// Setup the site folder information.
	$options['site_folder'] = dirname( __FILE__ ) . '/user-data/sites/' . $options['domain'];

	// Get the vhost file and make sure it hasn't already been created.
	$vhost_file = dirname( __FILE__ ) . '/user-data/vhosts/' . $options['domain'] . '.pp';

	// Create the directory and verify the vhost file doesn't already exists or die if it already exists.
	if ( ! is_dir( $options['site_folder'] ) && ! file_exists( $vhost_file ) ) {

		mkdir( $options['site_folder'] );

	} else {

		fwrite( STDERR, 'A site with this domain already seems to exist. Please use a different site name or delete the existing site first.' . PHP_EOL );
		exit( 1 );

	}

	// Make sure we have a valid site root.
	if ( ! isset( $options['root'] ) ) {

		$options['root'] = $options['site_folder'];

	} elseif ( ! is_dir( $options['root'] ) ) { // Throw an error if the root directory isn't already a valid directory.

		fwrite( STDERR, 'The project root directory specified is not valid. Please specify a valid directory as "root"' . PHP_EOL );
		exit( 1 );

	}

	// Make sure we have a valid apache doc root.
	if ( ! isset( $options['apacheroot'] ) ) {

		$options['apacheroot'] = '';

	}

	$options['apacheroot'] = sanitize_file_name( $options['apacheroot'] );

	$apache_path = $options['site_folder'] . '/' . $options['apacheroot'];

	// Create the apache root directory if it is different than the site root.
	if ( ! is_dir( $apache_path ) ) {
		mkdir( $apache_path );
	}

	// Create a list of the domain and any aliases.
	$domains = $options['domain'] . PHP_EOL;
	$aliases = ''; // A space delimited string of aliases only for use in the VHost configuration.

	if ( isset( $options['alias'] ) ) {

		if ( is_array( $options['alias'] ) ) {

			foreach ( $options['alias'] as $alias ) {

				$domains .= sanitize_file_name( $alias ) . PHP_EOL;
				$aliases .= sanitize_file_name( $alias ) . ' ';

			}

			$aliases = substr( $aliases, 0, strlen( $aliases ) - 1 ); // Remove the last space.

		} else {

			$domains .= sanitize_file_name( $options['alias'] ) . PHP_EOL;
			$aliases = sanitize_file_name( $options['alias'] );

		}
	}

	$domains = substr( $domains, 0, strlen( $domains ) - 1 ); // Remove the last newline.

	// Create and write the pv-hosts file.
	$handle = fopen( $options['site_folder'] . '/pv-hosts', 'x+' );
	fwrite( $handle, $domains );
	fclose( $handle );

	// Write the mapping file.
	$mapping = 'config.vm.synced_folder "' . $options['root'] . '", "/var/www/' . $options['domain'] . '", :owner => "www-data", :mount_options => [ "dmode=775", "fmode=774"]';

	$handle = fopen( $options['site_folder'] . '/pv-mappings', 'x+' );
	fwrite( $handle, $mapping );
	fclose( $handle );

	print_r( $options );

	exit();

}

// Execute delete functions.
if ( isset( $options['delete'] ) ) {
	exit();
}

/**
 * Sanitize the file and folder names submitted.
 *
 * @since 0.0.1
 *
 * @param string $file_name The file/folder name to sanitize.
 *
 * @return string A sanitized file/folder name.
 */
function sanitize_file_name( $file_name ) {

	return preg_replace( "/[^a-z\d.]/", '', $file_name );

}
