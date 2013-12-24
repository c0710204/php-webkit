<?php
$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5);
//echo $lang;
$dic=parse_ini_file('../lang/'.$lang.'.ini',true);
$dic['value']=json_decode(file_get_contents('../lang/'.$lang.'.json'),1);
echo '字典共有'.count($dic['key']).'+'.count($dic['value']).'条翻译<br/>';
$wwwroot=$_SERVER["DOCUMENT_ROOT"];
$truepaths=explode('\\',$wwwroot);
unset($truepaths[count($truepaths)-1]);
$approot=implode('\\', $truepaths);
$coremoderoot=$approot.'\\coremod';
$modsroot=$approot.'\\mods';
$orgs=get_game_res_dir_list('..\\coremod\\');
$mods=get_game_res_dir_list('..\\mods\\');