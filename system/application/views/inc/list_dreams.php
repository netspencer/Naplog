<div class="dreams">
<?php foreach($dreams as $dream):?>
	<?=$this->parser->parse("tmpl/dream", $dream, true);?>
<?php endforeach;?>
</div>