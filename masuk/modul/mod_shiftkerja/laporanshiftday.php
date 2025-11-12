<?php
session_start();
include "../../../configurasi/koneksi.php";
require('../../assets/pdf/fpdf.php');
include "../../../configurasi/fungsi_indotgl.php";
include "../../../configurasi/fungsi_rupiah.php";

// $unit = intval($_SESSION['unit']);
//ambil header
$ah = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM setheader ");
$rh = mysqli_fetch_array($ah);

$id = $_GET['idshift'];

$dtshift = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM waktukerja WHERE id_shift='$id'");
$rshift = mysqli_fetch_array($dtshift);

$shift = ($rshift['shift']=='pagi')?'1':'2';
$tgl_trkasir = $rshift['tanggal'];

$dt = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(ttl_trkasir) as ttl_penjualan FROM trkasir
WHERE shift='$shift' AND tgl_trkasir='$tgl_trkasir'");
$r1 = mysqli_fetch_array($dt);

$dnum = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir 
WHERE shift='$shift' AND tgl_trkasir='$tgl_trkasir'");

$rnum = mysqli_num_rows($dnum);
$rrnum = mysqli_fetch_array($dnum);


$dt2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(ttl_trkasir) as ttl_tunai FROM trkasir 
WHERE shift='$shift' AND tgl_trkasir='$tgl_trkasir' AND id_carabayar='1'");
$r2 = mysqli_fetch_array($dt2);

$dt3 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(ttl_trkasir) as ttl_transfer FROM trkasir 
WHERE shift='$shift' AND tgl_trkasir='$tgl_trkasir' AND id_carabayar='2'");
$r3 = mysqli_fetch_array($dt3);

$dt4 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(ttl_trkasir) as ttl_tempo FROM trkasir 
WHERE shift='$shift' AND tgl_trkasir='$tgl_trkasir' AND id_carabayar='3'");
$r4 = mysqli_fetch_array($dt4);


$tgl_awal = date('Y-m-d');
$jumlahdetail = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir where tgl_trkasir ='$tgl_awal' order by id_trkasir desc ");
$countdetail = mysqli_num_rows($jumlahdetail);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="struk.css">
    <script type="text/javascript" src="../../js/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="../../js/jquery-1.10.2.js"></script>
    <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    
    <style>
        .item {
            table-layout: fixed;      /* Fix lebar kolom */
            width: 100%;
            border-collapse: collapse;
        }
        body, table, td {
            font-family: Arial, sans-serif;
            font-size: 10pt;
        }
        
        .item th, .item td {
          vertical-align: top;
          word-wrap: break-word;    /* Bungkus kata */
          overflow-wrap: break-word;
        }
    
        /* Misal: kolom pertama fix 100px */
        .col-kode {
          width: 100px;
        }
    
        .col-deskripsi {
          width: 200px;
        }
        @media print
        {
            body .noprint
            {
                display: none !important;
                height: 0;
            }
        
        }
        
        
    </style>
</head>

