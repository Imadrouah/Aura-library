<?php
include("db.php");
if (isset($_POST["live"])) {
    if (!empty($_POST["searchData"])) {
        $sql = "SELECT title, author FROM books 
                WHERE title LIKE '$_POST[searchData]%' OR
                author LIKE '$_POST[searchData]%' OR
                publication_year LIKE '$_POST[searchData]%'";
        $res  = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res) > 0) {
            $books = array();
            while ($row = mysqli_fetch_assoc($res)) {
                $books[] = array(
                    "title" => $row["title"],
                    "author" => $row["author"]
                );
            }
            echo json_encode($books);
            exit();
        }
    }
    echo 1;
    exit();
}
if (isset($_POST["search"])) {
    $sql = "SELECT * FROM books 
            WHERE title like '$_POST[searchData]%'
            OR author like '$_POST[searchData]%' 
            OR publication_year like '$_POST[searchData]%' 
            ORDER BY $_POST[sort]";

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
}
