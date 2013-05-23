<?php
    // include 'adminheader.inc.php';
    session_start();
    if($_SESSION['name']){
        echo '<div class="logheader"><p class="Welcome">Welcome back, '.$_SESSION['name'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="admin.php">Manage Blog</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="change.php">Profiles</a></p></div>';
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Blogs</title>
<!--    <link rel="stylesheet" type="text/css" href="../css/base.css" />  -->
    <link rel="stylesheet" type="text/css" href="../css/admincommon.css" />
    <link rel="stylesheet" type="text/css" href="../css/page.css" />
    <script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>
</head>
<body>
    <div id="nav"><a href="index.php">Blogs</a></div>
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
    <div id="wrap">

<?php
	include 'db.inc.php';
    $db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or die ('Unable to connect. Check your connection parameters.');
    mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

	if ($_GET['action'] == 'edit') {
	//retrieve the record’s information
		$query = 'SELECT name, slug, description FROM metas
			WHERE cid = "' . $_GET['cid']. '"';
		$result = mysql_query($query, $db) or die(mysql_error($db));
		extract(mysql_fetch_assoc($result));
	} else {
		//set values to blank
		$name = isset($_GET['name'])?$_GET['name']:'';
		$description = isset($_GET['description'])?$_GET['description']:'';
		$slug = isset($_GET['slug'])?$_GET['slug']:'';
	}

	if (isset($_GET['error']) && $_GET['error'] != '') {
		echo ' <div id="error"> ' . $_GET['error'] . ' </div> ';
	}
?>
	<h2><?php echo ucfirst($_GET['action']); ?> Category</h2>
	<form action="commit.php?action=<?php echo $_GET['action']; ?>" method="post" >
		<label for="name" class="label">Name:</label><input type="text" name="name" value="<?php echo $name; ?>" class="long" /><br />
		<label for="slug" class="label">Slug:</label><input type="text" name="slug" value="<?php echo $slug; ?>" class="long" /><br />
		<label for="description" class="label">Description:</label><input type="text" name="description" value="<?php echo $description; ?>" class="long" /><br /><br />
		<input type="submit" name="submit" value="Add" />&nbsp;&nbsp;&nbsp;
		<input type="reset" value="Reset" />
	</form>
<?php
    // include 'adminfoot.inc.php';
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