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

        $idGenero = $db->insert($sql, true, $e);

        $salida = NULL;
        if (isset($idGenero)) {
            $salida = $idGenero;
        } else {
            $salida = -1;
        }
        return $salida;
    }
/*funcion para eliminar un Genero de la base de datos*/ 
        function eliminarGenero($value) {
        global $db; // bases de datos dentro de la funcion
        $sql = "DELETE FROM genero WHERE (id_genero =" . $value . ")";
        
        $resultado = $db->delete($sql, $e);

        return $resultado;
    }

}

?>
