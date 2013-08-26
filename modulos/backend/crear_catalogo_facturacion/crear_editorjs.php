<?php
function crear_editorjs($params){
	$nombreControlador =$params['controlador'];
	$nombreModelo=$params['modelo'];
	
	$rutaBase=$params['ruta_base'];
	global $_PETICION;
	
	
	$ruta.=$params['modulo'];
	
	
	 // $ruta='../web'.$rutaBase.$params['modulo'].'/js/catalogos/'.$nombreControlador.'/';	
	$ruta='../'.$params['ruta_base'].$params['modulo'].'/temas/default/web/js/catalogos/'.$nombreControlador.'/';	
	
	if ( !file_exists($ruta)) {						
		mkdir($ruta,0777,true);
	}
	
	ob_start();
	include 'edicion.js';	
	
	$out1 = ob_get_contents();
	ob_end_clean();
	
	$contenido=str_replace ('EdicionNombreDelControlador','Edicion'.$nombreControlador,$out1);
	
	$rutaCompleta=$ruta.'edicion.js';	
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