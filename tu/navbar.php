<!-- Overlay for fixed sidebar -->
<div class="sidebar-overlay"></div>

<!-- Material sidebar -->
<aside id="sidebar" class="sidebar sidebar-colored open" role="navigation">
  <!-- Sidebar header -->
  <div class="sidebar-header header-cover" style="background-image: url(../res/img/background-blur.jpg);">
    <!-- Top bar -->
    <div class="top-bar"></div>
    <!-- Sidebar toggle button -->
    <button type="button" class="sidebar-toggle">
      <i class="icon-material-sidebar-arrow"></i>
    </button>
    <!-- Sidebar brand image -->
    <div class="sidebar-image">
      <img src="../res/img/photo.jpg">
    </div>
    <!-- Sidebar brand name -->
    <a data-toggle="dropdown" class="sidebar-brand" href="#settings-dropdown">
        <span style="color:#fff">
            <?php
                $exec = $pdo->query("select nama_guru from guru where id_guru='".$_SESSION["username"]."'");
                echo $exec->fetchColumn();
            ?>
        </span>
            <b class="caret"></b>
        </a>
  </div>

  <!-- Sidebar navigation -->
  <ul class="nav sidebar-nav">
    <li class="dropdown">
      <ul id="settings-dropdown" class="dropdown-menu">
        <li>
            <a href="#" tabindex="-1"  data-toggle="modal" data-target="#myModal">
                        Pengaturan Akun
                    </a>
        </li>
        <li>
          <a href="../index.php?logout" tabindex="-1">
                        Log Out
                    </a>
        </li>
      </ul>
    </li>
<!--    dashboard-->
    <li>
      <a href="#">
        <i class="sidebar-icon zmdi zmdi-badge-check"></i><?php echo $pageini; ?>
      </a>
    </li>
    <li class="divider"></li>

    <li>
      <a href="#">
                Dashboard
            </a>
    </li>
    <li class="dropdown">
      <a class="ripple-effect dropdown-toggle" href="#" data-toggle="dropdown">
                Data Awal
                <b class="caret"></b>
            </a>
      <ul class="dropdown-menu">
        <li>
          <a href="guru.php" tabindex="-1">
                        Guru
                        <span class="sidebar-badge">
                            <?php
                                $exec = $pdo->query("select count(id_guru) from guru where privileges<>'admin'");
                                echo $exec->fetchColumn();
                            ?>
                        </span>
                    </a>
        </li>
        <li>
          <a href="murid.php" tabindex="-1">
                        Murid
                        <span class="sidebar-badge">
                            <?php
                                $exec = $pdo->query("select count(id_murid) from murid");
                                echo $exec->fetchColumn();
                            ?>
                        </span>
                    </a>
        </li>
        <li>
          <a href="matapelajaran.php" tabindex="-1">
                        Mata Pelajaran
                        <span class="sidebar-badge">
                            <?php
                                $exec = $pdo->query("select count(id_mapel) from mata_pelajaran");
                                echo $exec->fetchColumn();
                            ?>
                        </span>
                    </a>
        </li>
      </ul>
    </li>
    <li class="dropdown">
      <a class="ripple-effect dropdown-toggle" href="#" data-toggle="dropdown">
                Print
                <b class="caret"></b>
            </a>
      <ul class="dropdown-menu">
        <li>
          <a href="#" tabindex="-1">
                        Murid
                        <span class="sidebar-badge">12</span>
                    </a>
        </li>
        <li>
          <a href="#" tabindex="-1">
                        Guru
                        <span class="sidebar-badge">0</span>
                    </a>
        </li>
        <li>
          <a href="#" tabindex="-1">
                        Mata Pelajaran
                        <span class="sidebar-badge">0</span>
                    </a>
        </li>
      </ul>
    </li>
    <li>
      <a href="#">
                Pengaturan
            </a>
    </li>
  </ul>
  <!-- Sidebar divider -->
  <!-- <div class="sidebar-divider"></div> -->

  <!-- Sidebar text -->
  <!--  <div class="sidebar-text">Text</div> -->
</aside>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Pengaturan Akun</h4>
            </div>
            <form class="form-horizontal" action="akun.php" method="post">
                <div class="modal-body">
                    <legend>Nama</legend>
                    <hr>
                    <div class="form-group">
                        <label for="NISN" class="col-lg-2 control-label">Nama</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="NISN" placeholder="Nama Anda " name="nama" required value="<?php echo $pdo->query("select nama_guru from guru where id_guru='".$_SESSION["username"]."'")->fetchColumn();?>">
                        </div>
                    </div>
                    <legend>Password</legend>
                    <hr>
                    <div class="form-group">
                        <label for="NISN" class="col-lg-2 control-label">Password Lama</label>
                        <div class="col-lg-10">
                            <input type="password" class="form-control" id="NISN" placeholder="Password Lama" name="plama" required>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="nama" class="col-lg-2 control-label">Password Baru</label>
                        <div class="col-lg-10">
                            <input type="password" class="form-control" id="nama" placeholder="Password Baru" name="pbaru" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama" class="col-lg-2 control-label">Ulang Password</label>
                        <div class="col-lg-10">
                            <input type="password" class="form-control" id="nama" placeholder="Ulangi Password Baru" name="pulang" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input class="btn btn-primary btn-material-indigo" type="hidden" value="<?php echo __FILE__; ?>" name="page">
                    <input class="btn btn-primary btn-material-indigo" type="submit" value="Simpan" name="simpan">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
