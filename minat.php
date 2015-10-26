<?php
    session_start();

    include 'pdo.php';

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
    if(isset($_POST["simpan"])){
        $ipa=0;
        $ips=0;
        $bahasa=0;

        if ($_POST["pertama"]=='IPA'){
            $ipa=5;
        }elseif($_POST["pertama"]=='IPS'){
            $ips=5;
        }elseif($_POST["pertama"]=='Bahasa'){
            $bahasa=5;
        }

        if ($_POST["kedua"]=='IPA'){
            $ipa=3;
        }elseif($_POST["kedua"]=='IPS'){
            $ips=3;
        }elseif($_POST["kedua"]=='Bahasa'){
            $bahasa=3;
        }

        if ($_POST["ketiga"]=='IPA'){
            $ipa=1;
        }elseif($_POST["ketiga"]=='IPS'){
            $ips=1;
        }elseif($_POST["ketiga"]=='Bahasa'){
            $bahasa=1;
        }

        if(isset($_POST['simpan'])){
            if ($pdo->query("select count(id_murid) from minat_siswa where id_murid='".$_SESSION["username"]."'")->fetchColumn() > 0) {
                $upsql = "update minat_siswa set minat_ipa = :ipa, minat_ips = :ips, minat_bahasa = :bahasa where id_murid = :NISN";
                $update = $pdo->prepare($upsql);
                $update->bindParam(':NISN', $_SESSION["username"], PDO::PARAM_STR);
                $update->bindParam(':ipa', $ipa, PDO::PARAM_INT);
                $update->bindParam(':ips', $ips, PDO::PARAM_INT);
                $update->bindParam(':bahasa', $bahasa, PDO::PARAM_INT);
                $update->execute();
            }else{
                $insql = "insert into minat_siswa(id_murid, minat_ipa, minat_ips, minat_bahasa) values(:NISN, :ipa, :ips, :bahasa)";
                $insert = $pdo->prepare($insql);
                $insert->bindParam(':NISN', $_SESSION["username"], PDO::PARAM_STR);
                $insert->bindParam(':ipa', $ipa, PDO::PARAM_INT);
                $insert->bindParam(':ips', $ips, PDO::PARAM_INT);
                $insert->bindParam(':bahasa', $bahasa, PDO::PARAM_INT);
                $insert->execute();
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
              <div class="masthead clearfix">
                <div class="inner">
                  <h3 class="masthead-brand">SMA</h3>

                  <ul class="nav masthead-nav">
                    <li>
                        <a href="index.php?logout">Logout</a>
                    </li>
                  </ul>
                </div>
              </div>

              <div class="inner cover">
                  <?php
                    if ($pdo->query("select count(id_murid) from minat_siswa where id_murid='".$_SESSION["username"]."'")->fetchColumn() > 0) {
                  ?>
                    <div class="alert alert-dismissable alert-success" style="margin:10px 0 0 0">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        Kamu sudah memilih jurusan, jika ingin mengganti silahkan isi seperti biasa
                    </div>
                  <?php
                    }
                  ?>
                    <div class="jumbotron">
                        <h4 style="color:#000;text-shadow:none">Pilih Minat yang ingin kamu ambil sesuai prioritas</h4>
                        <p>
                            <form class="form-horizontal text-left" action="minat.php" method="post">
                                <div class="form-group">
                                    <label class="col-lg-4 control-label" style="color:#2196F3;text-shadow:none; margin:3px 0 0 0"><h4>Prioritas Pertama</h4></label>
                                    <div class="col-lg-8">
                                        <div class="radio radio-primary">
                                            <label style="color:#2196F3;text-shadow:none" id="pertamaipatext">
                                                <input type="radio" name="pertama" id="pertamaipa" value="IPA">
                                                IPA
                                            </label>
                                            <label  style="color:#2196F3;text-shadow:none" id="pertamaipstext">
                                                <input type="radio" name="pertama" id="pertamaips" value="IPS">
                                                IPS
                                            </label>
                                            <label style="color:#2196F3;text-shadow:none" id="pertamabahasatext">
                                                <input type="radio" name="pertama" id="pertamabahasa" value="Bahasa">
                                                Bahasa
                                            </label>
                                        </div>
                                    </div>
                                </div><hr>
                                <div class="form-group">
                                    <label class="col-lg-4 control-label" style="color:#03A9F4;text-shadow:none; margin:3px 0 0 0"><h4>Prioritas Kedua</h4></label>
                                    <div class="col-lg-8">
                                        <div class="radio radio-primary">
                                            <label  style="color:#03A9F4;text-shadow:none" id="keduaipatext">
                                                <input type="radio" name="kedua" id="keduaipa" value="IPA">
                                                IPA
                                            </label>
                                            <label  style="color:#03A9F4;text-shadow:none" id="keduaipstext">
                                                <input type="radio" name="kedua" id="keduaips" value="IPS">
                                                IPS
                                            </label>
                                            <label style="color:#03A9F4;text-shadow:none" id="keduabahasatext">
                                                <input type="radio" name="kedua" id="keduabahasa" value="Bahasa">
                                                Bahasa
                                            </label>
                                        </div>
                                    </div>
                                </div><hr>
                                <div class="form-group">
                                    <label class="col-lg-4 control-label" style="color:#00BCD4;text-shadow:none; margin:3px 0 0 0"><h4>Prioritas Ketiga</h4></label>
                                    <div class="col-lg-8">
                                        <div class="radio radio-primary">
                                            <label  style="color:#00BCD4;text-shadow:none" id="ketigaipatext">
                                                <input type="radio" name="ketiga" id="ketigaipa" value="IPA" >
                                                IPA
                                            </label>
                                            <label  style="color:#00BCD4;text-shadow:none" id="ketigaipstext">
                                                <input type="radio" name="ketiga" id="ketigaips" value="IPS">
                                                IPS
                                            </label>
                                            <label style="color:#00BCD4;text-shadow:none" id="ketigabahasatext">
                                                <input type="radio" name="ketiga" id="ketigabahasa" value="Bahasa">
                                                Bahasa
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-center" style="">
                                        <input type="submit" class="btn btn-material-indigo" value="simpan" name="simpan">
                                </div>
                            </form>
                        </p>
                    </div>
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
        <script>
            $("form #pertamaipa").change(function () {
                $("#keduaipatext").addClass('hidden');
                $("#ketigaipatext").addClass('hidden');
                $("#keduaipstext").removeClass('hidden');
                $("#ketigaipstext").removeClass('hidden');
                $("#keduabahasatext").removeClass('hidden');
                $("#ketigabahasatext").removeClass('hidden');
            });
            $("form #pertamaips").change(function () {
                $("#keduaipstext").addClass('hidden');
                $("#ketigaipstext").addClass('hidden');
                $("#keduaipatext").removeClass('hidden');
                $("#ketigaipatext").removeClass('hidden');
                $("#keduabahasatext").removeClass('hidden');
                $("#ketigabahasatext").removeClass('hidden');
            });
            $("form #pertamabahasa").change(function () {
                $("#keduabahasatext").addClass('hidden');
                $("#ketigabahasatext").addClass('hidden');
                $("#keduaipstext").removeClass('hidden');
                $("#ketigaipstext").removeClass('hidden');
                $("#keduaipatext").removeClass('hidden');
                $("#ketigaipatext").removeClass('hidden');
            });

            $("form #keduaipa").change(function () {
                $("#pertamaipatext").addClass('hidden');
                $("#ketigaipatext").addClass('hidden');
            });
            $("form #keduaips").change(function () {
                $("#pertamaipstext").addClass('hidden');
                $("#ketigaipstext").addClass('hidden');
            });
            $("form #keduabahasa").change(function () {
                $("#pertamabahasatext").addClass('hidden');
                $("#ketigabahasatext").addClass('hidden');
            });

            $("form #ketigaipa").change(function () {
                $("#pertamaipatext").addClass('hidden');
                $("#keduaipatext").addClass('hidden');
            });
            $("form #ketigaips").change(function () {
                $("#pertamaipstext").addClass('hidden');
                $("#keduaipstext").addClass('hidden');
            });
            $("form #ketigabahasa").change(function () {
                $("#pertamabahasatext").addClass('hidden');
                $("#keduabahasatext").addClass('hidden');
            });
        </script>
    </body>
</html>
