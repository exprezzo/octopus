<?php

class Peticion{
	function Peticion( $url, $peticiond = null ) {										
		$xp = explode( '/', $url);
		$size=sizeof($xp);
		$modulo='';
		global $_DEFAULT_APP,$_DEFAULT_CONTROLLER,$_DEFAULT_ACTION;
		switch($size){
			case 1:		//  raiz (modulo y controlador y accion por default)
				@include '../config.php';
				$modulo		= isset($peticiond )? $peticiond->modulo :  $_DEFAULT_APP;
				$controlador=isset($peticiond )? $peticiond->controlador : $_DEFAULT_CONTROLLER;
				$accion=$_DEFAULT_ACTION;
			break;
			case 2:	// solo escribió un parametro, la accion (modulo y controlador default)
				@include '../config.php';
				$modulo		=isset($peticiond )? $peticiond->modulo : $_DEFAULT_APP;
				$controlador=isset($peticiond )? $peticiond->controlador : $_DEFAULT_CONTROLLER;
				$accion		=$xp[1];
			break;			
			case 3:	// escribió el controlador y la accion, (modulo default)
				@include '../config.php';
				$modulo		=isset($peticiond )? $peticiond->modulo : $_DEFAULT_APP;
				$controlador=$xp[1];
				
				$accion		=$xp[2];
			break;
			case 4:	// escribió el modulo, controlador y la accion
				$modulo		=$xp[1];
				$controlador=$xp[2];
				$accion		=$xp[3];				
			break;			
			default:
				$modulo		=$xp[1];
				$controlador=$xp[2];
				$accion		=$xp[3];				
				$params=array();
				for ($i=4; $i<sizeof($xp); $i++ ){
					$params[]=$xp[$i];
				}
				
				$this->params=$params;
				//throw new Exception($url. " No reconocida" );
				//header("HTTP/1.0 404 ".$url. " No reconocida");
				// escribió algo incomprensible, en este caso deberia lanzar una pagina de error
		}
		
		$this->modulo 	   = $modulo;				
		$this->controlador = $controlador;
		$this->accion 	   = $accion;		
		
		// if (isset($peticiond) ){
			// $this->url_app = $peticiond->url_app;
			// $this->url_web = $peticiond->url_web;
			// $this->url_mod = $peticiond->url_mod;		
			// $this->basePath = $peticiond->basePath;					
		// }else{
			$this->establecerRutas();
		// }
		
	}
	
	function establecerRutas(){
		//url
		//ruta_archivos
		//vistas path (Tomando en cuenta el tema)
			
		$arrAppPath = explode('/',$_SERVER['SCRIPT_NAME']) ;				
		$url_app='/';			
		$arrCount=sizeof($arrAppPath);
		for( $i=1;  $i<$arrCount-2; $i++ ){		//no nos interesa el primero ni los ultimos dos
			$url_app.=''.$arrAppPath[$i].'/';
		}
		
		global  $_TEMA_APP;
		$tema = $_TEMA_APP;
		
		$ruta_archivos = '../'.$this->modulo;
		$ruta_vistas = $ruta_archivos.'/temas/'.$tema.'/vistas/';		
		$url_web = $url_app.$this->modulo.'/temas/'.$tema.'/web/';
		
		
		if ( !file_exists($ruta_archivos) ){
			$ruta_archivos = 'modulos/'.$this->modulo;
			$ruta_vistas = 'modulos/'.$this->modulo.'/temas/'.$tema.'/vistas/';
			
			if ( !file_exists($ruta_archivos) ){
				throw new Exception("carpeta de aplicacion no encontrada ".$ruta_archivos);
			}
			
			$url_web = $url_app.'core/modulos/'.$this->modulo.'/temas/'.$tema.'/web/';						
		}
		
		$this->ruta_archivos = $ruta_archivos;
		$this->ruta_vistas = $ruta_vistas;
		$this->url_web = $url_web;
		
		
		$this->url_app = $url_app;				
		$this->basePath=$ruta_archivos.'/';
		
		$this->url_web_mod = $url_web;
		$this->url_mod = $url_app; 
	}
}
?>