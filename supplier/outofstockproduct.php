<?php
session_start();
if (!isset($_SESSION['adminid'])) {
    header("Location: login.php");
}
$target_dir = "../images/product/";
$responce = "";
require("common/database.php");


//update product
if (isset($_POST['editproduct'])) {
    if (isset($_POST['editimage']) && ($_FILES['editproimage']["size"]!=0)) {
        $name = $_POST['editproductname'];
        $imagename = str_replace(" ", "", $name);
        $check = getimagesize($_FILES["editproimage"]["tmp_name"]);
        $target_file = $target_dir . basename($_FILES["editproimage"]["name"]);
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
                if ($_FILES["editproimage"]["size"] > 500000) {
                    $responce =
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error! </strong>File size is too big
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                } else {
                    if (move_uploaded_file($_FILES["editproimage"]["tmp_name"], $target_file)) {
                        $subcatid = $_POST['editsubcatid'];
                        $offer = $_POST['editoffer'];
                        $purchaseprice = $_POST['editpurchaseprice'];
                        $sellprice = $_POST['editsellprice'];
                        $mrp = $_POST['editmrp'];
                        $cgst = $_POST['editcgst'];
                        $sgst = $_POST['editsgst'];
                        $add = $_POST['editadd'];
                        $productno = $_POST['editproductno'];
                        $query = "UPDATE `product` SET `subcatid`='$subcatid', `available`=`available`+'$add', `purchaseprice`='$purchaseprice', `sellprice`='$sellprice', `mrp`='$mrp', `offer`='$offer', `cgst`='$cgst', `sgst`='$sgst',`image`='$imagename' WHERE `productno`= $productno;";
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
        $subcatid = $_POST['editsubcatid'];
        $offer = $_POST['editoffer'];
        $purchaseprice = $_POST['editpurchaseprice'];
        $sellprice = $_POST['editsellprice'];
        $mrp = $_POST['editmrp'];
        $cgst = $_POST['editcgst'];
        $sgst = $_POST['editsgst'];
        $add = $_POST['editadd'];
        $productno = $_POST['editproductno'];
        $query = "UPDATE `product` SET `subcatid`='$subcatid', `available`=`available`+'$add', `purchaseprice`='$purchaseprice', `sellprice`='$sellprice', `mrp`='$mrp', `offer`='$offer', `cgst`='$cgst', `sgst`='$sgst' WHERE `productno`= $productno;";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
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
        <!-- product table -->
        <div>
            <div class="card my-4 shadow">
                <div class="card-header">
                    <h1>Out Of Stock Products</h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="selectcate" class="form-label">Select category</label>
                            <select id="selectcate" class="form-select" aria-label="Default select example"
                                onchange="getsubcategorydropdown(this.value,'table')">
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
                            <select id="selectsubcat" class="form-select" aria-label="Default select example"
                                onchange="getproduct(this.value)">
                                <option selected value='cat0'>Select Sub Category</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive mw-100 small">
                <table id="producttable" class="table table-striped table-hover table-bordered p-0 m-0">
                    <thead>
                        <tr>
                            <th scope="col" style="display: none">SubCatid</th>
                            <th scope="col" style="display: none">Productno</th>
                            <th scope="col"></th>
                            <th scope="col">Product Name</th>
                            <th scope="col">MRP</th>
                            <th scope="col">S Price</th>
                            <th scope="col">B Price</th>
                            <th scope="col">STOCK</th>
                            <th scope="col" style="display: none">CGST</th>
                            <th scope="col" style="display: none">SGST</th>
                            <th scope="col" style="display: none">Offer</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody id="product">

                    </tbody>
                </table>
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
                    <form method="post" action="outofstockproduct.php" enctype="multipart/form-data" class="row g-3">
                        <div class="mb-2 col-12">
                            <label for="editproductname" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="editproductname" name="editproductname"
                                readonly>
                        </div>
                        <div class="mb-2 col-12">
                            <input type="text" class="form-control" id="editproductno" name="editproductno"
                                style="Display: none" readonly>
                        </div>
                        <div class="mb-2 col-6">
                            <label for="editselectcate" class="form-label">Select category</label>
                            <select id="editselectcate" class="form-select" aria-label="Default select example"
                                onchange="getsubcategorydropdown(this.value,'eform')" name="editcatid">
                                <?php
                                foreach ($category as $cat) {
                                    echo '<option value=' . $cat['catid'] . '>' . $cat['catname'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-2 col-6">
                            <label for="editselectsubcategory" class="form-label">Select Sub Category</label>
                            <select id="editselectsubcategory" class="form-select" aria-label="Default select example"
                                name="editsubcatid" required>
                                <?php
                                echo "<option  selected>select</option>";
                                foreach ($subcategory as $subcat) {
                                    echo "<option value=" . $subcat['subcatid'] . ">" . $subcat['name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-2 col-12">
                            <label for="editoffer" class="form-label">Offer</label>
                            <input type="text" class="form-control" id="editoffer" name="editoffer">
                        </div>
                        <div class="mb-2 col-4">
                            <label for="editpurchaseprice" class="form-label">Buy Price</label>
                            <input type="number" step="0.01" class="form-control" id="editpurchaseprice"
                                name="editpurchaseprice" required>
                        </div>
                        <div class="mb-2 col-4">
                            <label for="editsellprice" class="form-label">Sell Price</label>
                            <input type="number" step="0.01" class="form-control" id="editsellprice"
                                name="editsellprice" required>
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
                        <div class="mb-3 col-12">
                            <label for="editproimage" class="form-label">Select checkbox for updating image</label>
                            <input type="checkbox" name="editimage" id="editimage">
                            <input type="file" name="editproimage" id="editproimage">
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
                    <form method="post" action="outofstockproduct.php" enctype="multipart/form-data">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="deleteproductno" name="deleteproductno"
                                style="display: none">
                        </div>
                        <div class="mb-3">
                            <label for="deleteproductname" class="form-label">Product</label>
                            <input type="text" class="form-control" id="deleteproductname" name="deleteproductname"
                                readonly>
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



    <?php require("common/script.php"); ?>

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js">
    </script>

    <script>
    $(document).ready(function() {
        getproduct('cat0');
    });

    function getproduct(subcatid) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {

            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("product").innerHTML =
                    this.responseText;
                $('#producttable').DataTable();
            }
        };
        xhttp.open("GET", "list.php?list=product&frompage=outofstockproduct&subcatid=" + subcatid, true);
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
                } else if (type == "eform") {
                    document.getElementById("editselectsubcategory").innerHTML =
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
        document.getElementById('deleteproductno').value = item[1].innerHTML;
        document.getElementById('deleteproductname').value = item[3].innerHTML;
    }

    function editproduct(item) {
        item = item.parentNode.parentNode;
        item = item.getElementsByTagName('td');
        document.getElementById('editproductno').value = item[1].innerHTML;
        document.getElementById('editproductname').value = item[3].innerHTML;
        document.getElementById('editselectcate').value = 0;
        document.getElementById('editselectsubcategory').value = item[0].innerHTML;
        document.getElementById('editoffer').value = item[10].innerHTML;
        document.getElementById('editpurchaseprice').value = item[6].innerHTML;
        document.getElementById('editsellprice').value = item[5].innerHTML;
        document.getElementById('editmrp').value = item[4].innerHTML;
        document.getElementById('editcgst').value = item[8].innerHTML;
        document.getElementById('editsgst').value = item[9].innerHTML;
        document.getElementById('editadd').value = 0;
    }
    </script>
</body>

</html>