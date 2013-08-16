<?php   
	//include 'adminheader.inc.php';
session_start();
include 'header.php';	
if($_SESSION['username']){

	include 'db.inc.php';
    $db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or die ('Unable to connect. Check your connection parameters.');
    mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));
   
	if (!isset($_GET['do']) || $_GET['do'] != 1) {
		echo '<h4>Are you sure you want to delete this blog?</h4> <br/> ';
		echo ' <a href="' . $_SERVER['REQUEST_URI'] . ' & do=1"> yes </a> ';
		echo 'or <a href="admin.php"> no </a> <hr />';

		$query = 'SELECT cid,title,slug,type,`text`,created, status FROM contents WHERE cid="'.$_GET['cid'].'" ORDER BY created ';
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
	   
	} else {
		$query = 'SELECT type, status FROM contents WHERE cid="'.$_GET['cid'].'" ORDER BY created ';
	    $result = mysql_query($query, $db) or die (mysql_error($db));
	    if (mysql_num_rows($result) > 0) {
	        while ($row = mysql_fetch_assoc($result)) {
	        	$type = $row['type'];
	            $status = $row['status'];
	        }
	    }
		
		$query = 'DELETE FROM contents WHERE cid = "' . $_GET['cid'].'"';
		$result = mysql_query($query, $db) or die(mysql_error($db));
		if($result){
			if($status == 0){
				$query2 = 'UPDATE metas SET count = count-1 WHERE mid = "' . $type . '"';
				$result2 = mysql_query($query2, $db) or die(mysql_error($db));					
			}
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

<?php   
	//adminfoot.inc.php
	}else{
    	header ('Refresh: 1; URL= login.php');
		echo ' <p> You have not logged in. You will be redirected to login page. </p> ';
            echo ' <p> If your browser doesn\'t redirect you properly ' . 
                'automatically, <a href="login.php" >click here </a> . </p> ';
    }

    include 'foot.inc.php';
?>

	