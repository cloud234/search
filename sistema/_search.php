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

	echo "<div style=\"text-align:center;padding-top:8px;\" >";
		echo "<ul style=\"padding-top:2px;\" >";
			echo "<li style=\"display:inline-block;padding:0 1px;\" >";
				echo "<button style=\"width:70px;height:25px;\" type=\"button\" value=\"Start\" onclick=\"openStart(this)\" >Start</button >";
			echo "</li >";
			echo "<li style=\"display:inline-block;padding:0 1px;\" >";
				echo "<input style=\"width:250px;height:19px;\" id=\"input-search\" type=\"text\" autofocus />";
			echo "</li >";
			echo "<li style=\"display:inline-block;padding:0 1px;\" >";
				echo "<button style=\"width:70px;height:25px;\" type=\"button\" value=\"Clear\" onclick=\"openClean(this)\" >Clear</button >";
			echo "</li >";
		echo "</ul >";
		echo "<ul style=\"padding-top:2px;\" >";
			echo "<li style=\"display:inline-block;padding:0 1px;\" >";
				echo "<button style=\"width:30px;height:25px;outline:none;\" type=\"button\" value=\"<\" onclick=\"openPrevious(this)\" ><</button >";
			echo "</li >";
			echo "<li style=\"display:inline-block;padding:0 1px;\" >";
				echo "<input style=\"width:70px;height:19px;\" id=\"input-start\" type=\"text\" />";
			echo "</li >";
			echo "<li style=\"display:inline-block;padding:0 1px;\" >";
				echo "<button style=\"width:30px;height:25px;outline:none;\" type=\"button\" value=\">\" onclick=\"openNext(this)\" >></button >";
			echo "</li >";
		echo "</ul >";
	echo "</div >";
	echo "<div id=\"msg-search\" style=\"height:15px;text-align:center;\" >";
        echo "</div >";
	echo "<div style=\"position:relative;\" id=\"content-search\" >";
	echo "<div >";

?>