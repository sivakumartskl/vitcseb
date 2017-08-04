<?php 
session_start();

    if(isset($_SESSION['vitcseb1115users']) && isset($_SESSION['vitcseb1115userid'])) {
        header('Location: vitmainhome.php');
    }
    else {
        if(isset($_POST['logsub'])) {
            require __DIR__ . '/lib/DBConnection.php';
            $loginConnection = new DBConnection();

            $username = $_POST['username'];
            $password = $_POST['password'];

            $selectQuery = "SELECT user_id, user_name, user_password FROM vit_user_table WHERE user_name = :usrnme AND user_password = :pwd";
            $selectParams = array(':usrnme' => $username, ':pwd' => $password);

            $result = $loginConnection->getResult($selectQuery, $selectParams);
//            print_r($result);
            $userid = $result[0]['user_id'];
            if($result) {
                $_SESSION['vitcseb1115users'] = $username;
                $_SESSION['vitcseb1115userid'] = $userid;
                header('Location: vitmainhome.php');
            }
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Welcome to login page</title>
    </head>
    <body>
        <div>
            <form action='#' method='post'>
                <div>
                    <label>Username : </label>
                    <div><input type='text' name='username'></div>
                </div>
                <div>
                    <label>Password : </label>
                    <div><input type='password' name='password'></div>
                </div>
                <div>
                    <div><input type='submit' name='logsub'></div>
                </div>
            </form>
        </div>
        <a href="registration.php">Register here...</a>
    </body>
</html>
