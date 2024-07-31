<?php
class M_list_menu extends CI_Model 
{
	function get_all()
	{
		return $this->db
			->select('id_list_menu, list')
			->where('dihapus', 'tidak')
			->order_by('list', 'asc')
			->get('pj_list_menu');
	}

	function fetch_data_list($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				id_list_menu, 
				list 
			FROM 
				`pj_list_menu`, (SELECT @row := 0) r WHERE 1=1 
				AND dihapus = 'tidak' 
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				list LIKE '%".$this->db->escape_like_str($like_value)."%' 
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'list'
		);
		
		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function tambah_list($list)
	{
		$dt = array(
			'list' => $list,
			'dihapus' => 'tidak'
		);

		return $this->db->insert('pj_list_menu', $dt);
	}

	function hapus_list($id_list_menu)
	{
		$dt = array(
			'dihapus' => 'ya'
		);

		return $this->db
			->where('id_list_menu', $id_list_menu)
			->update('pj_list_menu', $dt);
	}

	function get_baris($id_list_menu)
	{
		return $this->db
			->select('id_list_menu, list')
			->where('id_list_menu', $id_list_menu)
			->limit(1)
			->get('pj_list_menu');
	}

	function update_list($id_list_menu, $list)
	{
		$dt = array(
			'list' => $list
		);

		return $this->db
			->where('id_list_menu', $id_list_menu)
			->update('pj_list_menu', $dt);
	}
}