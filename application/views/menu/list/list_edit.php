<?php echo form_open('menu/edit-list/'.$list->id_list_menu, array('id' => 'FormEditList')); ?>
<div class='form-group'>
	<?php
	echo form_input(array(
		'name' => 'list', 
		'class' => 'form-control',
		'value' => $list->list
	));
	?>
</div>
<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
function EditList()
{
	$.ajax({
		url: $('#FormEditList').attr('action'),
		type: "POST",
		cache: false,
		data: $('#FormEditList').serialize(),
		dataType:'json',
		success: function(json){
			if(json.status == 1){ 
				$('#ResponseInput').html(json.pesan);
				setTimeout(function(){ 
			   		$('#ResponseInput').html('');
			    }, 3000);
				$('#my-grid').DataTable().ajax.reload( null, false );
			}
			else {
				$('#ResponseInput').html(json.pesan);
			}
		}
	});
}

$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-primary' id='SimpanEditList'>Update Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$("#FormEditList").find('input[type=text],textarea,select').filter(':visible:first').focus();

	$('#SimpanEditList').click(function(e){
		e.preventDefault();
		EditList();
	});

	$('#FormEditList').submit(function(e){
		e.preventDefault();
		EditList();
	});
});
</script>