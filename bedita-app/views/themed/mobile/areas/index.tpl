<div data-role="page">

	<div data-role="header">
		<h1>{t}Publications{/t}</h1>
	</div><!-- /header -->

	<div data-role="content">

  {strip}
		{$beTree->designBranchMobile($tree,'checkbox')}
  {/strip}

	</div><!-- /content -->
	{$view->element('footer')}
</div><!-- /page -->