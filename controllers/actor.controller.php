<?php

class Actor_Controller{
    function listadoActores(){
    $model = new Actor_Model();

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
    $model = new Actor_Model();

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

  function insertarActor($nombre, $apellido, $dni, $mail, $nombreArtistico){
    $model = new Actor_Model();

    $salida = $model->insertarActor($nombre, $apellido, $dni, $mail, $nombreArtistico);

    return $salida;
  }

  function eliminarActor($nombreArtistico=0){

    $nombreArtistico = $_REQUEST["nombre_artistico"];

    $model = new Actor_Model();

    $salida = $model->eliminarActor($nombreArtistico);

     return $this->listadoArtistas();
  }


  function bajaActor() {
    $model = new Actor_Model();

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
}
?>
