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
        
        function editarSala( $id ){
            $salaModel = new Sala_Model();
            if( $_SERVER['REQUEST_METHOD'] == 'GET' ){
                if( $sala = $salaModel->getSalaById( $id ) ){
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
                $res = $salaModel->editarSala( $_REQUEST['id_sala'] , $_REQUEST['sa_nombre'] , $_REQUEST['sa_horaExhibicion'] );
                unset( $salaModel );
                if( $res == -1 ){
                    return $this->listarSalas( 'danger' , 'Error al editar la sala. Por favor, intente nuevamente.' );
                }else{
                    return $this->listarSalas( 'success' , 'Los datos de la sala fueron modificados con éxito.' );
                }
            }
        }
        
        function eliminarSala( $id ){
            $salaModel = new Sala_Model();
            $res = $salaModel->eliminarSala( $id );
            if( $res == 0 ){
                return $this->listarSalas( 'info' , 'No existe la sala.' );
            }else{
                return $this->listarSalas( 'success' , 'La sala fue eliminada con éxito.' );
            }
        }
        
        function asignarSala( $id ){
            $salaModel = new Sala_Model();
            $sala = $salaModel->getSalaById( $id );
            if( !$sala ){
                return $this->listarSalas( 'info' , 'No existe la sala.' );
            }
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
                    return $this->listarSalas( 'info' , 'No se asignó ninguna película.' );
                }else{
                    $res = $salaModel->asignarSala( $_REQUEST['id_sala'] , $_REQUEST['id_pelicula'] );
                    if( !$res ){
                        return $this->listarSalas( 'danger' , 'Error al asignar la sala. Por favor, intente nuevamente.' );
                    }else{
                        return $this->listarSalas( 'success' , 'La sala ha sido asignada con éxito.' );
                    }
                }
            }
        }
        
        function listarSalas( $class = null , $mensaje = null ){
            $Model = new Sala_Model();
            $tpl = new TemplatePower("templates/listadoSalas.html");
            $mostrar = false;
            if( !is_null( $class ) && !is_null( $mensaje ) ){
                $tpl->assignInclude( "mensajes" , "./templates/mensajes.html");
                $mostrar = true;
            }
            $tpl->prepare();
            $tpl->gotoBlock( "_ROOT" );
            if( $mostrar ){
                $tpl->assign( "var_clase" , $class );
                $tpl->assign( "var_mensaje" , $mensaje );
            }
            $listado = $Model->listarSalas();
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
