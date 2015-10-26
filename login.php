<?php
    session_start();

    include 'pdo.php';
    $callback = 'minat.php';
    if(isset($_POST['login-siswa'])){
        $username=$_POST['username'];
        if($exec = $pdo->query("select count(id_murid) from murid where id_murid='".$username."'")->fetchColumn()>0){
            $_SESSION["username"] = $username; // buat session username.\
            header("location:minat.php"); // Re-direct ke main.php
            exit;
        }else{
            header("location:index.php?error=NISN yang anda inputkan salah atau tidak terdaftar");
        }
    }

    if(isset($_GET["logout"])){
       session_destroy();
       header("location:index.php");
    }

    if(isset($_GET["from"])){
          $callback = $_GET["from"];
    }
?>
