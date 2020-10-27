<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



if ( ! function_exists('cbo_laporan'))
{
	function cbo_laporan($kel='Diagram')
	{
		$CI =&get_instance();
		$data = $CI->db->query("select a.* from ewarn_laporan a where a.aktif='Y' and kategori='{$kel}' order by a.kel, a.kode");
		$d=$data->result();
		$combo[0]=" - select - ";
		foreach($d as $key=>$dt)
		{
			$combo[$dt->kode]=$dt->nama_lap;
		}
		return $combo;
	}
}

if ( ! function_exists('kolom_huruf'))
{
	function kolom_huruf($col){
		$j = 0;
		for ($i = 65;$i<= 90;++$i){
			$arrHuruf[++$j] = chr($i);
		}
		
		for ($i = 65;$i<= 90;++$i){
			$arrHuruf[++$j] = "A".chr($i);
		}
		
		for ($i = 65;$i<= 90;++$i){
			$arrHuruf[++$j] = "B".chr($i);
		}
		
		for ($i = 65;$i<= 90;++$i){
			$arrHuruf[++$j] = "C".chr($i);
		}
	
		return  $arrHuruf[$col];
	}
}

if ( ! function_exists('cari_id_prop'))
{
	function cari_id_prop($id)
	{
		$CI =&get_instance();
		//echo $id;
		$result=0;
		$data = $CI->db->query("select a.id_prop from ewarn_kota a where a.id='$id' ");
		$d=$data->result();
		//var_dump($d);
		foreach($d as $key=>$dt)
		{
			$result=$dt->id_prop;
		}
		return $result;
	}
}

if ( ! function_exists('cari_penyakit'))
{
	function cari_penyakit($id)
	{
		$CI =&get_instance();
		$data = $CI->db->query("select a.nama_penyakit from ewarn_penyakit a where a.id='$id' ");
		$d=$data->result();
		//var_dump($d);
		$result='';
		foreach($d as $key=>$dt)
		{
			$result=$dt->nama_penyakit;
		}
		return $result;
	}
}

if ( ! function_exists('cari_prop'))
{
	function cari_prop($id)
	{
		$CI =&get_instance();
		$data = $CI->db->query("select a.propinsi from ewarn_propinsi a where a.id='$id' ");
		$d=$data->result();
		//var_dump($d);
		$result='none';
		foreach($d as $key=>$dt)
		{
			$result=$dt->propinsi;
		}
		return $result;
	}
}

if ( ! function_exists('cari_prop_kode'))
{
	function cari_prop_kode($kode="")
	{
		$CI =&get_instance();
		$data = $CI->db->query("select a.* from ewarn_propinsi a where a.kode='$kode' ");
		$d=$data->result();
		//var_dump($d);
		$result=0;
		foreach($d as $key=>$dt)
		{
			$result=$dt->id;
		}
		return $result;
	}
}

if ( ! function_exists('cari_kota'))
{
	function cari_kota($id)
	{
		$CI =&get_instance();
		$data = $CI->db->query("select a.kota, b.propinsi from ewarn_kota a inner join ewarn_propinsi b on a.id_prop=b.id where a.id='$id' ");
		$d=$data->result();
		//var_dump($d);
		$result='';
		foreach($d as $key=>$dt)
		{
			$result=$dt->kota.'  / '.$dt->propinsi;
		}
		return $result;
	}
}

if ( ! function_exists('cari_combo_kota'))
{
	function cari_combo_kota($id)
	{
		$CI =&get_instance();
		$data = $CI->db->query("select a.* from ewarn_kota a where a.id_prop='$id' ");
		$d=$data->result();
		$result[]=' - Select - ';
		foreach($d as $key=>$dt)
		{
			$result[$dt->id]=$dt->kota;
		}
		return $result;
	}
}

