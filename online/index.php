<?php
session_start();
require("common/database.php");
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
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>

<body>
    <?php require("common/navbar.php"); ?>
    <!-- corousel -->
    <div id="carouselExampleDark" class="carousel carousel-light slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="10000">
                <img src="https://source.unsplash.com/480x270/?grocery" class="d-block w-100" alt="..."
                    style="height: 400px;">
                <div class="carousel-caption d-none d-md-block">
                    <h5>First slide label</h5>
                    <p>Some representative placeholder content for the first slide.</p>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="2000">
                <img src="https://source.unsplash.com/480x270/?nuts" class="d-block w-100" alt="..."
                    style="height: 400px;">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Second slide label</h5>
                    <p>Some representative placeholder content for the second slide.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://source.unsplash.com/480x270/?snacks" class="d-block w-100" alt="..."
                    style="height: 400px;">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Third slide label</h5>
                    <p>Some representative placeholder content for the third slide.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    
    <div class="mb-5">
        <!-- showing all category to nevigate to perticular category -->
        <div class="border border-3 rounded-2 shadow p-1 d-flex justify-content-center align-items-center flex-column">
            <div class="text-center p-2 border border-1 bg-dark w-100 text-light">
                <h4>-: Shop By Category :-</h4>
            </div>
            <div class="card-group row row-cols-3 row-cols-md-4 row-cols-lg-6 g-0 w-100 d-flex justify-content-around align-items-center">
                <?php
                foreach ($category as $cat) {
                    $image = $cat["image"];
                    $catname = $cat["catname"];
                    $catid = $cat['catid'];
                    echo
                    '<div class="col m-0">
                        <a href="category.php?catid=' . $catid . '" style="text-decoration: none">
                        <div class="card border border-2 rounded-2 shadow bg-white text-dark text-center" style="height:150px;">
                            <div class="card-body d-flex justify-content-center align-items-center" style="z-index: 1;">
                                <h6 class="card-title" style="font-weight: 900">' . $catname . '</h6>
                            </div>
                            <img src="images/' . $image . '" alt="image" class="card-img p-1" width=100% height=100% style="opacity: 0.7;position: absolute;z-index: 0;">
                        </div>
                        </a>
                    </div>';
                }
                ?>
            </div>
        </div>
        
        <!-- showing all category with its subcategories -->
        <?php
        foreach ($category as $cat) {
            echo
            '<div class="row border border-3 rounded-2 shadow p-1 m-0">';
                $image = $cat["image"];
                $catname = $cat["catname"];
                $catdesc = $cat["catdesc"];
                $catid = $cat['catid'];
                echo
                '<div class="col-md-6 col-lg-4 m-0 p-1">
                    <a href="category.php?catid=' . $catid . '" style="text-decoration: none">
                    <div class="card border border-3 rounded-2 shadow p-3  text-dark d-flex justify-content-center" style="height:300px;">
                        <img src="images/' . $image . '" alt="image" class="card-img-top p-1" style="width:100%; height: 150px">
                        <div class="card-body">
                            <h5 class="card-title text-center">' . $catname . '</h5>
                            <p class="card-text text-center">' . $catdesc . '</p>
                        </div>
                    </div>
                    </a>
                </div>';
                $query = "SELECT * FROM `subcategory` WHERE catid=$catid";
                $subcategory = mysqli_query($con, $query);
                echo
                '<div class="col-md-6 col-lg-8 m-0 p-1 d-flex justify-content-center align-items-center">
                    <div class="card-group row row-cols-2 row-cols-md-3 row-cols-lg-5 g-0 w-100">';
                    while ($subcat = mysqli_fetch_assoc($subcategory)) {
                        $image = $subcat["image"];
                        $subcatname = $subcat["name"];
                        $subcatid = $subcat['subcatid'];
                        echo
                        '<a href="subcategory.php?subcatid=' . $subcatid . '&catid=' . $catid . '" class="text-decoration-none">
                            <div class="col m-0">
                                <div class="card  border border-3 rounded-2 shadow p-1 mb-1 bg-white text-dark d-flex justify-content-center align-items-center" style="height:200px;">
                                    <img src="images/' . $image . '" alt="image" class="card-img-top p-1" style="width:100%;height:100px;" >
                                    <div class="card-body text-center">
                                        <p class="card-title">' . $subcatname . '</p>
                                    </div>
                                </div>
                            </div>
                        </a>';
                    }
                    echo
                    '</div>
                </div>';
            echo
            '</div>';
        }
        ?>
    </div>
    <?php 
    require("common/script.php");
    require("common/footer.php");
    mysqli_close($con); 
    ?>
</body>

</html>