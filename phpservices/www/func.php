<head><meta http-equiv="content-type" content="text/html;charset=utf-8"></head>
<?php
/** 
* Indents a flat JSON string to make it more human-readable. 
* @param string $json The original JSON string to process. 
* @return string Indented version of the original JSON string. 
*/ 
function indent ($json) { 

$result = ''; 
$pos = 0; 
$strLen = strlen($json); 
$indentStr = ' '; 
$newLine = "\n"; 
$prevChar = ''; 
$outOfQuotes = true; 

for ($i=0; $i<=$strLen; $i++) { 

// Grab the next character in the string. 
$char = substr($json, $i, 1); 
// Are we inside a quoted string? 
if ($char == '"' && $prevChar != '\\') { 
$outOfQuotes = !$outOfQuotes; 
// If this character is the end of an element, 
// output a new line and indent the next line. 
} else if(($char == '}' || $char == ']') && $outOfQuotes) { 
$result .= $newLine; 
$pos --; 
for ($j=0; $j<$pos; $j++) { 
$result .= $indentStr; 
} 
} 
// Add the character to the result string. 
$result .= $char; 
// If the last character was the beginning of an element, 
// output a new line and indent the next line. 
if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) { 
$result .= $newLine; 
if ($char == '{' || $char == '[') { 
$pos ++; 
} 
for ($j = 0; $j < $pos; $j++) { 
$result .= $indentStr; 
} 
} 
$prevChar = $char; 
} 
return $result; 
} 




function read_res_file($file_path)
{
	$file=fopen($file_path,'r');
	if ($file===false) return false;
	$json='';
	$adv_flag=false;
	$tempstr='';
	$ign_flag=false;
	while (!feof($file)) 
	{		
		
		$line=fgets($file);
		//if (!(strstr($line, 'color')===false)) return false;
		if (!(strstr($line, '//')===false)) continue;
		if (!(strstr($line, '/*')===false)) $ign_flag=true;
		if (!(strstr($line, '*/')===false)) {$ign_flag=false;continue;}
		if ($ign_flag) continue;
		if ($line==="\n") continue;
		if ($line===" \n") continue;	
		//if ((substr(ltrim($line),0,1)=='"')&&(count(explode('"',$line))==2)&&((strstr($line, ",\n")===false))&&((strstr($line, ':')===false))) $adv_flag=true;
		//if ($adv_flag&&((!(strstr($line, "\",\n")===false))||(!(strstr($line, "\"\n")===false)))) $adv_flag=false;
		if ($adv_flag)
		{
			//echo '|'.$tempstr.$line.'|<br/>';
			$tempstr=$tempstr.trim($line).'\n';continue;

		}
		if ((!$adv_flag)&&($tempstr!=''))
		{
			echo '|'.$tempstr.$line.'|<br/>';
			$json=$json.$tempstr.$line;$tempstr='';

			continue;
			
		}
		$json=$json.$line;
		//echo '|'.$line.'|<br/>';
	}
	//echo $json.'<br/>';
	$obj=json_decode($json,1);
	return $obj;
}
function write_res_file($file_path,$new_content)
{
	$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5);
	$file=fopen($file_path,'r+');
	$json='';
	$adv_flag=false;
	$tempstr='';
	$ign_flag=false;
	if ($file===false) return false;
	while (!feof($file)) 
	{
		$line=fgets($file);
		if (!(strstr($line, '//')===false)) continue;
		if (!(strstr($line, '/*')===false)) $ign_flag=true;
		if (!(strstr($line, '*/')===false)) {$ign_flag=false;continue;}
		if ($ign_flag) continue;
		if ($line==="\n") continue;
		if ($line===" \n") continue;			
		$json=$json.$line."\n";
		//echo '|'.$line.'|<br/>';
	}
	fclose($file);
	//unlink($file_path);
	//echo $json;
	$obj=json_decode($json);
	foreach ($new_content as $key => $value) {
		if(isset($obj->$key))$obj->$key=$new_content[$key];
		else echo '无法将 '.$key.' 替换为 '.$value.": 元素不存在<br/>\n" ;
	}
	$obj->rebuild_tool_info->lang=$lang;
	$obj->rebuild_tool_info->rebuildtime=time();
	$obj->rebuild_tool_info->provide_by='TPOv1';
	//echo str_replace('\/','/',indent(json_encode($obj)));	
	$json=json_encode($obj);
	$path=pathinfo($file_path);
	if ($path["extension"]=='generatedshield')
	{
		$json=str_replace('"palette":[[]]', '"palette":[{}]', $json);
	}
	if ($path["extension"]=='object')
	{
		$json=str_replace('1,[]]', '1,{}]', $json);
	}	

	return file_put_contents($file_path,str_replace('\/','/',indent($json)));	
}

