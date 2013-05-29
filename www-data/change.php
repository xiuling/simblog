<?php
	//include 'adminheader.inc.php';
	session_start();
    if($_SESSION['username']){
        echo '<div class="logheader"><p class="Welcome">Welcome back, '.$_SESSION['username'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="admin.php">Manage Blog</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="change.php">Profiles</a></p></div>';
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Blogs</title>
<!--	<link rel="stylesheet" type="text/css" href="../css/base.css" />  -->
	<link rel="stylesheet" type="text/css" href="../css/admincommon.css" />
	<link rel="stylesheet" type="text/css" href="../css/page.css" />
	<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
</head>
<body>
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
			<input type="submit" value="Search" />
		</form>
	</div>
</div>	
	<div id="wrap">

<?php
    include 'db.inc.php';
    $db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or die ('Unable to connect. Check your connection parameters.');
    mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

    if (isset($_GET['error']) && $_GET['error'] != '') {
		echo ' <div id="error"> ' . $_GET['error'] . ' </div> ';
	}
?>

	<h4>OPTIONS</h4>
	<div class="changePass">
		<h5>Change Password</h5>
		<form action="update.php?action=changepass" method="post">
			<label for="oldPass" class="label">Old Password:</label><input type="password" name="oldPass" class="long"/><br />
			<label for="newPass1" class="label">New Password:</label><input type="password" name="newPass1" class="long" /><br />
			<label for="newPas2s" class="label">New Again:</label><input type="password" name="newPass2" class="long" /><br />
			<div class="button"><input type="submit" value="Change" /><input type="reset" value="Reset" /></div>
		</form>
	</div>
	<div class="changeImag">
		<h5>Change Image</h5>
		<form action="update.php?action=changeimag" method="post"  enctype="multipart/form-data">
			<input type="hidden" name="name" value="image" /> 
			<label for="uploadfile">Upload Image</label><input type="file" name="uploadfile" />
			<small> <em> * Acceptable image formats include: GIF, JPG/JPEG and PNG.
				</em> </small><br />
			<div class="button"><input type="submit" value="Upload" /></div>
		</form>
	</div>
	
	<div class="about">
		<h5>Change About</h5>
	<?php
		$query = 'SELECT `text`,cid FROM contents WHERE type=0';
		$result = mysql_query($query, $db) or die (mysql_error($db));	
		if($row = mysql_fetch_assoc($result)){
			echo '<form action="update.php?action=changeabout&cid='.$row['cid'].'" method="post"> ';
			echo '<label for="text" class="label">Update About</label><textarea name="text" class="mid">'. $row['text'] .'</textarea>';
			echo '<br />';
		}
		else{
			echo '<form action="update.php?action=changeabout" method="post">';
			echo '<label for="text" class="label">Update About</label><textarea name="text" class="mid"></textarea>';
			echo '<br />';
		}
	?>
			<div class="button aboutbutton"><input type="submit" value="Update" /><input type="reset" value="Reset" /></div>
		</form>
	</div>
	<?php
		if ($_SESSION['authCode'] ==2){
	?>
	<div class="adduser">
		<h5>Add User</h5>
		<form action="update.php?action=adduser" method="post"> 
			<label for="username" class="label">Username</label><input type="text" name="username" class="long" /><br />
			<label for="password" class="label">Password</label><input type="password" name="password" class="long" /><br />
			</label for="authCode" class="label">Role</label>
			<select name="authCode">
				<option value="2">Administrator</option>
				<option value="1">Editor</option>
			</select><br />
			<div class="button"><input type="submit" value="Add User" /><input type="reset" value="Reset" /></div>
		</form>
	</div>

<?php
		}
	//include 'adminfoot.inc.php';
	}else{
    	header ('Refresh: 1; URL= login.php');
		echo ' <p> You have not logged in. You will be redirected to login page. </p> ';
            echo ' <p> If your browser doesn\'t redirect you properly ' . 
                'automatically, <a href="login.php" >click here </a> . </p> ';
    }
?>

	</div>
	<div id="foot" style="clear:both;">
	</div>
</body>
</html>