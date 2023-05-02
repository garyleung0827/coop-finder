<?php
// Include coopDAO file
require_once('./dao/coopDAO.php');
$coopDAO = new coopDAO(); 

// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Get URL parameter
    $id =  trim($_GET["id"]);
    $coop = $coopDAO->getCoop($id);
            
    if($coop){
        // Retrieve individual field value
        $title = $coop->getTitle();
        $link = $coop->getLink();
        $source = $coop->getSource();
        $pubDate = $coop->getPubDate();
    } else{
        // URL doesn't contain valid id. Redirect to error page
        header("location: error.php");
        exit();
    }
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
} 

// Close connection
$coopDAO->getMysqli()->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>Title</label>
                        <p><b><?php echo $title; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Link</label>
                        <p><b><?php echo $link; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Source</label>
                        <p><b><?php echo $source; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Pub Date</label>
                        <p><b><?php echo $pubDate; ?></b></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>