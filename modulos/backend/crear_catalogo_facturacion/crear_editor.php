<?php
function crear_editor($params){
	
	$nombreModelo=$params['modelo'];
	$nombreControlador=$params['controlador'];
	$campos=$params['fields'];
	$icon = $params['campos']['icono'];
	$titulo = $params['campos']['titulo_nuevo'];
	
	global $_PETICION;
	// $ruta='../'.$_PETICION->modulo.'/vistas/'.$nombreControlador.'/';	
	// $ruta='../'.$params['ruta_base'].$params['modulo'].'temas/default/vistas/'.$nombreControlador.'/';	
	$ruta='../'.$params['ruta_base'].$params['modulo'].'/temas/default/vistas/'.$nombreControlador.'/';	
	if ( !file_exists($ruta) ){
		mkdir($ruta, 0700, true);
	}
	
	$divs='';
	for($i=0; $i<sizeof($campos); $i++ ){
		// if ($campos[$i]=='id') continue;
		
$divs.='
				<div class="inputBox" style=""  >
					<label style="">'.ucwords(strtolower($campos[$i])) .':</label>
					<input type="text" name="'.$campos[$i].'" class="entradaDatos" value="<?php echo $this->datos[\''.$campos[$i].'\']; ?>" style="width:500px;" />
				</div>'.PHP_EOL;
	}
$contenido='
<?php
	$id=$_PETICION->controlador.\'-\'.$_PETICION->accion;
	$_REQUEST[\'tabId\'] =$id;
?>
<script src="<?php echo $_PETICION->url_web; ?>js/catalogos/<?php echo $_PETICION->controlador; ?>/edicion.js"></script>

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
				nombre:\''. $params['catalogo'].'\',
				modelo:\''. ucfirst( $params['modelo'] ).'\'
			},			
			pk:"'.$params['pk_tabla'].'"
			
		};				
		 var editor=new Edicion'. $nombreControlador.'();
		 editor.init(config);		
	});
</script>
<style>
.entradaDatos, input[role="textbox"]{
	/* float:right; */
	background-color:#f2f2f2  !important;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	border-radius: 5px;
	border-top: 0px;
	border-right: 0px;
	border-left: 0px;
	border-bottom-color:#508b96  !important;
	border-bottom-style:solid !important;
	border-bottom-width:1px  !important;
	-webkit-box-shadow: 0px 3px #d6e6e9  !important;
    -moz-box-shadow: 0px 3px #d6e6e9  !important;
	box-shadow: 0px 3px #d6e6e9  !important;
	/* width:365px; */
	height:23px;
	/*height:43px;*/
	/* margin-bottom:25px; */
	font-family:"OpenSans-Light", sans-serif;
	font-size:17px;
	
	color:black  !important;
}
</style>
<div class="contenedor_formulario" id="<?php echo $id; ?>">
	<div id="titulo">
    	<h1>'.$titulo.'</h1>
	</div>
	<div id="cuerpo" >				
		<div id="contenedorDatos2">
			<form class="frmEdicion" style="">
				'.$divs.'
			</form>
			<div id="contenedorMenu2" class="toolbarEdicion">
				<input type="submit" value="Nuevo" class="botonNuevo btnNuevo">
				<input type="submit" value="Guardar" class="botonNuevo btnGuardar">
				<input type="submit" value="Eliminar" class="botonNuevo sinMargeDerecho btnDelete">
			</div>
		</div>		
	</div>
</div>';
	
	
	$rutaCompleta=$ruta.'edicion.php';	
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
	
	// crearEditor2($ruta, $params);
	// crearEditor3($ruta);
}

?>