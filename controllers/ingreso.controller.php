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
		$tpl->assign("var_link_direccion", "index.php?action=Artista::listadoArtistas");
		$tpl->assign("var_link_mostrar", "Listado de Artistas");

		$tpl->newBlock("blockItemMenu");
		$tpl->assign("var_link_direccion", "index.php?action=Actor::listadoActores");
		$tpl->assign("var_link_mostrar", "Listado de Actores");

		$tpl->newBlock("blockItemMenu");
		$tpl->assign("var_link_direccion", "index.php?action=Actor::listadoActoresPorPelicula");
		$tpl->assign("var_link_mostrar", "Listado de Actores por Pelicula");

		$tpl->newBlock("blockItemMenu");
		$tpl->assign("var_link_direccion", "index.php?action=Genero::listadoGeneros");
		$tpl->assign("var_link_mostrar", "Listado de Generos");

		$tpl->newBlock("blockItemMenu");
		$tpl->assign("var_link_direccion", "index.php?action=Pelicula::eliminarPelicula");
		$tpl->assign("var_link_mostrar", "Eliminar una Pelicula");

		$tpl->newBlock("blockItemMenu");
		$tpl->assign("var_link_direccion", "index.php?action=Actor::eliminarActor");
		$tpl->assign("var_link_mostrar", "Eliminar un Actor");

		// simplemente una prueba de agregar otro
		$tpl->newBlock("blockItemMenu");
		$tpl->assign("var_link_direccion", "index.php?action=Pelicula::altaPelicula");
		$tpl->assign("var_link_mostrar", "Alta Pel&iacute;cula");

		$tpl->newBlock("blockItemMenu");
		$tpl->assign("var_link_direccion", "index.php?action=Artista::altaArtista");
		$tpl->assign("var_link_mostrar", "Alta Artista");

		$tpl->newBlock("blockItemMenu");
		$tpl->assign("var_link_direccion", "index.php?action=Artista::bajaArtista");
		$tpl->assign("var_link_mostrar", "Baja Artista");

		$tpl->newBlock("blockItemMenu");
		$tpl->assign("var_link_direccion", "index.php?action=Artista::modificarArtista");
		$tpl->assign("var_link_mostrar", "Modificar Artista");

		$tpl->newBlock("blockItemMenu");
		$tpl->assign("var_link_direccion", "index.php?action=Actor::bajaActor");
		$tpl->assign("var_link_mostrar", "Baja Actor");

		$tpl->newBlock("blockItemMenu");
		$tpl->assign("var_link_direccion", "index.php?action=Genero::altaGenero");
		$tpl->assign("var_link_mostrar", "Alta Genero");

		$tpl->newBlock("blockItemMenu");
		$tpl->assign("var_link_direccion", "index.php?action=Genero::bajaGenero");
		$tpl->assign("var_link_mostrar", "Baja Genero");

		$tpl->newBlock("blockItemMenu");
		$tpl->assign("var_link_direccion", "index.php?action=Genero::modificarGenero");
		$tpl->assign("var_link_mostrar", "Modificar Genero");

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
