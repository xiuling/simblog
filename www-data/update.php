<?php
	$db = mysql_connect('localhost', 'testuser', '123456') or
		die ('Unable to connect. Check your connection parameters.');
	mysql_select_db('blog', $db) or die(mysql_error($db));
	include 'adminheader.inc.php';

	switch ($_GET['action']) {
		case 'changepass':
			$query = 'SELECT password FROM users WHERE name="'.$_SESSION['name'].'"';
			$result = mysql_query($query, $db) or die (mysql_error($db));
		    if (mysql_num_rows($result) > 0) {
		        while ($row = mysql_fetch_assoc($result)) {
		        	$password = $row['password'];
		        }
		    }

			$error = array();
			$oldPass = isset($_POST['oldPass']) ? trim($_POST['oldPass']) : '';
			if (empty($oldPass)) {
				$error[] = urlencode('Please enter the oldPass.');
			}
			if($oldPass!==$password){
				$error[] = urlencode('Old password is wrong.');
			}
			$newPass1 = isset($_POST['newPass1']) ? trim($_POST['newPass1']) : '';
			if (empty($newPass1)) {
				$error[] = urlencode('Please enter the newPass.');
			}
			$newPass2 = isset($_POST['newPass2']) ? trim($_POST['newPass2']) : '';
			if (empty($newPass2)) {
				$error[] = urlencode('Please enter the newPass again.');
			}
			if($newPass1!==$newPass2){
				$error[] = urlencode('The two new password are not the same.');
			}

			if(empty($error)){
				$query = 'UPDATE users SET password="'.$newPass2.'" WHERE name="'.$_SESSION['name'].'"';
				$result = mysql_query($query, $db) or die (mysql_error($db));
				if($result){
					echo 'Password has been changed.';
					header ('Refresh: 1; URL= change.php');
				}
			}else {
				header('Location:change.php?action=changepass'.' 
					&error='.join($error, urlencode('<br />')));
			}
			break;
		case 'changeimag':
			$dir ='../images';
			//make sure the uploaded file transfer was successful
			if ($_FILES['uploadfile']['error'] != UPLOAD_ERR_OK) {
				switch ($_FILES['uploadfile']['error']) {
					case UPLOAD_ERR_INI_SIZE:
						die('The uploaded file exceeds the upload_max_filesize directive ' .
					'in php.ini.');
					break;
					case UPLOAD_ERR_FORM_SIZE:
						die('The uploaded file exceeds the MAX_FILE_SIZE directive that ' .
					'was specified in the HTML form.');
					break;
					case UPLOAD_ERR_PARTIAL:
						die('The uploaded file was only partially uploaded.');
					break;
					case UPLOAD_ERR_NO_FILE:
						die('No file was uploaded.');
					break;
					case UPLOAD_ERR_NO_TMP_DIR:
						die('The server is missing a temporary folder.');
					break;
					case UPLOAD_ERR_CANT_WRITE:
						die('The server failed to write the uploaded file to disk.');
					break;
					case UPLOAD_ERR_EXTENSION:
						die('File upload stopped by extension.');
					break;
				}
			}
			list($width, $height, $type, $attr) = getimagesize($_FILES['uploadfile']['tmp_name']);
			// make sure the uploaded file is really a supported image
			switch ($type) {
				case IMAGETYPE_GIF:
					$image = imagecreatefromgif($_FILES['uploadfile']['tmp_name']) or
						die('The file you uploaded was not a supported filetype.');
					$ext = '.gif';
				break;
				case IMAGETYPE_JPEG:
					$image = imagecreatefromjpeg($_FILES['uploadfile']['tmp_name']) or
						die('The file you uploaded was not a supported filetype.');
					$ext = '.jpg';
				break;
				case IMAGETYPE_PNG:
					$image = imagecreatefrompng($_FILES['uploadfile']['tmp_name']) or
						die('The file you uploaded was not a supported filetype.');
					$ext = '.png';
				break;
				default:
					die('The file you uploaded was not a supported filetype.');
			}
			//insert information into image table
			$query = 'INSERT INTO contents(title, type) VALUES("' . $_POST['name'] . '", "personal")';
			$result = mysql_query($query, $db) or die (mysql_error($db));
			//retrieve the image_id that MySQL generated automatically when we inserted
			//the new record
			$last_id = mysql_insert_id();
			//because the id is unique, we can use it as the image name as well to make
			//sure we don’t overwrite another image that already exists
			$name = $last_id . $ext;
			// update the image table now that the final filename is known.
			$query = 'UPDATE users SET 
				imag = "' . $name . '" WHERE name =" ' . $_SESSION['name'].'"';
			$result = mysql_query($query, $db) or die (mysql_error($db));
			//save the image to its final destination
			switch ($type) {
				case IMAGETYPE_GIF:
					imagegif($image, $dir . '/' . $name);
				break;
				case IMAGETYPE_JPEG:
					imagejpeg($image, $dir . '/' . $name, 100);
				break;
				case IMAGETYPE_PNG:
					imagepng($image, $dir . '/' . $name);
				break;
			}
			imagedestroy($image);

			echo '<h4> Here is the picture: </h4>';
			echo '<img src="../images/<?php echo $name; ?> " style="float:left;margin-right:10px;">';
			echo '<p><a href="change.php">Go back</a></p>';
			break;
		case 'changeabout':
			$query = 'SELECT uid FROM users WHERE name="'.$_SESSION['name'].'"';
			$result = mysql_query($query, $db) or die (mysql_error($db));
			if (mysql_num_rows($result) > 0) {
		        while ($row = mysql_fetch_assoc($result)) {
		        	$uid = $row['uid'];
		       }
		    }
			$query = 'INSERT INTO contents(`text`,type,created,authorId) VALUES("'.$_POST['text'].'","about","'.@date('Y-m-d h:m:s').'","'.$uid.'")';
			$result = mysql_query($query, $db) or die (mysql_error($db));
			if($result){
					echo 'About Page has been changed.';
					header ('Refresh: 1; URL= about.php');
			}
			break;
	}

		include 'foot.inc.php';
?>