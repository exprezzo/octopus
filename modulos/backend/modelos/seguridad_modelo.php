<?php
class SeguridadModelo extends Modelo{
	var $tabla="system_acl";
	var $campos=array('id','fk_user','controlador','modulo','accion');
	
	function nuevo($params){
		return parent::nuevo($params);
	}
	function guardar($params){
		return parent::guardar($params);
	}
	function borrar($params){
		return parent::borrar($params);
	}
	function editar($params){
		return parent::obtener($params);
	}
	function buscar($params){
		return parent::buscar($params);
	}
}
?>