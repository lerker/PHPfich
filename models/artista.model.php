<?php

//var_dump($sql);
//die();
class Artista_Model{
    /*funcion que inserta un Artista en la base de datos*/
    function insertarArtista($nombre, $apellido, $dni, $mail) {
        # proceso: insertar ARTISTA
        global $db; // bases de datos dentro de la funcion
        if(($nombre!=NULL)&&($apellido!=NULL)){
                $sql = "INSERT artista(id_artista, ar_nombre, ar_apellido, ar_dni, ar_mail)
                        VALUES ('','" . $nombre . "','" . $apellido . "','" . $dni . "','" . $mail . "')";

                $idArtista = $db->insert($sql, true, $e);
        }
        else {
            $salida = -1;
        }
        return $salida;
    }

    /*funcion para eliminar un Artista de la base de datos*/
    function eliminarArtista($value, $campo='id') {
        global $db; // bases de datos dentro de la funcion
        if($value!="noSelect"){
            $sql = "DELETE FROM artista WHERE ";
             
            switch ($campo) {
                case 'dni'://esta opcion no se usa, pero la deje por las dudas
                    $sql .= "(ar_dni =" . $value . ")";
                    break;
                case 'apellido'://esta tampoco se usa pero la deje por las dudas
                    $sql .= "(ar_apellido =" . $value . ")";
                    break;
                case 'id'://creo que eliminar por id va a ser lo mejor
                    $sql .= "(id_artista =" . $value . ")";
                    break;
                default:
                    echo "campo de arstista no existe";
                    die;
                    break;
            }

            $salida = $db->delete($sql, $e);
        }
        else{
            $salida=-1;
        }
        return $salida;
    }
    
    /*funcion que lista los Artistas que se encuentran en la base de datos*/
    function listadoArtistas(){
        global $db; # manejo la bases de datos dentro de la funcion

        # creo la consulta SQL
        $sql = "SELECT artista.id_artista, artista.ar_nombre, artista.ar_apellido, artista.ar_dni, artista.ar_mail  
                    FROM artista
                    ORDER BY artista.ar_apellido, artista.ar_nombre";

        # la envio a la bases de datos, SELECT
        $resultado = $db->select( $sql );

        # retorno la lista como resultado
        return $resultado;
    }
    
    function actualizarArtista($idArtista, $nombre, $apellido, $dni, $mail) {
        # proceso: insertar ARTISTA
        global $db; // bases de datos dentro de la funcion
         if(($idArtista!="noSelect")&&($nombre!=NULL)&&($apellido!=NULL)){
                $sql = "UPDATE artista SET ar_nombre='" . $nombre . "', ar_apellido='" . $apellido . "', ar_dni='" . $dni . "', ar_mail='" . $mail .
                       "' WHERE (id_artista =" . $idArtista . ")";
        
                $resultado = $db->update($sql, $e);
         }
        else {
            $salida = -1;
        }
        return $salida;
    }

}
?>
