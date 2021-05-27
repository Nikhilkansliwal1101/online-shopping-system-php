<?php
session_start();
if(!isset($_SESSION['logined']))
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
    <div class="container">
        <div class="card-group row row-cols-1 row-cols-md-2 g-0 d-flex justify-content-around align-items-center">
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
            <a href="orders.php" class="text-decoration-none">
                <div class="col m-3">
                    <div class="card border border-3 rounded-2 shadow p-3 mb-5 bg-white" style="max-width: 800px">
                        <div class="row g-0">
                            <div class="col-6">
                                <img src="../online/images/order.jfif" alt="image" style="width:100%;height:200px;">
                            </div>
                            <div class="col-6 text-dark d-flex justify-content-center align-items-center">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Orders</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
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
    <?php require("common/script.php") ?>
</body>

</html>