<?php

//var_dump($sql);
//die();
class Actor_Model{
    function listadoActores(){
        global $db; # manejo la bases de datos dentro de la funcion

        # creo la consulta SQL
        $sql = "SELECT artista.id_artista, actor.id_actor, artista.ar_nombre, artista.ar_apellido, artista.ar_dni, artista.ar_mail, actor.ac_nombreArtistico
                    FROM artista
                    INNER JOIN actor
                    ON artista.id_artista = actor.id_artista
                    ORDER BY artista.ar_apellido, artista.ar_nombre";

        # la envio a la bases de datos, SELECT
        $resultado = $db->select( $sql );

        # retorno la lista como resultado
        return $resultado;
    }

    function listadoActoresPorPelicula($idPelicula){
            global $db; # manejo la bases de datos dentro de la funcion

            # creo la consulta SQL
            $sql = "SELECT artista.id_artista, actor.id_actor, artista.ar_nombre, artista.ar_apellido, artista.ar_dni, artista.ar_mail, actor.ac_nombreArtistico
                        FROM artista
                        INNER JOIN actor
                        ON artista.id_artista = actor.id_artista
                        INNER JOIN pelicula_actor
                        ON pelicula_actor.id_actor = actor.id_actor
                        WHERE pelicula_actor.id_pelicula = ".$idPelicula;

            # la envio a la bases de datos, SELECT
            $resultado = $db->select( $sql );

            # retorno la lista como resultado
            return $resultado;
    }

//-----------------------------------------------------------------------------
//
//           A L T A   B A J A  y  M O D I F I C A C I O N E S
//
//-----------------------------------------------------------------------------
    # retorna el Id del actor insertado, -1 para error
    function insertarActor($nombre, $apellido, $dni, $mail, $nombreArtistico) {
        # proceso: insertar ARTISTA, insertar dicho artista como ACTOR

        global $db; // bases de datos dentro de la funcion
        $sql = "INSERT artista(id_artista, ar_nombre, ar_apellido, ar_dni, ar_mail)
                VALUES ('','".$nombre."','".$apellido."','".$dni."','".$mail."')";

        $idArtista = $db->insert($sql,true,$e);


        if (isset($idArtista)){

            $sqlActor = "INSERT actor(id_artista,ac_normbreArtistico) VALUES('".$idArtista."', '".$nombreArtistico."')";

            $idActor = $db->insert($sqlActor,true,$e);

            if (isset($idActor)){
                return $idActor;
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

    function eliminarActor($nombreArtistico) {
        # puedo eliminar al actor pero no al artista aun

        global $db; // bases de datos dentro de la funcion


        $sql = "DELETE FROM actor WHERE actor.ac_nombreArtistico LIKE '".$nombreArtistico."';";

        $err='';
        $cantidad = $db->delete($sql);

        return $cantidad;
    }
}
?>
