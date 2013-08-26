<?php
function crear_buscador($params){
	// print_r($params); exit;
	
	$nombreControlador =$params['controlador'];
	$nombreModelo=$params['modelo'];
	 // print_r($params); exit;
	global $_PETICION;
	$ruta='../'.$params['ruta_base'].$params['modulo'].'/temas/default/vistas/'.$nombreControlador.'/';	
	
	if ( !file_exists($ruta) ){
		mkdir($ruta, 0700, true);
	}
	

$contenido='
<script src="<?php echo $_PETICION->url_web; ?>js/catalogos/<?php echo $_PETICION->controlador; ?>/busqueda.js"></script>

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
<?php 	
	global $_PETICION;
	$this->mostrar(\'/backend/componentes/busqueda_toolbar\');
?>
<div >	
	<table class="grid_busqueda">
		<thead>
			<th>id</th>		
			<th>titulo</th>					
		</thead>  	 
		<tbody>			
		</tbody>
	</table>
</div>
</div>
';
	
	
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
	crearBuscador2($ruta, $params);
}

function crearBuscador2($ruta, $params){
	$titulo = empty($params['campos']['titulo_busqueda'])? 'BUSQUEDA' : $params['campos']['titulo_nuevo'];
	$controlador = $params['controlador'];
	
	$contenido='<style>
</style>
<?php
	$id=$_PETICION->controlador.\'-\'.$_PETICION->accion;
	$_REQUEST[\'tabId\'] =$id;
?>
<div class="contenedor_catalogo" id="<?php echo $id; ?>">	
	<div class="titulo" style="text-align:center; background: black; color: white; padding:10px; margin:0; width:100%; position:relative;">
		<img  style="display:inline-block;" src="http://png.findicons.com/files/icons/2254/munich/32/invoice.png" />  		
		<h1 style="color: white; display: inline-block; vertical-align: top; margin-top: 9px;">'.$titulo.'</h1>			
		<div class="toolbarEdicion" style="display: inline-block; vertical-align: top; margin-left:10%; ">
						
			<button class="btnNuevo">Nuevo</button>
			<button class="btnEditar">Editar</button>
			<button class="btnEliminar" >Eliminar</button>		
			
			<div style="position:absolute; right:38px; top:14px;">
				<form action="<?php echo $_PETICION->url_app; ?>'.$controlador.'/buscar">
				<input type="text" name="query" >
				<input type="submit" value="Buscar" />					
				</form>
			</div>
		</div>
		
	</div>
	<?php
		
	?>
	<div style="text-align:center; "  >		
		<?php 			
		include \'busqueda.php\'; 
		?>		
	</div>
<div>';
	$rutaCompleta=$ruta.'buscar.php';	
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