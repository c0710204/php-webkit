<head><meta http-equiv="content-type" content="text/html;charset=utf-8"></head>
<?php
//include 'dic.php';
include 'func.php';
include 'dic.php';
$newdic=array();
//var_dump($_POST);
foreach ($_POST['list'] as $key ) {
	$dicpice=get_res_text($key,$_POST['rootpath_new'],$_POST['rootpath_org'],json_decode($_POST['tags'],1));
	$newdic=array_merge($newdic,$dicpice);
}

$inistr="{\n";
$flag=false;
foreach ($newdic as $key => $value) {
	if ($flag)	$inistr=$inistr.',"'.$key.'" : "'.$value."\"\n";
	else $inistr=$inistr.' "'.$key.'" : "'.$value."\"\n";
	$flag=true;
}
//echo $inistr.']';
file_put_contents("outputdic.json", indent(json_encode($newdic)));
?>