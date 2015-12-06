<?php

class Pelicula_Model{

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
    function getPeliculasSinSala(){
        global $db;
        $subSql = "SELECT distinct id_pelicula FROM pelicula_sala";
        $sql = "SELECT p.id_pelicula , p.pe_nombre FROM pelicula p "
             . "WHERE p.id_pelicula NOT IN ( " . $subSql ." )";
        $res = $db->select( $sql );
        if( $res ){
            $peliculas = array();
            foreach( (array) $res as $pelicula ){
                $peliculas[] = array(
                    'id_pelicula' => $pelicula['id_pelicula'],
                    'pe_nombre' => $pelicula['pe_nombre']
                );
            }
            return $peliculas;
        }else{
            return null;
        }
    }

    function getPeliculaBySala( $idSala ){
        global $db;
        $sql = "SELECT pe_nombre FROM pelicula p "
             . "INNER JOIN pelicula_sala ps ON p.id_pelicula = ps.id_pelicula "
             . "WHERE ps.id_sala = " . $idSala;
        $res = $db->select( $sql );
        $pelicula = null;
        if( $res ){
            $pelicula['pe_nombre'] = $res['0']['pe_nombre'];
        }
        return $pelicula;
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


    function editarPelicula( $id, $nombrePelicula, $genero, $director, $duracion, $fechaEstreno ){
        global $db;
        $sql =  "UPDATE pelicula SET pe_nombre = '" . $nombrePelicula
                . "', id_genero = " . $genero
                . ", id_director = ". $director
                . ", pe_fechaEstreno = '". $fechaEstreno
                . "', pe_duracion = ". $duracion
                . " WHERE id_pelicula = " . $id;
        $res = $db->update( $sql );
        if( $res == 0 ){
            // no se pudo editar la pelicula
            return -1;
        }
        if( $res ){
            // Se inserto con exito (Retorna numero de filas afectadas)
            return $res;
        }
    }
}
?>
