{literal}
<script language="JavaScript" type="text/javascript">
$(document).ready(function(){
	
	$(".autogrowarea").autogrow({
		lineHeight: 16
	});
	$(".areaform input[type='text'], .areaform textarea").width(340);
	

});
</script>
{/literal}

{include file="../common_inc/form_common_js.tpl"}

<fieldset id="properties">

<input type="hidden" name="data[id]" value="{$object.id|default:null}"/>
<input type="hidden" name="data[fixed]" value="{$object.fixed|default:0}"/>
	
	<table class="areaform">

			<tr>
				<th>{t}title{/t}:</th>
				<td><input type="text" id="titleBEObject" style="width:340px;" name="data[title]" value="{$object.title|default:""}"/></td>
			</tr>
			<tr>
				<td><label>{t}reside in{/t}:</label></td>
				<td>
					<select id="areaSectionAssoc" class="areaSectionAssociation" name="data[parent_id]">
					{if !empty($parent_id)}
						{$beTree->option($tree, $parent_id)}
					{else}
						{$beTree->option($tree)}
					{/if}
					</select>
					
					{if $object|default:false && ($object.fixed == 1)}
						<input id="areaSectionAssoc" type="hidden" name="data[parent_id]" value="{$parent_id}" />
					{/if}
					
				</td>
			</tr>
			<tr>
					<th>{t}description{/t}:</th>
					<td><textarea class="autogrowarea" name="data[description]">{$object.description|default:""}</textarea></td>
			</tr>
	</table>
	
	<hr />
	
	<table class="areaform">
			<tr>
			
					<th>{t}status{/t}:</th>
					<td id="status">
						{html_radios name="data[status]" options=$conf->statusOptions selected=$object.status|default:$conf->status separator="&nbsp;"}
					</td>
			</tr>

			<tr>
					<th>{t}language{/t}:</th>
					<td>
					{assign var=object_lang value=$object.lang|default:$conf->defaultLang}
					<select name="data[lang]" id="main_lang">
						{foreach key=val item=label from=$conf->langOptions name=langfe}
						<option {if $val==$object_lang}selected="selected"{/if} value="{$val}">{$label}</option>
						{/foreach}
						{foreach key=val item=label from=$conf->langsIso name=langfe}
						<option {if $val==$object_lang}selected="selected"{/if} value="{$val}">{$label}</option>
						{/foreach}
					</select>
					</td>
				</tr>
			<tr>
				<th>{t}nickname{/t}:(id:{$object.id|default:null})</th>
				<td>
					<input id="nicknameBEObject" type="text" name="data[nickname]" value="{$object.nickname|default:null}" />
					
				</td>
			</tr>
	</table>
	
	<hr />
	
	<table class="areaform">
			<tr>
			
					<th>{t}order{/t}:</th>
					<td>
						<input type="radio" name="data[priority_order]" value="asc" {if $object.priority_order|default:'asc'=="asc"}checked{/if} />{t}asc{/t}
						<input type="radio" name="data[priority_order]" value="desc" {if $object.priority_order|default:'asc'=="desc"}checked{/if} />{t}desc{/t}
					</td>
			</tr>
	<tr>
		<th></th>
		<td>
			<ul id="mediatypes" style="margin-top:10px; margin-left:0px">
				<li class="ico_rss">syndicate <input type="checkbox" name="data[syndicate]" value="on" {if $object.syndicate|default:'off'=='on'}checked{/if}/></li>
			</ul>
		</td>
	</tr>
	</table>
	
	<hr />
	
	<table class="areaform">
			
			<tr>
				<td><label>{t}publisher{/t}:</label></td>
				<td><input type="text" name="publisher" value="" /></td>
			</tr>
			<tr>
				<td><strong>&copy; {t}rights{/t}:</strong></td>
				<td><input type="text" name="data[rights]" value="{$object.rights|default:null}" /></td>
			</tr>
			<tr>
				<td> <label>{t}license{/t}:</label></td>
				<td>
					<select style="width:280px" name="data[license]">
						<option value="">--</option>
						<option  value="Creative Commons Attribuzione 2.5 Italia"{if !empty($object) && $object.license == "Creative Commons Attribuzione 2.5 Italia"} selected{/if}>Creative Commons Attribuzione 2.5 Italia</option>
						<option  value="Creative Commons Attribuzione-Non commerciale 2.5 Italia"{if !empty($object) && $object.license == "Creative Commons Attribuzione-Non commerciale 2.5 Italia"} selected{/if}>Creative Commons Attribuzione-Non commerciale 2.5 Italia</option>
						<option  value="Creative Commons Attribuzione-Condividi allo stesso modo 2.5 Italia"{if !empty($object) && $object.license == "Creative Commons Attribuzione-Condividi allo stesso modo 2.5 Italia"} selected{/if}>Creative Commons Attribuzione-Condividi allo stesso modo 2.5 Italia</option>
						<option  value="Creative Commons Attribuzione-Non opere derivate 2.5 Italia"{if !empty($object) && $object.license == "Creative Commons Attribuzione-Non opere derivate 2.5 Italia"} selected{/if}>Creative Commons Attribuzione-Non opere derivate 2.5 Italia</option>
						<option  value="Creative Commons Attribuzione-Non commerciale-Condividi allo stesso modo 2.5 Italia"{if !empty($object) && $object.license == "Creative Commons Attribuzione-Non commerciale-Condividi allo stesso modo 2.5 Italia"} selected{/if}>Creative Commons Attribuzione-Non commerciale-Condividi allo stesso modo 2.5 Italia</option>
						<option  value="Creative Commons Attribuzione-Non commerciale-Non opere derivate 2.5 Italia"{if !empty($object) && $object.license == "Creative Commons Attribuzione-Non commerciale-Non opere derivate 2.5 Italia"} selected{/if}>Creative Commons Attribuzione-Non commerciale-Non opere derivate 2.5 Italia</option>
						<option  value="Tutti i diritti riservati"{if !empty($object) && $object.license == "Tutti i diritti riservati"} selected{/if}>Tutti i diritti riservati</option>
					</select>
				</td>
			</tr>

		</table>
	

</fieldset>	

	<br />
	
	{include file="../common_inc/form_translations.tpl" object=$object|default:null}
	{include file="../common_inc/form_permissions.tpl" el=$object|default:null recursion=true}
	
	
{*if (!empty($method) && $method == "viewSection")}			



{else}
	
	<hr />
	<a href="{$html->url('/areas/viewSection/')}{$object.id}">
	
		{t}Edit more details{/t}

	</a>
	<hr />
{/if*}


