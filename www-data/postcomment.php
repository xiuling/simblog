<?php
	require 'db.inc.php';
	$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or die ('Unable to connect. Check your connection parameters.');
	mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

	include 'header.inc.php';

	$author = (isset($_POST['author'])) ? trim($_POST['author']) : '';
	$mail = (isset($_POST['mail'])) ? trim($_POST['mail']) : '';
	$text = (isset($_POST['text'])) ? $_POST['text'] : '';
	$cid = (isset($_POST['cid'])) ? $_POST['cid'] : '';
	$type = (isset($_POST['type'])) ? $_POST['type'] : '';

	$error = array();
	$title = isset($author) ? trim($author) : '';
	if (empty($author)) {
		$error[] = urlencode('Please enter your name.');
	}
	$mail = isset($mail) ? trim($mail) : '';
	if (empty($mail)) {
		$error[] = urlencode('Please enter your mail.');
	}
	$text = isset($_POST['text']) ? trim($_POST['text']) : '';
	if (empty($text)) {
		$error[] = urlencode('Please enter the content.');
	}

	if (empty($error)) {
		if($type=='about'){
	    	$query = 'INSERT INTO comments(cid,author,mail,`text`,created,type) VALUES ("'.$cid.'","'.$author.'","'.$mail.'","'.$text.'","' . @date('Y-m-d h:m:s') . '","about")';
			$result = mysql_query($query, $db) or die(mysql_error($db));
			if($result){
				$query2 = 'UPDATE contents set commentsNum=commentsNum+1 WHERE cid="' . $cid .'"';
				$result2 = mysql_query($query2, $db) or die(mysql_error($db));
			}
			if($result2){
			echo '<p> Done!</p>';
			//header ('Refresh: 1; URL= about.php');
			echo ' <p> You will be redirected to your original page request. </p> ';
		            echo ' <p> If your browser doesn\'t redirect you properly ' . 
		                'automatically, <a href="about.php" >click here </a> . </p> ';
	    	}
		}
		if($type==''){
			$query = 'INSERT INTO comments(cid,author,mail,`text`,created) VALUES ("'.$cid.'","'.$author.'","'.$mail.'","'.$text.'","' . @date('Y-m-d h:m:s') . '")';
			$result = mysql_query($query, $db) or die(mysql_error($db));
			if($result){
				$query2 = 'UPDATE contents set commentsNum=commentsNum+1 WHERE cid="' . $cid .'"';
				$result2 = mysql_query($query2, $db) or die(mysql_error($db));
			}
			if($result2){
				echo '<p> Done!</p>';
				header ('Refresh: 1; URL= blog.php?cid='.$cid);
				echo ' <p> You will be redirected to your original page request. </p> ';
			            echo ' <p> If your browser doesn\'t redirect you properly ' . 
			                'automatically, <a href="blog.php?cid='.$cid.'" >click here </a> . </p> ';
	    	}
	    }
	    
    }else{
    	header('Location: blog.php?cid='.$cid.' 
					&error='.join($error, urlencode('<br />')));
    }
?>