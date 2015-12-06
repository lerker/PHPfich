<?php

class Genero_Model {
/*funcion que lista los Generos que se encuentran en la base de datos*/
    function listadoGeneros() {
        global $db; # manejo la bases de datos dentro de la funcion
        # creo la consulta SQL
        $sql = "SELECT genero.id_genero, genero.ge_nombre
                    FROM genero
                    ORDER BY genero.ge_nombre";

        # la envio a la bases de datos, SELECT
        $resultado = $db->select($sql);

        # retorno la lista como resultado
        return $resultado;
    }
    
/*funcion que inserta un Genero en la base de datos*/
    function insertarGenero($nombre) {
        # proceso: insertar GENERO
        global $db; // bases de datos dentro de la funcion
        
        $sql = "INSERT genero(id_genero, ge_nombre)
                VALUES ('','" . $nombre . "')";
        
        $salida = $db->insert($sql, true, $e);
        
        return $salida;
    }
/*funcion para eliminar un Genero de la base de datos*/ 
    function eliminarGenero($idGenero) {
        global $db; // bases de datos dentro de la funcion
        
        $sql2 = "DELETE FROM pelicula WHERE pelicula.id_genero =" . $idGenero . ";";
        $sql = "DELETE FROM genero WHERE genero.id_genero =" . $idGenero . ";";
        
        $salida2 = $db->update($sql2, $e);
        $salida = $db->delete($sql, $e);

        return $salida;
    }
  /*funcion para actualizar un Genero de la base de datos*/   
    function actualizarGenero($idGenero, $nombre) {
        # proceso: insertar ARTISTA
        global $db; // bases de datos dentro de la funcion
        $sql = "UPDATE genero SET ge_nombre='" . $nombre . "' WHERE (id_genero =" . $idGenero . ")";
        $salida = $db->update($sql, $e);
        
        return $salida;
    }
    /*funcion para mostrar un Genero de la base de datos*/ 
    function getGenero($idGenero){
        global $db; # manejo la bases de datos dentro de la funcion

        # creo la consulta SQL
        $sql = "SELECT id_genero, ge_nombre
                FROM genero
                WHERE id_genero = ".$idGenero.";";

        # la envio a la bases de datos, SELECT
        $resultado = $db->select( $sql );

        # retorno la lista como resultado
        return $resultado[0];
    }

}

?>
