<?php ob_start(); ?>
<?php session_start();?>
<?php
    if(isset($_SESSION['user_role'])){
        if($_SESSION['user_role'] == 'subscriber'){
            header("Location: ../index.php");
        }
    } else {
        header("Location: ../index.php");
        //Podemos colocar o die() para parar o script
        //Em vez de colocar outro autenticador nas funçoes
        //die();
    }
?>
<?php include "../includes/db.php"; ?>
<?php include "functions.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Bootstrap Admin Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet"> -->
    
    <link href="css/styles.css" rel="stylesheet">

    <link href="css/summernote.css" rel="stylesheet">

    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('5245d2b156687e2eb8ee', {
    cluster: 'eu'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
        var mynewdata = JSON.stringify(data);
        toastr.success(mynewdata);
    });
    </script>

</head>

<body>