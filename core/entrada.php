<?php		
	//  AQUI INICIA EL PROCESO
	
	session_start();	
	//-------------------------------------------------------------------------------		
	ini_set('date.timezone', 'America/Mazatlan');	
	//carga el archivo de configuracion por default //¿Podemos omitir este archivo?	
	require_once '../config.php';			
	//las variables por default.
	if (!isset($_TEMA_APP) ) $_TEMA_APP='default';
	if (!isset($_DEFAULT_APP) ) $_DEFAULT_APP='portal';	
	if (!isset($_DEFAULT_CONTROLLER) ) $_DEFAULT_CONTROLLER='paginas';
	if (!isset($_DEFAULT_ACTION) ) $_DEFAULT_ACTION='inicio';		
	if (!isset($APPS_PATH) ) $APPS_PATH='../';	 //ruta relativa de la aplicacion
	if (!isset($CORE_PATH)) $CORE_PATH='';
	
	require_once 'clases/peticion.php';
	require_once 'clases/mvc/vista.php';	
	require_once 'clases/mvc/controlador.php';
	require_once 'clases/i_crud.php';
	
	require_once 'clases/database.php';
	require_once 'clases/mvc/modelo.php';		
	
	
	try{
		if ( isset($_SERVER['ORIG_PATH_INFO']) ){
			$_SERVER['PATH_INFO'] = $_SERVER['ORIG_PATH_INFO'];
		}
		$_PETICION=new Peticion( $_SERVER['PATH_INFO'] ); //Analiza el url		
		$_PETICION->establecerRutas();	
		
		//Una vez obtenido el modulo, se revisa que exista la carpeta.		
		if ( !file_exists($APPS_PATH.$_PETICION->modulo) ){
			$APPS_PATH='../modulos/';
			$MOD_WEB_PATH=$WEB_BASE.'modulos/'.$_PETICION->modulo.'/';
			if ( !file_exists($APPS_PATH.$_PETICION->modulo) ){
				throw new Exception("carpeta de aplicacion no encontrada");
			}			
		}		
		//y se carga el archivo de configuracion del modulo
		$configPath=$APPS_PATH.$_PETICION->modulo.'/config.php';
		if ( file_exists($configPath) ){
			require_once $APPS_PATH.$_PETICION->modulo.'/config.php';
		}
		
					
		$rutaControlador=$APPS_PATH.$_PETICION->modulo.'/controladores/'.$_PETICION->controlador.'.php';			
		$_PETICION->basePath=$APPS_PATH.$_PETICION->modulo.'/';
					
		if ( file_exists($rutaControlador) ){
			require_once ($rutaControlador);
		}else{
			$respuesta=array(
				'success'=>false,
				'msg'	 =>'El controlador '.$_PETICION->controlador.' no existe',
			);
			header("HTTP/1.0 404 Not Found".'El controlador '.$_PETICION->controlador.' no existe');
		}
		
		//  Todo el show, para poder hacer esto
		$controller=new $_PETICION->controlador;		
		$respuesta = $controller->servir();		
	}catch(Exception $e){		
		echo 'Exception: '.$e->getMessage();		
		//PENDIENTE: log exception
	}	
?>