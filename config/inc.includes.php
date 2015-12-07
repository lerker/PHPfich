<?php
	include("inc.configuration.php");

	include("./recursos/_php/class.mysqli.php");
	include("./recursos/_php/class.TemplatePower.inc.php");
	include("./recursos/_php/utils.php");

	// Controllers
    include("./controllers/ingreso.controller.php");
    include("./controllers/pelicula.controller.php");
    include("./controllers/sala.controller.php");
    include("./controllers/actor.controller.php");
    include("./controllers/genero.controller.php");
    include("./controllers/director.controller.php");
    include("./controllers/artista.controller.php");
  	// Models
	include("./models/pelicula.model.php");
    include("./models/sala.model.php");
    include("./models/actor.model.php");
    include("./models/genero.model.php");
    include("./models/director.model.php");
    include("./models/artista.model.php");
