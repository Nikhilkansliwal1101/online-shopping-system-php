<?php
session_start();
$responce = "";
require("common/database.php");


if (!isset($_SESSION['emailvarified'])) {
    $_SESSION['emailvarified'] = 0;
    $_SESSION['otpsent'] = 0;
}
if (isset($_POST["submit"])) {
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $pincode = $_POST['pincode'];
    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO `customer` (`custid`, `name`, `email`, `password`, `mobile`, `address`, `city`, `state`, `pincode`, `date`) VALUES (NULL,'$name', '$email','$hash', '$mobile', '$address', '$city', '$state', '$pincode', current_timestamp());";
    $result = mysqli_query($con, $query);
    if ($result) {
        $_SESSION['alreadyexists'] = 1;
        unset($_SESSION['otpsent']);
        unset($_SESSION['emailvarified']);
        unset($_SESSION['email']);
        unset($_SESSION['sendotp']);
        header("Location: login.php");
        die();
    } else {
        $responce =
            '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Error!</strong> cannot sign up
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
}
if (isset($_POST['sendotp'])) {
    $email = $_POST['email'];
    $query = "SELECT email FROM `customer` WHERE `email` LIKE '$email';";
    $result = mysqli_query($con, $query);
    $num = mysqli_num_rows($result);
    if ($num == 0) {
        $subject = "request_for_varify_email";
        exec("python common/sendotp.py $email $subject", $output, $r);
        $_SESSION['sendotp'] = $output[0];
        $_SESSION['email'] = $email;
        $_SESSION['otpsent'] = 1;
        $responce =
            '<div class="alert alert-Success alert-dismissible fade show" role="alert">
        <strong>Success ! </strong>OTP send to your E-mail address
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    } else {
        $_SESSION['alreadyexists'] = 1;
        header("Location: login.php");
        die();
    }
}
if (isset($_POST['otpsubmit'])) {
    if ($_POST['otp'] == $_SESSION['sendotp']) {
        $_SESSION['emailvarified'] = 1;
    } else {
        $responce =
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Error ! </strong>Wrong otp <br>Try again !
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
}
if (isset($_POST['resendotp'])) {
    unset($_SESSION['otpsent']);
    unset($_SESSION['emailvarified']);
    unset($_SESSION['email']);
    unset($_SESSION['sendotp']);
    header("Location: signin.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>

<body>
    <?php require("common/navbar.php"); ?>
    <div id="alert">
        <?php echo $responce; ?>
    </div>
    <?php
    if ($_SESSION['emailvarified'] == 1) {
        $email = $_SESSION['email'];
        echo
        '<div class="container border border-4 shadow p-3" style="max-width: 600px">
            <h2>Sign in for more</h2>
            <hr>
            <form class="row g-3" method="post" action="signin.php">
                <div class="col-md-6">
                    <label for="inputname" class="form-label">Name</label>
                    <input type="text" class="form-control" id="inputname" name="name" required>
                </div>
                <div class="col-md-6">
                    <label for="inputmobile" class="form-label">Mobile No</label>
                    <input type="text" class="form-control" id="inputmobile" name="mobile" required minlength="10"
                        maxlength="10">
                </div>
                <div class="col-md-6">
                    <label for="inputEmail4" class="form-label">Email</label>
                    <input type="email" class="form-control" id="inputEmail4" name="email" readonly value=' . $email . '>
                </div>
                <div class="col-md-6">
                    <label for="inputPassword4" class="form-label">Password</label>
                    <input type="password" class="form-control" id="inputPassword4" name="password" required minlength="8">
                </div>
                <div class="col-12">
                    <label for="inputAddress" class="form-label">Address</label>
                    <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" name="address"
                        required>
                </div>
                <div class="col-md-4">
                    <label for="inputZip" class="form-label">Pincode</label>
                    <input type="number" class="form-control" id="inputZip" name="pincode" readonly value=303103>
                </div>
                <div class="col-md-4">
                    <label for="inputCity" class="form-label">City</label>
                    <input type="text" class="form-control" id="inputCity" name="city" value="Jaipur" readonly required>
                </div>
                <div class="col-md-4">
                    <label for="inputState" class="form-label">State</label>
                    <select id="inputState" class="form-select" name="state" readonly>
                        <option selected value="Rajasthan">Rajasthan</option>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary" value="submit" name="submit">Sign in</button>
                    <button type="reset" class="btn btn-primary">Reset</button>
                </div>
            </form>
        </div>';
    } else {
        if (!$_SESSION['otpsent']) {
            echo
            '<div class="container border border-4 shadow  p-3" style="max-width: 600px">
                <h2>Varify your email address</h2><hr>
                <form action="signin.php" method="post" class="row g-3">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" required>
                        <div id="emailHelp" class="form-text">We will never share your email with anyone else.</div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="sendotp" value="submit">Send OTP</button>
                </form>  
            </div>';
        } else {
            $email = $_SESSION['email'];
            echo
            '<div class="container border border-4 shadow p-3" style="max-width: 600px">
                <h2>Varify your email address</h2><hr>
                <form action="signin.php" method="post" class="row g-3">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" disabled value=' . $email . '>
                        <div id="emailHelp" class="form-text">We will never share your email with anyone else.</div>
                    </div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#otpmodal"> Varify E-mail</button>
                    <button type="submit" class="btn btn-primary" name="resendotp" value="submit">Resend OTP</button>
                </form>
            </div>';
        }
    }
    ?>
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
                <form method="post" action="signin.php">
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
    <?php require("common/script.php"); ?>
</body>

</html>