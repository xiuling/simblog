<?php
	include 'db.inc.php';
    $db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or die ('Unable to connect. Check your connection parameters.');
    mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

    include 'header.inc.php';
    $query = 'SELECT cid,title,contents.slug,metas.name,`text`,contents.created,commentsNum FROM contents,metas WHERE contents.type!=0 AND contents.type=metas.mid AND status=0 ORDER BY created DESC';
    $result = mysql_query($query, $db) or die (mysql_error($db));
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_assoc($result)) {
            echo ' <div> ';
            echo ' <h3><a href="blog.php?cid='.$row['cid'].'"> ' . $row['title'] . '</a></h3>';
            echo ' <small> type:' . $row['name'] . '&nbsp;&nbsp; created:' . $row['created'] . '&nbsp;&nbsp; comments:' . $row['commentsNum'] . '</small>';
            echo ' <div> ' . $row['text'] . ' </div> ';
            echo ' </div> ';
		}
	}
    include 'sidebar.php';
	include 'foot.inc.php';
?>

