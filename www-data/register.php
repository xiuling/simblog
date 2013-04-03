<?php
    session_start();
    include 'db.inc.php';
    $db = mysql_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PASSWORD) or die ('Unable to connect. Check your connection parameters.');
    mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));
    // filter incoming values
    $name = (isset($_POST['name'])) ? trim($_POST['name']) : '';
    $password = (isset($_POST['password'])) ? $_POST['password'] : '';
    $mail = (isset($_POST['mail'])) ? trim($_POST['mail']) : '';
    $url = (isset($_POST['url'])) ? trim($_POST['url']) : '';
    $screenName = (isset($_POST['screenName'])) ? trim($_POST['screenName']) : '';
    if (isset($_POST['submit']) && $_POST['submit'] == 'Register') {
        $errors = array();
    // make sure manditory fields have been entered
        if (empty($name)) {
            $errors[] = 'Username cannot be blank.';
        }
    // check if username already is registered
        $query = 'SELECT name FROM users WHERE name = "' . $name . '"';
        $result = mysql_query($query, $db) or die(mysql_error());
        if (mysql_num_rows($result) > 0) {
            $errors[] = 'Username ' . $name . ' is already registered.';
            $name = '';
        }
        mysql_free_result($result);
        if (empty($password)) {
            $errors[] = 'Password cannot be blank.';
        }
        if (empty($mail)) {
            $errors[] = 'Email address cannot be blank.';
        }
        if (count($errors) > 0) {
            echo ' <p> <strong style="color:#FF000;" > Unable to process your ' .'registration. </strong> </p> ';
            echo ' <p> Please fix the following: </p> ';
            echo ' <ul> ';
            foreach ($errors as $error) {
                echo ' <li> ' . $error . ' </li> ';
            }
            echo ' </ul> ';
        } else {
    // No errors so enter the information into the database.
            $query = 'INSERT INTO users(uid, name, password, mail, url, screenName)
                VALUES(NULL ,"' . mysql_real_escape_string($name, $db) . '", 
                "' . mysql_real_escape_string($password, $db) . '", 
                "' . mysql_real_escape_string($mail, $db) . '", 
                "' . mysql_real_escape_string($url, $db) . '", 
                "' . mysql_real_escape_string($screenName, $db) . '" )';
            $result = mysql_query($query, $db) or die(mysql_error());
            $_SESSION['logged'] = 1;
            $_SESSION['name'] = $name;
            header('Refresh: 5; URL=main.php');
?>
<html>
<head>
    <title> Register </title>
</head>
<body>
    <p> <strong> Thank you <?php echo $name; ?> for registering! </strong> </p>
    <p> Your registration is complete! You are being sent to the page you requested. If your browser doesn't redirect properly after 5 seconds,<a href=”main.php”> click here </a> . </p>
</body>
</html>
<?php
    die();
        }
    }
?>
<html>
<head>
    <title> Register </title>
    <style type="text/css">
        td { vertical-align: top; }
    </style>
</head>
<body>
    <form action="register.php" method="post" >
    <table>
        <tr>
            <td> <label for="name" > Username: </label> </td>
            <td><input type="text" name="name" id="name" size="20" maxlength="20" value="<?php echo $name;?> "/></td>
        </tr> 
        <tr>
            <td> <label for="password" > Password: </label> </td>
            <td><input type="password" name="password" id="password" size="20" maxlength="20" value="<?php echo $password;?> " /> </td>
        </tr> 
        <tr>
            <td> <label for="mail"> Email: </label> </td>
            <td> <input type="text" name="mail" id="mail" size="20" maxlength="50" value="<?php echo $mail; ?>" /> </td>
        </tr> 
        <tr>
            <td> <label for="url"> Url: </label></td>
            <td> <input type="text" name="url" id="url" size="20" maxlength="50" value=" <?php echo $url; ?>"/ > </td>
        </tr>
        <tr>
            <td> <label for="screenName"> ScreenName: </label> </td>
            <td><input type="text" name="screenName" id="screenName" size="20" maxlength="20" value="<?php echo $screenName; ?>"/> </td>
        </tr>
        <tr>
            <td> </td>
            <td> <input type="submit" name="submit" value="Register" /></td>
        </tr>
    </table>
    </form>
</body>
</html>