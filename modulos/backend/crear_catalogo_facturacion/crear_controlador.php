<?php
function crear_controlador($params){
	$nombreControlador =$params['controlador'];
	$nombreModelo=$params['modelo'];
	$fields=$params['fields'];
	
	global $_PETICION;
	// $ruta='../'.$_PETICION->modulo.'/controladores/';	
	$ruta='../'.$params['ruta_base'].$params['modulo'].'/controladores/';	
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
require_once $_PETICION->basePath.\'/modelos/'.$nombreModelo.'_modelo.php\';
class '.$nombreControlador.' extends Controlador{
	var $modelo="'.$nombreModelo.'";
	var $campos='.$fieldsStr.';
	var $pk="'.$params['pk_tabla'].'";
	var $nombre="'.strtolower($nombreControlador).'";
	
	function mostrarVista( $archivos=""){
		$vista= $this->getVista();
		
		global $_TEMA_APP;
		global $_PETICION;
		return $vista->mostrarTema($_PETICION, $_TEMA_APP);
	}
	
	function nuevo(){		
		$campos=$this->campos;
		$vista=$this->getVista();				
		for($i=0; $i<sizeof($campos); $i++){
			$obj[$campos[$i]]=\'\';
		}
		$vista->datos=$obj;		
		
		global $_TEMA_APP;
		global $_PETICION;
		$_PETICION->accion=\'edicion\';
		return $vista->mostrarTema($_PETICION, $_TEMA_APP);
		
		
		
	}
	
	function guardar(){
		return parent::guardar();
	}
	function borrar(){
		return parent::borrar();
	}
	function editar(){
		global $_PETICION;
		// print_r($_PETICION);
		if ( isset($_PETICION->params[0]) )
		$_REQUEST[\'id\'] = $_PETICION->params[0];
		
		// return parent::editar();
		$id=empty( $_REQUEST[\'id\'])? 0 : $_REQUEST[\'id\'];
		$model=$this->getModel();
		$params=array(
			$this->pk=>$id
		);		
		
		$obj=$model->obtener( $params );	

		$vista=$this->getVista();				
		$vista->datos=$obj;		
		
		global $_PETICION;
		global $_TEMA_APP;
		$_PETICION->accion="edicion";
		$vista->mostrarTema($_PETICION,$_TEMA_APP);
	}
	function buscar(){
		if ( $_SERVER[\'REQUEST_METHOD\']==\'POST\'  ){
			return parent::buscar();			
		}else{
			global $_PETICION, $_TEMA_APP;
			$vista = $this->getVista();
			$_PETICION->accion=\'busqueda\';
			return $vista->mostrarTema($_PETICION, $_TEMA_APP);
		}
	}
}
?>';
	
	
	$rutaCompleta=$ruta.$nombreControlador.'.php';
	
	// if ( file_exists($rutaCompleta) ){
		// echo 'Ek archivo '.$rutaCompleta.' ya existe;<br/> ';
	// }else{
		// file_put_contents($rutaCompleta, $contenido);
		// if ( file_exists($rutaCompleta) ){
			// echo 'archivo creado: '.$rutaCompleta.' ;<br/> ';
		// }else{
			// echo 'el archivo no pudo crearse: '.$rutaCompleta.'<br/> ';
		// }		
	// }
	
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