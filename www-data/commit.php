<?php
	session_start();
	include 'header.php';
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
			if (empty($error)) {
				$query = 'INSERT INTO
				contents(title, `type`, `text`, created, status, authorId)
				VALUES("' . $title . '",
						"' . $type . '",
						"' . $text . '",
						"' . @date('Y-m-d h:m:s') . '", "0",
						"' . $_SESSION['uid'] . '")';
				$query2 = 'UPDATE metas SET count = count+1 WHERE mid = "' . $type. '"';
			} else {
				header('Location:contents.php?action=add&title='.$title.'&type='.$type.'&text='.$text.' 
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
			if (empty($error)) {
				//old type's count deincrease
				$query3 = 'SELECT type,status FROM contents WHERE cid ="' . $_POST['cid'] . '"';
				$result3 = mysql_query($query3, $db) or die(mysql_error($db));
				if($row = mysql_fetch_assoc($result3)){
					if($row['status'] == 0 && $row['type'] != $type1){
						$query4 = 'UPDATE metas SET count = count-1 WHERE mid = "' . $row['type']. '"';
						$result4 = mysql_query($query4, $db) or die(mysql_error($db));

						$query = 'UPDATE contents SET
							title = "' . $title . '",
							`type` = "' . $type1 . '",
							`text` = "' . $text . '",
							modified = "' . @date('Y-m-d h:m:s') . '",
							status = "0"
							WHERE cid = ' . $_POST['cid'];
							//new type's count increase
						$query2 = 'UPDATE metas SET count = count+1 WHERE mid = "' . $type1. '"';
					}
				} else{

					$query = 'UPDATE contents SET
						title = "' . $title . '",
						`text` = "' . $text . '",
						modified = "' . @date('Y-m-d h:m:s') . '",
						status = "0"
						WHERE cid = ' . $_POST['cid'];					
				}
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
						contents(title, `type`, `text`, created, status, authorId)
							VALUES("' . $title . '",
						    	"' . $type1 . '",
								"' . $text . '",
								"' . @date('Y-m-d h:m:s') . '", "1", "' . $_SESSION['uid'] .'")';
				}else{
					header('Location:contents.php?action=add&title='.$title.'&type='.$type1.'&text='.$text.'
							&error='.join($error, urlencode('<br />')));
				}
			}
		break;
		case 'insert':
			$error = array();
			$name = isset($_POST['name']) ? trim($_POST['name']) : '';
			if (empty($name)) {
				$error[] = urlencode('Please enter the category name.');
			}
			if(empty($error)){
				$query = 'INSERT INTO metas(name,type) VALUES ("'.$name.'","category",)';
			}else {
				header('Location:category.php?action=insert&name='.$name.'&error=' . join($error, urlencode('<br />')));
			}
	}
	if (isset($query)) {
		$result = mysql_query($query, $db) or die(mysql_error($db));
	}
	if(isset($query2)) {
		$result2 = mysql_query($query2, $db) or die(mysql_error($db));
	}
?>

<p> Done!</p>
<?php
	header ('Refresh: 1; URL= admin.php');
	echo ' <p> You will be redirected to your original page request. </p> ';
            echo ' <p> If your browser doesn\'t redirect you properly ' . 
                'automatically, <a href="admin.php" >click here </a> . </p> ';

    include 'foot.inc.php';
?>
