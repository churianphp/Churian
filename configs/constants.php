<?php 

Sessions::init();

date_default_timezone_set("Africa/Lagos");

# App Name
define("APP_NAME", "Churian");

# App URLs
define("URL", "//$_SERVER[HTTP_HOST]/");
define("UPLOADS_URL", URL."public/uploads/");
define("IMAGES_URL", URL."public/images/");
define("FILES_URL", URL."public/files/");
define("CSS_URL", URL."public/styles/");
define("JS_URL", URL."public/js/");

?>