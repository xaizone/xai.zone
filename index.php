<?php
const blacklistedMime = array(
    'text/html',
    'application/x-httpd-php',
    'application/xhtml+xml',
    'application/x-dosexec',
    'application/x-msdownload',
    'application/java-archive',
    'application/java-vm'
);

const blacklistedHost = array(
);

define("maxFileSize", "512000000");

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_FILES['file'])) {
        if(in_array($_SERVER['HTTP_X_FORWARDED_FOR'], blacklistedHost)) {
            echo "your ip address is blocked from uploading";
            return;
        }

        if($_FILES['file']['size'] > maxFileSize) {
            echo "file body size is too large";
            return;
        }

        if(in_array(mime_content_type($_FILES['file']['tmp_name']), blacklistedMime)) {
            echo "file type is blacklisted";
            return;
        }

        $filename = bin2hex(openssl_random_pseudo_bytes(8));
        $upload_type = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        if (move_uploaded_file($_FILES['file']['tmp_name'], $filename.'.'.$upload_type))
        {
            echo "https://".$_SERVER['HTTP_HOST']."/".$filename.".".$upload_type;
        }
    }
    else {
        echo "no file provided";
    }
}
else {
    echo "<pre>".file_get_contents("readme")."</pre>";
}
?>
