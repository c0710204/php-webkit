<head><meta http-equiv="content-type" content="text/html;charset=utf-8"></head>
<?php
//include 'dic.php';
include 'func.php';
include 'dic.php';
//var_dump($_POST);
foreach ($_POST['list'] as $key ) {
	
	$flag=set_res_text($key,$_POST['rootpath_new'],$_POST['rootpath_org'],json_decode($_POST['tags'],1),$dic);
	if ($flag===false)
	{
		
		echo '<strong>'.$key.'</strong> ';
	 	echo '<span style="color:red;">读取失败</span>';	
		echo '<br/><br/>';
	}
	elseif ($flag===true) 
	{
	//	echo '无导入内容';
	}
	else
	{
		
		echo '<strong>'.$key.'</strong> ';
	 	echo '<span style="color:green;">成功</span>';
	 	echo '<br/><br/>';
	}
	
	
}

//echo $inistr.']';
//file_put_contents("outputdic.json", indent(json_encode($newdic)));
?>