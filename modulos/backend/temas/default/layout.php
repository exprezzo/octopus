<?php
 // 
 
 
if ( !isset($_SESSION['isLoged'])|| $_SESSION['isLoged']!=true ){	
	
	// print_r(); exit;
	
	$_SESSION['login_redirect']=$_PETICION->modulo.'/'.$_PETICION->controlador.'/'.$_PETICION->accion;	
	 // print_r($_SESSION); exit;
	header ('Location: '.$_PETICION->url_app.$_PETICION->modulo.'/user/login'); exit;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="us">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title><?php echo $APP_CONFIG['nombre']; ?></title>
	<!--jQuery References-->
	
	
	<script src="<?php echo $_PETICION->url_web_mod; ?>libs/jquery-1.8.3.js"></script>
	<script src="<?php echo $_PETICION->url_web_mod; ?>libs/jquery-ui-1.9.2.custom/jquery-ui-1.9.2.custom.js"></script>  
	
	
	<!--Theme-->	
	<?php 
		global $_TEMAS;
		//$rutaTema=$_TEMAS[TEMA];
		
		$rutaTema=getUrlTema('artic');
		$rutaTema=getUrlTema($APP_CONFIG['tema']);
		
		$rutaMod=$_PETICION->url_app.'web/<?php echo $_PETICION->modulo; ?>/css/mods/black-tie/black-tie.css';
	?>
	
	
	<link href="<?php echo $rutaTema; ?>" rel="stylesheet" type="text/css" />
	<!--link href="<?php //echo $rutaMod; ?>" rel="stylesheet" type="text/css" /-->
	
	
	
	<!--Wijmo Widgets CSS-->	
	<link href="<?php echo $_PETICION->url_web_mod; ?>libs/Wijmo.2.3.2/Wijmo-Complete/css/jquery.wijmo-complete.2.3.2.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo $_PETICION->url_web_mod; ?>libs/Wijmo.2.3.2/Wijmo-Open/css/jquery.wijmo-open.2.3.2.css" rel="stylesheet" type="text/css" />			
	<!--link href="/css/themes/blitzer/jquery-ui-1.9.2.custom.css" rel="stylesheet"-->	
	<!--Wijmo Widgets JavaScript-->
	<script src="<?php echo $_PETICION->url_web_mod; ?>libs/Wijmo.2.3.2/Wijmo-Complete/js/jquery.wijmo-complete.all.2.3.2.js" type="text/javascript"></script>
	<script src="<?php echo $_PETICION->url_web_mod; ?>libs/Wijmo.2.3.2/Wijmo-Open/js/jquery.wijmo-open.all.2.3.2.js" type="text/javascript"></script>		
	<!-- Gritter -->
	<link href="<?php echo $_PETICION->url_web_mod; ?>libs/Gritter-master/css/jquery.gritter.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo $_PETICION->url_web_mod; ?>libs/Gritter-master/js/jquery.gritter.min.js" type="text/javascript"></script>
	
	
	<script src="<?php echo $_PETICION->url_web_mod; ?>libs/shortcut.js"></script>  
	
	<link href="<?php echo $_PETICION->url_web_mod; ?>css/estilos.css" rel="stylesheet" type="text/css" />		
	
	<script src="<?php echo $_PETICION->url_web_mod; ?>js/funciones.js" type="text/javascript"></script>
	<script src="<?php echo $_PETICION->url_web_mod; ?>js/TabManager.js" type="text/javascript"></script>
	<script src="<?php echo $_PETICION->url_web_mod; ?>js/navegacion_en_tabla.js" type="text/javascript"></script>
	<script src="<?php echo $_PETICION->url_web_mod; ?>js/navegacion_en_tabla_agrupada.js" type="text/javascript"></script>
	
	<script type="text/javascript">		
		kore={
			modulo:'<?php echo $_PETICION->modulo; ?>',
			controlador:'<?php echo $_PETICION->controlador; ?>',
			accion:'<?php echo $_PETICION->accion; ?>',
			url_base:'<?php echo $_PETICION->url_app; ?>',
			mod_url_base:'<?php echo $_PETICION->url_mod; ?>',			
			url_web_mod:'<?php echo $_PETICION->url_web_mod; ?>',
			decimalPlacesMoney:2
			// dafault:{
				// modulo:
				// controlador:
				// accion:
			// }			
		};
		
		salir=function(){		
			window.location=kore.mod_url_base+'usuarios/logout';
		}
		$(function () {
		
			shortcut.add("Ctrl+Alt+C", 
				function() { 
					TabManager.add(kore.mod_url_base+'catalogos/busqueda','Menu',0);
					
				}, 
				{ 'type':'keydown', 'propagate':false, 'target':document}
			);
			
			shortcut.add("Ctrl+Alt+M", 
				function() { 
					TabManager.add(kore.mod_url_base+'/backend/menu','Menu');
					
				}, 
				{ 'type':'keydown', 'propagate':false, 'target':document}
			);
			
			shortcut.add("Ctrl+Alt+G", 
				function() { 
					var tab=$('#tabs > div[aria-hidden="false"]');
					var tabObj = tab.data('tabObj');
					if (tabObj!=undefined && tabObj.guardar!=undefined){
						tabObj.guardar();
					}
					
				}, 
				{ 'type':'keydown', 'propagate':false, 'target':document}
			);
			
			shortcut.add("Ctrl+S", 
				function() { 
					var tab=$('#tabs > div[aria-hidden="false"]');
					var tabObj = tab.data('tabObj');
					if (tabObj!=undefined && tabObj.guardar!=undefined){
						tabObj.guardar();
					}
					
				}, 
				{ 'type':'keydown', 'propagate':false, 'target':document} 
			);  
			
			
			
			shortcut.add("Ctrl+Alt+W", 
				function() { 
					//busca el tab seleccionado
					var tab=$('#tabs > div[aria-hidden="false"]');
					var idTab=tab.attr('id');					
					var tabs=$('#tabs > div');
					for(var i=0; i<tabs.length; i++){
						if ( $(tabs[i]).attr('id') == idTab ){
							$('#tabs').wijtabs('remove', i);
						}
					}
					
					
				}, 
				{ 'type':'keydown', 'propagate':false, 'target':document} 
			); 
			
			
			
			shortcut.add("Ctrl+Alt+N", 
				function() { 
					var tab=$('#tabs > div[aria-hidden="false"]');
					var tabObj = tab.data('tabObj');
					if (tabObj!=undefined && tabObj.nuevo!=undefined){
						tabObj.nuevo();
					}
					
				}, 
				{ 'type':'keydown', 'propagate':false, 'target':document} 
			); 
			
			shortcut.add("Ctrl+Alt+B", 
				function() { 
					var tab=$('#tabs > div[aria-hidden="false"]');
					var tabObj = tab.data('tabObj');
					if (tabObj!=undefined && tabObj.borrar!=undefined){
						tabObj.borrar();
					}
					
					if (tabObj!=undefined && tabObj.eliminar!=undefined){						
					}
					
				}, 
				{ 'type':'keydown', 'propagate':false, 'target':document} 
			); 
			
			$.extend($.gritter.options, { 
				position: 'bottom-right', // defaults to 'top-right' but can be 'bottom-left', 'bottom-right', 'top-left', 'top-right' 
				fade_in_speed: 'medium', // how fast notifications fade in (string or int)
				fade_out_speed: 2000, // how fast the notices fade out
				time: 6000 // hang on the screen for...
			});
			
			TabManager.init('#tabs');
			
			//Agregar opcion para salir
			
			ajustarTab(); //Ajusta la altura al tamaño en relacion al tamaño de la pantalla
			iniciarLinkTabs(); //A los objetos con atributo linkTab=true,  se les agrega comportamiento ajax para abrir tabs.
			
			// TabManager.add('/'+kore.modulo+'/general/welcome','Bienvenido');
			// TabManager.add('/'+kore.modulo+'/pedidoi/verlista','Busqueda');
			// TabManager.add('/'+kore.modulo+'/orden_compra/index','Orden de Compra',1,'');			
			// TabManager.add('/'+kore.modulo+'/pedidoi/verlista','Nuevo');			 
			 // TabManager.add('/'+kore.modulo+'/catalogos/busqueda','Busqueda',0);
			 TabManager.add(kore.url_base+'backend/backend/menu','Menu',0,'tabMenu');
			
			// TabManager.add('/'+kore.modulo+'/series/busqueda','Busqueda',0);
			// TabManager.add('/'+kore.modulo+'/estadopedidos/busqueda','Busqueda',0);
			// TabManager.add('/'+kore.modulo+'/stocks/busqueda','Busqueda',0);
			// TabManager.add('/'+kore.modulo+'/productos/busqueda','Busqueda',0);
			// TabManager.add('/'+kore.modulo+'/catalogos/busqueda','Busqueda',0);
						
			//TabManager.add('/'+kore.modulo+'/'+kore.controlador+'/'+kore.accion+'/');
			
			//TabManager.add('/'+kore.modulo+'/pedidoi/pedido');
			//TabManager.add('/'+kore.modulo+'/pedidoi/editar/580');
			//$('#tabs > ul').append('');
			
			$(window).resize( function() {
			  ajustarTab();
			});
			
			$('.user_widget a').mouseenter(function(){
				$(this).addClass('ui-state-hover');
			});			
			$('.user_widget a').mouseleave(function(){
				$(this).removeClass('ui-state-hover');
			});
			
			$('.header_empresa').mouseenter(function(){
				$(this).addClass('ui-state-hover');
			});
			$('.header_empresa').mouseleave(function(){
				$(this).removeClass('ui-state-hover');
			});
			
			//$("#splitter").wijsplitter({ orientation: "horizontal" });
			
			 $(".accesos_directos").wijcarousel({
                display: 12,
                step: 4,
                orientation: "horizontal"
            });			
			
			$('.link-salir').mouseenter(function(){
				$(this).addClass('ui-state-hover');
			});
			$('.link-salir').mouseleave(function(){
				$(this).removeClass('ui-state-hover');
			});
		});
		
		
    
	</script>
	<style type="text/css">		
		@media only screen and (max-width: 999px) {	  } 									/* rules that only apply for canvases narrower than 1000px */
		@media only screen and (device-width: 768px) and (orientation: landscape) {} 		/* rules for iPad in landscape orientation */
		@media only screen and (min-device-width: 320px) and (max-device-width: 480px) {}	/* iPhone, Android rules here */		
		.link{cursor:pointer;}
		.ui-tabs .ui-tabs-nav{	/* border-bottom:0; */	}
		 /*.ui-tabs .ui-tabs-hide {display: inline-block !important;}		*/
		 .tbPedido.ui-tabs-hide {display: inline-block !important;}		
		.main_header{display: none;width: 100%;border: 0;}
		
		.wijmo-wijsplitter-h-panel1.ui-resizable{
				transition:height .5s;
				-moz-transition:height .5s; 			/* Firefox 4 */
				-webkit-transition:height .5s; 			/* Safari and Chrome */
				-o-transition:height .5s; 				/* Opera */					
		}
		
		.eliminado td{
			background-color:#F9DADA !important;
		}
		#tabs > ul > li.ui-state-active{
			background: #ffe475 url(images/ui-bg_inset-hard_100_ffe475_1x100.png) bottom repeat-x !important;
		}
	</style>	
