<?php
    session_start();
    include 'db.inc.php';
    $db = mysql_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PASSWORD) or die ('Unable to connect. Check your connection parameters.');
    mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));
    // filter incoming values
    $name = (isset($_POST['name'])) ? trim($_POST['name']) : '';
    $password = (isset($_POST['password'])) ? $_POST['password'] : '';
    $redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : 'index.php';
    if (isset($_POST['submit'])) {
        $query = 'SELECT authCode FROM users WHERE ' .
            'name = "' . mysql_real_escape_string($name, $db) . '" AND ' .
            'password = "' . mysql_real_escape_string($password, $db) . '"';
        $result = mysql_query($query, $db) or die(mysql_error($db));
        if (mysql_num_rows($result) > 0) {
            $row = mysql_fetch_assoc($result);
            $_SESSION['name'] = $name;
            $_SESSION['logged'] = 1;
            $_SESSION['authCode'] = $row['authCode'];
            header ('Refresh: 1; URL=' . $redirect);
            echo ' <p> You will be redirected to your original page request. </p> ';
            echo ' <p> If your browser doesn\'t redirect you properly ' . 
                'automatically, <a href="' . $redirect . '" >click here </a> . </p> ';
            die();
        } else {
                // set these explicitly just to make sure
            $_SESSION['name'] = '';
            $_SESSION['logged'] = 0;
            $_SESSION['authCode'] = 0;
            $error = ' <p> <strong> You have supplied an invalid username and/or ' .
                    'password! </strong> Please <a href="register.php"> click here ' .
                    'to register </a> if you have not done so already. </p> ';
            
        }
    }
?>
<html>
<head>
    <title> Login </title>
</head>
<body>
    <?php
        if (isset($error)) {
            echo $error;
        }
    ?>
    <form action="login.php" method="post">
    <table>
        <tr>
            <td> Username: </td>
            <td> <input type="text" name="name" maxlength="20" size="20" 
                value=" <?php echo $name; ?> " /> </td>
        </tr> 
        <tr>
            <td> Password: </td>
            <td> <input type="password" name="password" maxlength="20" size="20"
                value=" <?php echo $password; ?> " /> </td>
        </tr> 
        <tr>
            <td> </td>
            <td><input type="hidden" name="redirect" value=" <?php echo $redirect ?> " />
                <input type="submit" name="submit" value="Login" />
        </tr>
    </table>
    </form>
</body>
</html>