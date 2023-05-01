
<html>
<body>

<!--

/**************************************************************************
MIT License

Copyright (c) 2021 Scott Auge

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
**************************************************************************/
-->

<pre>
TODO:

-- Add _Locked/Locked() and "select...for update" but one might want to do
   that by the programmer?

CHANGES:

-- Added KeyField prompt so not dependent on a given name
-- Added Available() function to determine if a FindBy actually found the record
-- Remove slashes used to escape data coming into the DB in Update().  Using parameterized
   SQL means the slashes are taken as part of the data, not as metadata characters.
-- After Create() call FindByID() in case the RDBMS has defaults defined so we load them
   up properly.
-- Added ambiguous support.

NOTES:

-- This may be "busy" compared to using SQL statements, however, it does encapsulate all
   the data so one can make changes in one spot.  Programmer time v machine time.

$Id: TableClass.php 16 2012-03-09 10:09:43Z scott_auge $
$URL: file:///users/scott_auge/svn_tools/TableClass.php $
</pre>
<?php

date_default_timezone_set("America/Detroit");

//  --------------------------------------------------------------------
//  Connection to database
//  --------------------------------------------------------------------

if (!empty($_REQUEST) && $_REQUEST["Action"] == "Generate") {
  $Host = $_REQUEST["Host"];
  $User = $_REQUEST["User"];
  $Password = $_REQUEST["Password"];
  $Database = $_REQUEST["Database"];

} else {
  $Host = "localhost";
  $User = "youracct";
  $Password = "youracct";
  $Database = "yourdb";
}
//  --------------------------------------------------------------------
//  Table we want to make class for
//  --------------------------------------------------------------------

if (!empty($_REQUEST) && $_REQUEST["Action"] == "Generate") {
  $TableName = $_REQUEST["TableName"];
  $PrimaryField = $_REQUEST["PrimaryField"];
}
else {
  $TableName = "yourtable";
  $PrimaryField = "yourfield";
}

//  --------------------------------------------------------------------
//  End Configuration Code
//  --------------------------------------------------------------------


?>

<form action="" method="post">
  <input name="Action" value="Generate" type="hidden" />
  <p> Table Name:
    <input name="TableName" type="text" value="<?php print ($TableName) ?>" />
  </p>
  <p> Key Field:
    <input name="PrimaryField" type="text" value="<?php print ($PrimaryField) ?>" />
  </p>
   <p><font color="red">If your table does not have a unique primary field, this will not work.</font>
  </p> 
  <p>Connection:
    <input name="Host" type="text" id="Host" value="<?php print ($Host) ?>" />
    <input name="User" type="text" id="User" value="<?php print ($User) ?>" />
    <input name="Password" type="text" id="Password" value="<?php print ($Password) ?>" />
    <input name="Database" type="text" id="Database" value="<?php print ($Database) ?>" />
  </p>
  <p>
    <input type="submit" name="Submit" value="Generate" />
  </p>
</form>
<?php

