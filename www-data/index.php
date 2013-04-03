<?php
	include 'db.inc.php';
    $db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or die ('Unable to connect. Check your connection parameters.');
    mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

    include 'header.inc.php';
    $query = 'SELECT cid,title,slug,type,`text`,created FROM contents WHERE type!="personal" and type!="about" ORDER BY created ';
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
    include 'sidebar.php';
	include 'foot.inc.php';
?>
