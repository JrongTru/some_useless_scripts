<?php
$f1 = "./_shenshan.csv";
$f2 = "./shenshan.csv";
$f_out = "./shenshan_merge.csv";
$f_jg_in = fopen($f1, "r");
$f_jg_aly = fopen($f2, "r");

$arr_jg_in = array();
$arr_jg_aly = array();

$skip0 = chop(chop(fgets($f_jg_in), "\n"), "\r");

while(!feof($f_jg_in))
{
	$matchs = array();
	$curr_line = chop(chop(fgets($f_jg_in),"\n"), "\r");
	$tmp_arr = explode(",", $curr_line);
	$rear = array_pop($tmp_arr);
	$reg = "/([^_]+)(.*)?/";
	preg_match($reg, $rear, $matchs);
	$mark = $matchs[1];
	$arr_jg_in["$mark"] = $curr_line;
	echo $mark."\n";
	echo $curr_line."\n";
}

$skip1 = fgets($f_jg_aly);
while(!feof($f_jg_aly))
{
	$curr_line = fgets($f_jg_aly);
	echo $curr_line;
	array_push($arr_jg_aly, $curr_line);
}

$cnt = count($arr_jg_aly);
file_put_contents($f_out, $skip0.",".$skip1, FILE_APPEND);

for($i=0; $i < $cnt; ++$i)
{
	$curr_arr = explode(",", $arr_jg_aly[$i]);
	$mark = $curr_arr[0];
	$put_in = $arr_jg_in["$mark"].",".$arr_jg_aly[$i];
	echo $put_in."\n";
	file_put_contents($f_out, $put_in, FILE_APPEND);
	/*
	if(count($curr_arr) > 3)
	{
		for($j=1;$j < $_cnt; ++$j)
		{
			
			$matchs = array();
			#echo $curr_arr[0]."\n";
			#echo $arr_jg_in[$j]."\n";
			$reg = "/(.*)?($curr_arr[0])+(.*)?/";
			#echo $reg."\n";
			preg_match($reg, $arr_jg_in[$j], $matchs);
			#echo count($matchs)."\n";
			$line = $arr_jg_aly[$i];
			if(count($matchs)>0)	
			{
				$put_in = $arr_jg_in[$j]; 
				$put_in .= ",$line";
				array_splice($arr_jg_in, $j, 1);
				echo $put_in."\n";
				file_put_contents("jiguang_merge.csv", $put_in, FILE_APPEND);
				break;
			}
			
			
		}
	
	}*/
}

?>
