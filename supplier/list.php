<?php
session_start();
require("common/database.php");
if ($_GET['list'] == 'subcat') {
    if ($_GET['catid'] == 0) {
        $query = "SELECT * FROM (`category` as c join `subcategory` as sc on c" . ".catid=sc" . ".catid) ORDER BY sc" . ".catid";
    } else {
        $query = "SELECT * FROM (`category` as c join `subcategory` as sc on c" . ".catid=sc" . ".catid) WHERE sc" . ".catid=" . $_GET['catid'];
    }
    $subcategory = mysqli_query($con, $query);
    $subcategory = mysqli_fetch_all($subcategory, MYSQLI_ASSOC);
    echo "<option value=0 selected>select</option>";
    foreach ($subcategory as $subcat) {
        echo "<option value=" . $subcat['subcatid'] . ">" . $subcat['name'] . "</option>";
    }
} else if ($_GET['list'] == 'product') {
    $supplierid=$_SESSION['supplierid'];
    if (!substr_compare($_GET['subcatid'], "cat", 0, 3)) {
        if ($_GET['subcatid'][3] == 0) {
            $query = "SELECT * FROM `product` WHERE `supplierid` = '$supplierid' and `subcatid` IS NOT NULL;";
        } else {
            $_GET['subcatid'] = str_replace("cat", "", $_GET['subcatid']);
            $query = "SELECT * FROM `product` WHERE `supplierid` = '$supplierid' and subcatid IN (SELECT `subcatid` FROM `subcategory` WHERE `catid`=" . $_GET['subcatid'] . ");";
        }
    } else {
        $query = "SELECT * FROM `product` WHERE `supplierid` = '$supplierid' and  `subcatid` = " . $_GET['subcatid'];
    }
    $products = mysqli_query($con, $query);echo mysqli_error($con)."<br>";
    $products = mysqli_fetch_all($products, MYSQLI_ASSOC);echo mysqli_error($con)."<br>";
    foreach ($products as $product) {
        echo
        '<tr>
            <td style="display: none">' . $product['subcatid'] . '</td>
            <td style="display: none">' . $product['productno'] . '</td>
            <td>' . $product['productid'] . '</td>
            <td>' . $product['mrp'] . '</td>
            <td>' . $product['sellprice'] . '</td>
            <td>' . $product['purchaseprice'] . '</td>
            <td>' . $product['available'] . '</td>
            <td style="display: none">' . $product['cgst'] . '</td>
            <td style="display: none">' . $product['sgst'] . '</td>
            <td style="display: none">' . $product['offer'] . '</td>
            <td><button type="button" class="btn btn-success py-1" data-bs-toggle="modal" data-bs-target="#editproduct" onclick="editproduct(this)"><span class="material-icons">edit</span></button></td>
            <td><button type="button" class="btn btn-danger py-1" onclick="deleteproduct(this)" data-bs-toggle="modal" data-bs-target="#deleteproduct"><span class="material-icons">delete</span></button></td>
            </tr>';
    }
} else if ($_GET['list'] == 'payments') {
    $supplierid=$_SESSION['supplierid'];
    $query = "SELECT * FROM `payment` AS p WHERE `p`.`supplierid`='$supplierid' ORDER BY `p`.`paid`, `p`.`paymentid` ;";
    $payments = mysqli_query($con, $query);
    $sno = 1;
    echo
    '<div class="card my-4 shadow">
            <div class="card-header">
                <h1>Orders</h1>
            </div>
        </div>';
    echo
    '<div class="table-responsive mw-100">
        <table id="paymenttable" class="table table-hover table-bordered table-striped">
            <thead class="bg-success text-light">
                <tr>
                    <th scope="col">SNo.</th>
                    <th scope="col">PAYMENT ID</th>
                    <th scope="col">AMOUNT</th>
                    <th scope="col">DATE</th>
                    <th scope="col">DELIVERED</th>
                </tr>
            </thead>
            <tbody>';
                while ($payment = mysqli_fetch_assoc($payments)) {
                echo
                '<tr onclick=getdisc(' . $payment['paymentid'] . ')>
                    <td>' . $sno . '</td>
                    <td>' . $payment["paymentid"] . '</td>
                    <td>' . $payment["amount"] . '</td>
                    <td>' . $payment["date"] . '</td>
                    <td>' . $payment["collected"] . '</td>
                </tr>';
                $sno += 1;
                }
            echo
            '</tbody>
        </table>
    </div>';
} else if ($_GET['list'] == 'paymentdisc') {
    $query = "SELECT * FROM `orderdiscription` WHERE `paymentid`=" . $_GET['paymentid'];
    $products = mysqli_query($con, $query);

    $query = "SELECT * from `payment` WHERE `paymentid`=" . $_GET['paymentid'];
    $payment = mysqli_query($con, $query);
    $payment = mysqli_fetch_assoc($payment);

    echo
    '<div class="card m-0 my-4 p-2 shadow text-center bg-success">
        <div class="card-header">
            <h1>CUSTOMER FIRST</h1>
        </div>
    </div>
    <div class="row p-0 shadow m-0">
        <div class="col-md-6 row">
            <div class="col-4"><div>Order id :</div></div>
            <div class="col-8"><div>' . $_GET["paymentid"] . '</div></div>
        </div>
        <div class="col-md-6 row">
            <div class="col-4"><div>Date :</div></div>
            <div class="col-8"><div>' . $payment["date"] . '</div></div>
        </div>
    </div>';
    echo
    '<div class="table-responsive p-0 m-0">
    <table class="table table-sm table-hover table-bordered table-striped text-center">
    <thead class="bg-success text-light">
        <tr>
            <th scope="col">PRODUCT</th>
            <th scope="col">QTY</th>
            <th scope="col">RATE</th>
            <th scope="col">NET AMT</th>
        </tr>
    </thead>
    <tbody>';
    $total_amt = 0;
    while ($product = mysqli_fetch_assoc($products)) {
        $name = $product['pname'];
        $qty = $product['quantity'];
        $price = $product['purchaseprice'];
        $total_amt += ($price * $qty);
        echo
        '<tr>
            <td>' . $name . '</td>
            <td>' . $qty . '</td>
            <td>' . $price . '</td>
            <td>' . $price * $qty . '</td>
        </tr>';
    }
    echo
    '</tbody>
    <tfoot class="font-weight-bold">
        <tr>
            <td></td>
            <td></td>
            <td>NET AMT:</td>
            <td><span>&#8377; </span>' . $total_amt . '</td>
        </tr>
    </tfoot>
    </table>
    </div>
    <button type="button" class="btn btn-success w-100" onclick=printdiv(this)>Print Receipt</button>';
}