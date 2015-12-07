<?php

class Artista_Controller {
    /* con esta funcion solo llamo a crear al template para agregar artista */

    function altaArtista() {

        $tpl = new TemplatePower("templates/altaArtista.html");

        $tpl->prepare();  # segunda linea necesaria
        $tpl->gotoBlock("_ROOT"); # desde el comienzo
        # finalizo la transaccion, es necesaria
        return $tpl->getOutputContent();
    }

    /* esta funcion se dispara cuando presiono el boton guardar dentro del formulario */

    function agregarArtista() {

        $nombre = $_REQUEST["nombre"];
        $apellido = $_REQUEST["apellido"];
        $dni = $_REQUEST["dni"];
        $mail = $_REQUEST["mail"];

        $model = new Artista_Model();
        $salida = $model->insertarArtista($nombre, $apellido, $dni, $mail);
       
        if ($salida == -1) {
            echo "NO se puedo agregar a la base de datos";
        } else {
            echo"Se agrego correctamente a la base de datos";
            
        }

        return $this->listadoArtistas();
    }

    /* funcion que me lista todos los Artistas */

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

    /* funcion que se comunica con el modelo y elimina el Artista deseado */

    function borrarArtista() {
        $id_Artista = $_REQUEST["id"];
        $model = new Artista_Model();
        $salida = $model->eliminarArtista($id_Artista);

        if ($salida == -1) {
            echo "NO se puedo agregar a la base de datos";
        } else {
            echo"Se elimino correctamente a la base de datos";
        }

        return $this->listadoArtistas();
    }
   /* funcion para editar un artista*/
    function editarArtista() {
        $id_Artista = $_REQUEST["id"];

        $model = new Artista_Model();

        $tpl = new TemplatePower("templates/modificarArtista.html");

        $tpl->prepare();  # segunda linea necesaria
        $tpl->gotoBlock("_ROOT"); # desde el comienzo


        $artista = $model->getArtista($id_Artista);
        $tpl->assign("var_nom_artista", $artista["ar_nombre"]);
        $tpl->assign("var_ape_artista", $artista["ar_apellido"]);
        $tpl->assign("var_dni_artista", $artista["ar_dni"]);
        $tpl->assign("var_mail_artista", $artista["ar_mail"]);

        $listado_artistas = $model->listadoArtistas();


        # finalizo la transaccion, es necesaria
        return $tpl->getOutputContent();
    }
   /* funcion para actualizar un artista*/
    function actualizarArtista() {
        $idArtista = $_REQUEST["id"];
        $nombre = $_REQUEST["nombre"];
        $apellido = $_REQUEST["apellido"];
        $dni = $_REQUEST["dni"];
        $mail = $_REQUEST["mail"];

        $model = new Artista_Model();
        $salida = $model->actualizarArtista($idArtista, $nombre, $apellido, $dni, $mail);

        if ($salida == -1) {
            echo "NO se puedo agregar a la base de datos";
        } else {
            echo"Se edito correctamente a la base de datos";
        }
        return $this->listadoArtistas();
    }

}

?>
