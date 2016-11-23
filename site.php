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
	'noprovsion::', // Set the flag to prevent a reload/provision.
	'nodatabase::', // Set to prevent creation of a database.
	'deletefiles::', // Set to perform deletion of all files when removing a site.
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

// Setup variables common to both site creation and site deletion.
if ( isset( $options['create'] ) || isset( $options['delete'] ) ) {

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

}

// Execute create functions.
if ( isset( $options['create'] ) ) {

	// Create the directory and verify the vhost file doesn't already exists or die if it already exists.
	if ( ! is_dir( $options['site_folder'] ) && ! file_exists( $vhost_file ) ) {

		mkdir( $options['site_folder'] );

	} elseif ( file_exists( $vhost_file ) || file_exists( $options['site_folder'] . '/pv-hosts' ) || file_exists( $options['site_folder'] . '/pv-mappings' ) ) {

		// Throw an error if any of the Primary Vagrant site files already exist.
		fwrite( STDERR, 'A site with this domain already seems to exist. Please use a different site name or delete the existing site first.' . PHP_EOL );
		exit( 1 );

	}

	echo 'Site folder created.' . PHP_EOL;

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
		echo 'Apache docroot folder created.' . PHP_EOL;

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

	echo 'Hosts file created.' . PHP_EOL;

	// Write the mapping file.
	$mapping = 'config.vm.synced_folder "' . $options['root'] . '", "/var/www/' . $options['domain'] . '", :owner => "www-data", :mount_options => [ "dmode=775", "fmode=774"]';

	$handle = fopen( $options['site_folder'] . '/pv-mappings', 'x+' );
	fwrite( $handle, $mapping );
	fclose( $handle );

	echo 'Mappings file created.' . PHP_EOL;

	// Create the vhost config.
	$vhost_config = "apache::vhost { '" . $options['domain'] . "':" . PHP_EOL;

	if ( ! empty( $aliases ) ) {
		$vhost_config .= "  serveraliases                   => '" . $aliases . "'," . PHP_EOL;
	}

	// @todo set more of these items as options.
	$vhost_config .= "  docroot                         => '/var/www/" . $options['domain'] . "/" . $options['apacheroot'] . "'," . PHP_EOL;
	$vhost_config .= "  directory                       => '/var/www/" . $options['domain'] . "/" . $options['apacheroot'] . "'," . PHP_EOL;
	$vhost_config .= "  directory_allow_override        => 'All'," . PHP_EOL;
	$vhost_config .= "  ssl                             => true," . PHP_EOL;
	$vhost_config .= "  template                        => '/vagrant/provision/lib/conf/vhost.conf.erb'" . PHP_EOL;
	$vhost_config .= "}" . PHP_EOL;

	// Only add database information if we need to.
	if ( ! isset( $options['nodatabase'] ) ) {

		$database_name = $options['domain'];

		// Respect and override set for the database name.
		if ( isset( $options['database'] ) ) {
			$database_name = sanitize_file_name( $options['databasse'] );
		}

		// @todo set more of these items as options.
		$vhost_config .= PHP_EOL;
		$vhost_config .= "mysql_database { '" . $database_name . "':" . PHP_EOL;
		$vhost_config .= "  ensure  => 'present'," . PHP_EOL;
		$vhost_config .= "  charset => 'utf8mb4'," . PHP_EOL;
		$vhost_config .= "  collate => 'utf8mb4_general_ci'," . PHP_EOL;
		$vhost_config .= "  require => Class['mysql::server']," . PHP_EOL;
		$vhost_config .= "}" . PHP_EOL;
	}

	// Write the virtualhost file.
	$handle = fopen( $vhost_file, 'x+' );
	fwrite( $handle, $vhost_config );
	fclose( $handle );

	echo 'Virtualhost configuration created.' . PHP_EOL;

}

// Execute delete functions.
if ( isset( $options['delete'] ) ) {

	// Delete the site configuration.
	unlink( $vhost_file );
	echo 'Deleted ' . $vhost_file . PHP_EOL;

	if ( isset( $options['deletefiles'] ) ) { // Remove entire site folder.

		delete_directory( $options['site_folder'] );
		echo 'Deleted site folder.' . PHP_EOL;

	} else { // Only remove Primary Vagrant files.

		unlink( $options['site_folder'] . '/pv-hosts' );
		echo 'Deleted ' . $options['site_folder'] . '/pv-hosts' . PHP_EOL;

		unlink( $options['site_folder'] . '/pv-mappings' );
		echo 'Deleted ' . $options['site_folder'] . '/pv-mappings' . PHP_EOL;

	}
}

exit();

/**
 * Removes a directory recursively.
 *
 * @since 0.0.1
 *
 * @param string $directory The name of the directory to remove.
 *
 * @return bool True on success or false.
 */
function delete_directory( $directory ) {

	$files = array_diff( scandir( $directory ), array( '.', '..' ) );

	foreach ( $files as $file ) {
		( is_dir( $directory . '/' . $file ) ) ? delete_directory( $directory . '/' . $file ) : unlink( $directory . '/' . $file );
	}

	return rmdir( $directory );

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
