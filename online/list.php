<?php
if (!isset($_GET['list'])) {
    header("Location: index.php");
    die();
}
require("common/database.php");
if ($_GET['list'] == 'product') {
    $subcatid = $_GET['subcatid'];
    $query = "SELECT * FROM `product` WHERE `subcatid`=$subcatid ORDER BY 'sold'";
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
        '<div class="col p-1">
                <div class="card border border-3 rounded-2 shadow">
                <div class="card-header m-1 p-0 shadow bg-white">
                    <p class="p-0 m-0 text-danger" style="font-size: small; text-align: right;"><marquee direction="right">Get ' . $discount . ' % Off</marquee></p>
                </div>
                <div class="row">
                    <div class="col col-6 col-lg-12">
                        <img src="images/' . $image . '" class="card-img-top" alt="..." height="100%">
                    </div>
                    <div class="col col-6 col-lg-12">
                        <h5 style="display: none">' . $pno . '</h5>
                        <h5 style=" display: none">' . $cgst . '</h5>
                        <h5 style="display: none">' . $sgst . '</h5>
                        <h5 style="display: none">' . $pname . '</h5>
                        <h5 style="display: none">' . $mrp . '</h5>
                        <h5 style="display: none">' . $price . '</h5>
                        <div class="card-body d-flex justify-content-center flex-column p-2">
                            <h6 class="card-title text-center">' . $pname . '</h6>
                            <hr>
                            <p><span>&#8377;</span><strong> ' . $price . ' </strong>';if($price!=$mrp)echo '<small style="font-size: x-small;"><s> ' . $mrp . '</s></small>';echo'</p>
                        </div>
                        <div class="m-0 p-0">
                            <p class="p-0 m-0 text-primary" style="font-size: small; text-align: center;">' . $available . ' Items Available</p>
                        </div>
                        <div class="card-footer">';
        if ($available > 0) {
            echo
            '<div class="row text-center d-flex align-items-center">
                                <div class="col-4 m-0 p-1"><button type="button" class="btn btn-danger" style="width: 100%" onclick=decrement(this)>-</button>
                                </div>
                                <div class="col-4 m-0 p-1 text-center"><h5 class="quantity">0</h5></div>
                                <div class="col-4 m-0 p-1"><button type="button" class="btn btn-success" style="width: 100%" onclick=increment(this)>+</button>
                                </div>
                            </div>';
        } else {
            echo '<div class="text-center text-warning">Out of stock</div>';
        }
        echo '</div>
                    </div>
                </div>
                </div>
            </div>';
    }
} else if ($_GET['list'] == 'subcategory') {
    $catid = $_GET['catid'];
    $query = "SELECT * FROM `subcategory` WHERE `catid`=" . $catid . ";";
    $subcategory = mysqli_query($con, $query);
    echo "<ul>";
    while ($subcat = mysqli_fetch_assoc($subcategory)) {
        $subcatid = $subcat['subcatid'];
        $subcatname = $subcat['name'];
        echo '<li><button type="button" class="btn btn-outline-primary w-100 my-1 text-dark" onclick=getproduct(this.value) value=' . $subcatid . '>' . $subcatname . '</button></li>';
    }
    echo "</ul>";
} else if ($_GET['list'] == 'subcategoryname') {
    $subcatid = $_GET['subcatid'];
    $query = "SELECT `name` FROM `subcategory` WHERE `subcatid`=" . $subcatid . ";";
    $subcategoryname = mysqli_query($con, $query);
    $subcategoryname = mysqli_fetch_assoc($subcategoryname);
    echo '<button type="button" class="btn btn-dark my-1 w-100" onclick=toggledisplay("filter")><h2>' . $subcategoryname['name'] . '</h2></button>';
} else if ($_GET['list'] == 'category') {
    $query = "SELECT * FROM `category`";
    $category = mysqli_query($con, $query);
    echo "<ul>";
    while ($cat = mysqli_fetch_assoc($category)) {
        $catid = $cat['catid'];
        $catname = $cat['catname'];
        echo '<li><button type="button" class="btn btn-outline-success w-100 my-1 text-dark" onclick=getsubcategory(this.value) value=' . $catid . '>' . $catname . '</button></li>';
    }
    echo "</ul>";
} else if ($_GET['list'] == 'order') {
    $custid = $_GET['c'];
    $query = "SELECT * FROM `orders` WHERE `custid`=$custid ORDER BY `deliverydate`,`orders`.`orderid`;";
    $orders = mysqli_query($con, $query);
    echo
    '<div class="card p-3 shadow text-center">
            <div class="card-header">
                <h1>Previous Order</h1>
                <small>*click on order for order info</small>
            </div>
        </div>';
    echo
    '<div class="table-responsive">
            <table id="preorders" class="table table-sm table-hover table-bordered table-striped text-center">
                <thead class="bg-success text-light">
                    <tr>
                        <th>SNo.</th>
                        <th scope="col">ORDER ID</th>
                        <th scope="col">ORDER DATE</th>
                        <th scope="col">SHIP DATE</th>
                    </tr>
                </thead>
                <tbody>';
    $sno = 1;
    while ($order = mysqli_fetch_assoc($orders)) {
        echo
        '<tr onclick=getorderdisc(' . $order['orderid'] . ')>
                        <td>' . $sno . '</td>
                        <td>' . $order["orderid"] . '</td>
                        <td>' . $order["orderdate"] . '</td>
                        <td>' . $order["deliverydate"] . '</td>
                    </tr>
                    <div id="' . $order["orderid"] . '"></div>';
        $sno++;
    }
    echo
    '</tbody>   
            </table>
        </div>';
} else if ($_GET['list'] == 'orderdisc') {
    $query = "SELECT * FROM `orders` AS o,`customer` AS c WHERE `o`.`custid`=`c`.`custid` AND `o`.`orderid`=" . $_GET['orderid'];
    $order = mysqli_query($con, $query);
    $order = mysqli_fetch_array($order);
    echo
    '<div class="card my-4 p-2 mx-0 shadow text-center bg-success">
            <div class="card-header">
                <h1>CUSTOMER FIRST</h1>
            </div>
        </div>
        <div class="row p-0 shadow m-1">
            <h5 class="p-1">Order detail</h5>
            <div class="col-md-6 row">
                <div class="col-4"><div>Order id :</div></div>
                <div class="col-8"><div>' . $order["orderid"] . '</div></div>
            </div>
            <div class="col-md-6 row">
                <div class="col-4"><div>Date :</div></div>
                <div class="col-8"><div>' . $order["orderdate"] . '</div></div>
            </div>
        </div>';
    $products = "SELECT * FROM `orderdiscription` WHERE `orderid`=" . $_GET['orderid'];
    $products = mysqli_query($con, $products);
    echo
    '<div class="table-responsive small">
            <table class="table table-sm table-hover table-bordered table-striped text-center">
                <thead class="bg-success text-light">
                    <tr>
                        <th scope="col">PRODUCT</th>
                        <th scope="col">QTY</th>
                        <th scope="col">RATE</th>
                        <th scope="col">DISC</th>
                        <th scope="col">GST (%)</th>
                        <th scope="col">NET AMT</th>
                    </tr>
                </thead>
                <tbody>';
    $total_amt = 0;
    $total_disc = 0;
    $total_mrp = 0;
    $total_cgst = 0;
    $total_sgst = 0;
    $sno = 1;
    while ($product = mysqli_fetch_assoc($products)) {
        $name = $product['pname'];
        $qty = $product['quantity'];
        $cgst = $product['cgst'];
        $sgst = $product['sgst'];
        $price = $product['sellprice'];
        $mrp = $product['mrp'];
        $disc = ($mrp - $price);
        $total_amt += ($price * $qty);
        $total_disc += $disc * $qty;
        $total_mrp += ($mrp * $qty);
        $total_cgst += ($price * $qty * $cgst / 100);
        $total_sgst += ($price * $qty * $sgst / 100);

        echo
        '<tr>
                <td>' . $name . '</td>
                <td>' . $qty . '</td>
                <td>' . $mrp . '</td>
                <td>' . $disc . '</td>
                <td>' . ($cgst + $sgst) . '</td>
                <td>' . $price * $qty . '</td>
            </tr>';
    }
    echo
    '</tbody>
                <tfoot class="font-weight-bold">
                    <tr>
                        <td></td>
                        <td>CGST   :</td>
                        <td><span>&#8377; </span>' . $total_cgst . '</td>
                        <td></td>
                        <td>Total: </td>
                        <td><span>&#8377; </span>' . $total_mrp . '</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>SGST:</td>
                        <td><span>&#8377; </span>' . $total_sgst . '</td>
                        <td></td>
                        <td>DISC:</td>
                        <td><span>&#8377; </span>' . $total_disc . '</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>TOTAL TAX:</td>
                        <td><span>&#8377; </span>' . ($total_cgst + $total_sgst) . '</td>
                        <td></td>
                        <td>NET AMT:</td>
                        <td><span>&#8377; </span>' . $total_amt . '</td>
                    </tr>
                </tfoot>
            </table>
        </div>';
}


mysqli_close($con);