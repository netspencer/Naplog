<section id="dreams">
	<div class="container_12">
		<div class="grid_9">

			<ul class="sections">
				<li <?php if($current_section=="following") echo "class=\"current\""?>><a href="<?=base_url()?>dreams/following">Following</a></li>
				<li <?php if($current_section=="popular") echo "class=\"current\""?>><a href="<?=base_url()?>dreams/popular">Popular</a></li>
				<li <?php if($current_section=="everything") echo "class=\"current\""?>><a href="<?=base_url()?>dreams/everything">Everything</a></li>
			</ul>
			<?php $this->load->view("inc/list_dreams", array("dreams"=>$dreams));?>
			<a href="#" id="load_more">Load More Dream</a>
		</div>
		<div class="grid_3">
			
			<div class="sidebar">
				<div class="ad">	
					<h3>Advertisement</h3>
					<a href="http://klassio.com"><img src="http://f.cl.ly/items/3n2W1o321z3Q2M0D2t14/klassio-ad.jpg" alt="ad" /></a>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</section>