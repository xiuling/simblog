<?php
	//include 'adminheader.inc.php';
	session_start();
    if($_SESSION['name']){
        echo '<div class="logheader"><p class="Welcome">Welcome back, '.$_SESSION['name'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="admin.php">Manage Blog</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="change.php">Profiles</a></p></div>';
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
		$query = 'SELECT title, `type`, `text`, slug FROM contents
			WHERE cid = "' . $_GET['cid']. '"';
		$result = mysql_query($query, $db) or die(mysql_error($db));
		extract(mysql_fetch_assoc($result));
	} else {
		//set values to blank
		$title = isset($_GET['title'])?$_GET['title']:'';
		$type = isset($_GET['type'])?$_GET['type']:'';
		$text = isset($_GET['text'])?$_GET['text']:'';
		$slug = isset($_GET['slug'])?$_GET['slug']:'';
	}

	if (isset($_GET['error']) && $_GET['error'] != '') {
		echo ' <div id="error"> ' . $_GET['error'] . ' </div> ';
	}
?>
	<h2><?php echo ucfirst($_GET['action']); ?> Blog Content</h2>
	<form action="commit.php?action=<?php echo $_GET['action']; ?>" method="post" id="form1">
		<table class="left">
			<tr>
				<td> Title </td>
				<td><input type="text" name="title" value="<?php echo $title; ?>" class="long" /> </td>
			</tr> 
			<tr>
				<td> Type </td>
				<td><select name="type">
			<?php
				// select the movie type information
				$query = 'SELECT mid,name FROM metas WHERE type="category"
					ORDER BY mid desc';
				$result = mysql_query($query, $db) or die(mysql_error($db));
				// populate the select options with the results
				while ($row = mysql_fetch_assoc($result)) {
						if ($row['mid'] == $type) {
							echo ' <option value="' . $row['mid'] .
							'" selected="selected"> ';
						} else {
							echo ' <option value="' . $row['mid'] . '" > ';				
						}
						echo $row['name'] . ' </option> ';
				}
			?>
				</select>&nbsp;&nbsp;<a href="category.php?action=insert">Add</a> </td>
			</tr> 
			<tr>
				<td> Content </td>
				<td><textarea name="text" cols="50" rows="20"><?php echo $text;?></textarea></td>
			</tr>
			<tr>
				<td> Slug </td>
				<td> <input type="text" name="slug" value="<?php echo $slug; ?>" class="long" /> </td>
			</tr> 
			<tr>
				<td colspan="2">
			<?php
				if ($_GET['action'] == 'edit') {
					echo '<input type="hidden" value="' . $_GET['cid'] . '" name="cid" />';
				}
			?>
				<input type="submit" name="submit" value="<?php echo ucfirst($_GET['action']); ?>" />&nbsp;&nbsp;&nbsp;
                <input type="reset" value="Reset" />&nbsp;&nbsp;&nbsp;
                <input type="button" id="saveDraft" value="Save Draft" />
				</td>
			</tr>
		</table>
	</form>
	<script type="text/javascript">
		jQuery(window).load(function(){
		});

		jQuery(function(){ 
			jQuery('#saveDraft').click(function(){
				jQuery.ajax({
					type:'POST',
					url:'commit.php?action=saveDraft',
					dataType:'json',
					data:jQuery("#form1").serialize(),
					success: function(data){
					}
				});
			});
		});
	</script>	

<?php
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
