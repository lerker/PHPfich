<?php

//var_dump($sql);
//die();
class Artista_Model{
    function insertarArtista($nombre, $apellido, $dni, $mail) {
        # proceso: insertar ARTISTA
        global $db; // bases de datos dentro de la funcion
        $sql = "INSERT artista(id_artista, ar_nombre, ar_apellido, ar_dni, ar_mail)
                VALUES ('','".$nombre."','".$apellido."','".$dni."','".$mail."')";

        $idArtista = $db->insert($sql,true,$e);

        $salida = NULL;
        if (isset($idArtista)){
            $salida = $idArtista;
        }
        else{
            $salida = -1;
        }
        return $salida;
    }

    function eliminarArtista($value, $campo) {
        global $db; // bases de datos dentro de la funcion


        $sql = "DELETE FROM artista WHERE ";

        switch ($campo) {
            case 'dni':
                $sql."artista.dni LIKE '".$value."';";
                break;
            case 'apellido':
                $sql."artista.apellido LIKE '".$value."';";
                break;
            default:
                echo "campo de arstista no existe";
                die;
                break;
        }

        $cantidad = $db->delete($sql,$e);

        return $cantidad;
    }
}
?>
