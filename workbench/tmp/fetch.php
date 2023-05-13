// SELECT * FROM `INNODB_SYS_TABLES` where name = "theatre/advertisers";
// SELECT name FROM `INNODB_SYS_COLUMNS` where table_id = innodb_sys_tables.table_id; /* 86; */

class Table{

  function GetColumns ($db, $Table) {

    $SQL = "SELECT * FROM information_schema.`INNODB_SYS_TABLES` where name = \"" . $db . "/" . $Table . "\";";
echo $SQL;
    $PDOLink = new PDO("mysql:host=localhost;dbname=" . $db . "", "root", "");

    if ( ($result = $PDOLink->prepare($SQL))===false )
    {
      printf("Invalid query: %s\nWhole query: %s\n", $PDOLink->error, $SQL);
      exit();
    }
    
    $MyRows = $PDOLink->fetchAll();

    $result=$PDOLink->affected_rows;
echo $result . "\n";
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

$i=0;
foreach ($Rows as $row){
  echo $row[$i++];
}
?>