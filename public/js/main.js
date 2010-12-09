var base_url = "http://spencer.local/";

var page = 1;

$(document).ready(function() {
	$(".widget.describe textarea").autogrow();
	
	$(".widget.rate ul li").click(function() {
		$(".widget.rate input[name='sleep']").val($(this).attr("rel"));
		$(this).siblings().removeClass("current");
		$(this).addClass("current");
	});
	
	$("#load_more").click(function() {
		next_page = page + 1;
		$.get(base_url+"api/load_more_dreams", {page:next_page}, function(data) {
			$("div.dreams .dream").last().after(data.html);
			page++;
		}, "json");
		return false;
	});
		
	$("div.dreams .dream a[rel='like']").live("click", function() {
		like_element = $(this);
		
		dream = $(this).parents(".dream");
		id = dream.attr("id");
		id = id.substr(6);
		
		dream.find("ul.likes").toggle();
		
		$.post(base_url+"api/get_likes", {dream_id:id, like:true}, function(data) {
			if (dream.find("ul.likes").length==0) {
				dream.append(data.html);
				like_element.text(data.num_likes+" likes");
			}
		}, "json");
		
		return false;
	});
	
	$("div.dreams .dream a[rel='comment']").live("click", function() {
		comment_element = $(this);
		pretext = $(this).text();
		num_comments = pretext.replace("comments", "");
		num_comments = jQuery.trim(num_comments);
		num_comments = parseInt(num_comments);
		
		new_num_comments = num_comments + 1;
		newtext = new_num_comments + " comments";
		
		dream = $(this).parents(".dream");
		id = dream.attr("id");
		id = id.substr(6);
		comment = prompt("Leave a comment:");
		if (comment) $.post(base_url+"api/comment_dream", {id: id, content: comment}, function(data) {
			if (data.action == "commented") comment_element.text(newtext);
		}, "json");
		return false;
	});
	
	$("div.follow_button a").click(function() {
		button = $(this).parents(".follow_button");
		button_a = $(this);
		user_id = button.attr("rel");
		$.post(base_url+"api/follow_user", {action:"toggle", follow_id:user_id}, function(data) {
			if (data.action == "unfollow") {
				button_a.text("Follow");
				button_a.attr("class", "follow");
			} else if (data.action == "follow") {
				button_a.text("Unfollow");
				button_a.attr("class", "unfollow");
			}
		}, "json");
		return false;
	});
});