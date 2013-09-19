<?php

	ini_set("memory_limit","32M");
	ini_set("max_execution_time","300");
	
	header("HTTP/1.1 301 Moved Permanently");
	header("location: auth/");

?>