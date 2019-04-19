<?php global $CONF, $LANG; ?>

<!DOCTYPE html>

<html lang="en" class="nojs">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

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

		<link rel="icon" href="<?=IMAGE_URL?>favicon.png" type="image/x-icon">
		<link rel="stylesheet" href="<?=CSS_URL?>lib/bootstrap.min.css">
		<link rel="stylesheet" href="<?=CSS_URL?>style.css">

		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sunflower:300">

		<title>Churian | <?=isset($this->title) ? $this->title : "Home"?></title>
	</head>

	<body>
		<main class="main">
			<div style="display: none; position: fixed; color: #004a7c; z-index: 10000000000; top: 50%; left: 50%;" class="fa fa-spinner fa-spin fa-3x fa-fw spin"></div>
			<?php if (isset($this->header)) require($this->header); ?>