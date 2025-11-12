<?php
session_start();
include "../../../configurasi/koneksi.php";
include "../../../configurasi/fungsi_indotgl.php";

// $unit = intval($_SESSION['unit']);
//ambil header
$ah = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM setheader ");
$rh = mysqli_fetch_array($ah);

$dt = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir
    JOIN carabayar ON trkasir.id_carabayar = carabayar.id_carabayar
    WHERE trkasir.kd_trkasir='$_GET[kd_trkasir]'");
$r1 = mysqli_fetch_array($dt);

$carabayar = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM carabayar
    WHERE id_carabayar ='$r1[id_carabayar]'");
$bayar = mysqli_fetch_array($carabayar);
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
        <?php        
        // echo (str_repeat("=", 26) . "<br/>");

        echo '<table cellpadding="0" cellspacing="0" style="width:100%">
                    <tr>
                        <td align="left" class="txt-left">Nota&nbsp;</td>
                        <td align="left" class="txt-left">:</td>
                        <td align="left" class="txt-left">&nbsp;' . $r1['kd_trkasir'] . '</td>
                    </tr>
                    <tr>
                        <td align="left" class="txt-left">Kasir</td>
                        <td align="left" class="txt-left">:</td>
                        <td align="left" class="txt-left">&nbsp;' . $r1['petugas'] . '</td>
                    </tr>
                    <tr>
                        <td align="left" class="txt-left">Tgl.&nbsp;</td>
                        <td align="left" class="txt-left">:</td>
                        <td align="left" class="txt-left">&nbsp;' . tgl_indo($r1['tgl_trkasir']) . '</td>
                    </tr>
                </table>';
        // echo '<br/>';
        // $tItem = 'Item' . str_repeat("&nbsp;", (30 - strlen('Item')));
        // $tQty  = 'Qty' . str_repeat("&nbsp;", (6 - strlen('Qty')));
        // $tHarga = str_repeat("&nbsp;", (9 - strlen('Harga'))) . 'Harga';
        // $tTotal = str_repeat("&nbsp;", (10 - strlen('Total'))) . 'Subtotal';
        // $caption = $tItem . $tQty . $tHarga . $tTotal;

        // echo    '<table cellpadding="0" cellspacing="0" style="width:100%">
        //                 <tr>
        //                     <td align="left" class="txt-left">' . $caption . '</td>
        //                 </tr>
        //                 <tr>
        //                     <td align="left" class="txt-left">' . str_repeat("=", 35) . '</td>
        //                 </tr>';

        $query = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir_detail WHERE kd_trkasir='$_GET[kd_trkasir]' 
            ORDER BY id_dtrkasir ASC");

        // $Rpsubtotal = 0;
        // $diskon = 0;
        // while ($r2 = mysqli_fetch_array($query)) {
        //     $st[]       = $r2['hrgttl_dtrkasir'];
        //     $gt         = array_sum($st);
        //     $Rpsubtotal = $gt;
        //     $diskon     = round((($gt - $r1['ttl_trkasir']) / $gt) * 100);

        //     $pnjg_kode = strlen($r['kd_barang']);
            
        //     // $item = $r2['nmbrg_dtrkasir'] . str_repeat("&nbsp;", (38 - (strlen($r2['nmbrg_dtrkasir']))));
        //     // $item = $r2['kd_barang'] . str_repeat("&nbsp;", (35 - (strlen($r2['kd_barang']))));
        //     $item = $r2['kd_barang'] . str_repeat("&nbsp;", (25 - (strlen($r2['kd_barang']))));
        //     // echo '<tr>';
        //     // echo '<td align="left" class="txt-left">' . $item . '</td>';
        //     // echo '</tr>';

        //     // echo '<tr>';

        //     $qty        = $r2['qty_dtrkasir'];
        //     // $qty        = "&nbsp;" . str_repeat("&nbsp;", (30 - strlen($qty)));
        //     $qty        = "&nbsp;" . str_repeat("&nbsp;", (0 - strlen($qty)));

        //     $qty2       = $r2['qty_dtrkasir'];
        //     $qty2       = str_repeat("&nbsp;", (6 - strlen($qty2))) . $qty2;

        //     $price      = number_format($r2['hrgjual_dtrkasir'], 0, ',', '.');
        //     $price      = str_repeat("&nbsp;", (14 - strlen($price))) . $price;

        //     $total      = number_format($r2['hrgttl_dtrkasir'], 0, ',', '.');
        //     $lentotal   = strlen($total);
        //     $total      = str_repeat("&nbsp;", (14 - $lentotal)) . $total;
        //     // echo '<td class="txt-left" align="left">' . $qty . $qty2 . $price . $total . '</td>';
        //     echo '<td class="txt-left" align="left">' .$item. $qty . $qty2 . $price . $total . '</td>';

        //     echo '</tr>';
            
            
        // }
        
        ?>
        <table width="100%" class="item" style="margin-top: 20px;">
            <tr>
                <td width="30%">Item</td>
                <td class="txt-right" width="15%" style="padding-right:5px">Qty</td>
                <td class="txt-right" width="25%" style="padding-right:5px">Harga</td>
                <td class="txt-right" width="30%" style="padding-right:5px">Subtotal</td>
            </tr>
            <tr>
                <td align="left" class="txt-left" colspan="4"><?=str_repeat("=", 25)?></td>
            </tr>
            
            <?php
            while ($r2 = mysqli_fetch_array($query)) {
                $st[]       = $r2['hrgttl_dtrkasir'];
                $gt         = array_sum($st) * (1 + ($r1['ppn_trkasir']/100));
                $Rpsubtotal = $gt;
                $diskon     = round((($gt - $r1['ttl_trkasir']) / $gt) * 100);

            ?>
            <tr>
                <td width="100%" colspan="4" style="word-wrap: break-word;"><?=$r2['nmbrg_dtrkasir']?></td>
            </tr>
            <tr>
                <!--<td width="45%" style="word-wrap: break-word;"><?=$r2['nmbrg_dtrkasir']?></td>-->
                <td class="txt-right" colspan="2" style="padding-right:5px"><?=$r2['qty_dtrkasir']?></td>
                <td class="txt-right" width="25%" style="padding-right:5px"><?=number_format($r2['hrgjual_dtrkasir'], 0, ',', '.')?></td>
                <td class="txt-right" width="25%" style="padding-right:5px"><?=number_format($r2['hrgttl_dtrkasir'], 0, ',', '.')?></td>
            </tr>
            <?php
            }
            ?>
            
        </table>
        <?php
        // echo '<tr><td>' . str_repeat('-', 45) . '</td></tr>';
        ?>
        
        <table width="100%" class="item">
            <tr>
                <td align="left" class="txt-left" ><?=str_repeat("=", 25)?></td>
            </tr>
                
        </table>
            
        <table width="100%" class="item">
            <tr>
                <td width="45%">Metode Bayar</td>
                <td class="txt-right" width="25%" style="padding-right:5px">Total</td>
                <td class="txt-right" width="30%" style="padding-right:5px"><?=number_format($Rpsubtotal, 0, ',', '.')?></td>
            </tr>
            
        </table>
        
        <table width="100%" class="item">
            <tr>
                <td width="30%"><?=$bayar['nm_carabayar']?></td>
                <td class="txt-right" width="40%" style="padding-right:5px">Diskon(%)</td>
                <td class="txt-right" width="30%" style="padding-right:5px"><?=$diskon;?></td>
            </tr>
            <tr>
                <td width="30%"></td>
                <td class="txt-right" width="40%" style="padding-right:5px">Cash</td>
                <td class="txt-right" width="30%" style="padding-right:5px"><?=number_format($r1['dp_bayar'], 0, ',', '.');?></td>
            </tr>
            <tr>
                <td width="30%"></td>
                <td class="txt-right" width="40%" style="padding-right:5px">Kembalian</td>
                <td class="txt-right" width="30%" style="padding-right:5px"><?=number_format($r1['sisa_bayar'], 0, ',', '.');?></td>
            </tr>
        </table>
        
        <?php
        
        //Sub Total
        // $metode1    = 'Metode&nbsp;Bayar';
        // $metode1    = $metode1 . str_repeat("&nbsp;", (25 - strlen($metode1)));

        // $subtotal   = 'Total&nbsp;';
        // $subtotal   = $subtotal . str_repeat("&nbsp;", (28 - strlen($subtotal)));
        // $Ssubtotal  = number_format($Rpsubtotal, 0, ',', '.');
        // $Ssubtotal  = str_repeat("&nbsp;", (13 - strlen($Ssubtotal))) . $Ssubtotal;
        // echo '<tr><td>' . $metode1 . $subtotal . $Ssubtotal . '</td></tr>';

        // $metode2    = $bayar['nm_carabayar'];
        // $metode2    = $metode2 . str_repeat("&nbsp;", (26 - strlen($metode2)));

        // $titleDisc  = 'Diskon(%)';
        // $titleDisc  = $titleDisc . str_repeat("", (20 - strlen($titleDisc)));
        // $Rpdisc     = $diskon;
        // $Rpdisc     = str_repeat("&nbsp;", (25 - strlen($Rpdisc))) . $Rpdisc;
        // echo '<tr><td>' . $metode2 . $titleDisc . $Rpdisc . '</td></tr>';
        
        // $titlePPN  = 'PPN(%)';
        // $titlePPN  = $titlePPN . str_repeat("", (20 - strlen($titleDisc)));
        // $RpPPN     = $diskon;
        // $RpPPN     = str_repeat("&nbsp;", (29 - strlen($RpPPN))) . $RpPPN;
        // echo '<tr><td>' . $metode2 . $titlePPN . $RpPPN . '</td></tr>';

        // $metode3        = '&nbsp;';
        // $metode3        = $metode3 . str_repeat("&nbsp;", (35 - strlen($metode3)));
        // // $titleTagihan   = 'Tagihan';
        // // $titleTagihan   = $titleTagihan . str_repeat("", (20 - strlen($titleTagihan)));
        // // $Rptagihan      = number_format($r1['ttl_trkasir'], 0, ',', '.');
        // // $Rptagihan      = str_repeat("&nbsp;", (26 - strlen($Rptagihan))) . $Rptagihan;
        // // echo '<tr><td>' . $metode3 . $titleTagihan . $Rptagihan . '</td></tr>';

        // $titleCash = 'Uang&nbsp;Cash';
        // $titleCash = $titleCash . str_repeat("&nbsp;", (14 - strlen($titleCash)));
        // $Rpcash      = number_format($r1['dp_bayar'], 0, ',', '.');
        // $Rpcash      = str_repeat("&nbsp;", (20 - strlen($Rpcash))) . $Rpcash;
        // echo '<tr><td>' . $metode3 . $titleCash . $Rpcash . '</td></tr>';

        // $titleKembalian = 'Kembalian';
        // $titleKembalian = $titleKembalian . str_repeat("", (14 - strlen($titleKembalian)));
        // $Rpkembalian      = number_format($r1['sisa_bayar'], 0, ',', '.');
        // $Rpkembalian      = str_repeat("&nbsp;", (22 - strlen($Rpkembalian))) . $Rpkembalian;
        // echo '<tr><td>' . $metode3 . $titleKembalian . $Rpkembalian . '</td></tr>';

        // echo '<tr><td>&nbsp;</td></tr>';
        // echo '</table>';

        $footer = 'Terima kasih atas kunjungan anda';
        $footer1 = $rh['delapan'];
        $starSpace1 = (22 - strlen($footer1)) / 2;
        $starFooter1 = str_repeat('*', $starSpace1 + 1);
        // echo ($starFooter1 . '&nbsp;' . $footer1 . '&nbsp;' . $starFooter1 . "<br/>");

        $footer2 = $rh['sembilan'];
        // echo ($footer2 . "<br/>");

        $footer3 = $rh['sepuluh'];
        // echo ($footer3 . "<br/><br/><br/><br/>");
        
        
        $batas = "sobek&nbsp;disini";
        $starSpace2 = (44 - strlen($batas)) / 2;
        $starFooter2 = str_repeat('-', $starSpace2 + 1);
        // echo ($starFooter2 . '&nbsp;' . $batas . '&nbsp;' . $starFooter2 . "<br/>");
        // echo '<p>&nbsp;</p>';

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