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
//================================ ALTA Y BAJA ACTORES ========================================
  function altaActor(){
   $tpl = new TemplatePower("templates/altaActor.html");
   $tpl->prepare();
   return $tpl->getOutputContent();


  }
  function agregarActor(){

    $nombre = $_REQUEST['nombre'];
    $apellido = $_REQUEST['apellido'];
    $dni = $_REQUEST['dni'];
    $nombreArtistico = $_REQUEST['nombreArtistico'];
    $mail = $_REQUEST['mail'];

    dump($_REQUEST);
    $model = new Actor_Model();

    $salida = $model->altaActor($nombre, $apellido, $dni, $mail, $nombreArtistico);

    return $salida;
  }


  // ELIMINA EL ACTOR DE LA BASE DE DATOS
  function eliminarActor($nombreArtistico=0){

    $id = $_REQUEST["nombre_artistico"];

    $model = new Actor_Model();

    $salida = $model->eliminarActor($id);


     return $this->listadoActores();
  }
  //ELIMINA DEL TEMPLATE EL ACTOR
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
    return $tpl->getOutputContent();
  }
  function getActor($id_actor)
  {
      $model = new Actor_Model();

      $salida = $model->getActor($id_actor);

      return $salida;
  }
  function EditarActor()
  {

    $model = new Actor_Model();

    $tpl = new TemplatePower("templates/EditarActor.html");
    $tpl->prepare();  # segunda linea necesaria
    $tpl->gotoBlock("_ROOT"); # desde el comienzo

     $listado_actores = $model->listadoActores();

     if ($listado_actores){
      $tpl->gotoBlock("_ROOT");
      foreach ($listado_actores as $data) {
        $tpl->newBlock("blockActor");
        $tpl->assign("id_actor", $data["id_actor"]);
        $tpl->assign("var_nombArtistico", $data["ac_nombreArtistico"]);
      }
    }
    else{
      $tpl->gotoBlock("_ROOT");
      #$tpl->newBlock("block_no_Actores");
      #$tpl->assign("var_texto_no_actor", "<b>NO HAY ACTORES PARA ESA PELICULA</b>");
    }
    return $tpl->getOutputContent();
  }
  function CamposActor()
  {
     $model = new Actor_Model();
     $id = $_REQUEST["nombreArtistico"];
     $tpl = new TemplatePower("templates/CamposActor.html");
     $tpl->prepare();  # segunda linea necesaria
     $Actor = $model->getActor($id);
     if ($Actor)
     {
            $tpl->gotoBlock("_ROOT");
            $tpl->newBlock("block_editar");
       foreach ($Actor as $data)
         {
            $tpl->assign("id_actor",$id);
            $tpl->assign("nombreArt", $data["ac_nombreArtistico"]);
//            $tpl->assign("nombre", $data["ar_nombre"]);
//            $tpl->assign("apellido", $data["ar_apellido"]);
//            $tpl->assign("dni", $data["ar_dni"]);
//            $tpl->assign("email", $data["ar_mail"]);
        }

     }

    else
     {
        $tpl->gotoBlock("_ROOT");
        $tpl->newBlock("block_campo_vacio");
        $tpl->assign("var_texto","NO SE SELECCIONO NINGUN ACTOR");

     }
     return $tpl->getOutputContent();
  }
  function updateActor()
  {
      $idActor = $_REQUEST["idActor"];
      $nombreArtistico = $_REQUEST["nombreArtistico"];
//      $nombre = $_REQUEST["nombreActor"];
//      $apellido = $_REQUEST["apellidoActor"];
//      $dni = $_REQUEST["dniActor"];
//      $email = $_REQUEST["emailActor"];

      $model = new Actor_Model();

      $resultado = $model->updateActor($idActor, $nombreArtistico);

       $tpl = new TemplatePower("templates/Informe.html");
       $tpl->prepare();
      if ($resultado == 0 || $resultado = 1)
      {
        $tpl->assign("informe","Se actualizó correctamente");
      }
      else
      {
        $tpl->assign("informe","No se actualizó el campo");
      }

      return $tpl->getOutputContent();
  }

}
?>
