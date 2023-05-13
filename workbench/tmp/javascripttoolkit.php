function CRLF () {return "<br>";}

function q ($q) {return("\"" . $q . "\"");}

function escript() {echo"</script>\n";}

function script() {echo "\n<script language=\"javascript\">\n";}

function JumpTo ($Destination){
	print("window.location=" . q( $Destination) . ";\n");
}

function Alert ($t) {
  print("alert(" . q($t) . ");\n");
}

//
// try it out!
//

script();
Alert("Hi there!");
//JumpTo("http://yahoo.com");
escript();



