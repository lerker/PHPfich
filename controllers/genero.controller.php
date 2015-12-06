<?php

class Genero_Controller {
 /* con esta funcion solo llamo a crear al template para agregar Generos */
    function listadoGeneros() {
        $model = new Genero_Model();
        $listado = $model->listadoGeneros();

        # llamo al template para la vista, la modifico a gusto
        $tpl = new TemplatePower("templates/listadoGeneros.html"); # creo el template
        $tpl->prepare();  # segunda linea necesaria
        $tpl->gotoBlock("_ROOT"); # desde el comienzo
        #formateo del encabezado de la tabla
        $titulo_tabla = "<h2> LISTADO DE GENEROS </h2>";
        $subtitulo_tabla = "<strong><i> Cantidad: " . count($listado) . "</i></strong>";
        $tpl->assign("var_titulo_tabla", $titulo_tabla);
        $tpl->assign("var_subtitulo_tabla", $subtitulo_tabla);

        if ($listado) {
            $tpl->gotoBlock("_ROOT");
            foreach ($listado as $data) {
                $tpl->newBlock("blockGenero");
                $tpl->assign("var_id_gen", $data["id_genero"]);
                $tpl->assign("var_nom_gen", $data["ge_nombre"]);
            }
        } else {
            $tpl->gotoBlock("_ROOT");
            $tpl->newBlock("block_no_Generos");
            $tpl->assign("var_texto_no_generos", "<b>NO HAY GENEROS EN LA BASE DE DATOS</b>");
        }
        # finalizo la transaccion, es necesaria
        return $tpl->getOutputContent();
    }

    /* con esta funcion solo llamo a crear al template para agregar genero */

    function altaGenero() {
        $tpl = new TemplatePower("templates/altaGenero.html");

        $tpl->prepare();  # segunda linea necesaria
        $tpl->gotoBlock("_ROOT"); # desde el comienzo
        # finalizo la transaccion, es necesaria
        return $tpl->getOutputContent();
    }

    /* esta funcion se dispara cuando presiono el boton guardar dentro del formulario */

    function agregarGenero() {

        #$id_genero
        $nombre = $_REQUEST["nombre"];

        $model = new Genero_Model();
        $salida = $model->insertarGenero($nombre);

        if ($salida == -1) {
            echo "NO se puedo agregar a la base de datos";
        } else {
            echo"Se agrego correctamente a la base de datos";
        }

        return $this->listadoGeneros();
    }
   /* funcion que me permite borrar un genero*/
    function borrarGenero() {
        $id_Genero = $_REQUEST["id"];
        $model = new Genero_Model();
        $salida = $model->eliminarGenero($id_Genero);
        
        if ($salida == -1) {
            echo "NO se puedo agregar a la base de datos";
        } else {
            echo"Se elimino correctamente a la base de datos";
        }
        
        return $this->listadoGeneros();
    }

    /*funcion que me permite editar un genero*/
    function editarGenero() {
        $id_Genero = $_REQUEST["id"];

        $model = new Genero_Model();

        $tpl = new TemplatePower("templates/modificarGenero.html");

        $tpl->prepare();  # segunda linea necesaria
        $tpl->gotoBlock("_ROOT"); # desde el comienzo

        $genero = $model->getGenero($id_Genero);
        $tpl->assign("var_nom_genero", $genero["ge_nombre"]);


        $listado_generos = $model->listadoGeneros();

        # finalizo la transaccion, es necesaria
        return $tpl->getOutputContent();
    }

    /*funcion que me permite actualizar el genero*/
    function actualizarGenero() {
        $idGenero = $_REQUEST["id"];
        $nombre = $_REQUEST["nombre"];

        $model = new Genero_Model();
        $salida = $model->actualizarGenero($idGenero, $nombre);

           if ($salida == -1) {
            echo "NO se puedo agregar a la base de datos";
        } else {
            echo"Se edito correctamente a la base de datos";
        }
        
        return $this->listadoGeneros();
    }

}

?>
