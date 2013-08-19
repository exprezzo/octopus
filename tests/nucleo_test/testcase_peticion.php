<?php
require_once '../peticion.php';
require_once 'PHPUnit.php';
class PeticionTestcase extends PHPUnit_TestCase{
	 
	 //==================================================================================
	 // constructor of the test suite
    function FCTestcase($name) {
       $this->PHPUnit_TestCase($name);
    }	
	//==================================================================================	
	function testModuloControladorAccion1Param(){
		$modulo='portal';
		$controlador="user";
		$accion="edit";		
		$param1=5;		
		$url='/'.$modulo."/".$controlador.'/'.$accion.'/'.$param1;		
		$request=new Peticion( $url );
		$this->assertTrue($controlador == $request->controlador && $accion == $request->accion && $request->modulo == $modulo && $param1 ==$request->params[0 ]);
	}
	function testModuloControladorAccion(){
		$modulo='elmodulo';
		$controlador="elcontrolador";
		$accion="laaccion";				
		$url='/'.$modulo."/".$controlador.'/'.$accion;
		
		$request=new Peticion( $url );
		$this->assertTrue($controlador == $request->controlador && $accion == $request->accion && $request->modulo == $modulo);
	}
	function testControladorAccion(){
		$controlador="elcontrolador";
		$accion="laaccion";		
		$url="/".$controlador.'/'.$accion;
		$request=new Peticion( $url );
		global $_DEFAULT_APP;
		$this->assertTrue($controlador == $request->controlador && $accion == $request->accion && $request->modulo == $_DEFAULT_APP);
	}
	function testSoloAccion(){		
		$accion="elcontrolador";		
		$url="/".$accion;
		$request=new Peticion( $url );		
		global $_DEFAULT_APP, $_DEFAULT_CONTROLLER;
		$this->assertTrue($_DEFAULT_CONTROLLER == $request->controlador && $request->accion == $accion && $request->modulo == $_DEFAULT_APP);				
	}
	function testRaiz(){
		$url="";
		$request=new Peticion( $url );
		global $_DEFAULT_APP, $_DEFAULT_CONTROLLER, $_DEFAULT_ACTION;
		$this->assertTrue($_DEFAULT_CONTROLLER == $request->controlador && $request->accion == $_DEFAULT_ACTION && $request->modulo == $_DEFAULT_APP);
	}
	/*
	function testRutas(){
		// Y este que?
		//$this->assertTrue(false);
	}*/
}

?>