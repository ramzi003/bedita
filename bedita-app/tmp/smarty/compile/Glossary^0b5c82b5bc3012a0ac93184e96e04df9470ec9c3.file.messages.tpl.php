<?php /* Smarty version Smarty-3.1.11, created on 2012-09-11 12:37:14
         compiled from "/home/bato/workspace/github/bedita/bedita-app/views/elements/messages.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2142358279504f145acd4f24-15726681%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0b5c82b5bc3012a0ac93184e96e04df9470ec9c3' => 
    array (
      0 => '/home/bato/workspace/github/bedita/bedita-app/views/elements/messages.tpl',
      1 => 1347273764,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2142358279504f145acd4f24-15726681',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'session' => 0,
    'conf' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_504f145adc8928_33246197',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_504f145adc8928_33246197')) {function content_504f145adc8928_33246197($_smarty_tpl) {?><script type="text/javascript" charset="utf-8">
$(document).ready ( function ()  { 
<?php if (($_smarty_tpl->tpl_vars['session']->value->check('Message.info'))){?>
	$("#messagesDiv").triggerMessage("info", <?php echo $_smarty_tpl->tpl_vars['conf']->value->msgPause;?>
);
<?php }?>
<?php if (($_smarty_tpl->tpl_vars['session']->value->check('Message.warn'))){?>
	$("#messagesDiv").triggerMessage("warn", <?php echo $_smarty_tpl->tpl_vars['conf']->value->msgPause;?>
);
<?php }?>	
<?php if (($_smarty_tpl->tpl_vars['session']->value->check('Message.error'))){?>
	$("#messagesDiv").triggerMessage("error");
<?php }?>

});
</script>

<div id="messagesDiv">

	<?php if ($_smarty_tpl->tpl_vars['session']->value->check('Message.info')){?>
		<?php echo $_smarty_tpl->tpl_vars['session']->value->flash('info');?>

	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['session']->value->check('Message.warn')){?>
		<?php echo $_smarty_tpl->tpl_vars['session']->value->flash('warn');?>

	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['session']->value->check('Message.error')){?>
		<?php echo $_smarty_tpl->tpl_vars['session']->value->flash('error');?>

	<?php }?>
	
</div><?php }} ?>