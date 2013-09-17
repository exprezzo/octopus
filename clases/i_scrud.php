<?php 
/**
* En computación SCRUD es el acrónimo de Buscar, Crear, Obtener, Actualizar y Borrar (del original en inglés: Search, Create, Read, Update and Delete)
*/
interface I_SCRUD{

	function nuevo( $params );
	
	function obtener( $params );
	
	function guardar( $params ); //crear y actualizar		
		
	function borrar( $params );
	
	function buscar( $params );

}
?>