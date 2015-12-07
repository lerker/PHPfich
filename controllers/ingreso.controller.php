<?php

class Ingreso_Controller {

	var $messages = null;

	function main() {
		$tpl = new TemplatePower("templates/menu.html");
    	$tpl->prepare();
    	$tpl->gotoBlock("_ROOT");	# desde el comienzo

        //----------------------------------
        //      LISTADOS
        //
    	$tpl->newBlock("blockItemMenu");
            $tpl->assign("var_link_direccion", "index.php?action=Pelicula::listadoPeliculas");
            $tpl->assign("var_link_mostrar", "Listado de Peliculas");

<<<<<<< HEAD
		$tpl->newBlock("blockItemMenu");
		$tpl->assign("var_link_direccion", "index.php?action=Artista::listadoArtistas");
		$tpl->assign("var_link_mostrar", "Listado de Artistas");
=======
        $tpl->newBlock("blockItemMenu");
            $tpl->assign("var_link_direccion", "index.php?action=Pelicula::peliculasPorGenero");
            $tpl->assign("var_link_mostrar", "Listado de Peliculas por Genero");
>>>>>>> wachop

        $tpl->newBlock("blockItemMenu");
            $tpl->assign("var_link_direccion", "index.php?action=Director::peliculasPorDirector");
            $tpl->assign("var_link_mostrar", "Listado de Peliculas por Director");

        $tpl->newBlock("blockItemMenu");
            $tpl->assign("var_link_direccion", "index.php?action=Artista::listadoArtistas");
            $tpl->assign("var_link_mostrar", "Listado de Artistas");

<<<<<<< HEAD
		$tpl->newBlock("blockItemMenu");
		$tpl->assign("var_link_direccion", "index.php?action=Genero::listadoGeneros");
		$tpl->assign("var_link_mostrar", "Listado de Generos");

        $tpl->newBlock("blockItemMenu");
        $tpl->assign("var_link_direccion", "index.php?action=Sala::listarSalas");
        $tpl->assign("var_link_mostrar", "Listado de Salas");

        //-----------------------------
        //      ABM
        //

		$tpl->newBlock("blockItemMenu");
		$tpl->assign("var_link_direccion", "index.php?action=Pelicula::altaPelicula");
		$tpl->assign("var_link_mostrar", "Alta Pel&iacute;cula");

=======
        $tpl->newBlock("blockItemMenu");
            $tpl->assign("var_link_direccion", "index.php?action=Actor::listadoActores");
            $tpl->assign("var_link_mostrar", "Listado de Actores");

        $tpl->newBlock("blockItemMenu");
            $tpl->assign("var_link_direccion", "index.php?action=Director::listadoDirectores");
            $tpl->assign("var_link_mostrar", "Listado de Directores");

        $tpl->newBlock("blockItemMenu");
            $tpl->assign("var_link_direccion", "index.php?action=Genero::listadoGeneros");
            $tpl->assign("var_link_mostrar", "Listado de Generos");

        $tpl->newBlock("blockItemMenu");
            $tpl->assign("var_link_direccion", "index.php?action=Pelicula::eliminarPelicula");
            $tpl->assign("var_link_mostrar", "Eliminar una Pelicula");

        // simplemente una prueba de agregar otro
        $tpl->newBlock("blockItemMenu");
            $tpl->assign("var_link_direccion", "index.php?action=Pelicula::altaPelicula");
            $tpl->assign("var_link_mostrar", "Alta Pel&iacute;cula");

        $tpl->newBlock("blockItemMenu");
            $tpl->assign("var_link_direccion", "index.php?action=Actor::altaActor");
            $tpl->assign("var_link_mostrar", "Alta Actor");

        $tpl->newBlock("blockItemMenu");
            $tpl->assign("var_link_direccion", "index.php?action=Director::altaDirector");
            $tpl->assign("var_link_mostrar", "Alta Director");

>>>>>>> wachop
        $tpl->newBlock("blockItemMenu");
            $tpl->assign("var_link_direccion", "index.php?action=Artista::AltaArtista");
            $tpl->assign("var_link_mostrar", "Alta Artista");

        $tpl->newBlock("blockItemMenu");
<<<<<<< HEAD
        $tpl->assign("var_link_direccion", "index.php?action=Actor::altaActor");
        $tpl->assign("var_link_mostrar", "Alta Actor");

        $tpl->newBlock("blockItemMenu");
        $tpl->assign("var_link_direccion", "index.php?action=Director::altaDirector");
        $tpl->assign("var_link_mostrar", "Alta Director");
=======
            $tpl->assign("var_link_direccion", "index.php?action=Sala::listarSalas");
            $tpl->assign("var_link_mostrar", "Listado de Salas");
>>>>>>> wachop

        $tpl->newBlock("blockItemMenu");
            $tpl->assign("var_link_direccion", "index.php?action=Sala::altaSala");
            $tpl->assign("var_link_mostrar", "Alta de Sala");

        $tpl->newBlock("blockItemMenu");
        $tpl->assign("var_link_direccion", "index.php?action=Genero::altaGenero");
        $tpl->assign("var_link_mostrar", "Alta de Genero");



    return $tpl->getOutputContent();
  }


}
