<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{

    include "../../../configurasi/koneksi.php";
    include "../../../configurasi/fungsi_thumb.php";
    include "../../../configurasi/library.php";
    
    $module=$_GET['module'];
    $act=$_GET['act'];
    
    // Input admin
    if ($module=='komisi' AND $act=='input_komisi'){
        // echo $_POST['barang'];
        // die();
        if(strtolower($_POST['barang']) == 'all'){
            if($_POST['metode'] == 'nominal'){
                
                mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE barang SET
                                        komisi = '$_POST[komisi]' ");
            }else{
                mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE barang SET
                                        komisi = ROUND((hrgsat_barang*$_POST[komisi])/100,0) ");
            }
        } else {
            if($_POST['metode'] == 'nominal'){
            
                mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE barang SET
                                        komisi = '$_POST[komisi]'
    									WHERE nm_barang = '$_POST[nm_barang]'");
            }else{
                mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE barang SET
                                        komisi = ROUND((hrgsat_barang*$_POST[komisi])/100,0)
    									WHERE nm_barang = '$_POST[nm_barang]'");
                
            }							
        }
        //echo "<script type='text/javascript'>alert('Data berhasil ditambahkan !');window.location='../../media_admin.php?module=".$module."'</script>";
        header('location:../../media_admin.php?module='.$module);

    }
    elseif ($module=='komisi' AND $act=='input_komisiglobal'){
        $tgl_awal = date('Y-m-d');
        $bulan = substr($tgl_awal,5,2);
        $petugas = $_SESSION['namalengkap'];
        //ambil data table komisiglobal
        $stat = $db->query("select * from komisiglobal where month(tgl)='$bulan' ");
        $stat2 = mysqli_num_rows($stat);
        if($stat2>0) {
            mysqli_query($GLOBALS["___mysqli_ston"], "update komisiglobal set
                                         nilai = '$_POST[nilai]',
                                         tgl = '$tgl_awal',
										 petugas = '$petugas',
										 status = '$_POST[status]'
										 WHERE status='ON'								
                                           ");
            header('location:../../media_admin.php?module=' . $module . '&act=global');
        }
        else {
            mysqli_query($GLOBALS["___mysqli_ston"], "insert into komisiglobal 
                                        ( 
                                        nilai,
                                        tgl,
                                        petugas,
                                        status
                                        )
                                        VALUES (
                                        '$_POST[nilai]',
                                        '$tgl_awal',
                                        '$petugas',
                                        '$_POST[status]'
                                        )");
            mysqli_query($GLOBALS["___mysqli_ston"], "update komisiglobal set status='OFF' WHERE month(tgl) <'$bulan'  ");
            header('location:../../media_admin.php?module=' . $module . '&act=global');
        }}
     //update barang
    elseif ($module=='komisi' AND $act=='update_komisi'){
    
        if($_POST['metode'] == 'nominal'){
            
                mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE barang SET
                                        komisi = '$_POST[komisi]'
    									WHERE id_barang = '$_POST[barang]'");
    									
        }else{
                mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE barang SET
                                        komisi = ROUND((hrgsat_barang*$_POST[komisi])/100,0)
    									WHERE id_barang = '$_POST[barang]'");
                
        }
         
    												
    	//echo "<script type='text/javascript'>alert('Data berhasil diubah !');window.location='../../media_admin.php?module=".$module."'</script>";
    	header('location:../../media_admin.php?module='.$module);
    	
    }
    //Hapus Proyek
    elseif ($module=='komisi' AND $act=='hapus'){
        
        if($_GET['id']=='all'){
            
            mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE barang SET
                                                komisi = 0 ");
            	
        } else {
            
            mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE barang SET
                                                komisi = 0
            									WHERE id_barang = '$_GET[id]'");
            	
        }
        //echo "<script type='text/javascript'>alert('Data berhasil dihapus !');window.location='../../media_admin.php?module=".$module."'</script>";
        header('location:../../media_admin.php?module='.$module);
    }
    //Close komisi
    elseif ($module=='komisi' AND $act=='close'){
        
        mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE komisi_pegawai SET
                                                status_komisi = 'closed'
            									WHERE status_komisi = 'on' AND id_admin = '$_GET[id]'");
            
        //echo "<script type='text/javascript'>alert('Data berhasil dihapus !');window.location='../../media_admin.php?module=".$module."'</script>";
        header('location:../../media_admin.php?module='.$module.'&act=tutupkomisi');
    }

}
?>
