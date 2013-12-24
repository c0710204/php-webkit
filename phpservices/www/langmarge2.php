<head><meta http-equiv="content-type" content="text/html;charset=utf-8"></head>
<?php
include 'func.php';
$dic1=json_decode(file_get_contents($_GET['langfrom']),1);
$dic2=json_decode(file_get_contents($_GET['langto']),1);
$i=0;
foreach ($dic2 as $key => $value) if ((isset($dic1[$key]))&&($dic1[$key]!=$key))
	{$i++; $dic2[$key]=$dic1[$key];}
file_put_contents($_GET['langto'], json_encode($dic2));
echo "marge ".$i.' words';
?>
