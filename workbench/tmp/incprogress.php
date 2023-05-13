<?php
// Needs dosql.php!

//
// boolean to string
//

function BtoS($l) {return ($l == true) ? "true" : "false"; }

//
// Debugging
//

function Debug($Msg) {
	return;
  if ($Msg != "") 
	  print("Debug() " . $Msg ."<br>");
  else
    print("<br>");
}

// --------------------------------------------------------------------------------------
// The following are meant to imitate the 4gl as best as we can with SQL statements.
// --------------------------------------------------------------------------------------

//
// CanFind()
//

function CanFind($sql) {

  global $FoundIt;

  $sql = "select * from " . $sql . " limit 1";
  Debug("CanFind() " . $sql);
  DoSQL($sql, "FoundIt");

  return $FoundIt;

}

function FoundIt($row) {

  global $FoundIt;
  
  $FoundIt=false;
  if($row) $FoundIt=true;
  return $FoundIt;
  
}

//
// Create ("tablename (fields) values (values)")
// Create("session () values ()");
//

function Create ($sql) {
	
	$sql = "insert into " . $sql;
	Debug('Create() ' . $sql);
	DoSQL($sql, "EmptyJSR");
	
}

function EmptyJSR($row){
	return;
}

//
// Set up a for each into a select
//

function For_Each($sql) {
  
  Debug("1 " . $sql);
  $sql  = "select * from " . $sql;
  DoSQL($sql, "ViewForEach");
  Debug("2 " . $sql);
	
}

function ViewForEach($r) {
  var_dump($r);
  Debug("<br>CValue=" . $r["CValue"]);
  }

//
// Try to do a find no next or prev yet!
//

function Find($sql) {	

  $sql = "select  * from " . $sql . " limit 1";
  Debug('Find() ' . $sql);
  DoSQL($sql, "fiblock");

	
}

function fiblock ($row) {
  Debug("fiblock()");
	var_dump($row);
  Debug("<br>CValue = " . $row["CValue"]);
  
}


function Delete ($sql) {
	$sql = "delete from " . $sql;
	Debug('Delete() ' . $sql);
	DoSQL($sql, "EmptyJSR");

}
?>





