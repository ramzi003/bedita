<?php /* Smarty version Smarty-3.1.11, created on 2012-09-14 17:12:40
         compiled from "/home/bato/workspace/github/bedita/bedita-app/views/layouts/inc/meta.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1896494067505349688635d9-45665728%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '542c2bcc23712719ae436e0e99312ffdd56422b2' => 
    array (
      0 => '/home/bato/workspace/github/bedita/bedita-app/views/layouts/inc/meta.tpl',
      1 => 1347273764,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1896494067505349688635d9-45665728',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'html' => 0,
    'session' => 0,
    'currLang2' => 0,
    'conf' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_50534968a053b5_85766369',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50534968a053b5_85766369')) {function content_50534968a053b5_85766369($_smarty_tpl) {?>

	<?php echo $_smarty_tpl->tpl_vars['html']->value->charset();?>


	<link rel="icon" href="<?php echo $_smarty_tpl->tpl_vars['session']->value->webroot;?>
favicon.ico" type="image/gif" />
	<link rel="shortcut icon" href="<?php echo $_smarty_tpl->tpl_vars['session']->value->webroot;?>
favicon30.gif" type="image/gif" />
	
	<meta http-equiv="Content-Style-Type" content="text/css" />

	<meta name="author" content="ChannelWeb srl - Chialab srl" />
	<meta name="description" content="BEdita, semantic content management" lang="<?php echo $_smarty_tpl->tpl_vars['currLang2']->value;?>
" />
	<meta name="keywords" content="BEdita" />
	<meta name="generator" content="<?php echo $_smarty_tpl->tpl_vars['conf']->value->userVersion;?>
" />
<?php }} ?>