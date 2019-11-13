@extends('crudbooster::admin_template')
@section('content')

<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "sistem";

$con = mysqli_connect($host, $user, $password, $database);
?>
<!DOCTYPE html>
<html>

<head>
	<title></title>
</head>
<body>
<div class="panel panel-default">
	<div class="panel-heading">
		<strong><i class='fa fa-print'></i> E-Raport</strong>    
	</div>
	<div class="panel-body">
		<form action="" method="post">
			<div class="input-group">
	    		<input type="text" style="display:inline-block;width: 260px;" name='cari' value="" class="form-control input-sm pull-right" placeholder="Search"/>
	    		<div class="input-group-btn">
	   				<button type='submit' class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
	    		</div>
	    	</div>
	    </form>
 			<br>
		 	<table id="table_dashboard" class="table table-hover table-striped table-bordered">
				<tr>
					<th>No</th>
					<th>Kode</th>
					<th>Nama Pelajaran</th>
					<th>KKM</th>  
				</tr>
					<?php
					$batas =  2;
					$hal = @$_GET['hal'];
					if(empty($hal)) {
						$posisi = 0;
						$hal = 1;
					} else {
						$posisi = ($hal - 1) * $batas;
					}
					$no=1;
					if($_SERVER['REQUEST_METHOD'] =="POST"){
						$cari = trim(mysqli_real_escape_string($con, $_POST['cari']));
						if($cari != '') {
							$sql = "SELECT * FROM pelajaran WHERE nm_mapel LIKE '%$cari%'";
							$query = $sql;
							$queryJml = $sql;
						} else {
							$query = "SELECT * FROM pelajaran LIMIT $posisi, $batas";
							$queryJml = "SELECT * FROM pelajaran";
							$no = $posisi + 1;
						}

					} else {
						$query = "SELECT * FROM pelajaran LIMIT $posisi, $batas";
						$queryJml = "SELECT * FROM pelajaran";
						$no = $posisi + 1;
						
					}
					
					$pelajaran = mysqli_query($con, $query) or die (mysqli_error($con));
					if(mysqli_num_rows($pelajaran) > 0) {
						while($data = mysqli_fetch_array($pelajaran)) { ?>
							<tr>
								<td><?=$no++?></td>
								<td><?=$data['id']?></td>
								<td><?=$data['nm_mapel']?></td>
								<td><?=$data['kkm']?></td>
							</tr>
						<?php
						}
					} else {
						echo "<tr><td colspan=\"4\" align=\"center\">Data Tidak Ditemukan</td></tr>";
					}
					?>
			</table>
		    <!-- <div class="form-group">
		    	<label> Nama Siswa</label>
		    	<select style='width:25%' class="form-control" name="kd_siswa" required >
		    		<option value="">** Pilih Nama Siswa</option>
		    		@foreach($nama as $n)
		    			<option value="">{{$n->kd_siswa}}</option>
		    		@endforeach
		    	</select>
		    </div>

		    <div class="form-group">
		    	<label> Kelas</label>
		    	<input type='text' style='width:10%' name="kd_siswa" class="form-control" readonly="true
		    	" required >
		    </div>
 -->
	</div>
	<?php
		if($_POST['cari'] !=''){
			echo "<div style=\"float:left;\">";
			$jml = mysqli_num_rows(mysqli_query($con, $queryJml));
			echo "Data Hasil Pencarian : <b>$jml</b>";
			echo "</div>";
		} else { ?>
			<div style="float:left;">
				<?php
				$jml = mysqli_num_rows(mysqli_query($con, $queryJml));
				echo "Jumlah Data : <b>$jml</b>";
				?>
			</div>
			<div style="float:right;">
				<ul class="pagination pagination-sm" style="margin:0">
					<?php
					$jml_hal = ceil($jml / $batas);
					for ($i=1; $i <= $jml_hal; $i++) { 
						if($i != $hal) {
							echo "<li><a herf=\"?hal=$i\>$i</a></li>";
						} else {
							echo "<li class=\"active\"><a>$i</a></li>";
						}
					}
					?>
				</ul>
			</div>
			<?php
			}
			?>
</div>					
		
</body>
</html>

@endsection