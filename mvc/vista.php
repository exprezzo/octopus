<?php
/**
  * @package Core
  */
class  Vista{		
	var $errores=array();
	var $valores=array();
	
	function cargarJs($ruta){
		global $_PETICION;
		echo '<script src="/web/apps/'.$_PETICION->modulo.'/'.$ruta.'" type="text/javascript"></script>';		
	}
	
	function mostrarArchivo($rutaRelativa, $tema=''){
		global $_PETICION;
		global $_TEMA_APP;
		
		$tema = (empty($tema))? $_TEMA_APP : $tema;
		$ruta=$_PETICION->ruta_vistas.$rutaRelativa;
		
		$archivo_existe = ( file_exists($ruta) ) ? true : false;
		if ($archivo_existe) {
			//$this->antesdeMostrar($vista);
			require_once($ruta);
			//$this->despuesdeMostrar($vista);
			$success=true;
			$msg='accion mostrado';		}else{			
			$success=false;
			$msg='El archivo no ha sido encontrado: '.$ruta;			
			echo $msg;
			// header("HTTP/1.0 404".$msg);
		}
		
		return array(
			'success'=>$success,
			'msg'=>$msg
		);
	}
	
	function mostrarTema($peticion, $tema, $layout=''){
		// echo $layout;
		if ( empty($layout) ){
			global $_DEFAUL_LAYOUT;
			$layout = $_DEFAUL_LAYOUT;			
		}
		// echo $layout;
		// print_r($peticion);
		global $_PETICION, $APP_CONFIG;
		$rutaVista=$layout.'.php';											
		// echo $rutaVista;
		$vista_existe = ( file_exists($rutaVista) ) ? true : false;	
		if ($vista_existe) {
			require_once($rutaVista);
			$success=true;
			$msg='accion render ejecutada con éxito';
		}else{
			$msg='El recurso no ha sido encontrado: '.$rutaVista;
			$success=false;			
		}
		// echo $msg;
		return array(
			'success'=>$success,
			'msg'=>$msg
		);
	}
	
	function cargarVista($peticion, $tema='default'){
		global $_PETICION;
		global $APPS_PATH;
		global $APP_CONFIG;
		global $REDIRECT_URL;
		global $MOD_WEB_PATH;
		global $WEB_BASE;
		global $APP_URL_BASE;
		global $APP_PATH;
		global $_APP_PATH;
		
		$tema = empty( $tema )? '' : $tema.'/';		
		
		  // print_r($peticion);
		$rutaVista=$peticion->ruta_vistas.$peticion->controlador.'/'.$peticion->accion.'.php';									
		
		$vista_existe = ( file_exists($rutaVista) ) ? true : false;
		
		if ($vista_existe) {
			
			//$this->antesdeMostrar($vista);
			require_once($rutaVista);
			//$this->despuesdeMostrar($vista);
			$success=true;
			$msg='accion render ejecutada con éxito';
		}else{
			
			$success=false;
			$msg='El recurso no ha sido encontrado: '.$rutaVista;
			
			// echo $msg; 
			// exit;
			// header("HTTP/1.0 404".$msg); // exit;
		}
		
		return array(
			'success'=>$success,
			'msg'=>$msg
		);
		//si no lo encuentra, aqui termina el asunto con un mensaje de error
		//busca el archivo iniciando en la raiz del modulo /vistas/$controlador/$accion.php
		
	}
	
	
	function mostrar($vista=''){
		global $_PETICION;
		global $APPS_PATH;
		global $APP_CONFIG;
		global $REDIRECT_URL;
		global $MOD_WEB_PATH;
		global $WEB_BASE;
		global $APP_URL_BASE;
		
		if ( empty($vista) ){
			$controlador=$_PETICION->controlador;
			$accion=$_PETICION->accion;			
			$modulo=$_PETICION->modulo;			
			$peticionVista = new $_PETICION("/$modulo/$controlador/$accion",$_PETICION);
		}else{
			/*
			toma la peticion actual en caso de que la vista no este completa  
			Ejem:
			
				/vista
				
					en lugar de 
				
						modulo/controlador/vista
								
			*/
			
			$peticionVista = new $_PETICION($vista);
			
		}
		// echo $vista;
		// print_r($peticionVista);
		return $this->cargarVista($peticionVista, $tema='default');		
	}
			
	
	function render(){	
		return $this->mostrar();
	} 
	
	function setRutaContenido($rutaContenido){
		$this->rutaContenido=$rutaContenido;
	}
}
?>