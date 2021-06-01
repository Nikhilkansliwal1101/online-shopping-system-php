<?php
session_start();
if(!isset($_SESSION['adminid']))
{
    header("Location: login.php");
}
require("common/database.php");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    </style>
    <title>New Order</title>
</head>

<body>
    <?php require("common/navbar.php"); ?>
    <div id="alert"></div>
    <div class="text-center small m-0">
        <!-- order table -->
        <div id="cart" class="border border-4 p-2 shadow">
            <div class="card p-3 shadow text-center">
                <div class="card-header">
                    <h1>New Order</h1>
                </div>
                <div class="card-body">
                    <form class="row g-3" id="customerdetail">
                        <div class="col-md-6">
                            <label for="inputname" class="form-label">Name</label>
                            <input type="text" class="form-control" id="inputname" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="inputmobile" class="form-label">Mobile No</label>
                            <input type="text" class="form-control" id="inputmobile" name="mobile" required
                                minlength="10" maxlength="10">
                        </div>
                        <div class="col-12">
                            <label for="inputAddress" class="form-label">Address</label>
                            <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St"
                                name="address" required>
                        </div>
                        <div class="col-md-4">
                            <label for="inputZip" class="form-label">Pincode</label>
                            <input type="number" class="form-control" id="inputZip" name="pincode" readonly
                                value=303103>
                        </div>
                        <div class="col-md-4">
                            <label for="inputCity" class="form-label">City</label>
                            <input type="text" class="form-control" id="inputCity" name="city" value="Jaipur" readonly
                                required>
                        </div>
                        <div class="col-md-4">
                            <label for="inputState" class="form-label">State</label>
                            <select id="inputState" class="form-select" name="state" readonly>
                                <option selected value="Rajasthan">Rajasthan</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <div id="order" class="table-responsive mw-100">

            </div>
            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-outline-success w-50 m-2" onclick=placeorder()>Place Order</button>
            </div>
        </div>
        <br>

        <!-- product table -->
        <div class="border border-4 p-2 shadow">
            <div class="card my-4 shadow">
                <div class="card-header">
                    <h1>Products</h1>
                </div>
                <div class="card-body row">
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
                            onchange="getproducttable(this.value)">
                            <option selected value='cat0'>Select Sub Category</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="table-responsive mw-100">
                <table id="producttable" class="table table-striped table-hover table-bordered text-wrap">
                    <thead>
                        <tr>
                            <th scope="col" style="display: none">Productno</th>
                            <th scope="col" style="display: none">CGST</th>
                            <th scope="col" style="display: none">SGST</th>
                            <th scope="col" style="display: none">Product Name</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Available</th>
                            <th scope="col" style="display: none">MRP</th>>
                            <th scope="col" style="display: none">Sell Price</th>
                            <th scope="col">Quantity</th>
                        </tr>
                    </thead>
                    <tbody id="product">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

<?php require("common/script.php"); ?>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js">
</script>
<script>
$(document).ready(function() {
    order();
    getproducttable('cat0');
});

var total_disc = 0;
var total_amt = 0;
var total_cgst = 0;
var total_sgst = 0;
var total_mrp = 0;
var products = [];

function addproduct(item) {
    item = item.parentNode.parentNode;
    content = item.getElementsByTagName("h5");
    console.log(content);
    var product = {};
    product['pno'] = content[0].innerHTML;
    product['name'] = content[3].innerHTML;
    product['cgst'] = content[1].innerHTML;
    product['sgst'] = content[2].innerHTML;
    product['mrp'] = content[4].innerHTML;
    product['price'] = content[5].innerHTML;
    product['quantity'] = content[6].innerHTML;

    if (localStorage.getItem('neworder') !== null) {
        neworder = JSON.parse(localStorage.getItem('neworder'));
    } else {
        neworder = [];
    }
    for (i = 0; i < neworder.length; i++) {
        if (neworder[i]['pno'] == product['pno']) {
            neworder.splice(i, 1);
            break;
        }
    }
    if (product['quantity'] > 0) {
        neworder.push(product);
    }
    localStorage.setItem('neworder', JSON.stringify(neworder));
    order();
}

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
    xhttp.open("GET", "list.php?list=product&frompage=neworder&subcatid=" + subcatid, true);
    xhttp.send();
}

function getsubcategorydropdown(catid, type) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
                document.getElementById("selectsubcat").innerHTML =
                    "<option selected value=cat" + catid + ">Select Sub Category</option><option value=cat" +
                    catid +
                    ">All subcategories</option>";
                document.getElementById("selectsubcat").innerHTML +=
                    this.responseText;
        }
    };
    xhttp.open("GET", "list.php?list=subcat&dropdown=1&catid=" + catid, true);
    xhttp.send();
}

function increment(item) {
    item = item.parentNode.parentNode;
    block = item;
    item = item.getElementsByClassName("quantity");
    item[0].innerHTML = parseInt(item[0].innerHTML) + 1;
    addproduct(block);
}

