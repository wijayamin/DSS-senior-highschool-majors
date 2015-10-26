<?php
    session_start();

    include 'pdo.php';
    $callback = 'index.php';
    if(isset($_POST['login-guru'])){
        $username=$_POST['username'];
        $password=$_POST['password'];
        $query = "select * from guru where id_guru='".$username."' and password='".$password."'";
        $exec = $pdo->query($query);
        if($exec = $pdo->query("select count(id_guru) from guru where id_guru='".$username."' and password='".$password."'")->fetchColumn()>0){
            foreach($pdo->query($query) as $row){
                $_SESSION["username"] = $username; // buat session username.
                header("location:".$_POST['url']); // Re-direct ke main.php
                exit;
            }
        }else{
            header("location:index.php?error=Username Atau PIN yang anda inputkan salah");
        }
    }


    if(isset($_GET["logout"])){
       session_destroy();
       header("location:index.php");
    }

    if(isset($_GET["from"])){
          $callback = $_GET["from"];
    }
    if(isset($_SESSION["username"])){
        $exec = $pdo->query("select privileges from guru where id_guru='".$_SESSION["username"]."'");
        foreach($exec as $row){
            if ($row[0]=="admin"){
                header("location:tu/");
            }elseif($row[0]=="guru"){
                header("location:guru/");
            }else{
                header("location:minat.php");
            }
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Penjurusan Siswa SMA Online</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- include CSS dari sononye Broo -->
        <link href="res/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="res/css/roboto.min.css" rel="stylesheet">
        <link href="res/css/material-fullpalette.min.css" rel="stylesheet">
        <link href="res/css/ripples.min.css" rel="stylesheet">

        <!-- include CSS buatan lu sendiri Broo -->
        <link href="res/css/home.css" rel="stylesheet">

    </head>
    <body>
        <div class="site-wrapper">
          <div class="site-wrapper-inner">
            <div class="cover-container">

        <?php
                    if(isset($_GET["error"])){
                ?>
                        <div class="alert alert-dismissable alert-danger">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <?php echo $_GET["error"]; ?>
                        </div>
                <?php
                    }
        ?>
              <div class="masthead clearfix">
                <div class="inner">
                  <h3 class="masthead-brand">SMA</h3>

                  <ul class="nav masthead-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>&nbsp;&nbsp;Login&nbsp;&nbsp;</b> <span class="caret"></span></a>
                        <ul id="login-dp" class="dropdown-menu">
                            <li>
                                <div class="row">
                                    <div class="col-md-12">
                                        <form class="form" role="form" method="post" action="index.php" accept-charset="UTF-8" id="login-nav">
                                            <div class="form-group">
                                                <input type="hidden" name="url" value="<?php echo $callback; ?>">
                                                <label class="sr-only" for="exampleInputEmail2">NIK</label>
                                                <input type="text" name="username" class="form-control floating-label" id="exampleInputEmail2" placeholder="NIK" style="color:#fff" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="sr-only" for="exampleInputPassword2">PIN</label>
                                                <input type="password" name="password" class="form-control floating-label" id="exampleInputPassword2" placeholder="PIN" style="color:#fff" required>
                                                <div class="help-block text-right"><a href="">Lupa PIN</a></div>
                                            </div>
                                            <div class="form-group">
                                              <button type="submit" class="btn btn-primary btn-block" name="login-guru" value="login">Masuk</button>
                                            </div>
                                            <div class="checkbox">
                                              <label>
                                              <input type="checkbox"> Tetap Masuk
                                              </label>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                  </ul>
                </div>
              </div>

              <div class="inner cover">
                <h1 class="cover-heading">Penentuan Jurusan SMA Online</h1>

                <p class="lead">Selamat datang siswa/siswi yang akan memilih jurusan.
                    siswa/siswi dapat memilih jurusan dengan melakukan login untuk memilih jurusan yang dikehendaki
                <p class="lead text-center">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3">
                        <form method="post" action="login.php">
                            <div class="form-group">
                                <input type="hidden" name="url" value="login.php">
                                <input class="form-control floating-label" id="focusedInput" type="text" placeholder="Nomor Induk Siswa Nasional(NISN)" name="username" style="color:#fff;text-align:center" required>
                            </div>
                            <input class="btn btn-primary" type="submit" value="MASUK" name="login-siswa">
                        </form>
                    </div>

                </p>
              </div>

              <div class="mastfoot">
                <div class="inner">
                  <!-- Validation -->

                  <p><a href=
                  "#"
                  target="_blank"><small>V 0.2</small></a></p>


                  <p><a href=
                  "http://abankirenk.com"
                  target="_blank"><small>Background Image from ABANKIRENK Creative with Common License</small></a></p>



                  <p>© 2014 Kelompok 13  ~ <a href=
                  "http://Wijayamin.tk/">Metode AHP</a></p>
                </div>
              </div>
            </div>
        </div>
        </div>


        <!-- include JSnye Broo -->
        <script src="res/js/jquery-1.10.2.min.js"></script>
        <script src="res/js/bootstrap.min.js"></script>
        <script src="res/js/ripples.min.js"></script>
        <script src="res/js/material.min.js"></script>

        <!-- JS wajib Broo -->
        <script>
            $(document).ready(function() {
                // This command is used to initialize some elements and make them work properly
                $.material.init();
            });
        </script>
    </body>
</html>
