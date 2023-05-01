<?php

// $Id: clsUtil.php 15 2012-03-09 03:54:46Z scott_auge $
// $HeadURL: file:///users/scott_auge/svn_tools/clsUtil.php $

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

class clsUtil {

  public function RandomString ($Width) {
	
	   $Alphabet = "qwertyuioplkjhgfdsazxcvbnmMNBVCXZASDFGHJKLPOIUYTREWQ1234567890";
	   $CurStrLen = 0;
		 $Result = time ();
		 while (strlen($Result) < $Width) $Result .= substr($Alphabet, rand(1,strlen($Alphabet)), 1); 
		 
		 return $Result;
		 
	}
	
	public function SQL2USTime ($SQLTime) {
	
		$DateTime = explode (" ", $SQLTime);
		$YearMonthDay = explode("-", $DateTime[0]);
		$HourMinSec = explode(":", $DateTime[1]);
	
		$TheUSDateTime = $YearMonthDay[1] . "-" . $YearMonthDay[2] . "-" . $YearMonthDay[0] . " ";
		
		if ($HourMinSec[0] > 12) {
		
			$HourMinSec[0] = $HourMinSec[0] - 12;
			$AMPM = "pm";
			
		} else {
		
			$AMPM = "am";
			
		}
		
		if ($HourMinSec[0] == 12) $AMPM = "pm";
		 
		
		$TheUSDateTime .= $HourMinSec[0] . ":" . $HourMinSec[1] . ":" . $HourMinSec[2] . " " . $AMPM;
		
		return $TheUSDateTime;
		
	}	
	
	public function SQL2XMLRPC($Time) {

		$DateTime = explode (" ", $Time);
		$YearMonthDay = explode("-", $DateTime[0]);
		$HourMinSec = explode(":", $DateTime[1]);
		
		$XMLTime = $YearMonthDay[0] . $YearMonthDay[1] . $YearMonthDay[2] . "T" . $HourMinSec[0] . $HourMinSec[1] . $HourMinSec[2];
		// echo "XMLTime : " . $XMLTime . "<BR>";
		// echo "strtotime(): " . strtotime($XMLTime) . "<BR>";
		return $XMLTime;
		
	}
	
}
?>