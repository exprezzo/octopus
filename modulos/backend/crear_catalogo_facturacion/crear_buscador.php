<?php
function crear_buscador($params){
	// print_r($params); exit;
	
	$nombreControlador =$params['controlador'];
	$nombreModelo=$params['modelo'];
	$titulo = empty( $params['campos']['titulo_busqueda'] )? 'BUSQUEDA' : $params['campos']['titulo_busqueda'];
	$icon = $params['campos']['icono'];
	 // print_r($params); exit;
	global $_PETICION;
	$ruta='../'.$params['ruta_base'].$params['modulo'].'/temas/default/vistas/'.$nombreControlador.'/';	
	
	if ( !file_exists($ruta) ){
		mkdir($ruta, 0700, true);
	}
	

$contenido='
<script src="<?php echo $_PETICION->url_web; ?>js/catalogos/<?php echo $_PETICION->controlador; ?>/busqueda.js"></script>
<?php 		
	$id=$_PETICION->controlador.\'-\'.$_PETICION->accion;
	$_REQUEST[\'tabId\'] =$id;	
	
?>
<script>			
	$( function(){		
		var config={
			tab:{
				id:\'<?php echo $_REQUEST[\'tabId\']; ?>\'
			},
			controlador:{
				nombre:\'<?php echo $_PETICION->controlador; ?>\'
			},
			modulo:{
				nombre:\'<?php echo $_PETICION->modulo; ?>\'
			},
			catalogo:{
				nombre:\''. $params['catalogo'].'\'

			},			
			pk:"'.$params['pk_tabla'].'"
			
		};				
		 var lista=new Busqueda'. $nombreControlador.'();
		 lista.init(config);		
	});
</script>

<div class="contenedor_catalogo" id="<?php echo $id; ?>">	
	<div id="titulo">
    	<h1>'.$titulo.'</h1>
	</div>		
	<div id="cuerpo" >				
		<div id="contenedorDatos2">
		<table class="grid_busqueda">
			<thead>
				<th>id</th>		
				<th>titulo</th>					
			</thead>  	 
			<tbody>			
			</tbody>
		</table>
		<div id="contenedorMenu2" class="toolbarEdicion">
				<input type="submit" value="Nuevo" class="botonNuevo btnNuevo">
				<input type="submit" value="Editar" class="botonNuevo btnEditar">
				<input type="submit" value="Eliminar" class="botonNuevo sinMargeDerecho btnEliminar">
			</div>
	</div>
	</div>
	
	</div>
<div>';
	
	
	$rutaCompleta=$ruta.'busqueda.php';	
	if ( file_exists($rutaCompleta) ){
		// echo 'El archivo '.$rutaCompleta.' ya existe;<br/> ';
		// return array(
			// 'success'=>false,
			// 'msg'=>'El archivo '.$rutaCompleta.' ya existe;<br/> '
		// );
	}else{
		file_put_contents($rutaCompleta, $contenido);
		if ( file_exists($rutaCompleta) ){
			// echo 'archivo creado: '.$rutaCompleta.' ;<br/> ';
			// return array(
				// 'success'=>true,
				// 'msg'=>'archivo creado: '.$rutaCompleta.' ;<br/> '
			// );
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