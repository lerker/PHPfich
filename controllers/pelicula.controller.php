<?php

class Pelicula_Controller{
    var $messages = null;

    function listadoPeliculas(){

        $model = new Pelicula_Model();
        $modelActores = new Actor_Model();

        $listado = $model->listadoPeliculas();

        # llamo al template para la vista, la modifico a gusto
        $tpl = new TemplatePower("templates/listadoPeliculas.html"); # creo el template
        $tpl->prepare();  # segunda linea necesaria
        $tpl->gotoBlock("_ROOT"); # desde el comienzo

        # formateo del encabezado de la tabla
        $titulo_tabla = "<h1> LISTADO DE PELICULAS </h1>";
        $subtitulo_tabla = "<strong><i> Cantidad: ".count($listado)."</i></strong>";
        $tpl->assign("var_titulo_tabla",  $titulo_tabla);
        $tpl->assign("var_subtitulo_tabla",  $subtitulo_tabla);

        if ($listado){
            $tpl->gotoBlock("_ROOT");
            # para cada pelicula que retorna
            foreach ($listado as $data) {
                # genero la lista de los actores, segun el id de pelicula
                $actores = $modelActores->listadoActoresPorPelicula($data["id_pelicula"]);
                $act = array();
                if ($actores){
                    foreach ($actores as $key) { #para todos los resultados, me quedo con el nombre artistico
                    array_push($act, $key["ac_nombreArtistico"]);
                    }
                }
                $tpl->newBlock("blockPelicula");
                    //$tpl->assign("var_id_peli", $data["id_pelicula"]);
                $tpl->assign("var_nom_peli", $data["pe_nombre"]);
                $tpl->assign("var_gen_peli", $data["ge_nombre"]);
                $tpl->assign("var_dir_peli", $data["di_nombreArtistico"]);
                $tpl->assign("var_dur_peli", $data["pe_duracion"]);
                $tpl->assign("var_act_peli", implode(", ", $act));
                $tpl->assign("var_id_peli",  $data["id_pelicula"]);
            }
        }
        else{ // no hay peliculas
          $tpl->gotoBlock("_ROOT");
          $tpl->newBlock("block_no_Peliculas");
          $tpl->assign("var_texto_no_pelicula", "<b>NO HAY PELICULAS EN LA BASE DE DATOS</b>");
        }
        return $tpl->getOutputContent();
    }

    # TODO borrar esto a futuro, dejar la tercera funcion,
    function peliculasPorGenero($id_genero=0) {
        $model = new Pelicula_Model();

        $listado = $model->peliculasPorGenero($id_genero);

        $tpl = new TemplatePower("templates/listadoPeliculas.html"); # creo el template
        $tpl->prepare();  # segunda linea necesaria
        $tpl->gotoBlock("_ROOT"); # desde el comienzo

        #formateo del encabezado de la tabla
        $tpl->assign("var_titulo_tabla",  " LISTADO DE PELICULAS POR 'GENERO' ");
        $tpl->assign("var_subtitulo_tabla",  "Genero: ".$id_genero."  Cantidad: ".count($listado));

        # si listado retorno algo, NO ESTA VACIO
        if ($listado){
            $tpl->gotoBlock("_ROOT");
            foreach ($listado as $data) { # para cada elemento del listado lo cargo en la tabla
                $actores = $model->listadoActoresPorPelicula($data["id_pelicula"]);
                $act = array();
                foreach ($actores as $key) { #para todos los resultados, me quedo con el nombre artistico
                    array_push($act, $key["ac_nombreArtistico"]);
                }
            $tpl->newBlock("blockPelicula");
            $tpl->assign("var_id_peli",  $data["id_pelicula"]);
            $tpl->assign("var_nom_peli", $data["pe_nombre"]);
            $tpl->assign("var_gen_peli", $data["ge_nombre"]);
            $tpl->assign("var_dir_peli", $data["di_nombreArtistico"]);
            $tpl->assign("var_dur_peli", $data["pe_duracion"]);
            $tpl->assign("var_act_peli", implode(", ", $act));
            }
        }
        else{ // no hay peliculas
          $tpl->gotoBlock("_ROOT");
          $tpl->newBlock("block_no_Peliculas");
          $tpl->assign("var_texto_no_pelicula", "<b>NO HAY PELICULAS CON ESE GENERO EN LA BASE DE DATOS</b>");
      }
      return $tpl->getOutputContent();
    }

