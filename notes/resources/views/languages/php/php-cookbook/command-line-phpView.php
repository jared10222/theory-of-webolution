<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

      <div class="page-header">
        <h1>Command-Line PHP</h1>
      </div>
 


<table class="table table-responsive table-bordered">
	<caption>Table of Contents</caption>
    <tr>
    	<td><a href="#parsing_program">Parsing Program Arguments</a></td>
        <td><a href="#getopt">Parsing Program Arguments with getopt</a></td>
        <td><a href="#reading_keyboard">Reading From the Keyboard</a></td>
        <td><a href="#running_php">Running PHP Code on Every Line of an Input File</a></td>
    </tr>
    <tr>
    	<td><a href="#reading_passwords">Reading Passwords</a></td>
        <td><a href="#colorizing">Colorizing Console Output</a></td>
        <td><a href="#program">Program: DOM Explorer</a></td>
        <td></td>
    </tr>     
</table>

<hr />

<p>To run a script, pass the script filename as an argument:</p>
<p>On Unix, you can also use the hash-bang syntax at the top of your scripts to run the PHP interpreter automatically. If the PHP binary is in /usr/local/bin, make the first line of your script:</p>

<pre class="prettyprint">
% php scan-discussions.php 

<hr />

#!/usr/local/bin/php   
    </pre>


<hr />

<h2><a name="parsing_program">Parsing Program Arguments</a></h2>
<p><b>Problem:</b> You want to process arguments passed on the command line.</p>
<p><b>Solution:</b> Look in $argc for the number of arguments and $argv for their values. The first argument, $argv[0], is the name of script that is being run:</p>

<p>Documentation on <a href="http://php.net/reserved.variables.argc" target="_blank">$argc</a></p>
<p>Documentation on <a href="http://php.net/reserved.variables.argv" target="_blank">$argv</a></p>
<p>Documentation on <a href="http://php.net/reserved.variables.server" target="_blank">$_SERVER</a></p>

<pre class="prettyprint">
if($argc != 2){
    die("Wrong number of arguments: I expect only 1.");
}

$size = filesize($argv[1]);

print "I am $argv[0] and report that the size of ";
print "$argv[1] is $size bytes.";
    </pre>


<hr />

<h2><a name="getopt">Parsing Program Arguments with getopt</a></h2>
<p><b>Problem:</b> You want to parse program options that may be specified as short or long options, or they may be grouped.</p>
<p><b>Solution:</b> Use the built-in getopt() function. As of PHP 5.3.0, it supports long options, optional values, and other convenient features:</p>

<p>Documentation on <a href="http://php.net/getopt" target="_blank">getopt()</a></p>

<pre class="prettyprint">
//accepts -a, -b, and -c
$opts1 = getopt('abc');

//accepts --alice and --bob
$opts2 = getopt('',array('alice','bob'));
    </pre>


<hr />

<h2><a name="reading_keyboard">Reading From the Keyboard</a></h2>
<p><b>Problem:</b> You need to read in some typed user input.</p>
<p><b>Solution:</b> Read from the special filehandle STDIN:</p>
<p>If the Readline extension is installed, use readline():</p>
<p>If the ncurses extension is installed, use ncurses_getch():</p>

<p>Documentation on <a href="http://php.net/readline" target="_blank">the Readline extension</a></p>
<p>Documentation on <a href="http://cnswww.cns.cwru.edu/php/chet/readline/rltop.html" target="_blank">the Readline library</a></p>
<p>The <a href="http://pecl.php.net/package/ncurses" target="_blank">ncurses extension</a></p>
<p>The <a href="http://www.gnu.org/software/ncurses/" target="_blank">ncurses library</a></p>

<pre class="prettyprint">
print "Type your message. Type '.' on a line by itself when you're dont.\n";

$last_line = false; $message = '';
while(! $last_line){
    $next_line = fgets(STDIN,1024);
    if(".\n" == $next_line){
        $last_line = true;
    }else{
        $message .= $next_line;
    }
}

print "\nYour message is:\n$message\n";

<hr />

$last_line = false; $message = '';
while(! $last_line){
    $next_line = readline();
    if('.' == $next_line){
        $last_line = true;
    }else{
        $message .= $next_line."\n";
    }
}

print "\nYour message is:\n$message\n";

