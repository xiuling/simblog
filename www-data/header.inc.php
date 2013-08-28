<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Blogs</title>

	<link rel="stylesheet" type="text/css" href="../css/page.css" />  
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="../css/bootstrap-theme.min.css" />
	
</head>
<body>		

<nav class="navbar navbar-inverse" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  	<div class="navbar-header">
    	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
	      	<span class="sr-only">Toggle navigation</span>
	      	<span class="icon-bar"></span>
	      	<span class="icon-bar"></span>
	      	<span class="icon-bar"></span>
	    </button>
    	<a class="navbar-brand" href="index.php">V2XM Blog</a>
  	</div>

  	<!-- Collect the nav links, forms, and other content for toggling -->
  	<div class="collapse navbar-collapse navbar-ex1-collapse">
    	<ul class="nav navbar-nav">
      		<li class="active"><a href="index.php">Home</a></li>
      		<li><a href="about.php">About</a></li>
    	</ul>
    	<form class="navbar-form navbar-left" role="search" method="get" action="search.php">
      		<div class="form-group">
        <?php
				echo '<input type="text" name="search"  class="form-control" ';
				if (isset($_GET['search'])) {
					echo ' value="' . htmlspecialchars($_GET['search']) . '" ';
				}
				echo '/>';
			?>
      		</div>
      		<button type="submit" class="btn btn-default">Submit</button>
    	</form>
    	<ul class="nav navbar-nav navbar-right">
    	<?php
		    if(isset($_SESSION['username'])){
		?>		    		
				<li><a href="profile.php"><?php echo $_SESSION['username']; ?></a></li>
				<li><a href="admin.php">Manage</a></li>
		<?php
			}
		?>
	      	<li><a href="login.php">Log In</a></li>
	      	<li><a href="logout.php">Log Out</a></li>
    	</ul>
  	</div><!-- /.navbar-collapse -->
</nav>

	<div class="row" id="main">
		<div class="col-lg-10 mainleft">
	
