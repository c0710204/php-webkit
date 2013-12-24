<head><meta http-equiv="content-type" content="text/html;charset=utf-8"></head>

<?php
include 'func.php';
include 'dic.php';

?>
官方mod:<br/>
<table  border="1">
<?php foreach ($orgs as $org ) 
{

	?> 
	<tr>
		<td><a href='<?php echo $coremoderoot.'\\'.$org.'\\assets\\';?>'><?php echo $org;?></a></td>
		<td>
		<?php
			if (file_exists($coremoderoot.'\\'.$org.'\\modinfo.json'))
			{
				$modeinfo=json_decode(file_get_contents($coremoderoot.'\\'.$org.'\\modinfo.json'),1);
				?>
				<table>
					<tr><td>名称</td><td><?php echo $modeinfo['name'];?></td></tr>
					<tr><td>对应游戏版本</td><td><?php echo $modeinfo['gameversion'];?></td></tr>
					<tr><td>mod版本</td><td><?php echo $modeinfo['version'];?></td></tr>
					<tr><td>发布日期</td><td><?php echo $modeinfo['releasedate'];?></td></tr>
					<tr><td>简介</td><td><?php echo $modeinfo['intro'];?></td></tr>		
				</table>
				<?php
			}
			else
			{
		?>
			mod描述文件不存在。
		<?php } ?>
	</td>
	<td>
		<a href='modapply.php?type=org&mod=<?php echo $org; ?>'>还原到...</a>
	</td>
	</tr>
	<?php
}?>
</table>
个人mod:<br/>
<table border="1">
<?php foreach ($mods as $mods ) {
	?> 
	<tr>
		<td><a href='<?php echo $modsroot.'\\'.$mods.'\\assets\\';?>'><?php echo $mods;?></a></td>
		<td><?php

			if (file_exists($modsroot.'\\'.$mods.'\\modinfo.json'))
			{
				$modeinfo=json_decode(file_get_contents($modsroot.'\\'.$mods.'\\modinfo.json'),1);
				?>
				<table>
					<tr><td>名称</td><td><?php echo $modeinfo['name'];?></td></tr>
					<tr><td>对应游戏版本</td><td><?php echo $modeinfo['gameversion'];?></td></tr>
					<tr><td>mod版本</td><td><?php echo $modeinfo['version'];?></td></tr>
					<tr><td>发布日期</td><td><?php echo $modeinfo['releasedate'];?></td></tr>
					<tr><td>简介</td><td><?php echo $modeinfo['intro'];?></td></tr>		
				</table>
				<?php
			}
			else
			{
		?>
			mod描述文件不存在。
		<?php } ?>
		</td>
		<td>
			<a href='modapply.php?type=mods&mod=<?php echo $mods; ?>'>安装到...</a>
		</td>
	</tr>
	<?php
}?>
</table>