// JavaScript Document

function animationAjax(caption) {
	
	$caption = caption;
	$(document).ajaxStart(function() {
	});
	$(document).ajaxSend(function(){
		$($caption).append("<span>").css("text-align","center").text("Um momento");
	});
	$(document).ajaxSuccess(function(){
	});
	$(document).ajaxComplete(function(){
	});
	$(document).ajaxError(function(){
	});
	$(document).ajaxStop(function() {
		$(caption).empty();
	});
	
}
animationAjax("#msg-ajax");

function openStart($object) {
	
	$input_search = $("input[id=input-search]").val();
	$input_search = $input_search.replace(" ","%20");
	$input_search = $input_search.replace(" ","%20");
	$input_search = $input_search.replace(" ","%20");
	$input_search = $input_search.replace(" ","%20");
	$input_start = $("input[id=input-start]").val();
	if ( $input_search !== "" ) {
		if ( $input_start !== "" ) {
			animationAjax("#msg-search");
			$("#content-search").load("include/action_search.php?input-start="+$input_start+"&input-search="+$input_search);
		} else {
			alert("Insert a page");
		}
	} else {
		alert("Insert a search");
	}
	
}

function openClean($object) {
	
	$("input[id=input-search]").val("");
	$("input[id=input-start]").val("");
	
}

function openPrevious($object) {
	
	$input_search = $("input[id=input-search]").val();
	$input_search = $input_search.replace(" ","%20");
	$input_search = $input_search.replace(" ","%20");
	$input_search = $input_search.replace(" ","%20");
	$input_search = $input_search.replace(" ","%20");
	$input_start = $("input[id=input-start]").val();
	if ( $input_search !== "" ) {
		if ( $input_start !== "" ) {
			$start = eval($input_start)-10;
			if ( $start == "0" ){
				$start = $start+"0";
			}
			if ( $start >= 00 ) {
				$("#content-search").empty();
				$("input[id=input-start]").val($start);
				animationAjax("#msg-search");
				$("#content-search").load("include/action_search.php?input-start="+$start+"&input-search="+$input_search);
			} else {
				alert("One moment");
			}
		} else {
			alert("Insert a page");
		}
	} else {
		alert("Insert a search");
	}
	
}

function openNext($object) {
	
	$input_search = $("input[id=input-search]").val();
	$input_search = $input_search.replace(" ","%20");
	$input_search = $input_search.replace(" ","%20");
	$input_search = $input_search.replace(" ","%20");
	$input_search = $input_search.replace(" ","%20");
	$input_start = $("input[id=input-start]").val();
	if ( $input_search !== "" ) {
		if ( $input_start !== "" ) {
			$start = eval($input_start)+10;
			$("#content-search").empty();
			$("input[id=input-start]").val($start);
			animationAjax("#msg-search");
			$("#content-search").load("include/action_search.php?input-start="+$start+"&input-search="+$input_search);
		} else {
			alert("Insert a page");
		}
	} else {
		alert("Insert a search");
	}
	
}

function openPageIndex($index,$table,$start) {
	
	if ( !$("#button-remove-"+$start)[0] ) {
		$button = $("<button>").attr("id","button-remove-"+$start).attr("class","button").width(80).height(25).attr("name",$start).attr("type","button").attr("onclick","openCleanIndex(name)").text("Remove");
		$("#head-left-"+$start+" > ul").append($("<li>").css("display","inline-block").css("padding","0 1px").append($button));
		openAjaxIndex($index,$table,$start);
	} else {
		alert("Button is already selected");
	}
	
}

function openAjaxIndex($index,$table,$start) {
	
	animationAjax("#msg-"+$start);
	$("#body-left-"+$start).load("_query.php?index="+$index+"&input-table="+$table+"&input-start="+$start);
	
}

function openDeleteIndex($index,$table) {
	
	if ( confirm("Delete the result") == true ) {
		$("#inner-content").empty();
		$("#inner-content").load("_delete.php?index="+$index+"&data-table="+$table);
	}
	
}

function openCleanIndex(start) {
	
	$("#button-remove-"+start).parent().remove();
	$("#head-right-"+start).empty();
	$("#body-left-"+start).empty();
	$("#body-right-"+start).empty();
	
}

function openPageResult($table,$start) {
	
	if ( !$("#body-right-"+$start+" > ul")[0] ) {
		$input_search = $("input[id=input-search-"+$start+"]").val();
		$input_search = $input_search.replace(" ","%20");
		$input_search = $input_search.replace(" ","%20");
		$input_search = $input_search.replace(" ","%20");
		$input_search = $input_search.replace(" ","%20");
		$("#input-search-"+$start).attr("readonly",true);
		if ( $input_search !== "" ) {
			animationAjax("#msg-"+$start);
			$ul = $("<ul>").load("include/action_result.php?input-start="+$start+"&input-search="+$input_search+"&data-table="+$table);
			$("#body-right-"+$start).append($ul);
		} else {
			alert("Insert a search");
			$("#input-search-"+$start).attr("readonly",false);
		}
	} else {
		if ( confirm("New Search") == true ) {
			$("input[id=input-search-"+$start+"]").val("");
			$("#body-right-"+$start).empty();
			$("#input-search-"+$start).attr("readonly",false);
		}
	}
	
}

function openSubmitChecked(start) {
	
	if ( confirm("Display the result") == true ) {
		$("#body-right-"+start+" > ul input:checked").each(function(){
			alert($(this).val());
		});
	}
	
}

function openInputChecked(start) {
	
	if ( $("#body-right-"+start+" > ul input:checked")[0] ) {
		$button2 = $("<button>").attr("id","button2-search-"+start).width(80).height(25).attr("type","button").attr("name",start).text("Button2").attr("onclick","openSubmitChecked(name)");
		$button3 = $("<button>").attr("id","button3-search-"+start).width(80).height(25).attr("type","button").attr("name",start).text("Button3").attr("onclick","openSubmitChecked(name)");
		if ( !$("#button2-search-"+start)[0] ) {
			$("#head-right-"+id+" > ul").append($("<li>").css("display","inline-block").css("padding","0 1px").append($button2),$("<li>").css("display","inline-block").css("padding","0 1px").append($button3));
		}
	} else {
		$("#button2-search-"+start).parent().remove();
		$("#button3-search-"+start).parent().remove();
	}
	
}