<?php
session_start();
if(!isset($_SESSION['logined']))
{
    header("Location: login.php");
}
$target_dir = "../online/images/";
$responce = "";
require("common/database.php");


//add new product
if (isset($_POST['addproduct'])) {
    $productname = $_POST['productname'];
    $catid = $_POST['catid'];
    $subcatid = $_POST['subcatid'];
    $query = "SELECT * FROM `product` WHERE `productid` LIKE '$productname' and 'subcatid' = '$subcatid';";
    $result = mysqli_query($con, $query);
    $num = mysqli_num_rows($result);
    if ($num == 0) {
        $imagename = str_replace(" ", "", $productname);
        $offer = $_POST['offer'];
        $purchaseprice = $_POST['purchaseprice'];
        $sellprice = $_POST['sellprice'];
        $mrp = $_POST['mrp'];
        $cgst = $_POST['cgst'];
        $sgst = $_POST['sgst'];
        $available = $_POST['avaliable'];
        $check = getimagesize($_FILES["productimage"]["tmp_name"]);
        $target_file = $target_dir . basename($_FILES["productimage"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $target_file = $target_dir . $imagename . "." . $imageFileType;
        $imagename = $imagename . "." . $imageFileType;
        if ($check !== false) {
            if ($_FILES["productimage"]["size"] > 500000) {
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
                    if (move_uploaded_file($_FILES["productimage"]["tmp_name"], $target_file)) {
                        $query = "INSERT INTO `product` (`productno`, `productid`, `catid`, `sellunit`, `image`, `subcatid`, `available`, `purchaseprice`, `sellprice`, `mrp`, `offer`, `cgst`, `sgst`) VALUES (NULL, '$productname', '$catid', '0', '$imagename', '$subcatid', '$available', '$purchaseprice', '$sellprice', '$mrp', '$offer', '$cgst', '$sgst');";
                        $result = mysqli_query($con, $query);
                        if ($result) {
                            $responce =
                                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Sucess! </strong>Product added sucessfully
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                        } else {
                            $responce =
                                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error! </strong>Not able to add Product
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
        <strong>Error! </strong>Product already exists
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
}
//update product
if (isset($_POST['editproduct'])) {
    $catid = $_POST['editcatid'];
    $subcatid = $_POST['editsubcatid'];
    $offer = $_POST['editoffer'];
    $purchaseprice = $_POST['editpurchaseprice'];
    $sellprice = $_POST['editsellprice'];
    $mrp = $_POST['editmrp'];
    $cgst = $_POST['editcgst'];
    $sgst = $_POST['editsgst'];
    $add = $_POST['editadd'];
    $productno = $_POST['editproductno'];
    $query = "UPDATE `product` SET `catid`='$catid', `subcatid`='$subcatid', `available`=`available`+'$add', `purchaseprice`='$purchaseprice', `sellprice`='$sellprice', `mrp`='$mrp', `offer`='$offer', `cgst`='$cgst', `sgst`='$sgst' WHERE `productno`= $productno;";
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
// delete product
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
//update null product
if (isset($_POST['editnullproduct'])) {
    $catid = $_POST['editnullcatid'];
    $subcatid = $_POST['editnullsubcatid'];
    $productno = $_POST['editnullproductno'];
    $query = "UPDATE `product` SET `catid`='$catid', `subcatid`='$subcatid' WHERE `productno`= '$productno';";
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
if (isset($_POST['deletenullproduct'])) {
    $query = "DELETE FROM `product` WHERE `product`.`productno` = " . $_POST['deletenullproductno'] . ";";
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

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

    <title>Products</title>
</head>

<body>
    <?php require("common/navbar.php"); ?>
    <div id="alert">
        <?php echo $responce; ?>
    </div>

    <div class="container text-center small">
        <!-- product table -->
        <div class="shadow border-4 p-2">
            <div class="card my-4 shadow">
                <div class="card-header">
                    <h1>Products</h1>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addproduct">
                        Add New Product
                    </button>
                </div>
                <div class="card-body row">
                    <div class="col-md-6">
                        <label for="selectcate" class="form-label">Select category</label>
                        <select id="selectcate" class="form-select" aria-label="Default select example" onchange="getsubcategorydropdown(this.value,'table')">
                            <?php
                            echo "<option selected value=0>Select category</option>";
                            echo "<option value=0>All category</option>";
                            foreach ($category as $cat) {
                                echo "<option value=" . $cat['catid'] . ">" . $cat['catname'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="selectsubcat" class="form-label">Select Sub Category</label>
                        <select id="selectsubcat" class="form-select" aria-label="Default select example" onchange="getproducttable(this.value)">
                            <option selected value='cat0'>Select Sub Category</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="table-responsive mw-100">
                <table id="producttable" class="table table-striped table-hover table-bordered text-wrap">
                    <thead>
                        <tr>
                            <th scope="col">SNo.</th>
                            <th scope="col" style="display: none">Catid</th>
                            <th scope="col" style="display: none">SubCatid</th>
                            <th scope="col" style="display: none">Productno</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Purchase Price</th>
                            <th scope="col">Sell Price</th>
                            <th scope="col">MRP</th>
                            <th scope="col">Available</th>
                            <th scope="col">CGST</th>
                            <th scope="col">SGST</th>
                            <th scope="col">Offer</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="product">

                    </tbody>
                </table>
            </div>
        </div>

        <!-- null product table -->
        <div class="shadow border-4 p-2" id="nullpro">
            <div class="card my-4 shadow">
                <div class="card-header">
                    <h1>Products with No category or subcategory</h1>
                </div>
            </div>
            <div class="table-responsive mw-100">
                <table id="nullproducttable" class="table table-striped table-hover table-bordered text-wrap">
                    <thead>
                        <tr>
                            <th scope="col">SNo.</th>
                            <th scope="col" style="display: none">Productno</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Set</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody id="nullproduct">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for adding product -->
    <div class="modal fade" id="addproduct" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel1">Add New Product</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="product.php" enctype="multipart/form-data" class="row g-3">
                        <div class="mb-2 col-12">
                            <label for="productname" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="productname" name="productname" required>
                        </div>
                        <div class="mb-2 col-6">
                            <label for="selectcategory" class="form-label">Select category</label>
                            <select id="selectcategory" class="form-select" aria-label="Default select example" onchange="getsubcategorydropdown(this.value,'form')" name="catid" required>
                                <?php
                                echo "<option selected>Select category</option>";
                                foreach ($category as $cat) {
                                    echo "<option value=" . $cat['catid'] . ">" . $cat['catname'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-2 col-6">
                            <label for="selectsubcategory" class="form-label">Select Sub Category</label>
                            <select id="selectsubcategory" class="form-select" aria-label="Default select example" name="subcatid" required>
                                <option selected>Select Sub Category</option>
                            </select>
                        </div>
                        <div class="mb-2 col-12">
                            <label for="offer" class="form-label">Offer</label>
                            <input type="text" class="form-control" id="offer" name="offer">
                        </div>
                        <div class="mb-2 col-4">
                            <label for="purchaseprice" class="form-label">Buy Price</label>
                            <input type="number" step="0.01" class="form-control" id="purchaseprice" name="purchaseprice" required>
                        </div>
                        <div class="mb-2 col-4">
                            <label for="sellprice" class="form-label">Sell Price</label>
                            <input type="number" step="0.01" class="form-control" id="sellprice" name="sellprice" required>
                        </div>
                        <div class="mb-2 col-4">
                            <label for="mrp" class="form-label">MRP</label>
                            <input type="number" step="0.01" class="form-control" id="mrp" name="mrp" required>
                        </div>
                        <div class="mb-2 col-4">
                            <label for="cgst" class="form-label">CGST</label>
                            <input type="number" step="0.1" class="form-control" id="cgst" name="cgst" required>
                        </div>
                        <div class="mb-2 col-4">
                            <label for="sgst" class="form-label">SGST</label>
                            <input type="number" step="0.1" class="form-control" id="sgst" name="sgst" required>
                        </div>
                        <div class="mb-2 col-4">
                            <label for="avaliable" class="form-label">Avaliable</label>
                            <input type="number" class="form-control" id="avaliable" name="avaliable" required>
                        </div>
                        <div class="mb-2 col-12">
                            <label for="productimage" class="form-label">Choose Product image</label>
                            <input type="file" name="productimage" id="productimage" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="addproduct">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for updating product -->
    <div class="modal fade" id="editproduct" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel2">Edit Product</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="product.php" enctype="multipart/form-data" class="row g-3">
                        <div class="mb-2 col-12">
                            <label for="editproductname" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="editproductname" name="editproductname" readonly>
                        </div>
                        <div class="mb-2 col-12">
                            <input type="text" class="form-control" id="editproductno" name="editproductno" style="Display: none" readonly>
                        </div>
                        <div class="mb-2 col-6">
                            <label for="editselectcate" class="form-label">Select category</label>
                            <select id="editselectcate" class="form-select" aria-label="Default select example" onchange="getsubcategorydropdown(this.value,'eform')" name="editcatid" required>
                                <?php
                                echo "<option selected>Select category</option>";
                                foreach ($category as $cat) {
                                    echo "<option value=" . $cat['catid'] . ">" . $cat['catname'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-2 col-6">
                            <label for="editselectsubcategory" class="form-label">Select Sub Category</label>
                            <select id="editselectsubcategory" class="form-select" aria-label="Default select example" name="editsubcatid" required>
                                <option selected>Select Sub Category</option>
                            </select>
                        </div>
                        <div class="mb-2 col-12">
                            <label for="editoffer" class="form-label">Offer</label>
                            <input type="text" class="form-control" id="editoffer" name="editoffer">
                        </div>
                        <div class="mb-2 col-4">
                            <label for="editpurchaseprice" class="form-label">Buy Price</label>
                            <input type="number" step="0.01" class="form-control" id="editpurchaseprice" name="editpurchaseprice" required>
                        </div>
                        <div class="mb-2 col-4">
                            <label for="editsellprice" class="form-label">Sell Price</label>
                            <input type="number" step="0.01" class="form-control" id="editsellprice" name="editsellprice" required>
                        </div>
                        <div class="mb-2 col-4">
                            <label for="editmrp" class="form-label">MRP</label>
                            <input type="number" step="0.01" class="form-control" id="editmrp" name="editmrp" required>
                        </div>
                        <div class="mb-2 col-4">
                            <label for="editcgst" class="form-label">CGST</label>
                            <input type="number" step="0.1" class="form-control" id="editcgst" name="editcgst" required>
                        </div>
                        <div class="mb-2 col-4">
                            <label for="editsgst" class="form-label">SGST</label>
                            <input type="number" step="0.1" class="form-control" id="editsgst" name="editsgst" required>
                        </div>
                        <div class="mb-2 col-4">
                            <label for="editadd" class="form-label">ADD ITEMs</label>
                            <input type="number" class="form-control" id="editadd" name="editadd" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="editproduct">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- modal foe deleting product -->
    <div class="modal fade" id="deleteproduct" tabindex="-1" aria-labelledby="exampleModalLabel3" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel3">Delete Product</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="product.php" enctype="multipart/form-data">
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
                            <button type="submit" class="btn btn-primary" name="deleteproduct">Delete Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for updating null product -->
    <div class="modal fade" id="editnullproduct" tabindex="-1" aria-labelledby="exampleModalLabel4" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel4">Set Product category and subcategory</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="product.php" enctype="multipart/form-data" class="row g-3">
                        <div class="mb-2 col-12">
                            <label for="editnullproductname" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="editnullproductname" name="editnullproductname" readonly>
                        </div>
                        <div class="mb-2 col-12">
                            <input type="text" class="form-control" id="editnullproductno" name="editnullproductno" style="Display: none" readonly>
                        </div>
                        <div class="mb-2 col-6">
                            <label for="editnullselectcate" class="form-label">Select category</label>
                            <select id="editnullselectcate" class="form-select" aria-label="Default select example" onchange="getsubcategorydropdown(this.value,'enform')" name="editnullcatid" required>
                                <?php
                                echo "<option selected>Select category</option>";
                                foreach ($category as $cat) {
                                    echo "<option value=" . $cat['catid'] . ">" . $cat['catname'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-2 col-6">
                            <label for="editnullselectsubcategory" class="form-label">Select Sub Category</label>
                            <select id="editnullselectsubcategory" class="form-select" aria-label="Default select example" name="editnullsubcatid" required>
                                <option selected>Select Sub Category</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" name="editnullproduct">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- modal foe deleting null product -->
    <div class="modal fade" id="deletenullproduct" tabindex="-1" aria-labelledby="exampleModalLabel5" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel5">Delete Product</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="product.php" enctype="multipart/form-data">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="deletenullproductno" name="deletenullproductno" style="display: none">
                        </div>
                        <div class="mb-3">
                            <label for="deletenullproductname" class="form-label">Product</label>
                            <input type="text" class="form-control" id="deletenullproductname" name="deletenullproductname" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Please Press Delete Product to
                                Conform</label>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary" name="deletenullproduct">Delete
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
            $('#producttable').DataTable();
            $('#nullproducttable').DataTable();
            getproducttable('cat0');
            getnullproducttable()
        });

        function getproducttable(subcatid) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {

                if (this.readyState == 4 && this.status == 200) {
                    var table = $('#producttable').DataTable();
                    table.destroy();
                    document.getElementById("product").innerHTML =
                        this.responseText;
                    $('#producttable').DataTable();
                }
            };
            xhttp.open("GET", "list.php?list=product&subcatid=" + subcatid, true);
            xhttp.send();
        }

        function getnullproducttable() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {

                if (this.readyState == 4 && this.status == 200) {
                    var table = $('#nullproducttable').DataTable();
                    table.destroy();
                    document.getElementById("nullproduct").innerHTML =
                        this.responseText;
                    $('#nullproducttable').DataTable();
                }
            };
            xhttp.open("GET", "list.php?list=nullproduct", true);
            xhttp.send();
        }

        function getsubcategorydropdown(catid, type) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (type == 'table') {
                        document.getElementById("selectsubcat").innerHTML =
                            "<option selected value=cat" + catid + ">Select Sub Category</option><option value=cat" +
                            catid +
                            ">All subcategories</option>";
                        document.getElementById("selectsubcat").innerHTML +=
                            this.responseText;
                    } else if (type == "form") {
                        document.getElementById("selectsubcategory").innerHTML =
                            this.responseText;
                    } else if (type == "eform") {
                        document.getElementById("editselectsubcategory").innerHTML =
                            this.responseText;
                    } else if (type == "enform") {
                        document.getElementById("editnullselectsubcategory").innerHTML =
                            this.responseText;
                    }
                }
            };
            xhttp.open("GET", "list.php?list=subcat&dropdown=1&catid=" + catid, true);
            xhttp.send();
        }

        function deleteproduct(item) {
            item = item.parentNode.parentNode;
            item = item.getElementsByTagName('td');
            document.getElementById('deleteproductno').value = item[3].innerHTML;
            document.getElementById('deleteproductname').value = item[4].innerHTML;
        }

        function editproduct(item) {
            item = item.parentNode.parentNode;
            item = item.getElementsByTagName('td');
            console.log(item);
            document.getElementById('editproductno').value = item[3].innerHTML;
            document.getElementById('editproductname').value = item[4].innerHTML;
            document.getElementById('editselectcate').value = item[1].innerHTML;
            getsubcategorydropdown(item[1].innerHTML, 'eform');
            document.getElementById('editselectsubcategory').value = item[2].innerHTML;
            document.getElementById('editoffer').value = item[11].innerHTML;
            document.getElementById('editpurchaseprice').value = item[5].innerHTML;
            document.getElementById('editsellprice').value = item[6].innerHTML;
            document.getElementById('editmrp').value = item[7].innerHTML;
            document.getElementById('editcgst').value = item[9].innerHTML;
            document.getElementById('editsgst').value = item[10].innerHTML;
            document.getElementById('editadd').value = 0;
        }

        function deletenullproduct(item) {
            item = item.parentNode.parentNode;
            item = item.getElementsByTagName('td');
            document.getElementById('deletenullproductno').value = item[1].innerHTML;
            document.getElementById('deletenullproductname').value = item[2].innerHTML;
        }

        function editnullproduct(item) {
            item = item.parentNode.parentNode;
            item = item.getElementsByTagName('td');
            console.log(item);
            document.getElementById('editnullproductno').value = item[1].innerHTML;
            document.getElementById('editnullproductname').value = item[2].innerHTML;
        }
    </script>
</body>

</html>