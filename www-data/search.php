<?php
	require 'db.inc.php';
	$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or die ('Unable to connect. Check your connection parameters.');
	mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

	include 'header.inc.php';

	$search = (isset($_GET['search'])) ? $_GET['search'] : '';
	$sql = 'SELECT cid,title,slug,type,`text`,created FROM contents WHERE  MATCH (title, `text`) 
		AGAINST ("' . mysql_real_escape_string($search, $db) . '" IN BOOLEAN MODE) 
		ORDER BY created DESC';
	$result = mysql_query($sql, $db) or die(mysql_error($db));
	if (mysql_num_rows($result) == 0) {
		echo '<div class="contents"><strong>No articles found that match the search terms.</strong></div>';
	} else {
		while ($row = mysql_fetch_array($result)) {
			echo ' <div class="contents"> ';
            echo ' <h3><a href="blog.php?cid='.$row['cid'].'"> ' . $row['title'] . '</a></h3>';
            echo ' <p> type:' . $row['type'] . '&nbsp;&nbsp; created:' . $row['created'];
            echo ' <div> ' . $row['text'] . ' </div> ';
            echo '</div> ';
	}
	}
	mysql_free_result($result);

	include 'foot.inc.php';
?>
