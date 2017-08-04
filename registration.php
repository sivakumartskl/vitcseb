<?php
session_start();
if (isset($_SESSION['vitcseb1115users']) && isset($_SESSION['vitcseb1115userid'])) {
    header('Location: vitmainhome.php');
} else {
    if(isset($_POST['regsubmit'])) {
        require __DIR__ . '/lib/DBConnection.php';
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $regnum = $_POST['colregnum'];
        
        $dbConnection = new DBConnection();
        $insertParams = "INSERT INTO vit_user_table(user_name, email_address, user_password, coll_reg_num) VALUES(:usrnme, :usrpass, :usremail, :regnum)";
        $inserParams = array(':usrnme' => $username, ':usrpass' => $password, ':usremail' => $email, ':regnum' => $regnum);
        
        $resultreg = $dbConnection->executeQueryLastInsertedId($insertParams, $inserParams);
        
        if($resultreg) {
            $_SESSION['vitcseb1115users'] = $username;
            $_SESSION['vitcseb1115userid'] = $resultreg;
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
        <title>Registration page</title>
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
                        <form action="#" method="POST" class="form-horizontal">
                            <div class="form-group">
                                <label class="control-label col-sm-offset-3 col-sm-2">Username</label>
                                <div class="col-sm-3">
                                    <input type="text" name="username" placeholder="Username" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-offset-3 col-sm-2">Email</label>
                                <div class="col-sm-3">
                                    <input type="email" name="email" placeholder="Email address" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-offset-3 col-sm-2">password</label>
                                <div class="col-sm-3">
                                    <input type="password" name="password" placeholder="Password" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-offset-3 col-sm-2">college registration number</label>
                                <div class="col-sm-3">
                                    <input type="text" name="colregnum" placeholder="college registration number" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-5 col-sm-3">
                                    <input type="submit" value="Register" name="regsubmit" class="btn btn-default login-button">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-offset-3 col-sm-2">Already have an account?</label>
                                <div class="col-sm-3">
                                    <a href="index.php" class="btn btn-success form-redirect-btn">Login Here</a>
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

