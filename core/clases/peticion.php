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
			case 2:	// solo escribi� un parametro, la accion (modulo y controlador default)
				@include '../config.php';
				$modulo		=isset($peticiond )? $peticiond->modulo : $_DEFAULT_APP;
				$controlador=isset($peticiond )? $peticiond->controlador : $_DEFAULT_CONTROLLER;
				$accion		=$xp[1];
			break;			
			case 3:	// escribi� el controlador y la accion, (modulo default)
				@include '../config.php';
				$modulo		=isset($peticiond )? $peticiond->modulo : $_DEFAULT_APP;
				$controlador=$xp[1];
				
				$accion		=$xp[2];
			break;
			case 4:	// escribi� el modulo, controlador y la accion
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
				// escribi� algo incomprensible, en este caso deberia lanzar una pagina de error
		}
		
		$this->modulo 	   = $modulo;				
		$this->controlador = $controlador;
		$this->accion 	   = $accion;		
		
		if (isset($peticiond) ){
			$this->url_app = $peticiond->url_app;
			$this->url_web = $peticiond->url_web;
			$this->url_mod = $peticiond->url_mod;		
			$this->basePath = $peticiond->basePath;					
		}
		
	}
	
	function establecerRutas(){
		/* 
		Obtener la ruta absoluta, ya que puede eser asi:	
		portal.com/				ruta = /
		portal.com/sistema		ruta = /sistema
		localhost/portal		ruta = /portal
		portal/					ruta = /	
		*/
		$arrAppPath = explode('/',$_SERVER['SCRIPT_NAME']) ;				
		$app_path='/';			
		$arrCount=sizeof($arrAppPath);
		for( $i=1;  $i<$arrCount-2; $i++ ){		//no nos interesa el primero ni los ultimos dos
			$app_path.=''.$arrAppPath[$i].'/';			
		}
		
		$this->url_app = $app_path;
		$this->url_web = $app_path.'web/';
		$this->url_mod = $app_path.'web/';		
	}
}
?>