<?php
    class Genero_Model{
        function listadoGeneros(){
        global $db; # manejo la bases de datos dentro de la funcion

        # creo la consulta SQL
        $sql = "SELECT genero.id_genero, genero.ge_nombre
                    FROM genero
                    ORDER BY genero.ge_nombre";

        # la envio a la bases de datos, SELECT
        $resultado = $db->select( $sql );

        # retorno la lista como resultado
        return $resultado;
    }
    }

?>
