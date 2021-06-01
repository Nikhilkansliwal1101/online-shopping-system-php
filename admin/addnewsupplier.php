<?php
session_start();
if (!isset($_SESSION['adminid'])) {
    header("Location: login.php");
    die();
}
$responce = "";
require("common/database.php");


if (isset($_POST["submit"])) {
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $status = $_POST['status'];
    $pass = rand();
    $hash = password_hash($pass, PASSWORD_DEFAULT);

    $query = "INSERT INTO `supplier` (`supplierid`, `name`, `mobile`, `email`, `password`) VALUES (NULL,'$name', '$mobile', '$email','$hash');";
    $result = mysqli_query($con, $query);
    if ($result) {
        $responce =
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success ! </strong> Added Successfully
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    } else {
        $responce =
            '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Error!</strong> cannot sign up
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
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>

<body>
    <?php require("common/navbar.php"); ?>
    <div id="alert">
        <?php echo $responce; ?>
    </div>
    <div class="container border border-4 shadow p-3" style="max-width: 600px">
        <h2>Add New Supplier</h2>
        <hr>
        <form class="row g-3" method="post" action="addnewadmin.php">
            <div class="col-12">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="col-12">
                <label for="mobile" class="form-label">Mobile No</label>
                <input type="text" class="form-control" id="mobile" name="mobile" required minlength="10" maxlength="10">
            </div>
            <div class="col-12">
                <label for="Email" class="form-label">Email</label>
                <input type="email" class="form-control" id="Email" name="email" required>
            </div>
            <div class="col-12">
                <br>
                <button type="submit" class="btn btn-primary w-100" value="submit" name="submit">ADD</button>
            </div>
        </form>
    </div>
    <?php require("common/script.php"); ?>
</body>

</html>