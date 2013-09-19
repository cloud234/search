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
	
	$search_replace = str_ireplace(" ","_",$search);
	if ( !mysqli_query($connection,"CREATE TABLE res_$search_replace (start varchar(10),url varchar(500))") ) {
		mysqli_query($connection,"DELETE FROM res_$search_replace WHERE start='$start'");
	}
	if ( $query = mysqli_query($connection,"SELECT * FROM $table WHERE start='$start'") ) {
		while ( $row_query = mysqli_fetch_array($query) ) {
			openSearch($row_query['url'],$start,$search_replace);
		}
	}

?>
<?php

	function openSearch($url,$start,$search_replace) {
		
		// openSearch
		
		$curl = @curl_init();
		@curl_setopt($curl,CURLOPT_URL,$url);
		@curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
		@curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
		$curl_html = @curl_exec($curl);
		@curl_close($curl);
		
		$explode = explode("_",$search_replace);
		$part1 = isset($explode['0']) ? $explode['0'] : " ";
		$part2 = isset($explode['1']) ? $explode['1'] : " ";
		$part3 = isset($explode['2']) ? $explode['2'] : " ";
		$part4 = isset($explode['3']) ? $explode['3'] : " ";
		if ( !empty($part1) && !empty($part2) && !empty($part3) && !empty($part4) ) {
			if ( stristr($curl_html,$part1) && stristr($curl_html,$part2) && stristr($curl_html,$part3) && stristr($curl_html,$part4) ) {
				mysqli_query($GLOBALS['connection'],"INSERT INTO res_$search_replace (start,url) VALUES ('$start','$url')");
				echo "<li style=\"padding:2px 1px;\" >";
					echo "<input type=\"checkbox\" value=\"".htmlspecialchars($url)."\" onclick=\"openInputChecked('$start')\" >";
					echo "<label >";
						echo "<span class=\"link-span\" data=\"".htmlspecialchars($url)."\" onclick=\"openQueryLink(this)\" >".htmlspecialchars(wordwrap($url,60,"</br>"))."</span >";
					echo "</label >";
				echo "</li >";
			}
		}
		
	}
	
	mysqli_close($connection);

?>