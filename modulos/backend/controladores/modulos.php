<?php
require_once $APPS_PATH.$_PETICION->modulo.'/modelos/Modulo_modelo.php';
class modulos extends Controlador{
	var $modelo="Modulo";
	var $campos=array('id','nombre','icono','nombre_interno','ruta_base','orden');
	var $pk="id";
	var $nombre="modulos";
	function mostrarVista($vistaFile=''){		
		$vista=$this->getVista();
		$vista->mostrar();
	}
	function nuevo(){		
		$campos=$this->campos;
		$vista=$this->getVista();				
		for($i=0; $i<sizeof($campos); $i++){
			$obj[$campos[$i]]='';
		}
		$vista->datos=$obj;		
		
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
		return parent::editar();
	}
	function buscar(){
		return parent::buscar();
	}
}
?>