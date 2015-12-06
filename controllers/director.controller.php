<?php

class Director_Controller{

function peliculasPorDirector($id_director=0) {
    # creo el objeto modelo para manejar la funciones
    $model = new Director_Model();
        # llamo a la funcion y retorno el listado de peliculas
         # llamo al template para la vista, la modifico a gusto
    $idDirectores = $model->getDirectorId();

    $tpl = new TemplatePower("templates/peliculasPorDirector.html"); # creo el template
    $tpl->prepare();  # segunda linea necesaria
    $tpl->gotoBlock("_ROOT"); # desde el comienzo
    #formateo del encabezado de la tabla
//    $titulo_tabla = "<h2> LISTADO DE PELICULAS POR 'DIRECTOR' </h2>";
//    $subtitulo_tabla = "<strong><i> Director: ".$id_director."  Cantidad: ".count($idDirectores)."</i></strong>";
//    $tpl->assign("var_titulo_tabla",  $titulo_tabla);
//    $tpl->assign("var_subtitulo_tabla",  $subtitulo_tabla);
    $cantidad = count($idDirectores);

    $tpl->assign("var_cantidad_dir",$cantidad);

    foreach ($idDirectores as $Director)
    {
    $tpl->assign("id_director",$Director["id_director"]);
    $listado = $model->peliculasPorDirector($Director["id_director"]);

    $model2 = new Actor_Model(); //CREO UN OBJETO ACTOR
    $tpl->newBlock("blockDirector");
    $tpl->assign("var_dir_peli",$Director["di_nombreArtistico"]);

    # si listado retorno algo, NO ESTA VACIO
    #TODO completar con los actores
    if ($listado){
      $tpl->gotoBlock("_ROOT");
      //BLOQUE DIRECTOR
      foreach ($listado as $data) { # para cada elemento del listado lo cargo en la tabla
        # genero la lista de los actores, segun el id de pelicula
        $actores = $model2->listadoActoresPorPelicula($data["id_pelicula"]);
        $act = array();
        //CHEQUEO PARA ACTORES
        if ($actores) //Si actores retorno algo
        {
            foreach ($actores as $key) { #para todos los resultados, me quedo con el nombre artistico
            array_push($act, $key["ac_nombreArtistico"]);
            }
        }
        else
        {
            array_push($act, '-');
        }

        $tpl->newBlock("blockPelicula");
        $tpl->assign("var_id_peli",  $data["id_pelicula"]);
        $tpl->assign("var_nom_peli", $data["pe_nombre"]);
        $tpl->assign("var_gen_peli", $data["ge_nombre"]);
        $tpl->assign("var_dur_peli", $data["pe_duracion"]);
        $tpl->assign("var_act_peli", implode(", ", $act));    # implode(como_separo, array) # convierte a string el array
      }
    }
    else{ // no hay peliculas
      $tpl->gotoBlock("_ROOT");
      $tpl->newBlock("block_no_Peliculas");
      $tpl->assign("var_texto_no_pelicula", "<b>NO HAY PELICULAS CON ESE DIRECTOR EN LA BASE DE DATOS</b>");
    }
    }
    # imprimo por pantalla
    #$tpl->printToScreen();

    # finalizo la transaccion, es necesaria
    return $tpl->getOutputContent();

  }
  function listadoDirectores(){
    $model = new Director_Model();

    $listado = $model->listadoDirectores();

        # llamo al template para la vista, la modifico a gusto
    $tpl = new TemplatePower("templates/listadoDirectores.html"); # creo el template
    $tpl->prepare();  # segunda linea necesaria
    $tpl->gotoBlock("_ROOT"); # desde el comienzo

    #formateo del encabezado de la tabla
    $titulo_tabla = "<h2> LISTADO DE DIRECTORES</h2>";
    $subtitulo_tabla = "<strong><i> Cantidad: ".count($listado)."</i></strong>";
    $tpl->assign("var_titulo_tabla",  $titulo_tabla);
    $tpl->assign("var_subtitulo_tabla",  $subtitulo_tabla);

    if ($listado){
      $tpl->gotoBlock("_ROOT");
      foreach ($listado as $data) {
        $tpl->newBlock("blockDirector");
        $tpl->assign("var_id_art", $data["id_artista"]);
        $tpl->assign("var_id_director", $data["id_director"]);
        $tpl->assign("var_nom_act", $data["ar_nombre"]);
        $tpl->assign("var_ape_act", $data["ar_apellido"]);
        $tpl->assign("var_dni_act", $data["ar_dni"]);
        $tpl->assign("var_nAr_act", $data["di_nombreArtistico"]);
        $tpl->assign("var_mail_dir", $data["ar_mail"]);
      }
    }
    else{
      $tpl->gotoBlock("_ROOT");
      $tpl->newBlock("block_no_Directores");
      $tpl->assign("var_texto_no_Director", "<b>NO HAY DIRECTORES EN LA BASE DE DATOS</b>");
    }

    #$tpl->printToScreen();

    # finalizo la transaccion, es necesaria
    return $tpl->getOutputContent();

  }

