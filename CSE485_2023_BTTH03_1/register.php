<?php
//Khai báo autoloader
require_once 'vendor/autoload.php';
$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/src');
$twig = new \Twig\Environment($loader);
$error=isset($_GET['error'])?$_GET['error']:'';
echo $twig->render('register.html', [
    'error'=>$error
]);
