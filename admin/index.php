<?php
session_start();
if(!isset($_SESSION['adminid']))
{
    header("Location: login.php");
    die();
}

require("common/database.php");
$query = "SELECT count(*) FROM `orders` AS o WHERE `o`.`status` LIKE 'notcom';";
$no_of_orders=mysqli_query($con,$query);
$no_of_orders=mysqli_fetch_assoc($no_of_orders);

$query = "SELECT count(*) FROM `customer`";
$no_of_customer=mysqli_query($con,$query);
$no_of_customer=mysqli_fetch_assoc($no_of_customer);

$query = "SELECT count(*) FROM `product`";
$no_of_product=mysqli_query($con,$query);
$no_of_product=mysqli_fetch_assoc($no_of_product);

$query = "SELECT count(*) FROM `category`";
$no_of_category=mysqli_query($con,$query);
$no_of_category=mysqli_fetch_assoc($no_of_category);

$query = "SELECT count(*) FROM `subcategory`";
$no_of_subcategory=mysqli_query($con,$query);
$no_of_subcategory=mysqli_fetch_assoc($no_of_subcategory);
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <title>Admin</title>
</head>

<body>
    <?php require("common/navbar.php") ?>
    <div class="border border-3 rounded-2 shadow p-1">
        <div class="card-group row row-cols-1 row-cols-md-2 row-cols-lg-3 g-0 d-flex justify-content-around align-items-center">
            <a href="notcomorders.php" class="text-decoration-none">
                <div class="col m-3">
                    <div class="card border border-danger border-3 rounded p-3 shadow bg-white" style="max-width: 800px">
                        <div class="row g-0">
                            <div class="col-6">
                                <img src="../images/system/pendingorder.png" alt="image"
                                    style="width:100%;height:200px;" class=" rounded-0">
                            </div>
                            <div class="col-6 text-dark d-flex justify-content-center align-items-center rounded">
                                <div class="card-body text-danger">
                                    <h1 class="text-center"><?php echo $no_of_orders["count(*)"] ?></h1>
                                    <h3 class="text-center">Orders in the Queue</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="customer.php" class="text-decoration-none">
                <div class="col m-3">
                    <div class="card border border-primary border-3 rounded p-3 shadow bg-white" style="max-width: 800px">
                        <div class="row g-0">
                            <div class="col-6">
                                <img src="../images/system/customer.jpg" alt="image" style="width:100%;height:200px;"
                                    class=" rounded-0">
                            </div>
                            <div class="col-6 text-dark d-flex justify-content-center align-items-center rounded">
                                <div class="card-body text-primary">
                                    <h1 class="text-center"><?php echo $no_of_customer["count(*)"] ?></h1>
                                    <h3 class="text-center">Customer</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="product.php" class="text-decoration-none">
                <div class="col m-3">
                    <div class="card border border-warning border-3 rounded p-3 shadow bg-white" style="max-width: 800px">
                        <div class="row g-0">
                            <div class="col-6">
                                <img src="../images/system/product.png" alt="image" style="width:100%;height:200px;"
                                    class=" rounded-0">
                            </div>
                            <div class="col-6 text-dark d-flex justify-content-center align-items-center rounded">
                                <div class="card-body text-warning">
                                    <h1 class="text-center"><?php echo $no_of_product["count(*)"] ?></h1>
                                    <h3 class="text-center">Products</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="category.php" class="text-decoration-none">
                <div class="col m-3">
                    <div class="card border border-dark border-3 rounded p-3 shadow bg-white" style="max-width: 800px">
                        <div class="row g-0">
                            <div class="col-6">
                                <img src="../images/system/category.jpg" alt="image" style="width:100%;height:200px;"
                                    class=" rounded-0">
                            </div>
                            <div class="col-6 text-dark d-flex justify-content-center align-items-center rounded">
                                <div class="card-body text-dark">
                                    <h1 class="text-center"><?php echo $no_of_category["count(*)"] ?></h1>
                                    <h3 class="text-center">Category</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="subcategory.php" class="text-decoration-none">
                <div class="col m-3">
                    <div class="card border border-info border-3 rounded p-3 shadow bg-white" style="max-width: 800px">
                        <div class="row g-0">
                            <div class="col-6">
                                <img src="../images/system/subcategory.png" alt="image" style="width:100%;height:200px;"
                                    class=" rounded-0">
                            </div>
                            <div class="col-6 text-dark d-flex justify-content-center align-items-center rounded">
                                <div class="card-body text-info">
                                    <h1 class="text-center"><?php echo $no_of_subcategory["count(*)"] ?></h1>
                                    <h3 class="text-center">Subcategory</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="border border-3 rounded-2 shadow p-1">
        <div class="text-center p-2 border border-1 bg-dark w-100 text-light">
            <h4>-: Order :-</h4>
        </div>
        <div class="card-group row row-cols-1 row-cols-md-2 row-cols-lg-4 g-0 d-flex justify-content-around align-items-center">
            <a href="notcomorders.php" class="text-decoration-none">
                <div class="col m-3">
                    <div class="card border border-danger border-3 rounded-2 shadow p-3 mb-5 bg-white" style="max-width: 800px">
                        <div class="row g-0">
                            <div class="col-6">
                                <img src="../images/system/pendingorder.png" alt="image" style="width:100%;height:150px;">
                            </div>
                            <div class="col-6 text-dark d-flex justify-content-center align-items-center">
                                <div class="card-body text-danger">
                                    <h5 class="card-title text-center">Order In Queue</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="orders.php" class="text-decoration-none">
                <div class="col m-3">
                    <div class="card border border-dark border-3 rounded-2 shadow p-3 mb-5 bg-white" style="max-width: 800px">
                        <div class="row g-0">
                            <div class="col-6">
                                <img src="../images/system/order.jfif" alt="image" style="width:100%;height:150px;">
                            </div>
                            <div class="col-6 text-dark d-flex justify-content-center align-items-center">
                                <div class="card-body text-dark">
                                    <h5 class="card-title text-center">All Order</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="neworder.php" class="text-decoration-none">
                <div class="col m-3">
                    <div class="card border border-warning border-3 rounded-2 shadow p-3 mb-5 bg-white" style="max-width: 800px">
                        <div class="row g-0">
                            <div class="col-6">
                                <img src="../images/system/placeneworder.png" alt="image"
                                    style="width:100%;height:150px;">
                            </div>
                            <div class="col-6 text-dark d-flex justify-content-center align-items-center">
                                <div class="card-body text-warning">
                                    <h5 class="card-title text-center">Place New Order For Customer</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="border border-3 rounded-2 shadow p-1">
        <div class="text-center p-2 border border-1 bg-dark w-100 text-light">
            <h4>-: Supplier :-</h4>
        </div>
        <div
            class="card-group row row-cols-1 row-cols-md-2 row-cols-lg-4 g-0 d-flex justify-content-around align-items-center">
            <a href="suppliers.php" class="text-decoration-none">
                <div class="col m-3">
                    <div class="card border border-primary border-3 rounded-2 shadow p-3 mb-5 bg-white" style="max-width: 800px">
                        <div class="row g-0">
                            <div class="col-6">
                                <img src="../images/system/placeorder.png" alt="image" style="width:100%;height:150px;">
                            </div>
                            <div class="col-6 text-dark d-flex justify-content-center align-items-center">
                                <div class="card-body text-primary">
                                    <h5 class="card-title text-center">Make Order To Supplier</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="payment.php" class="text-decoration-none">
                <div class="col m-3">
                    <div class="card border border-warning border-3 rounded-2 shadow p-3 mb-5 bg-white" style="max-width: 800px">
                        <div class="row g-0">
                            <div class="col-6">
                                <img src="../images/system/paymoney.png" alt="image" style="width:100%;height:150px;">
                            </div>
                            <div class="col-6 text-dark d-flex justify-content-center align-items-center">
                                <div class="card-body text-warning">
                                    <h5 class="card-title text-center">Status Of Supplier Order</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="addnewsupplier.php" class="text-decoration-none">
                <div class="col m-3">
                    <div class="card border border-danger border-3 rounded-2 shadow p-3 mb-5 bg-white" style="max-width: 800px">
                        <div class="row g-0">
                            <div class="col-6">
                                <img src="../images/system/addnewsupplier.png" alt="image"
                                    style="width:100%;height:150px;">
                            </div>
                            <div class="col-6 text-dark d-flex justify-content-center align-items-center">
                                <div class="card-body text-danger">
                                    <h5 class="card-title text-center">Add New Supplier</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="border border-3 rounded-2 shadow p-1">
        <div class="text-center p-2 border border-1 bg-dark w-100 text-light">
            <h4>-: Manage :-</h4>
        </div>
        <div class="card-group row row-cols-1 row-cols-md-2 row-cols-lg-4 g-0 d-flex justify-content-around align-items-center">
            <a href="category.php" class="text-decoration-none">
                <div class="col m-3">
                    <div class="card border border-warning border-3 rounded-2 shadow p-3 mb-5 bg-white" style="max-width: 800px">
                        <div class="row g-0">
                            <div class="col-6">
                                <img src="../images/system/category.jpg" alt="image"
                                    style="width:100%;height:150px;">
                            </div>
                            <div class="col-6 text-dark d-flex justify-content-center align-items-center">
                                <div class="card-body text-warning">
                                    <h5 class="card-title text-center">Category</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="subcategory.php" class="text-decoration-none">
                <div class="col m-3">
                    <div class="card border border-info border-3 rounded-2 shadow p-3 mb-5 bg-white" style="max-width: 800px">
                        <div class="row g-0">
                            <div class="col-6">
                                <img src="../images/system/subcategory.png" alt="image"
                                    style="width:100%;height:150px;">
                            </div>
                            <div class="col-6 text-dark d-flex justify-content-center align-items-center">
                                <div class="card-body text-info">
                                    <h5 class="card-title text-center">Subcategory</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="product.php" class="text-decoration-none">
                <div class="col m-3">
                    <div class="card border border-primary border-3 rounded-2 shadow p-3 mb-5 bg-white" style="max-width: 800px">
                        <div class="row g-0">
                            <div class="col-6">
                                <img src="../images/system/product.png" alt="image"
                                    style="width:100%;height:150px;">
                            </div>
                            <div class="col-6 text-dark d-flex justify-content-center align-items-center">
                                <div class="card-body text-primary">
                                    <h5 class="card-title text-center">Products</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="outofstockproduct.php" class="text-decoration-none">
                <div class="col m-3">
                    <div class="card border border-danger border-3 rounded-2 shadow p-3 mb-5 bg-white" style="max-width: 800px">
                        <div class="row g-0">
                            <div class="col-6">
                                <img src="../images/system/outofstock.png" alt="image"
                                    style="width:100%;height:150px;">
                            </div>
                            <div class="col-6 text-dark d-flex justify-content-center align-items-center">
                                <div class="card-body text-danger">
                                    <h5 class="card-title text-center">Out Of Stock</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="carousel.php" class="text-decoration-none">
                <div class="col m-3">
                    <div class="card border border-dark border-3 rounded-2 shadow p-3 mb-5 bg-white" style="max-width: 800px">
                        <div class="row g-0">
                            <div class="col-6">
                                <img src="../images/system/carousel.png" alt="image"
                                    style="width:100%;height:150px;">
                            </div>
                            <div class="col-6 text-dark d-flex justify-content-center align-items-center">
                                <div class="card-body text-dark">
                                    <h5 class="card-title text-center">Carousel</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <?php require("common/script.php") ?>
</body>

</html>