<?php
// a backgound process
// -- using "background" db
// -- using table session
// -- general structure

// What db are we connecting to?

global $Login;

$Login["Server"]="localhost";
$Login["User"]="root";
$Login["Password"]="";
$Login["DBName"]="background";

// include our progress like stuff
include "c:/tmp/dosql.php";
include "c:/tmp/incprogress.php";
include "c:/tmp/incsession.php";

out("Here we go");
ClearAllSession();  // In case a stop is hanging around!

set_time_limit(0);  // No time out!

// State when we started

WriteCSession("1", "StartTime", microtime());

// The big loop!

while (true) {

  // Output a heartbeat

  $D = new DateTimeImmutable();
  out("Time is " . $D->format("o  m d H:i:s"));
  flush();

  // Tell the queue what time we are at
  WriteCSession("1", "CurrentTime", microtime());

  // Can we stop?
  
  if (CanFind("session where CValue='stop'")) {
    out("<b>Encountered a stop!</b>");
    break;
  }
  
  // Sleep for a bit
  
  out("Sleeping for 5 second");
  sleep(5);

  //////////////////////////////////////
  // Here is where we put our catches //
  //////////////////////////////////////

  if (CanFind("session where cValue='db'")) {
    out("<b>Found a <i>db</i> message!</b>");
  }

}

// When we ended

WriteCSession("1","EndTime", microtime());

flush();
CloseDB();

out("<b>STOPPED!</b>");
?>