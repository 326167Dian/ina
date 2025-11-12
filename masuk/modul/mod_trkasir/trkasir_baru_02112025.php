<?php
session_start();
if (empty($_SESSION['username']) and empty($_SESSION['passuser'])) {
	echo "<link href=../css/style.css rel=stylesheet type=text/css>";
	echo "<div class='error msg'>Untuk mengakses Modul anda harus login.</div>";
} else {

	$aksi = "modul/mod_trkasir/aksi_trkasir.php";
	$aksi_trkasir = "masuk/modul/mod_trkasir/aksi_trkasir.php";
	switch ($_GET['act']) {
			// Tampil Penjualan
		default:
			$tgl_awal = date('Y-m-d');
            $tanpatgl = substr($tgl_awal, 0, 8);
            $awalbulan = $tanpatgl . '01';
            $tampil_trkasir = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir  
        where tgl_trkasir = '$tgl_awal' order by id_trkasir desc ");


			/*$tgl_awal = date('Y-m-d');
      $tgl_akhir = date('Y-m-d', strtotime('-7 days', strtotime( $tgl_awal)));
      $tampil_trkasir = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir  
        where tgl_trkasir between '$tgl_akhir' and '$tgl_awal'ORDER BY tgl_trkasir desc ") ;*/

?>


			<div class="box box-primary box-solid table-responsive">
                <div class="box-header with-border">
                    <h3 class="box-title">TRANSAKSI PENJUALAN HARI INI <a href="https://youtu.be/WZlfjM0tTn0" target="_blanks">(Tonton Tutorial)</a></h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div><!-- /.box-tools -->
                </div>
                <div class="box-body table-responsive">
                    <a class='btn  btn-success btn-flat' href='?module=trkasir&act=tambah'>TAMBAH</a>
                    <td><a class='btn btn-danger btn-flat' href='modul/mod_trkasir/barangmacet.php' target='_blank'>DOWNLOAD STOK MACET</a></td>
                    <?php
                    $lupa = $_SESSION['level'];
                    if ($lupa == 'pemilik') {
                        echo "          <a class='btn  btn-info btn-flat' href='?module=trkasir&act=cari2'>CARI BERDASARKAN NO TRANSAKSI</a>           
									        ";
                    }
                    ?>
                    <?php
                    $global = mysqli_query($GLOBALS["___mysqli_ston"], "select * from komisiglobal where status='ON' ");
                    $global1 = mysqli_fetch_array($global);
                    $kogo = $global1['nilai'] / 100;
                    $status = $global1['status'];


                    if ($status == 'ON') {
                        $petugas = $_SESSION['namalengkap'];
                        

                        $querykomisi = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(ttl_trkasir) as total_komisi FROM trkasir
                            where tgl_trkasir between '$awalbulan' and '$tgl_awal' and petugas='$petugas' ");
                        $komisi = mysqli_fetch_array($querykomisi);
                        $komisipetugas = $komisi['total_komisi'] * $kogo;
                        echo "<marquee><h4><b>Total Komisi Transaksi  $petugas Saat Ini = Rp " . format_rupiah($komisipetugas) . "</b></h4></marquee>";
                    }
                    ?>
                    <div></div>
                    <hr>
                    <!--<a  class ='btn  btn-warning  btn-flat' href='?module=trkasir&act=jualsebelumnya'>PENJUALAN SEBELUMNYA</a>
                    <small>* Pembayaran belum lunas</small> -->


                    <table id="rekap" class="table table-bordered table-striped">
                        <thead style="text-align:center; text-transform:uppercase;">
                            <tr>
                                <th >No</th>
                                <th style="text-align:center">No Transaksi</th>
                                <th>shift</th>
                                <th>Jenis Transaksi</th>
                                <th>petugas</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th style="text-align:center">No Pesanan</th>
                                <th>Cara Bayar</th>
                                <th>Total</th>
                                <th width="70">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <table id="example1" class="table table-bordered table-striped">
                        <?php
                        $tgl_awal = date('Y-m-d');      
                        
                            $total = "SELECT id_trkasir, kd_trkasir, SUM(ttl_trkasir)as ttlskrg1                                                              
                                        FROM trkasir WHERE tgl_trkasir='$tgl_awal'";
                            $tunai = "SELECT id_trkasir, kd_trkasir, SUM(ttl_trkasir)as ttlskrg2                                                              
                                        FROM trkasir WHERE tgl_trkasir='$tgl_awal' AND id_carabayar='1'";
                            $transfer = "SELECT id_trkasir, kd_trkasir, SUM(ttl_trkasir)as ttlskrg3                                                              
                                        FROM trkasir WHERE tgl_trkasir='$tgl_awal' AND id_carabayar='2'";
                            $tempo = "SELECT id_trkasir, kd_trkasir, SUM(ttl_trkasir)as ttlskrg4                                                              
                                        FROM trkasir WHERE tgl_trkasir='$tgl_awal' AND id_carabayar='3'";
                            $shift1 = "SELECT id_trkasir, kd_trkasir, SUM(ttl_trkasir)as ttlshift1                                                              
                                        FROM trkasir WHERE tgl_trkasir='$tgl_awal' AND shift=1 ";
                            $shift1tunai = "SELECT id_trkasir, kd_trkasir, SUM(ttl_trkasir)as ttlshift1tunai                                                              
                                        FROM trkasir WHERE tgl_trkasir='$tgl_awal' AND shift=1 and id_carabayar='1' ";
                            $shift1transfer = "SELECT id_trkasir, kd_trkasir, SUM(ttl_trkasir)as ttlshift1transfer                                                              
                                        FROM trkasir WHERE tgl_trkasir='$tgl_awal' AND shift=1 and id_carabayar='2' ";
                            $shift1tempo = "SELECT id_trkasir, kd_trkasir, SUM(ttl_trkasir)as ttlshift1tempo                                                              
                                        FROM trkasir WHERE tgl_trkasir='$tgl_awal' AND shift=1 and id_carabayar=3 ";
                            $shift2 = "SELECT id_trkasir, kd_trkasir, SUM(ttl_trkasir)as ttlshift2                                                              
                                        FROM trkasir WHERE tgl_trkasir='$tgl_awal' AND shift=2 ";
                            $shift2tunai = "SELECT id_trkasir, kd_trkasir, SUM(ttl_trkasir)as ttlshift2tunai                                                              
                                        FROM trkasir WHERE tgl_trkasir='$tgl_awal' AND shift=2 and id_carabayar=1";
                            $shift2transfer = "SELECT id_trkasir, kd_trkasir, SUM(ttl_trkasir)as ttlshift2transfer                                                              
                                        FROM trkasir WHERE tgl_trkasir='$tgl_awal' AND shift=2 and id_carabayar=2";
                            $shift2tempo = "SELECT id_trkasir, kd_trkasir, SUM(ttl_trkasir)as ttlshift2tempo                                                              
                                        FROM trkasir WHERE tgl_trkasir='$tgl_awal' AND shift=2 and id_carabayar=3";

                            $shift3 = "SELECT id_trkasir, kd_trkasir, SUM(ttl_trkasir)as ttlshift3                                                              
                                        FROM trkasir WHERE tgl_trkasir = '$tgl_awal' AND shift=3 ";
                            $shift3tunai = "SELECT id_trkasir, kd_trkasir, SUM(ttl_trkasir)as ttlshift3tunai                                                              
                                        FROM trkasir WHERE tgl_trkasir = '$tgl_awal' AND shift=3 and id_carabayar=1";
                            $shift3transfer = "SELECT id_trkasir, kd_trkasir, SUM(ttl_trkasir)as ttlshift3transfer                                                              
                                        FROM trkasir WHERE tgl_trkasir = '$tgl_awal' AND shift=3 and id_carabayar=2";
                            $shift3tempo = "SELECT id_trkasir, kd_trkasir, SUM(ttl_trkasir)as ttlshift3tempo                                                              
                                        FROM trkasir WHERE tgl_trkasir = '$tgl_awal' AND shift=3 and id_carabayar=3";

                            $query2 = mysqli_query($GLOBALS["___mysqli_ston"], $total);
                            $query3 = mysqli_query($GLOBALS["___mysqli_ston"], $tunai);
                            $query4 = mysqli_query($GLOBALS["___mysqli_ston"], $transfer);
                            $query5 = mysqli_query($GLOBALS["___mysqli_ston"], $tempo);
                            $query6 = mysqli_query($GLOBALS["___mysqli_ston"], $shift1);
                            $query6tunai = mysqli_query($GLOBALS["___mysqli_ston"], $shift1tunai);
                            $query6transfer = mysqli_query($GLOBALS["___mysqli_ston"], $shift1transfer);
                            $query6tempo = mysqli_query($GLOBALS["___mysqli_ston"], $shift1tempo);
                            $query7 = mysqli_query($GLOBALS["___mysqli_ston"], $shift2);
                            $query7tunai = mysqli_query($GLOBALS["___mysqli_ston"], $shift2tunai);
                            $query7transfer = mysqli_query($GLOBALS["___mysqli_ston"], $shift2transfer);
                            $query7tempo = mysqli_query($GLOBALS["___mysqli_ston"], $shift2tempo);

                            $query8 = mysqli_query($GLOBALS["___mysqli_ston"], $shift3);
                            $query8tunai = mysqli_query($GLOBALS["___mysqli_ston"], $shift3tunai);
                            $query8transfer = mysqli_query($GLOBALS["___mysqli_ston"], $shift3transfer);
                            $query8tempo = mysqli_query($GLOBALS["___mysqli_ston"], $shift3tempo);


                            $r2 = mysqli_fetch_array($query2);
                            $ttlskrg = $r2['ttlskrg1'];
                            $ttlskrg2 = format_rupiah($ttlskrg);

                            $r3 = mysqli_fetch_array($query3);
                            $ttltunai = $r3['ttlskrg2'];
                            $ttltunai2 = format_rupiah($ttltunai);

                            $r4 = mysqli_fetch_array($query4);
                            $ttltransfer = $r4['ttlskrg3'];
                            $ttltransfer2 = format_rupiah($ttltransfer);

                            $r5 = mysqli_fetch_array($query5);
                            $ttltempo = $r5['ttlskrg4'];
                            $ttltempo2 = format_rupiah($ttltempo);

                            $r6 = mysqli_fetch_array($query6);
                            $ttlshift1 = $r6['ttlshift1'];
                            $ttlshiftx = format_rupiah($ttlshift1);

                            $r6tunai = mysqli_fetch_array($query6tunai);
                            $ttlshift1tunai = $r6tunai['ttlshift1tunai'];
                            $ttlshiftxtunai = format_rupiah($ttlshift1tunai);

                            $r6transfer = mysqli_fetch_array($query6transfer);
                            $ttlshift1transfer = $r6transfer['ttlshift1transfer'];
                            $ttlshiftxtransfer = format_rupiah($ttlshift1transfer);

                            $r6tempo = mysqli_fetch_array($query6tempo);
                            $ttlshift1tempo = $r6tempo['ttlshift1tempo'];
                            $ttlshiftxtempo = format_rupiah($ttlshift1tempo);

                            $r7 = mysqli_fetch_array($query7);
                            $ttlshift2 = $r7['ttlshift2'];
                            $ttlshifty = format_rupiah($ttlshift2);

                            $r7tunai = mysqli_fetch_array($query7tunai);
                            $ttlshift2tunai = $r7tunai['ttlshift2tunai'];
                            $ttlshiftytunai = format_rupiah($ttlshift2tunai);

                            $r7transfer = mysqli_fetch_array($query7transfer);
                            $ttlshift2transfer = $r7transfer['ttlshift2transfer'];
                            $ttlshiftytransfer = format_rupiah($ttlshift2transfer);

                            $r7tempo = mysqli_fetch_array($query7tempo);
                            $ttlshift2tempo = $r7tempo['ttlshift2tempo'];
                            $ttlshiftytempo = format_rupiah($ttlshift2tempo);

                            $r8 = mysqli_fetch_array($query8);
                            $ttlshift3 = $r8['ttlshift3'];
                            $ttlshifty3 = format_rupiah($ttlshift3);

                            $r8tunai = mysqli_fetch_array($query8tunai);
                            $ttlshift3tunai = $r8tunai['ttlshift3tunai'];
                            $ttlshiftytunai3 = format_rupiah($ttlshift3tunai);

                            $r8transfer = mysqli_fetch_array($query8transfer);
                            $ttlshift3transfer = $r8transfer['ttlshift3transfer'];
                            $ttlshiftytransfer3 = format_rupiah($ttlshift3transfer);

                            $r8tempo = mysqli_fetch_array($query8tempo);
                            $ttlshift3tempo = $r8tempo['ttlshift3tempo'];
                            $ttlshiftytempo3 = format_rupiah($ttlshift3tempo);
                        // echo"
                        // <tr>
                        //         <td colspan='4' style='text-align: center;'><strong>Tunai Rp. $ttltunai2 </strong>  </td>
                        //         <td colspan='2' style='text-align: center;'><strong> Transfer Rp. $ttltransfer2   ,- </strong></td> 
                        //         <td colspan='4' style='text-align: center;'><strong> Tempo Rp. $ttltempo2  ,- </strong></td> 
                        //     </tr>
                        //     <tr>
                        //         <td colspan='5'><strong><center>Total shift Pagi = Rp. $ttlshiftx                                 
                        //                                    <br> Tunai Rp. $ttlshiftxtunai                                                            
                        //                                    <br> Transfer Rp. $ttlshiftxtransfer
                        //                                    <br> Tempo Rp. $ttlshiftxtempo</center> </strong> </td>
                        //         <td colspan='5'><strong><center>Total shift Sore = Rp. $ttlshifty
                        //                                     <br> Tunai Rp. $ttlshiftytunai
                        //                                     <br> Transfer Rp. $ttlshiftytransfer
                        //                                     <br> Tempo Rp. $ttlshiftytempo <center></strong></td> 
                        //     </tr><tr>
                        //         <td colspan='10' style='font-weight:bold;'><h2><center>Total Hari ini Rp. $ttlskrg2  ,-</center></h2>  </td>
                                 
                        // </tr>";
                        
                            ?>                            
                    </table>
                    <table class="table table-striped table-bordered table-responsive">
                                <h4>Ringkasan Transaksi</h4>
                                <thead>
                                <th width="150px">Tipe Transaksi</th>
                                <th>Nilai Transaksi</th>
                                <th>Shift Pagi</th>
                                <th>Shift Sore</th>
                                </thead>
                                <tbody>
                                <?php
                                $tgl_awal = date('Y-m-d');
                                $tamtot = mysqli_query($GLOBALS["___mysqli_ston"],"select * from carabayar");
                                while ($tt=mysqli_fetch_array($tamtot)){

                                    $tcb= $db->query( "SELECT id_trkasir, kd_trkasir, SUM(ttl_trkasir) as ttlskrg1
                                        FROM trkasir WHERE tgl_trkasir='$tgl_awal' AND id_carabayar='$tt[id_carabayar]'");
                                    $tamtcb = $tcb->fetch_array();
                                    $dtamtcb = format_rupiah($tamtcb['ttlskrg1']);

                                    $shift1= $db->query( "SELECT id_trkasir, kd_trkasir, SUM(ttl_trkasir) as ttlskrg1
                                        FROM trkasir WHERE tgl_trkasir='$tgl_awal' AND id_carabayar='$tt[id_carabayar]' and shift=1 ");
                                    $pagi1 = $shift1->fetch_array();
                                    $pagi = format_rupiah($pagi1['ttlskrg1']);

                                    $shift2= $db->query( "SELECT id_trkasir, kd_trkasir, SUM(ttl_trkasir) as ttlskrg1
                                        FROM trkasir WHERE tgl_trkasir='$tgl_awal' AND id_carabayar='$tt[id_carabayar]' and shift=2 ");
                                    $sore1 = $shift2->fetch_array();
                                    $sore = format_rupiah($sore1['ttlskrg1']);

                                    echo"
                           <tr><td width='150 px'>$tt[nm_carabayar]</td>
                                <td>$dtamtcb</td>
                                <td>$pagi</td>
                                <td>$sore</td>
                           </tr>
                           ";
                                }
                                ?>
                                </tbody>
                                <tfoot>
                                <?php
                                $tgl_awal = date('Y-m-d');
                                $tothari = $db->query("SELECT id_trkasir, kd_trkasir, SUM(ttl_trkasir) as ttlskrg4                                                              
                                            FROM trkasir WHERE tgl_trkasir='$tgl_awal'");
                                $arth = $tothari->fetch_array();
                                $tdm = format_rupiah($arth['ttlskrg4']);

                                $totpagi = $db->query("SELECT id_trkasir, kd_trkasir, SUM(ttl_trkasir) as ttlskrg4                                                              
                                            FROM trkasir WHERE tgl_trkasir='$tgl_awal' and shift=1 ");
                                $tpagi = $totpagi->fetch_array();
                                $shiftpagi = format_rupiah($tpagi['ttlskrg4']);

                                $totsore = $db->query("SELECT id_trkasir, kd_trkasir, SUM(ttl_trkasir) as ttlskrg4                                                              
                                            FROM trkasir WHERE tgl_trkasir='$tgl_awal' and shift=2 ");
                                $tsore = $totsore->fetch_array();
                                $shiftsore = format_rupiah($tsore['ttlskrg4']);

                                echo"
                            <tr style='background-color: #00fafa;font-size:20px;font-weight:bold;'>
                                <td>TOTAL</td>                               
                                <td>$tdm</td>
                                <td>$shiftpagi</td>
                                <td>$shiftsore</td>
                            </tr>";
                                ?>
                                </tfoot>
                            </table>
                </div>
                <?php
                $kom = $db->query("select sum(komisi) as tambahan from trkasir_detail join trkasir
                    on(trkasir_detail.kd_trkasir=trkasir.kd_trkasir)
                    where trkasir_detail.idadmin='$_SESSION[idadmin]' and trkasir.tgl_trkasir between '$awalbulan' and '$tgl_awal' ");
                $misi = $kom->fetch_array();
                $pk = format_rupiah($misi['tambahan']);
                
                ?>
                <a class='btn  btn-success btn-flat' href='modul/mod_lapstok/sinkronisasi_stok.php'>SINKRONISASI</a>
                Klik SINKRONISASI sebelum tutup shift
                <?php
            
                if ($_SESSION['komisi']=='Y' && $_SESSION['level']=='petugas'){
                echo"
                <marquee><h3 style='font-weight: bold;'>Total Komisi per Produk <?php echo $petugas; ?> Rp. <?php echo $pk; ?></h3></marquee>
                "; }
                ?>
            </div>

            <script>
                $(document).ready(function() {
                    $("#rekap").DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            "url": "modul/mod_trkasir/penjualanhariini_serverside.php?action=table_data",
                            "dataType": "JSON",
                            "type": "POST"
                        },
                        "rowCallback": function(row, data, index) {
                             let q = (data['nm_carabayar']);
                             let r = (data['shift']);
                             let s = (data['jenistx']);
                            
                             if (q == 'Tempo' ) {
                                $(row).find('td:eq(8)').css('background-color', '#f39c12');
                                $(row).find('td:eq(8)').css('color', '#ffffff');
                             }
                             else {
                            // $(row).find('td:eq(7)').css('background-color', '#FFFFFF');
                            // $(row).find('td:eq(7)').css('color', '#000000');        
                            }
                            if (r == 1 ) {
                                $(row).find('td:eq(2)').text('Pagi');                               
                             }
                             else if (r == 2 ) {
                                $(row).find('td:eq(2)').text('Sore');                               
                             }
                             else if (r == 3 ) {
                                $(row).find('td:eq(2)').text('Malam');                               
                             }

                            if (s == 1 ) {
                               $(row).find('td:eq(3)').text('Reguler');
                               $(row).find('td:eq(3)').css('background-color', '#1e90ff');
                               $(row).find('td:eq(3)').css('color', '#ffffff'); 
                             }
                             else if (s == 2 ) {
                                $(row).find('td:eq(3)').text('Member');
                                $(row).find('td:eq(3)').css('background-color', '#32cd32');
                                $(row).find('td:eq(3)').css('color', '#ffffff');                                
                             }
                             else if (s == 3 ) {
                                $(row).find('td:eq(3)').text('Market Place'); 
                                $(row).find('td:eq(3)').css('background-color', '#ff0000');
                                $(row).find('td:eq(3)').css('color', '#ffffff');                               
                             }
                             else if (s == 4 ) {
                                $(row).find('td:eq(3)').text('Market Place'); 
                                $(row).find('td:eq(3)').css('background-color', '#ffa500');
                                $(row).find('td:eq(3)').css('color', '#ffffff');                             
                             }

                        },
                        columns: [{
                                "data": "no",
                                "className": 'text-center',
                            },
                            {
                                "data": "kd_trkasir"
                            },
                            {
                                "data": "shift",
                                "className": 'text-center',
                            },
                            {
                                "data": "jenistx",
                                "className": 'text-center',
                            },
                            {
                                "data": "petugas",
                                "className": 'text-center',
                            },
                            {
                                "data": "tgl_trkasir",
                                "className": 'text-center',
                            },
                            {
                                "data": "nm_pelanggan",
                            },
                            {
                                "data": "kodetx",
                            },
                            {
                                "data": "nm_carabayar",
                            },
                            {
                                "data": "ttl_trkasir",
                                "className": 'text-right',
                                "render": function(data, type, row) {
                                    return formatRupiah(data);
                                }
                            },
                            {
                                "data": "pilih",
                                "className": 'text-center'
                            },
                        ],

                    })

                });
            </script>

<?php

			break;

		case "tambah":
			//cek apakah ada SHIFT yang ON
			$tglharini = date('Y-m-d');
			$cekshift = mysqli_query($GLOBALS["___mysqli_ston"], "select * from waktukerja where tanggal = '$tglharini'
        and status='ON' ");
			$hitung = mysqli_num_rows($cekshift);
			$sshift  = mysqli_fetch_array($cekshift);
			$jamkerja = $sshift['shift'];

			if ($hitung < 1) {
				echo "<script type='text/javascript'>alert('Shift Kasir Belum Dibuka!');history.go(-1);</script>";
			} else {
				//cek apakah ada kode transaksi ON berdasarkan user
				$cekkd = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kdtk WHERE id_admin='$_SESSION[idadmin]' AND stt_kdtk='ON'");
				$ketemucekkd = mysqli_num_rows($cekkd);
				$hcekkd = mysqli_fetch_array($cekkd);
				$petugas = $_SESSION['namalengkap'];


				if ($ketemucekkd > 0) {
					$kdtransaksi = $hcekkd['kd_trkasir'];
				} else {
					$kdunik = date('dmyHis');
					$kdtransaksi = "TKP-" . $kdunik;
					
					$cekkd2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kdtk WHERE kd_trkasir='$kdtransaksi'");
    				$ketemucekkd2 = mysqli_num_rows($cekkd2);
    				if ($ketemucekkd2 > 0) {
    				    $kdunik2 = date('dmyHis')+1;
					    $kdtransaksi = "TKP-" . $kdunik2;
					}
    				
					mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO kdtk(kd_trkasir,id_admin) VALUES('$kdtransaksi','$_SESSION[idadmin]')");
				}

				$tglharini = date('Y-m-d');
				if ($jamkerja == 'pagi') {
					$shift = 1;
				} else {
					$shift = 2;
				}
    
                $tampil_jenisobat = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM jenis_obat ORDER BY idjenis ");
                
				echo "
		  <div class='box box-primary box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'>TAMBAH PENJUALAN</h3>
					<div class='box-tools pull-right'>
						<button class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class='box-body table-responsive'>
				
						<form onsubmit='return false;' method=POST action='$aksi?module=trkasir&act=input_trkasir' enctype='multipart/form-data' class='form-horizontal'>
						
						       <input type=hidden name='id_trkasir' id='id_trkasir' value='0'>
							   <input type=hidden name='kd_trkasir' id='kd_trkasir' value='$kdtransaksi'>
							   <input type=hidden name='stt_aksi' id='stt_aksi' value='input_trkasir'>
							   <input type=hidden name='petugas' id='petugas' value='$petugas'>
							   <input type=hidden name='shift' id='shift' value='$shift'>
							 
							 
						<div class='col-lg-6'>
							  
								<div class='form-group'>
							  
									<label class='col-sm-4 control-label'>Tanggal </label>
										<div class='col-sm-6'>
											<div class='input-group date'>
												<div class='input-group-addon'>
													<span class='glyphicon glyphicon-th'></span>
												</div>
													<input type='text' class='datepicker' name='tgl_trkasir' id='tgl_trkasir' required='required' value='$tglharini' autocomplete='off'>
											</div>
										</div>
										
									<label class='col-sm-4 control-label'>Kode Transaksi</label>        		
										<div class='col-sm-6'>
											<input type=text name='kd_hid' id='kd_hid' class='form-control' required='required' value='$kdtransaksi' autocomplete='off' Disabled>
										</div>
																		
									<label class='col-sm-4 control-label'>Pelanggan</label>        		
										<div class='col-sm-6'>
											<input type=text name='nm_pelanggan' id='nm_pelanggan' class='typeahead form-control' autocomplete='off'>
										</div>
										
									<label class='col-sm-4 control-label'>Telepon</label>        		
										<div class='col-sm-6'>
											<input type=text name='tlp_pelanggan' id='tlp_pelanggan' class='form-control' autocomplete='off'>
										</div>
										
									<label class='col-sm-4 control-label'>Alamat</label>        		
										<div class='col-sm-6'>
											<textarea name='alamat_pelanggan' id='alamat_pelanggan' class='form-control' rows='2'></textarea>
										</div>
										
									<label class='col-sm-4 control-label'>Keterangan</label>        		
										<div class='col-sm-6'>
											<textarea name='ket_trkasir' id='ket_trkasir' class='form-control' rows='2'></textarea>
										</div>
									
								</div>
							  
						</div>
						
						<div class='col-lg-6'>
						
						
								<input type=hidden name='id_barang' id='id_barang'>
								<input type=hidden name='stok_barang' id='stok_barang' >
								<input type=hidden name='id_admin' id='id_admin' value='$_SESSION[idadmin]'>
								<input type=hidden name='komisi_dtrkasir' id='komisi_dtrkasir'>
								
								<div class='form-group'>
								
									<label class='col-sm-4 control-label'>Kode Barang</label>        		
									 <div class='col-sm-7'>
									 <div class='input-group'>
										<input type=text name='kd_barang' id='kd_barang' class='form-control' autocomplete='off'>
										<div class='input-group-addon'>
											<button type=button data-toggle='modal' data-target='#ModalItem' href='#' id='kode'><span class='glyphicon glyphicon-search'></span></button>
										</div>
										</div>
									 </div>
									 
									<label class='col-sm-4 control-label'>Nama Barang</label>        		
											<div class='col-sm-7'>
													<input type=text name='nmbrg_dtrkasir' id='nmbrg_dtrkasir' class='form-control' autocomplete='off'>
											</div>
											
									<label class='col-sm-4 control-label'>ETALASE</label>        		
											<div class='col-sm-7'>
													<select class='form-control' name='jenisobat' id='jenisobat' >
													    <option></option>
													    ";
									
									               while($rj=mysqli_fetch_array($tampil_jenisobat)){
									                   echo "<option value='$rj[jenisobat]'>$rj[jenisobat]</option>";
									               }
								
								    echo "
													</select>
											</div>
											
														
									<label class='col-sm-4 control-label'>Qty</label>        		
										<div class='col-sm-7'>
											<input type='number' name='qty_dtrkasir' id='qty_dtrkasir' class='form-control' autocomplete='off'>
										</div>
										
									<label class='col-sm-4 control-label'>Satuan</label>        		
										<div class='col-sm-7'>
											<input type=text name='sat_dtrkasir' id='sat_dtrkasir' class='form-control' autocomplete='off'>
										</div>
										
									<label class='col-sm-4 control-label'>Harga</label>        		
										<div class='col-sm-7'>
											<input type=text name='hrgjual_dtrkasir' id='hrgjual_dtrkasir' class='form-control' autocomplete='off' disabled>
										</div>
										
									<label class='col-sm-4 control-label'>Komposisi dan Indikasi</label>        		
										<div class='col-sm-7'>
											<input type=text name='indikasi' id='indikasi' class='form-control' autocomplete='off'>
											</p>
												<div class='buttons'>
													<button type='button' class='btn btn-success right-block' onclick='simpan_detail();'>SIMPAN DETAIL</button>
												</div>
										</div>
										
								</div>
								
						</div>
						</form>
							  
				</div> 
				
				<div id='tabeldata'>
				
			</div>";
			}

			break;



		case "ubah":
			$ubah = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir 
	WHERE trkasir.id_trkasir='$_GET[id]'");
			$re = mysqli_fetch_array($ubah);
			$shift = $re['shift'];
			$petugas = $_SESSION['namalengkap'];

            $admin = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM komisi_pegawai 
	WHERE kd_trkasir='$re[kd_trkasir]'");
	        $radmin = mysqli_fetch_array($admin);
	        
			echo "
		  <div class='box box-primary box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'>UBAH PENJUALAN</h3>
					<div class='box-tools pull-right'>
						<button class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class='box-body table-responsive'>
				
						<form onsubmit='return false;' method=POST action='$aksi?module=trkasir&act=ubah_trkasir' enctype='multipart/form-data' class='form-horizontal'>
						
						       <input type=hidden name='id_trkasir' id='id_trkasir' value='$re[id_trkasir]'>
							   <input type=hidden name='kd_trkasir' id='kd_trkasir' value='$re[kd_trkasir]'>
							   <input type=hidden name='stt_aksi' id='stt_aksi' value='ubah_trkasir'>
							   <input type=hidden name='petugas' id='petugas' value='$petugas'>
							   <input type=hidden name='shift' id='shift' value='$shift'>
							 
						<div class='col-lg-6'>
							  
								<div class='form-group'>
							  
									<label class='col-sm-4 control-label'>Tanggal</label>
										<div class='col-sm-6'>
											<div class='input-group date'>
												<div class='input-group-addon'>
													<span class='glyphicon glyphicon-th'></span>
												</div>
													<input type='text' class='datepicker' name='tgl_trkasir' id='tgl_trkasir' value='$re[tgl_trkasir]' required='required' value='$tglharini' autocomplete='off'>
											</div>
										</div>
										
									<label class='col-sm-4 control-label'>Kode Transaksi</label>        		
										<div class='col-sm-6'>
											<input type=text name='kd_hid' id='kd_hid' class='form-control' required='required' value='$re[kd_trkasir]' autocomplete='off' Disabled>
										</div>
									
									<label class='col-sm-4 control-label'>Pelanggan</label>        		
										<div class='col-sm-6'>
											<input type=text name='nm_pelanggan' id='nm_pelanggan' class='typeahead form-control' value='$re[nm_pelanggan]' autocomplete='off'>
										</div>
										
									<label class='col-sm-4 control-label'>Telepon</label>        		
										<div class='col-sm-6'>
											<input type=text name='tlp_pelanggan' id='tlp_pelanggan' class='form-control' value='$re[tlp_pelanggan]' autocomplete='off'>
										</div>
										
									<label class='col-sm-4 control-label'>Alamat</label>        		
										<div class='col-sm-6'>
											<textarea name='alamat_pelanggan' id='alamat_pelanggan' class='form-control' rows='2'>$re[alamat_pelanggan]</textarea>
										</div>
										
									<label class='col-sm-4 control-label'>Keterangan</label>        		
										<div class='col-sm-6'>
											<textarea name='ket_trkasir' id='ket_trkasir' class='form-control' rows='2'>$re[ket_trkasir]</textarea>
										</div>
										
								</div>
							  
						</div>
						
						<div class='col-lg-6'>
						
						
								<input type=hidden name='id_barang' id='id_barang'>
								<input type=hidden name='stok_barang' id='stok_barang' >
								<input type=hidden name='id_admin' id='id_admin' value='$radmin[id_admin]'>
								<input type=hidden name='komisi_dtrkasir' id='komisi_dtrkasir'>
								
								<div class='form-group'>
									<label class='col-sm-4 control-label'>Kode Barang</label>        		
									 <div class='col-sm-7'>
									 <div class='input-group'>
										<input type=text name='kd_barang' id='kd_barang' class='form-control' autocomplete='off'>
										<div class='input-group-addon'>
											<button type=button data-toggle='modal' data-target='#ModalItem' href='#' id='kode'><span class='glyphicon glyphicon-search'></span></button>
										</div>
										</div>
									 </div>
									 
									<label class='col-sm-4 control-label'>Nama Barang</label>        		
											<div class='col-sm-7'>
													<input type=text name='nmbrg_dtrkasir' id='nmbrg_dtrkasir' class='form-control' autocomplete='off'>
											</div>
									
									<label class='col-sm-4 control-label'>ETALASE</label>        		
											<div class='col-sm-7'>
													<select class='form-control' name='jenisobat' id='jenisobat' >
													    <option></option>
													    ";
									
									               while($rj=mysqli_fetch_array($tampil_jenisobat)){
									                   echo "<option value='$rj[jenisobat]'>$rj[jenisobat]</option>";
									               }
								
								    echo "
													</select>
											</div>
											
									
									<label class='col-sm-4 control-label'>Qty</label>        		
										<div class='col-sm-7'>
											<input type='number' name='qty_dtrkasir' id='qty_dtrkasir' class='form-control' autocomplete='off'>
										</div>
											
									<label class='col-sm-4 control-label'>Satuan</label>        		
										<div class='col-sm-7'>
											<input type=text name='sat_dtrkasir' id='sat_dtrkasir' class='form-control' autocomplete='off'>
										</div>
										
									<label class='col-sm-4 control-label'>Harga</label>        		
										<div class='col-sm-7'>
											<input type=number name='hrgjual_dtrkasir' id='hrgjual_dtrkasir' class='form-control' autocomplete='off'>
										</div>
										
									<label class='col-sm-4 control-label'>Komposisi & Indikasi</label>        		
										<div class='col-sm-7'>
											<input type=text name='indikasi' id='indikasi' class='form-control' autocomplete='off'>
											</p>
												<div class='buttons'>
													<button type='button' class='btn btn-success right-block' onclick='simpan_detail();'>SIMPAN DETAIL</button>
												</div>
										</div>
								</div>
								
								
						</div>
						</form>
							  
				</div> 
				
				<div id='tabeldata'>
				
			</div>";


			break;
	}
}
?>

<!-- Modal itemmat -->
<div id="ModalItem" class="modal fade" role="dialog">
	<div class="modal-lg modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">PILIH ITEM BARANG</h4>

				<div id="box">
					<CENTER><strong>MySIFA PROFIT ANALYSIS</strong></CENTER><br>
					<center><button type="button" class="btn btn-info">PROFIT>200%</button>
						<button type="button" class="btn btn-success">PROFIT = 100 - 200 % </button>
						<button type="button" class="btn btn-warning">PROFIT = 30 - 100%"</button>
						<button type="button" class="btn btn-danger">PROFIT < 30% </button>
					</center>
				</div>
			</div>



			<div class="modal-body table-responsive">
				<table id="example" class="table table-condensed table-bordered table-striped table-hover">

					<thead>
						<tr class="judul-table">
							<th style="vertical-align: middle; background-color: #008000; text-align: center; ">No</th>
							<th style="vertical-align: middle; background-color: #008000; text-align: left; ">Kode</th>
							<th style="vertical-align: middle; background-color: #008000; text-align: left; ">Nama Barang</th>
							<th style="vertical-align: middle; background-color: #008000; text-align: right; ">Qty</th>
							<th style="vertical-align: middle; background-color: #008000; text-align: center; ">Satuan</th>
							<?PHP
				// 			$lupa = $_SESSION['level'];
				// 			if ($lupa == 'pemilik') {
								echo "<th style=\"vertical-align: middle; background-color: #008000; text-align: center; \">Harga Beli</th> ";
				// 			} else {
				// 			}
							?>
							<th style="vertical-align: middle; background-color: #008000; text-align: center; ">Harga Jual</th>
							<th style="vertical-align: middle; background-color: #008000; text-align: center; ">Komisi</th>
							<th style="vertical-align: middle; background-color: #008000; text-align: center; ">Komposisi</th>
							<th style="vertical-align: middle; background-color: #008000; text-align: center; ">Pilih</th>
						</tr>
					</thead>
					<tbody>
						<?php
						// $no = 1;
						// $tampil_dproyek = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM barang ORDER BY id_barang ASC");
						// while ($rd = mysqli_fetch_array($tampil_dproyek)) {
						// 	$Q = intval(($rd['hrgjual_barang'] - $rd['hrgsat_barang']) / $rd['hrgsat_barang']);
						// 	$harga1 = format_rupiah($rd['hrgjual_barang']);
						// 	$hargabeli = format_rupiah(intval($rd['hrgsat_barang']));

						// 	echo "<tr style='font-size: 13px;'> 
						// 				     <td align=center>$no</td>
						// 					 <td width='20px'>$rd[kd_barang]</td>
						// 					 <td>$rd[nm_barang]</td>
						// 					 <td align=right id='stok_barang'><div id='stok_$rd[id_barang]'>$rd[stok_barang]</div></td>
						// 					 <td align=center>$rd[sat_barang]</td>";
						// 	$lupa = $_SESSION['namalengkap'];
						// 	if ($lupa == 'apt. heru')
						// 		echo "	 <td align=center>$hargabeli</td></td>";

						// 	if ($Q <= 0.3) {
						// 		echo " <td style='background-color:#ff003f;'align='center'><strong>$harga1</strong></td> ";
						// 	} elseif ($Q > 0.3 && $Q <= 1) {
						// 		echo "  <td style='background-color:#f39c12;' align='center'><strong>$harga1</strong></td>";
						// 	} elseif ($Q > 1 && $Q <= 2) {
						// 		echo "  <td style='background-color:#00ff3f;' align='center'><strong>$harga1</strong></td>";
						// 	} elseif ($Q > 2) {
						// 		echo "  <td style='background-color:#00bfff;' align='center'><strong>$harga1</strong></td>";
						// 	}
						// 	echo "

						// 					 <td align=center>$rd[indikasi]</td>
						// 					 <td align=center>

						//  <button class='btn btn-xs btn-info' id='pilihbarang' 
						// 	 data-id_barang='$rd[id_barang]'
						// 	 data-kd_barang='$rd[kd_barang]'
						// 	 data-nm_barang='$rd[nm_barang]'
						// 	 data-stok_barang='$rd[stok_barang]'
						// 	 data-sat_barang='$rd[sat_barang]'
						// 	 data-indikasi='$rd[indikasi]'
						// 	 data-hrgjual_barang='$rd[hrgjual_barang]'>
						// 	 <i class='fa fa-check'></i>
						// 	 </button>

						// 					</td>
						// 				</tr>";
						// 	$no++;
						// }
						// echo "</tbody></table>";
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- end modal item -->

<script type="text/javascript">
	$(function() {
		$(".datepicker").datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			todayHighlight: true,
		});
	});
</script>

<script>
	$(document).ready(function() {
		tabel_detail();

	});

    // Autocomplete nama obat
	$('#nmbrg_dtrkasir').typeahead({
		source: function(query, process) {
			return $.post('modul/mod_trkasir/autonamabarang.php', {
				query: query
			}, function(data) {

				data = $.parseJSON(data);
				return process(data);

			});
		}
	});

	// event enter nama obat		
	$(document).ready(function() {
		$('#nmbrg_dtrkasir').on('keyup', function(e) {
// 		$('#nmbrg_dtrkasir').on('keydown', function(e) {
// 			if (e.which == 13) {
				let nm_barang = $('#nmbrg_dtrkasir').val();
				$.ajax({
					url: 'modul/mod_trkasir/autonamabarang_enter.php',
					type: 'post',
					data: {
						'nm_barang': nm_barang
					},
				}).success(function(response) {
					let data = $.parseJSON(response);
					// let data = JSON.parse(response)
					let qty_default = "1";

					for (let i = 0; i < data.length; i++) {
						data = data[i];
						document.getElementById('id_barang').value = data.id_barang;
						document.getElementById('kd_barang').value = data.kd_barang;
						document.getElementById('nmbrg_dtrkasir').value = data.nm_barang;
						document.getElementById('stok_barang').value = data.stok_barang;

						document.getElementById('qty_dtrkasir').value = qty_default;
						document.getElementById('sat_dtrkasir').value = data.sat_barang;
						document.getElementById('hrgjual_dtrkasir').value = data.hrgjual_barang;
						document.getElementById('indikasi').value = data.indikasi;
						document.getElementById('komisi_dtrkasir').value = data.komisi;
						$('#jenisobat').val(data.jenisobat).change();
					}

				});
// 			}
		})
	});
	
	$(document).on('click', '#kode', function() {
		$("#example").DataTable().destroy();

		$("#example").DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				"url": "modul/mod_trkasir/barang-serverside.php?action=table_data",
				"dataType": "JSON",
				"type": "POST"
			},
			"rowCallback": function(row, data, index) {
                let q = (data['hrgjual_barang'] - data['hrgsat_barang']) / data['hrgsat_barang'];
                
                if(q <= 0.3){
                    $(row).find('td:eq(6)').css('background-color', '#ff003f');
                    $(row).find('td:eq(6)').css('color', '#ffffff');
                } else if(q > 0.3 && q <= 1){
                    $(row).find('td:eq(6)').css('background-color', '#f39c12');
                    $(row).find('td:eq(6)').css('color', '#ffffff');
                    
                } else if(q > 1 && q <= 2){
                    $(row).find('td:eq(6)').css('background-color', '#00ff3f');
                    $(row).find('td:eq(6)').css('color', '#ffffff');
                    
                } else if(q > 2){
                    $(row).find('td:eq(6)').css('background-color', '#00bfff');
                    $(row).find('td:eq(6)').css('color', '#ffffff');
                    
                }
                
            },            
			columns: [{
					"data": "no",
					"className": 'text-center',
				},
				{
					"data": "kd_barang"
				},
				{
					"data": "nm_barang"
				},
				{
					"data": "stok_barang",
					"className": 'text-center',
				},
				{
					"data": "sat_barang",
					"className": 'text-center',
				},
				{
					"data": "hrgsat_barang",
					"className": 'text-right',
					"visible": <?= ($_SESSION['level'] == 'pemain') ? 'true' : 'false'; ?>,
					"render": function(data, type, row) {
						return formatRupiah(data);
					}
				},
				{
					"data": "hrgjual_barang",
					"className": 'text-right',
					"render": function(data, type, row) {
						return formatRupiah(data);
					}
				},
				{
					"data": "komisi",
					"className": 'text-right',
					"render": function(data, type, row) {
						return formatRupiah(data);
					}
				},
				{
					"data": "indikasi",
					"className": 'text-center'
				},
				{
					"data": "pilih",
					"className": 'text-center'
				},
			],
			"footerCallback": function(row, data, start, end, display) {
				// console.log(row);
			}
		})

	});

	$(document).on('click', '#pilihbarang', function() {

		var id_barang = $(this).data('id_barang');
		var kd_barang = $(this).data('kd_barang');
		var nm_barang = $(this).data('nm_barang');
		var stok_barang = $(this).data('stok_barang');
		var sat_barang = $(this).data('sat_barang');
		var hrgjual_barang = $(this).data('hrgjual_barang');
		var indikasi = $(this).data('indikasi');
		var jenisobat = $(this).data('jenisobat');
		var komisi_dtrkasir = $(this).data('komisi');
		var qty_default = "1";

		document.getElementById('id_barang').value = id_barang;
		document.getElementById('kd_barang').value = kd_barang;
		document.getElementById('nmbrg_dtrkasir').value = nm_barang;
		document.getElementById('stok_barang').value = stok_barang;

		document.getElementById('qty_dtrkasir').value = qty_default;
		document.getElementById('sat_dtrkasir').value = sat_barang;
		document.getElementById('hrgjual_dtrkasir').value = hrgjual_barang;
		document.getElementById('indikasi').value = indikasi;
		document.getElementById('komisi_dtrkasir').value = komisi_dtrkasir;
		$('#jenisobat').val(jenisobat).change();

		// $.ajax({
		// 	url: 'modul/mod_trkasir/gettabel_barang.php',
		// 	type: 'post',
		// 	data: {
		// 		'id_barang': id_barang
		// 	},
		// 	dataType: 'JSON',
		// 	success: function(response) {
		// 		document.getElementById('id_barang').value = response[0].id_barang;
		// 		document.getElementById('kd_barang').value = response[0].kd_barang;
		// 		document.getElementById('nmbrg_dtrkasir').value = response[0].nm_barang;
		// 		document.getElementById('stok_barang').value = response[0].stok_barang;

		// 		document.getElementById('qty_dtrkasir').value = qty_default;
		// 		document.getElementById('sat_dtrkasir').value = response[0].sat_barang;
		// 		document.getElementById('hrgjual_dtrkasir').value = response[0].hrgjual_barang;
		// 		document.getElementById('indikasi').value = response[0].indikasi;

		// 	}

		// });

		//hilangkan modal
		$(".close").click();

	});


	function simpan_detail() {

		let kd_trkasir = document.getElementById('kd_trkasir').value;
		let id_barang = document.getElementById('id_barang').value;
		let kd_barang = document.getElementById('kd_barang').value;
		let nmbrg_dtrkasir = document.getElementById('nmbrg_dtrkasir').value;
		let stok_barang = document.getElementById('stok_barang').value;
		let qty_dtrkasir = document.getElementById('qty_dtrkasir').value;
		let sat_dtrkasir = document.getElementById('sat_dtrkasir').value;
		let hrgjual_dtrkasir = document.getElementById('hrgjual_dtrkasir').value;
		let indikasi = document.getElementById('indikasi').value;
		let jenisobat = document.getElementById('jenisobat').value;
        let komisi_dtrkasir = document.getElementById('komisi_dtrkasir').value;
        let id_admin = document.getElementById('id_admin').value;

		if (nmbrg_dtrkasir == "") {
			alert('Belum ada Item terpilih');
		} else if (qty_dtrkasir == "") {
			alert('Qty tidak boleh kosong');
// 		} else if (parseInt(stok_barang) < parseInt(qty_dtrkasir)) {
// 			alert('Stok barang tidak mencukupi');
		} else {


			$.ajax({

				type: 'post',
				url: "modul/mod_trkasir/simpandetail_trkasir.php",
				data: {
					'kd_trkasir': kd_trkasir,
					'id_barang': id_barang,
					'kd_barang': kd_barang,
					'nmbrg_dtrkasir': nmbrg_dtrkasir,
					'qty_dtrkasir': qty_dtrkasir,
					'sat_dtrkasir': sat_dtrkasir,
					'hrgjual_dtrkasir': hrgjual_dtrkasir,
					'indikasi': indikasi,
					'jenisobat': jenisobat,
					'komisi_dtrkasir': komisi_dtrkasir,
					'id_admin': id_admin,
				},
				success: function(data) {
					//alert('Tambah data detail berhasil');
					document.getElementById("id_barang").value = "";
					document.getElementById("kd_barang").value = "";
					document.getElementById("nmbrg_dtrkasir").value = "";
					document.getElementById("qty_dtrkasir").value = "";
					document.getElementById("sat_dtrkasir").value = "";
					document.getElementById("hrgjual_dtrkasir").value = "";
					document.getElementById("indikasi").value = "";
					document.getElementById("komisi_dtrkasir").value = "";
				// 	$('#jenisobat').val().change();
					tabel_detail();

					let displayStok = stok_barang - qty_dtrkasir;
					$('#stok_' + id_barang).html(displayStok);
				}
			});
		}
	}



	$(document).on('click', '#hapusdetail', function() {

		var id_dtrkasir = $(this).data('id_dtrkasir');
		var id_barang = $(this).data('id_barang');

		$.ajax({
			type: 'post',
			url: "modul/mod_trkasir/hapusdetail_trkasir.php",
			data: {
				id_dtrkasir: id_dtrkasir
			},

			success: function(data) {
				//setelah simpan data, tabel_detail data terbaru
				//alert('Hapus data detail berhasil');
				tabel_detail();
				$('#stok_' + id_barang).html(data);
				//hilangkan modal
				$(".close").click();
			}
		});

	});



	//fungsi tabel detail
	function tabel_detail() {

		var kd_trkasir = document.getElementById('kd_trkasir').value;
		var stt_aksi = document.getElementById('stt_aksi').value;

		$.ajax({
			url: 'modul/mod_trkasir/tbl_detail.php',
			type: 'post',
			data: {
				'kd_trkasir': kd_trkasir,
				'stt_aksi': stt_aksi
			},
			success: function(data) {
				$('#tabeldata').html(data);
			}

		});
	}

	//auto pelanggan
	$('#nm_pelanggan').typeahead({
		source: function(query, process) {
			return $.get('modul/mod_trkasir/autopelanggan.php', {
				query: query
			}, function(data) {

				console.log(data);
				data = $.parseJSON(data);
				return process(data);

			});
		}
	});


	//enter pelanggan
	$('#nm_pelanggan').keydown(function(e) {
		if (e.which == 13) { // e.which == 13 merupakan kode yang mendeteksi ketika anda   // menekan tombol enter di keyboard
			//letakan fungsi anda disini

			var nm_pelanggan = $("#nm_pelanggan").val();
			$.ajax({
				url: 'modul/mod_trkasir/autopelanggan_enter.php',
				type: 'post',
				data: {
					'nm_pelanggan': nm_pelanggan
				},
			}).success(function(data) {

				var json = data;
				//replace array [] menjadi '' 
				var res1 = json.replace("[", "");
				var res2 = res1.replace("]", "");
				//INI CONTOH ARRAY JASON const json = '{"result":true, "count":42}';
				datab = JSON.parse(res2);
				document.getElementById('nm_pelanggan').value = datab.nm_pelanggan;
				document.getElementById('tlp_pelanggan').value = datab.tlp_pelanggan;
				document.getElementById('alamat_pelanggan').value = datab.alamat_pelanggan;
			});

		}
	});

	$('#kd_barang').keydown(function(e) {
		if (e.which == 13) { // e.which == 13 merupakan kode yang mendeteksi ketika anda   // menekan tombol enter di keyboard
			//letakan fungsi anda disini

			var kd_brg = $("#kd_barang").val();
			$.ajax({
				url: 'modul/mod_trkasir/autobarang.php',
				type: 'post',
				data: {
					'kd_brg': kd_brg
				},
			}).success(function(data) {

				var json = data;
				//replace array [] menjadi '' 
				var res1 = json.replace("[", "");
				var res2 = res1.replace("]", "");
				//INI CONTOH ARRAY JASON const json = '{"result":true, "count":42}';
				datab = JSON.parse(res2);
				document.getElementById('id_barang').value = datab.id_barang;
				document.getElementById('nmbrg_dtrkasir').value = datab.nm_barang;
				document.getElementById('stok_barang').value = datab.stok_barang;
				document.getElementById('qty_dtrkasir').value = "1";
				document.getElementById('sat_dtrkasir').value = datab.sat_barang;
				document.getElementById('hrgjual_dtrkasir').value = datab.hrgjual_barang;
				document.getElementById('indikasi').value = datab.indikasi;

			});

		}
	});


	function simpan_transaksi() {

		var id_trkasir = document.getElementById('id_trkasir').value;
		var kd_trkasir = document.getElementById('kd_trkasir').value;
		var petugas = document.getElementById('petugas').value;
		var shift = document.getElementById('shift').value;
		var tgl_trkasir = document.getElementById('tgl_trkasir').value;
		var nm_pelanggan = document.getElementById('nm_pelanggan').value;
		var tlp_pelanggan = document.getElementById('tlp_pelanggan').value;
		var alamat_pelanggan = document.getElementById('alamat_pelanggan').value;
		var ttl_trkasir = document.getElementById('ttl_trkasir').value;
		var dp_bayar = document.getElementById('dp_bayar').value;
		var sisa_bayar = document.getElementById('sisa_bayar').value;
		var ket_trkasir = document.getElementById('ket_trkasir').value;
		var stt_aksi = document.getElementById('stt_aksi').value;
		var id_carabayar = document.getElementById('id_carabayar').value;


		var ttl_trkasir1 = ttl_trkasir.replace(".", "");
		var dp_bayar1 = dp_bayar.replace(".", "");
		var sisa_bayar1 = sisa_bayar.replace(".", "");

		var ttl_trkasir1x = ttl_trkasir1.replace(".", "");
		var dp_bayar1x = dp_bayar1.replace(".", "");
		var sisa_bayar1x = sisa_bayar1.replace(".", "");

        var diskon1 = document.getElementById('diskon').value;
        var diskon1x = diskon1.replace(/\./g, "");
        
        var diskon2 = document.getElementById('diskon2').value;
        var diskon2x = diskon2.replace(/\./g, "");

		if (parseInt(dp_bayar1x) < parseInt(ttl_trkasir1x)) {
			alert('Input Nominal Bayar Lebih besar dari harga');
		} else {

			$.ajax({

				type: 'post',
				url: "modul/mod_trkasir/aksi_trkasir.php",
				dataType: 'json',
				data: {
					'id_trkasir': id_trkasir,
					'kd_trkasir': kd_trkasir,
					'tgl_trkasir': tgl_trkasir,
					'petugas': petugas,
					'shift': shift,
					'nm_pelanggan': nm_pelanggan,
					'tlp_pelanggan': tlp_pelanggan,
					'alamat_pelanggan': alamat_pelanggan,
					'ttl_trkasir': ttl_trkasir1x,
					'dp_bayar': dp_bayar1x,
					'sisa_bayar': sisa_bayar1x,
					'ket_trkasir': ket_trkasir,
					'stt_aksi': stt_aksi,
					'id_carabayar': id_carabayar,
					'diskon1': diskon1x,
					'diskon2': diskon2x
				},
				success: function(data) {
					console.log(data);
					if (data.message == 'success') {
						window.open('modul/mod_laporan/struk.php?kd_trkasir=' + kd_trkasir, 'nama window', 'width=400,height=700,toolbar=no,location=no,directories=no,status=no,menubar=no, scrollbars=no,resizable=yes,copyhistory=no');
						alert('Proses berhasil !');
						window.location = 'media_admin.php?module=trkasir';

					} else {
						window.location.reload();
					}

				}

				//	success: function(data) {

				//	window.open('modul/mod_laporan/struk.php?kd_trkasir='+kd_trkasir, 'nama window','
				//  	width=400,height=700,toolbar=no,location=no,directories=no,status=no,menubar=no,
				//  	scrollbars=no,resizable=yes,copyhistory=no');
				//	alert('Proses berhasil !');window.location='media_admin.php?module=trkasir';

				//	}
			});
		}

	}


	function cetakstruk() {

		var kd_trkasir = document.getElementById('kd_trkasir').value;

		//window.open("modul/mod_laporan/struk.php?kd_trkasir="+kd_trkasir,"_blank");
		window.open('modul/mod_laporan/struk.php?kd_trkasir=' + kd_trkasir, 'nama window', 'width=400,height=700,toolbar=no,location=no,directories=no,status=no,menubar=no, scrollbars=no,resizable=yes,copyhistory=no');

	}

	function cetakstrukresep() {

		var kd_trkasir = document.getElementById('kd_trkasir').value;

		//window.open("modul/mod_laporan/struk.php?kd_trkasir="+kd_trkasir,"_blank");
		window.open('modul/mod_laporan/strukresep.php?kd_trkasir=' + kd_trkasir, 'nama window', 'width=400,height=700,toolbar=no,location=no,directories=no,status=no,menubar=no, scrollbars=no,resizable=yes,copyhistory=no');

	}
</script>