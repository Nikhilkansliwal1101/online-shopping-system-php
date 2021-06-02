<?php
session_start();
if (isset($_SESSION['adminid'])) {
  header("Location: profile.php");
}
require("common/database.php");
$responce = "";


// when try to submit email and password
if ((isset($_POST['submit'])) && (isset($_POST['password']))) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $query = "SELECT * FROM `admin` WHERE `email` LIKE '$email';";
  $result = mysqli_query($con, $query);
  $num = mysqli_num_rows($result);
  if ($num == 0) {
    $responce =
      '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error ! </strong>No email address found!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
  } else {
    $user = mysqli_fetch_assoc($result);
    if (password_verify($password, $user['password'])) {
      $_SESSION['adminmail'] = $email;
      $_SESSION['adminid'] = $user['adminid'];
      header("Location: index.php");
      die();
    } else {
      $responce =
        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Error!</strong>Wrong password
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
  }
}

// when try to reset password
if (isset($_POST['resetpassword'])) {
  $email = $_POST['email'];
  $query = "SELECT email FROM `admin` WHERE `email` LIKE '$email';";
  $result = mysqli_query($con, $query);
  $num = mysqli_num_rows($result);
  if ($num == 0) {
    $responce =
      '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong>No email address found!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
  } else {
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['resetpassword'] = 1;
    $subject = "Change_password_request";
    exec("python common/sendotp.py $email $subject", $output, $r);
    $showotpmodal = 1;
    $_SESSION['sendotp'] = $output[0];
    $_SESSION['checkotp'] = 1;
  }
}

//submit new password
if (isset($_POST['newsubmit'])) {
  $email = $_SESSION['email'];
  $hash1 = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);
  $query = "UPDATE `admin` SET `password` = '$hash1' WHERE `admin`.`email` LIKE '$email';";
  $result = mysqli_query($con, $query);
  if ($result) {
    $responce =
      '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong>Password updated sucessfully!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
      unset($_SESSION['resetpassword']);
      unset($_SESSION['email']);
      unset($_SESSION['changepassword']); 
  } else {
    $responce =
      '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Error!</strong>password not changed try again!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
  }
}

//submit otp for changeing password
if (isset($_POST['otpsubmit'])) {
  if ($_POST['otp'] == $_SESSION['sendotp']) {
    $_SESSION['changepassword'] = 1;
    unset($_SESSION['checkotp']);
    unset($_SESSION['sendotp']);
  } else {
    $responce =
      '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong>Wrong otp <br>Try again!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
  }
}
?>
<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log in</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>

<body>
  <?php require("common/navbar.php"); ?>
  <div id="alert">
    <?php echo $responce; ?>
  </div>
  <div class="container" style="max-width: 600px; height: 80vh;">
    <div class="border border-4 shadow p-2">
      <h2>Log in</h2>
      <hr>
      <form class="row g-3" action="login.php" method="post">
        <?php
        if (isset($_SESSION['resetpassword'])) {
          $email = $_SESSION['email'];
          echo
          '<div class="col-12">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" readonly value=' . $email . '>
                <div id="emailHelp" class="form-text">We will never share your email with anyone else.</div>
              </div>';
        } else {
          echo
          '<div class="col-12">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" required>
                <div id="emailHelp" class="form-text">We will never share your email with anyone else.</div>
              </div>
              <div class="col-12">
                <label for="passwd" class="form-label">Password</label>
                <input type="password" class="form-control" id="passwd" name="password">
              </div>
              <div class="col-12">
                <button type="submit" class="btn btn-primary" name="resetpassword" value="resetpassword">Resetpassword</button>
                <button type="submit" class="btn btn-primary" name="submit" value="submit" onclick="checknullpassword(event);">Submit</button>
                </div>';
        }
        ?>
        <?php
        if (isset($_SESSION['checkotp'])) {
          echo
          '<div class="col-12">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#otpmodal">
                Enter OTP
                </button>
                </div>';
        }
        if (isset($_SESSION['changepassword'])) {
          echo
          '<div class="col-12">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#passmodal">
                Set New Password
                </button>
                </div>';
        }
        ?>
      </form>
      <hr>
    </div>
  </div>
  <!-- modal for otp enter -->
  <div class="modal fade" id="otpmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1">Enter OTP sent to your E-mail id</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" action="login.php">
          <div class="modal-body">
            <div class="mb-3">
              <label for="otp" class="form-label">Enter OTP</label>
              <input type="text" class="form-control" id="otp" name="otp">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" name="otpsubmit">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- modal for reset password -->
  <div class="modal fade" id="passmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel2">Reset your password</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="check"></div>
        <form method="post" action="login.php" onsubmit="checksamepassword(event)">
          <div class="modal-body">
            <div class="mb-3">
              <label for="newpassword" class="form-label">Password</label>
              <input type="password" class="form-control" id="newpassword" name="newpassword" required>
            </div>
            <div class="mb-3">
              <label for="rnewpassword" class="form-label">Re-enter Password</label>
              <input type="password" class="form-control" id="rnewpassword" name="rnewpassword" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" name="newsubmit">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php require("common/script.php"); ?>
  <script>
    function checksamepassword(event) {
      pass1 = document.getElementById('newpassword').value;
      pass2 = document.getElementById('rnewpassword').value;
      if (pass1.localeCompare(pass2) == 0) {
        return true;
      } else {
        document.getElementById('check').innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error ! </strong>Enter same password!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
        event.preventDefault();
        return false;
      }
    }

    function checknullpassword(event) {
      pass = document.getElementById('passwd').value;
      if (pass) {
        return true;
      } else {
        event.preventDefault();
        document.getElementById('alert').innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error ! </strong>Enter password!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
        return false;
      }
    }
  </script>
</body>

</html>