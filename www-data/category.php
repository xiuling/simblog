<?php
    // include 'adminheader.inc.php';
session_start();
include 'header.php';
if(isset($_SESSION['username'])){

	include 'db.inc.php';
    $db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or die ('Unable to connect. Check your connection parameters.');
    mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

	if ($_GET['action'] == 'edit') {
		$query = 'SELECT name FROM metas
			WHERE mid = "' . $_GET['mid']. '"';
		$result = mysql_query($query, $db) or die(mysql_error($db));
		extract(mysql_fetch_assoc($result));
	} else {
		//set values to blank
		$name = isset($_GET['name'])?$_GET['name']:'';
	}

	if (isset($_GET['error']) && $_GET['error'] != '') {
		echo ' <div id="error"> ' . $_GET['error'] . ' </div> ';
	}
?>
	<h2><?php echo ucfirst($_GET['action']); ?> Category</h2>
    <?php
    $query = 'SELECT name FROM metas WHERE type="category" ORDER BY mid DESC';
    $result = mysql_query($query,$db) or die(mysql_error($db));
    if(mysql_num_rows($result) > 0){
         echo '<div>';
        while ($row = mysql_fetch_assoc($result)) {
            echo $row['name'].'&nbsp;&nbsp;';
        }
        echo '</div>';
    }
           
    ?>
    <form class="form-horizontal" role="form"  action="commit.php?action=<?php echo $_GET['action']; ?>" method="post">
        <div class="form-group">
            <label for="name" class="col-lg-2 control-label">Name</label>
            <div class="col-lg-4">
                <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="<?php echo $name; ?>" />
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
                <button type="submit" class="btn btn-default">Add</button>
                <button type="reset" class="btn btn-default">Reset</button>
            </div>
        </div>
	</form>
<?php
    // include 'adminfoot.inc.php';
    }else{
        header ('Refresh: 1; URL= login.php');
        echo ' <p> You have not logged in. You will be redirected to login page. </p> ';
            echo ' <p> If your browser doesn\'t redirect you properly ' . 
                'automatically, <a href="login.php" >click here </a> . </p> ';
    }

    include 'foot.inc.php';
?>
