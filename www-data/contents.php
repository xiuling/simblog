<?php
	include 'db.inc.php';
    $db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or die ('Unable to connect. Check your connection parameters.');
    mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));
    include 'adminheader.inc.php';

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
	<form action="commit.php?action=<?php echo $_GET['action']; ?>" method="post" >
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
					foreach ($row as $value) {
						if ($row['mid'] == $type) {
							echo ' <option value="' . $row['mid'] .
							'" selected="selected"> ';
						} else {
							echo ' <option value="' . $row['mid'] . '" > ';				
						}
						echo $row['name'] . ' </option> ';
					}
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
                <input type="reset" value="Reset" />
				</td>
			</tr>
		</table>
	</form>
	
<?php
    include 'foot.inc.php';
?>
