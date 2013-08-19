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