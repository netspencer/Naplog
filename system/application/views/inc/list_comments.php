<ul class="comments">
	<?php foreach($comments as $comment):?>
		<?=$this->parser->parse("tmpl/comment", $comment, true);?>
	<?php endforeach;?>
	<div class="end-loop"></div>
</ul>