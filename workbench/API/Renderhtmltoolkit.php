<?php

class RenderHtmlWidget {
  
function CRLF () {return "<br>";}

function CR() {return "\r";}

function q ($q) {return("\"" . $q . "\"");}

function Select($name) {
  return "<select name=" . $this->q($name) . ">";
}

function addoption($o) {return "<option value=" . $this->q($o) . ">" . $o . "</option>" ;}

function eSelect() {return "</select>";}

function Radio ($Name, $Value){return "<input type=" 
                                    . $this->q("radio") 
                                    . "name="
                                    . $this->q($Name) 
                                    . "value="
                                    . $this->q($Value)
                                    . ">";
                              }
                              
function Submit($value) {return "<input type=" . $this->q("submit") . "value=" . $this->q($value) . ">";}

function TextInput ($name, $value, $size) {
  return "<input type=" . $this->q("text") . " name=" 
                        . $this->q($name) . " size=" 
                        . $this->q($size) . " value=" 
                        . $this->q($value) . ">" ;
}

function TextArea($name, $x, $y, $value){return "<textarea name=" . $this->q($name) . 
                                                       " rows=" . $this->q($y) . 
                                                       " cols=" . $this->q($x) . 
                                                       ">" . $value .
                                                       "</textarea" . ">" . CR();}
                                                       
function Checkbox ($id, $name, $checked) {return "<input type=" 
                                               . $this->q("checkbox") 
                                               . " name=" . $this->q($name)
                                               . " id=" . $this->q($id)
                                               . (($checked == "yes") ? " checked" : "")
                                               . ">"
                                               . $this->CR();
                                         }

function Label($For, $TheLabel) {return "<label for=" . $this->q($For) 
                         . " >"
                         . $TheLabel
                         . "</label>"
                         . $this->CR();}

function form($name, $method) {return "<form action=" . $this->q($name) . " method=" . $this->q($method) . ">";}

function eForm (){return "</form>" . $this->CR();}

function escript() {return "</script>";}

function script() {return "<script language=\"javascript\">";}

function JumpTo ($Destination) {
	//echo script();
	return ("window.location=" . $this->q( $Destination));
	//echo escript();
}

function Alert ($t) {
  return ("alert(" . $this->q($t) . ");");
}

function Button ($Name) {
  return "<button type=\"button\">$Name</button>"; 
}

function Hidden ($Name, $Value) {
  return "<hidden name=" . $this->q($Name) . " value=" . $this->q($Value) . ">";
}

} // class 

?>
