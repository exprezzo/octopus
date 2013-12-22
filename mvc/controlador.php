<?php
/**
  * @package Core
  */
class Controlador{
	var $modelo='Modelo';
	
	/**
	 * @var boolean $revisarSession
	 Esta variable es usada para aplicar seguridad por default, o false para no revisar seguridad en ninguna funcion ni vista
	*/
	var $revisarSession=true;
	var $accionesPublicas=array();
	
	/**
	Esta funcion es llamada antes que otra cosa, aqui se decide si ejecutar la funcion, o mostrar una vista (si la funcion no existe)
	es un buen punto para aplicar seguridad
	*/
	function servir(){		
		global $_PETICION;
		$accion = $_PETICION->accion;
		global $APP_CONFIG;
		if ($this->revisarSession){		
			if ( !in_array($accion, $this->accionesPublicas ) ){				
				if ( !isLoged() ){
					$peticion='/'.$_SERVER['SERVER_NAME'].$_PETICION->url_app.$_SERVER['PATH_INFO'];
					sessionAdd('_PETICION',$peticion);
					// $_SESSION[$_PETICION->modulo]['_PETICION'] = ;
					header('Location: '.$_PETICION->url_app.$APP_CONFIG['_LOGIN_REDIRECT_PATH']);					
					return true;
				}
			}
		}
		
		if (method_exists($this, $accion )){
			$respuesta = $this->$accion();
			if ($respuesta==null){
				$respuesta=array(
					'success'=>true
				);
			}
		}else{
			// no existe? muestra la vista
			// ¿JSON o HTML, o XML TALVEZ?
			$respuesta = $this->mostrarVista();				
		}
		return $respuesta;
	}		
		
	/**
	Esta funcion involucra a la clase Vista,
	
	*/
	function mostrarVista(){		
		$vista= $this->getVista();   //Obtiene una instancia de la clase Vista, para ejecutarle la funcion mostrarTema		
		global $_TEMA_APP;
		global $_PETICION;
		return $vista->mostrarTema( $_PETICION, $_TEMA_APP );
	}
	
	function getVista(){
		if ( !isset($this->vistaObj) ){
			// global $CORE_PATH;
			$this->vistaObj = new Vista();
		}
		return $this->vistaObj;
	}

	function nueva() {
		global $_PETICION;
		$_PETICION->accion="nuevo";
		
		return $this->nuevo();
	}
	
	function nuevo(){		
		$modelo = $this->getModelo();
		$campos=$modelo->campos;
		$vista=$this->getVista();				
		for($i=0; $i<sizeof($campos); $i++){
			$obj[$campos[$i]]='';
		}
		$vista->datos=$obj;		
		
		global $_PETICION;
		$vista->mostrar('/'.$_PETICION->controlador.'/edicion');
		
		
	}
	
	function editar(){
		// header("Content-Type: text/html;charset=utf-8");
		
		$id=empty( $_REQUEST['id'])? 0 : $_REQUEST['id'];
		$model=$this->getModelo();
		$params=array(
			$model->pk=>$id
		);		
		
		$obj=$model->obtener( $params );	

		$vista=$this->getVista();				
		$vista->datos=$obj;		
		
		global $_PETICION;
		$vista->mostrar('/'.$_PETICION->modulo.'/'.$_PETICION->controlador.'/edicion');
		// print_r($obj);
	}
	
	function buscar(){
		$mod=$this->getModelo();
		
		if (!empty($_REQUEST['paging']) ){
			$paging=$_REQUEST['paging']; //Datos de paginacion enviados por el componente js
			if ($paging['pageSize']<0) $paging['pageSize']=0;
			$params=array(	//Se traducen al lenguaje sql
				'limit'=>$pageSize=intval($paging['pageSize']),
				'start'=>intval($paging['pageIndex'])*$pageSize		
			);
		}else{
			$params=array(	);
		}
		
		
		

		if ( isset($_REQUEST['filtering']) ){
			$params['filtros']=$_REQUEST['filtering'];
		}
		
		if ( isset($_REQUEST['filtrosAnd']) ){
			$params['filtrosAnd']=$_REQUEST['filtrosAnd'];
		}
		
		$res=$mod->buscar($params);				
		
		if ( !$res['success'] ) {
			echo  json_encode($res); exit;
		}
		$respuesta=array(
			'rows'=>$res['datos'],
			'totalRows'=> $res['total'],
			'success'=>true
		);
		
		echo json_encode($respuesta);
		
		
		return $respuesta;
	}
	
	function getModelo(){
		if ( !isset($this->modObj) ){				
			$clase=$this->modelo.'Modelo';
			$this->modObj = new $clase();	
		}	
		return $this->modObj;
	}
		
	

	function guardar(){
		
		
		if ( empty($_POST['datos']) ){
			$res=array(
				'success'=>false,
				'msg'=>'No se recibieron datos para almacenar'
			);
			echo json_encode($res); return $res;
		}
		$datos= $_POST['datos'];
		
		$model=$this->getModelo();				
		$res = $model->guardar($datos);
		
		if (!$res['success']) {			
			echo json_encode($res); return $res;
		}
		
		
		$datos=$res['datos'];
		
		//----------------
		
		$res['datos']=$datos;		
		echo json_encode($res);
		return $res;
	}
	
	function eliminar(){
		$modObj= $this->getModelo();
		$params=array();
		
		if ( !isset($_POST[$modObj->pk]) ){
			$id=$_POST['datos'];
		}else{
			$id=$_POST[$modObj->pk];
		}
		
		if (empty($id) ){			
			$response=array(
				'success'=>false,
				'msg'=>'Seleccione un elemento'
			);
		}else{
			$params[$modObj->pk]=$id;
		
			$res=$modObj->borrar($params);
			
			$response=array(
				'success'=>$res,
				'msg'=>'Registro Eliminado'
			);
			
		}
		echo json_encode($response);
		return $response;
	}
}
?>