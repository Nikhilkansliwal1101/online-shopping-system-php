<?php
session_start();
if(!isset($_GET['list'])){
    header("Location: index.php");
    die();
}
require("common/database.php");
if ($_GET['list'] == 'subcat') {
    if ($_GET['catid'] == 0) {
        $query = "SELECT * FROM (`category` as c join `subcategory` as sc on c" . ".catid=sc" . ".catid) ORDER BY sc" . ".catid";
    } else {
        $query = "SELECT * FROM (`category` as c join `subcategory` as sc on c" . ".catid=sc" . ".catid) WHERE sc" . ".catid=" . $_GET['catid'];
    }
    $subcategory = mysqli_query($con, $query);
    $subcategory = mysqli_fetch_all($subcategory, MYSQLI_ASSOC);
    if (isset($_GET['table'])) {
        foreach ($subcategory as $subcat) {
            echo
            '<tr>
            <td style="display: none">' . $subcat['catid'] . '</td>
            <td>' . $subcat['catname'] . '</td>
            <td style="display: none">' . $subcat['subcatid'] . '</td>
            <td>' . $subcat['name'] . '</td>
            <td><button type="button" class="btn btn-success" onclick="editsubcategory(this)" data-bs-toggle="modal" data-bs-target="#editsubcat"><span class="material-icons">edit</span></button></td>
            <td><button type="button" class="btn btn-danger" onclick="deletesubcategory(this)" data-bs-toggle="modal" data-bs-target="#deletesubcategory"><span class="material-icons">delete</span></button></td>
            </tr>';
        }
    } else if (isset($_GET['dropdown'])) {
        echo "<option value=0 selected>select</option>";
        foreach ($subcategory as $subcat) {
            echo "<option value=" . $subcat['subcatid'] . ">" . $subcat['name'] . "</option>";
        }
    }
} else if ($_GET['list'] == 'nullsubcat') {
    $query = "SELECT * FROM `subcategory` WHERE `catid` is NULL";
    $subcategory = mysqli_query($con, $query);
    $subcategory = mysqli_fetch_all($subcategory, MYSQLI_ASSOC);
    foreach ($subcategory as $subcat) {
        echo
        '<tr>
        <td style="display: none">' . $subcat['subcatid'] . '</td>
        <td>' . $subcat['name'] . '</td>
        <td><button type="button" class="btn btn-success" onclick="editnullcatsubcategory(this)" data-bs-toggle="modal" data-bs-target="#editnullcatsubcat"><span class="material-icons">edit</span></button></td>
        <td><button type="button" class="btn btn-danger" onclick="deletenullcatsubcategory(this)" data-bs-toggle="modal" data-bs-target="#deletenullcatsubcategory"><span class="material-icons">delete</span></button></td>
        </tr>';
    }
} else if ($_GET['list'] == 'product') {
    if (!substr_compare($_GET['subcatid'], "cat", 0, 3)) {
        if ($_GET['subcatid'][3] == 0) {
            $query = "SELECT * FROM `product` WHERE (`subcatid` IS NOT NULL);";
        } else {
            $_GET['subcatid'] = str_replace("cat", "", $_GET['subcatid']);
            $query = "SELECT * FROM `product` WHERE subcatid IN (SELECT `subcatid` FROM `subcategory` WHERE `catid`=" . $_GET['subcatid'] . ");";
        }
    } else {
        $query = "SELECT * FROM `product` WHERE subcatid=" . $_GET['subcatid'];
    }
    $products = mysqli_query($con, $query);
    $products = mysqli_fetch_all($products, MYSQLI_ASSOC);
    if ($_GET['frompage'] == 'product') {
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
    } else if ($_GET['frompage'] == 'neworder') {
        foreach ($products as $product) {
            echo
            '<tr>
            <td style="display: none"><h5>' . $product['productno'] . '</h5></td>
            <td style="display: none"><h5>' . $product['cgst'] . '</h5></td>
            <td style="display: none"><h5>' . $product['sgst'] . '</h5></td>
            <td style="display: none"><h5>' . $product['productid'] . '</h5></td>
            <td>' . $product['productid'] . '</td>
            <td>' . $product['available'] . '</td>
            <td style="display: none"><h5>' . $product['mrp'] . '</h5></td>
            <td style="display: none"><h5>' . $product['sellprice'] . '</h5></td>
            <td>
                <div class="text-center d-flex nowrap justify-content-center">
                    <div><button type="button" class="btn btn-danger"  onclick=decrement(this)>-</button>
                    </div>
                    <div><h5 class="btn quantity">0</h5></div>
                    <div><button type="button" class="btn btn-success" onclick=increment(this)>+</button>
                    </div>
                </div>
            </td>';
        }
    }
} else if ($_GET['list'] == 'nullproduct') {
    $query = "SELECT * FROM `product` WHERE (`subcatid` IS NULL);";
    $products = mysqli_query($con, $query);
    $products = mysqli_fetch_all($products, MYSQLI_ASSOC);
    foreach ($products as $product) {
        echo
        '<tr>
        <td style="display: none">' . $product['productno'] . '</td>
        <td>' . $product['productid'] . '</td>
        <td class="d-flex align-items-center"><button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editnullproduct" onclick="editnullproduct(this)"><span class="material-icons">edit</span></button></td>
        <td><button type="button" class="btn btn-danger py-0" onclick="deletenullproduct(this)" data-bs-toggle="modal" data-bs-target="#deletenullproduct"><span class="material-icons">delete</span></button></td>
        </tr>';
    }
} else if ($_GET['list'] == 'order') {
    $query = "SELECT * FROM `orders` AS o,`customer` AS c WHERE `o`.`custid`=`c`.`custid` ORDER BY `o`.`status` DESC, `o`.`orderid` ;";
    $orders = mysqli_query($con, $query);
    $sno = 1;
    echo
    '<div class="card my-4 shadow">
            <div class="card-header">
                <h1>Orders</h1>
            </div>
        </div>';
    echo
    '<div class="table-responsive mw-100">
        <table id="orders" class="table table-hover table-bordered table-striped">
            <thead class="bg-success text-light">
                <tr>
                    <th scope="col">SNo.</th>
                    <th scope="col">ORDER ID</th>
                    <th scope="col">NAME</th>
                    <th scope="col">ADDRESS</th>
                    <th scope="col">ORDER DATE</th>
                    <th scope="col">DELIVERED</th>
                </tr>
            </thead>
            <tbody>';
    while ($order = mysqli_fetch_assoc($orders)) {
        echo
        '<tr>
                    <td onclick=getorderdisc(' . $order['orderid'] . ')>' . $sno . '</td>
                    <td onclick=getorderdisc(' . $order['orderid'] . ')>' . $order["orderid"] . '</td>
                    <td onclick=getorderdisc(' . $order['orderid'] . ')>' . $order["name"] . '</td>
                    <td onclick=getorderdisc(' . $order['orderid'] . ')>' . $order["address"] . ' ' . $order["city"] . ' ' . $order["state"] . '</td>
                    <td onclick=getorderdisc(' . $order['orderid'] . ')>' . $order["orderdate"] . '</td>';
        if ($order['status'] == 'notcom') {
            echo '<td><button type="button" class="btn btn-danger py-0" onclick=delivered(' . $order["orderid"] . ')>Delivered</button></td>';
        } else {
            echo '<td>' . $order["deliverydate"] . '</td>';
        }
        echo
        '</tr>';
        $sno += 1;
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
    '<div class="card m-0 my-4 p-2 shadow text-center bg-success">
        <div class="card-header">
            <h1>CUSTOMER FIRST</h1>
        </div>
    </div>
    <div class="row p-0 shadow m-0">
        <h5 class="p-1">Customer detail</h5>
        <div class="col-md-6 row">
            <div class="col-4"><div>Order id :</div></div>
            <div class="col-8"><div>' . $order["orderid"] . '</div></div>
            <div class="col-4"><div>Name :</div></div>
            <div class="col-8"><div>' . $order["name"] . '</div></div>
            <div class="col-4"><div>Address :</div></div>
            <div class="col-8"><div>' . $order["address"] . '</div></div>
            <div class="col-4"><div>City :</div></div>
            <div class="col-8"><div>' . $order["city"] . '</div></div>
        </div>
        <div class="col-md-6 row">
            <div class="col-4"><div>Date :</div></div>
            <div class="col-8"><div>' . $order["orderdate"] . '</div></div>
            <div class="col-4"><div>Mobile No :</div></div>
            <div class="col-8"><div>' . $order["mobile"] . '</div></div>
            <div class="col-4"><div>Pincode :</div></div>
            <div class="col-8"><div>' . $order["pincode"] . '</div></div>
            <div class="col-4"><div>State :</div></div>
            <div class="col-8"><div>' . $order["state"] . '</div></div>
        </div>
    </div>';

    $products = "SELECT * FROM `orderdiscription` WHERE `orderid`=" . $_GET['orderid'];
    $products = mysqli_query($con, $products);
    echo
    '<div class="table-responsive p-0 m-0">
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
            <td>CGST:</td>
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
            <td>TOTAL:</td>
            <td><span>&#8377; </span>' . ($total_cgst + $total_sgst) . '</td>
            <td></td>
            <td>NET AMT:</td>
            <td><span>&#8377; </span>' . $total_amt . '</td>
        </tr>
    </tfoot>
    </table>
    </div>
    <button type="button" class="btn btn-success w-100" onclick=printdiv(this)>Print Receipt</button>';
} else if ($_GET['list'] == 'customer') {
    $query = "SELECT custid,name,email,mobile,address,city,pincode FROM `customer`";
    $customers = mysqli_query($con, $query);
    $customers = mysqli_fetch_all($customers, MYSQLI_ASSOC);
    foreach ($customers as $customer) {
        echo
        '<tr>
        <td style="display: none">' . $customer['custid'] . '</td>
        <td>' . $customer['name'] . '</td>
        <td>' . $customer['email'] . '</td>
        <td>' . $customer['mobile'] . '</td>
        <td>' . $customer['address'] . '</td>
        <td>' . $customer['pincode'] . '</td>
        <td>' . $customer['city'] . '</td>
        </tr>';
    }
} else if ($_GET['list'] == 'suppliers') {
    $query = "SELECT * FROM `supplier`";
    $suppliers = mysqli_query($con, $query);
    echo
    '<div class="card my-4 shadow">
            <div class="card-header">
                <h1>Suppliers</h1>
            </div>
        </div>';
    echo
    '<div class="table-responsive mw-100">
        <table id="suppliers" class="table table-hover table-bordered table-striped">
            <thead class="bg-success text-light">
                <tr>
                    <th scope="col">NAME</th>
                    <th scope="col">MOBILE</th>
                    <th scope="col">EMAIL</th>
                </tr>
            </thead>
            <tbody>';
    while ($supplier = mysqli_fetch_assoc($suppliers)) {
        echo
        '<tr onclick=getdisc(' . $supplier["supplierid"] . ')>
                    <td>' . $supplier["name"] . '</td>
                    <td>' . $supplier["mobile"] . '</td>
                    <td>' . $supplier["email"] . '</td>
                </tr>';
    }
    echo
    '</tbody>
        </table>
    </div>';
} else if ($_GET['list'] == 'duedisc') {
    $supplier = $_GET['supplierid'];
    $query = "SELECT * FROM `orderdiscription` WHERE `supplierid`='$supplier' and `paymentid` is null;";
    $products = mysqli_query($con, $query);
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
    $total_disc = 0;
    $total_mrp = 0;
    $total_cgst = 0;
    $total_sgst = 0;
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
    <button type="button" class="btn btn-success w-100" onclick=orderproducts(' . $supplier . ')>Order Products</button>';
} else if ($_GET['list'] == 'payments') {
    $query = "SELECT * FROM `payment` AS p,`supplier` AS s WHERE `s`.`supplierid`=`p`.`supplierid` ORDER BY `p`.`paid`, `p`.`paymentid` ;";
    $payments = mysqli_query($con, $query);
    $sno = 1;
    echo
    '<div class="card my-4 shadow">
            <div class="card-header">
                <h1>Payments</h1>
            </div>
        </div>';
    echo
    '<div class="table-responsive mw-100">
        <table id="paymenttable" class="table table-hover table-bordered table-striped">
            <thead class="bg-success text-light">
                <tr>
                    <th scope="col">SNo.</th>
                    <th scope="col">PAYMENT ID</th>
                    <th scope="col">NAME</th>
                    <th scope="col">AMOUNT</th>
                    <th scope="col">DATE</th>
                    <th scope="col">Collected</th>
                    <th scope="col">PAID</th>
                </tr>
            </thead>
            <tbody>';
                while ($payment = mysqli_fetch_assoc($payments)) {
                echo
                '<tr>
                    <td onclick=getdisc(' . $payment['paymentid'] . ')>' . $sno . '</td>
                    <td onclick=getdisc(' . $payment['paymentid'] . ')>' . $payment["paymentid"] . '</td>
                    <td onclick=getdisc(' . $payment['paymentid'] . ')>' . $payment["name"] . '</td>
                    <td onclick=getdisc(' . $payment['paymentid'] . ')>' . $payment["amount"] . '</td>
                    <td onclick=getdisc(' . $payment['paymentid'] . ')>' . $payment["date"] . '</td>';
                    if ($payment['collected'] == NULL) {
                        echo '<td><button type="button" class="btn btn-success py-0" onclick=ordercollected(' . $payment["paymentid"] . ')>collected</button></td>';
                    } else {
                        echo '<td>' . $payment["collected"] . '</td>';
                    }
                    if ($payment['paid'] == NULL) {
                        echo '<td><button type="button" class="btn btn-danger py-0" onclick=paypayment(' . $payment["paymentid"] . ')>Paid</button></td>';
                    } else {
                        echo '<td>' . $payment["paid"] . '</td>';
                    }
                echo
                '</tr>';
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

    $query = "SELECT * FROM `supplier` where `supplierid` =" . $payment['supplierid'];
    $supplier = mysqli_query($con, $query);
    $supplier = mysqli_fetch_assoc($supplier);

    echo
    '<div class="card m-0 my-4 p-2 shadow text-center bg-success">
        <div class="card-header">
            <h1>CUSTOMER FIRST</h1>
        </div>
    </div>
    <div class="row p-0 shadow m-0">
        <h5 class="p-1">Supplier detail</h5>
        <div class="col-md-6 row">
            <div class="col-4"><div>Payment id :</div></div>
            <div class="col-8"><div>' . $_GET["paymentid"] . '</div></div>
            <div class="col-4"><div>Date :</div></div>
            <div class="col-8"><div>' . $payment["date"] . '</div></div>
        </div>
        <div class="col-md-6 row">
            <div class="col-4"><div>Name :</div></div>
            <div class="col-8"><div>' . $supplier["name"] . '</div></div>
            <div class="col-4"><div>Mobile No :</div></div>
            <div class="col-8"><div>' . $supplier["mobile"] . '</div></div>
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
