<?php
include("db.php");
$sql = "SELECT COUNT(DISTINCT author) AS totalAuthors, COUNT(title) AS totalBooks FROM books";
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($res);
$data = array(
    "numAuth" => $row["totalAuthors"],
    "numBook" => $row["totalBooks"]
);
$sql = "SELECT author, COUNT(title) AS numBooks,
            MAX(publication_year) AS newestBook, MIN(publication_year)
            AS oldestBook FROM books GROUP BY author";
$res = mysqli_query($conn, $sql);
if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $listData[] = array(
            "author" => $row["author"],
            "numBooks" => $row["numBooks"],
            "newestBook" => $row["newestBook"],
            "oldestBook" => $row["oldestBook"]
        );
    }
    $data["list"] = $listData;
} else {
    $data["list"] = 1;
}
echo json_encode($data);
