<?php
    // include 'adminheader.inc.php';
    session_start();
    if(isset($_SESSION['username'])){
       
    include 'header.php';
	include 'db.inc.php';
    $db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or die ('Unable to connect. Check your connection parameters.');
    mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db)); 
?>

    <h4><a href="contents.php?action=add"> [NEW] </a></h4>
    
	<?php
        // determine sorting order of table
        $order = array(1 => 'title ASC', 2 => 'status', 3 => 'name ASC');
        $o = (isset($_GET['o']) && ctype_digit($_GET['o'])) ? $_GET['o'] : 1;
        if (!in_array($o, array_keys($order))) {
            $o = 1;
        }
        // select list of characters for table
        switch ($_SESSION['authCode']) {
            case '2':
                $query = 'SELECT cid,title,metas.name,status,users.username FROM contents,metas,users 
                    WHERE  contents.type=metas.mid AND contents.authorId=users.uid ORDER BY ' . $order[$o];
                $result = mysql_query($query, $db) or die (mysql_error($db));
                if (mysql_num_rows($result) > 0) {
                    echo ' <table class="table table-striped"> ';
                    echo ' <tr> <th width=""> <a href="' . $_SERVER['PHP_SELF'] . '?o=1"> Title </a> </th> ';
                    echo ' <th width=""> <a href="' . $_SERVER['PHP_SELF'] . '?o=2"> Status </a> </th> ';
                    echo ' <th width=""> <a href="' . $_SERVER['PHP_SELF'] . '?o=4"> Type </a> </th> ';
                    echo ' <th> Author </th> ';
                    echo ' <th> Option </th> </tr> ';

                    $odd = true;
                    while ($row = mysql_fetch_assoc($result)) {
                        echo ($odd == true) ? ' <tr class="odd_row"> ' : ' <tr class="even_row"> ';
                        $odd = !$odd;
                        echo ' <td> ';
                        echo $row['title'];
                        echo ' </td> <td> ';
                        echo $row['status'];
                        echo ' </td> <td> ';
                        echo $row['name'];
                        echo '</td> <td> ';
                        echo $row['username'];
                        echo '</td> <td> ';
                        echo ' <a href="contents.php?action=edit&cid=' . $row['cid'] . '"> [EDIT] </a> ';
                        echo ' <a href="delete.php?cid=' . $row['cid'] . '" > [DELETE] </a> ';
                        echo ' </td> </tr>';
                    }
                    echo '</table>';
                }else{
                    echo 'There has no Blogs. You can <a href="contents.php?action=add">add</a> one.';
                }
                break;
            case '1':
                $query = 'SELECT cid,title,contents.slug,metas.name,status FROM contents,metas
                    WHERE contents.type=metas.mid  AND contents.authorId=' . $_SESSION['uid'] .' ORDER BY ' . $order[$o];
                $result = mysql_query($query, $db) or die (mysql_error($db));
                if (mysql_num_rows($result) > 0) {
                    echo ' <table class="table table-striped"> ';
                    echo ' <tr> <th width="300"> <a href="' . $_SERVER['PHP_SELF'] . '?o=1"> Title </a> </th> ';
                    echo ' <th width="150"> <a href="' . $_SERVER['PHP_SELF'] . '?o=2"> Status </a> </th> ';
                    echo ' <th width="150"> <a href="' . $_SERVER['PHP_SELF'] . '?o=4"> Type </a> </th>';
                    echo ' <th> Option </th> </tr> ';

                    $odd = true;
                    while ($row = mysql_fetch_assoc($result)) {
                        echo ($odd == true) ? ' <tr class="odd_row"> ' : ' <tr class="even_row"> ';
                        $odd = !$odd;
                        echo ' <td> ';
                        echo $row['title'];
                        echo ' </td> <td> ';
                        echo $row['status'];
                        echo '</td> <td> ';
                        echo $row['name'];
                        echo '</td> <td> ';
                       echo ' <a href="contents.php?action=edit&cid=' . $row['cid'] . '"> [EDIT] </a> ';
                        echo ' <a href="delete.php?cid=' . $row['cid'] . '" > [DELETE] </a> ';
                        echo '</td></tr>';
                    }
                    echo '</table>';
                }else{
                    echo 'There has no Blogs. You can <a href="contents.php?action=add">add</a> one.';
                }
                break;
            }
        
            
    // include 'adminfoot.inc.php';
    }else{
        header ('Refresh: 1; URL= login.php');
        echo ' <p> You have not logged in. You will be redirected to login page. </p> ';
            echo ' <p> If your browser doesn\'t redirect you properly ' . 
                'automatically, <a href="login.php" >click here </a> . </p> ';
    }

    include 'foot.inc.php';
?>