function decrement(item) {
    item = item.parentNode.parentNode;
    block = item;
    item = item.getElementsByClassName("quantity");
    if (parseInt(item[0].innerHTML) > 0) {
        item[0].innerHTML = parseInt(item[0].innerHTML) - 1;
    }
    addproduct(block);
}

function placeorder() {
    if (products.length == 0) {
        document.getElementById("alert").innerHTML =
            `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error !</strong> No Item in cart!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
        return;
    }
    let xhr = new XMLHttpRequest();
    let url = "operation.php";
    let myForm = document.getElementById('customerdetail');
    let custdetail = new FormData(myForm);
    if ((custdetail.get('mobile') == "") || (custdetail.get('mobile') == "") || (custdetail.get('mobile') == "") || (
            custdetail.get('mobile') == "") || (custdetail.get('mobile') == "") || (custdetail.get('mobile') == "")) {
        document.getElementById("alert").innerHTML =
            `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong>Fill customer Detail!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
        return;
    }
    let data = "products=" + JSON.stringify(products) + "&name=" + custdetail.get('name') + "&mobile=" + custdetail.get(
            'mobile') + "&address=" + custdetail.get('address') + "&pincode=" + custdetail.get('pincode') + "&city=" +
        custdetail.get('city') + "&state=" + custdetail.get('state')+"&operation=placeorder";
    xhr.open("POST", url, true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("alert").innerHTML =
                `<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success !</strong> order placed sucessfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>`;
            document.getElementById("order").innerHTML = this.responseText;
            localStorage.removeItem('neworder');
        }
    };
    xhr.send(data);
}

function removeitem(pid) {
    neworder = JSON.parse(localStorage.getItem('neworder'));
    for (i = 0; i < neworder.length; i++) {
        if (neworder[i]['pno'] == pid) {
            neworder.splice(i, 1);
            break;
        }
    }
    localStorage.setItem('neworder', JSON.stringify(neworder));
    order();
}

function order() {
    neworder = JSON.parse(localStorage.getItem('neworder'));
    var x = "";
    total_disc = 0;
    total_amt = 0;
    total_cgst = 0;
    total_sgst = 0;
    total_mrp = 0;
    products = [];
    if ((neworder != null) && (neworder.length > 0)) {
        x +=
            `<table class="table table-sm table-hover table-bordered table-striped text-center">
                    <thead class="bg-success text-light">
                        <tr>
                            <th scope="col" style="display: none">PID</th>
                            <th scope="col">PRODUCT</th>
                            <th scope="col">QTY</th>
                            <th scope="col">RATE</th>
                            <th scope="col">DISC</th>
                            <th scope="col">GST (%)</th>
                            <th scope="col">NET AMT</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>`;

        for (i = 0; i < neworder.length; i++) {
            var product = {};
            var pid = neworder[i]['pno'];
            var name = neworder[i]['name'];
            var qty = parseFloat(neworder[i]['quantity']);
            var cgst = parseFloat(neworder[i]['cgst']);
            var sgst = parseFloat(neworder[i]['sgst']);
            var price = parseFloat(neworder[i]['price']);
            var mrp = parseFloat(neworder[i]['mrp']);
            var disc = (mrp - price);
            total_amt += (price * qty);
            total_disc += disc * qty;
            total_mrp += (mrp * qty);
            total_cgst += (price * qty * cgst / 100);
            total_sgst += (price * qty * sgst / 100);

            product['pno'] = pid;
            product['name'] = name;
            product['qty'] = qty;
            product['cgst'] = cgst;
            product['sgst'] = sgst;
            product['mrp'] = mrp;
            product['price'] = price;

            products.push(product);

            x +=
                `<tr>
                        <td style="display: none">` + pid + `</td>
                        <td>` + name + `</td>
                        <td>` + qty + `</td>
                        <td>` + mrp + `</td>
                        <td>` + disc + `</td>
                        <td>` + (cgst + sgst) + `</td>
                        <td>` + price * qty + `</td>
                        <td><button type="button" class="btn-close bg-danger p-2" onclick="removeitem(` + pid + `)"></button></td>
                    </tr>`;
        }
        x +=
            `</tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td>CGST:</td>
                            <td><span>&#8377; </span>` + total_cgst + `</td>
                            <td></td>
                            <td>TOTAL:</td>
                            <td><span>&#8377; </span>` + total_mrp + `</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>SGST:</td>
                            <td><span>&#8377; </span>` + total_sgst + `</td>
                            <td></td>
                            <td>DISC:</td>
                            <td><span>&#8377; </span>` + total_disc + `</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>TOTAL:</td>
                            <td><span>&#8377; </span>` + (total_cgst + total_sgst) + `</td>
                            <td></td>
                            <td>NET AMT:</td>
                            <td><span>&#8377; </span>` + total_amt + `</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>`;
    }
    document.getElementById("order").innerHTML = x;
}
</script>

</html>