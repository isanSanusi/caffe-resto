<?php
$hostname = "localhost";
$database_name = "sans_caffe_and_resto";
$username = "root";
$password = "";

$database = mysqli_connect($hostname,$username,$password,$database_name);

if($database -> connect_error) {
    echo "Connection error!";
    die();
};
// echo "Connection Success!";