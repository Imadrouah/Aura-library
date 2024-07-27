<?php
include("db.php");
if (isset($_POST["idUpdate"])) {
    $id = $_POST["idUpdate"];
    $title = $_POST["title"];
    $author = $_POST["author"];
    $sql = "SELECT id FROM books WHERE title = '$title' AND author = '$author'";
    $res = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res) > 0) {
        echo 0;
        exit();
    }
    if (isset($_POST["year"])) {
        $year = date('Y-m-d', strtotime($_POST["year"]));
        $sql = "UPDATE books 
                SET title = '$title', author = '$author',
                publication_year = '$year' WHERE id = $id";
    } else
        $sql = "UPDATE books 
            SET title = '$title', author = '$author'
            WHERE id = $id";
    mysqli_query($conn, $sql);
    echo "Updated successfully!";
    exit();
} else if (isset($_POST["idDelete"])) {
    $sql = "SELECT pfp_type FROM books WHERE id = $_POST[idDelete] AND pfp_type != ''";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
    if (mysqli_num_rows($res) > 0) {
        if (file_exists("../imgs/books/book" . $_POST["idDelete"] .  "." . $row["pfp_type"])) {
            unlink("../imgs/books/book" . $_POST["idDelete"] .  "." . $row["pfp_type"]);
        }
    }
    $sql = "DELETE FROM books WHERE id =  $_POST[idDelete]";
    mysqli_query($conn, $sql);
    echo "Deleted successfully!";
    exit();
} else if (isset($_POST["deleteAll"])) {
    $sql = "SELECT id, pfp_type FROM books";
    $res = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($res)) {
        if (file_exists("../imgs/books/book" . $row["id"] .  "." . $row["pfp_type"])) {
            unlink("../imgs/books/book" . $row["id"] .  "." . $row["pfp_type"]);
        }
    }
    $sql = "TRUNCATE TABLE books";
    mysqli_query($conn, $sql);
    echo "Deleted all successfully!";
    exit();
}