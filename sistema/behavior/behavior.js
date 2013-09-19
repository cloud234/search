// JavaScript Document

$(document).ready(function(){
	
	$_search = $("<li>").append($("<span>").attr("id","index-search").text("Search"));
	$_query = $("<li>").append($("<span>").attr("id","index-query").text("Query"));
	$_result = $("<li>").append($("<span>").attr("id","index-result").text("Result"));
	$_delete = $("<li>").append($("<span>").attr("id","index-delete").text("Delete"));
	$_clear = $("<li>").append($("<span>").attr("id","index-clean").text("Clean"));
	$_logout = $("<li>").append($("<span>").attr("id","index-logout").text("Logout"));
	$ul = $("<ul>").append($_search,$_query,$_result,$_delete,$_clear,$_logout);
	$("#inner-header").append($ul);
	$("#content").append($("<div>").attr("id","msg-ajax").css("text-align","center").css("color","#BA1E28"));
	
});

$(document).ready(function(){
						   
	$("#index-search").click(function(){
		$("#inner-content").empty();
		$("#inner-content").load("_search.php");
	});
	$("#index-query").click(function(){
       	$("#inner-content").empty();
       	$("#inner-content").load("_query.php");
	});
	$("#index-result").click(function(){
       	$("#inner-content").empty();
       	$("#inner-content").load("_result.php");
	});
	$("#index-delete").click(function(){
       	$("#inner-content").empty();
       	$("#inner-content").load("_delete.php");
	});
	$("#index-clean").click(function(){
		$("#page").empty();
		$("#inner-content").empty();
	});
	$("#index-logout").click(function(){
		if ( confirm("Exit") == true ) {
			$(location).attr("href","../logout.php");
		}
	});
	
});

function openQueryIndex($index,$table) {
	
	$("#inner-content").empty();
	$("#inner-content").load("_query.php?index="+$index+"&input-table="+$table);
	
}

function openQueryReturn() {
	
	$("#inner-content").empty();
	$("#inner-content").load("_query.php");
	
}

function openQueryLink($tag) {
	
	$value = $($tag).attr("data");
	window.open($value);
	
}

function openResultIndex($index,$table) {
	
	$("#inner-content").empty();
	$("#inner-content").load("_result.php?index="+$index+"&input-table="+$table);
	
}

function openResultReturn() {
	
	$("#inner-content").empty();
	$("#inner-content").load("_result.php?");
	
}

function openResultLink($tag) {
	
	$value = $($tag).attr("data");
	window.open($value);
	
}