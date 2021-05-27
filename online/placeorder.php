<?php
require("common/database.php");
$custid = $_POST['c'];
$query = "INSERT INTO `orders` (`orderid`, `custid`, `orderdate`, `status`) VALUES (NULL, '$custid', current_timestamp(), 'notcom');";
$result = mysqli_query($con, $query);
$orderid = mysqli_insert_id($con);
if ($result) {
    $products = json_decode($_POST['products'], true);
    foreach ($products as $product) {
        $pno = $product['pno'];
        $que = "SELECT purchaseprice,available FROM `product` WHERE productno=$pno";
        $result = mysqli_query($con, $que);
        $result = mysqli_fetch_array($result);
        $purchaseprice = $result['purchaseprice'];
        $available = $result['available'];
        $pname = $product['name'];
        $cgst = $product['cgst'];
        $sgst = $product['sgst'];
        $qty = $product['qty'];
        $mrp = $product['mrp'];
        $price = $product['price'];
        if ($available >= $qty) {
            $update = "UPDATE `product` SET `available` = `available`-$qty WHERE `product`.`productno` = $pno;";
            mysqli_query($con, $update);
            $add = "INSERT INTO `orderdiscription` (`orderid`, `productno`, `pname`, `quantity`, `cgst`, `sgst`, `mrp`, `sellprice`, `purchaseprice`) VALUES ('$orderid', '$pno', '$pname', '$qty', '$cgst', '$sgst', '$mrp', '$price', '$purchaseprice');";
            mysqli_query($con, $add);
        } else if ($available != 0) {
            $qty = $available;
            $update = "UPDATE `product` SET `available` = `available`-$qty WHERE `product`.`productno` = $pno;";
            mysqli_query($con, $update);
            $add = "INSERT INTO `orderdiscription` (`orderid`, `productno`, `pname`, `quantity`, `cgst`, `sgst`, `mrp`, `sellprice`, `purchaseprice`) VALUES ('$orderid', '$pno', '$pname', '$qty', '$cgst', '$sgst', '$mrp', '$price', '$purchaseprice');";
            mysqli_query($con, $add);
        }
    }
} else {
    echo
    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong>Order cannot be placed!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}
