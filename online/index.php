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

        <!-- recommended products -->
        <div class="border border-3 rounded-2 shadow p-1">
            <div class="text-center p-2 border border-1 bg-dark w-100 text-light">
                <h4>-: Best Sellers :-</h4>
            </div>
            <div class="card-group row w-100 p-2 d-flex flex-nowrap" style="overflow-x: scroll;">
                <?php
                $query="SELECT * FROM `product` ORDER BY `sold` LIMIT 0,10;";
                $result = mysqli_query($con, $query);
                while ($product = mysqli_fetch_assoc($result)) {
                    $pname = $product['productid'];
                    $pno = $product['productno'];
                    $image = $product['image'];
                    $price = $product['sellprice'];
                    $mrp = $product['mrp'];
                    $offer = $product['offer'];
                    $cgst = $product['cgst'];
                    $sgst = $product['sgst'];
                    $available = $product['available'];
                    $discount = round(($mrp - $price) * 100 / $mrp);
                    echo
                    '<div class="col">
                        <div class="card border border-3 rounded-2 shadow" style="height:300px;width:200px">
                            <div class="card-header p-0 shadow">
                                <p class="p-0 m-0 text-danger" style="font-size: x-small; text-align: right;"><marquee direction="right">Get ' . $discount . ' % Off</marquee></p>
                            </div>
                            <img src="images/' . $image . '" class="card-img-top" alt="..." height="100px">
                            <h5 style="display: none">' . $pno . '</h5>
                            <h5 style=" display: none">' . $cgst . '</h5>
                            <h5 style="display: none">' . $sgst . '</h5>
                            <h5 style="display: none">' . $pname . '</h5>
                            <h5 style="display: none">' . $mrp . '</h5>
                            <h5 style="display: none">' . $price . '</h5>
                            <div class="card-body d-flex justify-content-center flex-column p-1 text-center">
                                <p class="card-title text-center small text-nowrap overflow-hidden" style="  text-overflow:ellipsis;">' . $pname . '</p>
                                <p><span>&#8377;</span><strong> ' . $price . ' </strong>';if ($price != $mrp) echo '<small style="font-size: x-small;"><s> ' . $mrp . '</s></small>';echo '</p>
                            </div>
                            <div class="m-0 p-0">
                                <p class="p-0 m-0 text-primary" style="font-size: small; text-align: center;">' . $available . ' Items Available</p>
                                </div>
                            <div class="card-footer">
                                <div class="row text-center d-flex align-items-center">';
                                if ($available > 0) {
                                    echo
                                    '<div class="col-4 m-0 p-1"><button type="button" class="btn btn-danger" style="width: 100%" onclick=decrement(this)>-</button>
                                    </div>
                                    <div class="col-4 m-0 p-1 text-center"><h5 class="quantity">0</h5></div>
                                    <div class="col-4 m-0 p-1"><button type="button" class="btn btn-success" style="width: 100%" onclick=increment(this)>+</button>
                                    </div>';
                                } else {
                                    echo 
                                    '<div class="col-12 m-0 p-1"><button type="button" class="btn btn-outline-warning" style="width: 100%">Out Of Stock</button></div>';
                                }
                                echo 
                                '</div>';
                            echo 
                            '</div>
                        </div>
                    </div>';
                }
                ?>
            </div>
        </div>

        <!-- showing all category -->
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
                // showing subcategories
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
                echo '<hr>';
                // showing top 10 selling product of category
                echo 
                '<div class="m-0 p-1">
                    <div class="card-group row w-100 p-2 d-flex flex-nowrap" style="overflow-x: scroll;"> ';
                    $query = "SELECT * FROM `product` WHERE `subcatid` IN (SELECT `subcatid` FROM `subcategory` where `catid`=$catid) ORDER BY 'sold' LIMIT 0,10";
                    $result = mysqli_query($con, $query);
                    while ($product = mysqli_fetch_assoc($result)) {
                        $pname = $product['productid'];
                        $pno = $product['productno'];
                        $image = $product['image'];
                        $price = $product['sellprice'];
                        $mrp = $product['mrp'];
                        $offer = $product['offer'];
                        $cgst = $product['cgst'];
                        $sgst = $product['sgst'];
                        $available = $product['available'];
                        $discount = round(($mrp - $price) * 100 / $mrp);
                        echo
                        '<div class="col">
                            <div class="card border border-3 rounded-2 shadow" style="height:300px;width:200px">
                                <div class="card-header p-0 shadow">
                                    <p class="p-0 m-0 text-danger" style="font-size: x-small; text-align: right;"><marquee direction="right">Get ' . $discount . ' % Off</marquee></p>
                                </div>
                                <img src="images/' . $image . '" class="card-img-top" alt="..." height="100px">
                                <h5 style="display: none">' . $pno . '</h5>
                                <h5 style=" display: none">' . $cgst . '</h5>
                                <h5 style="display: none">' . $sgst . '</h5>
                                <h5 style="display: none">' . $pname . '</h5>
                                <h5 style="display: none">' . $mrp . '</h5>
                                <h5 style="display: none">' . $price . '</h5>
                                <div class="card-body d-flex justify-content-center flex-column p-1 text-center">
                                    <p class="card-title text-center small text-nowrap overflow-hidden" style="  text-overflow:ellipsis;">' . $pname . '</p>
                                    <p><span>&#8377;</span><strong> ' . $price . ' </strong>';if ($price != $mrp) echo '<small style="font-size: x-small;"><s> ' . $mrp . '</s></small>';echo '</p>
                                </div>
                                <div class="m-0 p-0">
                                    <p class="p-0 m-0 text-primary" style="font-size: small; text-align: center;">' . $available . ' Items Available</p>
                                    </div>
                                <div class="card-footer">
                                    <div class="row text-center d-flex align-items-center">';
                                    if ($available > 0) {
                                        echo
                                        '<div class="col-4 m-0 p-1"><button type="button" class="btn btn-danger" style="width: 100%" onclick=decrement(this)>-</button>
                                        </div>
                                        <div class="col-4 m-0 p-1 text-center"><h5 class="quantity">0</h5></div>
                                        <div class="col-4 m-0 p-1"><button type="button" class="btn btn-success" style="width: 100%" onclick=increment(this)>+</button>
                                        </div>';
                                    } else {
                                        echo 
                                        '<div class="col-12 m-0 p-1"><button type="button" class="btn btn-outline-warning" style="width: 100%">Out Of Stock</button></div>';
                                    }
                                    echo 
                                    '</div>';
                                echo 
                                '</div>
                            </div>
                        </div>';
                    }
                    echo
                    '</div>
                    <div class="text-center">
                        <a class="text-info" href="category.php?catid=' . $catid . '"><h5>See more</h5></a>
                    </div>
                </div>
            </div>
            <br>';
        }
        ?>
    </div>
    <?php 
    require("common/script.php");
    require("common/footer.php");
    mysqli_close($con); 
    ?>

    <script>
    function addproduct(item) {
        item = item.parentNode.parentNode.parentNode;
        content = item.getElementsByTagName("h5");

        var product = {};
        product['pno'] = content[0].innerHTML;
        product['name'] = content[3].innerHTML;
        product['cgst'] = content[1].innerHTML;
        product['sgst'] = content[2].innerHTML;
        product['mrp'] = content[4].innerHTML;
        product['price'] = content[5].innerHTML;
        product['quantity'] = content[6].innerHTML;
        if (localStorage.getItem('cart') !== null) {
            cart = JSON.parse(localStorage.getItem('cart'));
        } else {
            cart = [];
        }

        for (i = 0; i < cart.length; i++) {
            if (cart[i]['pno'] == product['pno']) {
                cart.splice(i, 1);
                break;
            }
        }
        if (product['quantity'] > 0) {
            cart.push(product);
        }
        localStorage.setItem('cart', JSON.stringify(cart));
    }

    function increment(item) {
        block = item.parentNode.parentNode;
        block = block.getElementsByClassName("quantity");
        block[0].innerHTML = parseInt(block[0].innerHTML) + 1;
        addproduct(item.parentNode);
    }

    function decrement(item) {
        block = item.parentNode.parentNode;
        block = block.getElementsByClassName("quantity");
        if (parseInt(block[0].innerHTML) > 0) {
            block[0].innerHTML = parseInt(block[0].innerHTML) - 1;
        }
        addproduct(item.parentNode);
    }
    
    </script>
</body>

</html>