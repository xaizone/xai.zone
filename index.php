<?php
include 'config.php';
const blacklistedMime = array(
    'text/html',
    'application/x-httpd-php',
    'application/xhtml+xml',
    'application/x-dosexec',
    'application/x-msdownload',
    'application/java-archive'
);

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo "<pre>".file_get_contents('readme')."</pre>";
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_FILES['file'])) {
        if($_FILES['file']['size'] > maxFileSize) {
            echo "file body size is too large";
            return;
        }

        if(in_array(mime_content_type($_FILES['file']['tmp_name']), blacklistedMime)) {
            echo "file type is blacklisted";
            return;
        }

        $filename = bin2hex(random_bytes(uploadLength));
        $upload_type = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        if (move_uploaded_file($_FILES['file']['tmp_name'], uploadFolder."/".$filename.'.'.$upload_type)){
            echo (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ? "https" : "http")."://".$_SERVER['HTTP_HOST']."/".$filename.".".$upload_type;
        }
    } else if (isset($_POST['url'])) {
        if (filter_var($_POST['url'], FILTER_VALIDATE_URL)) {
            $id = bin2hex(random_bytes(urlLength));
            if (file_put_contents(urlFolder."/".$id, $_POST['url'])) {
                echo (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ? "https" : "http")."://".$_SERVER['HTTP_HOST']."/".$id;
            } else {
                echo "failed writing file";
            }
        } else {
            echo "invalid url";
        }
    }
    else {
        echo "no file provided";
    }
}
?>
