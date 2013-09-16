<?php
/**
  * @package Core
  */
  
/**
En computaci�n CRUD es el acr�nimo de Crear, Obtener, Actualizar y Borrar (del original en ingl�s: Create, Read, Update and Delete). Es usado para referirse a las funciones b�sicas en bases de datos o la capa de persistencia en un software.

En algunos lugares, se utilizan las siglas ABM para lo mismo (Alta Baja Modificaci�n), obviando la operaci�n de Obtener; el acr�nimo ABC para Altas, Bajas y Cambios; ABML siendo la �ltima letra (L) de listar, listado o lectura; o ABMC siendo la C de Consulta.

Tambi�n es usado el ABCDEF : Agregar, Buscar, Cambiar, Desplegar(listar), Eliminar, Fichar(Ficha, c�dula o Reporte de un registro). Fuente:vhag

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