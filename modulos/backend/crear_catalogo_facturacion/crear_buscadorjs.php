<?php
function crear_buscadorjs($params){
	
	$nombreModelo=$params['modelo'];
	$nombreControlador=$params['controlador'];
	
	
	global $_PETICION;
	// $ruta='..//web/'.$_PETICION->modulo.'/js/catalogos/'.$nombreControlador.'/';	
	
	$ruta='../'.$params['ruta_base'].$params['modulo'].'/temas/default/web/js/catalogos/'.$nombreControlador.'/';	
	
	// $ruta='../web'.$params['ruta_base'].$params['modulo'].'/js/catalogos/'.$nombreControlador.'/';	
	if ( !file_exists($ruta) ){
		mkdir($ruta, 0700, true);
	}
	
	ob_start();
	include 'busqueda.js';	
	
	$out1 = ob_get_contents();
	ob_end_clean();	
	$contenido=str_replace ('BusquedaNombreDelControlador','Busqueda'.$nombreControlador,$out1);
	
	//Genera la configuracion de los campos
	$fieldsStr='';
	foreach($params['fields'] as $campo){
		$fieldsStr.=PHP_EOL.'{ dataKey: "'.$campo.'", visible:true, headerText: "'.ucwords(strtolower($campo)).'" },';
	}
	$fieldsStr=$sql=substr($fieldsStr, 0, strlen($fieldsStr)-1 );	
	$contenido=str_replace ('//{FIELDS}',$fieldsStr,$contenido);
	
	$rutaCompleta=$ruta.'busqueda.js';	
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