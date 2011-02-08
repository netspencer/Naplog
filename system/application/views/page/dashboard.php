<section id="new_dream">
	<?=form_open("dashboard")?>
		<div class="container_12">
			<div class="grid_9">
				<div class="errors"><?=validation_errors()?></div>
			</div>
			<div class="dashboard_navbar_fancyness grid_9">
			</div>
			<div class="dashboard_navbar grid_9">
				<ul class="dashboard_navbar">
					<li class="dashboard_navbar"><a class="dashboard_navbar" href="">Log Dream</a></li>
					<li class="dashboard_navbar"><a class="dashboard_navbar" href="">My Dreams</a></li>
					<li class="dashboard_navbar"><a class="dashboard_navbar" href="">My Analytics</a></li>		
			</div>
			<div class="clear"></div>
			
				<div class="dashboard_navbar_fancyness grid_9">
						
					
				</div>
					
			<div class="post_dream grid_9">
			
				<div class="clear"></div>
				
            	
		    	
				<div class="grid_9">
					
					<div class="widget rate">
						<h2>How many hours did you sleep?</h2>
					
						<div class="sleep"></div>
						<input type="hidden" name="sleep" value="8" />
					
						<ul>
							<li rel="1" class="d1">1</li>
							<li rel="2" class="d2">2</li>
							<li rel="3" class="d3">3</li>
							<li rel="4" class="d4">4</li>
							<li rel="5" class="d5">5</li>
							<li rel="6" class="d6">6</li>
							<li rel="7" class="d7">7</li>
							<li rel="8" class="d8 current">8</li>
							<li rel="9" class="d9">9</li>
							<li rel="10" class="d10">10</li>
							<li rel="11" class="d11">11</li>
							<li rel="12" class="d12">12</li>
							<div class="clear"></div>							
						</ul>
						
					</div>
				
					<div class="widget describe">
						<h2>Describe your dream last night.</h2>
							<textarea name="content"></textarea>
							
					</div>
					<input class='submit_button' type='submit' value'submit' />
				</div>
				
				<div class="clear"></div>
			</div>
		</div>
	<?=form_close()?>
</section>