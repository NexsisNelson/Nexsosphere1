<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_mysqli_connect = "localhost";
$database_mysqli_connect = "accounts";
$username_mysqli_connect = "root";
$password_mysqli_connect = "";
$mysqli_connect = mysql_pconnect($hostname_mysqli_connect, $username_mysqli_connect, $password_mysqli_connect) or trigger_error(mysql_error(),E_USER_ERROR); 
?>