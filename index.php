<?php
session_start();
require('connection.php');
$edit = false;
$id = $fname = $lname = $dob = $city = "";
function getAllData($conn)
{
    $sql_getData = "SELECT * FROM user_info";
    $result = mysqli_query($conn, $sql_getData);
    return $result;
}
function getEditData($conn, $id)
{
    $sql_user_data = "SELECT * FROM user_info WHERE id=" . $id;
    $edit_record = mysqli_query($conn, $sql_user_data);
    return $edit_record;
}
$table_data = getAllData($conn);
if (isset($_POST['insert'])) {
    $_SESSION['message'] = "Record Inserted!";
    $sql_insert = 'INSERT INTO user_info (first_name,last_name,dob,city) VALUES ("' . $_POST["fname"] . '","' . $_POST["lname"] . '","' . $_POST["dob"] . '", "' . $_POST["city"] . '")';
    if (mysqli_query($conn, $sql_insert)) {
        echo "Data Inserted";
        header('location:index.php');
        exit;
    } else {
        echo "Error:" . $sql_insert . "<br>" . mysqli_error($conn);
    }
}
if (isset($_GET['edit'])) {
    $edit = true;
    $userRecord = getEditData($conn, $_GET['edit']);
    $row_array = mysqli_fetch_array($userRecord);
    $id = $row_array['id'];
    $fname = $row_array['first_name'];
    $lname = $row_array['last_name'];
    $dob = $row_array['dob'];
    $city = $row_array['city'];
}
if (isset($_POST['update'])) {
    $_SESSION['message'] = "Record Updated!";
    $fn = $_POST['fname'];
    $ln = $_POST['lname'];
    $dob_new = $_POST['dob'];
    $cty = $_POST['city'];
    $sql_update = "UPDATE user_info SET first_name = '$fn', last_name = '$ln',dob = '$dob_new', city = '$cty' WHERE id =" . $id;
    mysqli_query($conn, $sql_update);
    header('location:index.php');
    exit;
}
if (isset($_GET['delete'])) {
    var_dump($_GET);
    $_SESSION['message'] = "Record Deleted!";
    $sql_delete = "DELETE FROM user_info WHERE id=" . $_GET['delete'];
    mysqli_query($conn, $sql_delete);
    header('location:index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Php Mysql Crud App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <section class="form-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h3>PHP Crud App 2021</h3>
                </div>
                <div class="col-lg-6 m-auto">
                    <?php if (isset($_SESSION['message'])) { ?>
                        <div class="alert alert-primary" role="alert">
                            <?php
                            echo $_SESSION['message'];
                            unset($_SESSION['message']); ?>
                        </div>
                    <?php } ?>

                    <form action="" method="post">
                        <div class="form-group">
                            <label for="">First Name</label>
                            <input type="text" class="form-control" name="fname" id="fanme" value="<?php echo $fname; ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Last Name</label>
                            <input type="text" class="form-control" name="lname" id="lanme" value="<?php echo $lname; ?>">
                        </div>
                        <div class="form-group">
                            <label for="">DOB</label>
                            <input type="date" class="form-control" name="dob" id="dob" value="<?php echo $dob; ?>">
                        </div>
                        <div class="form-group">
                            <label for="">City</label>
                            <input type="text" class="form-control" name="city" id="city" value="<?php echo $city; ?>">
                        </div>
                        <div class="form-group mt-3">
                            <?php if ($edit) { ?>
                                <input type="submit" name="update" class="btn btn-success" value="Update">
                            <?php } else { ?>
                                <input type="submit" name="insert" class="btn btn-success" value="Submit">
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section class="table-display mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <th>Sr.no</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>DOB</th>
                                <th>City</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($table_data)) {  ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['first_name']; ?></td>
                                        <td><?php echo $row['last_name']; ?></td>
                                        <td><?php echo $row['dob']; ?></td>
                                        <td><?php echo $row['city']; ?></td>
                                        <td><a href="?edit=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a> <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>