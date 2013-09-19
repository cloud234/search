<?php

	ini_set("memory_limit","32M");
	ini_set("max_execution_time","300");
	ini_set("mysql.connect_timeout","90");

	session_start();

?>
<?php

	if ( (isset($_SESSION['code-key-1'])) && (isset($_SESSION['code-key-2'])) && ($_SESSION['code-key-1'] == $_SESSION['code-key-2']) ) {
	} elseif ( basename($_SERVER['SCRIPT_FILENAME']) == basename(__FILE__) ) {
		exit( header("location: http://127.0.0.1/Search/logout.php") );
	}
	
?>
<?php

	if ( (isset($_SESSION['id-auth-1'])) && (isset($_SESSION['id-auth-2'])) && ($_SESSION['id-auth-1'] == $_SESSION['id-auth-2']) ) {
		if ( (isset($_SESSION['name-auth-1'])) && (isset($_SESSION['name-auth-2'])) && ($_SESSION['name-auth-1'] == $_SESSION['name-auth-2']) ) {
		} elseif ( basename($_SERVER['SCRIPT_FILENAME']) == basename(__FILE__) ) {
			exit( header("location: http://127.0.0.1/Search/logout.php") );
		}
	} elseif ( basename($_SERVER['SCRIPT_FILENAME']) == basename(__FILE__) ) {
		exit( header("location: http://127.0.0.1/Search/logout.php") );
	}
	
?>
<?php

	$start = isset($_GET['input-start']) ? addslashes($_GET['input-start']) : "";
	$search = isset($_GET['input-search']) ? addslashes($_GET['input-search']) : "";
	$table = isset($_GET['data-table']) ? addslashes($_GET['data-table']) : "";
	
	$hostname = "localhost";
	$username = "root";
	$password = "";
	$database = "search";
	$connection = mysqli_connect($hostname,$username,$password);
	$database_selected = mysqli_select_db($connection,$database);
	if ( !$connection ) {
		echo "<p>Could not connect to MYSQL.</p>";
		echo "<p>MySQL Error: " .mysqli_connect_error()."</p>";
	}
	if ( !$database_selected ) {
		echo "<p>Could not connect to DATABASE.</p>";
		echo "<p>MySQL Error: " .mysqli_connect_error()."</p>";
	}
	
	$search = str_ireplace(" ","_",$search);
	if ( !mysqli_query($connection,"CREATE TABLE $search (start varchar(10),url varchar(500))") ) {
		mysqli_query($connection,"DELETE FROM $search WHERE start='$start'");
	}

?>
<?php

	$search_replace = str_ireplace("_","+",$search);
	$curl_browser = "http://www.google.com.br/search?q=".$search_replace."&hl=pt-BR&start=".$start."&sa=N";
	$curl = @curl_init();
	@curl_setopt($curl,CURLOPT_URL,$curl_browser);
	@curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
	@curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	$curl_html = @curl_exec($curl);
	@curl_close($curl);
	
	$document_html = new DOMDocument;
	@$document_html->loadHTML($curl_html);
	$div_id = $document_html->getElementById("search");
	$href_search = $div_id->getElementsByTagName("a");
	
	for ( $x=0; $x<$href_search->length; $x++ ) {
		$href_result[] = $href_search->item($x)->getAttribute("href");
	}
	
	foreach ( $href_result as $href_url ) {
		if ( !strpos($href_url,"webcache") ) {
			if ( !strpos($href_url,"search") ) {
				$part = @pathinfo($href_url);
				$part1 = isset($part['dirname']) ? $part['dirname']."/" : " ";
				$part2 = isset($part['basename']) ? $part['basename'] : " ";
				$part3 = isset($part['extension']) ? ".".$part['extension'] : " ";
				$part4 = isset($part['filename']) ? $part['filename'] : " ";
				$access_link = $part1.$part2;
				$divide_link = explode("=",$access_link);
				$create_link = array($divide_link[1]);
				$result_link[] = implode(" ",$create_link);
			}
		}
	}
	
	foreach ( $result_link as $link ) {
		$link = str_ireplace("&sa","",$link);
		mysqli_query($connection,"INSERT INTO $search (start,url) VALUES ('$start','$link')");
	}
	
	echo $document_html->saveHTML();
	mysqli_close($connection);

?>