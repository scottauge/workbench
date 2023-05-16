<?php
//
// Using arrays as Files
//
// "Table"  - the table name - required
// "RecID" - unique indentifier for record - required
// "?" - A Field in Table
// How to create? - done
// How to insert? - done
// How to delete? - done
// How to update? - done
// How to display? - done
// How to make a record ID? - done
// true/false to 1/0 SQLBool()? - done
// nl to out nlout() - done
// out() - done

function nlout($a) {
  print($a . "<br>");
}

// SQLbool
function SQLBool ($l) {
  $l=($l == true) ? 1 : 0;
  return $l;
}
  

// create a table array from db, else they just need to know the tables

function CrtStruct($TableName) {
  return $A;
}

// Create a record ID

function CrtRecID($Size) {
  return date_format(date_create(), "YzHis.u");
}

// Display the record

function DispRecord($a) {
  foreach($a as $key => $value)
  {
    $value=str_replace("'","", $value);  // get rid of ' for strings
    out($key . " : ". $value . "<br>");
  }
} // DispRecord

// Connect to db - places connection into Login ["conn"]

function AConnect($Login){

  $Login["conn"] = new mysqli($Login["Host"], $Login["User"], $Login["Password"], $Login["DB"]);
  return $Login;

} // AConnect()

// Disconnect from db

function ADisconnect($Login) {
  $Login["conn"]->close();
  $Login["conn"]="closed";
  return $Login;
}

// Various ops needed

function Create ($Conn, $Record) {
   return AInsert($Conn, $Record);
}

function AInsert($Conn, $Record) {

  $cols="";
  $values=$cols;
  $SQL = "INSERT INTO " . $Record["TableName"] . " (_cols) VALUES (_values);";

  //return $SQL;

 foreach($Record as $key => $value)
  {
    // Part of record structure, not record
    if ($key == "TableName") continue;

    $cols .= $key . ", ";

    if(is_string($value)) 
      $values .= "'" . $value . "', ";
    else
      $values .= $value . ", ";
 
  }

  $cols=substr($cols,0, strlen($cols)-2);
  $values=substr($values,0,strlen($values)-2);
 
  $SQL = str_replace("_cols", $cols, $SQL);
  $SQL = str_replace("_values", $values, $SQL);
  return $SQL;

} // AInsert()

function ADelete($Conn, $Record) {

  $W="";
  $SQL="DELETE FROM " . $Record["TableName"] . " WHERE _where";

  foreach($Record as $key => $value) {
    if ($key=="RecID") continue;
    if ($key=="TableName") continue;
    if ($key == "Active") continue;

    if(!is_string($value)) 
      $W .= $key . "=" . $value . " ";
    else
      $W .= $key . "='" . $value . "' ";
  }

  $SQL=str_replace("_where", $W, $SQL) . ";";
  return $SQL;

}  // ADelete()

function AUpdate($Conn, $Record, $PrevRecord) {

  $SQL = "UPDATE " . $Record["TableName"] . " SET _equals" . " WHERE _where";
  $c="";

  // _equals section
  foreach($Record as $key => $value) {

    if($key == "TableName") continue;

    if(is_string($value))
      $c .= $key . "= '" . $value . "', ";
    else
      $c .= $key . "=" . $value . ", ";
  }
  $c=substr($c, 0, strlen($c) - 2);

  $SQL=str_replace("_equals", $c, $SQL);

  // _where section
  $c='';
  foreach($PrevRecord as $key => $value) {

    if($key == "TableName") continue;

    if(is_string($value))
      $c .= $key . "= '" . $value . "' and ";
    else
      $c .= $key . "=" . $value . " and ";
  }
  $c=substr($c, 0, strlen($c) - 5);
  //nlout($c);
  $SQL=str_replace("_where", $c, $SQL) . ";";

  return $SQL;

} // AUpdate()


function AFind($Conn, $Record) {

} // AFind()

function AForEach($Record, $Where) {
  
  $SQL="select * from " . $Record;
  if($Where != "") $SQL .= " where " . $Where;
  return $SQL;

} // AForEach

function ShowColumns($Table)  {
  $sql="SHOW COLUMNS FROM " . $Table;
  return $sql;
}

function ApplySQL($Conn, $SQL) {

  $Result=$Conn["conn"]->query($SQL);
  return $Result;

}

function BeginTransaction($Connection) {
  $Connection["conn"]->begin_transaction();
}

function CommitTransaction($Connection) {
  $Connection["conn"]->commit();
}

function RollbackTransaction($Connection) {
  $Connection["conn"]->rollback();
}

?>