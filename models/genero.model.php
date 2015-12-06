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
        if($nombre!=NULL){
            $sql = "INSERT genero(id_genero, ge_nombre)
                VALUES ('','" . $nombre . "')";
            $salida = $db->insert($sql, true, $e);
        }
        else{
            //echo "No ingreso un nombre, no se puedo insertar el Genero";
            $salida=-1;
            
        }
        
        return $salida;
    }
/*funcion para eliminar un Genero de la base de datos*/ 
    function eliminarGenero($value) {
        global $db; // bases de datos dentro de la funcion
        
        if($value!="noSelect"){
            $sql = "DELETE FROM genero WHERE (id_genero =" . $value . ")";
            $salida = $db->delete($sql, $e);
        }
        else{
            $salida=-1;
        }
        return $salida;
    }
    
    function actualizarGenero($idGenero, $nombre) {
        # proceso: insertar ARTISTA
        global $db; // bases de datos dentro de la funcion
        if(($idGenero!="noSelect")&&($nombre!=NULL)){
            $sql = "UPDATE genero SET ge_nombre='" . $nombre . "' WHERE (id_genero =" . $idGenero . ")";
            $salida = $db->update($sql, $e);
        }
        else{
            $salida=-1;
            
        }

        return $salida;
    }

}

?>
