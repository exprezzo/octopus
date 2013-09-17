<?php 
/**
* En computaci�n SCRUD es el acr�nimo de Buscar, Crear, Obtener, Actualizar y Borrar (del original en ingl�s: Search, Create, Read, Update and Delete)
*/
interface I_SCRUD{

	function nuevo( $params );
	
	function obtener( $params );
	
	function guardar( $params ); //crear y actualizar		
		
	function borrar( $params );
	
	function buscar( $params );

}
?>