if (!empty($_POST)) {
$Connection = new mysqli ($Host, $User, $Password, $Database);
$SQL = "show columns from " . $TableName;
$S = $Connection->prepare($SQL);
$S->bind_result($Field, $Type, $Null, $Key, $Default, $Extra);
$S->execute();

$IsAutoIncrement = false;
while ($S->fetch()) {

  $FieldList[] = $Field;
  $TypeList[] = $Type;
  
  if ($Key == "PRI") {
    $KeyField = $Field;
    if ($Extra == "auto_increment") $IsAutoIncrement = true;
  }
  else {
    $KeyField = $PrimaryField;
  }
  
} // while

$S->close();

function DetermineTypeForBindResult($Type) {

  $pos = strpos($Type, "char");
  if ($pos === false) {}
  else return "s";

  $pos = strpos($Type, "text");
  if ($pos === false) {}
  else return "s";
  
  $pos = strpos($Type, "int");
  if ($pos === false) {}
  else return "i";  
  
  $pos = strpos($Type, "date");
  if ($pos === false) {}
  else return "s";  
  
  $pos = strpos($Type, "timestamp");
  if ($pos === false) {}
  else return "s";  
  
  $pos = strpos($Type, "float");
  if ($pos === false) {}
  else return "d";  
  
  $pos = strpos($Type, "decimal");
  if ($pos === false) {}
  else return "d";

  $pos = strpos($Type, "blob");
  if ($pos === false) {}
  else return "b";

  $pos = strpos($Type, "longblob");
  if ($pos === false) {}
  else return "b";

}

?>
<pre>
<?php print("&lt;?php\n"); ?>
//
// Generated by tools/TableClass.php
// on <?php print (date(DATE_COOKIE, time())) ?> 
// $Id: TableClass.php 16 2012-03-09 10:09:43Z scott_auge $
//

// This provides useful functions for the data such as RandonString
// and date format changers.

include_once ("clsUtil.php");

class cls<?php print($TableName) ?> extends clsUtil {

  // Database object (usually clsDB.php) (mysqli based object)
  
  public $DB;
  
  // Database fields
  
  <?php
  foreach ($FieldList as $FieldName) {
  ?>
public $<?php print ($FieldName) ?>;
  <?php
  }
  ?>

  // Available attribute if FindByID() gets something.  
  
  private $_Available;

  //  If our find is ambiguous, set this flag

  private $_Ambiguous;
  
  // This is used for FindByQuery() which may have multiple record result set.
  // We need it to move to the next result set with the FetchByQuery() method.  We 
  // cannot go backwards as of yet.  Clean up with CloseByQuery().
  
  private $_S;
  
  // Sometimes we just need to loop through the number of records available
  
  public $NumRows;

  // --------------------------------------------------------------------------
  // Constructor
  // --------------------------------------------------------------------------
  
  public function __construct ($DB) {
  
    $this->DB = $DB;
  
  } // Constructor

  // --------------------------------------------------------------------------
  // Create a record. Note this does not put data into the record, only 
  // prepares a container for Update()
  // --------------------------------------------------------------------------
  
  public function Create () {
  
    
    <?php

    if ($IsAutoIncrement) {
    ?>
    // if an auto incrementing key field, then we need to use last_insert_id() to get the value
    // last_insert_id() is mysql oriented.  See curval() for postgresql
				
    $SQL = "INSERT INTO <?php print($TableName) ?> () VALUES ()";
    $S = $this->DB->Connection->prepare($SQL);
    $S->execute();

    $SQL = "SELECT LAST_INSERT_ID();";
    $S = $this->DB->Connection->prepare($SQL);
    $S->bind_result($ID);
    $S->execute();
    $S->fetch();
		
    $S->close();		

    <?php
    } else {
?>
$ID = self::RandomString(50);
    $SQL = "INSERT INTO <?php print($TableName) ?> (<?php print ($KeyField) ?>) VALUES (?)";
    $S = $this->DB->Connection->prepare($SQL);
    $S->bind_param("s", $ID);
    $S->execute();
    $S->close();    
    <?php
    } // else
    ?>
$this-><?php print ($KeyField) ?> = $ID;

    // Load up our database defaults into the "buffer"

    $this->FindByID($ID);
  
  } // Create ()

  // --------------------------------------------------------------------------
  // Delete a record by it's key field
  // --------------------------------------------------------------------------
  
  public function Delete () {
  
    $SQL = "DELETE FROM <?php print($TableName) ?> WHERE <?php print ($KeyField) ?> = ?";
    $S = $this->DB->Connection->prepare($SQL);
    $S->bind_param("s", $this-><?php print ($KeyField) ?>);
    $S->execute();
    $S->close();  
  
  } // Delete ()
  
<?php
$i = 0;

$SQLUPDATEFieldList = "";
$SQLUPDATEBind = "";
$SQLResultBind = "";

foreach ($FieldList as $FieldName) {

// echo $TypeList[$i];

  //
  //  On mysql 5.1 "update set keyfield where keyfield" yields goofy results.
  //  So on update, we neglect the key field.  (You shouldn't be updating that anyhow!)
  //

  if ($FieldName == $KeyField) {
    $i++;
    continue;
  }

  $SQLUPDATEFieldList .= $FieldName . " = ?, "; 
  $SQLUPDATEBind .= "\$this->" . $FieldName . ", ";
  $SQLResultBind .= DetermineTypeForBindResult($TypeList[$i]);
  $i++;
}

// Remove trailing commas
$SQLUPDATEFieldList = substr($SQLUPDATEFieldList, 0, strlen($SQLUPDATEFieldList) - 2);
$SQLUPDATEBind = substr($SQLUPDATEBind, 0, strlen($SQLUPDATEBind) - 2);
?>

  // --------------------------------------------------------------------------
  // This is what moves the data from the public properties into the database
  // --------------------------------------------------------------------------

  public function Update () {


    //
    // We are using parameterized SQL, there is no need for magic quotes on this stuff.
    // If any of it is on, then we want to remove slashes from the input because it comes
    // back out with the slashes.
    //



    <?php
    foreach ($FieldList as $FieldName) {
      print ("      \$this->" . $FieldName . " = stripslashes(\$this->" . $FieldName . ");\n" );
    } // for each
    ?>



    //
    //  Warning!  Generator doesn't handle blob fields very well.  You may need to do some
    //            hand coding with MySQLi's Stmt->send_long_data() to properly update.  If
    //            the blob exceeds MYSQLs packet size (the DB, not PHP) then corruption is
    //            guaranteed.
    //            Use
    //                mysql> SHOW VARIABLES LIKE 'max_allowed_packet';
    //            to determine the size of data you're set up for.
    //

  
    $SQL = "UPDATE <?php print($TableName) ?> SET <?php print ($SQLUPDATEFieldList) ?> WHERE <?php print ($KeyField) ?> = ?";
    $S = $this->DB->Connection->prepare($SQL);
    $S->bind_param("<?php print($SQLResultBind) ?>s", <?php print ($SQLUPDATEBind) ?>,$this-><?php print($KeyField) ?>);
    $S->execute();
    $S->close();  
  
  } // Update ()

<?php

$SQLSELECTFieldList = "";
$SQLSELECTBind = "";

foreach ($FieldList as $FieldName) {
  $SQLSELECTFieldList .= $FieldName . ", "; 
  $SQLSELECTBind .= "\$this->" . $FieldName . ", ";
}
$SQLSELECTFieldList = substr($SQLSELECTFieldList, 0, strlen($SQLSELECTFieldList) - 2);
$SQLSELECTBind = substr($SQLSELECTBind, 0, strlen($SQLSELECTBind) - 2);
?>

  // --------------------------------------------------------------------------
  // On returns from the web, often we have the key fields value or it is 
  // stored in a session table.  Given the key field's value, find it and load
  // into the class.
  // --------------------------------------------------------------------------
  
  public function FindByID ($ID) {
  
    $SQL = "SELECT <?php print($SQLSELECTFieldList) ?> FROM <?php print ($TableName) ?> WHERE <?php print ($KeyField) ?> = ?";
    $S = $this->DB->Connection->prepare($SQL);
    $S->bind_param("s", $ID);
    
    // This order is very important for dealing with BLOBs and other large data types

    $S->execute();
    $S->store_result();
    $S->bind_result(<?php print ($SQLSELECTBind) ?>);

    // This order is very important, store_result() needs to be called before num_rows is set
    
    $this->SetAvailable ($S);
    $this->SetAmbiguous ($S);

    $S->fetch();
    $S->close();
  
  } // FindByID ()
  
<?php
$SQLSELECTFieldList = "";
$SQLSELECTBind = "";
foreach ($FieldList as $FieldName) {
  $SQLSELECTFieldList .= $FieldName . ", "; 
  $SQLSELECTBind .= "\$this->" . $FieldName . ", ";
}
$SQLSELECTFieldList = substr($SQLSELECTFieldList, 0, strlen($SQLSELECTFieldList) - 2);
$SQLSELECTBind = substr($SQLSELECTBind, 0, strlen($SQLSELECTBind) - 2);
?>  
  
  // --------------------------------------------------------------------------
  // MIGHT BE FASTER TO DO A QUERY OUTSIDE THIS CLASS FOR THE KeyField AND
  // THEN USE THIS CLASS WITH A FINDBYID() ON INDIVIDUAL RECORDS
  // --------------------------------------------------------------------------
  // ArrayArgs should be in the form and order needed for bind_param
  // SQL is {table} WHERE {find clause}, fields are automatically taken 
  // care of.
  // For queries that may have more than one record, one will want to use
  // FetchByQuery() and CloseByQuery() to move around and clean up.
  // Example $T->FindByQuery ("Bin where Bin = ? and location = ?",
  //                          array("ss", "$T->bin,$T->location") ???
  // Note if you have multiple rows, you may want to keep the result set in
  // one class, and create a class for manipulating the records with FindById()
  // --------------------------------------------------------------------------
  
  public function FindByQuery ($SQL, $ArrayArgs) {

    $SQL = "SELECT <?php print($SQLSELECTFieldList) ?> FROM " . $SQL;
    $this->_S = $this->DB->Connection->prepare($SQL);
    
    // Need to use a callback to bind unknown arts
    
    if (strpos($SQL, "?") != FALSE) {
      call_user_func_array(array($this->_S, "bind_param"), $ArrayArgs);
    }
    
    // This order is very important for dealing with BLOBs and other large data types

    $this->_S->execute();
    $this->_S->store_result();
    $this->_S->bind_result(<?php print ($SQLSELECTBind) ?>);
    
    // When doing this, auto load the first data set
    
    $this->_S->fetch();

    // This order is very important, store_result() needs to be called before num_rows is set
    
    $this->SetAvailable ($this->_S);
    $this->SetAmbiguous ($this->_S);
  
  } // FindByQuery ()  

  // --------------------------------------------------------------------------
  // Close the query
  // --------------------------------------------------------------------------
  
  public function CloseByQuery () {
  
     $this->_S->close();
     
  } // CloseByQuery ()
  
  // --------------------------------------------------------------------------
  // Allow the query to pull up the next row
  // --------------------------------------------------------------------------
  
  public function FetchByQuery () {
  
    $this->_S->fetch();
    
  } // FetchByQuery ()
  
  // --------------------------------------------------------------------------
  // Determines if a record was available.
  // --------------------------------------------------------------------------

  public function Available() {

    return $this->_Available;

  } // Available()

  // --------------------------------------------------------------------------
  // Determine if the query found something
  // --------------------------------------------------------------------------

 private function SetAvailable ($S) {

    $this->_Available = ($S->num_rows > 0) ? 1 : 0;

  } // SetAvailable()

  // --------------------------------------------------------------------------
  // Determine if the FindBy*() was ambiguous.
  // --------------------------------------------------------------------------

  public function Ambiguous() {

    return $this->_Ambiguous;

  } // Available()

  // --------------------------------------------------------------------------
  // Tool to help set Ambiguous from what ever FindBy*() used.
  // --------------------------------------------------------------------------

  private function SetAmbiguous ($S) {

    if ($S->num_rows < 2)
      $this->_Ambiguous = 0;
    else
      $this->_Ambiguous = ($S->num_rows);
      
    $this->NumRows = $S->num_rows;

  } // SetAmbiguous ()


} // class

/****** Unit Test

----- Create ------

include_once ("clsDB.php");
include_once ("clsactivity.php");

$DB = new clsDB();

$T = new clsactivity ($DB);

$T->Create();

$T->Name = "1Test";

$T->Update();

print $T->RecID;

unset ($T);
unset ($DB);


------ Update -------

include_once ("clsDB.php");
include_once ("clsactivity.php");

$DB = new clsDB();

$T = new clsactivity ($DB);

$T->FindByID("1613232823tRz7dOcyH8otVX1NVP2vQlP2G6YAHVmdcj2JKMpD");

$T->Name = "2Test";

$T->Update();

unset ($T);
unset ($DB);

----- Delete ------

include_once ("clsDB.php");
include_once ("clsactivity.php");

$DB = new clsDB();

$T = new clsactivity ($DB);

$T->FindByID("1613232823tRz7dOcyH8otVX1NVP2vQlP2G6YAHVmdcj2JKMpD");

$T->Delete();

unset ($T);
unset ($DB);

*****/
<?php 
print("?&gt;"); 
} // !empty($_POST)
?>

</pre>
</body>
</html>
