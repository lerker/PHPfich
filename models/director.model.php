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
//    function listadoDirectores(){
//        global $db; # manejo la bases de datos dentro de la funcion
//
//        # creo la consulta SQL
//        $sql = "SELECT director.id_director, director.id_artista, director.di_nombreArtistico
//                    FROM director
//                    ORDER BY director.di_nombreArtistico";
//
//        # la envio a la bases de datos, SELECT
//        $resultado = $db->select( $sql );
//
//        # retorno la lista como resultado
//        return $resultado;
//    }

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
    function getDirectorId()
    {
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

        dump($idArtista);
        if (isset($idArtista)){
            echo $idArtista;
            $sqlDirector = "INSERT director(id_artista,di_nombreArtistico) VALUES('".$idArtista."', '".$nombreArtistico."')";

        $idDirector = $db->insert($sqlDirector,true,$e);
            dump($idDirector);
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
        echo $nombreArtistico;

         $sql = "DELETE FROM director WHERE director.di_nombreArtistico LIKE '".$nombreArtistico."'";


        $err='';
        $cantidad = $db->delete($sql);

        return $cantidad;
    }
    function getDirectores($id)
    {
        global $db;

        $sql = "SELECT di_nombreArtistico,id_director FROM director WHERE id_director = ". $id;

        $salida = $db->select($sql);

        return $salida;
    }

    function updateDirector($idDirector, $nombreArtistico)
    {
        global $db;

        $sql = "UPDATE director
                SET di_nombreArtistico = '".$nombreArtistico."'
                WHERE id_actor = '".$idDirector."';";

        $resultado = $db->update($sql);

        return $resultado;
//        $sql =  "UPDATE actor AS ac
//                        INNER JOIN artista as ar on ac.id_artista = ar.id_artista
//                        SET ac.ac_nombreArtistico = '".$nombreArt."',
//                            ar.ar_nombre = '".$nombre."',
//                            ar.ar_apellido = '".$apellido."',
//                            ar.ar_dni = '".$dni."',
//                            ar.ar_mail = '".$email."'
//                            WHERE ac.id_artista = '".$idArtista."'";
    }

    }
