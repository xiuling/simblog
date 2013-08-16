 </div>
 <div class="col-lg-2 mainright">
 	<h4>Category</h4>
 	<div id="cate">
 	<?php
 		$query = 'SELECT mid,name,count FROM metas WHERE type="category" ORDER BY mid desc';
 		$result = mysql_query($query, $db) or die (mysql_error($db));
       	while ($row = mysql_fetch_assoc($result)) {
				echo '<p><a href="search.php?type='.$row['name'].'">' . $row['name'] . '(' . $row['count'] . ')</a></p>';
		}
 	?>
 	</div>
 </div>