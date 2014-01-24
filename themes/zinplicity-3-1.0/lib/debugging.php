<?php
#-------------------------------------------------------------------------------------
#  debugging.php - public version 1.0 - 05.01.2004
#-------------------------------------------------------------------------------------
/*
   Description:

   This file is providing a drastically improved errorhandler for about any PHP code. 
   The output is formatted with HTML and has _not_ been tested to look good with MSIE.

   Features:
    - Formatted, colored, stacktrace with top-down notation
	- Display contents of passed variables between functions
	  -> It will display Arrays, Objects, Integers, Strings... and even Resource-Types!
	  -> It will display a limited amount of the variable's content where possible.
	- DOCUMENT_ROOT is stripped away from paths to avoid long paths
	- Optional dump of all GLOBALS and DEFINES on error (only once), off by default
	- easy to install, does not require weird paths or extra tinkering with php
	- inspected for security threats
	- amount of error-reporting can be tuned by commenting/uncommenting single lines

   The errorhandler can't handle:
    - Syntax errors, limitation due to the nature of the PHP Parser
	- Errors between keyboard and chair
	- Advanced datatypes like detailed SQL results or binary objects
	- Bad HTML code. The browser won't display errors inside nullsized-frames 
	  and comments or other invalid code (unclosed tags...)

   INSTALLATION:
	- copy this file to a place in your PHP include path or to a path accessible by PHP
	- add a line at top of your php code (right after < ? p h p ) stating the following 

		-> if you used the include path then write -------->  include("debugging.php");
		-> if you used your own path -------> include("/YOUR-PATH-HERE/debugging.php");

   OScommerce:
	If you're applying this patch to oscommerce, then do this:
	- copy this file to both: catalog/includes/ and admin/includes/
	- add the following line to (admin and catalog again)/includes/application_top.php
	
			require('includes/debugging.php');   # improved debug-errohandler

 */
#-------------------------------------------------------------------------------------
/*
	=========================================
	==== Important Security Information =====
	=========================================
	
	Variable content is printed via htmlspecialchars, so there 
	shouldn't be a possibility to do something bad with this code.
	
	Nevertheless sometimes some security by obscurity could be helpful - so
	for an endangered system in production state you should always disable any 
	errormessages to be sent to the user.

	KEEP IN MIND THAT DISPLAYED VARIABLES CAN CONTAIN PASSWORDS OR OTHER
	CONFIDENTIAL INFORMATION THAT IS NORMALLY NEVER PRESENTED TO THE WEB-VISITOR!

	Such Information could be for example uncovered during an unavailable database 
	where the connect function fails, thus the corresponding error will display
	the normally invisible login-credentials which were passed to the function!

	This errorhandler has a mechanism which blocks the displaying for all attributes 
	which were passed to a function with a name containing "login" or "connect".
	
	Unfortunately this can't exclude all possible options where login-credentials are
	passed between functions (like connect-wrappers etc...), therefore this warning.

 */
#-------------------------------------------------------------------------------------
# Copyright 2004 - e m m t e e @ g m x . d e
# Published under the BSD License
#-------------------------------------------------------------------------------------
# PHP >= 4.1.0 Required
# PHP >= 4.3.0 Suggested
#-------------------------------------------------------------------------------------

global $backtrace_printed_a_lot;
$backtrace_printed_a_lot = 1;		# set to 1 to supress globals-dumping
									# set to 0 to enable  globals-dumping

#####################################################################################
# there's usually no need to edit anything below this line
#####################################################################################

