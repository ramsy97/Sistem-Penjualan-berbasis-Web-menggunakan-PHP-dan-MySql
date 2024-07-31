<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); ?>

<?php
$level = $this->session->userdata('ap_level');
?>

<div class="container">
	<div class="panel panel-default">
		<div class="panel-body">
			<h5><i class='fa fa-cube fa-fw'></i> Menu <i class='fa fa-angle-right fa-fw'></i> Semua Menu</h5>
			<hr />

			<div class='table-responsive'>
				<link rel="stylesheet" href="<?php echo config_item('plugin'); ?>datatables/css/dataTables.bootstrap.css"/>
				<table id="my-grid" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>No</th>
							<th>Kode</th>
							<th>Nama Menu</th>
							<th>Kategori</th>
							<th>List</th>
							<th>Stok</th>
							<th>Harga</th>
							<th>Keterangan</th>
							<?php if($level == 'admin' OR $level == 'inventory') { ?>
							<th class='no-sort'>Edit</th>
							<th class='no-sort'>Hapus</th>
							<?php } ?>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
<p class='footer'><?php echo config_item('web_footer'); ?></p>

<?php
$tambahan = '';
if($level == 'admin' OR $level == 'inventory')
{
	$tambahan .= nbs(2)."<a href='".site_url('menu/tambah')."' class='btn btn-default' id='TambahMenu'><i class='fa fa-plus fa-fw'></i> Tambah Menu</a>";
	$tambahan .= nbs(2)."<span id='Notifikasi' style='display: none;'></span>";
}
?>

<script type="text/javascript" language="javascript" >
	$(document).ready(function() {
		var dataTable = $('#my-grid').DataTable( {
			"serverSide": true,
			"stateSave" : false,
			"bAutoWidth": true,
			"oLanguage": {
				"sSearch": "<i class='fa fa-search fa-fw'></i> Pencarian : ",
				"sLengthMenu": "_MENU_ &nbsp;&nbsp;Data Per Halaman <?php echo $tambahan; ?>",
				"sInfo": "Menampilkan _START_ s/d _END_ dari <b>_TOTAL_ data</b>",
				"sInfoFiltered": "(difilter dari _MAX_ total data)", 
				"sZeroRecords": "Pencarian tidak ditemukan", 
				"sEmptyTable": "Data kosong", 
				"sLoadingRecords": "Harap Tunggu...", 
				"oPaginate": {
					"sPrevious": "Prev",
					"sNext": "Next"
				}
			},
			"aaSorting": [[ 0, "desc" ]],
			"columnDefs": [ 
				{
					"targets": 'no-sort',
					"orderable": false,
				}
	        ],
			"sPaginationType": "simple_numbers", 
			"iDisplayLength": 10,
			"aLengthMenu": [[10, 20, 50, 100, 150], [10, 20, 50, 100, 150]],
			"ajax":{
				url :"<?php echo site_url('menu/menu-json'); ?>",
				type: "post",
				error: function(){ 
					$(".my-grid-error").html("");
					$("#my-grid").append('<tbody class="my-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
					$("#my-grid_processing").css("display","none");
				}
			}
		} );
	});
	
	$(document).on('click', '#HapusMenu', function(e){
		e.preventDefault();
		var Link = $(this).attr('href');

		$('.modal-dialog').removeClass('modal-lg');
		$('.modal-dialog').addClass('modal-sm');
		$('#ModalHeader').html('Konfirmasi');
		$('#ModalContent').html('Apakah anda yakin ingin menghapus <br /><b>'+$(this).parent().parent().find('td:nth-child(3)').html()+'</b> ?');
		$('#ModalFooter').html("<button type='button' class='btn btn-primary' id='YesDelete' data-url='"+Link+"'>Ya, saya yakin</button><button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>");
		$('#ModalGue').modal('show');
	});

	$(document).on('click', '#YesDelete', function(e){
		e.preventDefault();
		$('#ModalGue').modal('hide');

		$.ajax({
			url: $(this).data('url'),
			type: "POST",
			cache: false,
			dataType:'json',
			success: function(data){
				$('#Notifikasi').html(data.pesan);
				$("#Notifikasi").fadeIn('fast').show().delay(3000).fadeOut('fast');
				$('#my-grid').DataTable().ajax.reload( null, false );
			}
		});
	});

	$(document).on('click', '#TambahMenu, #EditMenu', function(e){
		e.preventDefault();
		if($(this).attr('id') == 'TambahMenu')
		{
			$('.modal-dialog').removeClass('modal-sm');
			$('.modal-dialog').addClass('modal-lg');
			$('#ModalHeader').html('Tambah Menu');
		}
		if($(this).attr('id') == 'EditMenu')
		{
			$('.modal-dialog').removeClass('modal-sm');
			$('.modal-dialog').removeClass('modal-lg');
			$('#ModalHeader').html('Edit Menu');
		}
		$('#ModalContent').load($(this).attr('href'));
		$('#ModalGue').modal('show');
	});

	$(document).on('keyup', '.kode_menu', function(){
		$(this).parent().find('span').html("");

		var Kode = $(this).val();
		var Indexnya = $(this).parent().parent().index();
		var Pass = 0;
		$('#TabelTambahMenu tbody tr').each(function(){
			if(Indexnya !== $(this).index())
			{
				var KodeLoop = $(this).find('td:nth-child(2) input').val();
				if(KodeLoop !== '')
				{
					if(KodeLoop == Kode){
						Pass++;
					}
				}
			}
		});

		if(Pass > 0)
		{
			$(this).parent().find('span').html("<font color='red'>Kode sudah ada</font>");
			$('#SimpanTambahMenu').addClass('disabled');
		}
		else
		{
			$(this).parent().find('span').html('');
			$('#SimpanTambahMenu').removeClass('disabled');

			$.ajax({
				url: "<?php echo site_url('menu/ajax-cek-kode'); ?>",
				type: "POST",
				cache: false,
				data: "kodenya="+Kode,
				dataType:'json',
				success: function(json){
					if(json.status == 0){ 
						$('#TabelTambahMenu tbody tr:eq('+Indexnya+') td:nth-child(2)').find('span').html(json.pesan);
						$('#SimpanTambahMenu').addClass('disabled');
					}
					if(json.status == 1){ 
						$('#SimpanTambahMenu').removeClass('disabled');
					}
				}
			});
		}
	});
</script>
<script type="text/javascript" language="javascript" src="<?php echo config_item('plugin'); ?>datatables/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo config_item('plugin'); ?>datatables/js/dataTables.bootstrap.js"></script>

<?php $this->load->view('include/footer'); ?>