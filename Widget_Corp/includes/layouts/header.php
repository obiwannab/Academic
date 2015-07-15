<?php if (!isset($layout_context)) { $layout_context = "public"; } ?>
<!-- Setting a default value for context variable in case it is not set from a previous requesting page. -->
<!DOCTYPE html>
<html lang="en-us">
	<head>
		<title>Widget Corp<?php if ($layout_context == "admin") { echo " Admin"; } ?></title>
		<link href="stylesheets/public.css" media="all" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="header">
			<h1>Widget Corp<?php if ($layout_context == "admin") { echo " Admin"; } ?></h1>
		</div>