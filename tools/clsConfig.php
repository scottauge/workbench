<?php
// $Header: file:///Users/scottauge/Documents/SVN/theatre/clsConfig.php 2 2019-06-20 18:03:22Z scottauge $


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

class clsConfig {


    protected $Host; 
	protected $User;
	protected $Password;
	protected $Database;

    //
	// Database parameters for MySQLi
	//
	
	public function __construct () {
	
		if ($_SERVER['SERVER_NAME'] == "localhost") {
			
			//
			// Home development area
			//
	
			$this->Host = "localhost";
			$this->User = "root";
			$this->Password = "";
			$this->Database = "pages";
			
		} else if ($_SERVER['SERVER_NAME'] == "amduus.com") {	
		
			$this->Host = "localhost";
			$this->User = "amduusco";
			$this->Password = "'oiO6pUo\"dLLs\"5g!nJrm";
			$this->Database = "amduusco_amduus";
	
		} else if ($_SERVER['SERVER_NAME'] == "fcp.amduus.com") {

 		  	//
  		  	// Flint Community Players database
  		  	//
		  
			$this->Host = "localhost";
			$this->User = "youruser";
			$this->Password = "yourpassword";
			$this->Database = "yourdatabase";
			
		} else if ($_SERVER['SERVER_NAME'] == "demotheatre.amduus.com") {
		
			//
			// demotheatre.amduus.com database
			//
			
			$this->Host = "localhost";
			$this->User = "youruser";
			$this->Password = "yourpassword";
			$this->Database = "yourdatabase";
			
		} // else
	} // constructor
	
} // class
?>