    function peliculasPorDirector($id_director=0) {

        $model = new Pelicula_Model();

        $listado = $model->peliculasPorDirector($id_director);

        $tpl = new TemplatePower("templates/listadoPeliculas.html"); # creo el template
        $tpl->prepare();  # segunda linea necesaria
        $tpl->gotoBlock("_ROOT"); # desde el comienzo

        $tpl->assign("var_titulo_tabla",  " LISTADO DE PELICULAS POR 'DIRECTOR' ");
        $tpl->assign("var_subtitulo_tabla",  "Director: ".$id_director."  Cantidad: ".count($listado));

        if ($listado){
            $tpl->gotoBlock("_ROOT");
            foreach ($listado as $data) { # para cada elemento del listado lo cargo en la tabla
                $actores = $model->listadoActoresPorPelicula($data["id_pelicula"]);
                $act = array();
                foreach ($actores as $key) { #para todos los resultados, me quedo con el nombre artistico
                    array_push($act, $key["ac_nombreArtistico"]);
                }
            $tpl->newBlock("blockPelicula");
            $tpl->assign("var_id_peli",  $data["id_pelicula"]);
            $tpl->assign("var_nom_peli", $data["pe_nombre"]);
            $tpl->assign("var_gen_peli", $data["ge_nombre"]);
            $tpl->assign("var_dir_peli", $data["di_nombreArtistico"]);
            $tpl->assign("var_dur_peli", $data["pe_duracion"]);
            $tpl->assign("var_act_peli", implode(", ", $act));    # implode(como_separo, array) # convierte a string el array
            }
        }
        else{ // no hay peliculas
            $tpl->gotoBlock("_ROOT");
            $tpl->newBlock("block_no_Peliculas");
            $tpl->assign("var_texto_no_pelicula", "<b>NO HAY PELICULAS CON ESE DIRECTOR EN LA BASE DE DATOS</b>");
        }
    return $tpl->getOutputContent();
    }

    function peliculasPor($listarPor, $idListaPor=0) {
        $model = new Pelicula_Model();
        $listado = $model->peliculasPor($listarPor, $idListaPor);

        $tpl = new TemplatePower("templates/listadoPeliculas.html"); # creo el template
        $tpl->prepare();  # segunda linea necesaria
        $tpl->gotoBlock("_ROOT"); # desde el comienzo

        #formateo del encabezado de la tabla
        switch ($listarPor) {
            case "genero":
                $tpl->assign("var_titulo_tabla",  " LISTADO DE PELICULAS POR 'GENERO' ");
                $tpl->assign("var_subtitulo_tabla",  "Genero: ".$idListaPor."  Cantidad: ".count($listado));
                break;
            case "director":
                $tpl->assign("var_titulo_tabla",  " LISTADO DE PELICULAS POR 'DIRECTOR' ");
                $tpl->assign("var_subtitulo_tabla",  "Director: ".$idListaPor."  Cantidad: ".count($listado));
                break;
        }

        if ($listado){
            $tpl->gotoBlock("_ROOT");
            foreach ($listado as $data) { # para cada elemento del listado lo cargo en la tabla
                $actores = $model->listadoActoresPorPelicula($data["id_pelicula"]);
                $act = array();
                foreach ($actores as $key) { #para todos los resultados, me quedo con el nombre artistico
                    array_push($act, $key["ac_nombreArtistico"]);
                }
                $tpl->newBlock("blockPelicula");
                $tpl->assign("var_id_peli",  $data["id_pelicula"]);
                $tpl->assign("var_nom_peli", $data["pe_nombre"]);
                $tpl->assign("var_gen_peli", $data["ge_nombre"]);
                $tpl->assign("var_dir_peli", $data["di_nombreArtistico"]);
                $tpl->assign("var_dur_peli", $data["pe_duracion"]);
                $tpl->assign("var_act_peli", implode(", ", $act));
            }
        }
        else{ // no hay peliculas
            $tpl->gotoBlock("_ROOT");
            $tpl->newBlock("block_no_Peliculas");
            $tpl->assign("var_texto_no_pelicula", "<b>NO HAY PELICULAS CON ESE DIRECTOR EN LA BASE DE DATOS</b>");
        }
        return $tpl->getOutputContent();
    }

//-----------------------------------------------------------------------------
//
//           A L T A   B A J A  y  M O D I F I C A C I O N E S
//
//-----------------------------------------------------------------------------



    function eliminarPelicula($idPelicula) {

        $model = new Pelicula_Model();

        $salida = $model->eliminarPelicula($idPelicula);

        return $salida;
    }

    function cambiarGeneroPelicula($nombrePelicula, $generoNuevo) {

        $model = new Pelicula_Model();

        $salida = $model->cambiarGenero($nombrePelicula, $generoNuevo);

        return $salida;
    }

