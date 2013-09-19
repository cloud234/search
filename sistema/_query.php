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
				echo "<p >Query</p >";
			echo "</div >";
		echo "</div >";
		echo "<div >";
			echo "<div style=\"text-align:center;padding-top:20px;\" >";
				echo "<ul >";
				$open_query = mysqli_query($connection,"SHOW TABLES FROM search");
				while ( $row_query = mysqli_fetch_array($open_query) ) {
					if ( !strstr($row_query[0],"res_") ) {
						echo "<li style=\"padding:3px 1px;\" >";
							echo "<span class=\"link-span\" onclick=\"openQueryIndex('index-query','$row_query[0]')\" >".htmlspecialchars($row_query[0])."</span >";
						echo "</li >";
					}
				}
				echo "</ul >";
			echo "</div >";
		echo "</div >";
		
		mysqli_close($connection);
		
	}
	
	function openIndexIndex($table) {
		
		// openIndexIndex
		
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
				echo "<p >Query</p >";
			echo "</div >";
			echo "<div >";
			echo "<div style=\"text-align:center;padding-top:20px;\" >";
				echo "<span class=\"link-span\" onclick=\"openQueryReturn()\" >Return</span >";
			echo "</div >";
			echo "<div style=\"text-align:center;padding-top:5px;\" >";
				echo "<p >$table</p >";
			echo "</div >";
		echo "</div >";
		echo "<div >";
			echo "<div style=\"padding-top:5px;\" >";
				echo "<table style=\"width:1000px;\" >";
					$open_query = mysqli_query($connection,"SELECT start FROM $table GROUP BY start HAVING count(start) > 1");
					while ( $row_query = mysqli_fetch_array($open_query) ) {
						echo "<tbody \" >";
							echo "<tr id=\"head-".htmlspecialchars($row_query['start'])."\" style=\"vertical-align:middle;\" >";
								echo "<td id=\"head-left-".htmlspecialchars($row_query['start'])."\" style=\"width:500px;\" >";
									echo "<ul style=\"display:inline-block;\" >";
										echo "<li style=\"display:inline-block;padding:3px 1px;\" >";
											echo "<button style=\"height:25px;\" type=\"button\" onclick=\"openPageIndex('index-result','$table','$row_query[start]')\" >".htmlspecialchars($row_query['start'])."</button >";
										echo "</li >";
									echo "</ul >";
									echo "<div id=\"msg-".htmlspecialchars($row_query['start'])."\" style=\"display:inline-block;position:relative;left:270px;\" >";
								echo "</td >";
								echo "<td id=\"head-right-".htmlspecialchars($row_query['start'])."\" style=\"width:500px;\" >";
								echo "</td >";
							echo "</tr >";
							echo "<tr id=\"body-".htmlspecialchars($row_query['start'])."\" style=\"vertical-align:baseline;\" >";
								echo "<td id=\"body-left-".htmlspecialchars($row_query['start'])."\" style=\"width:500px;\" >";
								echo "</td >";
								echo "<td id=\"body-right-".htmlspecialchars($row_query['start'])."\" style=\"width:500px;\" >";
								echo "</td >";
							echo "</tr >";
						echo "</tbody >";
					}
				echo "</table >";
			echo "</div >";
		echo "</div >";
		
		mysqli_close($connection);
		
	}
	
	function openIndexResult($table,$start) {
		
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
		
		echo "<ul >";
			$open_query = mysqli_query($connection,"SELECT * FROM $table WHERE start='$start'");
			while ( $row_query = mysqli_fetch_array($open_query) ) {
				echo "<li style=\"padding:3px 1px;\" >";
					echo "<span class=\"link-span\" data=\"".htmlspecialchars($row_query['url'])."\" onclick=\"openQueryLink(this)\" >".htmlspecialchars(wordwrap($row_query['url'],60,"</br>")."</span >";
				echo "</li >";
			}
		echo "</ul >";
		
		echo "<script type=\"text/javascript\">";
			echo "$(document).ready(function(){";
				echo "start = $start;";
				echo "if ( start == \"0\" ) {";
					echo "start = \"00\";";
				echo "}";
				echo "button = $(\"<button>\").attr(\"id\",\"button1-search-\"+start).width(80).height(25).attr(\"type\",\"button\").attr(\"name\",start).attr(\"onclick\",\"openPageResult('$table',start)\").text(\"Search\");";
				echo "input = $(\"<input>\").attr(\"id\",\"input-search-\"+start).attr(\"type\",\"text\").attr(\"name\",start).css(\"width\",\"150px\").css(\"height\",\"19px\").css(\"color\",\"#BA1E28\").css(\"text-align\",\"center\").css(\"padding\",\"2px 5px\").css(\"border\",\"1px solid #BA1E28\").css(\"outline\",\"none\");";
				echo "li_button = $(\"<li>\").css(\"display\",\"inline-block\").css(\"padding\",\"0 1px\").append(button);";
				echo "li_input = $(\"<li>\").css(\"display\",\"inline-block\").css(\"padding\",\"0 1px\").append(input);";
				echo "ul = $(\"<ul>\").attr(\"id\",\"ul-head-left-\"+start).css(\"text-align\",\"center\").append(li_button,li_input);";
				echo "$(\"#head-right-\"+start).append(ul);";
			echo "});";
		echo "</script >";
		
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
			openIndexIndex($table);
		}
		if ( $_GET['index'] == "index-result" ) {
			openIndexResult($table,$start);
		}
	}

?>