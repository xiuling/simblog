 <div id="sidebar">
 	<h4>Category</h4>
 	<?php
 		$query = 'SELECT mid,name,count FROM metas WHERE type="category" ORDER BY mid desc';
 		$result = mysql_query($query, $db) or die (mysql_error($db));
       	while ($row = mysql_fetch_assoc($result)) {
				echo '<p><a href="search.php?type='.$row['name'].'">' . $row['name'] . '(' . $row['count'] . ')</a></p>';
		}
 	?>
 	<h4>Function</h4>
 	<p><a href="login.php">Log in</a></p>
 	<p><a href="logout.php">Log out</a></p>
 </div>