<?php 

ob_start(); //output buffering start هيخزن الاوتبوت معاده الهيدر
session_start();

if(isset($_SESSION['Username'])){
    $pageTitle='Dashboard';
    include 'init.php';
    //Start Dashboard Page

    $numUsers = 5;
    //علشان اطبع اخر خمس اعضاء
    $latestUser = getLatest("*" , "users" , "UserID" , $numUsers );
    $numItems = 6;
    //علشان اطبع اخر خمسitems ا
    $latestItems = getLatest("*" , "items" , "Item_ID" , $numItems );
    $numComments = 4;
    ?>



        <?php include 'dash.html'; ?>

    <?php
    //End Dashboard Page
    include $tpl . 'footer.php';
}
else{

    header('Location: index.php');

    exit();
}
ob_end_flush(); //يظهر الاوتبوت ع المتصفح
?>