<?php
require 'vendor/autoload.php';
require 'Utils/MyEmailServer.php';
require 'Utils/EmailSender.php';
$emailServer = new MyEmailServer();
$emailSender = new EmailSender($emailServer);
// $emailSender->send("duchai0501@gmail.com", "Điểm Danh", "Lê đức hải điểm danh");