    function altaPelicula() {
        $model = new Pelicula_Model();
        $modelGeneros = new Genero_Model();
        $modelDirectores = new Director_Model();

        $tpl = new TemplatePower("templates/altaPelicula.html");

        $tpl->prepare();  # segunda linea necesaria
        $tpl->gotoBlock("_ROOT"); # desde el comienzo

        $listado_generos = $modelGeneros->listadoGeneros();

        if ($listado_generos){
            $tpl->gotoBlock("_ROOT");
            foreach ($listado_generos as $data) {
                $tpl->newBlock("blockGenero");
                $tpl->assign("var_genero_id", $data["id_genero"]);
                $tpl->assign("var_genero_nom", $data["ge_nombre"]);
            }
        }
        else{
            $tpl->gotoBlock("_ROOT");
            #$tpl->newBlock("block_no_Actores");
            #$tpl->assign("var_texto_no_actor", "<b>NO HAY ACTORES PARA ESA PELICULA</b>");
        }
        $listado_director = $modelDirectores->listadoDirectores();

        if ($listado_director){
            $tpl->gotoBlock("_ROOT");
            foreach ($listado_director as $data) {
                $tpl->newBlock("blockDirector");
                $tpl->assign("var_director_id", $data["id_director"]);
                $tpl->assign("var_director_nom", $data["di_nombreArtistico"]);
            }
        }
        else{
            $tpl->gotoBlock("_ROOT");
            #$tpl->newBlock("block_no_Actores");
            #$tpl->assign("var_texto_no_actor", "<b>NO HAY ACTORES PARA ESA PELICULA</b>");
        }
        return $tpl->getOutputContent();
    }

    function agregarPelicula() {

        #$id_pelicula
        $id_gen = $_REQUEST["genero"];
        $id_dir = $_REQUEST["director"];
        $nom_pe = $_REQUEST["nombrePelicula"];
        $duraci = $_REQUEST["duracion"];
        $f_estr = $_REQUEST["fechaEstreno"];

        #dump ($_REQUEST);
        #die;
        $model = new Pelicula_Model();
        $salida = $model->insertarPelicula($id_gen,$id_dir,$nom_pe,$duraci,$f_estr);

        return $this->listadoPeliculas();
    }


    function borrarPelicula() {
        # TODO
        #$id_pelicula = id
        $id_pelicula = $_REQUEST["id"];

        # $this->eliminarPelicula($id_pelicula);
        $model = new Pelicula_Model();
        $resultado = $model->eliminarPelicula($id_pelicula);

        return $this->listadoPeliculas();
    }

    # carga formulario con los cambios
    function editarPelicula() {
        $id_pelicula = $_REQUEST["id"];

        $model = new Pelicula_Model();
        $modelGeneros = new Genero_Model();
        $modelDirectores = new Director_Model();

        $tpl = new TemplatePower("templates/editarPelicula.html");

        $tpl->prepare();  # segunda linea necesaria
        $tpl->gotoBlock("_ROOT"); # desde el comienzo

        $pelicula = $model->getPelicula($id_pelicula);
        $tpl->assign("var_nom_pelicula",$pelicula["pe_nombre"]);
        $tpl->assign("var_dur_peli",$pelicula["pe_duracion"]);
        $tpl->assign("var_fe_peli",$pelicula["pe_fechaEstreno"]);

        $listado_generos = $modelGeneros->listadoGeneros();

        if ($listado_generos){
            $tpl->gotoBlock("_ROOT");
            foreach ($listado_generos as $data) {
                $tpl->newBlock("blockGenero");
                $tpl->assign("var_genero_id", $data["id_genero"]);
                $tpl->assign("var_genero_nom", $data["ge_nombre"]);
                if ($data["ge_nombre"] == $pelicula["ge_nombre"])
                    $tpl->assign("var_selected","selected");
            }
        }
        else{
            $tpl->gotoBlock("_ROOT");
            #$tpl->newBlock("block_no_Actores");
            #$tpl->assign("var_texto_no_actor", "<b>NO HAY ACTORES PARA ESA PELICULA</b>");
        }
        $listado_director = $modelDirectores->listadoDirectores();

        if ($listado_director){
            $tpl->gotoBlock("_ROOT");
            foreach ($listado_director as $data) {
                $tpl->newBlock("blockDirector");
                $tpl->assign("var_director_id", $data["id_director"]);
                $tpl->assign("var_director_nom", $data["di_nombreArtistico"]);
                if ($data["di_nombreArtistico"] == $pelicula["di_nombreArtistico"])
                    $tpl->assign("var_selected","selected");
            }
        }
        else{
            $tpl->gotoBlock("_ROOT");
            #$tpl->newBlock("block_no_Actores");
            #$tpl->assign("var_texto_no_actor", "<b>NO HAY ACTORES PARA ESA PELICULA</b>");
        }
        return $tpl->getOutputContent();
    }

    # edita una pelicula que viene de un formulario
    function editarPelicula_formulario() {
        $model = new Pelicula_Model();
        $res = $model->editarPelicula( $_REQUEST['id'], $_REQUEST['nombrePelicula'], $_REQUEST['genero'], $_REQUEST['director'], $_REQUEST['duracion'], $_REQUEST['fechaEstreno'] );
        unset($model);
        if ( $res == -1 ){
            echo "No se pudo editar la Pelicula, errores en los campos proporcionados";
            die;
        }
        else {
            echo "Editado con Exito!!";
        }
        return $this->listadoPeliculas();
    }
}
?>
