<?php 
session_start();
    if(!isset($_SESSION['vitcseb1115users']) && !isset($_SESSION['vitcseb1115userid'])) {
        header('Location: index.php');
    }
    else {
        
    }
?>
<!DOCTYPE  html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Vitcseb1115</title>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/datatables.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/jquery-ui-style.css" rel="stylesheet" type="text/css"/>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
        <script src="js/jquery-2.1.4.min.js" type="text/javascript"></script>
        <script src="js/jquery-ui-block.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/datatables.min.js" type="text/javascript"></script>
        <script src="js/moment.js" type="text/javascript"></script>
        <script src="js/script.js" type="text/javascript"></script>
    </head>
    <body>
        <?php include_once(__DIR__ . '/templates/vitheadernav.php'); ?>
        <a href='vit1115logout.php' style="float: right;">Logout</a>
        <form align="center">
            <label>Enter the youtube url</label><br>
            <textarea cols="100" rows="3" id="yurl" placeholder="Enter the youtube url..."></textarea><br>
            <input type="submit" value="Submit Url" align="center" id="ysubmit">
        </form><br>
        <input type="hidden" value="<?php echo $_SESSION['vitcseb1115userid']; ?>" id="currentLoggedInUserId">
        <div id="sampleTest"></div>
        <div id="commentsModalVit" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Comments</h4>
                    </div>
                    <div class="modal-body" id="allCommsBodyDiv">
                        <div id="appendAllComms"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

