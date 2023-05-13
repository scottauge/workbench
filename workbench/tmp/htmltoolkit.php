function CRLF () {return "<br>";}

function q ($q) {return("\"" . $q . "\"");}

function Select($name, $options) {
  echo "<select name=" . q($name) . ">";
}

function addoption($o) {echo "<option value=" . q($o) . ">" . $o . "</option>" ;}

function eSelect() {echo "</select>";}

function Submit($value) {echo "<input type=" . q("submit") . "value=" . q($value) . ">";}

function TextInput ($name, $value, $size) {
  echo("<input type=" . q("text") . " name=" . q($name) . " size=" . q($size) . " value=" . q($value) . ">") ;
}

function TextArea($name, $x, $y, $value){echo "<textarea name=" . q($name) . 
                                                       " rows=" . q($y) . 
                                                       " cols=" . q($x) . 
                                                       ">" . $value .
                                                       "</textarea" . ">";}

function form($name, $method) {echo "<form action=" . q($name) . " method=" . q($method) . ">";}

function eForm (){echo "</form>";}

function escript() {echo"</script>";}

function script() {echo "<script language=\"javascript\">";}

function JumpTo ($Destination) {
	//echo script();
	print("window.location=" . q( $Destination));
	//echo escript();
}

function Alert ($t) {
  print("alert(" . q($t) . ");");
}

//
// try it out!
//
/*
form("", "get");
select("scott" , "");
addoption("scott");
addoption("craig");
eselect();echo CRLF();
TextInput("a", "10", 10);
TextInput("b", "30", 30);echo CRLF();
TextArea("Name", 20, 10, "Hi there");
TextArea("Again", 10, 10, "Hi Again");
Submit("Send");
eform();
echo CRLF();
*/
script();
Alert("Hi there!");
//JumpTo("http://yahoo.com");
escript();



