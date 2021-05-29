<?php
session_start();
if(!isset($_SESSION['logined']))
{
    header("Location: login.php");
}
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
    <title>Orders</title>
</head>

<body>
    <?php require("common/navbar.php");  ?>
    <div class="text-center small">
        <div id="order" class="border border-4 shadow p-2">
        </div>
        <hr><br>

    </div>
    <div class="modal fade bd-example-modal-lg p-1" id="orderd" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content container border border-4 p-1">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 m-0" id="orderdisc">
                </div>
            </div>
        </div>
    </div>

    <?php require("common/script.php"); ?>

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js">
    </script>

    <script>
    $(document).ready(function() {
        getorder();
    });

    setInterval(getorder, 60000);

    function printdiv(item) {
        var divContents = item.parentNode.innerHTML;
        var printWindow = window.open('', '');
        printWindow.document.write(
            `<html><head><title>Print DIV Content</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous"></head>`
        );
        printWindow.document.write('<body >');
        printWindow.document.write(divContents);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }

    function delivered(orderid) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                getorder();
                document.getElementById("x").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "list.php?list=orderdelivred&orderid=" + orderid, true);
        xhttp.send();
    }

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

    function getorder() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("order").innerHTML = this.responseText;
                $('#orders').DataTable();
            }
        };
        xhttp.open("GET", "list.php?list=order", true);
        xhttp.send();
    }
    </script>
</body>

</html>