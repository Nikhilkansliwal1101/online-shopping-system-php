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
}