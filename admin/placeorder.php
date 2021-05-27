<?php
require("common/database.php");
$mobile = $_POST['mobile'];
$name = $_POST['name'];
$address = $_POST['address'];
$pincode = $_POST['pincode'];
$city = $_POST['city'];
$state = $_POST['state'];
$query = "SELECT email FROM `customer` WHERE `mobile`= '$mobile';";
$result = mysqli_query($con, $query);
$num = mysqli_num_rows($result);
if ($num == 0) {
    $query = "INSERT INTO `customer` (`custid`, `name`, `mobile`, `address`, `city`, `state`, `pincode`, `date`) VALUES (NULL,'$name', '$mobile', '$address', '$city', '$state', '$pincode', current_timestamp());";
    $result = mysqli_query($con, $query);
}
$query = "SELECT custid FROM `customer` WHERE `mobile`= '$mobile';";
$result = mysqli_query($con, $query);
$result = mysqli_fetch_all($result, MYSQLI_ASSOC);
$custid = $result[0]['custid'];
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
        }
    }
} else {
    echo
    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong>Order cannot be placed!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}
