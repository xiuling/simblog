<?php
	session_start();
    if($_SESSION['name']){
        echo '<div class="logheader">Welcome back, '.$_SESSION['name'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="admin.php">Manage Blog</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="change.php">Profiles</a></div>';
    }
    include 'db.inc.php';
    $db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or die ('Unable to connect. Check your connection parameters.');
    mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));
?>
<html>
<head>
	<title>Blogs</title>
<!--	<link rel="stylesheet" type="text/css" href="../css/base.css" />  -->
	<link rel="stylesheet" type="text/css" href="../css/common.css" />
	<link rel="stylesheet" type="text/css" href="../css/page.css" />
	<style type="text/css">
		body#intro #about a{ color: #333; padding-bottom: 5px; border-color: #727377; background: #FFF;}
	</style>
</head>
<body id="intro">
	<div id="banner"><a href="index.php">Blogs</a></div>
	<div id="nav">
		<ul>
			<li id="home"><a href="index.php">Home</a></li>
			<li id="about"><a href="about.php">About</a></li>
		</ul>
	</div>
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
			<input type="submit" value="Search" />
		</form>
	</div>
	<div id="wrap">
			<?php
			    $query = 'SELECT `text`,contents.created,users.name FROM contents,users WHERE type="about" AND contents.authorId=users.uid ORDER BY created DESC LIMIT 1';
			    $result = mysql_query($query, $db) or die (mysql_error($db));
				if (mysql_num_rows($result) > 0) {
					echo ' <div class="contents"> ';
			        echo ' <h3><a href="about.php"> About Us</a></h3>';
			        while ($row = mysql_fetch_assoc($result)) {			        	
			            echo ' <p> Author:&nbsp;' . $row['name'] . '&nbsp;&nbsp; created:&nbsp;' . $row['created'];
			            echo ' <div> ' . $row['text'] . ' </div> ';
			            echo '<hr />';
			       }
			    }			
		echo '</div>';
		echo ' <div class="comments"> ';
    	$query = 'SELECT coid, created, author, mail, `text` FROM comments WHERE type="about"';
	    $result = mysql_query($query,$db) or die(mysql_error($db));
	    if(mysql_num_rows($result) > 0){
	        echo '<h3>Commemts Here:</h3>'; 
	        while ($row = mysql_fetch_assoc($result)) {                      
	            echo '<hr /> <p>author:&nbsp;' . $row['author'] .'&nbsp;&nbsp; mail:&nbsp;' . $row['mail'] . '&nbsp;&nbsp; created:&nbsp;' . $row['created'];
	            echo ' <div> ' . $row['text'] . ' </div> ';
	        }
	    }else{        
	        echo '<p>There is no comments yet.</p>';
	        echo '<p>You can give a conmments.</p>';
	    }
	    echo '</div>';

	    if (isset($_GET['error']) && $_GET['error'] != '') {
	        echo ' <div id="error"> ' . $_GET['error'] . ' </div> ';
	    }
?>
    <h3>Add a comment</h3>
    <div class="postcomment">
    <form action="postcomment.php" method="post">
        <input type="hidden" name="type" value="about" />
        <label for="author" class="label">Author:</label><input type="text" name="author" class="long" /><br />
        <label for="mail" class="label">Mail:</label><input type="text" name="mail" class="long" /><br />
        <label for="Commemts" class="label">Comments:</label><textarea name="text" class="mid"></textarea><br />
        <input type="submit" value="Post" />&nbsp;&nbsp;<input type="reset" value="Reset" />
    </form>
    </div>
</div>
<?php    
    include 'sidebar.php';
?>
<div id="foot" style="clear:both;"></div>
</body>
</html>