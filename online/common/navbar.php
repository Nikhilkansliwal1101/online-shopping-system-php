<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="./">Customer First</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="./">Home</a>
                </li>
            </ul>
            <div class="d-flex">
                <a href="order.php"><button class="btn btn-outline-success mx-2" type="button" name="cart">Cart</button></a>
                <?php
                if(isset($_SESSION['custid']))
                {
                  echo 
                  '<a href="profile.php"><button class="btn btn-outline-success mx-2" type="button" name="profile">Profile</button></a>
                  <a href="logout.php"><button class="btn btn-outline-danger mx-2" type="button" name="logout">Logout</button></a>';

                }
                else
                {
                  echo 
                  '<a href="login.php"><button class="btn btn-outline-success mx-2" type="button" name="login">Login</button></a>
                  <a href="signin.php"><button class="btn btn-outline-success mx-2" type="button" name="signin">Signup</button></a>';
                }
                ?>
            </div>
        </div>
    </div>
</nav>