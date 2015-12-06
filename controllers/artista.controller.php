<?php

class Artista_Controller{

/*con esta funcion solo llamo a crear al template para agregar artista*/
      function altaArtista() {
        $model = new Artista_Model();

        $tpl = new TemplatePower("templates/altaArtista.html");

        $tpl->prepare();  # segunda linea necesaria
        $tpl->gotoBlock("_ROOT"); # desde el comienzo
        # finalizo la transaccion, es necesaria
        return $tpl->getOutputContent();
    }
    
/*esta funcion se dispara cuando presiono el boton guardar dentro del formulario*/
    function agregarArtista() {

        #$id_pelicula
        $nombre = $_REQUEST["nombre"];
        $apellido = $_REQUEST["apellido"];
        $dni = $_REQUEST["dni"];
        $mail = $_REQUEST["mail"];

        #dump ($_REQUEST);
        #die;
        $model = new Artista_Model();
        $salida = $model->insertarArtista($nombre, $apellido, $dni, $mail);
        if($salida==-1){
            echo "No ingreso correctamente nombre y apellido, no se pudo agregar el Artista";
            die;
        }
        return $this->listadoArtistas();
    }
 /* funcion que me lista todos los Artistas*/ /*OJO ACA ESTA METIDO TMB EL FORMULARIO*/  
    function listadoArtistas() {
        $model = new Artista_Model();
        $listado = $model->listadoArtistas();


        # llamo al template para la vista, la modifico a gusto
        $tpl = new TemplatePower("templates/listadoArtistas.html"); # creo el template
        $tpl->prepare();  # segunda linea necesaria
        $tpl->gotoBlock("_ROOT"); # desde el comienzo
        
        #formateo del encabezado de la tabla
        $titulo_tabla = "<h2> LISTADO DE ARTISTAS </h2>";
        $subtitulo_tabla = "<strong><i> Cantidad: " . count($listado) . "</i></strong>";
        $tpl->assign("var_titulo_tabla", $titulo_tabla);
        $tpl->assign("var_subtitulo_tabla", $subtitulo_tabla);

        if ($listado) {
            $tpl->gotoBlock("_ROOT");
            foreach ($listado as $data) {
                $tpl->newBlock("blockArtista");
                $tpl->assign("var_id_art", $data["id_artista"]);
                $tpl->assign("var_nom_act", $data["ar_nombre"]);
                $tpl->assign("var_ape_act", $data["ar_apellido"]);
                $tpl->assign("var_dni_act", $data["ar_dni"]);
                $tpl->assign("var_mail_act", $data["ar_mail"]);
            }
        } else {
            $tpl->gotoBlock("_ROOT");
            $tpl->newBlock("block_no_Artistas");
            $tpl->assign("var_texto_no_artistas", "<b>NO HAY ARTISTAS EN LA BASE DE DATOS</b>");
        }
        # finalizo la transaccion, es necesaria
        return $tpl->getOutputContent();
    }
/* funcion que me crea el formulario para eliminar un Artista*/
    function bajaArtista() {
        $model = new Artista_Model();

        $tpl = new TemplatePower("templates/bajaArtista.html");

        $tpl->prepare();  # segunda linea necesaria
        $tpl->gotoBlock("_ROOT"); # desde el comienzo

        $listado_artistas = $model->listadoArtistas();

        if ($listado_artistas) {
            $tpl->gotoBlock("_ROOT");
            foreach ($listado_artistas as $data) {
                $tpl->newBlock("blockArtista");
                $tpl->assign("var_artista_id", $data["id_artista"]);
                $aux=$data["ar_nombre"];//esto es una negrada..pero funcaa..ver de cambiarlo si llegamos
                $aux.=" ";
                $aux.=$data["ar_apellido"];
                $tpl->assign("var_ar_nombre", $aux);
                
            }
        } else {
            $tpl->gotoBlock("_ROOT");
            #$tpl->newBlock("block_no_Artistas");
            #$tpl->assign("var_texto_no_artista", "<b>NO HAY ARTISTAS</b>");
        }
        # finalizo la transaccion, es necesaria
        return $tpl->getOutputContent();
    }
/*funcion que se comunica con el modelo y elimina el Artista deseado*/
    function eliminarArtista() {
        $idArtista = $_REQUEST["nombre_apellido"];
        $model = new Artista_Model();
        $salida = $model->eliminarArtista($idArtista);
        if($salida==-1){
            echo "No selecciono un Artista, no se elimino ningun Artista ";
            die;
        }
        return $this->listadoArtistas();
    }
    
    function modificarArtista() {
        $model = new Artista_Model();

        $tpl = new TemplatePower("templates/modificarArtista.html");

        $tpl->prepare();  # segunda linea necesaria
        $tpl->gotoBlock("_ROOT"); # desde el comienzo

        $listado_artistas = $model->listadoArtistas();

        if ($listado_artistas) {
            $tpl->gotoBlock("_ROOT");
            foreach ($listado_artistas as $data) {
                $tpl->newBlock("blockModArtista");
                $tpl->assign("var_artista_id", $data["id_artista"]);
                $aux=$data["ar_nombre"];//esto es una negrada..pero funcaa..ver de cambiarlo si llegamos
                $aux.=" ";
                $aux.=$data["ar_apellido"];
                $tpl->assign("var_ar_nombre", $aux);
                
            }
        } else {
            $tpl->gotoBlock("_ROOT");
            #$tpl->newBlock("block_no_Artistas");
            #$tpl->assign("var_texto_no_artista", "<b>NO HAY ARTISTAS</b>");
        }
        # finalizo la transaccion, es necesaria
        return $tpl->getOutputContent();
    }
    
    function actualizarArtista() {
        $idArtista = $_REQUEST["nombre_apellido"];
        $nombre = $_REQUEST["nombre"];
        $apellido = $_REQUEST["apellido"];
        $dni = $_REQUEST["dni"];
        $mail = $_REQUEST["mail"];
        
        $model = new Artista_Model();
        $salida = $model->actualizarArtista($idArtista, $nombre, $apellido, $dni, $mail);
        if($salida==-1){
            echo "Seleccione correctamente un Artista a Modificar y especifique su nuevo nombre y apellido";
            die;
        }
        return $this->listadoArtistas();
    }

}
?>
