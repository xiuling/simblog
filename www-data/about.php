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
	
</head>
<body>
	<nav class="navbar navbar-inverse" role="navigation">
		<div class="navbar-header">
		    <a class="navbar-brand" href="#">V2XM Blog</a>
		</div>
		<ul class="nav navbar-nav">
		    <li><a href="index.php">home</a></li>
		    <li class="active"><a href="about.php">About</a></li>
		    
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

	<div class="row" id="main">
		<div class="col-lg-10 mainleft">

	<?php
	include 'db.inc.php';
    $db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or die ('Unable to connect. Check your connection parameters.');
    mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

 ?>

	<div class="contents"> 
		<h3><a href="about.php"> About Us</a></h3>
			<?php
			    $query = 'SELECT cid,`text`,contents.created,contents.modified,commentsNum FROM contents WHERE type=0';
			    $result = mysql_query($query, $db) or die (mysql_error($db));
				if (mysql_num_rows($result) > 0) {					
			        while ($row = mysql_fetch_assoc($result)) {	
			        	if($row['modified']){		        	
			            	echo ' <small> created:&nbsp;' . $row['created'] . '&nbsp;&nbsp;modified:&nbsp;' . $row['modified'] . '&nbsp;&nbsp;comments:&nbsp;'. $row['commentsNum'] .'</small>';
			            }else{
			            	echo ' <small"> created:&nbsp;' . $row['created'] . '&nbsp;&nbsp;comments:&nbsp;'. $row['commentsNum'] .'</small>';
			            }
			            echo ' <div> ' . $row['text'] . ' </div> ';
			            $cid=$row['cid'];
			       }
			    }else{
			    	echo '<p>There is nothing about author yet.</p>';
			    }			
		echo '</div>';
		echo ' <div class="comments"> ';
    	$query = 'SELECT coid, created, author, mail, `text` FROM comments WHERE type="about"';
	    $result = mysql_query($query,$db) or die(mysql_error($db));
	    if(mysql_num_rows($result) > 0){ 
	        while ($row = mysql_fetch_assoc($result)) {                      
	            echo '<hr /> <small>author:&nbsp;' . $row['author'] .'&nbsp;&nbsp; mail:&nbsp;' . $row['mail'] . '&nbsp;&nbsp; created:&nbsp;' . $row['created'] . '</small>';
	            echo ' <div> ' . $row['text'] . ' </div> ';
	        }
	    }else{        
	        echo '<div class="col-lg-4" style="border: 1px dotted gray;">';       
	        echo '<small>There is no comments yet.</small><br />';
	        echo '<small>You can give a conmments.</small>';
	        echo '</div>';
	    }
	    echo '</div>';

	    if (isset($_GET['error']) && $_GET['error'] != '') {
	        echo ' <div id="error"> ' . $_GET['error'] . ' </div> ';
	    }
?>
	<br /><br /><br />
    <div class="postcomment">
    <form class="form-horizontal" role="form" action="postcomment.php" method="post">
        <input type="hidden" name="type" value="about" />
        <input type="hidden" name="cid" value="<?php echo $cid; ?>" />
        <div class="form-group">
            <label for="author" class="col-lg-2 control-label">Name</label>
            <div class="col-lg-4">
                <input type="text" class="form-control" id="author" placeholder="Name" name="author">
            </div>
        </div>
        <div class="form-group">
            <label for="mail" class="col-lg-2 control-label">Email</label>
            <div class="col-lg-4">
                <input type="text" class="form-control" id="mail" placeholder="Email" name="mail">
            </div>
        </div>
        <div class="form-group">
            <label for="comments" class="col-lg-2 control-label">Comments</label>
            <div class="col-lg-4">
                <textarea class="form-control" id="comments" placeholder="Comments" rows="6" name="text"></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
                <button type="submit" class="btn btn-default">Post</button>
            </div>
        </div>
    </form>
	</div>

<?php    
    include 'sidebar.php';
    include 'foot.inc.php';
?>
