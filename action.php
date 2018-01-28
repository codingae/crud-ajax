<?php
include_once("config.php");

$val_nama_lengkap = $_POST['val_nama_lengkap'];
$val_uname        = $_POST['val_uname'];

if ($_POST["action"]=="tambah") {
	$query       = mysqli_query($koneksi,"insert into user (nama,uname) VALUES ('$val_nama_lengkap','$val_uname')") or die(mysqli_error($koneksi));
	$id_terakhir = mysqli_insert_id($koneksi);

	if ($query == TRUE) {
		echo "<tr id='isi_".$id_terakhir."'>";
			echo "<td class='nama' id='idnama_".$id_terakhir."' data-id='".$id_terakhir."'>". $val_nama_lengkap ."</td>";
			echo "<td class='uname' id='iduname_".$id_terakhir."' data-id='".$id_terakhir."'>". $val_uname ."</td>";
			echo "<td><button type='button' class='hapus' data-id='".$id_terakhir."'>hapus</button><button type='button' class='edit' data-id='".$id_terakhir."'>edit</button></td>";
		echo "</tr>";
	}else{
		echo "gagal";
	}
}

if ($_POST['action']=="hapus") {
	$id    = $_POST['idnya'];
	$query = mysqli_query($koneksi,"delete from user where id='$id'");
	if ($query==TRUE) {
		echo "ok";
	}else{
		echo "tidak ok";
	}
}

if ($_POST['action']=="edit") {
	$id         = $_POST['idnya'];
	$query      = mysqli_query($koneksi,"select * from user where id='$id'");
	$row        = mysqli_fetch_array($query);
	$return_arr = array('nama_lengkap'=>$row['nama'],'uname'=>$row['uname'],'id'=>$row['id']);
	echo json_encode($return_arr);
}

if ($_POST['action']=="update_db") {
	$id           = $_POST['id'];
	$nama_lengkap = $_POST['nama_lengkap'];
	$uname        = $_POST['uname'];
	$query = mysqli_query($koneksi,"update user set nama='$nama_lengkap'
													,uname='$uname'
													where id='$id'");
	$return_arr = array('nama_lengkap'=>$nama_lengkap,'uname'=>$uname,'id'=>$id);
	echo json_encode($return_arr);
}