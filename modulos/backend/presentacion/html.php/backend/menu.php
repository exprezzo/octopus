<style>

#<?php echo $_REQUEST['tabId']; ?>{
	padding: 0;
	margin: 0;
}


.menu_page_header{
	padding: 10px;	
}

.menu_page_header h1{
	padding: 0px;	
	margin: 0px;	
}

.menu_page_header h3{
	display: inline-block;
	font-size: 14px;
	padding: 0;
	margin: 0;
	text-align: right;
	width: 163px;
}
.menu_ico{
	width:32px;
	height:32px;
}
.menu_item a{
	text-decoration:none;
}

.menu_item label{
	cursor: pointer;
	top: 18px;
	left: 51px;
	position: absolute;
}
.menu_item{
	list-style: none;
	position: relative;
	width: 200px;
	float: left;
	padding: 10px;
}
.menuTabs{
	margin:5px;
}
.menuTabs  ul.ui-tabs-nav{
	width:auto !important;
	min-height:auto !important;
	
}

</style>
<div class="menu_page_header">
<h1 style="display:inline-block;"><?php echo $APP_CONFIG['nombre']; ?></h1>
<h3 style="display:block;font-size:14px;">Menu principal</h3>
</div>



<div class="menuTabs">
<ul>
<?php
	$tabId=0;
	
	// print_r($_SESSION);
	foreach($this->modulos as $mod){
		 // if ($mod['id']==1 && $_SESSION['userInfo']['rol']!=1) continue;
		echo '<li><a href="#menuTabs-tabs-'.$tabId.'">'.$mod['nombre'].'</a></li>';		
		$tabId++;
	}
?>
</ul>
<?php
	$tabId=0;
	foreach($this->modulos as $mod){
		// if ($mod['id']==1 && $_SESSION['userInfo']['rol']!=1) continue;
		
		echo '<div id="menuTabs-tabs-'.$tabId.'"> <ul>';
		foreach($mod['catalogos'] as $cat){			
			echo '<li class="menu_item"><a  controlador="'.$cat['controlador'].'"  tablink="true" href="'.$_PETICION->url_app.$mod['nombre_interno'].'/'.$cat['controlador'].'/busqueda">'.
			'<img class="menu_ico" src="'.$cat['icono'].'" />'.
			'<label>'.$cat['nombre'].'</label></a></li>';
		}
		$tabId++;
		echo '</ul></div>';
	}
?>
<ul style="display:inline-block;">
	<?php

	
	?>
	</ul>
<!--div id="menuTabs-tabs-1">
	<ul style="display:inline-block;">
		<li class="menu_item"><a  controlador="catalogos"  tablink="true" href="/catalogos/busqueda">
			<img class="menu_ico" src="http://png.findicons.com/files/icons/577/refresh_cl/48/windows_view_icon.png" />
			<label>Manejador de Catalogos</label></a>
		</li>
		<li class="menu_item"><a  controlador="usuarios"  tablink="true" href="/usuarios/busqueda">
			<img class="menu_ico" src="http://png.findicons.com/files/icons/1620/crystal_project/64/personal.png" />
			<label>Usuarios</label></a>
		</li>
		<li class="menu_item"><a  controlador="modulos"  tablink="true" href="/modulos/busqueda">
			<img class="menu_ico" src="http://png.findicons.com/files/icons/1681/siena/48/puzzle_yellow.png" />
			<label>Modulos</label></a>
		</li>
		<li class="menu_item"><a  controlador="seguridad"  tablink="true" href="/seguridad/busqueda">
			<img class="menu_ico" src="http://png.findicons.com/files/icons/1035/human_o2/48/keepassx.png" />
			<label>Seguridad</label></a>
		</li>
		<li class="menu_item"><a  controlador="config"  tablink="true" href="/config/busqueda">
			<img class="menu_ico" src="http://png.findicons.com/files/icons/108/pastel/64/configuration_settings.png" />
			<label>Configuracion General</label></a>
		</li>
		
	</ul>
</div-->

</div>

<script>
	$().ready(function(){	
		var tabId='<?php echo $_REQUEST['tabId']; ?>';
		// $('#'+tabId).addClass('pedido');
		// alert('#'+tabId+'[tablink="true"]');
		
            $('#'+tabId+" .menuTabs").wijtabs({
				// alignment: 'left'
			});
        
		
		
		var links=$('#'+tabId+' [tablink="true"]');
		
		$.each(links, function(index, element) {
			var link=$(element);
			if ( !link.attr )  return false;
			var destino=link.attr('href');
			link.attr('href','#');
			
			link.attr('tablink',false);
			link.addClass('link');
			
			var img=link.find('img');
			var ruta=img.attr('src');
			var controlador=link.attr('controlador');
						
			link.click(function(){			
				TabManager.add(destino,'Cargando...',0,'tab_'+controlador);
			});
		});
	});
</script>
