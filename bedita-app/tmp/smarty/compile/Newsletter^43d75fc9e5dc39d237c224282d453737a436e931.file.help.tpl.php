<?php /* Smarty version Smarty-3.1.11, created on 2012-09-14 17:12:40
         compiled from "/home/bato/workspace/github/bedita/bedita-app/views/elements/help.tpl" */ ?>
<?php /*%%SmartyHeaderCode:99401012050534968dbe643-99378830%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '43d75fc9e5dc39d237c224282d453737a436e931' => 
    array (
      0 => '/home/bato/workspace/github/bedita/bedita-app/views/elements/help.tpl',
      1 => 1347273764,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '99401012050534968dbe643-99378830',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'html' => 0,
    'params' => 0,
    'currentModule' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_50534968e26748_48926300',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50534968e26748_48926300')) {function content_50534968e26748_48926300($_smarty_tpl) {?>

<?php $_smarty_tpl->tpl_vars['params'] = new Smarty_variable($_smarty_tpl->tpl_vars['html']->value->params, null, 0);?>
<script type="text/javascript">
var remote_url_response = "<?php echo $_smarty_tpl->tpl_vars['html']->value->url('/pages/helpOnline/');?>
<?php echo $_smarty_tpl->tpl_vars['params']->value['controller'];?>
/<?php echo $_smarty_tpl->tpl_vars['params']->value['action'];?>
";
$().ready(function(e){
	$('.helptrigger').click(function () {

		if (!$("#helpcontent").length) {		
			//fa la chiamata ajax solo se non già fatta precedentemente
			$("#helpcontainer2").addClass("loadingHelp");
			$("#helpcontainer2").append("<div id='helpcontent'></div>");
			
			$.get(remote_url_response, function(html){
				$(html).find(".textC").appendTo("#helpcontent");
				$("#helpcontainer2").removeClass("loadingHelp");
			});		
		} 

		$('#helpcontainer, .quartacolonna, .main, .mainhalf, .mainfull, .insidecol').toggle();
		$(this).toggleClass("helpon");
	});
});
</script>

<div id="helpcontainer">
	<div id="helpcontainer2" class="graced">
		<h2 class="bedita">
			BEhelp } <?php echo (($tmp = @$_smarty_tpl->tpl_vars['currentModule']->value['label'])===null||$tmp==='' ? '' : $tmp);?>
 } <?php echo $_smarty_tpl->tpl_vars['html']->value->action;?>

		</h2>
		<hr />
	</div>
</div><?php }} ?>