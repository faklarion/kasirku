<?php 
function tgl_indo($tanggal){
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
	
	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun
 
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}
?>

<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="main.css">
	<title>Laporan Penjualan</title>
</head>
<body>
<div class="app-title">
	<div>
		<h1><i class="fa fa-cube"></i> Laporan Penjualan</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		<li class="breadcrumb-item"><a href="javascript:void(0)">Stok Harian</a></li>
	</ul>
</div>

<div class="row">
	<div class="col-md-12 col-xs-12 col-sm-12">
		<div class="tile">
		<?php if($this->session->flashdata('error')){ echo $this->session->flashdata('error');} ?>
			
					<div class="col-md-12 col-md-offset-3">
						<div class="pull-right">
						    <button class="btn btn-primary add_p"><i class="fa fa-fw fa-lg fa-plus"></i> Laporan Harian</button>
                        </div><br><br><br>
						
					</div>
<div class="col-md-13">
		<div class="tab-content">
			<div class="tab-pane active" id="user-info">
				<div class="user-info">

		<div class="table-responsive">
        <table class="table table-hover table-bordered" id="tabelKu" width="100%">
            <thead>
                <tr>
                    <th class="text-center">No.</th>
                    <th class="text-center">Tanggal Penjualan</th>
                    <th class="text-center">Cabang</th>
                    <th class="text-center">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                        $noUrut = 0;
                       
					    $sql = $this->db->query("SELECT * FROM tbl_penjualan
                        JOIN tbl_pegawai ON tbl_pegawai.id_pegawai = tbl_penjualan.id_pegawai
                        GROUP BY tanggal_terjual ORDER BY tanggal_terjual DESC
                        ");

                        foreach($sql->result() as $data){
                        $noUrut++
                ?>
                    <tr>
                        <td class="text-center"><?= $noUrut?>.</td>
                        <td class="text-center"><?= tgl_indonesia($data->tanggal_terjual) ?></td>
                        <td class="text-center"><?= $data->nama_pegawai ?></td>
                        <td class="text-center">
                           
						</td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>
				</div>
			</div>
		</div>

	</div>
</div>



<!--              Modal Add                   -->


<div id="addModal" class="modal fade" style="font-size: 12px;">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
   </div>
   <div class="modal-body" id="form_add">
     
   </div>                      
<div class="row text-right">
                        <div class="col-md-12">
<span>
    <button style="font-size:12px;" type="button" class="btn btn-dark" id="tutop" data-dismiss="modal">Cancel</button>&nbsp;&nbsp;&nbsp;<br>&nbsp;&nbsp;</span>
</div>
   </div>
  </div>
 </div>
</div>

<!--                 Modal Edit_Pegawai                   -->


<div id="editModal" class="modal fade" style="font-size: 12px;">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
   </div>
   <br>
   <div class="modal-body" id="form_edit">  
   </div>
                      
<div class=" row text-right">

                        <div class="col-md-12">
<span>
    <button style="font-size:12px;" type="button" class="btn btn-dark" id="tutop" data-dismiss="modal">Close</button>&nbsp;&nbsp;&nbsp;<br>&nbsp;&nbsp;</span>
</div>
   </div>
  </div>
 </div>
</div>



<div id="img" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body" id="modal-gambar">
				<div style="padding-bottom: 5px;">
					<center>
						<img src="" id="pict" alt="" class="img-responsive img-thumbnail">
					</center>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah anda yakin ingin menghapus produk ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="<?= base_url('main/hapus_produk/') ?>" id="hapusLink" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<!--     end Modal      -->

<script>
   
$(document).ready(function(){
    $('.hapusModal').click(function(){
        let isi = $(this).text();
        let tid = $(this).prop('id');
        let rid = tid.split('__');
        let id_baris = rid[1];
		var hapuslink = document.getElementById('hapusLink');

        if(id_baris){
			hapuslink.href = "<?= base_url('stok/hapus_stok/')?>"+id_baris;
        }
    })
})


//form input
$(document).on('click', '.add_p', function(){
  $.ajax({
   url:"<?= base_url('laporan/add')?>",
   success:function(data){
    $('#form_add').html(data);
    $('#addModal').modal('show');
   }
  });
 });

 $(document).on('click', '.edit_p', function(){
  var idnya = $(this).attr("id");
  $.ajax({
   url:"<?= base_url('laporan/edit')?>",
   method:"POST",
   data:{idnya:idnya},
   success:function(data){
    $('#form_edit').html(data);
    $('#editModal').modal('show');
   }
  });
 });

 $(document).on("click", "#show_foto", function() {
		var id = $(this).data('id');
		var ft = $(this).data('foto');
		$("#modal-gambar #id").val(id);
		$("#modal-gambar #pict").attr("src", "<?= base_url('assets/images/products/'); ?>"+ft);
	});
</script>
