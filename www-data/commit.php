<?php
	session_start();
	include 'db.inc.php';
    $db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or die ('Unable to connect. Check your connection parameters.');
    mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

	switch ($_GET['action']) {
		case 'add':
			$error = array();
			$title = isset($_POST['title']) ? trim($_POST['title']) : '';
			if (empty($title)) {
				$error[] = urlencode('Please enter the title.');
			}
			$type = isset($_POST['type']) ? trim($_POST['type']) : '';
			if (empty($type)) {
				$error[] = urlencode('Please select a type.');
			}
			$text = isset($_POST['text']) ? trim($_POST['text']) : '';
			if (empty($text)) {
				$error[] = urlencode('Please enter the content.');
			}
			$slug = isset($_POST['slug']) ? trim($_POST['slug']) : '';
			if (empty($slug)) {
				$error[] = urlencode('Please enter the slug.');
			}
			if (empty($error)) {
				$query = 'INSERT INTO
				contents(title, `type`, `text`, slug, created, status, authorId)
				VALUES("' . $title . '",
						"' . $type . '",
						"' . $text . '",
						"' . $slug . '",
						"' . @date('Y-m-d h:m:s') . '", "0",
						"' . $_SESSION['uid'] . '")';
				$query2 = 'UPDATE metas SET count = count+1 WHERE mid = "' . $type. '"';
			} else {
				header('Location:contents.php?action=add&title='.$title.'&type='.$type.'&text='.$text.'&slug='.$slug.' 
					&error='.join($error, urlencode('<br />')));
			}
		break;
		case 'edit':
			$error = array();
			$title = isset($_POST['title']) ? trim($_POST['title']) : '';
			if (empty($title)) {
				$error[] = urlencode('Please enter the title.');
			}
			$type1 = isset($_POST['type']) ? trim($_POST['type']) : '';
			if (empty($type1)) {
				$error[] = urlencode('Please select a type.');
			}
			$text = isset($_POST['text']) ? trim($_POST['text']) : '';
			if (empty($text)) {
				$error[] = urlencode('Please enter the text.');
			}
			$slug = isset($_POST['slug']) ? trim($_POST['slug']) : '';
			if (empty($slug)) {
				$error[] = urlencode('Please enter the slug.');
			}
			if (empty($error)) {
				//old type's count deincrease
				$query3 = 'SELECT type,status FROM contents WHERE cid ="' . $_POST['cid'] . '"';
				$result3 = mysql_query($query3, $db) or die(mysql_error($db));
				if($row = mysql_fetch_assoc($result3)){
					if($row['status'] == 0 && $row['type'] != $type1){
						$query4 = 'UPDATE metas SET count = count-1 WHERE mid = "' . $row['type']. '"';
						$result4 = mysql_query($query4, $db) or die(mysql_error($db));
					}
				}
				//update
				$query = 'UPDATE contents SET
					title = "' . $title . '",
					`type` = "' . $type1 . '",
					`text` = "' . $text . '",
					slug = "' . $slug . '",
					modified = "' . @date('Y-m-d h:m:s') . '",
					status = "0"
					WHERE cid = ' . $_POST['cid'];
					//new type's count increase
				$query2 = 'UPDATE metas SET count = count+1 WHERE mid = "' . $type1. '"';
			} else {
				header('Location:contents.php?action=edit&cid=' . $_POST['cid'] .
					'&error=' . join($error, urlencode('<br />')));
			}
		break;
		case 'saveDraft':
			$title = isset($_POST['title']) ? trim($_POST['title']) : '';
			if (empty($title)) {
				$error[] = urlencode('Please enter the title.');
			}
			$type1 = isset($_POST['type']) ? trim($_POST['type']) : '';
			$text = isset($_POST['text']) ? trim($_POST['text']) : '';
			$slug = isset($_POST['slug']) ? trim($_POST['slug']) : '';

			if($_POST['cid']){
				if(empty($error)){
					//old type's count deincrease
					$query3 = 'SELECT type,status FROM contents WHERE cid ="' . $_POST['cid'] . '"';
					$result3 = mysql_query($query3, $db) or die(mysql_error($db));
					if($row = mysql_fetch_assoc($result3)){
						$query4 = 'UPDATE metas SET count = count-1 WHERE mid = "' . $row['type']. '"';
						$result4 = mysql_query($query4, $db) or die(mysql_error($db));
					}
					//update
					$query = 'UPDATE contents SET
						title = "' . $title . '",
						`type` = "' . $type1 . '",
						`text` = "' . $text . '",
						slug = "' . $slug . '",
						modified = "' . @date('Y-m-d h:m:s') . '",
						status = "1"
						WHERE cid = ' . $_POST['cid'];
				}else{
					header('Location:contents.php?action=edit&cid=' . $_POST['cid'] .
							'&error=' . join($error, urlencode('<br />')));
				}
			}else{
				if(empty($error)){
					$query = 'INSERT INTO
						contents(title, `type`, `text`, slug, created, status, authorId)
							VALUES("' . $title . '",
						    	"' . $type1 . '",
								"' . $text . '",
								"' . $slug . '",
								"' . @date('Y-m-d h:m:s') . '", "1", "' . $_SESSION['uid'] .'")';
				}else{
					header('Location:contents.php?action=add&title='.$title.'&type='.$type1.'&text='.$text.'&slug='.$slug.' 
							&error='.join($error, urlencode('<br />')));
				}
			}
		break;
		case 'insert':
			$error = array();
			$name = isset($_POST['name']) ? trim($_POST['name']) : '';
			$slug = isset($_POST['slug']) ? trim($_POST['slug']) : '';
			$description = isset($_POST['description']) ? trim($_POST['description']) : '';
			if (empty($name)) {
				$error[] = urlencode('Please enter the category name.');
			}
			if(empty($error)){
				$query = 'INSERT INTO metas(name,slug,type,description) VALUES ("'.$name.'","'.$slug.'","category","'.$description.'")';
			}else {
				header('Location:category.php?action=insert&name='.$name.'&slug='.$slug.'&description='.$description.'&error=' . join($error, urlencode('<br />')));
			}
	}
	if (isset($query)) {
		$result = mysql_query($query, $db) or die(mysql_error($db));
	}
	if(isset($query2)) {
		$result2 = mysql_query($query2, $db) or die(mysql_error($db));
	}
?>
<html>
<head>
<title> Commit </title>
</head>
<body>
<p> Done!</p>
<?php
	header ('Refresh: 1; URL= admin.php');
	echo ' <p> You will be redirected to your original page request. </p> ';
            echo ' <p> If your browser doesn\'t redirect you properly ' . 
                'automatically, <a href="admin.php" >click here </a> . </p> ';
?>
</body>
</html>