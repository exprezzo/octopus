<?php
class estudiantes extends Controlador{	
	function reprobar(){
		
		
		$vista = $this->getVista();
		
		
		$vista->mensaje = 'Este es un mensaje del controlador';
		$vista->mostrar();
	}
	
}
?>