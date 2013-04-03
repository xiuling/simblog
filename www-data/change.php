<?php
    include 'db.inc.php';
    $db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or die ('Unable to connect. Check your connection parameters.');
    mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

    include 'adminheader.inc.php';

    if (isset($_GET['error']) && $_GET['error'] != '') {
		echo ' <div id="error"> ' . $_GET['error'] . ' </div> ';
	}
?>

	<h4>OPTIONS</h4>
	<div class="changePass">
		<h5>Change Password</h5>
		<form action="update.php?action=changepass" method="post">
			<label for="oldPass" class="label">Old Password:</label><input type="password" name="oldPass" class="long"/><br />
			<label for="newPass1" class="label">New Password:</label><input type="password" name="newPass1" class="long" /><br />
			<label for="newPas2s" class="label">New Again:</label><input type="password" name="newPass2" class="long" /><br />
			<input type="submit" value="Change" /><input type="reset" value="Reset" />
		</form>
	</div>
	<div class="changeImag">
		<h5>Change Image</h5>
		<form action="update.php?action=changeimag" method="post"  enctype="multipart/form-data">
			<input type="hidden" name="name" value="image" /> 
			<label for="uploadfile">Upload Image</label><input type="file" name="uploadfile" />
			<small> <em> * Acceptable image formats include: GIF, JPG/JPEG and PNG.
				</em> </small><br />
			<input type="submit" value="Upload" />
		</form>
	</div>
	<div class="about">
		<h5>Change About</h5>
		<form action="update.php?action=changeabout" method="post"> 
			<label for="text" class="label">Update About</label><textarea name="text" class="mid"></textarea>
			<br />
			<input type="submit" value="Update" /><input type="reset" value="Reset" />
		</form>
	</div>


<?php
	include 'foot.inc.php';
?>