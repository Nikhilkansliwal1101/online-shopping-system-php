<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <title>Cart</title>
</head>

<body>
    <?php require("common/navbar.php"); ?>
    <div class="small mb-5">
        <div id="cart" class="border border-4 p-1 shadow">
            <div class="card p-3 shadow text-center">
                <div class="card-header">
                    <h1>Your Cart</h1>
                </div>
            </div>
            <div id="currentorder" class="table-responsive">

            </div>
            <?php
            if (isset($_SESSION['custid'])) {
                echo
                '<div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-outline-success w-50" onclick=placeorder()>Place Order</button>
                </div>
        </div>
        <br>
        <hr><br>       
        <div id="preorder" class="border border-4 shadow p-2">';
            } else {
                echo
                '<div class="d-flex justify-content-center">
                    <a href="login.php"><button type="button" class="btn btn-outline-danger">Login for Continue</button></a>
                </div>';
            }
            ?>
        </div>
        <br>
        <hr><br>
    </div>
    <div class="modal fade bd-example-modal-lg p-0 m-0" id="orderd" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content container border border-4 p-0 m-0">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 m-0" id="orderdisc">
                </div>
            </div>
        </div>
    </div>



    <?php require("common/script.php");
    require("common/footer.php"); ?>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js">
    </script>
    <script>
        var total_disc = 0;
        var total_amt = 0;
        var total_cgst = 0;
        var total_sgst = 0;
        var total_mrp = 0;
        var products = [];
        var c = <?php if (isset($_SESSION['custid'])) echo $_SESSION['custid'];
                else echo '0' ?>;
        $(document).ready(function() {
            currentorder();
            if (c != '0')
                getpreorder();
        });

        function getorderdisc(orderid) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("orderdisc").innerHTML = this.responseText;
                    $('#orderd').modal('toggle');
                }
            };
            xhttp.open("GET", "list.php?list=orderdisc&orderid=" + orderid, true);
            xhttp.send();
        }

        function getpreorder() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("preorder").innerHTML = this.responseText;
                    $('#preorders').DataTable();
                }
            };
            xhttp.open("GET", "list.php?list=order&c=" + c, true);
            xhttp.send();
        }

        function placeorder() {
            let xhr = new XMLHttpRequest();
            let url = "placeorder.php";
            let data = "products=" + JSON.stringify(products) + "&custid=" + c;
            xhr.open("POST", url, true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById("currentorder").innerHTML = this.responseText;
                    if (this.responseText == "") {
                        document.getElementById("cart").innerHTML =
                            `<div class="card p-3 shadow text-center">
                                <div class="card-header">
                                    <h1>Your Cart</h1>
                                    <img src="images/emptycart.png" class="img-fluid" alt="Responsive image">
                                </div>
                            </div>`;;
                        localStorage.removeItem('cart');
                        getpreorder();
                    }
                }
            };
            xhr.send(data);
        }

        function removeitem(pid) {
            cart = JSON.parse(localStorage.getItem('cart'));
            for (i = 0; i < cart.length; i++) {
                if (cart[i]['pno'] == pid) {
                    cart.splice(i, 1);
                    break;
                }
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            currentorder();
        }

        function currentorder() {
            cart = JSON.parse(localStorage.getItem('cart'));
            var x = "";
            total_disc = 0;
            total_amt = 0;
            total_cgst = 0;
            total_sgst = 0;
            total_mrp = 0;
            products = [];
            if ((cart != null) && (cart.length > 0)) {
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
                for (i = 0; i < cart.length; i++) {
                    var product = {};
                    var pid = cart[i]['pno'];
                    var name = cart[i]['name'];
                    var qty = parseFloat(cart[i]['quantity']);
                    var cgst = parseFloat(cart[i]['cgst']);
                    var sgst = parseFloat(cart[i]['sgst']);
                    var price = parseFloat(cart[i]['price']);
                    var mrp = parseFloat(cart[i]['mrp']);
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
                        <td><button type="button" class="btn btn-close bg-danger p-2" onclick="removeitem(` +
                        pid + `)"></button></td>
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
                        <td>TOTAL TAX:</td>
                        <td><span>&#8377; </span>` + (total_cgst + total_sgst) + `</td>
                        <td></td>
                        <td>NET AMT:</td>
                        <td><span>&#8377; </span>` + total_amt + `</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>`;
            }
            if (x != "") {
                document.getElementById("currentorder").innerHTML = x;
            } else {
                document.getElementById("cart").innerHTML =
                    `<div class="card p-3 shadow text-center">
                        <div class="card-header">
                            <h1>Your Cart</h1>
                            <img src="images/emptycart.png" class="img-fluid" alt="Responsive image">
                        </div>
                    </div>`;
            }
        }
    </script>
</body>

</html>