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

    /**
    * Para listar Peliculas por diferentes criterios
    * @param string $listarPor
    * @param int $idListaPor
    * @return retorn idpelicula, nombre, genero nombre, director, duracion
    */
    function peliculasPor($listarPor, $idListaPor){
        global $db;
        $sql = "SELECT p.id_pelicula, p.pe_nombre, g.ge_nombre, d.di_nombreArtistico, p.pe_duracion
                    FROM pelicula p
                    INNER JOIN genero g
                    ON p.id_genero = g.id_genero
                    INNER JOIN director d
                    ON p.id_director = d.id_director";

        switch ($listarPor) {
            case "genero":
                $sql = $sql." WHERE p.id_genero = ".$idListaPor;
                break;
            case "director":
                $sql = $sql." WHERE d.id_director = ".$idListaPor;
                break;
        }
        $resultado = $db->select( $sql );

        return $resultado;

    }

    ## TODO eliminar estas dos funciones a futuro
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
