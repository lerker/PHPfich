<?php

class Ingreso_Controller {

	var $messages = null;

	function main() {
		$tpl = new TemplatePower("templates/menu.html");
    	$tpl->prepare();
    	$tpl->gotoBlock("_ROOT");	# desde el comienzo

    	$tpl->newBlock("blockItemMenu");
    	$tpl->assign("var_link_direccion", "index.php?action=Pelicula::listadoPeliculas");
		$tpl->assign("var_link_mostrar", "Listado de Peliculas");

		$tpl->newBlock("blockItemMenu");
		$tpl->assign("var_link_direccion", "index.php?action=Pelicula::peliculasPorGenero");
		$tpl->assign("var_link_mostrar", "Listado de Peliculas por Genero");

		$tpl->newBlock("blockItemMenu");
		$tpl->assign("var_link_direccion", "index.php?action=Pelicula::peliculasPorDirector");
		$tpl->assign("var_link_mostrar", "Listado de Peliculas por Director");


		$tpl->newBlock("blockItemMenu");
		$tpl->assign("var_link_direccion", "index.php?action=Pelicula::listadoActores");
		$tpl->assign("var_link_mostrar", "Listado de Actores");

		$tpl->newBlock("blockItemMenu");
		$tpl->assign("var_link_direccion", "index.php?action=Pelicula::listadoActoresPorPelicula");
		$tpl->assign("var_link_mostrar", "Listado de Actores por Pelicula");

		$tpl->newBlock("blockItemMenu");
		$tpl->assign("var_link_direccion", "index.php?action=Pelicula::eliminarPelicula");
		$tpl->assign("var_link_mostrar", "Eliminar una Pelicula");

		$tpl->newBlock("blockItemMenu");
		$tpl->assign("var_link_direccion", "index.php?action=Pelicula::eliminarActor");
		$tpl->assign("var_link_mostrar", "Eliminar un Actor");

		// simplemente una prueba de agregar otro
		$tpl->newBlock("blockItemMenu");
		$tpl->assign("var_link_direccion", "index.php?action=Pelicula::altaPelicula");
		$tpl->assign("var_link_mostrar", "Alta Pel&iacute;cula");

		$tpl->newBlock("blockItemMenu");
		$tpl->assign("var_link_direccion", "index.php?action=Pelicula::altaArtista");
		$tpl->assign("var_link_mostrar", "Alta Artista");

		$tpl->newBlock("blockItemMenu");
		$tpl->assign("var_link_direccion", "index.php?action=Pelicula::bajaActor");
		$tpl->assign("var_link_mostrar", "Baja Actor");

    return $tpl->getOutputContent();
  }

 
}


#$peliculas->listadoPeliculas();
#$peliculas->peliculasPorGenero(1);
#$peliculas->peliculasPorDirector(1);


#$peliculas->listadoActores();
#$peliculas->listadoActoresPorPelicula(7);


#echo $peliculas->eliminarPelicula(8);
#echo $peliculas->eliminarActor("coso");
#echo $peliculas->cambiarGenero('Titanic',4);