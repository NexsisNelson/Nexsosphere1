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

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="active_account.php";
  $loginUsername = $_POST['email'];
  $LoginRS__query = sprintf("SELECT email FROM userdata WHERE email=%s", GetSQLValueString($loginUsername, "text"));
  mysql_select_db($database_mysqli_connect, $mysqli_connect);
  $LoginRS=mysql_query($LoginRS__query, $mysqli_connect) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "sign_up")) {
  $insertSQL = sprintf("INSERT INTO userdata (first_name, last_name, email, phone_number, `date`, username, password) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['first_name'], "text"),
                       GetSQLValueString($_POST['last_name'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['phone_number'], "int"),
                       GetSQLValueString($_POST['date'], "date"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"));

  mysql_select_db($database_mysqli_connect, $mysqli_connect);
  $Result1 = mysql_query($insertSQL, $mysqli_connect) or die(mysql_error());

  $insertGoTo = "login.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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
                    <h1> Nexsosphere</h1>
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

                            <div class="login-title">
                                <h3>
                                    Sign Up
                                    <p>Sign up to be part of the next level of crypto trading </p>
                                </h3>
                            </div>

                            <form action="<?php echo $editFormAction; ?>" method="POST" name="sign_up" >
                                <p>
                                    <label >First Name</label>
                                    <input type="text" id="first_name" name="first_name" placeholder="enter your first name">
                                </p>
                                <p>
                                    <label >Last name </label>
                                    <input type="text" name="last_name" placeholder="enter your last name">
                                </p>
                                <p>
                                    <label >Email address</label>
                                    <input type="email"   name="email" placeholder="enter your fucking email">
                                </p>
                                <p>
                                    <label >Phone Number</label>
                                    <input type="text" name="phone_number" placeholder="enter your phone">
                                </p>
                                
                                <p>
                                    <label >Date of Birth</label>
                                    <input type="date"  name="date">
                                </p>

                                <p>
                                    <label >username</label>
                                    <input type="text" name="username" placeholder="enter a username">
                                </p>
                                <p>
                                    <label >Password</label>
                                    <input type="password" name="password" placeholder="Enter your password">
                                </p>
                                <p>
                                    <label >Confirm Password</label>
                                    <input type="password" placeholder=" confirm password">
                                </p>

                                <p>
                                    <input type="submit" name="signup" class="btn-submit">
                                </p>
                                <input type="hidden" name="MM_insert" value="sign_up">
                                
                            </form>

                            <p class="not-regis">Already have an account ?<a href="login.php">login</a></p>

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