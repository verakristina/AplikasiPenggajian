<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
    </div>
    <div class="card mb-3">
    	<div class="card-header bg-primary text-white">
    		Filter Data Gaji Pegawai
    	</div>
    	<div class="card-body">
    		<form class="form-inline">
    			<div class="form-group mb-2">
    				<label for="staticEmail2"> Bulan:</label>
    				<select class="form-control ml-3" name="bulan">
    					<option value="" readonly>-- Pilih Bulan --</option>
    					<option value="01">Januari</option>
    					<option value="02">Februari</option>
    					<option value="03">Maret</option>
    					<option value="04">April</option>
    					<option value="05">Mei</option>
    					<option value="06">Juni</option>
    					<option value="07">Juli</option>
    					<option value="08">Agustus</option>
    					<option value="09">September</option>
    					<option value="10">Oktober</option>
    					<option value="11">November</option>
    					<option value="12">Desember</option>
    				</select>
    			</div>
    			<div class="form-group mb-2 ml-5">
    				<label for="staticEmail2"> Tahun:</label>
    				<select class="form-control ml-3" name="tahun">
    					<option value="" readonly>-- Pilih Tahun --</option>
    					<?php $tahun = date('Y');
    					for ($i=2020; $i < $tahun+5; $i++) { ?>
    					<option value="<?php echo $i ?>"><?php echo $i ?></option>
    				<?php } ?>
    				</select>
    			</div>
    			<?php 
    				if ((isset($_GET['bulan']) && $_GET['bulan']!='') && (
    					 isset($_GET['tahun']) && $_GET['tahun']!='')) {
			    		$bulan = $_GET['bulan'];
			    		$tahun = $_GET['tahun'];
			    		$bulantahun = $bulan.$tahun;
			    	}else{
			    		$bulan = date('m');
			    		$tahun = date('Y');
			    		$bulantahun = $bulan.$tahun;
			    	}
    			 ?>
    			<button type="submit" class="btn btn-primary mb-2 ml-auto"><i class="fas fa-eye"></i> Tampilkan Data</button>
    			<?php if (count($gaji) > 0) { ?>
    				<a href="<?php echo base_url('admin/dataPenggajian/cetakGaji?bulan='.$bulan),'&tahun='.$tahun ?>" class="btn btn-success mb-2 ml-3 _blank"><i class="fas fa-print"></i> Cetak Daftar Gaji</a>
    			<?php }else{ ?>
    				<button type="button" class="btn btn-success mb-2 ml-3" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-print"></i> Cetak Daftar gaji</button>
    			<?php } ?>
    		</form>
    	</div>
    </div>
    <?php 

    	if ((isset($_GET['bulan']) && $_GET['bulan']!="") && (isset($_GET['tahun']) && $_GET['tahun']!="")) {
    		$bulan = $_GET['bulan'];
    		$tahun = $_GET['tahun'];
    		$bulantahun = $bulan.$tahun;
    	}else{
    		$bulan = date('m');
    		$tahun = date('Y');
    		$bulantahun = $bulan.$tahun;
    	}

    ?>

	<div class="alert alert-info">
		Menampilkan Data Gaji Pegawai Bulan : <span class="font-weight-bold"><?php echo $bulan; ?></span> Tahun : <span class="font-weight-bold"><?php echo $tahun; ?></span>
	</div>

	<div class="table-responsive">
		<?php 

		$jml_data = count($gaji);
		if($jml_data > 0){ ?>
		<table class="table table-bordered table-striped">
			<tr>
				<th class="text-center">No</th>
				<th class="text-center">Nik</th>
				<th class="text-center">Nama Pegawai</th>
				<th class="text-center">Jenis Kelamin</th>
				<th class="text-center">Jabatan</th>
				<th class="text-center">Gaji Pokok</th>
				<th class="text-center">Tj.Transport</th>
				<th class="text-center">Uang Makan</th>
				<th class="text-center">Potongan</th>
				<th class="text-center">Total Gaji</th>
			</tr>
			<?php foreach ($potongan as $p){
				$alpha = $p->jml_potongan;
			} ?>
			<?php $no=1; foreach ($gaji as $g): ?>
			<?php $potongan = $g->alpha * $alpha ?>
			<tr>
				<td><?php echo $no++ ?></td>
				<td><?php echo $g->nik ?></td>
				<td><?php echo $g->nama_pegawai ?></td>
				<td><?php echo $g->jenis_kelamin ?></td>
				<td><?php echo $g->nama_jabatan ?></td>
				<td>Rp. <?php echo number_format($g->gaji_pokok, 0,',','.') ?></td>
				<td>Rp. <?php echo number_format($g->tj_transport, 0,',','.') ?></td>
				<td>Rp. <?php echo number_format($g->uang_makan, 0,',','.')?></td>
				<td>Rp. <?php echo number_format($potongan, 0,',','.')?></td>
				<td>Rp. <?php echo number_format($g->gaji_pokok + $g->tj_transport + $g->uang_makan - $potongan, 0,',','.')?></td>
			</tr>
			<?php endforeach; ?>
		</table>
		<?php }else	{ ?>
		<span class="badge badge-danger"><i class="fas fa-info-circle"></i> Data Masih Kosong Silahkan Input Data Kehadiran Pada Bulan Dan Tahun Yang Ada</span>
	<?php } ?>
	</div>
</div>   
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Informasi</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				Data Gaji Masih Kosong silahkan input absensi terlebih dahulu pada bulan dan tahun yang anda pilih
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save</button>
			</div>
		</div>
	</div>
</div>  