<?php
	include 'header.inc.php';
	include 'db.inc.php';
	$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or die ('Unable to connect. Check your connection parameters.');
	mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

	if($search = (isset($_GET['search'])) ? $_GET['search'] : ''){
		$sql = 'SELECT cid,title,contents.text,contents.created,metas.name FROM contents,metas WHERE  MATCH (title, `text`) 
			AGAINST ("' . mysql_real_escape_string($search, $db) . '" IN BOOLEAN MODE) AND contents.status=0 and contents.type=metas.mid
			ORDER BY created DESC';
		$result = mysql_query($sql, $db) or die(mysql_error($db));
		if (mysql_num_rows($result) == 0) {
			echo '<div class="text-info"><strong>No articles found that match the search terms.</strong></div>';
		} else {
			while ($row = mysql_fetch_array($result)) {
				echo ' <div class="contents"> ';
	            echo ' <h3><a href="blog.php?cid='.$row['cid'].'"> ' . $row['title'] . '</a></h3>';
	            echo '<small>type:<a href="search.php?type='.$row['name'].'">' . $row['name'] . '</a>&nbsp;&nbsp; created:' . $row['created'] .'</small>';
	            echo ' <p> ' . $row['text'] . '</p>' ;
	            echo '</div> ';
			}
		}
		mysql_free_result($result);
	}
	if($type = (isset($_GET['type'])) ? $_GET['type'] : ''){
		$sql = 'SELECT cid,title,contents.text,contents.created,metas.name FROM contents,metas WHERE  contents.status=0 and contents.type=metas.mid and metas.name= "'. $type .'"
			ORDER BY created DESC';
		$result = mysql_query($sql, $db) or die(mysql_error($db));
		if (mysql_num_rows($result) == 0) {
			echo '<div class="text-info"><strong>No articles found that match the search terms.</strong></div>';
		} else {
			while ($row = mysql_fetch_array($result)) {
				echo ' <div class="contents"> ';
	            echo ' <h3><a href="blog.php?cid='.$row['cid'].'"> ' . $row['title'] . '</a></h3>';
	            echo '<small>type:<a href="search.php?type='.$row['name'].'">' . $row['name'] . '</a>&nbsp;&nbsp; created:' . $row['created'] .'</small>';
	            echo ' <p> ' . $row['text'] . '</p>' ;
	            echo '</div> ';
			}
		}
		mysql_free_result($result);
	}

	include 'sidebar.php';
	include 'foot.inc.php';
?>