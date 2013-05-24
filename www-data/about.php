<?php
	include 'db.inc.php';
    $db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or die ('Unable to connect. Check your connection parameters.');
    mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

    include 'header.inc.php';
 ?>
			 <div class="contents"> 
			     <h3><a href="about.php"> About Us</a></h3>
			<?php
			    $query = 'SELECT cid,`text`,contents.created,contents.modified,commentsNum FROM contents WHERE type=0';
			    $result = mysql_query($query, $db) or die (mysql_error($db));
				if (mysql_num_rows($result) > 0) {					
			        while ($row = mysql_fetch_assoc($result)) {	
			        	if($row['modified']){		        	
			            	echo ' <p><span class="small"> created:&nbsp;' . $row['created'] . '&nbsp;&nbsp;modified:&nbsp;' . $row['modified'] . '&nbsp;&nbsp;comments:&nbsp;'. $row['commentsNum'] .'</span></p>';
			            }else{
			            	echo ' <p><span class="small"> created:&nbsp;' . $row['created'] . '&nbsp;&nbsp;comments:&nbsp;'. $row['commentsNum'] .'</span></p>';
			            }
			            echo ' <div> ' . $row['text'] . ' </div> ';
			            $cid=$row['cid'];
			       }
			    }else{
			    	echo '<p>There is nothing about author yet.</p>';
			    }			
		echo '</div>';
		echo ' <div class="comments"> ';
    	$query = 'SELECT coid, created, author, mail, `text` FROM comments WHERE type="about"';
	    $result = mysql_query($query,$db) or die(mysql_error($db));
	    if(mysql_num_rows($result) > 0){
	        echo '<h4>Commemts Here:</h4>'; 
	        while ($row = mysql_fetch_assoc($result)) {                      
	            echo '<hr /> <p><span class="small">author:&nbsp;' . $row['author'] .'&nbsp;&nbsp; mail:&nbsp;' . $row['mail'] . '&nbsp;&nbsp; created:&nbsp;' . $row['created'] . '</span></p>';
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
        <input type="hidden" name="type" value="about" />
        <input type="hidden" name="cid" value="<?php echo $cid; ?>" />
        <label for="author" class="label">Author:</label><input type="text" name="author" class="long" /><br />
        <label for="mail" class="label">Mail:</label><input type="text" name="mail" class="long" /><br />
        <label for="Commemts" class="label">Comments:</label><textarea name="text" class="mid"></textarea><br />
        <input type="submit" value="Post" />&nbsp;&nbsp;<input type="reset" value="Reset" />
    </form>
    </div>
</div>
<?php    
    include 'sidebar.php';
?>
<div id="foot" style="clear:both;"></div>
</body>
</html>