<?php
session_start();
if(!isset($_SESSION['logined']))
{
    header("Location: login.php");
}
require("common/database.php");
$responce = "";
$target_dir = "../online/images/";
// add new category
if (isset($_POST['addcategory'])) {
    $catname = $_POST['catname'];
    $imagename = str_replace(" ", "", $catname);
    $query = "SELECT * FROM `category` WHERE `catname` LIKE '$catname';";
    $result = mysqli_query($con, $query);
    $num = mysqli_num_rows($result);
    if ($num == 0) {
        $catdesc = $_POST['catdesc'];
        $check = getimagesize($_FILES["catimage"]["tmp_name"]);
        $target_file = $target_dir . basename($_FILES["catimage"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $target_file = $target_dir . $imagename . "." . $imageFileType;
        $imagename = $imagename . "." . $imageFileType;
        if ($check !== false) {
            if ($_FILES["catimage"]["size"] > 500000) {
                $responce =
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error! </strong>File size is too big
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            } else {
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "jfif") {
                    $responce =
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error! </strong>only JPG, JPEG, PNG & GIF files are allowed.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                } else {
                    if (move_uploaded_file($_FILES["catimage"]["tmp_name"], $target_file)) {
                        $query = "INSERT INTO `category` (`catid`, `catname`, `catdesc`, `image`) VALUES (NULL, '$catname', '$catdesc', '$imagename');";
                        $result = mysqli_query($con, $query);
                        if ($result) {
                            $responce =
                                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Sucess! </strong>Category added sucessfully
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                        } else {
                            $responce =
                                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error! </strong>Cannot add category
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
        <strong>Error! </strong>Category already exists
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
}
//update category
if (isset($_POST['editcategory'])) {
    $catid = $_POST['editcatid'];
    $catdesc = $_POST['editcatdesc'];
    $query = "UPDATE `category` SET `catdesc` = '$catdesc' WHERE `category`.`catid` = '$catid';";
    $result = mysqli_query($con, $query);
    if ($result) {
        $responce =
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Sucess! </strong>category updated sucessfully
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    } else {
        $responce =
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error! </strong>Cannot update category
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
}
//delete category
if (isset($_POST['deletecategory'])) {
    $catid = $_POST['deletecatid'];
    $query = "DELETE FROM `category` WHERE `category`.`catid` = $catid;";
    $result = mysqli_query($con, $query);
    if ($result) {
        $responce =
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Sucess! </strong>category deleted sucessfully
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    } else {
        $responce =
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error! </strong>Cannot delete category
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
}

// category list
$query = "SELECT * FROM `category`";
$category = mysqli_query($con, $query);
$category = mysqli_fetch_all($category, MYSQLI_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

    <title>Categories</title>
</head>

<body>
    <?php require("common/navbar.php"); ?>

    <div class="container text-center small">
        <div id="alert">
            <?php echo $responce; ?>
        </div>
        <!-- category table -->
        <div class="shadow border-4 p-2">
            <div class="card my-4 shadow">
                <div class="card-header">
                    <h1>Categories</h1>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addcat">
                        Add New category
                    </button>
                </div>
            </div>
            <div class="table-responsive mw-100">
                <table id="categorytable" class="table table-striped table-hover table-bordered text-wrap">
                    <thead>
                        <tr>
                            <th scope="col">SNo.</th>
                            <th scope="col" style="display: none">Catid</th>
                            <th scope="col">Category Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Edit Description</th>
                            <th scope="col">delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sno = 1;
                        foreach ($category as $cat) {
                            $catname = $cat['catname'];
                            $catdesc = $cat["catdesc"];
                            $catid = $cat['catid'];
                            echo
                            '<tr>
                                <td scope="row">' . $sno . '</td>
                                <td style="display: none">' . $catid . '</td>
                                <td>' . $catname . '</td>
                                <td>' . $catdesc . '</td>
                                <td><button type="button" class="btn btn-success" onclick="editcategory(this)" data-bs-toggle="modal" data-bs-target="#editcategory">Edit Description</button></td>
                                <td><button type="button" class="btn btn-danger" onclick="deletecategory(this)" data-bs-toggle="modal" data-bs-target="#deletecategory">Delete</button></td>
                            </tr>';
                            $sno = $sno + 1;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for adding category -->
    <div class="modal fade" id="addcat" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel1">Add New Category</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="category.php" enctype="multipart/form-data" class="row g-3">
                        <div class="mb-3 col-12">
                            <label for="catname" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="catname" name="catname" required>
                        </div>
                        <div class="mb-3 col-12">
                            <label for="catdesc" class="form-label">Category Description</label>
                            <input type="text" class="form-control" id="catdesc" name="catdesc" required>
                        </div>
                        <div class="mb-3 col-12">
                            <label for="catimage" class="form-label">Choose Category image</label>
                            <input type="file" name="catimage" id="catimage" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="addcategory">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal for updating category -->
    <div class="modal fade" id="editcategory" tabindex="-1" aria-labelledby="exampleModalLabel3" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel3">Edit Category Description</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="category.php" enctype="multipart/form-data" class="row g-3">
                        <div class="mb-3 col-12">
                            <label for="editcategoryname" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="editcategoryname" name="editcategoryname" readonly>
                        </div>
                        <div class="mb-3 d-none">
                            <input type="text" class="form-control" id="editcatid" name="editcatid" style="Display: none" readonly>
                        </div>
                        <div class="mb-3 col-12">
                            <label for="editcatdesc" class="form-label">Category Description</label>
                            <input type="text" class="form-control" id="editcatdesc" name="editcatdesc">
                        </div>
                        <button type="submit" class="btn btn-primary" name="editcategory">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- modal foe deleting category -->
    <div class="modal fade" id="deletecategory" tabindex="-1" aria-labelledby="exampleModalLabel5" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel5">Delete Category</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="category.php" enctype="multipart/form-data" class="row g-3">
                        <div class="mb-3 d-none">
                            <input type="text" class="form-control" id="deletecatid" name="deletecatid" style="display: none">
                        </div>
                        <div class="mb-3 col-12">
                            <label for="deletecategoryname" class="form-label">Category</label>
                            <input type="text" class="form-control" id="deletecategoryname" name="deletecategoryname" readonly>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">Please Press Delete category to
                                Conform</label>
                        </div>
                        <button type="submit" class="btn btn-primary" name="deletecategory">Delete Category</button>
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
            $('#categorytable').DataTable();
        });

        function editcategory(item) {
            item = item.parentNode.parentNode;
            item = item.getElementsByTagName('td');
            document.getElementById('editcategoryname').value = item[2].innerHTML;
            document.getElementById('editcatid').value = item[1].innerHTML;
            document.getElementById('editcatdesc').value = item[3].innerHTML;
        }

        function deletecategory(item) {
            item = item.parentNode.parentNode;
            item = item.getElementsByTagName('td');
            document.getElementById('deletecategoryname').value = item[2].innerHTML;
            document.getElementById('deletecatid').value = item[1].innerHTML;
        }
    </script>
</body>

</html>