<?php echo form_open('menu/tambah-list', array('id' => 'FormTambahList')); ?>
<div class='form-group'>
	<input type='text' name='list' class='form-control'>
</div>
<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
function TambahList()
{
	$.ajax({
		url: $('#FormTambahList').attr('action'),
		type: "POST",
		cache: false,
		data: $('#FormTambahList').serialize(),
		dataType:'json',
		success: function(json){
			if(json.status == 1){ 
				$('#ResponseInput').html(json.pesan);
				setTimeout(function(){ 
			   		$('#ResponseInput').html('');
			    }, 3000);
				$('#my-grid').DataTable().ajax.reload( null, false );

				$('#FormTambahList').each(function(){
					this.reset();
				});
			}
			else {
				$('#ResponseInput').html(json.pesan);
			}
		}
	});
}

$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-primary' id='SimpanTambahList'>Simpan Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$("#FormTambahList").find('input[type=text],textarea,select').filter(':visible:first').focus();

	$('#SimpanTambahList').click(function(e){
		e.preventDefault();
		TambahList();
	});

	$('#FormTambahList').submit(function(e){
		e.preventDefault();
		TambahList();
	});
});
</script>