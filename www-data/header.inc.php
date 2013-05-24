<?php
	session_start();
    if($_SESSION['username']){
        echo '<div class="logheader"><p class="Welcome">Welcome back, '.$_SESSION['username'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="admin.php">Manage Blog</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="change.php">Profiles</a></p></div>';
    }else{
    	
    }
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Blogs</title>
<!--	<link rel="stylesheet" type="text/css" href="../css/base.css" />  -->
	<link rel="stylesheet" type="text/css" href="../css/common.css" />
	<link rel="stylesheet" type="text/css" href="../css/page.css" />
	<style type="text/css">
		body#intro #home a{ color: #333; padding-bottom: 5px; border-color: #727377; background: #FFF;}
	</style>
</head>
<body id="intro">
<div id="head">
	<div id="banner"><a href="index.php">Blogs</a></div>
	<div id="search">
		<form method="get" action="search.php">
			<label for="search">Search</label>
	<?php
		echo '<input type="text" name="search" ';
		if (isset($_GET['search'])) {
			echo ' value="' . htmlspecialchars($_GET['search']) . '" ';
		}
		echo '/>';
	?>
			<div class="button"><input type="submit" value="Search" /></div>
		</form>
	</div>
</div>
	<div id="nav">
		<ul>
			<li id="home"><a href="index.php">Home</a></li>
			<li id="about"><a href="about.php">About</a></li>
		</ul>
	</div>
	
	<div id="wrap">