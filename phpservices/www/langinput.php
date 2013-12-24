<head><meta http-equiv="content-type" content="text/html;charset=utf-8"></head>
<?php
//include 'dic.php';
include 'func.php';
include 'dic.php';
?>
<form action='./langinput2.php'>
	官方mod:
	<select name='rootpath_org'>
		<?php foreach ($orgs as $org ) {
			?> 
			<option value='<?php echo $coremoderoot.'\\'.$org.'\\assets\\';?>'><?php echo $org;?></option>
			<?php
		}?>
	</select><br/>
	来源mod:
	<select name='rootpath_new'>
		<?php foreach ($mods as $mod ) {
			?> 
			<option value='<?php echo $modsroot.'\\'.$mod.'\\assets\\';?>'><?php echo $mod;?></option>
			<?php
		}?>
	</select><br/>
	提取内容:<br/>
	<input type='checkbox' name='description'><?php echo $dic['key']['description']?><br/>
	<input type='checkbox' name='shortdescription'><?php echo $dic['key']['shortdescription']?><br/>
	<input type='checkbox' name='title'><?php echo $dic['key']['title']?><br/>
	<input type='checkbox' name='interface'><?php echo $dic['key']['interface']?><br/>
	<input type='checkbox' name='contentPages'><?php echo $dic['key']['contentPages']?><br/>
	</select>
	<input type='submit'>
<?php