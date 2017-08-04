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
<html>
    <head>
        <title>Registration page</title>
    </head>
    <body>
        <form action="#" method="POST">
            <label>Username</label>
            <input type="text" name="username" placeholder="Username">
            <label>Email</label>
            <input type="email" name="email" placeholder="Email address">
            <label>password</label>
            <input type="password" name="password" placeholder="Password">
            <label>college registration number</label>
            <input type="text" name="colregnum" placeholder="college registration number">
            <input type="submit" value="Register" name="regsubmit">
        </form>
        <a href="index.php">Login here...</a>
    </body>
</html>

