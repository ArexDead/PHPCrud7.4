<?php
session_start();

$mysqli = new mysqli('localhost', 'root', '', 'crud') or die(mysqli_error($mysqli));

$id = 0;
$name = '';
$age = '';
$location = '';
$update = false;

if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $location = $_POST['location'];

    $mysqli->query("INSERT INTO data (name,age,location) VALUES('$name','$age','$location')") or
        die($mysqli->error);

    $_SESSION['message'] = "Record has been saved!";
    $_SESSION['msg_type'] = "success";

    header("location: index.php");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $mysqli->query("DELETE FROM data where id=$id") or die($mysqli->error());

    $_SESSION['message'] = "Record has been deleted!";
    $_SESSION['msg_type'] = "danger";
    header("location: index.php");
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $result = $mysqli->query("SELECT * FROM data WHERE id=$id") or die($mysqli->error());
    if ($result->num_rows) {
        $row = $result->fetch_array();
        $name = $row['name'];
        $age = $row['age'];
        $location = $row['location'];
    }
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $age  = $_POST['age'];
    $location = $_POST['location'];

    $mysqli->query("UPDATE data SET name = '$name', age = '$age', location = '$location' WHERE id = '$id' ") or die($mysqli->error());

    $_SESSION['message'] = "Record has been updated!";
    $_SESSION['msg_type'] = "warning";
    header("location: index.php");
}