var base_url = "/";

var page = 1;

$(document).ready(function() {
	$(window).resize();
	$(".widget.describe textarea").autogrow();
	$("span.timestamp").timeago();
	
	$(window.location.hash).addClass("from_hash");
	
	$(".widget.rate ul li").click(function() {
		$(".widget.rate input[name='sleep']").val($(this).attr("rel"));
		$(this).siblings().removeClass("current");
		$(this).addClass("current");
	});
	
	$("#load_more").click(function() {
		next_page = page + 1;
		$.get(base_url+"api/load_more_dreams", {page:next_page}, function(data) {
			$("div.dreams .dream").last().after(data.html);
			//$("#tmpl_dream").tmpl(data).insertAfter($("div.dreams .dream").last());
			page++;
		}, "json");
		return false;
	});
		
	$("div.dreams .dream a[rel='like']").live("click", function() {
		dream = $(this).parents(".dream");
		id = dream.attr("id");
		id = id.substr(6);
				
		$.post(base_url+"api/like_dream", {dream_id:id}, function(data) {
			dream.find("a[rel='like']").text(data.num_likes+" likes");
			if (data.action=="liked") {
				dream.find("a[rel='like']").addClass("liked");
				$("ul.likes li.user").last().append("<span>,</span>");
				$("#tmpl_like").tmpl(data).insertBefore($("ul.likes div.end-loop"));
			} else {
				dream.find("a[rel='like']").removeClass("liked");
				$("ul.likes li.current-user").remove();
				$("ul.likes li.user").last().find("span").remove();
				if (data.num_likes == 0) {
					$("ul.likes li.num_likes").remove();
				}
			}
		}, "json");
		
		return false;
	});
	
	$("div.dreams .dream a[rel='comment']").live("click", function() {
		$.scrollTo("#add-comment", 500);
		$("#add-comment textarea").trigger("focus");
		return false;
	});
	
	$("#add-comment").click(function() {
		$("#add-comment textarea").trigger("focus");
	});
	
	$("#add-comment textarea").focus(function() {
		$("#add-comment h2").addClass("focus");
	});
	
	$("#add-comment textarea").blur(function() {
		$("#add-comment h2").removeClass("focus");
	});
		
	$("form#add-comment").submit(function() {
		id = $(this).find("[name='dream_id']").val();
		comment = $(this).find("[name='content']").val();
		if (comment) $.post(base_url+"api/comment_dream", {id: id, content: comment}, function(data) {
			//$("#tmpl_comment").tmpl(data).insertBefore($("ul.comments div.end-loop"));
			$("ul.comments div.end-loop").before(data);
			$("span.timestamp").timeago();
			set_comment("");
		});
		return false;
	});
	
	$("form#add-comment").keydown(function(e) {
		if (e.which == 13 && e.shiftKey) {
			// shift+enter
		} else if (e.which == 13) {
			// enter
			$(this).submit();
			return false;
		}
	});
	
	$("ul.comments span.reply").live("click", function() {
		comment = $(this).parents("li");
		user = comment.find("a.user").text();
		$("#add-comment textarea").trigger("focus");
		temp = $("form#add-comment").find("[name='content']").val();
		set_comment("@"+user+" "+temp);
	});
	
	$("#notifications a[rel='mark_all']").click(function() {
		$.post(base_url+"api/mark_notifications");
		$("#notifications ul li").removeClass("unread");
		$("#notifications ul li").addClass("read");
		$("span#notif_count").text("");
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
	
	$("a#set_new_password").click(function() {
		$(this).hide();
		$("#new_password").fadeIn();
	});
});

$(window).resize(function() {
	window_height = $(window).height();
	body_height = $("body").height();
	diff = window_height - body_height;
	if (diff > 0) {
		diff = (diff + $("div.endofpage").height()) - 20;
		$("div.endofpage").height(diff);
	}
});

function set_comment(value) {
	$("form#add-comment").find("[name='content']").val(value);
}