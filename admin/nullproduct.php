<?php
session_start();
if (!isset($_SESSION['adminid'])) {
    header("Location: login.php");
}
$target_dir = "../images/product/";
$responce = "";
require("common/database.php");

//update null product
if (isset($_POST['editproduct'])) {
    $subcatid = $_POST['editsubcatid'];
    $productno = $_POST['editproductno'];
    $query = "UPDATE `product` SET `subcatid`='$subcatid' WHERE `productno`= '$productno';";
    $result = mysqli_query($con, $query);
    if ($result) {
        $responce =
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Sucess! </strong>Product updated sucessfully
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    } else {
        $responce =
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error! </strong>Cannot update Product
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
}
// delete null product
if (isset($_POST['deleteproduct'])) {
    $query = "DELETE FROM `product` WHERE `product`.`productno` = " . $_POST['deleteproductno'] . ";";
    $result = mysqli_query($con, $query);
    if ($result) {
        $responce =
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Sucess! </strong>Product deleted sucessfully
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    } else {
        $responce =
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error! </strong>Cannot delete Product
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
}
// category list
$query = "SELECT * FROM `category`";
$category = mysqli_query($con, $query);
$category = mysqli_fetch_all($category, MYSQLI_ASSOC);

$query = "SELECT * FROM `subcategory`;";
$subcategory = mysqli_query($con, $query);
$subcategory = mysqli_fetch_all($subcategory, MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

    <title>Products</title>
</head>

<body>
    <?php require("common/navbar.php"); ?>
    <div id="alert">
        <?php echo $responce; ?>
    </div>

    <div class="text-center small">
        <!-- null product table -->
        <div>
            <div class="card my-4 shadow">
                <div class="card-header">
                    <h1>Products With Null Subcategory</h1>
                </div>
            </div>
            <div class="table-responsive mw-100">
                <table id="producttable" class="table table-striped table-hover table-bordered text-wrap">
                    <thead>
                        <tr>
                            <th scope="col" style="display: none">Productno</th>
                            <th scope="col"></th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Set</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody id="product">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for updating null product -->
    <div class="modal fade" id="editproduct" tabindex="-1" aria-labelledby="exampleModalLabel4" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel4">Set Product category and subcategory</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="nullproduct.php" enctype="multipart/form-data" class="row g-3">
                        <div class="mb-2 col-12">
                            <label for="editproductname" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="editproductname" name="editproductname" readonly>
                        </div>
                        <div class="mb-2 col-12">
                            <input type="text" class="form-control" id="editproductno" name="editproductno" style="Display: none" readonly>
                        </div>
                        <div class="mb-2 col-6">
                            <label for="editselectcate" class="form-label">Select category</label>
                            <select id="editselectcate" class="form-select" aria-label="Default select example" onchange="getsubcategorydropdown(this.value)" name="editcatid">
                                <?php
                                echo "<option  selected value=0>select</option>";
                                foreach ($category as $cat) {
                                    echo "<option value=" . $cat['catid'] . ">" . $cat['catname'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-2 col-6">
                            <label for="editselectsubcategory" class="form-label">Select Sub Category</label>
                            <select id="editselectsubcategory" class="form-select" aria-label="Default select example" name="editsubcatid" required>
                                <?php
                                echo "<option  selected value=0>select</option>";
                                foreach ($subcategory as $subcat) {
                                    echo "<option value=" . $subcat['subcatid'] . ">" . $subcat['name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" name="editproduct">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- modal foe deleting null product -->
    <div class="modal fade" id="deleteproduct" tabindex="-1" aria-labelledby="exampleModalLabel5" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel5">Delete Product</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="nullproduct.php" enctype="multipart/form-data">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="deleteproductno" name="deleteproductno" style="display: none">
                        </div>
                        <div class="mb-3">
                            <label for="deleteproductname" class="form-label">Product</label>
                            <input type="text" class="form-control" id="deleteproductname" name="deleteproductname" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Please Press Delete Product to
                                Conform</label>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary" name="deleteproduct">Delete
                                Product</button>
                        </div>
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
            getproduct()
        });

        function getproduct() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {

                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("product").innerHTML =
                        this.responseText;
                    $('#producttable').DataTable();
                }
            };
            xhttp.open("GET", "list.php?list=nullproduct", true);
            xhttp.send();
        }

        function getsubcategorydropdown(catid) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("editselectsubcategory").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "list.php?list=subcat&dropdown=1&catid=" + catid, true);
            xhttp.send();
        }

        function deleteproduct(item) {
            item = item.parentNode.parentNode;
            item = item.getElementsByTagName('td');
            document.getElementById('deleteproductno').value = item[0].innerHTML;
            document.getElementById('deleteproductname').value = item[2].innerHTML;
        }

        function editproduct(item) {
            item = item.parentNode.parentNode;
            item = item.getElementsByTagName('td');
            document.getElementById('editproductno').value = item[0].innerHTML;
            document.getElementById('editproductname').value = item[2].innerHTML;
        }
    </script>
</body>

</html>