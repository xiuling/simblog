<?php
	include 'db.inc.php';
    $db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or die ('Unable to connect. Check your connection parameters.');
    mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));
    include 'adminheader.inc.php';

	if (!isset($_GET['do']) || $_GET['do'] != 1) {
		echo '<h4>Are you sure you want to delete this blog?</h4> <br/> ';
		echo ' <a href="' . $_SERVER['REQUEST_URI'] . ' & do=1"> yes </a> ';
		echo 'or <a href="admin.php"> no </a> <hr />';

		$query = 'SELECT cid,title,slug,type,`text`,created FROM contents WHERE cid="'.$_GET['cid'].'" ORDER BY created ';
	    $result = mysql_query($query, $db) or die (mysql_error($db));
	    if (mysql_num_rows($result) > 0) {
	        while ($row = mysql_fetch_assoc($result)) {
	            echo ' <div class="contents" style="clear:both;"> ';
	            echo ' <h3><a href="blog.php?cid='.$row['cid'].'"> ' . $row['title'] . '</a></h3>';
	            echo ' <p> type:' . $row['type'] . '&nbsp;&nbsp; created:' . $row['created'];
	            echo ' <div> ' . $row['text'] . ' </div> ';
	            echo ' </div> ';
			}
		}
	    echo ' </div> ';
	} else {
		$query = 'DELETE FROM contents WHERE cid = "' . $_GET['cid'].'"';
		$result = mysql_query($query, $db) or die(mysql_error($db));
		if($result){
?>
	<p> Your blog has been deleted.</p>
	<?php
	header ('Refresh: 1; URL= admin.php');
	echo ' <p> You will be redirected to your original page request. </p> ';
            echo ' <p> If your browser doesn\'t redirect you properly ' . 
                'automatically, <a href="admin.php" >click here </a> . </p> ';
?>
<?php
	}
}
?>