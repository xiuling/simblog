
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Blogs</title>

	<link rel="stylesheet" type="text/css" href="../css/page.css" />  
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css" />
	
</head>
<body>
	<nav class="navbar navbar-inverse" role="navigation">
		<div class="navbar-header">
		    <a class="navbar-brand" href="index.php">V2XM Blog</a>
		</div>
		<ul class="nav navbar-nav">
		    <li><a href="index.php">home</a></li>
		    <li><a href="about.php">About</a></li>
		    
	    </ul>
		<div class="container">
			
			<form class="navbar-form pull-left" method="get" action="search.php">
				<div class="input-group">
			     
			<?php
				echo '<input type="text" name="search"  class="form-control" ';
				if (isset($_GET['search'])) {
					echo ' value="' . htmlspecialchars($_GET['search']) . '" ';
				}
				echo '/>';
			?>
				<span class="input-group-btn">
			        <button class="btn btn-default" type="submit">Submit</button>
			      </span>
			    </div>
		    </form>
			<ul class="nav pull-right">		    	
				<li class="pull-right"><a href="logout.php">Log Out</a></li>
				<li class="divider-vertical pull-right"></li>
				<li class="pull-right"><a href="login.php">Log In</a></li>
				<?php
		    		if(isset($_SESSION['username'])){
		    	?>
		    		<li class="pull-right"><a href="admin.php">Manage</a></li>
					<li class="pull-right"><a href="profile.php"><?php echo $_SESSION['username']; ?></a></li>
				<?php
					}
				?>
				<li class="divider-vertical pull-right"></li>
			</ul>
		</div>		
	</nav>

	<div id="main">
		
	
