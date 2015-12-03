<?php

class Artista_Controller{

    function altaArtista() {
        $model = new Artista_Model();

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
        $model = new Artista_Model();
        $salida = $model->insertarArtista($nombre, $apellido, $dni, $mail);

        #return $this->listadoArtistas();
    }
}
?>
