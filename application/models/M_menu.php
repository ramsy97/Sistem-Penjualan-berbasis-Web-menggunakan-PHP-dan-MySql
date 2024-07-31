<?php
class M_menu extends CI_Model 
{
	function fetch_data_menu($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id_menu`, 
				a.`kode_menu`, 
				a.`nama_menu`,
				IF(a.`total_stok` = 0, 'Kosong', a.`total_stok`) AS total_stok,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) AS harga,
				a.`keterangan`,
				b.`kategori`,
				IF(c.`list` IS NULL, '-', c.`list` ) AS list 
			FROM 
				`pj_menu` AS a 
				LEFT JOIN `pj_kategori_menu` AS b ON a.`id_kategori_menu` = b.`id_kategori_menu` 
				LEFT JOIN `pj_list_menu` AS c ON a.`id_list_menu` = c.`id_list_menu` 
				, (SELECT @row := 0) r WHERE 1=1 
				AND a.`dihapus` = 'tidak' 
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				a.`kode_menu` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`nama_menu` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR IF(a.`total_stok` = 0, 'Kosong', a.`total_stok`) LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`keterangan` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR b.`kategori` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR c.`list` LIKE '%".$this->db->escape_like_str($like_value)."%' 
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'a.`kode_menu`',
			2 => 'a.`nama_menu`',
			3 => 'b.`kategori`',
			4 => 'c.`list`',
			5 => 'a.`total_stok`',
			6 => '`harga`',
			7 => 'a.`keterangan`'
		);
		
		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function hapus_menu($id_menu)
	{
		$dt['dihapus'] = 'ya';
		return $this->db
				->where('id_menu', $id_menu)
				->update('pj_menu', $dt);
	}

	function tambah_baru($kode, $nama, $id_kategori_menu, $id_list_menu, $stok, $harga, $keterangan)
	{
		$dt = array(
			'kode_menu' => $kode,
			'nama_menu' => $nama,
			'total_stok' => $stok,
			'harga' => $harga,
			'id_kategori_menu' => $id_kategori_menu,
			'id_list_menu' => (empty($id_list_menu)) ? NULL : $id_list_menu,
			'keterangan' => $keterangan,
			'dihapus' => 'tidak'
		);

		return $this->db->insert('pj_menu', $dt);
	}

	function cek_kode($kode)
	{
		return $this->db
			->select('id_menu')
			->where('kode_menu', $kode)
			->where('dihapus', 'tidak')
			->limit(1)
			->get('pj_menu');
	}

	function get_baris($id_menu)
	{
		return $this->db
			->select('id_menu, kode_menu, nama_menu, total_stok, harga, id_kategori_menu, id_list_menu, keterangan')
			->where('id_menu', $id_menu)
			->limit(1)
			->get('pj_menu');
	}

	function update_menu($id_menu, $kode_menu, $nama, $id_kategori_menu, $id_list_menu, $stok, $harga, $keterangan)
	{
		$dt = array(
			'kode_menu' => $kode_menu,
			'nama_menu' => $nama,
			'total_stok' => $stok,
			'harga' => $harga,
			'id_kategori_menu' => $id_kategori_menu,
			'id_list_menu' => (empty($id_list_menu)) ? NULL : $id_list_menu,
			'keterangan' => $keterangan
		);

		return $this->db
			->where('id_menu', $id_menu)
			->update('pj_menu', $dt);
	}

	function cari_kode($keyword, $registered)
	{
		$not_in = '';

		$koma = explode(',', $registered);
		if(count($koma) > 1)
		{
			$not_in .= " AND `kode_menu` NOT IN (";
			foreach($koma as $k)
			{
				$not_in .= " '".$k."', ";
			}
			$not_in = rtrim(trim($not_in), ',');
			$not_in = $not_in.")";
		}
		if(count($koma) == 1)
		{
			$not_in .= " AND `kode_menu` != '".$registered."' ";
		}

		$sql = "
			SELECT 
				`kode_menu`, `nama_menu`, `harga` 
			FROM 
				`pj_menu` 
			WHERE 
				`dihapus` = 'tidak' 
				AND `total_stok` > 0 
				AND ( 
					`kode_menu` LIKE '%".$this->db->escape_like_str($keyword)."%' 
					OR `nama_menu` LIKE '%".$this->db->escape_like_str($keyword)."%' 
				) 
				".$not_in." 
		";

		return $this->db->query($sql);
	}

	function get_stok($kode)
	{
		return $this->db
			->select('nama_menu, total_stok')
			->where('kode_menu', $kode)
			->limit(1)
			->get('pj_menu');
	}

	function get_id($kode_menu)
	{
		return $this->db
			->select('id_menu, nama_menu')
			->where('kode_menu', $kode_menu)
			->limit(1)
			->get('pj_menu');
	}

	function update_stok($id_menu, $jumlah_beli)
	{
		$sql = "
			UPDATE `pj_menu` SET `total_stok` = `total_stok` - ".$jumlah_beli." WHERE `id_menu` = '".$id_menu."'
		";

		return $this->db->query($sql);
	}
}