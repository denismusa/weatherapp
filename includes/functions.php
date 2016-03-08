<?
	
	function k_to_c($temp)
	{
		if ( !is_numeric($temp) ) { return false; }
		return round(($temp - 273.15));
	}
	
?>