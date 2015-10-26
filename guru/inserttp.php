<?php
session_start();
include '../pdo.php';
if(!isset($_SESSION["username"])){
    header("location:../index.php?from=".$_SERVER['REQUEST_URI']);
}
    $exec = $pdo->query("select privileges from guru where id_guru='".$_SESSION["username"]."'");
    foreach($exec as $row){
        if ($row[0]=="admin"){
            header("location:../tu/");
        }
    }
    $pageini = 'Input Nilai Mapel';

#insert data
if(isset($_POST['simpan'])){
    if ($pdo->query("select count(id_nilai) from nilai_tp where id_murid='".$_GET["nisn"]."'")->fetchColumn() == 0) {
        $nisn=$_GET["nisn"];
        $id_mapel=$_POST["id_mapel"];
        $nilai=$_POST["nilai"];
        $i=0;
        foreach($id_mapel as $row){
            $insql = "insert into nilai_tp(id_kelompok, id_murid, nilai) values(:id_mapel, :NISN, :nilai)";
            $insert = $pdo->prepare($insql);
            $insert->bindParam(':id_mapel', $id_mapel[$i], PDO::PARAM_INT);
            $insert->bindParam(':NISN', $nisn, PDO::PARAM_STR);
            $insert->bindParam(':nilai', $nilai[$i], PDO::PARAM_INT);
            $insert->execute();
            $i++;
        }
    }
}
#update data
if(isset($_POST['update'])){
    $nisn=$_GET["nisn"];
    $id_mapel=$_POST["id_mapel"];
    $nilai=$_POST["nilai"];
    $i=0;
    foreach($id_mapel as $row){
        $upsql = "update nilai_tp set nilai = :nilai where id_kelompok = :id_mapel and id_murid = :NISN";
        $update = $pdo->prepare($upsql);
        $update->bindParam(':NISN', $nisn, PDO::PARAM_STR);
        $update->bindParam(':id_mapel', $id_mapel[$i], PDO::PARAM_INT);
        $update->bindParam(':nilai', $nilai[$i], PDO::PARAM_INT);
        $update->execute();
        $i++;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Penjurusan Siswa SMA Online</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- include CSS dari sononye Broo -->
        <link href="../res/css/normalize.css" rel="stylesheet">
        <link href="../res/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="../res/css/roboto.min.css" rel="stylesheet">
        <link href="../res/css/material-fullpalette.min.css" rel="stylesheet">
        <link href="../res/css/ripples.min.css" rel="stylesheet">

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
                        <ul class="breadcrumb" style="margin-bottom:5px; background-color:#fff;">
                            <li><a href="javascript:void(0)">Nilai Murid Kelas</a></li>
                            <li><a href="tp.php">Nilai Mata Pelajaran</a></li>
                            <li class="active">Input Nilai</li>
                </div>
            <?php
                if ($pdo->query("select count(id_nilai) from nilai_tp where id_murid='".$_GET["nisn"]."'")->fetchColumn() > 0) {
            ?>
                <div class="panel">
                    <form class="form-horizontal" action="inserttp.php?nisn=<?php echo $_GET["nisn"]; ?>" method="post">
                        <div class="panel-heading text-right">
                            <ul class="nav nav-pills pull-left" style="margin:10px 0 0 0">
                                <li>
                                    <a href="javascript:void(0)">
                                            <?php
                                                $exec = $pdo->query("select nama_murid from murid where id_murid='".$_GET["nisn"]."'");
                                                echo $_GET["nisn"]." | ".$exec->fetchColumn();
                                            ?>
                                    </a>
                                </li>
                            </ul>
                            <div class="form-group" style="margin:0 0 -5px 0;">
                                        <input type="submit" class="btn btn-material-indigo" value="Update" name="update">
                            </div>
                        </div>
                        <div class="panel-body">
                                <input type="hidden" name="nisn" value="<?php echo $_GET["nisn"]; ?>">
                                <fieldset>
                                    <?php
                                        $i=0;
                                        foreach($pdo->query("select * from kelompok_pelajaran") as $row){
                                    ?>
                                    <div class="form-group">
                                        <label for="<?php echo $row[1]; ?>" class="col-lg-2 control-label"><?php echo $row[1]; ?></label>
                                        <div class="col-lg-10">
                                            <input type="hidden" name="id_mapel[<?php echo $i; ?>]" value="<?php echo $row[0]; ?>">
                                            <input type="number" class="form-control" id="inputEmail" placeholder="nilai" name="nilai[<?php echo $i; ?>]" value="<?php echo $pdo->query("select nilai from nilai_tp where id_murid='".$_GET["nisn"]."' and id_kelompok='".$row[0]."'")->fetchColumn(); ?>">
                                        </div>
                                    </div>
                                    <?php
                                            $i++;
                                        }
                                    ?>
                                </fieldset>
                        </div>
                    </form>
                </div>
            <?php
                }else{
            ?>
                <div class="panel">
                    <form class="form-horizontal" action="inserttp.php?nisn=<?php echo $_GET["nisn"]; ?>" method="post">
                        <div class="panel-heading text-right">
                            <ul class="nav nav-pills pull-left" style="margin:10px 0 0 0">
                                <li>
                                    <a href="javascript:void(0)">
                                            <?php
                                                $exec = $pdo->query("select nama_murid from murid where id_murid='".$_GET["nisn"]."'");
                                                echo $_GET["nisn"]." | ".$exec->fetchColumn();
                                            ?>
                                    </a>
                                </li>
                            </ul>
                            <div class="form-group" style="margin:0 0 -5px 0;">
                                        <input type="submit" class="btn btn-material-teal-A700" value="Simpan" name="simpan">
                            </div>
                        </div>
                        <div class="panel-body">
                                <input type="hidden" name="nisn" value="<?php echo $_GET["nisn"]; ?>">
                                <fieldset>
                                    <?php
                                        $i=0;
                                        foreach($pdo->query("select * from kelompok_pelajaran") as $row){
                                    ?>
                                    <div class="form-group">
                                        <label for="<?php echo $row[1]; ?>" class="col-lg-2 control-label"><?php echo $row[1]; ?></label>
                                        <div class="col-lg-10">
                                            <input type="hidden" name="id_mapel[<?php echo $i; ?>]" value="<?php echo $row[0]; ?>">
                                            <input type="number" class="form-control" id="inputEmail" placeholder="nilai" name="nilai[<?php echo $i; ?>]" value="0">
                                        </div>
                                    </div>
                                    <?php
                                            $i++;
                                        }
                                    ?>
                                </fieldset>
                        </div>
                    </form>
                </div>
            <?php
                }
            ?>
            </div>
        </div>
        <!-- include JSnye Broo -->
        <script src="../res/js/jquery-1.10.2.min.js"></script>
        <script src="../res/js/bootstrap.min.js"></script>
        <script src="../res/js/ripples.min.js"></script>
        <script src="../res/js/material.min.js"></script>
        <script src="../res/js/sidebar.js"></script>
        <script src="../res/js/modernizr.js"></script>

        <!-- JS wajib Broo -->
        <script>
            $(document).ready(function() {
                // This command is used to initialize some elements and make them work properly
                $.material.init();
            });
        </script>
    </body>
</html>
