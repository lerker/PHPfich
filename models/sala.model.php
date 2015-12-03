<?php

    class Sala_Model {
        
        function insertarSala( $nombre , $horaExibicion , &$error = null ){
            global $db;
            $sql = "INSERT INTO sala( sa_nombre , sa_horaExhibicion ) "
                 . "VALUES ('" . $nombre . "','" . $horaExibicion . "') ";
            $res = $db->insert( $sql , true , $error );
            dump( $res );
            if( $res === false ){
                // error sql
                return -2;
            }
            if( $res === 0 ){
                // error al insertar
                return -1;
            }
            return $res;
        }
        
        function editarSala( $id , $nombre , $horaExhibicion , &$error = null ){
            global $db;
            $sql = "UPDATES sala SET sa_nombre = '" . $nombre . "', sa_horaExhibicion = '" . $horaExhibicion . "' "
                 . "WHERE id_sala = " . $id;
            $res = $db->update( $sql , $error );
            if( $res === false ){
                // error sql
                return -2;
            }
            if( $res === 0 ){
                // no se pudo editar la sala
                return -1;
            }
            if( $res ){
                // Se inserto con exito (Retorna numero de filas afectadas)
                return $res;
            }
        }
        
    }
