<?php
function anti_inject($data)
	{
		$filter_sql = stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES)));
		return $filter_sql;
	}
function NamaBulan($bln) 
{
	if ($bln == 1)
		return "Januari";
	elseif ($bln == 2)
		return "Februari";		
	elseif ($bln == 3)
		return "Maret";		
	elseif ($bln == 4)
		return "April";		
	elseif ($bln == 5)
		return "Mei";
	elseif ($bln == 6)
		return "Juni";		
	elseif ($bln == 7)
		return "Juli";
	elseif ($bln == 8)
		return "Agustus";		
	elseif ($bln == 9)
		return "September";
	elseif ($bln == 10)
		return "Oktober";		
	elseif ($bln == 11)
		return "November";
	elseif ($bln == 12)
		return "Desember";		
}

function NamaHari($hari) 
{
	if ($hari == 1)
		return "Senin";
	elseif ($hari == 2)
		return "Selasa";		
	elseif ($hari == 3)
		return "Rabu";		
	elseif ($hari == 4)
		return "Kamis";		
	elseif ($hari == 5)
		return "Jumat";
	elseif ($hari == 6)
		return "Sabtu";
	elseif ($hari == 7)
		return "Minggu";
}
function no_kwitansi_auto()
	{
		$conn = mysqli_connect("localhost", "root", "", "ponpes");	
		$sql = mysqli_query($conn,"SELECT MAX(RIGHT(no_transaksi,5)) AS notrans 
							FROM transaksi WHERE tgl_transaksi = '".date('Y-m-d')."'");
		$m = mysqli_fetch_assoc($sql);

		$no = 0;
		if($m['notrans'] <> NULL)
		{
			$kd = number_format($m['notrans'],0) + 1;
			if(strlen($kd) == 1)
			{
				$no = "PS".date('dmy')."0000".$kd;
			}
			elseif (strlen($kd) == 2) {
				$no = "PS".date('dmy')."000".$kd;
			}
			elseif (strlen($kd) == 3) {
				$no = "PS".date('dmy')."00".$kd;
			}
			elseif (strlen($kd) == 4) {
				$no = "PS".date('dmy')."0".$kd;
			}
			else {
				$no = "PS".date('dmy').$kd;
			}
		}
		else
		{
			$no = "PS".date('dmy')."00001";
		}

		return $no;
	}
?>