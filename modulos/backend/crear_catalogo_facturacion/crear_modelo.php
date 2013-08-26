<?php
function crear_modelo($params){
	
	$nombreModelo=$params['modelo'];
	$fields=$params['fields'];
	$tabla=$params['tabla'];
	
	// print_r($params); exit;
	
	global $_PETICION;
	// $ruta='../'.$_PETICION->modulo.'/modelos/';	
	$ruta='../'.$params['ruta_base'].$params['modulo'].'/modelos/';	
	if ( !file_exists($ruta) ){
		mkdir($ruta, 0700, true);
	}
	
	$fieldsStr='array(';
	for($i=0; $i<sizeof($fields); $i++ ){
		$fieldsStr.='\''.$fields[$i].'\',';
	}
	
	$fieldsStr=$sql=substr($fieldsStr, 0, strlen($fieldsStr)-1 );
	$fieldsStr.=')';
	
$contenido='<?php
class '.$nombreModelo.'Modelo extends Modelo{
	var $tabla="'.$tabla.'";
	var $campos='.$fieldsStr.';
	var $pk="'.$params['pk_tabla'].'";
	
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
?>';
	
	
	$rutaCompleta=strtolower( $ruta.$nombreModelo.'_modelo.php' );
	
	if ( file_exists($rutaCompleta) ){
		// echo 'El archivo '.$rutaCompleta.' ya existe;<br/> ';
		return array(
			'success'=>false,
			'msg'=>'El archivo '.$rutaCompleta.' ya existe;<br/> '
		);
	}else{
		file_put_contents($rutaCompleta, $contenido);
		if ( file_exists($rutaCompleta) ){
			// echo 'archivo creado: '.$rutaCompleta.' ;<br/> ';
			return array(
				'success'=>true,
				'msg'=>'archivo creado: '.$rutaCompleta.' ;<br/> '
			);
		}else{
			// echo 'el archivo no pudo crearse: '.$rutaCompleta.'<br/> ';
			return array(
				'success'=>false,
				'msg'=>'el archivo no pudo crearse: '.$rutaCompleta.'<br/> '
			);
		}
		
	}
	
}
?>