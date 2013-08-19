<style>
.main_menu li{
	display:inline-block; margin-right:20px;
}
.main_menu a {text-decoration:none; color:#666666;}
</style>
<ul class="main_menu">
	<?php 	
	foreach($this->menus as $menu){
		echo '<li><a href="'.$_PETICION->url_app.$menu['target'].'">'.$menu['titulo'].'</a></li>';
	}
	?>	
</ul>