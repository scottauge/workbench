// Include at the beginning of all your pages.  You will need to set up a login page
// or an error page.

// Login in the cookie?

function Login($User, $Passwrd, $Cookie) {

  $UserID=$_REQUEST["UserID"];
  $Password=$_REQUEST["Password"];
  $Cookie=$_REQUEST["Login"];

  // IF no cookie value, make one
  if(!isset($Cookie) || $Cookie=="") $Cookie=CalcCookieValue (30);

  

} // Login ()

function Logout ($Cookie) {

  

} // Logout()

// Is the cookie logged in?

function IsLoggedIn($Cookie) {

  if can-find("session where Session.Cookie = \'$(COOKIE[\'Login\']\'") return true;
  return false;

} // IsLoggedin()

function CalcCookieValue ($length) {
  $R="";
  $Alphabet = "ABCDEFGHJIKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

  for($i=0; $i<$length; $i++)
    $R .= substr($Alphabet, random_int(1,strlen($Alphabet)), 1);

  return $R;
}