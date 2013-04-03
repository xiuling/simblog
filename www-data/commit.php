<?php
	$db = mysql_connect('localhost', 'testuser', '123456') or
		die ('Unable to connect. Check your connection parameters.');
	mysql_select_db('blog', $db) or die(mysql_error($db));

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
				contents(title, `type`, `text`, slug, created)
				VALUES("' . $_POST['title'] . '",
						"' . $_POST['type'] . '",
						"' . $_POST['text'] . '",
						"' . $_POST['slug'] . '",
						"' . @date('Y-m-d h:m:s') . '")';
			} else {
				header('Location:contents.php?action=add'.' 
					&error='.join($error, urlencode('<br />')));
			}
		break;
		case 'edit':
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
				$error[] = urlencode('Please enter the text.');
			}
			$slug = isset($_POST['slug']) ? trim($_POST['slug']) : '';
			if (empty($slug)) {
				$error[] = urlencode('Please enter the slug.');
			}
			if (empty($error)) {
				$query = 'UPDATE contents SET
					title = "' . $_POST['title'] . '",
					`type` = "' . $_POST['type'] . '",
					`text` = "' . $_POST['text'] . '",
					slug = "' . $_POST['slug'] . '",
					modified = "' . @date('Y-m-d h:m:s') . '"
					WHERE cid = ' . $_POST['cid'];
			} else {
				header('Location:contents.php?action=edit&cid=' . $_POST['cid'] .
					'&error=' . join($error, urlencode('<br />')));
			}
		break;
	}
	if (isset($query)) {
		$result = mysql_query($query, $db) or die(mysql_error($db));
	}
?>
<html>
<head>
<title> Commit </title>
</head>
<body>
<p> Done!</p>
<?php
	header ('Refresh: 2; URL= admin.php');
	echo ' <p> You will be redirected to your original page request. </p> ';
            echo ' <p> If your browser doesn\'t redirect you properly ' . 
                'automatically, <a href="admin.php" >click here </a> . </p> ';
?>
</body>
</html>