  //ABM
  //GENERO EL TEMPLATE
  function altaDirector(){
   $tpl = new TemplatePower("templates/altaDirector.html");
   $tpl->prepare();
   return $tpl->getOutputContent();


  }
  //OBTENGO LOS DATOS DEL FORMULARIO Y LUEGO LOS PASO A LA BASE DE DATOS
  function agregarDirector(){

    $nombre = $_REQUEST['nombre'];
    $apellido = $_REQUEST['apellido'];
    $dni = $_REQUEST['dni'];
    $nombreArtistico = $_REQUEST['nombreArtistico'];
    $mail = $_REQUEST['mail'];


    $model = new Director_Model();

    $salida = $model->altaDirector($nombre, $apellido, $dni, $mail, $nombreArtistico);

    return $salida;
  }

    // ELIMINA EL ACTOR DE LA BASE DE DATOS
  function eliminarDirector($id=0){

    $id = $_REQUEST["nombre_artistico"];
    $model = new Director_Model();

    $Directores = $this->getDirectores($id);

    foreach ($Directores as $data)
    {
        if ($data["id_director"]==$id)
        {

            $salida = $model->eliminarDirector($data["di_nombreArtistico"]);

        }
    }
     return $this->listadoDirectores();
  }
  function getDirectores($id)
  {
      $model = new Director_Model();

      $salida = $model->getDirectores($id);

      return $salida;
  }
  //ELIMINA DEL TEMPLATE EL ACTOR
  function bajaDirector() {
    $model = new Director_Model();

    $tpl = new TemplatePower("templates/bajaDirector.html");

    $tpl->prepare();  # segunda linea necesaria
    $tpl->gotoBlock("_ROOT"); # desde el comienzo

    $listado_directores = $model->listadoDirectores();

    if ($listado_directores){
      $tpl->gotoBlock("_ROOT");
      foreach ($listado_directores as $data) {
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

  function EditarDirector()
  {

    $model = new Director_Model();

    $tpl = new TemplatePower("templates/EditarDirector.html");
    $tpl->prepare();  # segunda linea necesaria
    $tpl->gotoBlock("_ROOT"); # desde el comienzo

     $listado_directores = $model->listadoDirectores();

     if ($listado_directores){
      $tpl->gotoBlock("_ROOT");
      foreach ($listado_directores as $data) {
        $tpl->newBlock("blockDirector");
        $tpl->assign("id_director", $data["id_director"]);
        $tpl->assign("var_nombArtistico", $data["di_nombreArtistico"]);
      }
    }
    else{
      $tpl->gotoBlock("_ROOT");
      #$tpl->newBlock("block_no_Actores");
      #$tpl->assign("var_texto_no_actor", "<b>NO HAY ACTORES PARA ESA PELICULA</b>");
    }
    return $tpl->getOutputContent();
  }
  function CamposDirector()
  {
     $model = new Director_Model();
     $id = $_REQUEST["nombreArtistico"];
     $tpl = new TemplatePower("templates/CamposDirector.html");
     $tpl->prepare();  # segunda linea necesaria
     $Director = $model->getDirectores($id);

     if ($Director)
     {
            $tpl->gotoBlock("_ROOT");
            $tpl->newBlock("block_editar");
       foreach ($Director as $data)
         {
            $tpl->assign("id_director",$id);
            $tpl->assign("nombreArt", $data["di_nombreArtistico"]);
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
        $tpl->assign("var_texto","NO SE SELECCIONO NINGUN DIRECTOR");

     }
     return $tpl->getOutputContent();
  }
  function updateDirector(){

    $idDirector = $_REQUEST["idDirector"];
    $nombreArtistico = $_REQUEST["nombreArtistico"];

    $model = new Director_Model();

    $resultado = $model->updateDirector($idDirector, $nombreArtistico);

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
