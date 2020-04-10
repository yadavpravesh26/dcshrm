<?php
ini_set('max_execution_time', 400);
phpinfo();

if( ini_get('allow_url_fopen') ) {
    die('allow_url_fopen is enabled. file_get_contents should work well');
} else {
    die('allow_url_fopen is disabled. file_get_contents would not work');
}

/* Source File URL */
$remote_file_url = 'http://daks.me/dcshrm-dev-31-07-18.zip';

/* New file name and path for this file */
$local_file = 'files.zip';

/* Copy the file from source url to server */
$copy = copy( $remote_file_url, $local_file );

/* Add notice for success/failure */
if( !$copy ) {
    echo "Doh! failed to copy $file...\n";
}
else{
    echo "WOOT! success to copy $file...\n";
}
 ?>
