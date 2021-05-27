<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Customer First</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Change Option
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="category.php">Manage Category</a></li>
                        <li><a class="dropdown-item" href="subcategory.php">Manage Subcategory</a></li>
                        <li><a class="dropdown-item" href="product.php">Manage Products</a></li>
                        <li><a class="dropdown-item" href="customer.php">Know your Customers</a></li>
                        <li><a class="dropdown-item" href="orders.php">Orders</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link " tabindex="-1" href="neworder.php">Place Order</a>
                </li>
            </ul>
            <div class="d-flex">
                <?php
                if (isset($_SESSION['logined'])) {
                    if ($_SESSION['status'] == 1) {
                        echo '<a href="addnewadmin.php"><button class="btn btn-outline-success mx-2" type="button">Add Admin</button></a>';
                    }
                    echo '<a href="profile.php"><button class="btn btn-outline-success mx-2" type="button" name="profile">Profile</button></a>
                    <a href="logout.php"><button class="btn btn-outline-danger mx-2" type="button" name="logout">Logout</button></a>';
                } else {
                    echo '<a href="login.php"><button class="btn btn-outline-success mx-2" type="button" name="login">Login</button></a>';
                } ?>
            </div>
        </div>
    </div>
</nav>
<?php
if (!isset($_SESSION['logined'])) {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Alert ! </strong> Login to continue
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}
?>