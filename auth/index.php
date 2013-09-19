<?php

	ini_set("memory_limit","32M");
	ini_set("max_execution_time","300");
	ini_set("mysql.connect_timeout","90");

	session_start();

?>
<?php
	
	if ( (isset($_SESSION['code-key-1'])) && (isset($_SESSION['code-key-2'])) && ($_SESSION['code-key-1'] == $_SESSION['code-key-2']) ) {
		if ( (isset($_SESSION['id-auth-1'])) && (isset($_SESSION['id-auth-2'])) && ($_SESSION['id-auth-1'] == $_SESSION['id-auth-2'])  ) {
			if ( (isset($_SESSION['name-auth-1'])) && (isset($_SESSION['name-auth-2'])) && ($_SESSION['name-auth-1'] == $_SESSION['name-auth-2']) ) {
				exit( header("location: ../sistema/index.php") );
			} else {
				exit( header("location: http://127.0.0.1/Search/logout.php") );
			}
		} else {
			exit( header("location: http://127.0.0.1/Search/logout.php") );
		}
	}

?>
<?php
	
	function openSessionID($id) {
		
		global $session;
    	$car = "1234567890abcdefghijklmnopqrstuvwxyz";
    		for ( $i=1; $i<=$id; $i++ ) {
        		$session .= substr($car,rand(0,strlen($car)-1),1);
    		} 
    	return $session;
		
	}
	
	openSessionID(17);
	$_SESSION['compare-key-1'] = $session;
	$_SESSION['compare-key-2'] = $session;
	unset($session);
	
	$_SESSION['message-user'] = false;
	$_SESSION['message-password'] = false;
	$_SESSION['message-check'] = false;

?>
<?php

	function openCodeCheck($t) {
		
		global $keyid;
    	$car = "abcdefghijklmnopqrstuvwxyz";
    		for ( $i=1; $i<=$t; $i++ ) {
        		$keyid .= substr($car, rand(0, strlen($car) -1), 1);
				$_SESSION['keyid'] = $keyid;
    		} 
    	return $_SESSION['keyid'];
		
	}
	
	function openCreateCheck() {
		
		$keyid = openCodeCheck(5);
    	$img = ImageCreate(180,40);
		$font = "checks/outwrite.ttf";
    	$background = ImageColorAllocate($img,186,30,40);
    	$text = ImageColorAllocate($img,231,255,16);		
		$imgtext = Imagettftext($img,27,0,30,35,$text,$font,$keyid);
		//$rotation = Imagerotate($img,0,$background);
    	Imagepng($img,"checks/checks.png");
		ImageDestroy($img);
		unset($keyid);
		
	}
	
	if ( !isset($_POST['send-auth']) ) {
		openCreateCheck();
	}
	