</head>
<body style="padding:0; margin:0;" class="" >	
	
		<div id="tabs">
			 <ul>			
			</ul>		
		</div>	
		
		<div class="ui-state-default link-salir" style=""><a onclick="salir()" href="#" >Salir</a></div>			
</body>
</html>
<?php 

function getUrlTema($tema){
	$_TEMAS=array();
	global $_PETICION;
	// print_r($_PETICION);
	$_TEMAS['artic']="http://cdn.wijmo.com/themes/arctic/jquery-wijmo.css";
	$_TEMAS['midnight']="http://cdn.wijmo.com/themes/midnight/jquery-wijmo.css";
	$_TEMAS['aristo']="http://cdn.wijmo.com/themes/aristo/jquery-wijmo.css";
	// $_TEMAS['rocket']="http://cdn.wijmo.com/themes/rocket/jquery-wijmo.css";
	$_TEMAS['rocket']=$_PETICION->url_web_mod. "libs/temas_wijmo/rocket/jquery-wijmo.css";
	$_TEMAS['cobalt']="http://cdn.wijmo.com/themes/cobalt/jquery-wijmo.css";
	$_TEMAS['sterling']="http://cdn.wijmo.com/themes/sterling/jquery-wijmo.css";
	$_TEMAS['black-tie']="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/themes/black-tie/jquery-ui.css";
	$_TEMAS['blitzer']="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/themes/blitzer/jquery-ui.css";
	$_TEMAS['cupertino']="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/themes/cupertino/jquery-ui.css";
	$_TEMAS['dark-hive']="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/themes/dark-hive/jquery-ui.css";
	$_TEMAS['dot-luv']="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/themes/dot-luv/jquery-ui.css";
	$_TEMAS['eggplant']="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/themes/eggplant/jquery-ui.css";
	$_TEMAS['excite-bike']="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/themes/excite-bike/jquery-ui.css";
	$_TEMAS['flick']="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/themes/flick/jquery-ui.css";
	$_TEMAS['hot-sneaks']="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/themes/hot-sneaks/jquery-ui.css";
	$_TEMAS['humanity']="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/themes/humanity/jquery-ui.css";
	$_TEMAS['le-frog']="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/themes/le-frog/jquery-ui.css";
	$_TEMAS['mint-choc']="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/themes/mint-choc/jquery-ui.css";
	$_TEMAS['vader']="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/themes/vader/jquery-ui.css";
	$_TEMAS['ui-lightness']="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/themes/ui-lightness/jquery-ui.css";
	$_TEMAS['ui-darkness']="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/themes/ui-darkness/jquery-ui.css";
	$_TEMAS['trontastic']="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/themes/trontastic/jquery-ui.css";
	$_TEMAS['swanky-purse']="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/themes/swanky-purse/jquery-ui.css";
	$_TEMAS['sunny']="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/themes/sunny/jquery-ui.css";
	$_TEMAS['start']="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/themes/start/jquery-ui.css";
	$_TEMAS['south-street']="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/themes/south-street/jquery-ui.css";
	$_TEMAS['smoothness']="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/themes/smoothness/jquery-ui.css";
	$_TEMAS['redmond']="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/themes/redmond/jquery-ui.css";
	$_TEMAS['pepper-grinder']="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/themes/pepper-grinder/jquery-ui.css";
	$_TEMAS['overcast']="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/themes/overcast/jquery-ui.css";
	return $_TEMAS[$tema];
}

?>