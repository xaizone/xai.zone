<?php
include 'config.php';
if($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['id'])) {
    if (file_exists(urlFolder."/".$_GET['id'])) {
		header("Location: ".file_get_contents(urlFolder."/".$_GET['id']));
    } else {
		header("Location: ".(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ? "https" : "http").'://'.$_SERVER['HTTP_HOST']);
    }
}
?>