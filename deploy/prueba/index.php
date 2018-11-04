<?php
set_include_path(get_include_path() . PATH_SEPARATOR . '../../phpseclib');

include 'Crypt/RSA.php';
include 'Net/SSH2.php';

/*
$ssh = new Net_SSH2('server.nigma.com.co', 1157);
$key = new Crypt_RSA();
$key->loadKey(file_get_contents('privatekey_server1'));

if (!$ssh->login('contacte', $key)) {
	exit('Error de inicio de sesion');
}
*/

// Post de GitHub
$webhook = ((isset($_POST['payload']))?$_POST['payload']:"");

if ( $webhook != "" ) {

	$webhook = json_decode($webhook);

	// Rama a la que se ha hecho push desde GitHub
	$rama = basename($webhook->ref);


	if( $rama == "master" ) {

		// Acceso por SSH
		$ssh = new Net_SSH2('server.nigma.com.co', 1157);
		$key = new Crypt_RSA();
		$key->loadKey(file_get_contents('privatekey_server1'));

		// Validar conexión
		if (!$ssh->login('contacte', $key)) {
			exit();
		}

		// Comandos a ejecutar
		$ssh->exec('mkdir pepe_master');

	}


	if( $rama == "develop" ) {

		// Acceso por SSH
		$ssh = new Net_SSH2('server.nigma.com.co', 1157);
		$key = new Crypt_RSA();
		$key->loadKey(file_get_contents('privatekey_server2'));

		// Validar conexión
		if (!$ssh->login('asiquedo', $key)) {
			exit();
		}

		// Comandos a ejecutar
		$ssh->exec('mkdir pepe_develop');
	}

}

// $ssh->exec('cd folder && git init');


?>
