<head><meta http-equiv="content-type" content="text/html;charset=utf-8"></head>
<?php
include 'func.php';
include 'dic.php';

if (isset($_GET['gamepath']))
{
	if ($_GET['type']=='org') $assets_path=$coremoderoot.'\\'.$_GET['mod'].'\\*';
	else $assets_path=$modsroot.'\\'.$_GET['mod'].'\\*';
	$game_assets_path=$_GET['gamepath'].'\\*';

	$cmd="xcopy \"$assets_path\" \"$game_assets_path\" /Y /E";
	//echo $cmd;
	$result=shell_exec($cmd);
	file_put_contents("php://stdout", $result);
	//echo mb_convert_encoding(str_replace("\n", "<br/>", $result), "UTF-8", "GBK");;
	?><input type="button" name="Submit" onclick="javascript:history.back(-1);" value="返回"><?php
}
else
{
?>
<form aciton='modapply.php'>
游戏根目录(\Starbound)：<input type='text' name='gamepath' value='D:\game\SteamApps\common\Starbound'/><br/>
应用mod：<?php echo $_GET['mod'];?><br/>
<input type='hidden' name='mod' value='<?php echo $_GET['mod'];?>'>
<input type='hidden' name='type' value='<?php echo $_GET['type'];?>'>
<input type='submit' value='确认安装'><input type="button" name="Submit" onclick="javascript:history.back(-1);" value="返回">
</form>
<?php
}
?>