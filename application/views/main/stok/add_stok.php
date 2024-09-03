<div class="row">
    <div class="col-md-12 col-xs-8 col-sm-8">
        <form action="<?=base_url('stok/add_stok')?>"  method="POST" enctype="multipart/form-data">
				<h3 class="login-head text-center"><i class="fa fa-plus"></i> Add Stok Harian</h3><br>
				
                <div class="form-group">
                <select name="id_product" class="form-control" required>
                    <option value="" hidden>Pilih</option>
					<?php 
						$products = $this->db->get('tbl_product')->result_array();
						foreach ($products as $row) {?>
						<option value="<?= $row['id_product'] ?>"><?= $row['nama_product'] ?></option>
					<?php } ?>
                </select>
                </div>
                <!-- <div class="form-group">
                    <input class="form-control" name="stok" min='1' type="number" max="9999" placeholder="Stok" autofocus required>
                </div> -->
                <!-- <div class="form-group">
                     <input class="form-control" name="harga_beli" min='100' type="number" max="99999999" placeholder="Harga Beli (satuan)" autofocus required>
                </div> -->
                <div class="form-group">
                    <input class="form-control" name="stok" min='1' type="number" max="99999999" placeholder="Jumlah Stok" autofocus required>
				</div>
				
				
				<div class="form-group btn-container">
					<button class="btn btn-primary btn-block" type="submit" name="add_stok"><i class="fa fa-check fa-lg fa-fw"></i>Add</button>
				</div>
				
			</form>
    </div>
</div>
