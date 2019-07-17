<?php

require "basics/bootstrap.php";
require "helpers/functions.php";
require "helpers/sessions.php";
require "helpers/cookies.php";

require "configs/constants.php";
require "configs/texts.php";
require "configs/vars.php";

# Load Database
require "configs/database/query.php";

require "helpers/sanitizer.php";
require "helpers/auth.php";

require "basics/controller.php";
require "basics/model.php";
require "basics/view.php";

?>