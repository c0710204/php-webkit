<html lang="zh-cn">
<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<!-- Bootstrap -->
<link rel="stylesheet" href="/css/bootstrap.css"/>

</head>
<body>
	<div class="container">
<?php



include('func.php');
?><div class="alert alert-warning alert-dismissable"><?php
include('dic.php');
?></div><?php


if (!(isset($_GET['edited'])))$_GET['edited']=0;
if ($_GET['edited']==0)
{

if (isset($_GET['file'])&&(is_dir($_GET['file'])))
{
$sub=scandir($_GET['file']);
$i=0;
?>

<div class='row'>
<?php
foreach ($sub as $line) {
	$line_O=$_GET['file'].'\\'.$line;
	$path=pathinfo($line_O);
	$line=mb_convert_encoding($line, "UTF-8", "GBK");
	if (is_dir($line_O)){
	?>
	<div class='col-md-2'>
	<a href='./trans2.php?file=<?php echo $_GET['file'].'\\'.$line;?>'>
		<span class='glyphicon glyphicon-folder-close'></span>
		<?php echo $line;?>
	</a>
	</div>
	<?php }
	
	if ((isset($path["extension"])&&
		($path["extension"]=='png')
		)){
	?>
	<div class='col-md-2'>
	<span class='glyphicon glyphicon-picture'></span>
	<a href='file://<?php echo $_GET['file'].'\\'.$line;?>'><?php echo $line;?></a>
	</div>
	
	<?php }	
	

	if ((isset($path["extension"])&&
		($path["extension"]!='ttf')&&
		($path["extension"]!='')&&
		($path["extension"]!='png')&&
		($path["extension"]!='ogg')
		)){
	?>
	<div class='col-md-2'>
	<span class='glyphicon glyphicon-list-alt'></span>
	<a href='./trans2.php?file=<?php echo $_GET['file'].'\\'.$line;?>'><?php echo $line;?></a>
	</div>
	
	<?php }	
}
?>
</div>
<?php
}

else 
	{if (isset($_GET['file'])&&(file_exists($_GET['file'])))
{
	$_GET['file']=str_replace('\\','/',$_GET['file']);
	$_GET['file']=str_replace('//','/',$_GET['file']);
	$obj=read_res_file($_GET['file']);
	if (!($obj)) {
	//echo str_replace('\/','/',indent(json_encode(json_decode($json))));
	?>解析出错！<br/><?php }else{?>
	<form action='./trans2.php'>
		<table>
	<tr><td><input type='hidden' name='edited' value='1'>
	<?php echo $dic['key']['fileuri'];?>:</td><td><input type='text' style="width:400px" name='file' value='<?php echo $_GET['file'];?>'/></td></tr>

	<?php foreach ($obj as $key => $value) {
		if (isset($dic['key'][$key]))$key_echo=$dic['key'][$key];else $key_echo=$key;
		if (is_string($value)&&
			isset($dic['value'][$value])
			)
			$value_echo=$dic['value'][$value];else $value_echo=$value;

		if (is_numeric($value))	
		{
		?>
			<tr><td><input type='hidden' name='rows[]' value='<?php echo $key;?>'/>
			<?php echo $key_echo;?>:</td><td><input type='text' style="width:400px" name='<?php echo $key;?>' value='<?php echo $value_echo;?>'/></td></tr>
		<?php }
		if (is_string($value))	
		{
			$path=pathinfo($_GET['file']);
			$valpath=pathinfo($value);
			if (!(strstr($value,'.png')===false))
			{?>
	<tr><td>
	<?php echo $key_echo;?>:</td><td><img src='./trans3.php?pic=<?php echo getpicpath($path['dirname'],$value);?>' alt='<?php echo $path['dirname'].'|'.$value;?>'></img></td></tr>	
			<?php	}
			elseif (strlen($value_echo)<=40)
			{
	?>
	<tr><td><input type='hidden' name='rows[]' value='<?php echo $key;?>'/>
	<?php echo $key_echo;?>:</td><td><input type='text' style="width:400px" name='<?php echo $key;?>' value='<?php echo $value_echo;?>'/></td></tr>
	<?php }else{?>
	<tr><td><input type='hidden' name='rows[]' value='<?php echo $key;?>'/>
	<?php echo $key_echo;?>:</td><td><textarea style="width:400px;height:200px" name='<?php echo $key;?>' ><?php echo $value_echo;?></textarea></td></tr>
	<?php
		}
	}
	}	?>

	<tr><td><input type='submit'></td><td><input type="button" name="Submit" onclick="javascript:history.back(-1);" value="返回"></td></tr>
	</table>
	</form>
	<?php
		
	
}
}
}

?>
<div class='row'><div class='col-md-12'></div></div>

<div >
<form action='./trans2.php'class='form-inline'>
<input type='hidden' name='edited' value='0' >
<div class='row'>
	<div class="form-group">
   		<label class="sr-only" for="path">资源地址</label>
    	<input type='text' name='file' style='width:400px' id='path'  value='<?php if (isset($_GET['file'])) {echo $_GET['file']; }else {echo 'D:\game\SteamApps\common\assets-b1\items';}?>'/>
  	</div>
	<input type='submit' class="btn btn-default btn-sm" value='打开文件/目录'/>
</div>
</form>

<form action='./trans2.php'>
	<input type='hidden' name='edited' value='0'>
	<div class='row'>
		<div class='col-md-2'>选择mod:</div>
		<div class='col-md-4'>
		<select name='file'>
			<?php foreach ($mods as $mod ) {
				?> 
				<option value='<?php echo $modsroot.'\\'.$mod.'\\assets\\';?>'><?php echo $mod;?></option>
				<?php
			}?>
		</select>
		</div>
		<div class='col-md-2 '><input type='submit' class="btn btn-default" value='打开mod'/></div>
	</div>
</form>
</div>
<?php

}
else
{
	//echo $_GET['file'];
	write_res_file($_GET['file'],$_GET);
	?>
		<a class="btn btn-default" href='./trans2.php'></a>
	<?php
}


?>
</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
 <!--[if lt IE 9]>
        <script src="/js/html5shiv.min.js"></script>
        <script src="/js/respond.min.js"></script>
    <![endif]-->
    <script src="/js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/js/bootstrap.min.js"></script>
</body>
</html>