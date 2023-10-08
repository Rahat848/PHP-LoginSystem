<?php
$login = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include './partials/_dbconnect.php';
  $username = $_POST['username'];
  $password = $_POST['password'];

  // $sql = "Select * from users where username = '$username' AND password='$password'";
  $sql = "Select * from users where username = '$username'";
  $result = mysqli_query($connection, $sql);
  $num = mysqli_num_rows($result);
  if ($num == 1) {
    while ($row = mysqli_fetch_assoc($result)) {
      if (password_verify($password, $row['password'])) {
        $login = true;
        //session use
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("location: welcome.php");
      }else{
        $showError = "Invalid Credentials";
    }
    }
} else {
    $showError = "invalid Credentials";
  }


}

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
  <?php require('./partials/_nav.php'); ?>

  <!-- alert -->
  <?php
  if ($login) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
<strong>Success!</strong> You are Loged In.
<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
  }
  if ($showError) {
    echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
<strong>error!</strong> . $showError. Please try again...
<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
  }


  ?>

  <div class="container my-4">
    <h1 class="text-center">Log in to Our Website</h1>
    <form action="/php-loginsystem/login.php" method="POST">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password">
      </div>
      <button type="submit" class="btn btn-primary">Login</button>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>
</body>

</html>