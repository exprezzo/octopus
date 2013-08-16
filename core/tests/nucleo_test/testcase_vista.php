<?php
$CORE_PATH='../';
$APPS_PATH='nucleo_test/';

require_once $CORE_PATH.'vista/vista.php';
require_once $CORE_PATH.'peticion.php';
require_once 'PHPUnit.php';
class VistaTestcase extends PHPUnit_TestCase{

	function setUp() {
		// if (!defined('PATH_NUCLEO') ) define ('PATH_NUCLEO','../mvc_core/');
		// if (!defined('VISTAS_PATH') ) define ('VISTAS_PATH','nucleo_test/');
		if (!defined('DEFAULT_APP') ) define('DEFAULT_APP','app_test');
		if (!defined('DEFAULT_CONTROLLER') ) define('DEFAULT_CONTROLLER','controladortest');
		if (!defined('DEFAULT_ACTION') ) define('DEFAULT_ACTION','index');
		$_SERVER['PATH_INFO']="";
		
		global $_PETICION;
		$_PETICION=new Peticion();
    }
	
	function testMostrarDefault(){
		ob_start();
		$vista= new Vista();		
		$respuesta = $vista->mostrar();
		ob_end_clean();
		
		$this->assertTrue($respuesta['success'] == true );
	}
	function testMostrar(){		
		global $_PETICION;
		ob_start();
		$vista= new Vista();		
		$respuesta = $vista->mostrar($_PETICION->controlador.'/index2');
		ob_end_clean();
		
		$this->assertTrue($respuesta['success'] == true );
	}
	
	function testMostrarInexistente(){		
		ob_start();
		$vista= new Vista();
		$respuesta = $vista->mostrar('noexiste');
		ob_end_clean();
		
		$this->assertTrue( $respuesta['success']== false );
	}
	
	/*
	function testValidarParametros(){
		$this->assertTrue( false );
	}*/
}

?>