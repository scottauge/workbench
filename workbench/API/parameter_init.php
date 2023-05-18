//
// Create a drop down list with data initialized from parameter
//

include_once "c:/tmp/Renderhtmltoolkit.php";
include_once "c:/tmp/incdb.php";

class HtmlWidget extends RenderHtmlWidget {

  var $Widget;
  var $Conn;

  // Pass in a database connection
  public function __construct ($Connection) {
    $this->Conn=$Connection;
  }

  // Construct a drop down with a where

  function db_Select($S, $W) {

    $V = $this->Select($S) . $this->CR();

    $SQL=AforEach($S,"Title='$W'");

    $Result=ApplySQL($this->Conn, $SQL);
    while($row=$Result->fetch_assoc()) {

      $j=$this->NumEntries($row["Text"]);
      $i=1;
      while ($i<=$j) {
        $V .= $this->addoption($this->Entry($row["Text"],$i)) . $this->CR();
        $i++;
      }

    } // while

    $V .= $this->eSelect() . $this->CR();

    return $V;

  } // function db_select

  // simple db doc

  function db_Render ($W) {

    $V = "";

    $SQL=AforEach("parameter","Title='$W'");
    $Result=ApplySQL($this->Conn, $SQL);
    while($row=$Result->fetch_assoc()) {
      $tmp=$row['Text'];
      $V .= $tmp;
    }
    $V .= $this->CR();
    return $V;
  }

  function db_Radio($Name, $W) {

    $V="";
    $SQL=AforEach("parameter","Title='$W'");

    $Result=ApplySQL($this->Conn, $SQL);
    while($row=$Result->fetch_assoc()) {

      $j=$this->NumEntries($row["Text"]);
      $i=1;
      while ($i<=$j) {
        $V .= $this->Entry($row["Text"],$i);
        $V .= $this->Radio($Name, $this->Entry($row["Text"],$i));
        $V .= $this->CR();
        $i++;
      }

    } // while

    return $V;

  } // function db_Radio()

  function db_TextInput($Name, $Size, $W) {

    $V="";
    $SQL=AforEach("parameter","Title='$W'");

    $Result=ApplySQL($this->Conn, $SQL);
    while($row=$Result->fetch_assoc()) {
        $V .= $this->TextInput($Name, $row["Text"], $Size);
    } // while

    return $V;

  }
  
  function db_Button($Name) {
    $V=$this->Button($Name);
    return $V;
  }
  
  function db_Hidden($Name, $W) {
    
    $V="";
    $SQL=AforEach("parameter","Title='$W'");

    $Result=ApplySQL($this->Conn, $SQL);
    while($row=$Result->fetch_assoc()) {
        $V .= $this->Hidden("name", $this->Hidden($Name, $row["Text"]));
    } // while

    return $V;
    
  }
  
  function NumEntries($a) {

    $an = explode (',', $a);
    return count($an);
  }

  function Entry($h, $n) {

    $n--;

    $hn=explode("," , $h);

    return $hn[$n];

  }  

} // class HtmlWidget



$L["Host"]="localhost";
$L["User"]="root";
$L["Password"]="";
$L["DB"]="background";

$Conn = Aconnect($L);

$Parameter = new HtmlWidget ($Conn);

echo $Parameter->form("a", "get");
echo $Parameter->CRLF();
echo $Parameter->CR();
echo $Parameter->db_Select("parameter", "Test");
echo $Parameter->CRLF();
echo $Parameter->CR();
echo $Parameter->db_TextInput("name", 20, "Test");
echo $Parameter->CRLF();
echo $Parameter->CR();
echo $Parameter->db_Render("Test");
echo $Parameter->CRLF();
echo $Parameter->CR();
echo $Parameter->db_Radio("scott", "Test");
echo $Parameter->CRLF();
echo $Parameter->CR();
echo $Parameter->Checkbox("id", "name", "");
echo $Parameter->CRLF();
echo $Parameter->CR();
echo $Parameter->Submit("Go");
echo $Parameter->CRLF();
echo $Parameter->CR();
echo $Parameter->Button("Nothing");
echo $Parameter->CR();

echo $Parameter->Hidden("name", "Test");
echo $Parameter->CR();
echo $Parameter->eform();

Adisconnect($Conn);
