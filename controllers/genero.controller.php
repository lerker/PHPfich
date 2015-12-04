<?php

class Genero_Controller{
    
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
    
/*con esta funcion solo llamo a crear al template para agregar artista*/
    function altaGenero() {
        $model = new Genero_Model();

        $tpl = new TemplatePower("templates/altaGenero.html");

        $tpl->prepare();  # segunda linea necesaria
        $tpl->gotoBlock("_ROOT"); # desde el comienzo
        # finalizo la transaccion, es necesaria
        return $tpl->getOutputContent();
    }
    
/*esta funcion se dispara cuando presiono el boton guardar dentro del formulario*/
    function agregarGenero() {

        #$id_pelicula
        $nombre = $_REQUEST["nombre"];
        #dump ($_REQUEST);
        #die;
        $model = new Genero_Model();
        $salida = $model->insertarGenero($nombre);

        return $this->listadoGeneros();
    }
    
    /* funcion que me crea el formulario para eliminar un Genero*/
    function bajaGenero() {
        $model = new Genero_Model();

        $tpl = new TemplatePower("templates/bajaGenero.html");

        $tpl->prepare();  # segunda linea necesaria
        $tpl->gotoBlock("_ROOT"); # desde el comienzo

        $listado_generos = $model->listadoGeneros();

        if ($listado_generos) {
            $tpl->gotoBlock("_ROOT");
            foreach ($listado_generos as $data) {
                $tpl->newBlock("blockGenero");
                $tpl->assign("var_gen_id", $data["id_genero"]);
                $tpl->assign("var_gen_nombre", $data["ge_nombre"]);
                
            }
        } else {
            $tpl->gotoBlock("_ROOT");
            #$tpl->newBlock("block_no_Generos");
            #$tpl->assign("var_texto_no_Generos", "<b>NO HAY GENEROS</b>");
        }
        # finalizo la transaccion, es necesaria
        return $tpl->getOutputContent();
    }
/*funcion que se comunica con el modelo y elimina el Artista deseado*/
    function eliminarGenero() {
        $idGenero = $_REQUEST["nombre_gen"];
        $model = new Genero_Model();
        $salida = $model->eliminarGenero($idGenero);
        return $this->listadoGeneros();
    }

}

?>
