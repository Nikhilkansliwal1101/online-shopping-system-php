<?php
session_start();
$responce="";

if (!isset($_SESSION['supplierid'])) {
  header("Location: login.php");
  die();
}
require("common/database.php");
if (isset($_POST["savechanges"])) {
  $name = $_POST['name'];
  $mobile = $_POST['mobile'];
  $email = $_POST['email'];

  $query = "UPDATE `supplier` SET `name`= '$name',`mobile`='$mobile' WHERE `supplier`.`email` ='$email' ;";
  $result = mysqli_query($con, $query);
  if ($result) {
        $responce=
        '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Sucess ! </strong>Detailes Updated successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
  } else {
        $responce=
        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error !</strong> cannot be updated.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
  }
}
$email = $_SESSION['suppliermail'];
$query = "SELECT `name`, `mobile` FROM `supplier` WHERE `email` LIKE '$email'";
$detail = mysqli_query($con, $query);
$detail = mysqli_fetch_assoc($detail);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>

<body>
  <?php require("common/navbar.php"); ?>
<div id="alert">
<?php echo $responce;?>
</div>
  <div class="container border border-4 shadow p-3" style="max-width: 600px">
    <div class="d-flex justify-content-center">
      <img src="../online/images/user.png" alt="User" class="img-fluid">
    </div>
    <br>
    <fieldset disabled="disabled" id="form">
    <form class="row g-3" method="post" action="profile.php">
      <div class="col-12">
        <label for="inputEmail4" class="form-label">Email</label>
        <input type="email" class="form-control" id="inputEmail4" name="email" readonly value=<?php echo $_SESSION['suppliermail']; ?>>
      </div>
      <div class="col-12">
        <label for="inputname" class="form-label">Name</label>
        <input type="text" class="form-control" id="inputname" name="name" required value=<?php echo "\"" . $detail['name'] . "\""; ?>>
      </div>
      <div class="col-12">
        <label for="inputmobile" class="form-label">Mobile No</label>
        <input type="text" class="form-control" id="inputmobile" name="mobile" required minlength="10" maxlength="10" value=<?php echo $detail['mobile']; ?>>
      </div>
      <button type="submit" class="btn btn-primary" value="savechanges" name="savechanges" id="savechanges" style="display: none;">Save Changes</button>
    </form>
    </fieldset>
    <div class="row">
      <div class="col-6 p-2 my-2">
        <button type="button" class="btn btn-primary w-100" id="editbutton" onclick=editinfo()>Edit</button>
      </div>
      <div class="col-6 p-2 my-2">
        <a href="logout.php"><button type="button" class="btn btn-danger w-100" id="logoutbutton">Logout</button></a>
      </div>
    </div>
  </div>
  <?php require("common/script.php"); ?>
  <script>
    function editinfo() {
      document.getElementById('editbutton').style.display = 'none';
      document.getElementById('logoutbutton').style.display = 'none';
      document.getElementById('savechanges').style.display = 'block';
      document.getElementById('form').disabled = false;
    }
  </script>
</body>

</html>