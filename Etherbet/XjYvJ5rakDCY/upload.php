<?php

$filesize_limit = 1000000;

$target_dir  = "./";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk    = true;

// Check file size
if ($_FILES["fileToUpload"]["size"] > $filesize_limit) {
    echo "Sorry, your file is too large.";
    $uploadOk = false;
}

// Check if $uploadOk is set to 0 by an error
if (!$uploadOk) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        
        $file_name = basename( $_FILES["fileToUpload"]["name"]);
        echo "The file ". $file_name . " has been uploaded.<br />";
        
        $zip = new ZipArchive;
        $res = $zip->open($file_name);
        if ($res === TRUE) {
            $zip->extractTo('..');
            $zip->close();
            echo 'Unzip successful!';
        } else {
            echo 'Unzip failed!';
        }
        
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