if ( ! function_exists('cari_combo_distrik'))
{
	function cari_combo_distrik($id)
	{
		$CI =&get_instance();
		$data = $CI->db->query("select a.* from ewarn_distrik a where a.id_kota='$id' ");
		$d=$data->result();
		$result[]=' - Select - ';
		foreach($d as $key=>$dt)
		{
			$result[$dt->id]=$dt->distrik;
		}
		return $result;
	}
}

if ( ! function_exists('cari_combo_puskesmas'))
{
	function cari_combo_puskesmas($id)
	{
		$CI =&get_instance();
		$data = $CI->db->query("select a.* from ewarn_puskesmas a where a.id_distrik='$id' ");
		$d=$data->result();
		$result[]=' - Select - ';
		foreach($d as $key=>$dt)
		{
			$result[$dt->id]=$dt->puskesmas;
		}
		return $result;
	}
}

if ( ! function_exists('cari_jml_propinsi'))
{
	function cari_jml_propinsi($id)
	{
		$CI =&get_instance();
		$sql="select (select count(x.id) from ewarn_kota x where x.id_prop={$id} and x.aktif='Y') as jml_kota, (select count(x.id) from ewarn_distrik x inner join ewarn_kota y on x.id_kota=y.id where y.id_prop={$id} and y.aktif='Y') as jml_distrik, (select count(k.id) from ewarn_puskesmas k inner join ewarn_distrik x on k.id_distrik=x.id inner join ewarn_kota y on x.id_kota=y.id where y.id_prop={$id} and k.aktif='Y') as jml_rs";
		$data = $CI->db->query($sql);
		$query=$data->row();
		$result['kota']=$query->jml_kota;
		$result['kecamatan']=$query->jml_distrik;
		$result['puskesmas']=$query->jml_rs;
		return $result;
	}
}


if ( ! function_exists('cari_jml_kota'))
{
	function cari_jml_kota($id)
	{
		$CI =&get_instance();
		$sql="select (select count(x.id) from ewarn_distrik x where x.id_kota={$id} and x.aktif='Y') as jml_distrik, (select count(k.id) from ewarn_puskesmas k inner join ewarn_distrik x on k.id_distrik=x.id where x.id_kota={$id} and k.aktif='Y') as jml_rs";
		$data = $CI->db->query($sql);
		$query=$data->row();
		$result['kecamatan']=$query->jml_distrik;
		$result['puskesmas']=$query->jml_rs;
		return $result;
	}
}

if ( ! function_exists('cari_jml_kecamatan'))
{
	function cari_jml_kecamatan($id)
	{
		$CI =&get_instance();
		$sql="select (select count(k.id) from ewarn_puskesmas k where k.id_distrik={$id} and k.aktif='Y') as jml_rs";
		$data = $CI->db->query($sql);
		$query=$data->row();
		$result['puskesmas']=$query->jml_rs;
		return $result;
	}
}

if ( ! function_exists('cari_data_sms'))
{
	function cari_data_sms($id)
	{
		$CI =&get_instance();
		$sql="SELECT e.propinsi, d.kota, c.distrik, b.puskesmas FROM ewarn_petugas_puskesmas a INNER JOIN ewarn_puskesmas b ON a.id_puskesmas = b.id INNER JOIN ewarn_distrik c ON b.id_distrik = c.id INNER JOIN ewarn_kota d ON c.id_kota = d.id INNER JOIN ewarn_propinsi e ON d.id_prop = e.id where a.hp='{$id}'";
		$data = $CI->db->query($sql);
		$query=$data->row();
		
		$result['propinsi']='';
		$result['kota']='';
		$result['kecamatan']='';
		$result['puskesmas']='';
			
		if ($query){
			$result['propinsi']=$query->propinsi;
			$result['kota']=$query->kota;
			$result['kecamatan']=$query->distrik;
			$result['puskesmas']=$query->puskesmas;
		}
		
		return $result;
	}
}

