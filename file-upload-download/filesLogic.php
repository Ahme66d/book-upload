<?php

// connect to database
$conn = mysqli_connect('localhost', 'root', '', 'file-management');

if(!$conn){
    die("Error");
}

$sql = "SELECT * FROM `upload_file`";

$result = mysqli_query($conn, $sql);

$files = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Uploads files

if (isset($_POST['save'])) { // if save button on the form is clicked
    // name of the uploaded file
    $filename = $_FILES['myfile']['name'];

    // destination of the file on the server
    $destination = 'uploads/' . $filename;

    // get the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    // the physical file on a temporary uploads directory on the server

    $file = $_FILES['myfile']['tmp_name'];
    $size = $_FILES['myfile']['size'];

    if (!in_array($extension, ['zip', 'pdf', 'docx', 'rar', 'ppt', 'pptx', 'html'])) {
        echo "<p style='
                color: red;
                font-size: 18px;
                text-align: center;
                width: 45%;
                margin: 40px auto;
                background-color: #756a6a
                '</p>You file extension must be .zip, .pdf or .docx or .rar or .ppt 
                or .pptx or .html </p>";
    } elseif ($size > 1000000000) {

     // file shouldn't be larger than 20 Megabyte
    
        echo "<p style='
                <p style='
                color: red;
                font-size: 18px;
                text-align: center;
                width: 37%;
                margin: 40px auto;
                background-color: #756a6a

                    '>File too large!</p>";
    } else {

        // move the uploaded (temporary) file to the specified destination


            if (move_uploaded_file($file, $destination)) {

                 $sql =  "INSERT INTO `upload_file` (`book_name`, `book_size`, 
                 `downloads`) 
                            VALUES ('$filename', $size, 0)";
            if (mysqli_query($conn, $sql)) {
                echo "<p style='
                color: #fff;
                font-size: 18px;
                text-align: center;
                width: 37%;
                margin: 40px auto;
                background-color: #756a6a

                '>File uploaded successfully</p>";
            }

    } else {
        echo "Sorry, there was an error uploading your file.";
    }

}

}



// Downloads files

if (isset($_GET['file_id'])) {
    $id = $_GET['file_id'];

    // fetch file to download from database

    $sql = "SELECT * FROM upload_file WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    
    $filepath = 'uploads/' . $file['name'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('uploads/' . $file['name']));
        readfile('uploads/' . $file['name']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE `upload_file` SET `downloads`=$newCount WHERE `id`=$id";
        mysqli_query($conn, $updateQuery);
        exit;
    }

}