function backtrace(
					$hr				= false,  # pass true as parameter to enclose error in horizontal rules
					$topic			= "",	  # string
					$message		= "",	  # string
					$dump_globals	= false	  # append a dump of all PHP-defined Globals to each errormessage (large output)
				   ) 
	{ # function starts here... 
	$MAXSTRLEN		= 1500;				# define maximum printed parameter-size, usually a complete context is helpful	
	$debug_objects	= true;				# try to print details for objects
	$debug_arrays	= true;				# display detailed array-contents
	
	# if you want to see raw data, then uncomment the following line (for educational purposes)
	# print "<pre><small><small>".htmlspecialchars(print_r(debug_backtrace(),true));


	if ($hr) print "<hr>";
	print '<font type=courier><small><br>';
	if (@$topic) print "<b><u>". htmlspecialchars($topic) . "</b></u><br><b><span style=\"background:yellow;\">&nbsp;".str_replace("\n","<br>",$message)." </span></b><br>";	
	$traceArr = debug_backtrace();	# fetch backtrace-data from php
	array_shift($traceArr);			# get rid of this file from dataset, as it would always print in backtrace too
	$filecount = 0;
	foreach($traceArr as $arr) {
		if (!empty($arr["line"])) {
			$filecount++;
			# specialty: remove redundant path before / of webserver... matter of taste, so change it if you like even longer paths
			print "<b><font color='#888888'>" . (($filecount == 1) ? "At " : "Called from " )."</font>". @htmlspecialchars(substr($arr["file"],strlen(getenv("DOCUMENT_ROOT")))) . ":" . @$arr["line"] . " <br>"
						. "&nbsp;&nbsp; <font color=blue>" . @htmlspecialchars($arr["function"]) . "(</b>" ;

			if (stristr($arr["function"],"connect") or stristr($arr["function"],"login"))  {
				print "<font color=red>". htmlspecialchars("<<< HIDDEN DUE TO SECURITY CONCERN >>>")."</font>";
			}
			else if(!empty($arr['args'])) {
				$linecount = sizeof($arr['args']);
				foreach($arr['args'] as $v) {
					$linecount--; # we print in inverse direction - matter of taste
					# now let's dump some variables - depending on the type the dump should look different.
					if	(is_null($v)) {
						print 'null' ;
					}
					else if (is_array($v)) {
						print 'array of size ' . sizeof($v).'';
						if ($debug_arrays == true) {
							print ": <font color=green><small><small>";
								$content = htmlspecialchars(substr(print_r($v,true),0,$MAXSTRLEN));
								print str_replace("\n"," &bull; ",$content);
								if (strlen($content) >= $MAXSTRLEN) { print '<b>... ... ...</b>'; }
							print "</small></small></font>";
						}
					}
					else if (is_object($v)) {
						if ($debug_objects == true) {
							print "<font color=magenta><small><small>";
								$content = htmlspecialchars(substr(print_r($v,true),0,$MAXSTRLEN));
								print str_replace("\n"," &bull; ",$content);
								if (strlen($content) >= $MAXSTRLEN) { print '<b>... ... ...</b>'; }
							print "</small></small></font>";
						}
						else {
							print 'object of class "' . htmlspecialchars(get_class($v)) . '"'; # redundant - already done by print_r
							# it could be that somebody deactivates detailed object-debugging.
						}
					}
					else if (is_bool($v)) {
						if ($v == true) {
							print 'bool: <font color="#FF6633">true</font>' ;
						}
						else if ($v == false) {
							print 'bool: <font color="#FF6633">false</font>';
						}
						else {
							# dead code :)
							print 'ALERT: THIS SHOULD NEVER BE POSSIBLE - BOOL NEIGHTER TRUE OR FALSE!';
						}
					}
					else if (is_resource($v)) {
						print 'resource of type <font color="#FF6633">"' . htmlspecialchars(get_resource_type($v)) . '"</font>';
						#print htmlspecialchars(substr(print_r(serialize($v),true),0,$MAXSTRLEN));
						#if (strlen(print_r(serialize($v),true)) > $MAXSTRLEN) print '...';
					}
					else {
						print htmlspecialchars(gettype(@$v));  # you can replace the part below with print_r style code 
						$v = (string) @$v;					   # it's just a matter of taste...
						print  ": <font color='#FF6633'>\"" . htmlspecialchars(substr($v,0,$MAXSTRLEN));
						if (strlen($v) > $MAXSTRLEN) print '... ... ...';
						print "\"</font>";
					}
					if ($linecount > 0) print "</font> , <font color=blue>"; # if you change direction, change this too.
				}
			}
			else {
				print "<!-- no arguments -->"; # if you dislike () then just add something to this print
			}

			print "<b>)</b></font><br>";
		}
	}  
	# ok, this code will output hundrets of lines with seldom advantage
	# therefore this part won't trigger if you received the file with default configuration
	if (($dump_globals) and ($GLOBALS['backtrace_printed_a_lot'] < 1)){
		if (version_compare("4.3.0", phpversion()) <= 0) {
			print "<font color=red><b>GLOBALS:</b></font><font color='#440000'><pre><small><small>";
				print htmlspecialchars(print_r($GLOBALS,true));
			print "</pre><br></font><font color=red><b>END OF GLOBALS</b></font></small></small><hr>";
			print "<font color='#CC3300'><b>CONSTANTS:</b></font><br><pre><small><small>";
				print htmlspecialchars(print_r(get_defined_constants(),true));
			print "</pre><br><font color='#CC3300'><b>END OF CONSTANTS</b></font></small></small><br>";
		}
		else {
			print "<font color=red>Your PHP version " . phpversion() ." seems to be older than 4.3.0, thus does not support "
				 ."the returning of print_r() results. Ignoring this problem could cause a code injection weakness, so "
				 ."dumping all globals and defines is disabled for security reasons.</font>";
		}
	}
	print "</small></font>";
	if ($hr) print "<hr>";
	$GLOBALS['backtrace_printed_a_lot'] = 1; # set to zero if you're crazy and want the globals printed even multiple times on one page
} # end function "backtrace"

#-------------------------------------------------------------------------------------

function errhandler($type, $msg, $file, $line, $context) {
	#print "---------------------.";
	#print_r($GLOBALS['backtrace_printed_a_lot']); # just for debugging the reminder-var
	#print ".---------------------";
	switch($type) {
		case E_ERROR:
		case E_USER_ERROR:  # php4
			backtrace(false,"ERROR:",$msg, true);	# DO NOT DISABLE THIS LINE
			break;
		case E_WARNING:
		case E_USER_WARNING: # php4
			backtrace(false,"WARNING:",$msg,true);	# Think before disabling this one 
			break;
		case E_NOTICE; 
		case E_USER_NOTICE: # php4
			# this might be annoying, but usually indicates non-fatal errors...
			backtrace(false,"INFO:",$msg,false);
			print "<b>Hint:</b> use the @ symbol in front of function or brackets to suppress unavoidable errors.<br>";
			break;
		default:
			backtrace(false,"TYPE ".$type.":",$msg,false);
			print "<b>Hint:</b> lookup the errorcode <a target=_new href='http://php.net/manual/en/ref.errorfunc.php#errorfunc.constants'> HERE </a><br>";
			break;
	}
}
#-------------------------------------------------------------------------------------
set_error_handler("errhandler"); # finally enable the new errorhandler
#-------------------------------------------------------------------------------------

# error_reporting(E_ALL); # define PHP errorhandler-level (uncomment if you need to change the errorlevel)
# $blah = pg_connect("","","",""); # uncomment this to experience the stacktrace

?>
