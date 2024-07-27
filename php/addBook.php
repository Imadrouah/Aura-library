<?php
include("db.php");
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["title"])) {
    $title = $_POST["title"];
    $author = $_POST["author"];
    $year = $_POST["year"];
    $conv = date('Y-m-d', strtotime($year));

    $sql = "SELECT * FROM books WHERE title = \"$title\" AND author = \"$author\"";
    $res = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res) > 0) {
        echo 1;
        exit();
    }

    $sql = "INSERT INTO books (title, author, publication_year) VALUES (\"$title\",\"$author\",\"$conv\")";

    if (isset($_FILES["image"])) {

        $file = $_FILES["image"];
        $fileName = $file["name"];
        $fileSize = $file["size"];
        $fileTemp = $file["tmp_name"];
        $fileErr = $file["error"];
        $fileNameExt = explode(".", $fileName);
        $fileType = strtolower(end($fileNameExt));

        if ($fileErr === 0) {
            if ($fileSize < 1000000) {
                mysqli_query($conn, $sql);

                $sql = "SELECT id FROM books WHERE title = \"$title\" AND author = \"$author\" AND publication_year = \"$year\"";
                $res = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($res);

                $fileDest = "imgs/books/" . "book" . $row["id"] . "." . $fileType;
                move_uploaded_file($fileTemp, $fileDest);
                $sql =  "UPDATE books SET pfp_type = '$fileType' WHERE id = $row[id]";
                mysqli_query($conn, $sql);
                echo 2;
                exit();
            } else {
                $response = array(
                    "err" => 3,
                    "res" => "The image is too big! (" . floor($fileSize / 1e+6 * 100) / 100 . " mb)"
                );
                echo json_encode($response);
                exit();
            }
        } else {
            $response = array(
                "err" => 3,
                "res" => "There was an error uploading your image."
            );
            echo json_encode($response);
            exit();
        }
    } else {
        mysqli_query($conn, $sql);
        echo 2;
        exit();
    }
}
