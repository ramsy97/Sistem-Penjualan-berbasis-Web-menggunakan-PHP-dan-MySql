<?php
class M_kategori_menu extends CI_Model 
{
	function get_all()
	{
		return $this->db
			->select('id_kategori_menu, kategori')
			->where('dihapus', 'tidak')
			->order_by('kategori', 'asc')
			->get('pj_kategori_menu');
	}

	function fetch_data_kategori($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				id_kategori_menu, 
				kategori  
			FROM 
				`pj_kategori_menu`, (SELECT @row := 0) r WHERE 1=1 
				AND dihapus = 'tidak' 
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				kategori LIKE '%".$this->db->escape_like_str($like_value)."%' 
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'kategori'
		);
		
		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function tambah_kategori($kategori)
	{
		$dt = array(
			'kategori' => $kategori,
			'dihapus' => 'tidak'
		);

		return $this->db->insert('pj_kategori_menu', $dt);
	}

	function hapus_kategori($id_kategori_menu)
	{
		$dt = array(
			'dihapus' => 'ya'
		);

		return $this->db
			->where('id_kategori_menu', $id_kategori_menu)
			->update('pj_kategori_menu', $dt);
	}

	function get_baris($id_kategori_menu)
	{
		return $this->db
			->select('id_kategori_menu, kategori')
			->where('id_kategori_menu', $id_kategori_menu)
			->limit(1)
			->get('pj_kategori_menu');
	}

	function update_kategori($id_kategori_menu, $kategori)
	{
		$dt = array(
			'kategori' => $kategori
		);

		return $this->db
			->where('id_kategori_menu', $id_kategori_menu)
			->update('pj_kategori_menu', $dt);
	}
}