?>
<?php
	
	function queryCheckAction() {
		
		switch ( isset($_POST['send-auth']) ) {
			case true:
				queryCheckImage();
			break;
			case false:
			break;
		}
		
	}
	
	function queryCheckImage() {
		
		switch ( !empty($_POST['check-auth']) ) {
			case true:
				switch ( $_SESSION['keyid'] == $_POST['check-auth'] ) {
					case true:
						queryCheckForm();
					break;
					case false:
						$_SESSION['message-check'] = "erro-check";
					break;
				}
			break;
			case false:
				$_SESSION['message-check'] = "null-check";
			break;
		}
		
	}
	
	function queryCheckForm() {
		
		$user = addslashes($_POST['user-auth']);
		$pass = addslashes($_POST['password-auth']);
		$pass = addslashes(sha1(md5($pass)));
		
		$hostname = "localhost";
		$username = "root";
		$password = "";
		$database = "auth";
		$connection = mysqli_connect($hostname,$username,$password);
		$database_selected = mysqli_select_db($connection,$database);
		if ( !$connection ) {
			echo "<p style=\"color:#222;\" >Could not connect to MYSQL.</p>";
			echo "<p style=\"color:#222;\" >MySQL Error: " .mysqli_connect_error()."</p>";
		}
		if ( !$database_selected ) {
			echo "<p style=\"color:#222;\" >Could not connect to DATABASE.</p>";
			echo "<p style=\"color:#222;\" >MySQL Error: " .mysqli_connect_error()."</p>";
		}
		$query = mysqli_query($connection,"SELECT * FROM auth WHERE user_auth='$user'");
		$row = mysqli_fetch_array($query);
		
		switch ( !empty($_POST['user-auth']) ) {
			case true:
				switch ( $user == $row['user_auth'] ) {
					case true:
						switch ( !empty($_POST['password-auth']) ) {
							case true:
								switch ( $pass == $row['password_auth'] ) {
									case true:
										$_SESSION['code-key-1'] = $_SESSION['compare-key-1'];
										$_SESSION['code-key-2'] = $_SESSION['compare-key-2'];
										$_SESSION['id-auth-1'] = $row['id_auth'];
										$_SESSION['id-auth-2'] = $row['id_auth'];
										$_SESSION['name-auth-1'] = $row['name_auth'];
										$_SESSION['name-auth-2'] = $row['name_auth'];
										header("location: ../sistema/index.php");
										unset($row,$query,$user,$pass);
										unset($_SESSION['compare-key-1'],$_SESSION['compare-key-2']);
									break;
									case false:
										$_SESSION['message-password'] = "erro-password";
									break;
								}
							break;
							case false:
								$_SESSION['message-password'] = "null-password";
							break;
						}
					break;
					case false:
						$_SESSION['message-user'] = "erro-user";
					break;
				}	
			break;
			case false:
				$_SESSION['message-user'] = "null-user";
			break;
		}
		mysqli_close($connection);
			
	}
	
	queryCheckAction();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml" >
<head >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title >Search</title >
<style type="text/css">
html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, font, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td {
    margin:0;
    padding:0;
    border:0;
}
ol, ul {
    list-style:none;
}
table {
    border-collapse:separate;
    border-spacing:0;
}
</style>
<style type="text/css">


/* Inner-HTML */

#body {
	overflow-y:scroll;
}
#wrapper {
	font-family:arial,verdana,sans-serif;
	font-size:14px;
}


/* Inner-Header */

#inner-header {
	height:70px;
	color:#fff;
	box-shadow:0 1px 15px rgba(186,30,40,0.5);
	background-color:#BA1E28;
}


/* Inner-Content */

#inner-content {
	position:relative;
	width:1000px;
	margin:0 auto;
	color:#FFFE10;
}
#inner-left {
	position:absolute;
	width:500px;
	height:30px;
	margin:30px 0px 0px 0px;
	border-radius:1px;
	box-shadow:0 1px 15px rgba(186,30,40,0.5);
	background-color:#BA1E28;
}
#inner-right {
	position:absolute;
	top:30px;
	left:548px;
	width:350px;
	height:360px;
	border-radius:1px;
	box-shadow:0 1px 15px rgba(186,30,40,0.5);
	background-color:#BA1E28;
}


/* Inner-Left */

#inner-left ul {
	text-align:center;
	padding-top:3px;
}
#inner-left li {
	display:inline;
	padding:0px 10px 0px 0px;
}
#inner-left a {
	color:#FFFE10;
	text-decoration:none;
}


/* Inner-Right */

