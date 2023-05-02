<?php
// Include movieDAO file
require_once('./dao/movieDAO.php');


// Define variables and initialize with empty values
$name = $director = $releaseDate = $length = $imgName = "";
$name_err = $director_err =  $releaseDate_err = $length = $imgName_err = "";

// Processing form data when form is submitted

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //validate upload
    if (isset($_FILES['imgName'])) {
        $file_name = $_FILES['imgName']['name'];
        $file_size = $_FILES['imgName']['size'];
        $file_tmp = $_FILES['imgName']['tmp_name'];
        $imgName = $file_name;

        if ($_FILES['imgName']['size'] > 10485760) {
            $imgName_err = 'Faild to upload: File size must be smaller than 10 MB';
        }
    }

    // Validate name
    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Please enter a name.";
    } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\d\s:]+$/")))) {
        $name_err = "Please enter a valid name.";
    } else {
        $name = $input_name;
    }

    // Validate director
    $input_director = trim($_POST["director"]);
    if (empty($input_director)) {
        $director_err = "Please enter director name.";
    } elseif (!filter_var($input_director, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s,]+$/")))) {
        $director_err = "Please enter a valid name.";
    } else {
        $director = $input_director;
    }

    // Validate release date
    $input_releaseDate = trim($_POST["releaseDate"]);
    if (empty($input_releaseDate)) {
        $releaseDate_err = "Please enter the date of release.";
    } elseif (date($input_releaseDate) > date("Y-m-d")) {
        $releaseDate_err = "Date must smaller than today";
    } else {
        $releaseDate = $input_releaseDate;
    }

    // Validate length
    $input_length = trim($_POST["length"]);
    if (empty($input_length)) {
        $length_err = "Please enter the movie length(min).";
    } elseif (!ctype_digit($input_length)) {
        $length_err = "Please enter a positive integer value.";
    } else {
        $length = $input_length;
    }

    // Check input errors before inserting in database and upload file
    if (empty($name_err) && empty($director_err) && empty($releaseDate_err) && empty($length_err) &&  empty($imgName_err)) {
        $movieDAO = new movieDAO();
        $movie = new Movie(0, $name, $director, $releaseDate, $length, $imgName);
        $addResult = $movieDAO->addMovie($movie);
        move_uploaded_file($file_tmp,"imgs/".$file_name);
        echo '<br><h6 style="text-align:center">' . $addResult . '</h6>';
        header("refresh:2; url=index.php");
        // Close connection
        $movieDAO->getMysqli()->close();
    }


}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
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
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add movie to the database.</p>

                    <!--the following form action, will send the submitted form data to the page itself ($_SERVER["PHP_SELF"]), instead of jumping to a different page.-->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype = "multipart/form-data">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name"
                                class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $name; ?>">
                            <span class="invalid-feedback">
                                <?php echo $name_err; ?>
                            </span>
                        </div>

                        <div class="form-group">
                            <label>Director</label>
                            <input type="text" name="director"
                                class="form-control <?php echo (!empty($director_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $director; ?>">
                            <span class="invalid-feedback">
                                <?php echo $director_err; ?>
                            </span>
                        </div>

                        <div class="form-group">
                            <label>Release Date</label>
                            <input type="date" name="releaseDate"
                                class="form-control <?php echo (!empty($releaseDate_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $releaseDate; ?>" >
                            <span class="invalid-feedback">
                                <?php echo $releaseDate_err; ?>
                            </span>
                        </div>

                        <div class="form-group">
                            <label>Movie Length(min)</label>
                            <input type="text" name="length"
                                class="form-control <?php echo (!empty($length_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $length; ?>">
                            <span class="invalid-feedback">
                                <?php echo $length_err; ?>
                            </span>
                        </div>

                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" accept="image/*" name="imgName" 
                                class="form-control <?php echo (!empty($imgName_err)) ? 'is-invalid' : ''; ?>">
                            <span class="invalid-feedback">
                                <?php echo $imgName_err; ?>
                            </span>
                        </div>

                        <input type="submit" class="btn btn-primary" value="Submit">
                        <input type="reset" class="btn btn-danger" value="Reset">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
        <? include 'footer.php'; ?>
    </div>
</body>

</html>