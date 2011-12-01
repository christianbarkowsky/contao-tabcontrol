<!-- indexer::stop -->
<script type="text/javascript">
/* <![CDATA[ */
	function loadTabControls() {
		$$('div.mod_article').each(function(s) {
			new TabControl(s, {
				behaviour: '<?php echo $this->behaviour; ?>',
				tabs: s.getElements('<?php echo $this->tabsSelector; ?>'),
				panes: s.getElements('<?php echo $this->panesSelector; ?>'),
				selectedClass: 'selected',
				hoverClass: 'hover'
			});
		});
	}
	
	/*
	 * Bootstrap
	 */
	window.addEvent('domready', loadTabControls);
/* ]]> */
</script>
<!-- indexer::continue -->

<div class="<?php echo $this->class; ?>_tabs block"<?php echo $this->cssID; ?><?php if ($this->style): ?> style="<?php echo $this->style; ?>"<?php endif; ?>>
<ul>
<?php foreach ($this->titles as $title) : ?>
	<li class="<?php echo $this->tabs; ?>"><?php echo $title; ?></li>
<?php endforeach; ?>
</ul>
</div>