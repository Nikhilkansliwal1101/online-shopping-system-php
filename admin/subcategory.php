<?php
session_start();
if(!isset($_SESSION['logined']))
{
    header("Location: index.php");
}
$responce="";
$target_dir = "../online/images/";
require("common/database.php");

// add new subcategory
if (isset($_POST['addsubcategory'])) {
    $subcatname = $_POST['subcatname'];
    $imagename = str_replace(" ", "", $subcatname);
    $catid = $_POST['subtablecatid'];
    $query = "SELECT * FROM `subcategory` WHERE `name` LIKE '$subcatname' and 'catid' = '$catid';";
    $result = mysqli_query($con, $query);
    $num = mysqli_num_rows($result);
    if ($num == 0) {
        $check = getimagesize($_FILES["subcatimage"]["tmp_name"]);
        $target_file = $target_dir . basename($_FILES["subcatimage"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $target_file = $target_dir . $imagename . "." . $imageFileType;
        $imagename = $imagename . "." . $imageFileType;
        if ($check !== false) {
            if ($_FILES["subcatimage"]["size"] > 500000) {
                $responce=
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error! </strong>File size is too big
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            } else {
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "jfif") {
                    $responce=
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error! </strong>only JPG, JPEG, PNG & GIF files are allowed.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                } else {
                    if (move_uploaded_file($_FILES["subcatimage"]["tmp_name"], $target_file)) {
                        $query = "INSERT INTO `subcategory` (`subcatid`,`name`, `catid`, `image`) VALUES (NULL, '$subcatname', '$catid', '$imagename');";
                        $result = mysqli_query($con, $query);
                        if ($result) {
                            $responce=
                            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Sucess! </strong>Sub Category addes sucessfully
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                        } else {
                            $responce=
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error! </strong>Cannot add Sub Category
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                        }
                    } else {
                        $responce=
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error! </strong>Error in uploading file.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }
                }
            }
        } else {
            $responce=
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error! </strong>Please select an image
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    } else {
        $responce=
        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error! </strong>Sub Category already exists
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
}
//update subcategory
if (isset($_POST['editsubcategory'])) {
    $subcatid = $_POST['editsubcatid'];
    $catid = $_POST['editsubtablecatid'];
    $query = "UPDATE `subcategory` SET `catid` = '$catid' WHERE `subcategory`.`subcatid` = '$subcatid';";
    $result = mysqli_query($con, $query);
    if ($result) {
        $responce=
        '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Sucess! </strong>category updated sucessfully
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    } else {
        $responce=
        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error! </strong>Cannot update category
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
}
//delete subcategory
if (isset($_POST['deletesubcategory'])) {
    $subcatid = $_POST['deletesubcatid'];
    $query = "DELETE FROM `subcategory` WHERE `subcategory`.`subcatid` = $subcatid;";
    $result = mysqli_query($con, $query);
    if ($result) {
        $responce=
        '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Sucess! </strong>category deleted sucessfully
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    } else {
        $responce=
        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error! </strong>Cannot delete category
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
}

//update nullcatsubcategory
if (isset($_POST['editnullcatsubcategory'])) {
    $subcatid = $_POST['editnullcatsubcatid'];
    $catid = $_POST['editnullcatsubtablecatid'];
    $query = "UPDATE `subcategory` SET `catid` = '$catid' WHERE `subcategory`.`subcatid` = '$subcatid';";
    $result = mysqli_query($con, $query);
    if ($result) {
        $responce=
        '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Sucess! </strong>category updated sucessfully
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    } else {
        $responce=
        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error! </strong>Cannot update category
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
}
//delete nullcatsubcategory
if (isset($_POST['deletenullcatsubcategory'])) {
    $subcatid = $_POST['deletenullcatsubcatid'];
    $query = "DELETE FROM `subcategory` WHERE `subcategory`.`subcatid` = $subcatid;";
    $result = mysqli_query($con, $query);
    if ($result) {
        $responce=
        '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Sucess! </strong>category deleted sucessfully
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    } else {
        $responce=
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

    <title>Subcategories</title>
</head>

<body>
    <?php require("common/navbar.php"); ?>
    <div id="alert">
        <?php echo $responce; ?>
    </div>

    <div class="text-center small">
        <!-- subcategory table -->
        <div class="shadow border-4 p-2">
            <div class="card my-4 shadow">
                <div class="card-header">
                    <h1>Subcategories</h1>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addsubcat">
                        Add New subcategory
                    </button>
                </div>
                <div class="card-body">
                    <label for="selectcat" class="form-label">Select category</label>
                    <select id="selectcat" class="form-select" aria-label="Default select example" onchange="getsubcategorytable(this.value)">
                        <?php
                        echo "<option selected>Select category</option>";
                        echo "<option value=0>All categories</option>";
                        foreach ($category as $cat) {
                            echo "<option value=" . $cat['catid'] . ">" . $cat['catname'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="table-responsive mw-100">
                <table id="subcategorytable" class="table table-striped table-hover table-bordered text-wrap">
                    <thead>
                        <tr>
                            <th scope="col" style="display: none">Catid</th>
                            <th scope="col">Category</th>
                            <th scope="col" style="display: none">SubCatid</th>
                            <th scope="col">Name</th>
                            <th scope="col">Change category</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody id="subcat">

                    </tbody>
                </table>
            </div>
        </div>

        <!-- NULL category subcategory table -->
        <div class="shadow border-4 p-2" id="nullcat">
            <div class="card my-4 shadow">
                <div class="card-header">
                    <h1>Subcategories with No category</h1>
                </div>
            </div>
            <div class="table-responsive mw-100">
                <table id="nullcatsubcategorytable" class="table table-striped table-hover table-bordered text-wrap">
                    <thead>
                        <tr>
                            <th scope="col" style="display: none">SubCatid</th>
                            <th scope="col">Name</th>
                            <th scope="col">Set category</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody id="nullcatsubcat">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for adding subcategory -->
    <div class="modal fade" id="addsubcat" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel1">Add New Sub Category</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="subcategory.php" enctype="multipart/form-data" class="row g-3">
                        <div class="mb-3 col-12">
                            <label for="subcatname" class="form-label">Sub Category Name</label>
                            <input type="text" class="form-control" id="subcatname" name="subcatname" required>
                        </div>
                        <div class="mb-3 col-12">
                            <label for="subtablecatid" class="form-label">Choose Category name</label>
                            <select class="form-select" aria-label="Default select example" name='subtablecatid'>
                                <?php
                                foreach ($category as $cat) {
                                    echo "<option value=" . $cat['catid'] . ">" . $cat['catname'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3 col-12">
                            <label for="subcatimage" class="form-label">Choose Sub Category image</label>
                            <input type="file" name="subcatimage" id="subcatimage" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="addsubcategory">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- model for updating subcategory -->
    <div class="modal fade" id="editsubcat" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel2">Change category of Sub Category</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="subcategory.php" enctype="multipart/form-data" class="row g-3">
                        <div class="mb-3 col-12">
                            <label for="editsubcatname" class="form-label">Sub Category Name</label>
                            <input type="text" class="form-control" id="editsubcatname" name="editsubcatname" readonly>
                        </div>
                        <div class="mb-3 d-none">
                            <input type="text" class="form-control" id="editsubcatid" name="editsubcatid" style="display: none">
                        </div>
                        <div class="mb-3 col-12">
                            <label for="editsubtablecatid" class="form-label">Change Category name</label>
                            <select class="form-select" aria-label="Default select example" id="editsubtablecatid" name="editsubtablecatid">
                                <?php
                                foreach ($category as $cat) {
                                    echo "<option value=" . $cat['catid'] . ">" . $cat['catname'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" name="editsubcategory">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- modal foe deleting subcategory-->
    <div class="modal fade" id="deletesubcategory" tabindex="-1" aria-labelledby="exampleModalLabel3" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel3">Delete Subcategory</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="subcategory.php" enctype="multipart/form-data" class="row g-3">
                        <div class="mb-3 d-none">
                            <input type="text" class="form-control" id="deletesubcatid" name="deletesubcatid" style="display: none">
                        </div>
                        <div class="mb-3 col-12">
                            <label for="deletecategorynameofsubcategory" class="form-label">Category</label>
                            <input type="text" class="form-control" id="deletecategorynameofsubcategory" name="deletecategorynameofsubcategory" readonly>
                        </div>
                        <div class="mb-3 col-12">
                            <label for="deletesubcategoryname" class="form-label">Subcategory</label>
                            <input type="text" class="form-control" id="deletesubcategoryname" name="deletesubcategoryname" readonly>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">Please Press Delete subcategory to
                                Conform</label>
                        </div>
                        <button type="submit" class="btn btn-primary" name="deletesubcategory">Delete
                            Subcategory</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- model for updating nullcatsubcategory -->
    <div class="modal fade" id="editnullcatsubcat" tabindex="-1" aria-labelledby="exampleModalLabel4" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel4">Set category for Sub Category</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="subcategory.php" enctype="multipart/form-data" class="row g-3">
                        <div class="mb-3 col-12">
                            <label for="editnullcatsubcatname" class="form-label">Sub Category Name</label>
                            <input type="text" class="form-control" id="editnullcatsubcatname" name="editnullcatsubcatname" readonly>
                        </div>
                        <div class="mb-3 col-12">
                            <input type="text" class="form-control" id="editnullcatsubcatid" name="editnullcatsubcatid" style="display: none">
                        </div>
                        <div class="mb-3 col-12">
                            <label for="editsubtablecatid" class="form-label">Set Category name</label>
                            <select class="form-select" aria-label="Default select example" id="editnullcatsubtablecatid" name="editnullcatsubtablecatid">
                                <?php
                                foreach ($category as $cat) {
                                    echo "<option value=" . $cat['catid'] . ">" . $cat['catname'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" name="editnullcatsubcategory">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- modal for0 deleting nullcatsubcategory-->
    <div class="modal fade" id="deletenullcatsubcategory" tabindex="-1" aria-labelledby="exampleModalLabel5" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel5">Delete Subcategory</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="subcategory.php" enctype="multipart/form-data" class="row g-3">
                        <div class="mb-3 d-none">
                            <input type="text" class="form-control" id="deletenullcatsubcatid" name="deletenullcatsubcatid" style="display: none">
                        </div>
                        <div class="mb-3 col-12">
                            <label for="deletenullcatsubcategoryname" class="form-label">Subcategory</label>
                            <input type="text" class="form-control" id="deletenullcatsubcategoryname" name="deletenullcatsubcategoryname" readonly>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">Please Press Delete subcategory to
                                Conform</label>
                        </div>
                        <button type="submit" class="btn btn-primary" name="deletenullcatsubcategory">Delete
                            Subcategory</button>
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
            $('#subcategorytable').DataTable();
            $('#nullcatsubcategorytable').DataTable();
            getsubcategorytable(0);
            getnullcatsubcategorytable();
        });

        function getsubcategorytable(catid) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {

                if (this.readyState == 4 && this.status == 200) {
                    var table = $('#subcategorytable').DataTable();
                    table.destroy();
                    document.getElementById("subcat").innerHTML =
                        this.responseText;
                    $('#subcategorytable').DataTable();
                }
            };
            xhttp.open("GET", "list.php?list=subcat&table=1&catid=" + catid, true);
            xhttp.send();
        }

        function getnullcatsubcategorytable() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {

                if (this.readyState == 4 && this.status == 200) {
                    var table = $('#nullcatsubcategorytable').DataTable();
                    table.destroy();
                    document.getElementById("nullcatsubcat").innerHTML =
                        this.responseText;
                    $('#nullcatsubcategorytable').DataTable();
                }
            };
            xhttp.open("GET", "list.php?list=nullsubcat", true);
            xhttp.send();
        }

        function editsubcategory(item) {
            item = item.parentNode.parentNode;
            item = item.getElementsByTagName('td');
            document.getElementById('editsubcatname').value = item[3].innerHTML;
            document.getElementById('editsubcatid').value = item[2].innerHTML;
            document.getElementById('editsubtablecatid').value = item[0].innerHTML;
        }

        function deletesubcategory(item) {
            item = item.parentNode.parentNode;
            item = item.getElementsByTagName('td');
            document.getElementById('deletecategorynameofsubcategory').value = item[1].innerHTML;
            document.getElementById('deletesubcategoryname').value = item[3].innerHTML;
            document.getElementById('deletesubcatid').value = item[2].innerHTML;
        }

        function editnullcatsubcategory(item) {
            item = item.parentNode.parentNode;
            item = item.getElementsByTagName('td');
            document.getElementById('editnullcatsubcatname').value = item[1].innerHTML;
            document.getElementById('editnullcatsubcatid').value = item[0].innerHTML;
        }

        function deletenullcatsubcategory(item) {
            item = item.parentNode.parentNode;
            item = item.getElementsByTagName('td');
            document.getElementById('deletenullcatsubcategoryname').value = item[1].innerHTML;
            document.getElementById('deletenullcatsubcatid').value = item[0].innerHTML;
        }
    </script>
</body>

</html>