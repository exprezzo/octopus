<?php
if ( !isset( $DB_CONFIG ) ) {
	$DB_CONFIG=array(
		'DB_SERVER'	=>'localhost',
		'DB_NAME'	=>'db_user',
		'DB_USER'	=>'root',
		'DB_PASS'	=>'',
		'PASS_AES'  =>'faztA3s'
	);
}


if ( !isset( $APP_CONFIG ) ) {
	$APP_CONFIG=array(
		'nombre'=>'Octopus Backend',
		'tema'=>'redmond'
	);
}

$APP_CONFIG['tema'] = 'rocket';




// if ( !isset($_LOGIN_REDIRECT_PATH) ) $_LOGIN_REDIRECT_PATH = 'sistema';
$_DEFAUL_LAYOUT ='layout';
if (!isset($_DEFAULT_CONTROLLER) ) $_DEFAULT_CONTROLLER='backend';
?>