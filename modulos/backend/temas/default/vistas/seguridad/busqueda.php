
<script src="<?php echo $_PETICION->url_web_mod; ?>js/catalogos/<?php echo $_PETICION->controlador; ?>/busqueda.js"></script>

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
				nombre:'Seguridad'
			}
			
		};				
		 var lista=new Busquedaseguridad();
		 lista.init(config);		
	});
</script>
<?php 	
	global $_PETICION;
	$this->mostrar('/componentes/busqueda_toolbar');
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
