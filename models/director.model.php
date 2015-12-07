<?php

    class Director_Model {
        function peliculasPorDirector($id_director) {
        global $db; // bases de datos dentro de la funcion
        $sql = "SELECT p.id_pelicula, p.pe_nombre, g.ge_nombre, d.di_nombreArtistico, p.pe_duracion
                    FROM pelicula p
                    INNER JOIN genero g
                    ON p.id_genero = g.id_genero
                    INNER JOIN director d
                    ON p.id_director = d.id_director
                    WHERE d.id_director = ".$id_director;

        $resultado = $db->select( $sql );
        return $resultado;
    }
        function listadoDirectores(){
           global $db; # manejo la bases de datos dentro de la funcion

           # creo la consulta SQL
           $sql = "SELECT artista.id_artista, director.id_director, artista.ar_nombre, artista.ar_apellido, artista.ar_dni, artista.ar_mail, director.di_nombreArtistico
                       FROM artista
                       INNER JOIN director
                       ON artista.id_artista = director.id_artista
                       ORDER BY artista.ar_apellido, artista.ar_nombre";

           # la envio a la bases de datos, SELECT
           $resultado = $db->select( $sql );
           # retorno la lista como resultado
           return $resultado;
       }
        function getDirectorId(){
            global $db;
              # creo la consulta SQL
            $sql = "SELECT id_director,di_nombreArtistico
                        FROM director";

            # la envio a la bases de datos, SELECT
            $resultado = $db->select( $sql );
            # retorno la lista como resultado
            return $resultado;
        }

    //ABM

        function altaDirector($nombre, $apellido, $dni, $mail, $nombreArtistico) {
           # proceso: insertar ARTISTA, insertar dicho artista como ACTOR

           global $db; // bases de datos dentro de la funcion
           $sql = "INSERT artista(id_artista, ar_nombre, ar_apellido, ar_dni, ar_mail)
                   VALUES ('','".$nombre."','".$apellido."','".$dni."','".$mail."')";

           $idArtista = $db->insert($sql,true,$e);

           if (isset($idArtista)){

               $sqlDirector = "INSERT director(id_artista,di_nombreArtistico) VALUES('".$idArtista."', '".$nombreArtistico."')";

           $idDirector = $db->insert($sqlDirector,true,$e);

               if (isset($idDirector)){
                   return $idDirector;
               }
               else{
                  return -1;
               }

               return $idArtista;
           }
           else{
               return -1;
           }
       }

        function eliminarDirector($nombreArtistico) {
            # puedo eliminar al actor pero no al artista aun
            global $db; // bases de datos dentro de la funcion
            $sql = "DELETE FROM director WHERE director.di_nombreArtistico LIKE '".$nombreArtistico."'";
            $err='';
            $cantidad = $db->delete($sql);
            return $cantidad;
        }
        function getDirectores($id)
        {
            global $db;

            $sql = "SELECT d.di_nombreArtistico,ar.ar_nombre, ar.ar_apellido, "
                    . "ar.ar_dni,ar.ar_mail, d.id_director FROM director d "
                    . "INNER JOIN artista ar on d.id_artista = ar.id_artista  "
                    . "WHERE id_director = ". $id;

            $salida = $db->select($sql);

            return $salida;
        }

        function updateDirector($idDirector, $nombreArtistico){
            global $db;
            $sql = "UPDATE director
                    SET di_nombreArtistico = '".$nombreArtistico."'
                    WHERE id_director = '".$idDirector."';";

            $resultado = $db->update($sql);
            return $resultado;
        }

    }
