<?php
require './db/db.php';
$delete = false;
$update = false;
$updatefail = false;

if (!$conn) {
    die("Sorry we failed to connect: " . mysqli_connect_error());
} else {

    if (isset($_GET['delete'])) {
        $sno = $_GET['delete'];
        $sql = "DELETE FROM `items` WHERE `itemId` = '$sno'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $delete = true;
        } else {
            $deletionFail = true;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['snoEdit'])) {
            // Update the record

            $id = $_POST["id"];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $des = $_POST['des'];
            
            // Sql query to be executed

            $sql = "UPDATE `items` SET `itemId` = '$id' , `itemName` = '$name' , `price` = '$price' , `description` = '$des' WHERE `items`.`itemId` = '$id'";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $update = true;
            } else {
                $updatefail = true;
                // echo "<script>alert('Could not update the record successfully !!')</script>";
            }
        }
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item List</title>

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Oswald:wght@500;600;700&family=Pacifico&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <!-- Edit Modal -->
    <div class="modal fade mx-auto" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog bg-dark text-white" role="document">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="editModalLabel">Edit Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="bg-dark mx-auto p-5 col-lg-6 text-white " action="itemList.php" method="post">
                    <input type="hidden" name="snoEdit" id="snoEdit">
                    <h1 class="text-center text-white pb-4">Update Item Information</h1>
                    <div class="mb-3">
                        <label class="form-label">Item ID</label>
                        <input type="number" class="form-control" name="id" id="editid" required readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Item Name</label>
                        <input type="text" class="form-control" name="name" id="editname" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" class="form-control" name="price" id="editprice" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <input type="text" class="form-control" name="des" id="editdes" required>
                    </div>

                    <div class="d-flex align-items-center justify-content-center ">
                        <button type="submit" class="py-3 mt-4 px-5 btn btn-outline-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Topbar and navbar Start -->
    <?php require './resource/navbar.php' ?>
    <!-- Topbar and navbar End -->

    <?php
    if ($delete) {
        echo "<div class='text-center alert alert-success alert-dismissible fade show' role='alert'>
                        <strong>Success!</strong>Item Deleted successfully !! 
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>×</span>
                        </button>
                    </div>";
    }
    if ($update) {
        echo "<div class='text-center alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Success!</strong> Information Updated Successfully !!
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>×</span>
            </button>
        </div>";
    }
    if ($updatefail) {
        echo "<div class=' text-center alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Failed!</strong> Could not update the Information successfully !!
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>×</span>
            </button>
        </div>";
    }
    ?>

    <!-- admin profile start -->

    <nav class="mt-5 px-5 py-3 d-flex flex-row justify-content-between align-items-center bg-dark">
        <h5 class=" text-white">Admin Section</h5>
        <button class="btn btn-primary">Logout</button>
    </nav>

    <div>
        <div class="row">
            <?php require './resource/sidebar.php' ?>

            <div class="col-9 bg-light overflow-auto">
                <h5 class="text-center mt-3">Item List</h5>

                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Description</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require './db/db.php';
                        if (!$conn) {
                            die("Sorry we failed to connect: " . mysqli_connect_error());
                        }

                        $sql = "SELECT * FROM `items` ORDER BY `itemId`";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {

                            echo " <tr>
                                <td>" . $row['itemId'] . "</td>
                                <td>" . $row['itemName'] . "</td>
                                <td>" . $row['price'] . "</td>
                                <td>" . $row['description'] . "</td>
                                <td>
                                <button class='update m-1 btn btn-sm btn-primary'>Update</button>
                                <button class='delete m-1 btn btn-sm btn-primary'>Delete</button>
                                </td>
                                </tr>";
                        }
                        ?>

                    </tbody>
                </table>

            </div>
        </div>

    </div>

    <!-- admin profile end -->


    <!-- Footer Start -->
    <?php require './resource/footer.php' ?>
    <!-- Footer End -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <script>
    updates = document.getElementsByClassName('update');
    Array.from(updates).forEach((element) => {
        element.addEventListener("click", (e) => {
            tr = e.target.parentNode.parentNode;

            id = tr.getElementsByTagName("td")[0].innerText;
            name = tr.getElementsByTagName("td")[1].innerText;
            price = tr.getElementsByTagName("td")[2].innerText;
            des = tr.getElementsByTagName("td")[3].innerText;

            editid.value = id;
            editname.value = name;
            editprice.value = price;
            editdes.value = des;

            snoEdit.value = e.target.id;

            console.log(id);

            $('#editModal').modal('toggle');
        })
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log("delete");
            tr = e.target.parentNode.parentNode;
            sno = tr.getElementsByTagName("td")[0].innerText;

            if (confirm("Are you sure you want to delete this item!")) {
                window.location = `itemList.php?delete=${sno}`;
            }
        })
    })
    </script>
</body>

</html>