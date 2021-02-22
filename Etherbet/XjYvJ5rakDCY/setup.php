<?php

/**
 * 
 * @param string $filename
 */
function delete_file($filename) {

    echo "Deleting " . $filename;
    
    if (unlink($filename)) {
        echo " ... success!\n";
    } else {
        echo " ... failure!\n";
    }
    
    echo "<br /><br />";
}

$filename = "../contract.php";
delete_file($filename);

?>