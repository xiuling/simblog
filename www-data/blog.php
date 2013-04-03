<?php
    include 'db.inc.php';
    $db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or die ('Unable to connect. Check your connection parameters.');
    mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

    include 'header.inc.php';

    $query = 'SELECT cid,title,slug,type,`text`,created FROM contents WHERE cid="'.$_GET['cid'].'"';
    $result = mysql_query($query, $db) or die (mysql_error($db));
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_assoc($result)) {
            echo ' <div class="contents"> ';
            echo ' <h3><a href="blog.php?cid='.$row['cid'].'"> ' . $row['title'] . '</a></h3>';
            echo ' <p> type:&nbsp;' . $row['type'] . '&nbsp;&nbsp; created:&nbsp;' . $row['created'];
            echo ' <div> ' . $row['text'] . ' </div> ';
            echo '</div> ';
		}
	}
    echo ' <div class="comments"> ';
    $query = 'SELECT coid, created, author, mail, `text` FROM comments WHERE cid="'.$_GET['cid'].'"';
    $result = mysql_query($query,$db) or die(mysql_error($db));
    if(mysql_num_rows($result) > 0){
        echo '<h3>Commemts Here:</h3>'; 
        while ($row = mysql_fetch_assoc($result)) {                      
            echo '<hr /> <p>author:&nbsp;' . $row['author'] .'&nbsp;&nbsp; mail:&nbsp;' . $row['mail'] . '&nbsp;&nbsp; created:&nbsp;' . $row['created'];
            echo ' <div> ' . $row['text'] . ' </div> ';
        }
    }else{        
        echo '<p>There is no comments yet.</p>';
        echo '<p>You can give a conmments.</p>';
    }
    echo '</div>';

    if (isset($_GET['error']) && $_GET['error'] != '') {
        echo ' <div id="error"> ' . $_GET['error'] . ' </div> ';
    }
?>
    <h3>Add a comment</h3>
    <div class="postcomment">
    <form action="postcomment.php" method="post">
        <input type="hidden" name="cid" value="<?php echo $_GET['cid']; ?>" />
        <input type="hidden" name="type" value="" />
        <label for="author" class="label">Author:</label><input type="text" name="author" class="long" /><br />
        <label for="mail" class="label">Mail:</label><input type="text" name="mail" class="long" /><br />
        <label for="Commemts" class="label">Comments:</label><textarea name="text" class="mid"></textarea><br />
        <input type="submit" value="Post" />&nbsp;&nbsp;<input type="reset" value="Reset" />
    </form>
    </div>

<?php
    echo '</div>';
    include 'sidebar.php';
	include 'foot.inc.php';
?>