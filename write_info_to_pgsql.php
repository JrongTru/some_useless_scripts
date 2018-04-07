<?php
$dir = opendir('.');
$this_name = basename(__FILE__);
$matchs = array();
$str = __FILE__;

$conn = @pg_connect ( "host=localhost dbname=kakou user=postgres password=postgres" );

$reg = '/([^S]+([^\/]+))\/\D+(\/\d+)+\/(\D+)?\//';
if(preg_match($reg, $str, $matchs))
{
     print_r($matchs);
}

if(!$conn)
{
     echo pg_last_error()."\n";
     pg_close($conn);
     $conn = NULL;
     exit;
}
else
{
     echo "pgsql connect successed!\n";
}

$sql_cmd = "insert into cltx (fxbh,hphm,hpzl,hpys,jgsj,clsd,tjtp,qmtp,hptp,clxs,cdbh,wzdd,kkbh,tpwz,scbz,tztp,csys,sub_hphm) values('test','-','0','-',to_timestamp($1,'yyyy\mm\dd\hh24miss'),6,$2,$3,'0|0|0,0,0,0|0,0,0,0|',80,'3',$4,'hdk016','hddj-imgserv01','0','no_data','0','-')";


$result = pg_prepare($conn, 'insertData', $sql_cmd);
if(!$result)
{
     echo pg_last_error()."\n";
}

while(false !== ($file = readdir($dir)))
{
     if($file[0] === '.' ||  $file === $this_name)## strcmp($file, $this_name))
          continue;
     $path = realpath($file);
     $ins_p = str_replace('/', '\\', str_replace($matchs[1].'/', "", $path));
     $date = substr($ins_p, 10, 10).'\\'.str_split(basename($path), 6)[0];
     echo $ins_p."\n".$date."\n";

     $res = pg_execute($conn, "insertData", array($date, $ins_p, $matchs[2], $matchs[4]));
}
closedir($dir);
?>
