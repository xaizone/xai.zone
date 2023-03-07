<?php
include 'config.php';
if($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['id'])) {
    if (file_exists(urlFolder."/".$_GET['id'])) {
		header("Location: ".file_get_contents(urlFolder."/".$_GET['id']));
    } else {
		http_response_code(404);
        echo "<pre>404 not found</pre>";
    }
}
?>