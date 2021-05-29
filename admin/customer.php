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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php require("common/navbar.php"); ?>
    <div class="text-center small">
        <div class="shadow border border-4 p-2">
            <div class="card my-4 shadow">
                <div class="card-header">
                    <h1>Customers</h1>
                </div>
            </div>
            <div class="table-responsive mw-100">
                <table id="customertable" class="table table-striped table-hover table-bordered text-wrap">
                    <thead>
                        <tr>
                            <th scope="col" style="display: none">Custid</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Mobile No</th>
                            <th scope="col">Address</th>
                            <th scope="col">Pincode</th>
                            <th scope="col">City</th>
                        </tr>
                    </thead>
                    <tbody id="customer">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php require("common/script.php"); ?>

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js">
    </script>

    <script>
        $(document).ready(function() {
            $('#customertable').DataTable();
            getcustomer();
        });

        function getcustomer() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {

                if (this.readyState == 4 && this.status == 200) {
                    var table = $('#customertable').DataTable();
                    table.destroy();
                    document.getElementById("customer").innerHTML =
                        this.responseText;
                    $('#customertable').DataTable();
                }
            };
            xhttp.open("GET", "list.php?list=customer", true);
            xhttp.send();
        }
    </script>
</body>


</html>