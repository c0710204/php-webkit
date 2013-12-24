<head><meta http-equiv="content-type" content="text/html;charset=utf-8"></head>
<form action='./langoutput3.php' method='post'>
	<input type='submit' value='开始执行'/><br/>
	<?php if ($_GET['rootpath_org']=='') $_GET['rootpath_org']=$_GET['rootpath_new'];?>
<input type='hidden' name='rootpath_new' value='<?php echo $_GET['rootpath_new'];?>'/>
<input type='hidden' name='rootpath_org' value='<?php echo $_GET['rootpath_org'];?>'/>
<?php
include 'func.php';
include 'dic.php';

$list=get_file_list('',$_GET['rootpath_new']);
$rootpath_new=$_GET['rootpath_new'];
$rootpath_org=$_GET['rootpath_org'];
unset($_GET['rootpath_new']);
unset($_GET['rootpath_org']);
$tags=array();
foreach ($_GET as $key => $value) {
	if ($value=='on')array_push($tags,$key);
}
?>
<input type='hidden' name='tags' value='<?php echo json_encode($tags);?>'/>
<?php
foreach ($list as $line)
{
	?>
	<input type='hidden' name='list[]' value='<?php echo $line;?>'/>
	<a href='./trans2.php?file=<?php echo $rootpath_new.$line;?>'><strong><?php echo $line;?></strong></a><br/>
	<?php
}
?>
</form>