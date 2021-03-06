<script type="text/javascript">
<!--
var message = "{t}Are you sure that you want to delete the item?{/t}" ;
var messageSelected = "{t}Are you sure that you want to delete selected items?{/t}" ;
var urls = Array();
urls['deleteSelected'] = "{$html->url('deleteSelected/')}";
urls['changestatusSelected'] = "{$html->url('changeStatusObjects/')}";
urls['copyItemsSelectedToAreaSection'] = "{$html->url('addItemsToAreaSection/')}";
urls['moveItemsSelectedToAreaSection'] = "{$html->url('moveItemsToAreaSection/')}";
urls['removeFromAreaSection'] = "{$html->url('removeItemsFromAreaSection/')}";
urls['assocObjectsCategory'] = "{$html->url('assocCategory/')}";
urls['disassocObjectsCategory'] = "{$html->url('disassocCategory/')}";
urls['checkSelected'] = "{$html->url('checkMultiUrl/')}";
var no_items_checked_msg = "{t}No items selected{/t}";
var sel_status_msg = "{t}Select a status{/t}";
var sel_category_msg = "{t}Select a category{/t}";
var sel_copy_to_msg = "{t}Select a destination to 'copy to'{/t}";

function count_check_selected() {
	var checked = 0;
	$('input[type=checkbox].objectCheck').each(function(){
		if ($(this).prop("checked")) {
			checked++;
		}
	});
	return checked;
}
$(document).ready(function(){

	// avoid to perform double click
	$("a:first", ".indexlist .obj").click(function(e){ 
		e.preventDefault();
	});

	$(".indexlist .obj TD").not(".checklist").not(".go").css("cursor","pointer").click(function(i) {
		document.location = $(this).parent().find("a:first").attr("href"); 
	});

	$("#deleteSelected").bind("click", function() {
		if (count_check_selected()<1) {
			alert(no_items_checked_msg);
			return false;
		}
		if (!confirm(message)) {
			return false;
		}
		$("#formObject").prop("action", urls['deleteSelected']) ;
		$("#formObject").submit() ;
	});

	$("#assocObjects").click( function() {
		if (count_check_selected()<1) {
			alert(no_items_checked_msg);
			return false;
		}
		if ($('#areaSectionAssoc').val() == "") {
			alert(sel_copy_to_msg);
			return false;
		}
		var op = ($('#areaSectionAssocOp').val())? $('#areaSectionAssocOp').val() : "copy";
		$("#formObject").attr("action", urls[op + 'ItemsSelectedToAreaSection']) ;
		$("#formObject").submit() ;
	});

	$(".opButton").click( function() {
		if (count_check_selected() < 1) {
			alert(no_items_checked_msg);
			return false;
		}
		if (this.id.indexOf('changestatus') > -1) {
			if ($('#newStatus').val() == "") {
				alert(sel_status_msg);
				return false;
			}
		}
		if (this.id == 'assocObjectsCategory') {
			if ($('#objCategoryAssoc').val() == "") {
				alert(sel_category_msg);
				return false;
			}
		}
		if (this.id == 'disassocObjectsCategory') {
			$('#objCategoryAssoc').val($('#filter_category').val());
		}
		$("#formObject").prop("action", urls[this.id]) ;
		$("#formObject").submit() ;
	});
});

//-->
</script>	

	
<form method="post" action="" id="formObject">

	<input type="hidden" name="data[id]"/>


	<table class="indexlist js-header-float">
	{capture name="theader"}
	<thead>
		<tr>
			<th></th>
			<th>{$beToolbar->order('title', 'Title')}</th>
			<th>{$beToolbar->order('url', 'Url')}</th>
			<th>{$beToolbar->order('http_code', 'check result')}</th>
			<th style="text-align:center">{$beToolbar->order('status', 'Status')}</th>
			{if !empty($properties)}
				{foreach $properties as $p}
					<th>{$p.name}</th>
				{/foreach}
			{/if}
			<th style="text-align:center">{t}Link{/t}</th>
			<th>{t}Notes{/t}</th>
		</tr>
	</thead>
	{/capture}
		
		{$smarty.capture.theader}
	
		{section name="i" loop=$objects}
		
		<tr class="obj {$objects[i].status}">
			<td class="checklist">
			{if (empty($objects[i].fixed))}
				<input type="checkbox" name="objects_selected[]" class="objectCheck" title="{$objects[i].id}" value="{$objects[i].id}" />
			{/if}
			</td>
			<td><a href="{$html->url('view/')}{$objects[i].id}">{$objects[i].title|truncate:64|default:"<i>[no title]</i>"}</a></td>
			<td>{$objects[i].url|default:''|truncate:48:'(...)':true:true}</td>
			<td>{$objects[i].http_code|default:''}</td>
			<td style="text-align:center">{$objects[i].status}</td>
			{if !empty($properties)}
				{foreach $properties as $p}
					<td class="custom-property-cell">
					{if !empty($objects[i].customProperties[$p.name]) && $p.object_type_id == $objects[i].object_type_id}
						{if is_array($objects[i].customProperties[$p.name])}
							{$objects[i].customProperties[$p.name]|@implode:", "|truncate:80:"..."}
						{else}
							{$objects[i].customProperties[$p.name]|truncate:80:"..."}
						{/if}
					{else}
						-
					{/if}
					</td>
				{/foreach}
			{/if}
			<td class="go">
				<input type="button" value="{t}go{/t}" onclick="window.open('{$objects[i].url|default:''}','_blank')" />	
			</td>
			
			<td>{if $objects[i].num_of_editor_note|default:''}<img src="{$html->webroot}img/iconNotes.gif" alt="notes" />{/if}</td>
		</tr>
		
		
		
		{sectionelse}
		
			<tr><td colspan="100" style="padding:30px">{t}No items found{/t}</td></tr>
		
		{/section}

</table>


<br />

{assign_associative var="params" bulk_checklinks=true bulk_tree=true bulk_categories=true bulk_export_links=true}
{$view->element('list_objects_bulk', $params)}

</form>



<br />
<br />
<br />
<br />
	
	



