<?php

class Controlador{
	var $modelo='Modelo';
	var $campos=array('id');
	var $pk='id';
	
	
	function servir(){		
		global $_PETICION;
		$accion = $_PETICION->accion;
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
	function init(){
		return array('success'=>true);
	}
		
	function mostrarVista($vistaFile=''){		
		$vista= $this->getVista(); //El manejador de vistas		
		global $_TEMA_APP;
		global $_PETICION;
		return $vista->mostrarTema( $_PETICION, $_TEMA_APP );
	}
	
	function getVista(){
		if ( !isset($this->vistaObj) ){
			global $CORE_PATH;
			$this->vistaObj = new Vista();
		}
		return $this->vistaObj;
	}
	
	
	function nuevo(){		
		$campos=$this->campos;
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
		$model=$this->getModel();
		$params=array(
			$this->pk=>$id
		);		
		
		$obj=$model->obtener( $params );	

		$vista=$this->getVista();				
		$vista->datos=$obj;		
		
		global $_PETICION;
		$vista->mostrar('/'.$_PETICION->modulo.'/'.$_PETICION->controlador.'/edicion');
		// print_r($obj);
	}
	
	function buscar(){
		$mod=$this->getModel();
		
		if (!empty($_GET['paging']) ){
			$paging=$_GET['paging']; //Datos de paginacion enviados por el componente js
			if ($paging['pageSize']<0) $paging['pageSize']=0;
			$params=array(	//Se traducen al lenguaje sql
				'limit'=>$pageSize=intval($paging['pageSize']),
				'start'=>intval($paging['pageIndex'])*$pageSize		
			);
		}else{
			$params=array(	);
		}
		
		
		

		if ( isset($_GET['filtering']) ){
			$params['filtros']=$_GET['filtering'];
		}
		
		$res=$mod->buscar($params);				
		
		if ( !$res['success'] ) {
			echo  json_encode($res); exit;
		}
		$respuesta=array(
			'rows'=>$res['datos'],
			'totalRows'=> $res['total']
		);
		echo json_encode($respuesta);
	}
	
	function getModelo(){
		if ( !isset($this->modObj) ){				
			$clase=$this->modelo.'Modelo';
			$this->modObj = new $clase();	
		}	
		return $this->modObj;
	}
	function getModel(){		
		
		return $this->getModelo();
	}		
	

	function guardar(){
		
		
		if ( empty($_POST['datos']) ){
			$res=array(
				'success'=>false,
				'msg'=>'No se recibieron datos para almacenar'
			);
			echo json_encode($res); exit;
		}
		$datos= $_POST['datos'];
		
		$model=$this->getModel();				
		$res = $model->guardar($datos);
		
		if (!$res['success']) {			
			echo json_encode($res); exit;
		}
		
		
		$datos=$res['datos'];
		
		//----------------
		
		$res['datos']=$datos;		
		echo json_encode($res);
		return $res;
	}
	function paginar(){
		return $this->buscar();
	}
	function eliminar(){
		$modObj= $this->getModel();
		$params=array();
		
		if ( !isset($_POST[$this->pk]) ){
			$id=$_POST['datos'];
		}else{
			$id=$_POST[$this->pk];
		}
		$params[$this->pk]=$id;
		
		$res=$modObj->borrar($params);
		
		$response=array(
			'success'=>$res,
			'msg'=>'Registro Eliminado'
		);
		echo json_encode($response);
		exit;
	}
}
?>