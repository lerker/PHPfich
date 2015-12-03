<?php

    class Director_Model {
        function listadoDirectores(){
        global $db; # manejo la bases de datos dentro de la funcion

        # creo la consulta SQL
        $sql = "SELECT director.id_director, director.id_artista, director.di_nombreArtistico
                    FROM director
                    ORDER BY director.di_nombreArtistico";

        # la envio a la bases de datos, SELECT
        $resultado = $db->select( $sql );

        # retorno la lista como resultado
        return $resultado;
    }

    }
