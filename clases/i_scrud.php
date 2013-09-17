<?php 
 /**
  * En computacioan SCRUD es el acronimo de Buscar, Crear, Obtener, Actualizar y Borrar (del original en ingles: Search, Create, Read, Update and Delete)
  * Esta interfaz solo presenta los metodos vacios, la clase que implemente esta interfaz sera encargada del funcionamiento que corresponda
  */
interface I_SCRUD{

	function nuevo( $params );
	
	function obtener( $params );
	
	function guardar( $params ); //crear y actualizar		
		
	function borrar( $params );
	
	function buscar( $params );

}
?>