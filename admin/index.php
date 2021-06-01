<?php
session_start();
if(!isset($_SESSION['adminid']))
{
    header("Location: login.php");
    die();
}
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
        <div class="text-center p-2 border border-1 bg-dark w-100 text-light">
            <h4>-: Manage Products :-</h4>
        </div>
        <div class="card-group row row-cols-1 row-cols-md-2 row-cols-lg-3 g-0 d-flex justify-content-around align-items-center">
            <a href="category.php" class="text-decoration-none">
                <div class="col m-3">
                    <div class="card border border-3 rounded-2 shadow p-3 mb-5 bg-white" style="max-width: 800px">
                        <div class="row g-0">
                            <div class="col-6">
                                <img src="../online/images/managecategory.png" alt="image"
                                    style="width:100%;height:200px;">
                            </div>
                            <div class="col-6 text-dark d-flex justify-content-center align-items-center">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Manage Categories</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="subcategory.php" class="text-decoration-none">
                <div class="col m-3">
                    <div class="card border border-3 rounded-2 shadow p-3 mb-5 bg-white" style="max-width: 800px">
                        <div class="row g-0">
                            <div class="col-6">
                                <img src="../online/images/managesubcategory.png" alt="image"
                                    style="width:100%;height:200px;">
                            </div>
                            <div class="col-6 text-dark d-flex justify-content-center align-items-center">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Manage Subcategories</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="product.php" class="text-decoration-none">
                <div class="col m-3">
                    <div class="card border border-3 rounded-2 shadow p-3 mb-5 bg-white" style="max-width: 800px">
                        <div class="row g-0">
                            <div class="col-6">
                                <img src="../online/images/manageproduct.png" alt="image"
                                    style="width:100%;height:200px;">
                            </div>
                            <div class="col-6 text-dark d-flex justify-content-center align-items-center">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Manage Products</h5>
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
            <h4>-: Customer :-</h4>
        </div>
        <div class="card-group row row-cols-1 row-cols-md-2 row-cols-lg-3 g-0 d-flex justify-content-around align-items-center">
            <a href="customer.php" class="text-decoration-none">
                <div class="col m-3">
                    <div class="card border border-3 rounded-2 shadow p-3 mb-5 bg-white" style="max-width: 800px">
                        <div class="row g-0">
                            <div class="col-6">
                                <img src="../online/images/customer.png" alt="image" style="width:100%;height:200px;">
                            </div>
                            <div class="col-6 text-dark d-flex justify-content-center align-items-center">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Know your Customers</h5>
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
        <div class="card-group row row-cols-1 row-cols-md-2 row-cols-lg-3 g-0 d-flex justify-content-around align-items-center">
            <a href="orders.php" class="text-decoration-none">
                <div class="col m-3">
                    <div class="card border border-3 rounded-2 shadow p-3 mb-5 bg-white" style="max-width: 800px">
                        <div class="row g-0">
                            <div class="col-6">
                                <img src="../online/images/order.jfif" alt="image" style="width:100%;height:200px;">
                            </div>
                            <div class="col-6 text-dark d-flex justify-content-center align-items-center">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Order List</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="neworder.php" class="text-decoration-none">
                <div class="col m-3">
                    <div class="card border border-3 rounded-2 shadow p-3 mb-5 bg-white" style="max-width: 800px">
                        <div class="row g-0">
                            <div class="col-6">
                                <img src="../online/images/placeneworder.png" alt="image" style="width:100%;height:200px;">
                            </div>
                            <div class="col-6 text-dark d-flex justify-content-center align-items-center">
                                <div class="card-body">
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
        <div class="card-group row row-cols-1 row-cols-md-2 row-cols-lg-3 g-0 d-flex justify-content-around align-items-center">
            <a href="suppliers.php" class="text-decoration-none">
                <div class="col m-3">
                    <div class="card border border-3 rounded-2 shadow p-3 mb-5 bg-white" style="max-width: 800px">
                        <div class="row g-0">
                            <div class="col-6">
                                <img src="../online/images/placeorder.png" alt="image" style="width:100%;height:200px;">
                            </div>
                            <div class="col-6 text-dark d-flex justify-content-center align-items-center">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Make order of prducts to supplier</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="payment.php" class="text-decoration-none">
                <div class="col m-3">
                    <div class="card border border-3 rounded-2 shadow p-3 mb-5 bg-white" style="max-width: 800px">
                        <div class="row g-0">
                            <div class="col-6">
                                <img src="../online/images/paymoney.png" alt="image" style="width:100%;height:200px;">
                            </div>
                            <div class="col-6 text-dark d-flex justify-content-center align-items-center">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Pay and status of order</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="addnewsupplier.php" class="text-decoration-none">
                <div class="col m-3">
                    <div class="card border border-3 rounded-2 shadow p-3 mb-5 bg-white" style="max-width: 800px">
                        <div class="row g-0">
                            <div class="col-6">
                                <img src="../online/images/addnewsupplier.png" alt="image" style="width:100%;height:200px;">
                            </div>
                            <div class="col-6 text-dark d-flex justify-content-center align-items-center">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Add New Supplier</h5>
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