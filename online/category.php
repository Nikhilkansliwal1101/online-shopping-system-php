<?php
session_start();

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
    <style>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0;
    }
    </style>
</head>

<body>
    <?php require("common/navbar.php"); ?>
    <div class="mb-5">
        <div>
            <div id="categoryname" class="m-0 p-0">
            </div>
            <div id="filter" class="d-none m-0 p-0">
                <div>
                    <h2>Select Category</h2>
                </div>
                <div id="category">
                </div>
            </div>
        </div>
        <div class="border border-3 rounded-2 shadow p-1 d-flex justify-content-center align-items-center flex-column">
            <div class="text-center p-2 border border-1 bg-dark w-100 text-light">
                <h4>-: Shop By Category :-</h4>
            </div>
            <div id="subcategory" class="card-group row row-cols-3 row-cols-md-4 row-cols-lg-6 g-0 m-2 w-100">
            </div>
        </div>

        <div class="card-group card-deck row row-cols-1 row-cols-md-2 row-cols-lg-4 text-center d-flex justify-content-around p-2 m-0"
            id="product">
        </div>
    </div>

    <?php 
    require("common/script.php"); 
    require("common/footer.php"); 
    ?>


    <script>
    $(document).ready(function() {
        getcategory();
        toggledisplay('filter');
        getproduct(<?php echo $_GET['catid'] ?>);
    });


    function toggledisplay(id) {
        var x = document.getElementById(id);
        x.classList.toggle("d-none");
    }

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

    function getproduct(catid) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("product").innerHTML = this.responseText;
                toggledisplay('filter');
            }
        };
        getcategoryname(catid);
        getsubcategory(catid);
        xhttp.open("GET", "list.php?list=product&frompage=category&catid=" + catid, true);
        xhttp.send();
    }

    function getsubcategory(catid) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("subcategory").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "list.php?list=subcategory&frompage=category&catid=" + catid, true);
        xhttp.send();
    }

    function getcategoryname(catid) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("categoryname").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "list.php?list=categoryname&catid=" + catid, true);
        xhttp.send();
    }

    function getcategory() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("category").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "list.php?list=category&frompage=category", true);
        xhttp.send();
    }
    </script>
</body>

</html>