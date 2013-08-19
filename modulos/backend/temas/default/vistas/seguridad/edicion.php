
<script src="<?php echo $_PETICION->url_web_mod; ?>js/catalogos/<?php echo $_PETICION->controlador; ?>/edicion.js"></script>

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
		 var editor=new Edicionseguridad();
		 editor.init(config);		
	});
</script>

	<div class="pnlIzq">
		<?php 	
			global $_PETICION;
			$this->mostrar('/componentes/toolbar');	
			if (!isset($this->datos)){		
				$this->datos=array();		
			}
		?>
		
		<form class="frmEdicion" style="padding-top:10px;">	
			<input type="hidden" name="id" class="txtId" value="<?php echo $this->datos['id']; ?>" />	
			<div class="inputBox" style="margin-bottom:8px;display:block;margin-left:10px;width:100%;" autoFocus >
				<label style="">fk_user:</label>
				<input type="text" name="fk_user" class="txt_fk_user" value="<?php echo $this->datos['fk_user']; ?>" style="width:500px;" />
			</div>
			<div class="inputBox" style="margin-bottom:8px;display:block;margin-left:10px;width:100%;" autoFocus >
				<label style="">Modulo:</label>
				<input type="text" name="modulo" class="txt_modulo" value="<?php echo $this->datos['modulo']; ?>" style="width:500px;" />
			</div>
			<div class="inputBox" style="margin-bottom:8px;display:block;margin-left:10px;width:100%;" autoFocus >
				<label style="">Controlador:</label>
				<input type="text" name="controlador" class="txt_controlador" value="<?php echo $this->datos['controlador']; ?>" style="width:500px;" />
			</div>
			<div class="inputBox" style="margin-bottom:8px;display:block;margin-left:10px;width:100%;" autoFocus >
				<label style="">Accion:</label>
				<input type="text" name="accion" class="txt_accion" value="<?php echo $this->datos['accion']; ?>" style="width:500px;" />
			</div>
		</form>
	</div>
</div>
