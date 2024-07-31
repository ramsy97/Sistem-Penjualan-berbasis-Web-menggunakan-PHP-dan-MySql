<?php echo form_open('menu/edit/'.$menu->id_menu, array('id' => 'FormEditMenu')); ?>
<div class="form-horizontal">
	<div class="form-group">
		<label class="col-sm-3 control-label">Kode Menu</label>
		<div class="col-sm-8">
			<?php 
			echo form_input(array(
				'name' => 'kode_menu',
				'class' => 'form-control',
				'value' => $menu->kode_menu
			));
			echo form_hidden('kode_menu_old', $menu->kode_menu);
			?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">Nama Menu</label>
		<div class="col-sm-8">
			<?php 
			echo form_input(array(
				'name' => 'nama_menu',
				'class' => 'form-control',
				'value' => $menu->nama_menu
			));
			?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">Kategori</label>
		<div class="col-sm-8">
			<select name='id_kategori_menu' class='form-control'>
				<option value=''></option>
				<?php
				foreach($kategori->result() as $k)
				{
					$selected = '';
					if($menu->id_kategori_menu == $k->id_kategori_menu){
						$selected = 'selected';
					}
					
					echo "<option value='".$k->id_kategori_menu."' ".$selected.">".$k->kategori."</option>";
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">List</label>
		<div class="col-sm-8">
			<select name='id_list_menu' class='form-control'>
				<option value=''></option>
				<?php
				foreach($list->result() as $l)
				{
					$selected = '';
					if($menu->id_list_menu == $l->id_list_menu){
						$selected = 'selected';
					}

					echo "<option value='".$l->id_list_menu."' ".$selected.">".$l->list."</option>";
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">Stok</label>
		<div class="col-sm-8">
			<?php 
			echo form_input(array(
				'name' => 'total_stok',
				'class' => 'form-control',
				'value' => $menu->total_stok
			));
			?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">Harga</label>
		<div class="col-sm-8">
			<?php 
			echo form_input(array(
				'name' => 'harga',
				'class' => 'form-control',
				'value' => $menu->harga
			));
			?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">Keterangan</label>
		<div class="col-sm-8">
			<textarea name='keterangan' class='form-control' rows='3' style='resize:vertical;'><?php echo $menu->keterangan; ?></textarea>
		</div>
	</div>
</div>
<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-primary' id='SimpanEditMenu'>Update Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$('#SimpanEditMenu').click(function(){
		$.ajax({
			url: $('#FormEditMenu').attr('action'),
			type: "POST",
			cache: false,
			data: $('#FormEditMenu').serialize(),
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
	});
});
</script>