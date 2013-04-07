<?php
	include 'db.inc.php';
    $db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or die ('Unable to connect. Check your connection parameters.');
    mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));
    include 'adminheader.inc.php';
?>
    <h3> Blogs <a href="contents.php?action=add"> [ADD] </a></h3>
    
	<?php
        // determine sorting order of table
        $order = array(1 => 'title ASC', 2 => 'slug ASC', 3 => 'name ASC');
        $o = (isset($_GET['o']) && ctype_digit($_GET['o'])) ? $_GET['o'] : 1;
        if (!in_array($o, array_keys($order))) {
            $o = 1;
        }
        // select list of characters for table
        $query = 'SELECT cid,title,contents.slug,metas.name FROM contents,metas WHERE allowComment=0 and contents.type=metas.mid ORDER BY ' . $order[$o];
        $result = mysql_query($query, $db) or die (mysql_error($db));
        if (mysql_num_rows($result) > 0) {
            echo ' <table> ';
            echo ' <tr> <th width="300"> <a href="' . $_SERVER['PHP_SELF'] . '?o=1"> Title </a> </th> ';
            echo ' <th width="250"> <a href="' . $_SERVER['PHP_SELF'] . '?o=2"> Slug </a> </th> ';
            echo ' <th width="250"> <a href="' . $_SERVER['PHP_SELF'] . '?o=3"> Type </a> </th> ';
            echo ' <th> Option </th> </tr> ';

            $odd = true;
            while ($row = mysql_fetch_assoc($result)) {
                echo ($odd == true) ? ' <tr class="odd_row"> ' : ' <tr class="even_row"> ';
                $odd = !$odd;
                echo ' <td> ';
                echo $row['title'];
                echo ' </td> <td> ';
                echo $row['slug'];
                echo '</td> <td> ';
                echo $row['name'];
                echo '</td> <td> ';
                echo ' <a href="contents.php?action=edit&cid=' . $row['cid'] . '"> [EDIT] </a> ';
                echo ' <a href="delete.php?cid=' . $row['cid'] . '" > [DELETE] </a> ';
                echo ' </td> </tr> ';
		}
    }
	?>
	</table>
<?php
    include 'foot.inc.php';
?>