#inner-right #legend-div h2,h3,h4 {
	display:inline-block;
	padding-top:20px;
	padding-left:42px;
}
#inner-right #user-div label {
	display:inline-block;
	padding-top:20px;
	padding-bottom:5px;
	padding-left:42px;
}
#inner-right #user-div input {
	width:250px;
	height:28px;
	color:#BA1E28;
	margin-left:42px;
	padding:0 10px;
	border-radius:1px;
	border:1px solid #BA1E28;
	outline:none;
}
#inner-right #user-div input:focus {
	border:1px solid #BA1E28;
}
#inner-right #user-div span {
	display:block;
	color:#FFFE10;
	font-size:14px;
	margin:10px 0px 0px 42px;
}
#inner-right #password-div label {
	display:inline-block;
	padding-top:20px;
	padding-bottom:5px;
	padding-left:42px;
}
#inner-right #password-div input {
	width:250px;
	height:28px;
	color:#BA1E28;
	margin-left:42px;
	padding:0 10px;
	border-radius:1px;
	border:1px solid #BA1E28;
	outline:none;
}
#inner-right #password-div input:focus {
	border:1px solid #BA1E28;
}
#inner-right #password-div span {
	display:block;
	color:#FFFE10;
	font-size:14px;
	margin:10px 0px 0px 42px;
}
#inner-right #check-div label {
	display:inline-block;
	font-weight:bold;
	padding-top:5px;
	padding-bottom:5px;
	padding-left:87px;
}
#inner-right #check-div img {
	width:180px;
	height:40px;
}
#inner-right #check-div input {
	width:200px;
	height:28px;
	color:#BA1E28;
	text-align:center;
	margin-left:67px;
	padding:0 10px;
	border-radius:1px;
	border:1px solid #BA1E28;
	outline:none;
}
#inner-right #check-div input:focus {
	border:1px solid #BA1E28;
}
#inner-right #check-div span {
	display:block;
	color:#FFFE10;
	font-size:14px;
	text-align:center;
	margin-top:10px;
}
#inner-right #submit-div label {
}
#inner-right #submit-div input {
	width:110px;
	height:28px;
	color: #FFFE10;
	font-weight:bold;
	margin:10px 0px 0px 122px;
	border: 1px solid #FFFE10;
	border-radius:1px;
	outline:none;
	background-color: #BA1E28;
}
</style>
</head >
<body id="body" >
	<div id="wrapper" >
      <div id="header" >
            <div id="inner-header" >
            </div >
        </div >
        <div id="content" >
            <div id="inner-content" >
            	<div id="inner-left" >
                    <ul >
                        <li ><a href="http://search-cloud234.rhcloud.com/" >Search</a ></li >
                        <li ><a href="http://search-cloud234.rhcloud.com/" >Search</a ></li >
                        <li ><a href="http://search-cloud234.rhcloud.com/logout.php" >Logout</a ></li >
                    </ul >
                </div >
                <div id="inner-right" >
                    <form method="post" name="cadastro" action="<?php $_SERVER['PHP_SELF']; ?>" >
                    	<div id="legend-div" >
                    		<h3 >Login</h3 >
                        </div >
                        <div id="user-div" >
                            <label ><strong >Nome de usu&aacute;rio</strong ></label>
                            <input type="text" name="user-auth" id="user-auth" /><br />
                            <?php
                                if ( $_SESSION['message-user'] == "null-user" ) {
                                    echo "<span >"; echo "Digite o seu nome de usu&aacute;rio"; echo "</span >";
                                } elseif ( $_SESSION['message-user'] == "erro-user" ) {
                                        echo "<span >"; echo "Nome de usu&aacute;rio incorreto"; echo "</span >";
                                }
                            ?>
                        </div >
                        <div id="password-div" >
                            <label ><strong >Senha</strong ></label >
                            <input type="password" name="password-auth" id="password-auth" /><br />
                            <?php
                                if ( $_SESSION['message-password'] == "null-password" ) {
                                    echo "<span >"; echo "Digite uma senha"; echo "</span >";
                                } elseif ( $_SESSION['message-password'] == "erro-password" ) {
                                        echo "<span >"; echo "Senha incorreta"; echo "</span >";
                                }
                            ?>
                        </div >
                        <div id="check-div" >
                            <?php
                                if ( $_SESSION['message-check'] == "null-check" ) {
                                    echo "<span >"; echo "Digite o c&oacute;digo de verifica&ccedil;&atilde;o"; echo "</span >";
                                } elseif ( $_SESSION['message-check'] == "erro-check" ) {
                                        echo "<span >"; echo "C&oacute;digo de verifica&ccedil;&atilde;o incorreto"; echo "</span >";
                                }
                            ?>
                            <label ><img src="checks/checks.png" /></label >
                            <input type="text" name="check-auth" id="check-auth" /><br />
                        </div >
                        <div id="submit-div" >
                            <input type="submit" name="send-auth" id="send-auth" value="Login" />
                        </div >
                    </form >
                </div >
            </div >
        </div >
        <div id="footer" >
            <div id="inner-footer" >
            </div >
		</div >
    </div >
</body >
</html >