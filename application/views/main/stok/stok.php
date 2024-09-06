<?php
function tgl_indo($tanggal)
{
    $bulan = array(
        1 => 'Januari',
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

    return $pecahkan[2] . ' ' . $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[0];
}
?>

<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="main.css">
    <title>Stok Harian</title>
</head>

<body>
    <div class="app-title">
        <div>
            <h1><i class="fa fa-cube"></i> Stok Harian</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Stok Harian</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12 col-xs-12 col-sm-12">
            <div class="tile">
                <?php if ($this->session->flashdata('error')) {
                    echo $this->session->flashdata('error');
                } ?>

                <div class="col-md-12 col-md-offset-3">
                    <div class="pull-right">
                        <button class="btn btn-primary add_p"><i class="fa fa-fw fa-lg fa-plus"></i> Stok
                            Harian</button>
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
                                                <th class="text-center">Cabang</th>
                                                <th class="text-center">Tanggal</th>
                                                <th class="text-center">Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $noUrut = 0;
                                            foreach ($data_stok as $data) {
                                                $noUrut++
                                                    ?>
                                                <tr>
                                                    <td class="text-center"><?= $noUrut ?>.</td>
                                                    <td class="text-center"><?= $data->nama_pegawai ?>.</td>
                                                    <td class="text-center"><?= tgl_indo($data->tanggal) ?></td>
                                                    <td class="text-center">
                                                        <!-- <a class="btn btn-warning btn-sm edit_p" id="<?= $data->id_stok ?>">&nbsp;<i class="fa fa-pencil" ></i></a> -->
                                                        <a class="btn btn-sm btn-warning" data-toggle="modal"
                                                            data-target="#showModal<?= $data->id_stok ?>">&nbsp;<i class="fa fa-eye"></i></a>
                                                        <!-- <a class="btn btn-sm btn-danger hapusModal"
                                                            id="hapusModal__<?= $data->id_stok ?>" data-toggle="modal"
                                                            data-target="#deleteModal">&nbsp;<i class="fa fa-trash"></i></a> -->
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
                                        <button style="font-size:12px;" type="button" class="btn btn-dark" id="tutop"
                                            data-dismiss="modal">Cancel</button>&nbsp;&nbsp;&nbsp;<br>&nbsp;&nbsp;</span>
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
                                        <button style="font-size:12px;" type="button" class="btn btn-dark" id="tutop"
                                            data-dismiss="modal">Close</button>&nbsp;&nbsp;&nbsp;<br>&nbsp;&nbsp;</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--                 Modal Show Data                   -->

                <?php foreach($data_stok as $row) : ?>
                <!-- Modal -->
                <div id="showModal<?= $row->id_stok ?>" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- konten modal-->
                        <div class="modal-content">
                            <!-- heading modal -->
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h6 class="modal-title">Data Stok <?= $row->nama_pegawai ?> <?= tgl_indonesia($row->tanggal)?></h6>
                            </div>
                            <!-- body modal -->
                            <div class="modal-body">
                                <table class="table table-bordered" id="tabelKu">
                                    <thead>
                                        <tr>
                                            <td>No</td>
                                            <td>Nama Produk</td>
                                            <td>Stok Masuk</td>
                                            <td>Total</td>
                                            <td>Opsi</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $totalStok = 0;
                                            $total = 0;
                                            $no = 1;
                                            $data_barang = $this->Product_model->get_all_stok_by_cabang($row->id_pegawai, $row->tanggal); 
                                            foreach ($data_barang as $baris) :
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $baris->nama_product?></td>
                                            <td><?= $baris->stok ?></td>
                                            <td>Rp <?= buatRupiah($baris->stok * $baris->harga_jual) ?></td>
                                            <td></td>
                                            <?php 
                                                $totalStok += $baris->stok;
                                                $total += $baris->stok * $baris->harga_jual; 
                                            ?>
                                        </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                    <tfoot>
                                        <td colspan="2">Total</td>
                                        <td><?= $totalStok ?></td>
                                        <td colspan="2">Rp <?= buatRupiah($total)?></td>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- footer modal -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>



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
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
                    aria-hidden="true">
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
                                <a href="<?= base_url('main/hapus_produk/') ?>" id="hapusLink"
                                    class="btn btn-danger">Hapus</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!--     end Modal      -->

                <script>

                    $(document).ready(function () {
                        $('.hapusModal').click(function () {
                            let isi = $(this).text();
                            let tid = $(this).prop('id');
                            let rid = tid.split('__');
                            let id_baris = rid[1];
                            var hapuslink = document.getElementById('hapusLink');

                            if (id_baris) {
                                hapuslink.href = "<?= base_url('stok/hapus_stok/') ?>" + id_baris;
                            }
                        })
                    })


                    //form input
                    $(document).on('click', '.add_p', function () {
                        $.ajax({
                            url: "<?= base_url('stok/add') ?>",
                            success: function (data) {
                                $('#form_add').html(data);
                                $('#addModal').modal('show');
                            }
                        });
                    });

                    $(document).on('click', '.edit_p', function () {
                        var idnya = $(this).attr("id");
                        $.ajax({
                            url: "<?= base_url('stok/edit') ?>",
                            method: "POST",
                            data: { idnya: idnya },
                            success: function (data) {
                                $('#form_edit').html(data);
                                $('#editModal').modal('show');
                            }
                        });
                    });

                    $(document).on("click", "#show_foto", function () {
                        var id = $(this).data('id');
                        var ft = $(this).data('foto');
                        $("#modal-gambar #id").val(id);
                        $("#modal-gambar #pict").attr("src", "<?= base_url('assets/images/products/'); ?>" + ft);
                    });
                </script>