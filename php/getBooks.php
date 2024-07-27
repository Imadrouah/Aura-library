<?php
include("db.php");
if (empty($_GET["sort"]))
    $sql = "SELECT * FROM books";
else
    $sql = "SELECT * FROM books ORDER BY $_GET[sort]";
$res = mysqli_query($conn, $sql);
if (mysqli_num_rows($res) == 0) {
    echo 1;
    exit();
} else {
    $books = array();
    while ($row = mysqli_fetch_assoc($res)) {
        $books[] = array(
            "id" => $row["id"],
            "title" => $row["title"],
            "author" => $row["author"],
            "year" => $row["publication_year"],
            "pictype" => $row["pfp_type"]
        );
    }
    echo json_encode($books);
    exit();
}
