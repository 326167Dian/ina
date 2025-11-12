<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href=../css/style.css rel=stylesheet type=text/css>";
  echo "<div class='error msg'>Untuk mengakses Modul anda harus login.</div>";
}
else{

$aksi="modul/mod_lapstok/aksi_barang.php";
$aksi_barang = "masuk/modul/mod_lapstok/aksi_barang.php";
switch($_GET[act]){
  // Tampil barang
  default:

  
      $tampil_barang = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM barang ORDER BY barang.id_barang ");
      
	  ?>
			
			
			<div class="box box-primary box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">KOREKSI STOK</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<a  class ='btn  btn-success btn-flat' href='modul/mod_lapstok/sinkronisasi_stok.php'>SINKRONISASI</a>
                    </div><!-- /.box-tools -->
				</div>
				<div class="box-body">
					
					<table id="example1" class="table table-bordered table-striped" >
						<thead>
							<tr>
								<th>No</th>
								<th>Kode</th>
								<th>Nama Barang</th>
								<th style="text-align: right; ">Masuk</th>
								<th style="text-align: right; ">Keluar</th>
								<th style="text-align: center; ">Selisih</th>
								<th style="text-align: center; ">Stok</br>Barang</th>
								<th width="70">Koreksi Stok</th>
							</tr>
						</thead>
						<tbody>
						<?php 
								$no=1;
								while ($r=mysqli_fetch_array($tampil_barang)){

                                $beli = "SELECT trbmasuk.tgl_trbmasuk,                                           
                                       SUM(trbmasuk_detail.qty_dtrbmasuk) AS totalbeli                                            
                                       FROM trbmasuk_detail join trbmasuk 
                                       on (trbmasuk_detail.kd_trbmasuk=trbmasuk.kd_trbmasuk)
                                       WHERE kd_barang =$r[kd_barang]" ;
                                $buy = mysqli_query($GLOBALS["___mysqli_ston"],$beli);
                                $buy2 = mysqli_fetch_array($buy);

                                $jual = "SELECT trkasir.tgl_trkasir,                                
                                        sum(trkasir_detail.qty_dtrkasir) AS totaljual
                                        FROM trkasir_detail join trkasir 
                                        on (trkasir_detail.kd_trkasir=trkasir.kd_trkasir)
                                        WHERE kd_barang =$r[kd_barang]" ;
                                $jokul = mysqli_query($GLOBALS["___mysqli_ston"],$jual);
                                $sell = mysqli_fetch_array($jokul);
                                $selisih = $buy2[totalbeli]-$sell[totaljual];


									echo "<tr class='warnabaris' >
                                             <td>$no</td>                                    										     
											 <td>$r[kd_barang]</td>
											 <td>$r[nm_barang]</td>";
									if($buy2[totalbeli]<"0")
                                    {echo"<td align=center> 0 </td>";}
									else{echo "<td align=center>$buy2[totalbeli]</td>";}

									if($sell[totaljual]<"0")
                                    {echo"<td align=center> 0 </td>";}
									else{echo "<td align=center>$sell[totaljual]</td>";}
									echo" <td align=center>$selisih</td>";

									if($selisih==$r[stok_barang])
                                        {echo "<td align=right>$r[stok_barang]</td>";}
									else{echo"<td style='background-color:#ffbf00; text-align: right;'>$r[stok_barang]</td>";}
									echo"	 	
											 <td style='text-align: center;'><a href='?module=koreksistok&act=edit&id=$r[id_barang]' title='EDIT' class='btn btn-primary btn-xs'>KOREKSI</a> 	
											</td>
										</tr>";
								$no++;
								}



						echo "</tbody></table>";
					    ?>
				</div>
			</div>	
             

<?php

	
    break;

  case "edit":
    $edit=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM barang 
	WHERE barang.id_barang='$_GET[id]'");
    $r=mysqli_fetch_array($edit);

		echo "
		  <div class='box box-primary box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'>INPUT STOK BARU</h3>
					<div class='box-tools pull-right'>
						<button class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
                    </div><!-- /.box-tools -->
				</div>
				
				<div class='box-body'>
						<form method=POST method=POST action=$aksi?module=koreksistok&act=input_koreksi  enctype='multipart/form-data' class='form-horizontal'>
							  <input type=hidden name=id value=''>											  
							  
							 
                             
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Kode Barang</label>        		
									 <div class='col-sm-4'>
										<input type=text name='kd_barang' class='form-control' required='required' value='$r[kd_barang]' autocomplete='off'>
									 </div>
							  </div>
							  						  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Tanggal</label>        		
									 <div class='col-sm-4'>  
										<input type=date name='tgl' class='form-control' required='required' value='' autocomplete='off'>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Nama Barang</label>        		
									 <div class='col-sm-4'>
										<input type=text name='nm_kbarang' class='form-control' required='required' value='$r[nm_barang]' autocomplete='off'>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Stok Barang</label>        		
									 <div class='col-sm-3'>
										<input type=number name='stok_barangawal' class='form-control' required='required' value='$r[stok_barang]' autocomplete='off'>
									 </div>
							  </div>";

                      $beli = "SELECT trbmasuk.tgl_trbmasuk,                                           
                                                       SUM(trbmasuk_detail.qty_dtrbmasuk) AS totalbeli                                            
                                                       FROM trbmasuk_detail join trbmasuk 
                                                       on (trbmasuk_detail.kd_trbmasuk=trbmasuk.kd_trbmasuk)
                                                       WHERE kd_barang =$r[kd_barang]" ;
                      $buy = mysqli_query($GLOBALS["___mysqli_ston"],$beli);
                      $buy2 = mysqli_fetch_array($buy);

                      $jual = "SELECT trkasir.tgl_trkasir,                                
                                                        sum(trkasir_detail.qty_dtrkasir) AS totaljual
                                                        FROM trkasir_detail join trkasir 
                                                        on (trkasir_detail.kd_trkasir=trkasir.kd_trkasir)
                                                        WHERE kd_barang =$r[kd_barang]" ;
                      $jokul = mysqli_query($GLOBALS["___mysqli_ston"],$jual);
                      $sell = mysqli_fetch_array($jokul);
                      $selisih = $buy2[totalbeli]-$sell[totaljual];
				echo"			  <div class='form-group'>
									<label class='col-sm-2 control-label'>Selisih Transaksi Masuk & Keluar</label>        		
									 <div class='col-sm-3'>
									 
										<input type=number name='selisih_tx' class='form-control' required='required' value='$selisih' autocomplete='off'>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Koreksi Stok</label>        		
									 <div class='col-sm-3'>
										<input type=number name='stok_baru' class='form-control' required='required' value='' autocomplete='off'>
									 </div>
							  </div>
							  
							 
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Keterangan Koreksi</label>        		
									 <div class='col-sm-4'>
										<textarea name='ket' class='ckeditor' id='content' rows='3'> </textarea>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'></label>       
										<div class='col-sm-4'>
											<input class='btn btn-primary' type=submit value=SIMPAN>
											<input class='btn btn-danger' type=button value=BATAL onclick=self.history.back()>
										</div>
								</div>
								
							  </form>
							  
				</div> 
				
			</div>";	
	

 
    
    break;


}
}
?>


<script type="text/javascript">
 $(function(){
  $(".datepicker").datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true,
  });
 });
 <script type="text/javascript" src="..vendors/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    var editor = CKEDITOR.replace("content", {
        filebrowserBrowseUrl    : '',
        filebrowserWindowWidth  : 1000,
        filebrowserWindowHeight : 500
    });