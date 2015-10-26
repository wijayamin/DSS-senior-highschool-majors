<?php
session_start();
include '../pdo.php';
if(!isset($_SESSION["username"])){
    header("location:../index.php?from=".$_SERVER['REQUEST_URI']);
}
    $exec = $pdo->query("select privileges from guru where id_guru='".$_SESSION["username"]."'");
    foreach($exec as $row){
        if ($row[0]=="admin"){
            header("location:../guru/");
        }
    }

$pageini="Minat Murid";

?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $pageini; ?> - Penjurusan Siswa SMA Online</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- include CSS dari sononye Broo -->
        <link href="../res/css/normalize.css" rel="stylesheet">
        <link href="../res/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="../res/css/roboto.min.css" rel="stylesheet">
        <link href="../res/css/material-fullpalette.min.css" rel="stylesheet">
        <link href="../res/css/ripples.min.css" rel="stylesheet">
        <link href="../res/css/material-design-iconic-font.min.css" rel="stylesheet">

        <!-- include CSS buatan lu sendiri Broo -->
        <link href="../res/css/sidebar.css" rel="stylesheet">

    </head>
    <body>
        <!-- Sidebarnye bro -->
        <?php include 'navbar.php'; ?>

        <!-- contentnye bro -->
        <div class="wrapper">
          <!-- Sidebar Constructor -->
            <div id="murid" class="constructor">
                <div class="well well-sm" style="margin-top:5px">
                        <ul class="breadcrumb pull-left" style="margin-bottom:5px; background-color:#fff;">
                            <li><a href="javascript:void(0)">Daftar Murid Kelas</a></li>
                            <li class="active"></li>
                        </ul>
                        <div class="input-group text-right">
                                <input type="text" class="search form-control" style="max-width:200px;" placeholder="Cari Murid">
                                <span class="input-group-btn">
                                    <button class="btn btn-flat  btn-material-white btn-xs" type="button" ><i class="mdi-action-search"></i></button>
                                </span>
                        </div>
                </div>


                <div class="panel">
                    <div class="panel-heading text-right">
                        <ul class="nav nav-pills" style="margin:10px 0 0 0">
                            <li>
                                <a href="javascript:void(0)">
                                    Jumlah Murid
                                    <span class="badge">
                                        <?php
                                            $exec = $pdo->query("select count(m.id_murid) from murid m, walikelas w where m.id_walikelas=w.id_walikelas and w.id_guru='".$_SESSION["username"]."'");
                                            echo $exec->fetchColumn();
                                        ?>
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <div class="form-group" style="margin:0 0 -5px 0;">
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-hover ">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Induk</th>
                                    <th>Nama</th>
                                    <th>Prioritas 1</th>
                                    <th>Prioritas 2</th>
                                    <th>Prioritas 3</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <?php
                                    $exec = $pdo->query("select m.id_murid, m.nama_murid from murid m, walikelas w where m.id_walikelas=w.id_walikelas and w.id_guru='".$_SESSION["username"]."'");
                                    $i=1;
                                    foreach($exec as $row){
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td class="nisn"><?php echo $row[0]; ?></td>
                                    <td class="nama"><?php echo $row[1]; ?></td>
                                    <?php
                                        foreach($pdo->query("select minat_ipa, minat_ips, minat_bahasa from minat_siswa where id_murid='".$row[0]."'") as $raw){
                                            if($raw[0]=='1'){
                                                echo "<td>IPA</td>";
                                            }elseif($raw[1]=='1'){
                                                echo "<td>IPS</td>";
                                            }elseif($raw[2]=='1'){
                                                echo "<td>Bahasa</td>";
                                            }

                                            if($raw[0]=='3'){
                                                echo "<td>IPA</td>";
                                            }elseif($raw[1]=='3'){
                                                echo "<td>IPS</td>";
                                            }elseif($raw[2]=='3'){
                                                echo "<td>Bahasa</td>";
                                            }

                                            if($raw[0]=='5'){
                                                echo "<td>IPA</td>";
                                            }elseif($raw[1]=='5'){
                                                echo "<td>IPS</td>";
                                            }elseif($raw[2]=='5'){
                                                echo "<td>Bahasa</td>";
                                            }

                                        }
                                    ?>

                                </tr>
                                <?php
                                        $i++;
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <!-- include JSnye Broo -->
        <script src="../res/js/jquery-1.10.2.min.js"></script>
        <script src="../res/js/bootstrap.min.js"></script>
        <script src="../res/js/ripples.min.js"></script>
        <script src="../res/js/material.min.js"></script>
        <script src="../res/js/sidebar.js"></script>
        <script src="../res/js/modernizr.js"></script>
        <script src="../res/js/list.min.js"></script>

        <!-- JS wajib Broo -->
        <script>
            $(document).ready(function() {
                // This command is used to initialize some elements and make them work properly
                $.material.init();
            });
        </script>
        <script>
            var options = {
              valueNames: [ 'nisn', 'nama', 'kelas' ]
            };

            var userList = new List('murid', options);
        </script>
    </body>
</html>
