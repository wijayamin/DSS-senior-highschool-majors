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

$pageini="Hasil Penjurusan";

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
                            <li><a href="javascript:void(0)">Hasil Penjurusan</a></li>
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
                                    <th>Rekomendasi Jurusan</th>
                                    <th>Rekomendasi Alternatif</th>
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
                                        $nilai_matematika =  $pdo->query("select nilai from nilai_mapel where id_murid='".$row[0]."' and id_mapel='1'")->fetchColumn();
                                        $nilai_fisika =  $pdo->query("select nilai from nilai_mapel where id_murid='".$row[0]."' and id_mapel='2'")->fetchColumn();
                                        $nilai_kimia =  $pdo->query("select nilai from nilai_mapel where id_murid='".$row[0]."' and id_mapel='3'")->fetchColumn();
                                        $nilai_biologi =  $pdo->query("select nilai from nilai_mapel where id_murid='".$row[0]."' and id_mapel='4'")->fetchColumn();
                                        $nilai_sejarah =  $pdo->query("select nilai from nilai_mapel where id_murid='".$row[0]."' and id_mapel='5'")->fetchColumn();
                                        $nilai_geografi =  $pdo->query("select nilai from nilai_mapel where id_murid='".$row[0]."' and id_mapel='6'")->fetchColumn();
                                        $nilai_ekonomi =  $pdo->query("select nilai from nilai_mapel where id_murid='".$row[0]."' and id_mapel='7'")->fetchColumn();
                                        $nilai_sosiologi =  $pdo->query("select nilai from nilai_mapel where id_murid='".$row[0]."' and id_mapel='8'")->fetchColumn();
                                        $nilai_indonesia =  $pdo->query("select nilai from nilai_mapel where id_murid='".$row[0]."' and id_mapel='9'")->fetchColumn();
                                        $nilai_inggris =  $pdo->query("select nilai from nilai_mapel where id_murid='".$row[0]."' and id_mapel='10'")->fetchColumn();
                                        $nilai_jepang =  $pdo->query("select nilai from nilai_mapel where id_murid='".$row[0]."' and id_mapel='11'")->fetchColumn();
                                        $nilai_jawa =  $pdo->query("select nilai from nilai_mapel where id_murid='".$row[0]."' and id_mapel='12'")->fetchColumn();

                                        $rata_rapot_ipa=($nilai_matematika+$nilai_fisika+$nilai_kimia+$nilai_biologi)/4;
                                        $rata_rapot_ips=($nilai_matematika+$nilai_sejarah+$nilai_geografi+$nilai_ekonomi+$nilai_sosiologi)/5;
                                        $rata_rapor_bahasa=($nilai_matematika+$nilai_indonesia+$nilai_inggris+$nilai_jawa+$nilai_jepang)/5;

                                        $tpa_ipa= $pdo->query("select nilai from nilai_tp where id_murid='".$row[0]."' and id_kelompok='1'")->fetchColumn();
                                        $tpa_ips= $pdo->query("select nilai from nilai_tp where id_murid='".$row[0]."' and id_kelompok='2'")->fetchColumn();
                                        $tpa_bahasa= $pdo->query("select nilai from nilai_tp where id_murid='".$row[0]."' and id_kelompok='3'")->fetchColumn();

                                        $minat_ipa= $pdo->query("select minat_ipa from minat_siswa where id_murid='".$row[0]."'")->fetchColumn();
                                        $minat_ips= $pdo->query("select minat_ips from minat_siswa where id_murid='".$row[0]."'")->fetchColumn();
                                        $minat_bahasa= $pdo->query("select minat_bahasa from minat_siswa where id_murid='".$row[0]."'")->fetchColumn();

                                        #matriks rapor
                                            #matriks rapor awal kolom 1
                                            $matriks_rapor_awal_1_1=1;
                                            $matriks_rapor_awal_1_2=$rata_rapot_ips/$rata_rapot_ipa;
                                            $matriks_rapor_awal_1_3=$rata_rapor_bahasa/$rata_rapot_ipa;

                                            #matriks rapor awal kolom 2
                                            $matriks_rapor_awal_2_1=$rata_rapot_ipa/$rata_rapot_ips;
                                            $matriks_rapor_awal_2_2=1;
                                            $matriks_rapor_awal_2_3=$rata_rapor_bahasa/$rata_rapot_ips;

                                            #matriks rapor awal kolom 3
                                            $matriks_rapor_awal_3_1=$rata_rapot_ipa/$rata_rapor_bahasa;
                                            $matriks_rapor_awal_3_2=$rata_rapot_ips/$rata_rapor_bahasa;
                                            $matriks_rapor_awal_3_3=1;

                                            #matriks rapor awal ditotal per colom
                                            $matriks_rapor_awal_total_1=$matriks_rapor_awal_1_1+$matriks_rapor_awal_1_2+$matriks_rapor_awal_1_3;
                                            $matriks_rapor_awal_total_2=$matriks_rapor_awal_2_1+$matriks_rapor_awal_2_2+$matriks_rapor_awal_2_3;
                                            $matriks_rapor_awal_total_3=$matriks_rapor_awal_3_1+$matriks_rapor_awal_3_2+$matriks_rapor_awal_3_3;

                                            #matriks rata rata tp akhir
                                            $matriks_rapor_akhir_rata_ipa=$matriks_rapor_awal_1_1/$matriks_rapor_awal_total_1;
                                            $matriks_rapor_akhir_rata_ips=$matriks_rapor_awal_1_2/$matriks_rapor_awal_total_1;
                                            $matriks_rapor_akhir_rata_bahasa=$matriks_rapor_awal_1_3/$matriks_rapor_awal_total_1;

                                        #matrik tp
                                            #matriks tp awal kolom 1
                                            $matriks_tp_awal_1_1=1;
                                            $matriks_tp_awal_1_2=$tpa_ips/$tpa_ipa;
                                            $matriks_tp_awal_1_3=$tpa_bahasa/$tpa_ipa;

                                            #matriks tp awal kolom 2
                                            $matriks_tp_awal_2_1=$tpa_ipa/$tpa_ips;
                                            $matriks_tp_awal_2_2=1;
                                            $matriks_tp_awal_2_3=$tpa_bahasa/$tpa_ips;

                                            #matriks tp awal kolom 3
                                            $matriks_tp_awal_3_1=$tpa_ipa/$tpa_bahasa;
                                            $matriks_tp_awal_3_2=$tpa_ips/$tpa_bahasa;
                                            $matriks_tp_awal_3_3=1;

                                            #matriks tp awal ditotal per colom
                                            $matriks_tp_awal_total_1=$matriks_tp_awal_1_1+$matriks_tp_awal_1_2+$matriks_tp_awal_1_3;
                                            $matriks_tp_awal_total_2=$matriks_tp_awal_2_1+$matriks_tp_awal_2_2+$matriks_tp_awal_2_3;
                                            $matriks_tp_awal_total_3=$matriks_tp_awal_3_1+$matriks_tp_awal_3_2+$matriks_tp_awal_3_3;

                                            #matriks rata rata rapot akhir
                                            $matriks_tp_akhir_rata_ipa=$matriks_tp_awal_1_1/$matriks_tp_awal_total_1;
                                            $matriks_tp_akhir_rata_ips=$matriks_tp_awal_1_2/$matriks_tp_awal_total_1;
                                            $matriks_tp_akhir_rata_bahasa=$matriks_tp_awal_1_3/$matriks_tp_awal_total_1;

                                        #matrik minat
                                            #matriks minat awal kolom 1
                                            $matriks_minat_awal_1_1=1;
                                            $matriks_minat_awal_1_2=$minat_ips/$minat_ipa;
                                            $matriks_minat_awal_1_3=$minat_bahasa/$minat_ipa;

                                            #matriks minat awal kolom 2
                                            $matriks_minat_awal_2_1=$minat_ipa/$minat_ips;
                                            $matriks_minat_awal_2_2=1;
                                            $matriks_minat_awal_2_3=$minat_bahasa/$minat_ips;

                                            #matriks minat awal kolom 3
                                            $matriks_minat_awal_3_1=$minat_ipa/$minat_bahasa;
                                            $matriks_minat_awal_3_2=$minat_ips/$minat_bahasa;
                                            $matriks_minat_awal_3_3=1;

                                            #matriks minat awal ditotal per colom
                                            $matriks_minat_awal_total_1=$matriks_minat_awal_1_1+$matriks_minat_awal_1_2+$matriks_minat_awal_1_3;
                                            $matriks_minat_awal_total_2=$matriks_minat_awal_2_1+$matriks_minat_awal_2_2+$matriks_minat_awal_2_3;
                                            $matriks_minat_awal_total_3=$matriks_minat_awal_3_1+$matriks_minat_awal_3_2+$matriks_minat_awal_3_3;

                                            #matriks rata rata minat akhir
                                            $matriks_minat_akhir_rata_ipa=$matriks_minat_awal_1_1/$matriks_minat_awal_total_1;
                                            $matriks_minat_akhir_rata_ips=$matriks_minat_awal_1_2/$matriks_minat_awal_total_1;
                                            $matriks_minat_akhir_rata_bahasa=$matriks_minat_awal_1_3/$matriks_minat_awal_total_1;

                                        #matrik total paling akhir suuuu
                                            #matriks itung akhir kolom 1
                                            $matriks_akhir_1_1=$matriks_rapor_akhir_rata_ipa;
                                            $matriks_akhir_1_2=$matriks_rapor_akhir_rata_ips;
                                            $matriks_akhir_1_3=$matriks_rapor_akhir_rata_bahasa;

                                            $matriks_akhir_2_1=$matriks_tp_akhir_rata_ipa;
                                            $matriks_akhir_2_2=$matriks_tp_akhir_rata_ips;
                                            $matriks_akhir_2_3=$matriks_tp_akhir_rata_bahasa;

                                            $matriks_akhir_3_1=$matriks_minat_akhir_rata_ipa;
                                            $matriks_akhir_3_2=$matriks_minat_akhir_rata_ips;
                                            $matriks_akhir_3_3=$matriks_minat_akhir_rata_bahasa;

                                            #var kali matriks
                                            $var_kali_1='0.5389';
                                            $var_kali_2='0.2971';
                                            $var_kali_3='0.1637';

                                            $kali_matriks_ipa=($matriks_rapor_akhir_rata_ipa*$var_kali_1)+($matriks_tp_akhir_rata_ipa*$var_kali_2)+($matriks_minat_akhir_rata_ipa*$var_kali_3);
                                            $kali_matriks_ips=($matriks_rapor_akhir_rata_ips*$var_kali_1)+($matriks_tp_akhir_rata_ips*$var_kali_2)+($matriks_minat_akhir_rata_ips*$var_kali_3);
                                            $kali_matriks_bahasa=($matriks_rapor_akhir_rata_bahasa*$var_kali_1)+($matriks_tp_akhir_rata_bahasa*$var_kali_2)+($matriks_minat_akhir_rata_bahasa*$var_kali_3);

                                        $array = [
                                            "IPA" => $kali_matriks_ipa,
                                            "IPS" => $kali_matriks_ips,
                                            "Bahasa" => $kali_matriks_bahasa
                                        ];

                                        arsort($array);
                                        $a=array();
                                        foreach($array as $key => $val){
                                            array_push($a, $key);
                                        }

                                    ?>
                                    <td><?php echo $a[0]; ?></td>
                                    <td><?php echo $a[1]; ?></td>
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