function get_res_text($respath,$root,$root_org,$inputkey)
{
	//echo 'cal '.$root.$respath.'<br/>';
	$obj1=read_res_file($root.$respath);
	$obj2=read_res_file($root_org.$respath);
	if (!($obj1)) return array('error'=>'error');
	if (!($obj2)) return array('error'=>'error');
	return get_res_text_From_obj($obj1,$obj2,$inputkey);
}
function set_res_text($respath,$root,$root_org,$inputkey,$dic)
{
	//echo 'cal '.$root.$respath.'<br/>';
	$obj=read_res_file($root_org.$respath);
	if (!($obj)) return false;
	$newobj=set_res_text_to_obj($obj,$inputkey,$dic);
	if (is_null($newobj)) return true;
	return write_res_file($root.$respath,$newobj);
}
function get_game_res_dir_list($root)
{
	
	$ans=array();
	if (!(file_exists($root)))
	{
		mkdir($root);
		return array();
	}
	$sub=scandir($root);
	$i=0;

	foreach ($sub as $line) 
	{
			
		if ($line=='.') continue;
		if ($line=='..') continue;
		$path=pathinfo($root.$line);
		if ((is_dir($root.$line))&&(is_dir($root.$line.'/assets')))
		{
			array_push($ans,$line);
		}
	}
	return $ans;
}
function get_file_list($pathin,$root)
{
	
	$ans=array();
	$sub=scandir($root.$pathin);
	$i=0;

	foreach ($sub as $line) 
	{
			
		if ($line=='.') continue;
		if ($line=='..') continue;
		$line_O=$pathin.'\\'.$line;
		$path=pathinfo($root.$line_O);
		if (is_dir($root.$line_O))
		{
			$ans=array_merge($ans,get_file_list($line_O,$root));
		}

		if ((isset($path["extension"])&&
			($path["extension"]!='ttf')&&
			($path["extension"]!='')&&
			($path["extension"]!='wav')&&
			($path["extension"]!='png')&&
			($path["extension"]!='zip')&&
			($path["extension"]!='psd')&&
			($path["extension"]!='abc')&&
			($path["extension"]!='lua')&&
			($path["extension"]!='txt')&&
			($path["extension"]!='ogg')))
		{
			array_push($ans, $line_O);
		}
	}
	return $ans;
}
function get_res_text_From_obj($obj,$obj_org,$inputkey)
{
	$dic=array();
	if (is_array($obj))
	{
		foreach ($obj as $key => $value) {
			//interface mod
			if((is_array($inputkey)&&(in_array('interface',$inputkey)))||($inputkey==''))
				if ((isset($value['type']))&&($value['type']=='label')&&(isset($value['value'])))
				{

					$dic[$obj_org[$key]['value']]=$value['value'];
				}
					
			//item mod
			if ((is_string($key))&&
				(is_string($value))&&
			//	(!(strstr($value, '/')===false))&&
			//	(!(strstr($value, '.png')===false))&&
			//	(!(strstr($value, '.ogg')===false))&&
			//	(!(strstr($value, '.wav')===false))&&
				($key!='itemName')
				)
			{
				if((is_array($inputkey)&&(in_array($key, $inputkey)))||($inputkey==''))
					{$dic[$obj_org[$key]]=$value; }
			}
		}
	}
	else
	{
		var_dump($obj);
		$dic=array();
	}
	return $dic;
}

function set_res_text_to_obj($obj_org,$inputkey,$dic)
{
	$orj=array();
	//var_dump($obj_org);
	if (is_array($obj_org))
	{
		foreach ($obj_org as $key => $value) 
		{
			//interface mod
			if((is_array($inputkey)&&(in_array('interface',$inputkey)))||($inputkey==''))
				if ((isset($value['type']))&&($value['type']=='label')&&(isset($value['value'])))
				{

					if (isset($dic['value'][$value['value']]))
						$value['value']=$dic['value'][$value['value']]; 
				}
					
			//item mod
			if ((is_string($key))&&
				(is_string($value))&&
			//	(!(strstr($value, '/')===false))&&
			//	(!(strstr($value, '.png')===false))&&
			//	(!(strstr($value, '.ogg')===false))&&
			//	(!(strstr($value, '.wav')===false))&&
				($key!='itemName')
				)
			{

				if((is_array($inputkey)&&(in_array($key, $inputkey)))||($inputkey==''))
				{
					echo "翻译 \"".$value;
					if (isset($dic['value'][$value]))
					{
						$obj[$key]=$dic['value'][$value]; 
						echo '" 到 '.$obj[$key]." <br/>\n";
					}
					else
					{
						echo '" 失败'." <br/>\n";
					}
				}
			}
		}
	}
	else
	{
		var_dump($obj_org);

	}
	return $obj;
}

function getpicpath($path,$picpath)
{
	if (!(strstr($picpath, ':')===false)) $picpath=explode(':', $picpath)[0];
	if (substr($picpath, 0,1)=='/')
	{
		$truepaths=explode('/',$path);
		$picpaths=explode('/', $picpath);
		for ($i=count($truepaths)-1; $i>=0 ; $i--) { 
			$trypath=implode('/', $truepaths);
			if (file_exists($trypath.$picpath)) return $trypath.$picpath;
			else unset($truepaths[$i]);
		}
	}
	else
	{
		return $path.'/'.$picpath;
	}
}