<?php require_once('../Connections/mysqli_connect.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['email'])) {
  $loginUsername=$_POST['email'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "username";
  $MM_redirectLoginSuccess = "../index.html";
  $MM_redirectLoginFailed = "login_fail.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_mysqli_connect, $mysqli_connect);
  	
  $LoginRS__query=sprintf("SELECT email, password, username FROM userdata WHERE email=%s AND password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $mysqli_connect) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'username');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
    <head>
        <meta charset="utf-8">
        <title></title>
        <meta name="viewport" content="width=device-width", inital-scale="1.0">
        <link href="../assets/css/login.css" rel="stylesheet" type="text/css">
    </head>

    <body>

        <header>
            <div class="brand-logo">
               <h1>Nexsosphere</h1> 
            </div>

            <nav>
                <ul>
                    <a href="/" class="nav-btn">Home</a>
                    <a href="/" class="nav-btn">About</a>
                    <a href="/" class="nav-btn">Contact</a>
                </ul>
            </nav>

        </header>


        <hero>
            <section id="hero">
                <div class="container hero-wrap">
                    <div class="quote-wrap">
                        <p> Lorem ipsum dolor sit amet consectetur, adipisicing elit. 
                            Numquam, eaque atque aut, similique expedita odit soluta vitae ut, 
                            aliquam veritatis deserunt ullam debitis vel doloribus iure reiciendis id eveniet quis!
                        </p>
                        <em>_Nexsis</em>
                    </div>
                    <div class="login-wrap">

                        <div class="login-wrap-box">

                            <div class="login-failed-title">
                                <h3>
                                    There is already an account with this username/email
                                    <p>Try retriving your account</p>
                                </h3>
                            </div>

                            <form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST" name="login">
                                <p>
                                    <label >Email address</label>
                                    <input type="text" name="email" placeholder="enter your fucking email">
                                </p>

                                <p>
                                    <div class="d-flex">
                                        <label >Password</label>
                                        <a href="index.php"> Forgot password ?</a>
                                    </div>
                                    <input type="password" name="password" placeholder="Enter your password">
                                </p>

                                <p>
                                <input type="submit" name="submit" class="btn-submit">
                                </p>
                                
                            </form>

                            <p class="not-regis">Not registered ?<a href="./signup.php" >Create Account</a></p>

                        </div>

                    </div>

                </div>
                <div class="container">
                    <div class="theme-switch-wrapper">
                        <label for="checkbox" class="theme-switch">
                            <input type="checkbox" id="checkbox">
                            <div class="slider round"></div>
                        </label>
                        <em>switch theme</em>
                    </div>
                </div>
            </section>
        </hero>
        <script src="../assets/js/main.js"></script>
    </body>


</html>