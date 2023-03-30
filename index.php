<!DOCTYPE html>
<html>
<head>
	<title>Analisis Toko</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
	<h1>Analisis Toko</h1>
	<form method="post" enctype="multipart/form-data">
		<input type="file" name="file" required>
		<button type="submit">Upload</button>
	</form>
	<hr>
    <?php
		if (isset($_FILES['file'])) {

            include 'functions.php';
			// Baca isi file
			$data_pengunjung = file_get_contents($_FILES['file']['tmp_name']);

            //proses
            $jam_ramai = cari_jam_ramai($data_pengunjung);
            $penjualan_tertinggi = cari_penjualan_tertinggi($data_pengunjung);
            $penjualan_harian = urutkan_hari_penjualan($data_pengunjung);

        }
        ?>
    <h2>Jam Ramai</h2>
	<table class="table table-bordered">
    <thead class="table-secondary">
		<tr>
			<th>Hari</th>
			<th>Jam</th>
			<th>Pengunjung</th>
		</tr>
    </thead>
    <tbody>
		<?php foreach ($jam_ramai as $hari => $jam_pengunjung) { ?>
			<tr>
				<td><?php echo $hari ?></td>
				<td><?php echo $jam_pengunjung['jam'] ?></td>
				<td><?php echo $jam_pengunjung['pengunjung'] ?></td>
			

			</tr>
            </tbody>
		<?php } ?>
	</table>

    <h2>Penjualan tertinggi dan terendah</h2>
	
    <table class="table table-bordered">
    <thead class="table-secondary">
		<tr>
			<th>Hari</th>
			<th>Jam</th>

			<th>Penjualan tertinggi</th>
            <th>Penjualan terendah</th>

		</tr>
        </thead>
    <tbody>
		<?php foreach ($penjualan_tertinggi as $hari => $penjualan) { ?>
			<tr>
				<td><?php echo $hari ?></td>
				<td><?php echo $penjualan['jam'] ?></td>
				<td>Rp.<?php echo number_format($penjualan['penjualan_tertinggi']) ?></td>
				<td>Rp.<?php echo number_format($penjualan['penjualan_terendah']) ?></td>


			</tr>
            </tbody>
		<?php } ?>
	</table>

    <h2>urutan penjualan tertinggi hingga terendah</h2>

<table class="table table-bordered">
    <thead class="table-secondary">
	<tr>
		<th>Hari</th>
		
		<th>Penjualan perhari</th>
	</tr>
    </thead>
    <tbody>
	<?php foreach ($penjualan_harian as $hari => $penjualan) { ?>

		<tr>
			<td><?php echo $hari ?></td>
			<td>Rp.<?php echo number_format($penjualan, 0, ',', '.') ?></td>
			
		</tr>
        </tbody>
	<?php } ?>
</table>
    </div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>
    </body>
    </html>