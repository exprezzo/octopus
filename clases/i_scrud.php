<?php
/**
  * @package Core
  */
  
/**
En computación CRUD es el acrónimo de Crear, Obtener, Actualizar y Borrar (del original en inglés: Create, Read, Update and Delete). Es usado para referirse a las funciones básicas en bases de datos o la capa de persistencia en un software.

En algunos lugares, se utilizan las siglas ABM para lo mismo (Alta Baja Modificación), obviando la operación de Obtener; el acrónimo ABC para Altas, Bajas y Cambios; ABML siendo la última letra (L) de listar, listado o lectura; o ABMC siendo la C de Consulta.

También es usado el ABCDEF : Agregar, Buscar, Cambiar, Desplegar(listar), Eliminar, Fichar(Ficha, cédula o Reporte de un registro). Fuente:vhag

Another variation of CRUD is BREAD, an acronym for "Browse, Read, Edit, Add, Delete".

*/
interface I_SCRUD{

	function nuevo( $params );
	
	function obtener( $params );
	
	function guardar( $params ); //crear y actualizar		
		
	function borrar( $params );
	
	function buscar( $params );

}
?>