<?php include_once "config.php"; ?>
<script src="jquery-2.1.1.min.js" type="text/javascript"></script>

<label for="nama">Nama Lengkap</label>
<input type="hidden" id="id" name="id">
<input type="text" id="nama_lengkap" name="nama_lengkap" required>
<label for="nama">Username</label>
<input type="text" id="uname" name="uname" required>
<input type="submit" name="submit" id="submit" value="submit">
<br>
<br>
<table border="1">
	<thead>
		<tr>
			<!-- <td>#!</td> -->
			<td>Nama</td>
			<td>Uname</td>
			<td colspan="2">Action</td>
		</tr>
	</thead>
	<tbody id="isinya">
		<?php 
			// $no = 1;
			$q  = mysqli_query($koneksi,"select * from user order by id DESC");
			while ($r = mysqli_fetch_array($q)) {
			?>
			<tr id="isi_<?php echo $r['id'] ?>">
				<!-- <td><?php echo $no++; ?></td> -->
				<td class="nama" id="idnama_<?php echo $r['id'] ?>" data-id="<?php echo $r['id'] ?>"><?php echo $r['nama']; ?></td>
				<td class="uname" id="iduname_<?php echo $r['id'] ?>" data-id="<?php echo $r['id'] ?>"><?php echo $r['uname']; ?></td>
				<td><button type="button" class="hapus" data-id="<?php echo $r['id'] ?>">hapus</button><button type="button" class="edit" data-id="<?php echo $r['id'] ?>">edit</button></td>
			</tr>
			<?php
			}
		?>
	</tbody>
</table>
<script type="text/javascript">
	$(document).on('click','#submit',function(){
		var nama_lengkap = $('#nama_lengkap').val();
		var uname        = $('#uname').val();
		$.ajax({
			method : "POST",
			url : "action.php",
			data : {val_nama_lengkap : nama_lengkap, val_uname : uname, action:"tambah"},
			success : function(data){
				$('#isinya').prepend(data);
			}
		});
	});	
	$(document).on('click','.hapus',function(){
		var id = $(this).attr('data-id');
		$.ajax({
			method : "POST",
			url : "action.php",
			data : {idnya : id, action:"hapus"},
			success : function(data){
				if (data=="ok") {
					$("#isi_"+id).fadeOut();
				}
			}
		});
	});
	$(document).on('click','.edit',function(){
		var id = $(this).attr('data-id');
		$.ajax({
			method : "POST",
			url : "action.php",
			data : {idnya : id, action:"edit"},
			dataType: 'JSON',
			success : function(data){
				var id = data.id;
				var uname = data.uname;
				var nama = data.nama_lengkap;
				$('#uname').val(uname);
				$('#nama_lengkap').val(nama);
				$('#id').val(id);
				$('#submit').val("edit");
				$('#submit').attr("id","edit");
			}
		});
	});
	$(document).on('click','#edit',function(){
		var id           = $('#id').val();
		var nama_lengkap = $('#nama_lengkap').val();
		var uname        = $('#uname').val();
		$.ajax({
			method : "POST",
			url : "action.php",
			data : {id : id, nama_lengkap: nama_lengkap, uname: uname, action:"update_db"},
			dataType: 'JSON',
			success : function(data){
				var id = data.id;
				var uname = data.uname;
				var nama = data.nama_lengkap;
				$('#idnama_'+id).html(nama);
				$('#iduname_'+id).html(uname);
				$('#nama_lengkap').val("");
				$('#uname').val("");
				$('#edit').val("submit");
				$('#edit').attr("id","submit");
			}
		});
	});
</script>