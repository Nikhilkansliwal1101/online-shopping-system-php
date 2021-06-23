<?php
require("common/database.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['operation'] == 'placeorder') {
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
            $total = 0;
            foreach ($products as $product) {
                $pno = $product['pno'];
                $que = "SELECT purchaseprice,available,supplierid FROM `product` WHERE productno=$pno";
                $result = mysqli_query($con, $que);
                $result = mysqli_fetch_array($result);
                $purchaseprice = $result['purchaseprice'];
                $available = $result['available'];
                $supplierid = $result['supplierid'];
                $pname = $product['name'];
                $cgst = $product['cgst'];
                $sgst = $product['sgst'];
                $qty = $product['qty'];
                $mrp = $product['mrp'];
                $price = $product['price'];
                if ($available >= $qty) {
                    $update = "UPDATE `product` SET `available` = `available`-$qty, `sold` = `sold`+$qty WHERE `product`.`productno` = $pno;";
                    mysqli_query($con, $update);
                    $add = "INSERT INTO `orderdiscription` (`orderid`, `productno`, `pname`, `quantity`, `cgst`, `sgst`, `mrp`, `sellprice`, `purchaseprice`, `supplierid`, `paymentid`) VALUES ('$orderid', '$pno', '$pname', '$qty', '$cgst', '$sgst', '$mrp', '$price', '$purchaseprice', '$supplierid', NULL);";
                    mysqli_query($con, $add);
                    $total += $price * $qty;
                } else if ($available != 0) {
                    $qty = $available;
                    $update = "UPDATE `product` SET `available` = `available`-$qty, `sold` = `sold`+$qty WHERE `product`.`productno` = $pno;";
                    mysqli_query($con, $update);
                    $add = "INSERT INTO `orderdiscription` (`orderid`, `productno`, `pname`, `quantity`, `cgst`, `sgst`, `mrp`, `sellprice`, `purchaseprice`, `supplierid`, `paymentid`) VALUES ('$orderid', '$pno', '$pname', '$qty', '$cgst', '$sgst', '$mrp', '$price', '$purchaseprice', '$supplierid', NULL);";
                    mysqli_query($con, $add);
                    $total += $price * $qty;
                }
            }
            $query = "UPDATE `orders` SET `amount` = '$total' WHERE `orders`.`orderid` = '$orderid';";
            mysqli_query($con, $query);
        } else {
            echo
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong>Order cannot be placed!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_GET['operation'] == 'orderdelivred') {
        $orderid = $_GET['orderid'];
        $query = "UPDATE `orders` SET `status` = 'com', `deliverydate` = current_timestamp() WHERE `orders`.`orderid` = $orderid;";
        mysqli_query($con, $query);
    } else if ($_GET['operation'] == 'orderproducts') {
        $supplierid = $_GET['supplierid'];
        $query = "INSERT INTO `payment` (`paymentid`, `supplierid`, `amount`, `date`, `paid`,`collected`) VALUES (NULL, '$supplierid', '0', current_timestamp(), NULL,NULL);";
        $result = mysqli_query($con, $query);
        $paymentid = mysqli_insert_id($con);
        $query = "SELECT * FROM `orderdiscription` WHERE `supplierid`='$supplierid' and `paymentid` is null;";
        $products = mysqli_query($con, $query);
        $total = 0;
        while ($product = mysqli_fetch_assoc($products)) {
            $orderid = $product['orderid'];
            $productid = $product['productno'];
            $query = "UPDATE `orderdiscription` SET `paymentid` = '$paymentid' WHERE `orderdiscription`.`orderid` = '$orderid' AND `orderdiscription`.`productno` = '$productid';";
            mysqli_query($con, $query);
            $total += $product['purchaseprice'] * $product['quantity'];
        }
        $query = "UPDATE `payment` SET `amount` = '$total' WHERE `payment`.`paymentid` = '$paymentid';";
        mysqli_query($con, $query);
    } else if ($_GET['operation'] == 'paymentpaid') {
        $paymentid = $_GET['paymentid'];
        $query = "UPDATE `payment` SET `paid` = current_timestamp() WHERE `payment`.`paymentid` = $paymentid;";
        mysqli_query($con, $query);
    } else if ($_GET['operation'] == 'ordercollected') {
        $paymentid = $_GET['paymentid'];
        $query = "UPDATE `payment` SET `collected` = current_timestamp() WHERE `payment`.`paymentid` = $paymentid;";
        mysqli_query($con, $query);
    }
}
