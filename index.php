<?php

define("BASEURL", 1);

# Load Foundation
require "app/basics/bootstrapper.php";
require "helpers/functions.php";
require "helpers/sessions.php";
require "helpers/cookies.php";

# Load Constants
require "configs/constants.php";
require "configs/texts.php";
require "configs/vars.php";

# Load Database
require "configs/database/querier.php";

# Load Core Helpers
require "helpers/sanitizer.php";
require "helpers/auth.php";

# Load MVC Base Classes
require "app/basics/controller.php";
require "app/basics/model.php";
require "app/basics/view.php";

# Load Every Model
foreach (glob("app/models/*.php") as $script) {
	require $script;
}

$kernel = new Bootstrapper();

?>