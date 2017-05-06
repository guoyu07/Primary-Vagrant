<?php

// Check for a custom dashboard, otherwise load default.
if ( file_exists( './custom/index.php' ) ) {
	include( './custom/index.php' );
} else {
	include( './dashboard.php' );
}
