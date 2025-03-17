<?php
session_start();
session_unset();
session_destroy();
header('Location: /AI_Forum_PHP_Project/public/');
exit;
?>