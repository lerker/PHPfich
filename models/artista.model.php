<?php

class Artista_Model {
    /* funcion que lista los Artistas que se encuentran en la base de datos */

    function listadoArtistas() {
        global $db; # manejo la bases de datos dentro de la funcion
        # creo la consulta SQL
        $sql = "SELECT artista.id_artista, artista.ar_nombre, artista.ar_apellido, artista.ar_dni, artista.ar_mail
                    FROM artista
                    ORDER BY artista.ar_apellido, artista.ar_nombre";

        # la envio a la bases de datos, SELECT
        $resultado = $db->select($sql);

        # retorno la lista como resultado
        return $resultado;
    }

    /* funcion que inserta un Artista en la base de datos */

    function insertarArtista($nombre, $apellido, $dni, $mail) {
        # proceso: insertar ARTISTA
        global $db; // bases de datos dentro de la funcion

        $sql = "INSERT artista(id_artista, ar_nombre, ar_apellido, ar_dni, ar_mail)
               VALUES ('','" . $nombre . "','" . $apellido . "','" . $dni . "','" . $mail . "')";

        $salida = $db->insert($sql, true, $e);

        return $salida;
    }

    /* funcion para eliminar un Artista de la base de datos */

    function eliminarArtista($idArtista) {
        global $db; // bases de datos dentro de la funcion

        $sql = "DELETE FROM artista WHERE artista.id_artista =" . $idArtista . ";";

        $salida = $db->delete($sql, $e);

        return $salida;
    }

    /* funcion que Actualiza un Artistas que se encuentra en la base de datos */

    function actualizarArtista($idArtista, $nombre, $apellido, $dni, $mail) {
        # proceso: insertar ARTISTA
        global $db; // bases de datos dentro de la funcion

        $sql = "UPDATE artista SET ar_nombre='" . $nombre . "', ar_apellido='" . $apellido . "', ar_dni='" . $dni . "', ar_mail='" . $mail .
                "' WHERE (id_artista =" . $idArtista . ")";

        $salida = $db->update($sql, $e);

        return $salida;
    }

    /* funcion que retorna un artista específico que se encuentra en la base de datos */

    function getArtista($idArtista) {
        global $db; # manejo la bases de datos dentro de la funcion
        # creo la consulta SQL
        $sql = "SELECT id_artista, ar_nombre, ar_apellido, ar_dni, ar_mail
                FROM artista
                WHERE id_artista = " . $idArtista . ";";

        # la envio a la bases de datos, SELECT
        $resultado = $db->select($sql);

        # retorno la lista como resultado
        return $resultado[0];
    }

}

?>
