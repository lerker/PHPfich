<?php

    class Sala_Model {
        
        function altaSala( $nombre , $horaExibicion ){
            global $db;
            $sql = "INSERT sala( sa_nombre , sa_horaExhibicion ) "
                 . "VALUES ('" . $nombre . "','" . $horaExibicion . "') ";
            $res = $db->insert( $sql , true );
            if( $res == 0 ){
                // error al insertar
                return -1;
            }
            return $res;
        }
        
        function editarSala( $id , $nombre , $horaExhibicion ){
            global $db;
            $sql = "UPDATE sala SET sa_nombre = '" . $nombre . "', sa_horaExhibicion = '" . $horaExhibicion . "' "
                 . "WHERE id_sala = " . $id;
            $res = $db->update( $sql );
            if( $res == 0 ){
                // no se pudo editar la sala
                return -1;
            }
            if( $res ){
                // Se inserto con exito (Retorna numero de filas afectadas)
                return $res;
            }
        }
        
        function eliminarSala( $idSala ){
            global $db;
            $sql = "DELETE FROM sala WHERE id_sala = " . $idSala;
            $res = $db->delete( $sql );
            return $res;
        }
        
        function asignarSala( $idSala , $idPelicula ){
            global $db;
            $sql = "INSERT pelicula_sala( id_sala , id_pelicula ) "
                 . "VALUES ('" . $idSala . "','" . $idPelicula . "') ";
            $res = $db->insert( $sql , true );
            if( $res == 0 ){
                return true;
            }
            return false;
        }
        
        function listarSalas(){
            global $db;
            $sql = "SELECT * FROM sala";
            $res = $db->select( $sql );
            $listado = array();
            if( $res ){
                foreach( (array) $res as $sala ){
                    $listado[] = array(
                        'id_sala' => $sala['id_sala'],
                        'sa_nombre' => $sala['sa_nombre'],
                        'sa_horaExhibicion' => $sala['sa_horaExhibicion']
                    );
                }
            }
            return $listado;
        }
        
        function getSalaById( $id ){
            global $db;
            $sql = "SELECT * FROM sala WHERE id_sala = " . $id;
            $res = $db->select( $sql );
            if( $res ){
                $sala = array(
                    'id_sala' => $res['0']['id_sala'],
                    'sa_nombre' => $res['0']['sa_nombre'],
                    'sa_horaExhibicion' => $res['0']['sa_horaExhibicion']
                );
                return $sala;
            }
            return false;
        }
        
    }
