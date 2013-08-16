<?php
	//include 'adminheader.inc.php';
session_start();
if($_SESSION['username']){

    include 'header.php';
	include 'db.inc.php';
    $db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or die ('Unable to connect. Check your connection parameters.');
    mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

	if ($_GET['action'] == 'edit') {
	//retrieve the record’s information
		$query = 'SELECT title, `type`, `text` FROM contents
			WHERE cid = "' . $_GET['cid']. '"';
		$result = mysql_query($query, $db) or die(mysql_error($db));
		extract(mysql_fetch_assoc($result));
	} else {
		//set values to blank
		$title = isset($_GET['title'])?$_GET['title']:'';
		$type = isset($_GET['type'])?$_GET['type']:'';
		$text = isset($_GET['text'])?$_GET['text']:'';
		//$slug = isset($_GET['slug'])?$_GET['slug']:'';
	}

	if (isset($_GET['error']) && $_GET['error'] != '') {
		echo ' <div id="error"> ' . $_GET['error'] . ' </div> ';
	}
?>
<div class="col-lg-10">
	<h2><?php echo ucfirst($_GET['action']); ?> New Blog </h2>
	<h4><a class="col-lg-2" href="category.php?action=insert">Add Type</a>&nbsp;&nbsp;&nbsp;&nbsp;<!-- <a class="col-lg-2" href="category.php?action=insert">Add Label</a> --></h4>
	<form class="form-horizontal" role="form" id="form1" action="commit.php?action=<?php echo $_GET['action']; ?>" method="post">
            <div class="form-group">
                <label for="title" class="col-lg-2 control-label">Title</label>
                <div class="col-lg-8">
                <input type="text" class="form-control" id="title" placeholder="Title" name="title" value="<?php echo $title;?>">
                </div>
            </div>
            <div class="form-group">
                <label for="mail" class="col-lg-2 control-label">Type</label>
                <div class="col-lg-8">
                	<select name="type" id="type">
				<?php
					// select the movie type information
					$query = 'SELECT mid,name FROM metas WHERE type="category"
						ORDER BY mid desc';
					$result = mysql_query($query, $db) or die(mysql_error($db));
					// populate the select options with the results
					while ($row = mysql_fetch_assoc($result)) {
							if ($row['mid'] == $type) {
								echo ' <option value="' . $row['mid'] .
								'" selected="selected"> ';
							} else {
								echo ' <option value="' . $row['mid'] . '" > ';				
							}
							echo $row['name'] . ' </option> ';
					}
				?>
					</select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="text" class="col-lg-2 control-label">Content</label>
                <div class="col-lg-8">
                    <textarea class="form-control" id="text" placeholder="text" rows="16" name="text"><?php echo $text;?></textarea>
                </div>
            </div>
            <?php
				if ($_GET['action'] == 'edit') {
					echo '<input type="hidden" value="' . $_GET['cid'] . '" name="cid" />';
				}
			?>
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-8">
                    <button type="submit" class="btn btn-default" name="submit"><?php echo ucfirst($_GET['action']); ?></button>
                    <!-- <button type="button" class="btn btn-default" id="saveDraft">Save Draft</button> -->
                    <button type="reset" class="btn btn-default">Reset</button>
                </div>
            </div>
            <input type="hidden" name="cid" value="<?php echo $_GET['cid']; ?>" />
        </form>    

	<script type="text/javascript">
		jQuery(window).load(function(){
		});

		jQuery(function(){ 
			jQuery('#saveDraft').click(function(){
				jQuery.ajax({
					type:'POST',
					url:'commit.php?action=saveDraft',
					dataType:'json',
					data:jQuery("#form1").serialize(),
					success: function(data){
					}
				});
			});
		});
	</script>	

<?php
	//include 'adminfoot.inc.php';
	}else{
    	header ('Refresh: 1; URL= login.php');
		echo ' <p> You have not logged in. You will be redirected to login page. </p> ';
            echo ' <p> If your browser doesn\'t redirect you properly ' . 
                'automatically, <a href="login.php" >click here </a> . </p> ';
    }
?>

	</div>
	<div id="foot" style="clear:both;">
	</div>
</body>
</html>
