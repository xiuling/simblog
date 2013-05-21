<?php
	include 'db.inc.php';
    $db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or die ('Unable to connect. Check your connection parameters.');
    mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));
    include 'adminheader.inc.php';

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
    include 'foot.inc.php';
?>