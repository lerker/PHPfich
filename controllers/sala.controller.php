<?php

    class Sala_Controller{
        
        function altaSala(){
            if( $_SERVER['REQUEST_METHOD'] == 'GET' ){
                $tpl = new TemplatePower("./templates/altaSala.html");
                $tpl->prepare();
                return $tpl->getOutputContent();
            }
            if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
                $Model = new Sala_Model();
                $res = $Model->altaSala( $_REQUEST['sa_nombre'] , $_REQUEST['sa_horaExhibicion'] );
                unset( $Model );
                if( $res == -1 ){
                    return $this->listarSalas( 'danger' , 'Error al agregar la sala. Por favor, intente nuevamente.' );
                }else{
                    return $this->listarSalas( 'success' , 'La sala fue agregada con éxito.' );
                }
            }
        }
        
        function editarSala(){
            $salaModel = new Sala_Model();
            if( $_SERVER['REQUEST_METHOD'] == 'GET' ){
                if( $sala = $salaModel->getSalaById( $_REQUEST['id'] ) ){
                    unset( $salaModel );
                    $tpl = new TemplatePower("./templates/editarSala.html");
                    $tpl->prepare();
                    $tpl->gotoBlock( "_ROOT" );
                    $tpl->newBlock( "editar" );
                    $tpl->assign( "var_idSala" , $sala['id_sala']  );
                    $tpl->assign( "var_nombre" , $sala['sa_nombre'] );
                    $tpl->assign( "var_horaExhibicion" , $sala['sa_horaExhibicion'] );
                    return $tpl->getOutputContent();
                }else{
                    return $this->listarSalas( 'info' , 'La sala no existe.' );
                }
            }
            if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
                $salaModel->editarSala( $_REQUEST['id_sala'] , $_REQUEST['sa_nombre'] , $_REQUEST['sa_horaExhibicion'] );
                unset( $salaModel );
                return $this->listarSalas();
            }
        }
        
        function eliminarSala(){
            $salaModel = new Sala_Model();
            $salaModel->eliminarSala( $_REQUEST['id'] );
            unset( $salaModel );
            return $this->listarSalas();
        }
        
        function asignarSala(){
            $salaModel = new Sala_Model();
            $sala = $salaModel->getSalaById( $_REQUEST['id'] );
            if( $_SERVER['REQUEST_METHOD'] == 'GET' ){
                $tpl = new TemplatePower("templates/asignarSala.html");
                $tpl->prepare();
                $tpl->gotoBlock( "_ROOT" );
                $tpl->assign( "var_idSala" , $sala['id_sala'] );
                $tpl->assign( "var_nombre" , $sala['sa_nombre'] );
                $peliculaModel = new Pelicula_Model();
                $listadoPeliculas = $peliculaModel->getPeliculasSinSala();
                foreach( (array) $listadoPeliculas as $pelicula ){
                    $tpl->newBlock( "pelicula_block" );
                    $tpl->assign( "var_idPelicula" , $pelicula['id_pelicula'] );
                    $tpl->assign( "var_nombrePelicula" , $pelicula['pe_nombre'] );
                }
                return $tpl->getOutputContent();
            }
            if( $_SERVER['REQUEST_METHOD'] == 'POST'){
                if( $_REQUEST['id_pelicula'] === "noSelect" ){
                    return $this->listarSalas();
                }else{
                    $salaModel->asignarSala( $_REQUEST['id_sala'] , $_REQUEST['id_pelicula'] );
                    return $this->listarSalas();
                }
            }
        }
        
        function listarSalas(){
            $Model = new Sala_Model();
            $tpl = new TemplatePower("templates/listadoSalas.html");
            $tpl->prepare();
            $tpl->gotoBlock( "_ROOT" );
            $listado = $Model->listarSalas();
            
            # formateo del encabezado de la tabla
            $titulo_tabla = "<h1> LISTADO DE SALAS </h1>";
            $subtitulo_tabla = "<strong><i> Cantidad: ".count($listado)."</i></strong>";
            $tpl->assign("var_titulo_tabla",  $titulo_tabla);
            $tpl->assign("var_subtitulo_tabla",  $subtitulo_tabla);
            
            if( $listado ){
                foreach( (array) $listado as $sala ){
                    $tpl->newBlock( "sala_block" );
                    $tpl->assign( "var_idSala" , $sala['id_sala'] );
                    $tpl->assign( "var_nombreSala" , $sala['sa_nombre'] );
                    $tpl->assign( "var_horaExhibicion" , $sala['sa_horaExhibicion'] );
                    $peliculaModel = new Pelicula_Model();
                    $pelicula = $peliculaModel->getPeliculaBySala( $sala['id_sala'] );
                    if( is_null( $pelicula ) ){
                        $tpl->newBlock( "sin_pelicula_sala_block" );
                        $tpl->assign( "var_idSala" , $sala['id_sala'] );
                    }else{
                        $tpl->newBlock( "pelicula_sala_block" );
                        $tpl->assign( "var_pelicula" , $pelicula['pe_nombre'] );
                    }
                }
            }else{
                $tpl->newBlock( "sin_salas_block" );
            }
            unset( $Model );
            return $tpl->getOutputContent();
        }
        
    }
