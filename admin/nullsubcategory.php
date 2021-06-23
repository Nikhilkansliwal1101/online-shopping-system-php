<?php
session_start();
if (!isset($_SESSION['adminid'])) {
    header("Location: index.php");
}
$responce = "";
$target_dir = "../images/subcategory/";
require("common/database.php");


//update nullcatsubcategory
if (isset($_POST['editsubcategory'])) {
    $subcatid = $_POST['editsubcatid'];
    $catid = $_POST['editcatid'];
    $query = "UPDATE `subcategory` SET `catid` = '$catid' WHERE `subcategory`.`subcatid` = '$subcatid';";
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
//delete nullcatsubcategory
if (isset($_POST['deletesubcategory'])) {
    $subcatid = $_POST['deletesubcatid'];
    $query = "DELETE FROM `subcategory` WHERE `subcategory`.`subcatid` = $subcatid;";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <title>Subcategories</title>
</head>

<body>
    <?php require("common/navbar.php"); ?>
    <div id="alert">
        <?php echo $responce; ?>
    </div>

    <div class="text-center small">
        <!-- NULL category subcategory table -->
        <div>
            <div class="card mb-4 shadow">
                <div class="card-header">
                    <h1>Subcategories with No category</h1>
                </div>
            </div>
            <div class="table-responsive">
                <table id="subcategorytable" class="table table-striped table-hover table-bordered text-wrap">
                    <thead>
                        <tr>
                            <th scope="col" style="display: none">SubCatid</th>
                            <th scope="col"></th>
                            <th scope="col">Name</th>
                            <th scope="col">Set category</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody id="subcat">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- model for updating nullcatsubcategory -->
    <div class="modal fade" id="editsubcat" tabindex="-1" aria-labelledby="exampleModalLabel4" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel4">Set category for Sub Category</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="nullsubcategory.php" enctype="multipart/form-data" class="row g-3">
                        <div class="mb-3 col-12">
                            <label for="editsubcatname" class="form-label">Sub Category Name</label>
                            <input type="text" class="form-control" id="editsubcatname" name="editsubcatname" readonly>
                        </div>
                        <div class="mb-3 col-12">
                            <input type="text" class="form-control" id="editsubcatid" name="editsubcatid"
                                style="display: none">
                        </div>
                        <div class="mb-3 col-12">
                            <label for="editcatid" class="form-label">Set Category name</label>
                            <select class="form-select" aria-label="Default select example" id="editcatid"
                                name="editcatid">
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

    <!-- modal for deleting nullcatsubcategory-->
    <div class="modal fade" id="deletesubcat" tabindex="-1" aria-labelledby="exampleModalLabel5" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel5">Delete Subcategory</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="nullsubcategory.php" enctype="multipart/form-data" class="row g-3">
                        <div class="mb-3 d-none">
                            <input type="text" class="form-control" id="deletesubcatid" name="deletesubcatid"
                                style="display: none">
                        </div>
                        <div class="mb-3 col-12">
                            <label for="deletesubcatname" class="form-label">Subcategory</label>
                            <input type="text" class="form-control" id="deletesubcatname" name="deletesubcatname"
                                readonly>
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
    <?php require("common/script.php"); ?>

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js">
    </script>
    <script>
    $(document).ready(function() {
        getsubcategorytable();
    });

    function getsubcategorytable() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {

            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("subcat").innerHTML =
                    this.responseText;
                $('#subcategorytable').DataTable();
            }
        };
        xhttp.open("GET", "list.php?list=nullsubcat", true);
        xhttp.send();
    }

    function editsubcategory(item) {
        item = item.parentNode.parentNode;
        item = item.getElementsByTagName('td');
        document.getElementById('editsubcatname').value = item[2].innerHTML;
        document.getElementById('editsubcatid').value = item[0].innerHTML;
    }

    function deletesubcategory(item) {
        item = item.parentNode.parentNode;
        item = item.getElementsByTagName('td');
        document.getElementById('deletesubcatname').value = item[2].innerHTML;
        document.getElementById('deletesubcatid').value = item[0].innerHTML;
    }
    </script>
</body>

</html>