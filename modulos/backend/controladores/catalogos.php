<?php

 require_once $_PETICION->basePath.'/modelos/catalogo_modelo.php';
require_once $_PETICION->basePath.'/modelos/modulo_modelo.php';

include $_PETICION->basePath.'/crear_catalogo_facturacion/crear_controlador.php';
include $_PETICION->basePath.'/crear_catalogo_facturacion/crear_modelo.php';
// include $_PETICION->basePath.'/crear_catalogo/crear_vistas.php';
include $_PETICION->basePath.'/crear_catalogo_facturacion/crear_buscador.php';
include $_PETICION->basePath.'/crear_catalogo_facturacion/crear_buscadorjs.php';
include $_PETICION->basePath.'/crear_catalogo_facturacion/crear_editor.php';
include $_PETICION->basePath.'/crear_catalogo_facturacion/crear_editorjs.php';


class catalogos extends Controlador{
	var $modelo="Catalogo";
	var $campos=array('id','fk_modulo','nombre','controlador','modelo','tabla','pk_tabla','icono','titulo_nuevo','titulo_edicion','titulo_busqueda','msg_creado','msg_actualizado','pregunta_eliminar','msg_eliminado','msg_cambios','campos_busqueda');
	var $pk="id";
	var $nombre="catalogos2";
	
	function mostrarVista($vistaFile=''){
		
		$vista=$this->getVista();
		$vista->mostrar();
	}
	
	function nuevo(){		
		$obj=array();
		$campos=$this->campos;
		for($i=0; $i<sizeof($campos); $i++){
			$obj[$campos[$i]]='';
		}		
		$vista=$this->getVista();				
		$vista->datos=$obj;		
		
		$moduloMod=new ModuloModelo();
		$res=$moduloMod->buscar( array() );
		$vista->modulos=$res['datos'];
		
		
		global $_PETICION;
		$vista->mostrar('/'.$_PETICION->modulo.'/'.$_PETICION->controlador.'/edicion');		
	}
	
	function crear_catalogo( $params ){
				
		$ruta_base='..'.$params['ruta_base'];
		$modulo = $params['modulo']; 		
		$tabla = $params['tabla']; 
		// print_r( $params ); exit;
		$directorio =$ruta_base;

		if ( !file_exists($directorio)) {						
			mkdir($directorio);
		}
		
		$directorio =$ruta_base.$modulo;				
		
		if ( !file_exists($directorio)) {									
			mkdir($directorio);
			mkdir($directorio.'/controladores');
			mkdir($directorio.'/modelos');
			mkdir($directorio.'/temas');
			mkdir($directorio.'/temas/default');
			mkdir($directorio.'/temas/default/vistas');
		}		
					
		$sql="SHOW COLUMNS FROM $tabla";
		$mod=$this->getModelo();
		$res=$mod->ejecutarSql($sql);
		// print_r($res);
		$fields=array();
		foreach($res['datos'] as $key=>$value ){		
			$fields[]=$value['Field'];
		}		
		//en la carpeta controladores crea el controlador
		ob_start();
		
		
		$params['fields']=$fields;
		// print_r($params); exit;
		$resp1=crear_controlador($params);
		$resp2=crear_modelo($params);
		$resp3=crear_buscador($params);
		$resp4=crear_buscadorjs($params);
		$resp5=crear_editor($params);
		$resp6=crear_editorjs($params);		
		
		ob_end_clean();
		// echo json_encode($res);
	}
	function guardar(){
		global $_PETICION;
		ob_start();
			$resp = parent::guardar();
		ob_end_clean();
		
		$params=$_REQUEST['datos'];
		
		
		$moduloMod = new ModuloModelo();
		$res=$moduloMod->buscar(
			array('filtros'=>array(
				array('dataKey'=>'id','filterValue'=>$_REQUEST['datos']['fk_modulo'],'filterOperator'=>'equals')
			))
		);
		
		
		$moduloObj=$res['datos'][0];
		
		
		
		$params=array(
			'controlador'=>$_REQUEST['datos']['controlador'],
			'modelo'=>$_REQUEST['datos']['modelo'],
			'tabla'=>$_REQUEST['datos']['tabla'],
			'modulo'=>$moduloObj['nombre_interno'],			
			'ruta_base'=>$moduloObj['ruta_base'],
			'pk_tabla'=>$_REQUEST['datos']['pk_tabla'],
			'catalogo'=>$_REQUEST['datos']['nombre'],
			'campos'=>$_REQUEST['datos']
		);
		
		// print_r( $res ); exit;
		$this->crear_catalogo( $params );
		echo json_encode($resp);
		
	}
	function borrar(){
		return parent::borrar();
	}
	function editar(){
		$vista=$this->getVista();				
		$moduloMod=new ModuloModelo();
		$res=$moduloMod->buscar( array() );
		$vista->modulos=$res['datos'];		
		return parent::editar();
	}
	function buscar(){
		return parent::buscar();
	}
}
?>