<ul class="comments">
	<?php foreach($comments as $comment):?>
		<?php $this->load->view("partial/comment", $comment);?>
	<?php endforeach;?>
	<div class="end-loop"></div>
</ul>