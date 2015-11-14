<?php
            
//var_dump($sql);
//die();
class Pelicula_Model{

//-----------------------------------------------------------------------------
//
//                      L I S T A R   C O S A S
//
//-----------------------------------------------------------------------------

    function listadoPeliculas(){
        global $db; # manejo la bases de datos dentro de la funcion

        # creo la consulta SQL
        $sql = "SELECT p.id_pelicula, p.pe_nombre, g.ge_nombre, d.di_nombreArtistico, p.pe_duracion
                    FROM pelicula p
                    INNER JOIN genero g
                    ON p.id_genero = g.id_genero
                    INNER JOIN director d
                    ON p.id_director = d.id_director
                    ORDER BY p.pe_nombre";

        # la envio a la bases de datos, SELECT
        $resultado = $db->select( $sql );

        # retorno la lista como resultado
        return $resultado;
    }


    function peliculasPorGenero($id_genero) {

        global $db; // bases de datos dentro de la funcion
        $sql = "SELECT p.id_pelicula, p.pe_nombre, g.ge_nombre, d.di_nombreArtistico, p.pe_duracion
                    FROM pelicula p
                    INNER JOIN genero g
                    ON p.id_genero = g.id_genero
                    INNER JOIN director d
                    ON p.id_director = d.id_director
                    WHERE p.id_genero = ".$id_genero;

        $resultado = $db->select( $sql );


        return $resultado;
    }

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

    function listadoDirectores(){
        global $db; # manejo la bases de datos dentro de la funcion

        # creo la consulta SQL
        $sql = "SELECT director.id_director, director.id_artista, director.di_nombreArtistico
                    FROM director
                    ORDER BY director.di_nombreArtistico";

        # la envio a la bases de datos, SELECT
        $resultado = $db->select( $sql );

        # retorno la lista como resultado
        return $resultado;
    }

    function getPelicula($idPelicula){
        global $db; # manejo la bases de datos dentro de la funcion

        # creo la consulta SQL
        $sql = "SELECT p.id_pelicula, p.pe_nombre, g.ge_nombre, d.di_nombreArtistico, p.pe_duracion, p.pe_fechaEstreno
                    FROM pelicula p
                    INNER JOIN genero g
                    ON p.id_genero = g.id_genero
                    INNER JOIN director d
                    ON p.id_director = d.id_director
                    WHERE p.id_pelicula = ".$idPelicula.";";

        # la envio a la bases de datos, SELECT
        $resultado = $db->select( $sql );

        # retorno la lista como resultado
        return $resultado[0];
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

    function insertarPelicula($id_genero,$id_director,$pe_nombre,$pe_duracion,$pe_fechaEstreno){
        global $db;

        $sql = "INSERT INTO pelicula(id_pelicula, id_genero, id_director, pe_nombre, pe_duracion, pe_fechaEstreno) VALUES ('', '".$id_genero."', '".$id_director."', '".$pe_nombre."', '".$pe_duracion."', '".$pe_fechaEstreno."');";

        $idPelicula = $db->insert($sql,true,$e);

        return $idPelicula;
    }


    function eliminarPelicula($idPelicula) {
        global $db; // bases de datos dentro de la funcion
        $sql = "DELETE FROM pelicula WHERE pelicula.id_pelicula =".$idPelicula.";";

        $err='';
        $cantidad = $db->delete($sql,$err);
        
        return $cantidad;
    }

    function cambiarGenero($nombrePelicula, $generoNuevo) {
        global $db; // bases de datos dentro de la funcion
        $sql = "UPDATE pelicula SET pelicula.id_genero = '".$generoNuevo."' WHERE pelicula.pe_nombre LIKE '".$nombrePelicula."';";

        $err='';
        $cantidad = $db->update($sql,$err);
        
        return $cantidad;
    }

    
    
    
}
?>