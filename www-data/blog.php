<?php
    include 'db.inc.php';
    $db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or die ('Unable to connect. Check your connection parameters.');
    mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

    include 'header.inc.php';

    $query = 'SELECT cid,title,contents.slug,metas.name,`text`,contents.created FROM contents,metas WHERE contents.type=metas.mid AND cid="'.$_GET['cid'].'"';
    $result = mysql_query($query, $db) or die (mysql_error($db));
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_assoc($result)) {
            echo ' <div class="contents"> ';
            echo ' <h3><a href="blog.php?cid='.$row['cid'].'"> ' . $row['title'] . '</a></h3>';
            echo ' <small> type:&nbsp;' . $row['name'] . '&nbsp;&nbsp; created:&nbsp;' . $row['created'] .'</small>';
            echo ' <div> ' . $row['text'] . ' </div> ';
            echo '</div> ';
		}
	}
    echo ' <div class="comments"> <hr />';
    $query = 'SELECT coid, created, author, mail, `text` FROM comments WHERE cid="'.$_GET['cid'].'"';
    $result = mysql_query($query,$db) or die(mysql_error($db));
    if(mysql_num_rows($result) > 0){
        echo '<h4>Commemts Here:</h4>'; 
        while ($row = mysql_fetch_assoc($result)) {                      
            echo ' <small>author:&nbsp;' . $row['author'] .'&nbsp;&nbsp; mail:&nbsp;' . $row['mail'] . '&nbsp;&nbsp; created:&nbsp;' . $row['created'] .'</small>';
            echo ' <div> ' . $row['text'] . ' </div> ';
        }
    }else{ 
        echo '<div class="col-lg-4" style="border: 1px dotted gray;">';       
        echo '<small>There is no comments yet.</small><br />';
        echo '<small>You can give a conmments.</small>';
        echo '</div>';
    }
    echo '</div>';

    if (isset($_GET['error']) && $_GET['error'] != '') {
        echo ' <div id="error"> ' . $_GET['error'] . ' </div> ';
    }
?>
    <br /><br /><br />
    <div class="postcomment">        
        <form class="form-horizontal" role="form"  action="postcomment.php" method="post">
            <div class="form-group">
                <label for="author" class="col-lg-2 control-label">Name</label>
                <div class="col-lg-4">
                <input type="text" class="form-control" id="author" placeholder="Name" name="author">
                </div>
            </div>
            <div class="form-group">
                <label for="mail" class="col-lg-2 control-label">Email</label>
                <div class="col-lg-4">
                    <input type="text" class="form-control" id="mail" placeholder="Email" name="mail">
                </div>
            </div>
            <div class="form-group">
                <label for="comments" class="col-lg-2 control-label">Comments</label>
                <div class="col-lg-4">
                    <textarea class="form-control" id="comments" placeholder="Comments" rows="6" name="text"></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <button type="submit" class="btn btn-default">Post</button>
                </div>
            </div>
            <input type="hidden" name="cid" value="<?php echo $_GET['cid']; ?>" />
        </form>    
    </div>

<?php

    include 'sidebar.php';
	include 'foot.inc.php';
?>