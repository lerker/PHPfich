<?php
	include("inc.configuration.php");

	include("./recursos/_php/class.mysqli.php");
	include("./recursos/_php/class.TemplatePower.inc.php");
	include("./recursos/_php/utils.php");

	// Controllers
	include("./controllers/pelicula.controller.php");
    include("./controllers/ingreso.controller.php");
    include("./controllers/sala.controller.php");
  	// Models
	include("./models/pelicula.model.php");
    include("./models/sala.model.php");