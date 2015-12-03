<?php


#foreach ($listado as $key) {
# echo "nombre ".$key["pe_nombre"]."<br>";
#}
#var_dump($listado);

class Pelicula_Controller{
  var $messages = null;

//-------------------------------------------------------------------------
//
//            L I S T A R   C O S A S
//
//-------------------------------------------------------------------------


  function listadoPeliculas(){

    $model = new Pelicula_Model();

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
        $actores = $model->listadoActoresPorPelicula($data["id_pelicula"]);
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
        # implode(como_separo, array) # convierte a string el array
        $tpl->assign("var_act_peli", implode(", ", $act));
        $tpl->assign("var_id_peli",$data["id_pelicula"]);
      }
    }
    else{ // no hay peliculas
      $tpl->gotoBlock("_ROOT");
      $tpl->newBlock("block_no_Peliculas");
      $tpl->assign("var_texto_no_pelicula", "<b>NO HAY PELICULAS EN LA BASE DE DATOS</b>");
    }

    # imprimo por pantalla
    #$tpl->printToScreen();

    # finalizo la transaccion, es necesaria
    return $tpl->getOutputContent();
  }

  
  function peliculasPorGenero($id_genero=0) {
    # creo el objeto modelo para manejar la funciones
    $model = new Pelicula_Model();

    # llamo a la funcion y retorno el listado de peliculas
    $listado = $model->peliculasPorGenero($id_genero);

    # llamo al template para la vista, la modifico a gusto
    $tpl = new TemplatePower("templates/listadoPeliculas.html"); # creo el template
    $tpl->prepare();  # segunda linea necesaria
    $tpl->gotoBlock("_ROOT"); # desde el comienzo

    #formateo del encabezado de la tabla
    $titulo_tabla = "<h2> LISTADO DE PELICULAS POR 'GENERO' </h2>";
    $subtitulo_tabla = "<strong><i> Genero: ".$id_genero."  Cantidad: ".count($listado)."</i></strong>";
    $tpl->assign("var_titulo_tabla",  $titulo_tabla);
    $tpl->assign("var_subtitulo_tabla",  $subtitulo_tabla);

    # si listado retorno algo, NO ESTA VACIO
    #TODO completar con los actores
    if ($listado){
      $tpl->gotoBlock("_ROOT");
      foreach ($listado as $data) { # para cada elemento del listado lo cargo en la tabla
        # genero la lista de los actores, segun el id de pelicula
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
      $tpl->assign("var_texto_no_pelicula", "<b>NO HAY PELICULAS CON ESE GENERO EN LA BASE DE DATOS</b>");
    }

    # imprimo por pantalla
    #$tpl->printToScreen();

    # finalizo la transaccion, es necesaria
    return $tpl->getOutputContent();

  }

  function peliculasPorDirector($id_director=0) {
    # creo el objeto modelo para manejar la funciones
    $model = new Pelicula_Model();

        # llamo a la funcion y retorno el listado de peliculas
    $listado = $model->peliculasPorDirector($id_director);

        # llamo al template para la vista, la modifico a gusto
        $tpl = new TemplatePower("templates/listadoPeliculas.html"); # creo el template
    $tpl->prepare();  # segunda linea necesaria
    $tpl->gotoBlock("_ROOT"); # desde el comienzo

    #formateo del encabezado de la tabla
    $titulo_tabla = "<h2> LISTADO DE PELICULAS POR 'DIRECTOR' </h2>";
    $subtitulo_tabla = "<strong><i> Director: ".$id_director."  Cantidad: ".count($listado)."</i></strong>";
    $tpl->assign("var_titulo_tabla",  $titulo_tabla);
    $tpl->assign("var_subtitulo_tabla",  $subtitulo_tabla);

    # si listado retorno algo, NO ESTA VACIO
    #TODO completar con los actores
    if ($listado){
      $tpl->gotoBlock("_ROOT");
      foreach ($listado as $data) { # para cada elemento del listado lo cargo en la tabla
        # genero la lista de los actores, segun el id de pelicula
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

    # imprimo por pantalla
    #$tpl->printToScreen();

    # finalizo la transaccion, es necesaria
    return $tpl->getOutputContent();

  }

  function listadoActores(){
    $model = new Pelicula_Model();

    $listado = $model->listadoActores();
    
        # llamo al template para la vista, la modifico a gusto
        $tpl = new TemplatePower("templates/listadoActores.html"); # creo el template
    $tpl->prepare();  # segunda linea necesaria
    $tpl->gotoBlock("_ROOT"); # desde el comienzo

    #formateo del encabezado de la tabla
    $titulo_tabla = "<h2> LISTADO DE ACTORES </h2>";
    $subtitulo_tabla = "<strong><i> Cantidad: ".count($listado)."</i></strong>";
    $tpl->assign("var_titulo_tabla",  $titulo_tabla);
    $tpl->assign("var_subtitulo_tabla",  $subtitulo_tabla);

    if ($listado){
      $tpl->gotoBlock("_ROOT");
      foreach ($listado as $data) {
        $tpl->newBlock("blockActor");
        $tpl->assign("var_id_art", $data["id_artista"]);
        $tpl->assign("var_id_act", $data["id_actor"]);
        $tpl->assign("var_nom_act", $data["ar_nombre"]);
        $tpl->assign("var_ape_act", $data["ar_apellido"]);
        $tpl->assign("var_dni_act", $data["ar_dni"]);
        $tpl->assign("var_nAr_act", $data["ac_nombreArtistico"]);
      }
    }
    else{
      $tpl->gotoBlock("_ROOT");
      $tpl->newBlock("block_no_Actores");
      $tpl->assign("var_texto_no_actor", "<b>NO HAY ACTORES EN LA BASE DE DATOS</b>");
    }

    #$tpl->printToScreen();

    # finalizo la transaccion, es necesaria
    return $tpl->getOutputContent();
    
  }

  function listadoActoresPorPelicula($idPelicula=0){
    $model = new Pelicula_Model();

    $listado = $model->listadoActoresPorPelicula($idPelicula);
    
        # llamo al template para la vista, la modifico a gusto
        $tpl = new TemplatePower("templates/listadoActores.html"); # creo el template
    $tpl->prepare();  # segunda linea necesaria
    $tpl->gotoBlock("_ROOT"); # desde el comienzo

    #formateo del encabezado de la tabla
    $titulo_tabla = "<h2> LISTADO DE ACTORES POR 'PELICULA' </h2>";
    $subtitulo_tabla = "<strong><i> Cantidad: ".count($listado)."</i></strong>";
    $tpl->assign("var_titulo_tabla",  $titulo_tabla);
    $tpl->assign("var_subtitulo_tabla",  $subtitulo_tabla);

    if ($listado){
      $tpl->gotoBlock("_ROOT");
      foreach ($listado as $data) {
        $tpl->newBlock("blockActor");
        $tpl->assign("var_id_art", $data["id_artista"]);
        $tpl->assign("var_id_act", $data["id_actor"]);
        $tpl->assign("var_nom_act", $data["ar_nombre"]);
        $tpl->assign("var_ape_act", $data["ar_apellido"]);
        $tpl->assign("var_dni_act", $data["ar_dni"]);
        $tpl->assign("var_nAr_act", $data["ac_nombreArtistico"]);
      }
    }
    else{
      $tpl->gotoBlock("_ROOT");
      $tpl->newBlock("block_no_Actores");
      $tpl->assign("var_texto_no_actor", "<b>NO HAY ACTORES PARA ESA PELICULA</b>");
    }

    #$tpl->printToScreen();

    # finalizo la transaccion, es necesaria
    return $tpl->getOutputContent();
    
  }

//-----------------------------------------------------------------------------
//
//           A L T A   B A J A  y  M O D I F I C A C I O N E S
//
//-----------------------------------------------------------------------------

  function insertarActor($nombre, $apellido, $dni, $mail, $nombreArtistico){
    $model = new Pelicula_Model();

    $salida = $model->insertarActor($nombre, $apellido, $dni, $mail, $nombreArtistico);

    return $salida;
  }
   
  function eliminarActor($nombreArtistico=0){

    $nombreArtistico = $_REQUEST["nombre_artistico"];
  
    $model = new Pelicula_Model();

    $salida = $model->eliminarActor($nombreArtistico);

     return $this->listadoArtistas();
  }

  function eliminarPelicula($idPelicula) {

    $model = new Pelicula_Model();

    $salida = $model->eliminarPelicula($idPelicula);

    return $salida;
  }

  function cambiarGenero($nombrePelicula, $generoNuevo) {

    $model = new Pelicula_Model();

    $salida = $model->cambiarGenero($nombrePelicula, $generoNuevo);

    return $salida;
  }

function bajaActor() {
    $model = new Pelicula_Model();
    
    $tpl = new TemplatePower("templates/bajaActor.html");

    $tpl->prepare();  # segunda linea necesaria
    $tpl->gotoBlock("_ROOT"); # desde el comienzo

    $listado_actores = $model->listadoActores();

    if ($listado_actores){
      $tpl->gotoBlock("_ROOT");
      foreach ($listado_actores as $data) {
        $tpl->newBlock("blockActor");
        $tpl->assign("var_actor_id", $data["id_actor"]);
        $tpl->assign("var_actor_nom", $data["ac_nombreArtistico"]);
      }
    }
    else{
      $tpl->gotoBlock("_ROOT");
      #$tpl->newBlock("block_no_Actores");
      #$tpl->assign("var_texto_no_actor", "<b>NO HAY ACTORES PARA ESA PELICULA</b>");
    }




    # finalizo la transaccion, es necesaria
    return $tpl->getOutputContent();
    
  }

  function altaPelicula() {
    $model = new Pelicula_Model();
    
    $tpl = new TemplatePower("templates/altaPelicula.html");

    $tpl->prepare();  # segunda linea necesaria
    $tpl->gotoBlock("_ROOT"); # desde el comienzo

    $listado_generos = $model->listadoGeneros();

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



    //------


    $listado_director = $model->listadoDirectores();

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



    # finalizo la transaccion, es necesaria
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

  function editarPelicula() {
    # TODO
    #$id_pelicula = id
    $id_pelicula = $_REQUEST["id"];
  
    $model = new Pelicula_Model();
    
    $tpl = new TemplatePower("templates/altaPelicula.html");

    $tpl->prepare();  # segunda linea necesaria
    $tpl->gotoBlock("_ROOT"); # desde el comienzo

    #       NOMBRE
    
    # array(6) { ["id_pelicula"]=> string(2) "11" ["pe_nombre"]=> string(9) "El wachon" ["ge_nombre"]=> string(5) "Drama" ["di_nombreArtistico"]=> string(13) "James Cameron" ["pe_duracion"]=> string(2) "88" ["pe_fechaEstreno"]=> string(10) "2015-11-20" }
    $pelicula = $model->getPelicula($id_pelicula);
    $tpl->assign("var_nom_pelicula",$pelicula["pe_nombre"]);
    $tpl->assign("var_dur_peli",$pelicula["pe_duracion"]);
    $tpl->assign("var_fe_peli",$pelicula["pe_fechaEstreno"]);


    $listado_generos = $model->listadoGeneros();

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



    //------


    $listado_director = $model->listadoDirectores();

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

    $tpl->assign("var_dur_peli",$pelicula["pe_duracion"]);

    

    # finalizo la transaccion, es necesaria
    return $tpl->getOutputContent();
  } 
#
  #
  #
  #
  #
  #
  #
  #
  #
  #
  function altaArtista() {
    $model = new Pelicula_Model();
    
    $tpl = new TemplatePower("templates/altaArtista.html");

    $tpl->prepare();  # segunda linea necesaria
    $tpl->gotoBlock("_ROOT"); # desde el comienzo

    # finalizo la transaccion, es necesaria
    return $tpl->getOutputContent();
    
  }
  
  function agregarArtista() {
    
    #$id_pelicula
    $nombre = $_REQUEST["nombre"];
    $apellido = $_REQUEST["apellido"];
    $dni = $_REQUEST["dni"];
    $mail = $_REQUEST["mail"];

    #dump ($_REQUEST);
    #die;
    $model = new Pelicula_Model();
    $salida = $model->insertarArtista($nombre, $apellido, $dni, $mail);

    #return $this->listadoArtistas();
    }
}
?>