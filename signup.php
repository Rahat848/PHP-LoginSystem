<?php
$showalert = false;
$showError = false;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include './partials/_dbconnect.php';
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // $exists = false;
    //check wheather this username Exits;
    $exitstsSql = "SELECT * FROM `users` WHERE username = '$username'";
    $result= mysqli_query($connection,$exitstsSql);
    $numExitsRows = mysqli_num_rows($result);

    if($numExitsRows > 0){
        // $exists = true;
        $showError = "username already exists";
    }
    else{
        // $exists = false;
        if($password == $cpassword){
            $hash =password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`username`, `password`, `dt`) VALUES ('$username', '$hash', current_timestamp())";
            $result = mysqli_query($connection,$sql);
            if($result){
                $showalert = true;
            }
        }
        else{
            $showError ="Password do not match";
        }
    }

}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
<?php require('./partials/_nav.php'); ?>

<!-- alert signup done or not  starts -->
<?php
if($showalert){
echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
<strong>Success!</strong> Your Account is now created and you can login.
<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
}
if($showError){
echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
<strong>error!</strong> . $showError. Please try again...
<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
}
?>
<!-- alert signup done or not  ends -->

    <div class="container my-4">
        <h1 class="text-center">Signup to Our Website</h1>
        <form action="/php-loginsystem/signup.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" maxlength="30" class="form-control" id="username" name="username" aria-describedby="emailHelp" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" maxlength="30" class="form-control" id="password" name="password" required>
            </div >
            <div class="mb-3">
                <label for="cpassword" class="form-label">Confirm Password</label>
                <input type="cpassword" maxlength="255" class="form-control" id="cpassword" name="cpassword" required>
                <div id="cpassword" class="form-text">Mske sure to type the same password.</div>
            </div>
            <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>
        <div class="my-3 text-center">
            <h5 class="mx-auto"><span class="fw-bold">Note:</span> Please do not put your original email and password.</h5>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>

</html>