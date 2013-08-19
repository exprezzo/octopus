<?php
require_once $_PETICION->basePath.'/modelos/menu_modelo.php';
class menu extends Controlador{
	var $modelo="menu";
	var $campos=array('id','titulo','target','icono','thumb');
	var $pk="id";
	var $nombre="menu";
	
	function mostrarVista( $archivos=""){
		$vista= $this->getVista();
		$vista->mostrar( $archivos );
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