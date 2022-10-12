<?php 



$smarty = new Smarty();
$smarty->setTemplateDir($App['dirs']['basedir'] . '/templates/');
$smarty->setConfigDir($App['dirs']['configdir'] . '/smarty/');
$smarty->setCompileDir($App['dirs']['appdir'] . 'smarty_writeable/compile/');
$smarty->setCacheDir($App['dirs']['appdir'] . 'smarty_writeable/cache/');
$smarty->force_compile = $App['Settings']['smarty']['force_compile'];
$smarty->debugging =  $App['Settings']['smarty']['debug'];
