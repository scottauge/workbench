// SELECT * FROM `INNODB_SYS_TABLES` where name = "theatre/advertisers";
// SELECT name FROM `INNODB_SYS_COLUMNS` where table_id = innodb_sys_tables.table_id; /* 86; */

class Table{

  function GetColumns ($db, $Table) {

    $SQL = "SELECT * FROM information_schema.`INNODB_SYS_TABLES` where name = \"" . $db . "/" . $Table . "\";";
//echo $SQL;
    $PDOConnection = "mysql:host=localhost;dbname=$db";
//echo "\n" . $PDOConnection . "\n";

    $PDOlink = new PDO($PDOConnection, "root", "");
//echo "Here\n";
    if ( ($result = $PDOlink->query($SQL))===false )
    {
      printf("Invalid query: %s\nWhole query: %s\n", $PDOLink->error, $SQL);
      exit();
    }

  // echo "\nThere\n";
    //$PDOlink
    $MyRows = $result->fetchAll();

    //$result1=$result->$affected_rows;
//echo $result . "\n";
    return $MyRows;

  } // function GetColumns()

  function Record () {

  } // function Record()

  function Set () {

  } // function Set()

} // class Table

?>
======
// main<br>
<?php
$Mydb = new Table();
$Rows = $Mydb->GetColumns("theatre", "advertisers");
?><pre><?php
var_dump($Rows);
?></pre>
/*
$i=0;
foreach ($Rows as $row){
  echo "\n";
  echo $i . "\n";
  echo "\nthere " . $row[0] . "\n";
}
*/


?>