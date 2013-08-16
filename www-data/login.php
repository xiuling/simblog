<?php
    session_start();

    include 'header.php';
    include 'db.inc.php';
    $db = mysql_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PASSWORD) or die ('Unable to connect. Check your connection parameters.');
    mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));
    // filter incoming values
    $username = (isset($_POST['username'])) ? trim($_POST['username']) : '';
    $password = (isset($_POST['password'])) ? $_POST['password'] : '';
    $redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : 'index.php';
    if (isset($_POST['submit'])) {
        $query = 'SELECT authCode,uid FROM users WHERE ' .
            'username = "' . mysql_real_escape_string($username, $db) . '" AND ' .
            'password = "' . mysql_real_escape_string($password, $db) . '"';
        $result = mysql_query($query, $db) or die(mysql_error($db));
        if (mysql_num_rows($result) > 0) {
            $row = mysql_fetch_assoc($result);
            $_SESSION['username'] = $username;
            $_SESSION['uid'] = $row['uid'];
            $_SESSION['logged'] = 1;
            $_SESSION['authCode'] = $row['authCode'];
            header ('Refresh: 1; URL=' . $redirect);
            echo ' <p> You will be redirected to your original page request. </p> ';
            echo ' <p> If your browser doesn\'t redirect you properly ' . 
                'automatically, <a href="' . $redirect . '" >click here </a> . </p> ';
            die();
        } else {
                // set these explicitly just to make sure
            $_SESSION['username'] = '';
            $_SESSION['logged'] = 0;
            $_SESSION['authCode'] = 0;
            $error = ' <p> <strong> You have supplied an invalid username and/or ' .
                    'password! </strong> Please <a href="register.php"> click here ' .
                    'to register </a> if you have not done so already. </p> ';
            
        }
    }
?>

    <?php
        if (isset($error)) {
            echo $error;
        }
    ?>
    <h3>Log In</h3>
    <form class="form-horizontal" role="form"  action="login.php" method="post">
        <div class="form-group">
            <label for="username" class="col-lg-2 control-label">Username</label>
            <div class="col-lg-4">
                <input type="text" class="form-control" id="username" placeholder="username" name="username">
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="col-lg-2 control-label">Password</label>
            <div class="col-lg-4">
                <input type="password" class="form-control" id="password" placeholder="Password" name="password">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
                <button type="submit" class="btn btn-default" name="submit">LogIn</button>
            </div>
        </div>
        <input type="hidden" name="redirect" value=" <?php echo $redirect ?> " />
    </form>    
</div>
</body>
</html>