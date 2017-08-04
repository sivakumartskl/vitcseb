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
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Welcome to login page</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="js/jquery-2.1.4.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="jumbotron text-center">
                <h1>Vit Cse B</h1>
                <p>2011 - 2015</p> 
                <p>Facebook type website for vit friends</p> 
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-container">
                        <form action='#' method='post' class="form-horizontal">
                            <div class="form-group">
                                <label class="control-label col-sm-offset-3 col-sm-2">Username</label>
                                <div class="col-sm-3"><input type='text' name='username' class="form-control"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-offset-3 col-sm-2">Password</label>
                                <div class="col-sm-3"><input type='password' name='password' class="form-control"></div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-5 col-sm-3">
                                    <input type='submit' name='logsub' class="btn btn-default login-button" value="Login">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-offset-3 col-sm-2">Don't have an account?</label>
                                <div class="col-sm-3">
                                    <a href="registration.php" class="btn btn-success form-redirect-btn">Register Here</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <footer class="footer">
              <div class="container">
                <p class="text-muted">A webiste by Sivakumar Tadisetti...</p>
              </div>
            </footer>
        </div>
    </body>
</html>
