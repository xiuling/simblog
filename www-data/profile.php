<?php
	session_start();
	if(isset($_SESSION['username'])){
	    include 'header.php';
	    include 'db.inc.php';
	    $db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or die ('Unable to connect. Check your connection parameters.');
	    mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

	    if (isset($_GET['error']) && $_GET['error'] != '') {
			echo ' <div id="error"> ' . $_GET['error'] . ' </div> ';
		}
?>
<div class="row">
	<h3>OPTIONS</h3>
	<div class="col-lg-8 option" >	
		<div class="changePass">
			<h4>Change Password</h4>
			<form class="form-horizontal" role="form"  action="update.php?action=changepass" method="post">
		        <div class="form-group">
		            <label for="oldPass" class="col-lg-2 control-label">Old Password</label>
		            <div class="col-lg-6">
		                <input type="password" class="form-control" id="oldPass" placeholder="oldPass" name="oldPass">
		            </div>
		        </div>
		        <div class="form-group">
		            <label for="newPass1" class="col-lg-2 control-label">New Password</label>
		            <div class="col-lg-6">
		                <input type="password" class="form-control" id="newPass1" placeholder="NewPass" name="newPass1">
		            </div>
		        </div>
		        <div class="form-group">
		            <label for="newPass2" class="col-lg-2 control-label">New Password Again</label>
		            <div class="col-lg-6">
		                <input type="password" class="form-control" id="newPass2" placeholder="NewPassAgain" name="newPass2">
		            </div>
		        </div>
		        <div class="form-group">
		            <div class="col-lg-offset-2 col-lg-6">
		                <button type="submit" class="btn btn-default">Update</button>
		                <button type="reset" class="btn btn-default">Reset</button>
		            </div>
		        </div>
		    </form>    
		</div>
	</div>
	<!-- <div class="col-lg-8 option">
		<div class="changeImag">
			<h4>Change Image</h4>
			<form  class="form-horizontal" role="form" action="update.php?action=changeimag" method="post"  enctype="multipart/form-data">
				<input type="hidden" name="name" value="image" /> 
				<div class="form-group">
		            <label for="uploadfile" class="col-lg-2 control-label">Upload Image</label>
		            <div class="col-lg-6">
		                <input type="file"  id="uploadfile" placeholder="uploadfile" name="uploadfile">
		                <p class="help-block">* Acceptable image formats include: GIF, JPG/JPEG and PNG.
					</p>
		            </div>
		        </div>
				<div class="form-group">
		            <div class="col-lg-offset-2 col-lg-10">
		                <button type="submit" class="btn btn-default">Upload</button>
		            </div>
		        </div>
			</form>
		</div>
	</div> -->
	<div class="col-lg-8 option">
		<div class="about">
			<h4>Change About</h4>
		<?php
			$query = 'SELECT `text`,cid FROM contents WHERE type=0';
			$result = mysql_query($query, $db) or die (mysql_error($db));	
			if($row = mysql_fetch_assoc($result)){
				echo '<form  class="form-horizontal" role="form" action="update.php?action=changeabout&cid='.$row['cid'].'" method="post"> ';
				echo '<div class="form-group">';
				echo '<label for="text" class="col-lg-2 control-label">Update About</label>';
				echo '<div class="col-lg-6"><textarea name="text" class="form-control" id="uploadfile" placeholder="about" rows="6">'. $row['text'] .'</textarea></div>';
				echo '</div>';
			}
			else{
				echo '<form class="form-horizontal" role="form" action="update.php?action=changeabout" method="post">';
				echo '<div class="form-group">';
				echo '<label for="text" class="col-lg-2 control-label">Update About</label>';
				echo '<div class="col-lg-6"><textarea name="text" class="mid" class="form-control" id="uploadfile" placeholder="about" rows="6"></textarea>';
				echo '<br />';
			}
		?>
				<div class="form-group">
		            <div class="col-lg-offset-2 col-lg-6">
		                <button type="submit" class="btn btn-default">Update</button>
		                <button type="reset" class="btn btn-default">Reset</button>
		            </div>
		        </div>
			</form>
		</div>
	</div>
	<div class="col-lg-8 option">
	<?php
		if ($_SESSION['authCode'] ==2){
	?>
		<div class="adduser">
			<h4>Add User</h4>
			<form class="form-horizontal" role="form"  action="update.php?action=adduser" method="post">
		        <div class="form-group">
		            <label for="username" class="col-lg-2 control-label">Username</label>
		            <div class="col-lg-6">
		                <input type="text" class="form-control" id="username" placeholder="username" name="username">
		            </div>
		        </div>
		        <div class="form-group">
		            <label for="password" class="col-lg-2 control-label">Password</label>
		            <div class="col-lg-6">
		                <input type="password" class="form-control" id="password" placeholder="password" name="password">
		            </div>
		        </div>
		        <div class="form-group">
		            <label for="authCode" class="col-lg-2 control-label">Role</label>
		            <div class="col-lg-6">
		                <select name="authCode">
							<option value="2">Administrator</option>
							<option value="1">Editor</option>
						</select>
		            </div>
		        </div>
		        <div class="form-group">
		            <div class="col-lg-offset-2 col-lg-6">
		                <button type="submit" class="btn btn-default">Add User</button>
		                <button type="reset" class="btn btn-default">Reset</button>
		            </div>
		        </div>
		    </form>    
		</div>
	</div>

<?php
		}
	//include 'adminfoot.inc.php';
	}else{
    	header ('Refresh: 1; URL= login.php');
		echo ' <p> You have not logged in. You will be redirected to login page. </p> ';
            echo ' <p> If your browser doesn\'t redirect you properly ' . 
                'automatically, <a href="login.php" >click here </a> . </p> ';
    }
?>

	</div>
<?php
	include 'foot.inc.php';
?>