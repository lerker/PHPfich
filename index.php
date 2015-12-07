<?php

//===========================================================================================================
// OPEN SESSION |
//---------------
session_start();

//===========================================================================================================
// INCLUDES |
//-----------

include("./config/inc.includes.php");


//===========================================================================================================
// OPEN CONNECTION |
//------------------
// aca conviene abrir la coneccion y dejarla abierta, solo cerrarla al final. Para no sobrecargar la red
// pero se podria abrir y cerrar en cada funcion
if (!isset($db)){  // si no esta la db seteada
	if ($config["dbEngine"]=="MYSQL"){
		$db = new MySQL($config["dbhost"],$config["dbuser"],$config["dbpass"],$config["db"]);
        #mysqli_set_charset("utf8");
	}
	//var_dump($db);
}

//===========================================================================================================
// INSTANCIA CLASES Y METODOS |
//-----------------------------

if ((!isset($_REQUEST["action"])) || ($_REQUEST["action"] == "")) {
	// si no tenemos un campo action, o esta vacio, redirigimos todo el ingreso al inicio de nuestra app
  $_REQUEST["action"] = "Ingreso::main";
}
if ($_REQUEST["action"] == "") { // puede pasar que no se cargue, solo por precaucion, se carga un html vacio
  $html = "";
} else {
  if (!strpos($_REQUEST["action"], "::")) { // viene sin dos puntos, los concatenos. Dividimos las funciones del controlador
    $_REQUEST["action"].="::menu";
  }
  // class paramam clase, y method, funcion
  list($classParam, $method) = explode('::', $_REQUEST["action"]); // divide esos dos cosos, y lo guarda en una lista con dos varibles
  if ($method == "") {
    $method = "main";
  }
  $classToInstaciate = $classParam . "_Controller";
  if (class_exists($classToInstaciate)) { // verifica si la classe existe, si esta cargada. Controlador y modelo deben estar incluidos
    if (method_exists($classToInstaciate, $method)) {
      $claseTemp = new $classToInstaciate;
      $html = call_user_func_array(array($claseTemp, $method), array()); // en html, el getOutputContext del template retorna un string de html para mostrar
    } else {
      $html = "No tiene permitido acceder a ese contenido.";
    }
  } else {
    $html = "La p&aacute;gina solicitada no est&aacute; disponible.";
  }
}

//===========================================================================================================
// INSTANCIA TEMPLATE |
//---------------------

// aca se crea un contenedor, para que todas las paginas se mantengan semilares entre paginas
// dentro del contenedor le incrustamos la pagina, html calculada para mostrar.
	$tpl = new TemplatePower("recursos/_html/index.html");
	$tpl->prepare();
    #date("d/m/y")
    date_default_timezone_set('America/Argentina/Buenos_Aires');
	$tpl->assign("fecha_completa",date('d/m/y h:i:s A'));
	$tpl->assign("aplicacion","Cine El SOBON");

//===========================================================================================================
// LEVANTA TEMPLATE	|
//-------------------

// aca asignamos el contenido para el contenedor
	$tpl->gotoBlock("_ROOT");
	$tpl->assign("contenido",$html);
	$html=$tpl->getOutputContent();
	echo $html;
?>
