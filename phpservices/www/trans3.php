<head><meta http-equiv="content-type" content="text/html;charset=utf-8"></head>
<?php
if (isset($_GET['pic']))
{

	if ((file_exists($_GET['pic'])))
	{
		
	$pic=file_get_contents($_GET['pic']);
	echo $pic;
	}
	else
	{
	$pic=file_get_contents('./err.bmp');
	echo $pic;	
	}
}