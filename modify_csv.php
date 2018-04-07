<?php
$fcsv = fopen("./guangji.csv", "r");

while(!feof($fcsv))
{
	$curr_line = fgets($fcsv);
	$curr_arr = explode(',', $curr_line);
	$arr_count = count($curr_arr);
	if($arr_count>9 && $arr_count < 12)
	{
		
		$rear = array_pop($curr_arr);
		$curr_line = implode(',', $curr_arr);
		$i=(12 - $arr_count);
		for(;$i > 0 ;--$i)
		{
			$curr_line .= ",0";
		}
		$curr_line .= ",$rear";
	}
	file_put_contents('./jiguang.csv', $curr_line, FILE_APPEND);
}
?>



