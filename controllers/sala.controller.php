<?php

    class Sala_Controller{

        function insertarSala(){
            if( $_SERVER['REQUEST_METHOD'] == 'GET' ){
                $tpl = new TemplatePower("./templates/insertarSala.html");
                $tpl->prepare();
                return $tpl->getOutputContent();
            }
            if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
                dump($_REQUEST );
                /*$nombre = $_REQUEST['sa_nombre'];
                //$horaExhibicion = $_REQUEST['sa_horaExhibicion'];
                $horaExhibicion = 'hola';
                $Model = new Sala_Model();
                $error = null;
                $res = $Model->insertarSala( $nombre , $horaExhibicion , $error );
                */
            }
        }

        function editarSala( $id ){
            if( $_SERVER['REQUEST_METHOD'] == 'GET' ){
                $tpl = new TemplatePower("./templates/editarSala.html");
                $tpl->prepare();
                return $tpl->getOutputContent();
            }
            if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
                dump( $_REQUEST );
                /*$Model = new Sala_Model();
                $error = null;
                $res = $Model->editarSala( $id , $nombre , $horaExhibicion , $error );
                dump( $res );
                dump( $error );*/
            }
        }

    }
?>