if ( ! function_exists('cari_combo_petugas_puskesmas'))
{
	function cari_combo_petugas_puskesmas($id)
	{
		$CI =&get_instance();
		$data = $CI->db->query("select a.* from ewarn_petugas_puskesmas a where a.id_puskesmas='$id' ");
		$d=$data->result();
		$result[]=' - Select - ';
		foreach($d as $key=>$dt)
		{
			$result[$dt->id]=$dt->petugas;
		}
		return $result;
	}
}


if ( ! function_exists('cari_distrik'))
{
	function cari_distrik($id)
	{
		$CI =&get_instance();
		$data = $CI->db->query("select a.distrik, b.kota, c.propinsi from ewarn_distrik a inner join ewarn_kota b on a.id_kota=b.id inner join ewarn_propinsi c on b.id_prop=c.id where a.id='$id' ");
		$d=$data->result();
		//var_dump($d);
		foreach($d as $key=>$dt)
		{
			$result=$dt->distrik.'  / '.$dt->kota.'  / '.$dt->propinsi;
		}
		return $result;
	}
}

if ( ! function_exists('cari_rs'))
{
	function cari_rs($id)
	{
		$CI =&get_instance();
		$data = $CI->db->query("select a.puskesmas, b.distrik, c.kota, d.propinsi from ewarn_puskesmas a inner join ewarn_distrik b on a.id_distrik=b.id inner join ewarn_kota c on b.id_kota=c.id inner join ewarn_propinsi d on c.id_prop=d.id where a.id='$id' ");
		$d=$data->result();
		//var_dump($d);
		foreach($d as $key=>$dt)
		{
			$result=$dt->puskesmas.'  / '.$dt->distrik.'  / '.$dt->kota.'  / '.$dt->propinsi;
		}
		return $result;
	}
}

if ( ! function_exists('cariPetugas'))
{
	function cariPetugas($nohp)
	{
		$CI =&get_instance();
		$sql="SELECT
			  a.propinsi,
			  b.kota,
			  c.distrik,
			  d.puskesmas,
			  e.petugas
			FROM
			  ewarn_petugas_puskesmas e
			  INNER JOIN ewarn_puskesmas d ON d.id = e.id_puskesmas
			  INNER JOIN ewarn_distrik c ON c.id = d.id_distrik
			  INNER JOIN ewarn_kota b ON b.id = c.id_kota
			  INNER JOIN ewarn_propinsi a ON a.id = b.id_prop where e.hp='{$nohp}'";
		
		$query = $CI->db->query($sql);
		$jml=$query->num_rows();
		if ($jml>0)
		{
			$rows=$query->result_array();
			foreach($rows as &$row)
			{
				return $row['propinsi'].'/'.$row['kota'].'/'.$row['distrik'].'/'.$row['puskesmas'].'/'.$row['petugas'];
			}
		}else
		{
			return '';
		}
	}
}

if ( ! function_exists('simpan_tmp'))
{
	function simpan_tmp($data,$ket)
	{
		$CI =&get_instance();
		$id_user=$CI->session->userdata('id_user');
			
		$del['user_name']=$id_user;
        $del['judul']=$ket;
        $CI->db->delete('ewarn_tmp',$del);
        
        $dcetak=json_encode($data);
        
        $upd['user_name'] = $id_user;
		$upd['isi'] =  $dcetak;
		$upd['judul'] = $ket;
			
		$CI->db->insert('ewarn_tmp',$upd);
		return true;
	}
}
if ( ! function_exists('format_hp'))
{
	function format_hp($hp)
	{
		$allowed = "/[^0-9]/i";
		$hp=preg_replace($allowed,"",$hp);
		$hp=intval(trim($hp));
		$prefix=substr($hp,0,2);
		if ($prefix!=='62')
			$hp='62'.$hp;
		
		return '+'.$hp;
	}
}
/* End of file number_helper.php */
/* Location: ./system/helpers/number_helper.php */