<hr />

$line = '';
ncurses_init();
ncurses_addstr("Type a message, ending with !\n");
/*Display the keystrokes as they are typed*/
ncurses_echo();
while(($c = ncurses_getch()) != ord("!")){
    $line = .= chr($c);
}
ncurses_end();
print "You typed: [$line]\n";
    </pre>


<hr />

<h2><a name="running_php">Running PHP Code on Every Line of an Input File</a></h2>
<p><b>Problem:</b> you want to read an entire file and execute PHP code on every line. For example, you want to create a command-line version of grep that uses PHP's Perl-compatible regular expression engine.</p>
<p><b>Solution:</b> Use the -R command-line flag to process standard input:</p>

<p>Documentation on <a href="http://php.net/features.commandline.options" target="_blank">using PHP from the command line.</a></p>

<pre class="prettyprint">
% php -R 'if (preg_match("/$argv[1]/", $argn)) print "$argn\n";'
    php
    &lt; /usr/share/dict/words
    
    <b>ephphatha</b>
    </pre>


<hr />

<h2><a name="reading_passwords">Reading Passwords</a></h2>
<p><b>Problem:</b> You need to read a string from the command line without it being echoed as it's typed--for example, when entering passwords.</p>
<p><b>Solution:</b> If the ncurses extension is available, use ncurses_getch() to read cahracter, making sure "noecho" mode is turned on:</p>

<pre class="prettyprint">
$password = '';
ncurses_init();
ncurses_addstr("Enter your password:\n");
/* Do not display the keystrokes as they are typed */
ncurses_noecho();
while (true) {
    // get a character from the keyboard
    $c = chr(ncurses_getch());
    if ( "\r" == $c || "\n" == $c ) {
        // if it's a newline, break out of the loop, we've got our password
        break;
    } elseif ("\x08" == $c) {
        /* if it's a backspace, delete the previous char from $password */
        $password = substr_replace($password,'',-1,1);
    } elseif ("\x03" == $c) {
        // if it's Control-C, clear $password and break out of the loop
        $password = NULL;
        break;
    } else {
        // otherwise, add the character to the password
        $password .= $c;
    }
}
ncurses_end();
    </pre>


<hr />

<h2><a name="colorizing">Colorizing Console Output</a></h2>
<p><b>Problem:</b> You want to display console output in different colors.</p>
<p><b>Solution:</b> Use PEAR's Console_Color2 class:</p>
<p>If you're already using ncurses, incorporate colors by using the appropriate functions:</p>

<p>The <a href="http://pear.php.net/package/Console_Color2/redirected" target="_blank">Console_Color2 class</a></p>
<p>Documentation on <a href="http://php.net/ncurses_init_pair" target="_blank">ncurses_init_pair()</a></p>
<p>Documentation on <a href="http://php.net/ncurses_color_set" target="_blank">ncurses_color_set()</a></p>
<p>More information about <a href="http://tldp.org/HOWTO/NCURSES-Programming-HOWTO/color.html" target="_blank">ncurses color programming</a> and about <a href="http://en.wikipedia.org/wiki/ANSI_escape_code" target="_blank">color escape sequences</a></p>

<pre class="prettyprint">
$color = new Console_Color2();

$ok = $color->color('green');
$fail = $color->color('red'); 
$reset = $color->color('reset');

print $ok . "OK  " . $reset . "Something succeeded!\n";
print $fail .  "FAIL " . $reset . "Something failed!\n";  

<hr />

ncurses_init();
ncurses_start_color();

ncurses_init_pair(1, NCURSES_COLOR_GREEN, NCURSES_COLOR_BLACK);
ncurses_init_pair(2, NCURSES_COLOR_RED, NCURSES_COLOR_BLACK);
ncurses_init_pair(3, NCURSES_COLOR_WHITE, NCURSES_COLOR_BLACK);

ncurses_color_set(1);
ncurses_addstr("OK ");
ncurses_color_set(3);
ncurses_addstr("Something succeeded!\n");
ncurses_color_set(2);
ncurses_addstr("FAIL ");
ncurses_color_set(3);
ncurses_addstr("Something succeeded!\n"); 
    </pre>


<hr />

<h2><a name="program">Program: DOM Explorer</a></h2>


 
      
      
      
</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>