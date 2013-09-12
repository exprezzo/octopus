<?php
require_once $_PETICION->basePath.'/modelos/usuario_modelo.php';
require_once $_PETICION->basePath.'/modelos/rol_modelo.php';
class usuarios extends Controlador{
	var $modelo="Usuario";
	var $campos=array('id','nick','pass','email','rol','fbid','name','picture','originalName');
	var $accionesPublicas=array('login');
	function mostrarVista($vistaFile=''){
		
		$vista=$this->getVista();
		$vista->mostrar();
	}
	function logout(){	
		// ob_start();
		$model=$this->getModel();		
		$model->logout();
		// ob_end_clean();
		global $APP_PATH;
		header ('Location: '.$APP_PATH);
	}
	
	function nuevo(){		
		$campos=$this->campos;
		$vista=$this->getVista();				
		for($i=0; $i<sizeof($campos); $i++){
			$obj[$campos[$i]]='';
		}
		$vista->datos=$obj;		
		
		$rolMod = new rolModelo();
		$res = $rolMod->buscar( array() );				
		$vista->roles=$res['datos'];
		
		global $_PETICION;
		$vista->mostrar('/'.$_PETICION->controlador.'/edicion');
		
		
	}
	
	function guardar(){				
		return parent::guardar();
	}
	function borrar(){
		return parent::borrar();
	}
	function editar(){
		// header("Content-Type: text/html;charset=utf-8");
		
		$id=empty( $_REQUEST['id'])? 0 : $_REQUEST['id'];
		$model=$this->getModel();
		$params=array(
			'id'=>$id
		);		
		$obj=$model->obtener( $params );		
		$obj['pass']='';
		$vista=$this->getVista();				
		$vista->datos=$obj;		
		
		$rolMod = new rolModelo();
		$res = $rolMod->buscar( array() );				
		$vista->roles=$res['datos'];
		
		global $_PETICION;
		$vista->mostrar('/'.$_PETICION->controlador.'/edicion');
		// print_r($obj);
	}
	function buscar(){
		return parent::buscar();
	}
}
?>