<?php
/**
  * @package Core
  */
	//  AQUI INICIA EL PROCESO
	function my_autoloader($class) {
		global $_PETICION;	
	}
	
	function getModelo($modelo){
		//incluye el archivo del modelo, y devuelve una instancia
		// verifica si existe
		global $_PETICION;
		// print_r($_PETICION);
		$ruta=$_PETICION->ruta_archivos.'/modelos/'.$modelo.'.php';
		if (file_exists($ruta) ){
			require_once $ruta;
			$modelo.='Modelo';
			return new $modelo();
		}else{
			throw new Exception("El archivo no existe. ($ruta)");
		}
		
	}
	
	function logout(){
		global $_PETICION;		
		unset($_SESSION);
	}
	
	function getSessionVar($varName){
		global $_PETICION;
		return empty($_SESSION[$varName])? false: $_SESSION[$varName];
	}
	
	function sessionGet($varName){
		global $_PETICION;				
		return empty($_SESSION[$varName])? false: $_SESSION[$varName];
	}
	
	function sessionUnset($varName){
		global $_PETICION;				
		unset( $_SESSION[$varName] );
		// return empty($_SESSION[$varName])? false: $_SESSION[$varName];
	}
	
	function sessionSet($llave, $valor){
		global $_PETICION;		
		$_SESSION[$llave]=$valor;
	}
	
	function sessionAdd($llave, $valor){
		global $_PETICION;		
		$_SESSION[$llave]=$valor;
	}
	
	function isLoged(){
		global $_PETICION;		 
		return ( empty($_SESSION) || empty($_SESSION['isLoged']) )? false : true;
	}
	
	function addUser($user){
		global $_PETICION;		
		$_SESSION['user']=$user;
	}
	
	function getUser(){
		global $_PETICION;		
		return $_SESSION['user'];		
	}
	
	spl_autoload_register(__NAMESPACE__.'\my_autoloader');
	session_start();	
	//-------------------------------------------------------------------------------		
	ini_set('date.timezone', 'America/Mazatlan');	
	//carga el archivo de configuracion por default //¿Podemos omitir este archivo?	
	// require_once '../config.php';			
	
	//las variables por default.
	if (!isset($_TEMA_APP) ) $_TEMA_APP='default';
	// if (!isset($_DEFAUL_LAYOUT) ) $_DEFAUL_LAYOUT='layout';
	
	if (!isset($_DEFAULT_APP) ) $_DEFAULT_APP='portal';		
	if (!isset($_DEFAULT_CONTROLLER) ) $_DEFAULT_CONTROLLER='paginas';
	if (!isset($_DEFAULT_ACTION) ) $_DEFAULT_ACTION='inicio';		
	if (!isset($APPS_PATH) ) $APPS_PATH='../';	 //ruta relativa de la aplicacion
	if (!isset($CORE_PATH)) $CORE_PATH='';	// para las pruebas unitarias
	
	require_once 'clases/peticion.php';
	require_once 'mvc/vista.php';	
	require_once 'mvc/controlador.php';
	require_once 'clases/i_crud.php';
	
	require_once 'clases/database.php';
	require_once 'mvc/modelo.php';		
	
	
	try{
		if ( isset($_SERVER['ORIG_PATH_INFO']) ){
			$_SERVER['PATH_INFO'] = $_SERVER['ORIG_PATH_INFO'];
		}
		$_PETICION=new Peticion( $_SERVER['PATH_INFO'] ); //Analiza el url		
		
		if ( file_exists($_PETICION->ruta_archivos) ){			
			if ( file_exists($_PETICION->ruta_archivos.'/config.php') ){				
				require_once $_PETICION->ruta_archivos.'/config.php';
			}
		}
		
					
		$rutaControlador = $_PETICION->ruta_archivos.'/controladores/'.$_PETICION->controlador.'.php';			
		
		$APPS_PATH = $_PETICION->basePath;
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
		//-----PLUGINS-----
		if ( !empty($_PLUGINS) ){			
			foreach($_PLUGINS as $plugin){
				$plugin = $plugin.'Plugin';
				$plugin = new $plugin();
				$controller->attach( $plugin );
			}
			
		}
		//-----------
		
		$respuesta = $controller->servir();		
	}catch(Exception $e){		
		echo 'Exception: '.$e->getMessage();		
		//PENDIENTE: log exception
	}	
?>