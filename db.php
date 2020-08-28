<?php 
@ob_start();
@session_start();
?>

<?php



// Author : Ender KUŞ

include "Medoo.php";
 use Medoo\Medoo;
// Sentez Veritabanı Bağlantı Bilgileri
$database = new Medoo([
	'database_type' => 'mssql',
	'database_name' => '',
	'server' => '',
	'username' => '',
	'password' => '',
	//Opsiyonel alan açılabilir..
	//'driver' => 'dblib',
	//'logging' => true,
]);

// Veritabanı bağlantısını kontrol ediyoruz. Başasız olduğunda hata verecek.
/**if ($database) {
	echo "Bağlantı başarılı";
}**/





 ?>
