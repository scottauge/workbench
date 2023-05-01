<?php

// $Id: clsDB.php 15 2012-03-09 03:54:46Z scott_auge $

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

include_once ("clsConfig.php");

class clsDB extends clsConfig {

  public $Connection;
	
  public function __construct () {
	
	  parent::__construct();
	
	  $this->Connection = new mysqli ($this->Host, $this->User, $this->Password, $this->Database);
		
		if ($this->Connection->connect_error) {
      die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }
		
	} // constructor
	
	//
	// Often used for setting the time zone or other client parameters 
	//
	
	public function ExecSQL ($SQL) {
	
	  $S = $this->Connection->prepare($SQL);
		$S->execute();
		$S->close();
	
	}
	
	public function ExecQuery ($SQL) {
	
	  $S = $this->Connection->query($SQL);
		$D = $S->fetch_assoc();
		$S->close();	
	  
		return $D;
		
	}
	
	// Used for returning array of objects from a bound parameter select
	// MySQLi checked.  May not work with other DB drivers
	
  protected function ResultToObjects($stmt)
    {
      $result = array();
     
      $metadata = $stmt->result_metadata();
      $fields = $metadata->fetch_fields();

      for (;;)
      {
        $pointers = array();
        $row = new stdClass();
       
        $pointers[] = $stmt;
        foreach ($fields as $field)
        {
          $fieldname = $field->name;
          $pointers[] = &$row->$fieldname;
        }
       
        call_user_func_array(mysqli_stmt_bind_result, $pointers);
       
        if (!$stmt->fetch())
          break;
       
        $result[] = $row;
      }
     
      $metadata->free();
     
      return $result;
    } 	
	
} // class
?>