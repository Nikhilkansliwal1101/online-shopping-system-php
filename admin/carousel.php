<?php
session_start();
if (!isset($_SESSION['adminid'])) {
    header("Location: login.php");
}
require("common/database.php");
$responce = "";
$target_dir = "../images/carousel/";
// add new carousel
if (isset($_POST['addcarousel'])) {
    $clable = $_POST['clable'];
    $imagename = str_replace(" ", "", $clable);
    $query = "SELECT * FROM `carousel` WHERE `clable` LIKE '$clable';";
    $result = mysqli_query($con, $query);
    $num = mysqli_num_rows($result);
    if ($num == 0) {
        $cdisc = $_POST['cdisc'];
        $check = getimagesize($_FILES["cimage"]["tmp_name"]);
        $target_file = $target_dir . basename($_FILES["cimage"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $target_file = $target_dir . $imagename . "." . $imageFileType;
        $imagename = $imagename . "." . $imageFileType;
        if ($check !== false) {
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "jfif") {
                $responce =
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error! </strong>only JPG, JPEG, PNG & GIF files are allowed.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            } else {
                if ($_FILES["cimage"]["size"] > 700000) {
                    $responce =
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error! </strong>File size is too big
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                } else {
                    if (move_uploaded_file($_FILES["cimage"]["tmp_name"], $target_file)) {
                        $query = "INSERT INTO `carousel` (`id`, `clable`, `cdisc`, `image`) VALUES (NULL, '$clable', '$cdisc', '$imagename');";
                        $result = mysqli_query($con, $query);
                        if ($result) {
                            $responce =
                                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sucess! </strong>Carousel added sucessfully
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                        } else {
                            $responce =
                                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error! </strong>Cannot add carousel
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                        }
                    } else {
                        $responce =
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error! </strong>Error in uploading file.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                    }
                }
            }
        } else {
            $responce =
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error! </strong>Please select an image
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    } else {
        $responce =
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error! </strong>Carousel already exists
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
}
//update carousel
if (isset($_POST['editcarousel'])) {
    if (isset($_POST['editimage']) && ($_FILES['editcimage']["size"]!=0)) {
        $clable = $_POST['editclable'];
        $imagename = str_replace(" ", "", $clable);
        $check = getimagesize($_FILES["editcimage"]["tmp_name"]);
        $target_file = $target_dir . basename($_FILES["editcimage"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $target_file = $target_dir . $imagename . "." . $imageFileType;
        $imagename = $imagename . "." . $imageFileType;
        if ($check !== false) {
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "jfif") {
                $responce =
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error! </strong>only JPG, JPEG, PNG & GIF files are allowed.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            } else {
                if ($_FILES["editcimage"]["size"] > 700000) {
                    $responce =
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error! </strong>File size is too big
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                } else {
                    if (move_uploaded_file($_FILES["editcimage"]["tmp_name"], $target_file)) {
                        $id = $_POST['editid'];
                        $cdisc = $_POST['editcdisc'];
                        $query = "UPDATE `carousel` SET `cdisc` = '$cdisc',`image`='$imagename' WHERE `carousel`.`id` = '$id';";
                        $result = mysqli_query($con, $query);
                        if ($result) {
                            $responce =
                                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Sucess! </strong>carousel updated sucessfully
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                        } else {
                            $responce =
                                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error! </strong>Cannot update carousel
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                        }
                    } else {
                        $responce =
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error! </strong>Error in uploading file.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                    }
                }
            }
        }
    } else {
        $id = $_POST['editid'];
        $cdisc = $_POST['editcdisc'];
        $query = "UPDATE `carousel` SET `cdisc` = '$cdisc' WHERE `carousel`.`id` = '$id';";
        $result = mysqli_query($con, $query);
        if ($result) {
            $responce =
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sucess! </strong>carousel updated sucessfully
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        } else {
            $responce =
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error! </strong>Cannot update carousel
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }
}
//delete carousel
if (isset($_POST['deletecarousel'])) {
    $id = $_POST['deleteid'];
    $query = "DELETE FROM `carousel` WHERE `carousel`.`id` = $id;";
    $result = mysqli_query($con, $query);
    if ($result) {
        $responce =
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Sucess! </strong>carousel deleted sucessfully
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    } else {
        $responce =
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error! </strong>Cannot delete carousel
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
}

// carousel list
$query = "SELECT * FROM `carousel`";
$carousel = mysqli_query($con, $query);
$carousel = mysqli_fetch_all($carousel, MYSQLI_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <title>Carousel</title>
</head>

<body>
    <?php require("common/navbar.php"); ?>

    <div id="alert">
        <?php echo $responce; ?>
    </div>
    <div class="text-center small">
        <!-- carousel table -->
        <div class="card mb-4 shadow">
            <div class="card-header">
                <h1>Carousel</h1>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addcarousel">
                    Add New Carousel
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table id="carouseltable" class="table table-striped table-hover table-bordered text-wrap">
                <thead>
                    <tr>
                        <th scope="col" style="display: none">id</th>
                        <th scope="col"></th>
                        <th scope="col">Lable</th>
                        <th scope="col">Description</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($carousel as $ca) {
                        $clable = $ca['clable'];
                        $cdisc = $ca["cdisc"];
                        $id = $ca['id'];
                        $image = $ca['image'];
                        echo
                        '<tr>
                        <td style="display: none">' . $id . '</td>
                        <td><img src="../images/carousel/' . $image . '" alt="..." height="100px" width="100px"></td>
                        <td>' . $clable . '</td>
                        <td>' . $cdisc . '</td>
                        <td><button type="button" class="btn btn-success" onclick="editcarousel(this)" data-bs-toggle="modal" data-bs-target="#editcarousel"><span class="material-icons">edit</span></button></td>
                        <td><button type="button" class="btn btn-danger" onclick="deletecarousel(this)" data-bs-toggle="modal" data-bs-target="#deletecarousel"><span class="material-icons">delete</span></button></td>
                    </tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>


    <!-- Modal for adding carousel -->
    <div class="modal fade" id="addcarousel" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel1">Add New Carousel</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="carousel.php" enctype="multipart/form-data" class="row g-3">
                        <div class="mb-3 col-12">
                            <label for="clable" class="form-label">Carousel Lable</label>
                            <input type="text" class="form-control" id="clable" name="clable" required>
                        </div>
                        <div class="mb-3 col-12">
                            <label for="cdisc" class="form-label">Carousel Description</label>
                            <input type="text" class="form-control" id="cdisc" name="cdisc" required>
                        </div>
                        <div class="mb-3 col-12">
                            <label for="cimage" class="form-label">Choose Carousel Image</label>
                            <input type="file" name="cimage" id="cimage" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="addcarousel">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal for updating carousel -->
    <div class="modal fade" id="editcarousel" tabindex="-1" aria-labelledby="exampleModalLabel3" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel3">Edit Carousel</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="carousel.php" enctype="multipart/form-data" class="row g-3">
                        <div class="mb-3 col-12">
                            <label for="editclable" class="form-label">Carousel Name</label>
                            <input type="text" class="form-control" id="editclable" name="editclable" readonly>
                        </div>
                        <div class="mb-3 d-none">
                            <input type="text" class="form-control" id="editid" name="editid" style="Display: none" readonly>
                        </div>
                        <div class="mb-3 col-12">
                            <label for="editcdisc" class="form-label">Carousel Description</label>
                            <input type="text" class="form-control" id="editcdisc" name="editcdisc">
                        </div>
                        <div class="mb-3 col-12">
                            <label for="editcimage" class="form-label">Select checkbox for updating image</label>
                            <input type="checkbox" name="editimage" id="editimage">
                            <input type="file" name="editcimage" id="editcimage">
                        </div>
                        <button type="submit" class="btn btn-primary" name="editcarousel">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- modal foe deleting carousel -->
    <div class="modal fade" id="deletecarousel" tabindex="-1" aria-labelledby="exampleModalLabel5" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel5">Delete Carousel</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="carousel.php" enctype="multipart/form-data" class="row g-3">
                        <div class="mb-3 d-none">
                            <input type="text" class="form-control" id="deleteid" name="deleteid" style="display: none">
                        </div>
                        <div class="mb-3 col-12">
                            <label for="deleteclable" class="form-label">Carousel Lable</label>
                            <input type="text" class="form-control" id="deleteclable" name="deleteclable" readonly>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">Please Press Delete Carousel to
                                Conform</label>
                        </div>
                        <button type="submit" class="btn btn-primary" name="deletecarousel">Delete Carousel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php require("common/script.php"); ?>

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js">
    </script>
    <script>
        $(document).ready(function() {
            $('#carouseltable').DataTable();
        });

        function editcarousel(item) {
            item = item.parentNode.parentNode;
            item = item.getElementsByTagName('td');
            document.getElementById('editclable').value = item[2].innerHTML;
            document.getElementById('editid').value = item[0].innerHTML;
            document.getElementById('editcdisc').value = item[3].innerHTML;
        }

        function deletecarousel(item) {
            item = item.parentNode.parentNode;
            item = item.getElementsByTagName('td');
            document.getElementById('deleteclable').value = item[2].innerHTML;
            document.getElementById('deleteid').value = item[0].innerHTML;
        }
    </script>
</body>

</html>