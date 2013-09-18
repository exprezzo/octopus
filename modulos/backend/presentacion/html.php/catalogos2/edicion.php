
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
				nombre:'Catalogo2'
			},			
			pk:"id"
			
		};				
		 var editor=new Edicioncatalogos2();
		 editor.init(config);		
	});
</script>

	<div class="pnlIzq">
		<?php 	
			global $_PETICION;
			$this->mostrar('/backend/componentes/toolbar');	
			if (!isset($this->datos)){		
				$this->datos=array();		
			}
		?>
		
		<form class="frmEdicion" style="padding-top:10px;">				
			<div class="inputBox" style="margin-bottom:8px;display:block;margin-left:10px;width:100%;"  >
	<label style="">Id:</label>
	<input type="text" name="id" class="txt_id" value="<?php echo $this->datos['id']; ?>" style="width:500px;" />
</div>
<div class="inputBox" style="margin-bottom:8px;display:block;margin-left:10px;width:100%;"  >
	<label style="">Fk_modulo:</label>
	<input type="text" name="fk_modulo" class="txt_fk_modulo" value="<?php echo $this->datos['fk_modulo']; ?>" style="width:500px;" />
</div>
<div class="inputBox" style="margin-bottom:8px;display:block;margin-left:10px;width:100%;"  >
	<label style="">Nombre:</label>
	<input type="text" name="nombre" class="txt_nombre" value="<?php echo $this->datos['nombre']; ?>" style="width:500px;" />
</div>
<div class="inputBox" style="margin-bottom:8px;display:block;margin-left:10px;width:100%;"  >
	<label style="">Controlador:</label>
	<input type="text" name="controlador" class="txt_controlador" value="<?php echo $this->datos['controlador']; ?>" style="width:500px;" />
</div>
<div class="inputBox" style="margin-bottom:8px;display:block;margin-left:10px;width:100%;"  >
	<label style="">Modelo:</label>
	<input type="text" name="modelo" class="txt_modelo" value="<?php echo $this->datos['modelo']; ?>" style="width:500px;" />
</div>
<div class="inputBox" style="margin-bottom:8px;display:block;margin-left:10px;width:100%;"  >
	<label style="">Tabla:</label>
	<input type="text" name="tabla" class="txt_tabla" value="<?php echo $this->datos['tabla']; ?>" style="width:500px;" />
</div>
<div class="inputBox" style="margin-bottom:8px;display:block;margin-left:10px;width:100%;"  >
	<label style="">Pk_tabla:</label>
	<input type="text" name="pk_tabla" class="txt_pk_tabla" value="<?php echo $this->datos['pk_tabla']; ?>" style="width:500px;" />
</div>
<div class="inputBox" style="margin-bottom:8px;display:block;margin-left:10px;width:100%;"  >
	<label style="">Icono:</label>
	<input type="text" name="icono" class="txt_icono" value="<?php echo $this->datos['icono']; ?>" style="width:500px;" />
</div>
<div class="inputBox" style="margin-bottom:8px;display:block;margin-left:10px;width:100%;"  >
	<label style="">Titulo_nuevo:</label>
	<input type="text" name="titulo_nuevo" class="txt_titulo_nuevo" value="<?php echo $this->datos['titulo_nuevo']; ?>" style="width:500px;" />
</div>
<div class="inputBox" style="margin-bottom:8px;display:block;margin-left:10px;width:100%;"  >
	<label style="">Titulo_edicion:</label>
	<input type="text" name="titulo_edicion" class="txt_titulo_edicion" value="<?php echo $this->datos['titulo_edicion']; ?>" style="width:500px;" />
</div>
<div class="inputBox" style="margin-bottom:8px;display:block;margin-left:10px;width:100%;"  >
	<label style="">Titulo_busqueda:</label>
	<input type="text" name="titulo_busqueda" class="txt_titulo_busqueda" value="<?php echo $this->datos['titulo_busqueda']; ?>" style="width:500px;" />
</div>
<div class="inputBox" style="margin-bottom:8px;display:block;margin-left:10px;width:100%;"  >
	<label style="">Msg_creado:</label>
	<input type="text" name="msg_creado" class="txt_msg_creado" value="<?php echo $this->datos['msg_creado']; ?>" style="width:500px;" />
</div>
<div class="inputBox" style="margin-bottom:8px;display:block;margin-left:10px;width:100%;"  >
	<label style="">Msg_actualizado:</label>
	<input type="text" name="msg_actualizado" class="txt_msg_actualizado" value="<?php echo $this->datos['msg_actualizado']; ?>" style="width:500px;" />
</div>
<div class="inputBox" style="margin-bottom:8px;display:block;margin-left:10px;width:100%;"  >
	<label style="">Pregunta_eliminar:</label>
	<input type="text" name="pregunta_eliminar" class="txt_pregunta_eliminar" value="<?php echo $this->datos['pregunta_eliminar']; ?>" style="width:500px;" />
</div>
<div class="inputBox" style="margin-bottom:8px;display:block;margin-left:10px;width:100%;"  >
	<label style="">Msg_eliminado:</label>
	<input type="text" name="msg_eliminado" class="txt_msg_eliminado" value="<?php echo $this->datos['msg_eliminado']; ?>" style="width:500px;" />
</div>
<div class="inputBox" style="margin-bottom:8px;display:block;margin-left:10px;width:100%;"  >
	<label style="">Msg_cambios:</label>
	<input type="text" name="msg_cambios" class="txt_msg_cambios" value="<?php echo $this->datos['msg_cambios']; ?>" style="width:500px;" />
</div>

		</form>
	</div>
</div>
