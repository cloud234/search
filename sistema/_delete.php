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
				echo "<p >Delete</p >";
			echo "</div >";
		echo "</div >";
		echo "<div >";
			echo "<div style=\"padding-top:20px;\" >";
				echo "<table style=\"position:relative;left:250px;width:500px;text-align:center;\" >";
					echo "<tbody >";
						$open_query = mysqli_query($connection,"SHOW TABLES FROM search");
						while ( $row_query = mysqli_fetch_array($open_query) ) {
							echo "<tr >";
								echo "<td style=\"width:350px;padding:3px 0;\" >";
										echo "<span >".htmlspecialchars($row_query[0])." - ".openCountTable($row_query[0])."</span >";
								echo "</td >";
								echo "<td style=\"width:150px;padding:3px 0;\" >";
									echo "<ul >";
										echo "<li style=\"display:inline-block;padding:0 5px;\" >";
											echo "<span class=\"link-button\" onclick=\"openDeleteIndex('index-clean','".htmlspecialchars($row_query[0])."')\" >Clean</span >";
										echo "</li >";
										echo "<li style=\"display:inline-block;padding:0 5px;\" >";
											echo "<span class=\"link-button\" onclick=\"openDeleteIndex('index-delete','".htmlspecialchars($row_query[0])."')\" >Delete</span >";
										echo "</li >";
									echo "</ul >";
								echo "</td >";
							echo "</tr >";
						}
					echo "</tbody >";
				echo "</table >";
			echo "</div >";
		echo "</div >";
		
		mysqli_close($connection);
		
	}
	
	function openButtonDelete($table) {
		
		// openButtonDelete
		
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
		
		mysqli_query($connection,"DROP TABLE $table");
		mysqli_close($connection);
		
		echo "<script type=\"text/javascript\">";
			echo "$(document).ready(function(){";
				echo "$(\"#inner-content\").empty();";
				echo "$(\"#inner-content\").load(\"_delete.php\");";
			echo "})";
		echo "</script>";
		
	}
	
	function openButtonClean($table) {
		
		// openButtonClean
		
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
		
		mysqli_query($connection,"DELETE FROM $table");
		mysqli_close($connection);
		
		echo "<script type=\"text/javascript\">";
			echo "$(document).ready(function(){";
				echo "$(\"#inner-content\").empty();";
				echo "$(\"#inner-content\").load(\"_delete.php\");";
			echo "})";
		echo "</script>";
		
	}
	
	function openCountTable($table) {
		
		// openCountTable
		
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
		
		$open_query = mysqli_query($connection,"SELECT count(*) AS 'full_records' FROM $table");
		$row_query = mysqli_fetch_array($open_query);
		$count = $row_query['full_records'];
		return $count;
		
		mysqli_close($connection);
		
	}
	
	$table = isset($_GET['data-table']) ? addslashes($_GET['data-table']) : "";
	$start = isset($_GET['input-start']) ? addslashes($_GET['input-start']) : "";
	
	if ( !isset($_GET['index-query']) ) {
		openIndexList();
	}
	if ( isset($_GET['index']) ) {
		if ( $_GET['index'] == "index-delete" ) {
			openButtonDelete($table);
		}
		if ( $_GET['index'] == "index-clean" ) {
			openButtonClean($table);
		}
	}

?>