<body class="struk" onload="printOut()">
    <button onclick="javascript:window.close()" class="noprint" autofocus>[Press ESC] For Close</button>
    <section class="sheet">
    
        
        <?php
        echo '<table cellpadding="0" cellspacing="0" align="center">
                    <tr>
                        <td class="txt-center"><h3>' . $rh['satu'] . '</h3></td>
                    </tr>
                    <tr>
                        <td class="txt-center">' . $rh['dua'] . '</td>
                    </tr>
                    <tr>
                        <td class="txt-center">' . $rh['tiga'] . '</td>
                    </tr>
                    <tr>
                        <td class="txt-center">' . $rh['empat'] . '</td>
                    </tr>
                    <tr>
                        <td class="txt-center">' . $rh['lima'] . '</td>
                    </tr>
                    <tr>
                        <td class="txt-center">' . $rh['enam'] . '</td>
                    </tr>
                    <tr>
                        <td class="txt-center">' . $rh['tujuh'] . '</td>
                    </tr>
                </table>';
                
        ?>
            <table width="100%" class="item">
                <tr>
                    <td align="left" class="txt-left" ><?=str_repeat("=", 25)?></td>
                </tr>
                
            </table>
            
            <table width="100%" class="item">
                <tr>
                    <td width="55%">Tanggal</td>
                    <td width="5%">:</td>
                    <td width="40%"><?= tgl_indo($tgl_trkasir)?></td>
                </tr>
                <tr>
                    <td>Total Penjualan</td>
                    <td>:</td>
                    <td><?= format_rupiah($r1['ttl_penjualan'])?></td>
                </tr>
                <tr>
                    <td>Tunai</td>
                    <td>:</td>
                    <td><?= format_rupiah($r2['ttl_tunai'])?></td>
                </tr>
                <tr>
                    <td>Transfer</td>
                    <td>:</td>
                    <td><?= format_rupiah($r3['ttl_transfer'])?></td>
                </tr>
                <tr>
                    <td>Tempo</td>
                    <td>:</td>
                    <td><?= format_rupiah($r4['ttl_tempo'])?></td>
                </tr>
                <tr>
                    <td>Jumlah Transaksi</td>
                    <td>:</td>
                    <td><?= $rnum?></td>
                </tr>
                <tr>
                    <td>Petugas Buka</td>
                    <td>:</td>
                    <td><?= ($rnum == 0) ? "" : $rshift['petugasbuka']?></td>
                </tr>
                <tr>
                    <td>Petugas Tutup</td>
                    <td>:</td>
                    <td><?= ($rnum == 0) ? "" : $rshift['petugastutup']?></td>
                </tr>
                
            </table>
            
            <table width="100%" class="item">
                <tr>
                    <td align="left" class="txt-left" ><?=str_repeat("=", 25)?></td>
                </tr>
                
            </table>
            
        <?php
        
        
        $footer = 'Terima kasih atas kunjungan anda';
        $footer1 = $rh['delapan'];
        $starSpace1 = (22 - strlen($footer1)) / 2;
        $starFooter1 = str_repeat('*', $starSpace1 + 1);
        
        $footer2 = $rh['sembilan'];
        
        $footer3 = $rh['sepuluh'];
        
        $batas = "sobek&nbsp;disini";
        $starSpace2 = (44 - strlen($batas)) / 2;
        $starFooter2 = str_repeat('-', $starSpace2 + 1);
        
        ?>
        
        <table width="100%" class="item" style="margin-top: 20px">
            <tr>
                <td align="left" class="txt-left" ><?= ($starFooter1 . '&nbsp;' . $footer1 . '&nbsp;' . $starFooter1 . "<br/>"); ?></td>
            </tr>
            <tr>
                <td align="left" class="txt-left" ><?= $footer2; ?></td>
            </tr>
            <tr>
                <td align="left" class="txt-left" ><?= $footer3; ?></td>
            </tr>
            <tr>
                <td align="left" class="txt-left" >&nbsp;</td>
            </tr>
            <tr>
                <td align="left" class="txt-left" ><?= ($starFooter2 . '&nbsp;' . $batas . '&nbsp;' . $starFooter2 . "<br/>"); ?></td>
            </tr>
            <tr>
                <td align="left" class="txt-left" ><p>&nbsp;</p></td>
            </tr>
            
        </table>
    </section>

    <script>
        function printOut() {
            window.print();
        }
        
        
        $(function(){
        //Yes! use keydown because some keys are fired only in this trigger,
        //such arrows keys
            $("body").keydown(function(e){
                 //well so you need keep on mind that your browser use some keys 
                 //to call some function, so we'll prevent this
                //  e.preventDefault();
        
                 //now we caught the key code.
                var keyCode = e.keyCode || e.which;
        
                 //your keyCode contains the key code, F1 to F12 
                 //is among 112 and 123. Just it.
                console.log(keyCode);
                if(keyCode == 27){
                    window.close();
                }    
                
            });
        });
    </script>
    
    
</body>

</html>