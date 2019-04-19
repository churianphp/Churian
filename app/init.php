<?php

require "basics/bootstrap.php";

require "libs/helpers/functions.php";
require "libs/helpers/sessions.php";
require "libs/helpers/cookies.php";

require "configs/constants.php";
require "configs/conf.php";
require "configs/lang.php";

# Load Database
require "configs/database/query.php";

require "libs/helpers/sanitizer.php";
require "libs/helpers/encrypt.php";

require "basics/controller.php";
require "basics/model.php";
require "basics/view.php";

require "libs/helpers/formValidator.php";
require "libs/helpers/ipHandler.php";

?>