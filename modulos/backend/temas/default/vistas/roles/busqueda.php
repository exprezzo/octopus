
<script src="<?php echo $MOD_WEB_PATH; ?>js/catalogos/<?php echo $_PETICION->controlador; ?>/busqueda.js"></script>

<script>			
	$( function(){		
		var config={
			tab:{
				id:'<?php echo $_REQUEST['tabId']; ?>'
			},
			controlador:{
				nombre:'<?php echo $_PETICION->controlador; ?>'
			},
			modulo:{
				nombre:'<?php echo $_PETICION->modulo; ?>'
			},
			catalogo:{
				nombre:'rol'

			},			
			pk:"id"
			
		};				
		 var lista=new Busquedaroles();
		 lista.init(config);		
	});
</script>
<?php 	
	global $_PETICION;
	$this->mostrar('/backend/componentes/busqueda_toolbar');
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
