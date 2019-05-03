<?php global $CONF, $LANG; ?>

<!DOCTYPE html>

<html lang="en" class="nojs">
	<head>
		<title>Churian | <?=isset($this->title) ? $this->title : "Home"?></title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta charset="utf-8">

		<meta property="og:title" content="Churian">
		<meta property="og:description" content="Churian">
		<meta property="og:image" content="<?=IMAGE_URL?>favicon.png">
		<meta property="og:url" content="<?=URL?>">

		<meta name="twitter:title" content="Churian">
		<meta name="twitter:description" content="Churian">
		<meta name="twitter:image" content="<?=IMAGE_URL?>favicon.png">
		<meta name="twitter:card" content="summary_large_image">
		<meta name="description" content="Churian">
		<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

		<link rel="icon" type="image/x-icon" href="<?=IMAGE_URL?>favicon.png">
		<link rel="stylesheet" type="text/css" href="<?=CSS_URL?>lib/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?=CSS_URL?>style.css">

		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sunflower:300">
	</head>

	<body>
		<main class="main">
			<?php if (isset($this->header)) require($this->header); ?>