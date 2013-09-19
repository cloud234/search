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

	function openIndexList() {
		
		// openIndexList
		
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
		
		echo "<div >";
			echo "<div style=\"text-align:center;text-shadow:0 1px rgba(186,30,40,0.2);padding-top:10px;\" >";
				echo "<p >Result</p >";
			echo "</div >";
		echo "</div >";
		echo "<div >";
			echo "<div style=\"padding-top:20px;\" >";
				echo "<ul style=\"text-align:center;\" >";
				$open_query = mysqli_query($connection,"SHOW TABLES FROM search");
				while ( $row_query = mysqli_fetch_array($open_query) ) {
					if ( strstr($row_query[0],"res_") ) {
						echo "<li style=\"padding:2px 1px;\" >";
							echo "<span class=\"link-span\" onclick=\"openResultIndex('index-query','$row_query[0]')\" >".htmlspecialchars($row_query[0])."</span >";
						echo "</li >";
					}
				}
				echo "</ul >";
			echo "</div >";
		echo "</div >";
		
		mysqli_close($connection);
		
	}
	
	function openIndexResult($table) {
		
		// openIndexResult
		
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
		
		echo "<div >";
			echo "<div style=\"text-align:center;text-shadow:0 1px rgba(186,30,40,0.2);padding-top:10px;\" >";
				echo "<p >Result</p >";
			echo "</div >";
			echo "<div style=\"text-align:center;padding-top:20px;\" >";
				echo "<span class=\"link-span\" onclick=\"openResultReturn()\" >Return</span >";
			echo "</div >";
			echo "<div style=\"text-align:center;padding-top:5px;\" >";
				echo "<p >$table</p >";
		echo "</div >";
		echo "<div >";
			echo "<div style=\"padding-top:5px;\" >";
				echo "<ul style=\"text-align:center;\" >";
				$open_query = mysqli_query($connection,"SELECT url FROM $table");
				while ( $row_query = mysqli_fetch_array($open_query) ) {
					if ( !strstr($row_query['url'],"res_") ) {
						echo "<li style=\"padding:2px 1px;\" >";
							echo "<span class=\"link-span\" data=\"".htmlspecialchars($row_query['url'])."\" onclick=\"openResultLink(this)\" >".htmlspecialchars($row_query['url'])."</span >";
						echo "</li >";
					}
				}
				echo "</ul >";
			echo "</div >";
		echo "</div >";
		
		mysqli_close($connection);
		
	}

?>
<?php

	$table = isset($_GET['input-table']) ? addslashes($_GET['input-table']) : "";
	$start = isset($_GET['input-start']) ? addslashes($_GET['input-start']) : "";
	
	if ( !isset($_GET['index']) ) {
		openIndexList();
	}
	if ( isset($_GET['index']) ) {
		if ( $_GET['index'] == "index-query" ) {
			openIndexResult($table);
		}
	}

?>