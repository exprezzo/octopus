<?php
require_once $_PETICION->basePath.'/modelos/menu_modelo.php';

class Paginas extends Controlador{	
	function mostrarVista($vista = ''){		
		$vista = $this->getVista();
		
		$mod = new menuModelo();
		$menusRes = $mod->buscar( array() );
		
		$vista->menus = $menusRes['datos'];
		
		
		return parent::mostrarVista($vista);
		
	}
}
?>