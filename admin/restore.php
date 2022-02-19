<?php
require "../config/config.function.php";

function restore($file)
{
	require("../config/config.database.php");
	global $rest_dir;
	$nama_file	= $file['name'];
	$ukrn_file	= $file['size'];
	$tmp_file	= $file['tmp_name'];

#For NGINX
#    $uploads_dir = '/usr/share/nginx/html/candycbt/admin/backup/';

#For Apache
	$uploads_dir = '/var/www/html/candycbt/admin/backup/';

#For Windows Comment the NGINX and Apache custom directory
	
	if ($nama_file == "") {
		echo "Fatal Error";
	} else {
/*		$alamatfile	= $rest_dir . $nama_file;	*/
		
		$alamatfile	= $uploads_dir . $nama_file;
		$templine	= array();

		if (move_uploaded_file($tmp_file, $alamatfile)) {

			$templine	= '';

			$lines	= file($alamatfile);

			foreach ($lines as $line) {
				if (substr($line, 0, 2) == '--' || $line == '')
					continue;

				$templine .= $line;

				if (substr(trim($line), -1, 1) == ';') {
					mysqli_query($koneksi, $templine);
					$templine = '';
				}
			}
		} else {
			echo "Proses upload gagal, kode error = " . $file['error'];
		}
	}
}
restore($_FILES['datafile']);
if (isset($_FILES['datafile'])) {
	echo "data berhasil di restore";
}
