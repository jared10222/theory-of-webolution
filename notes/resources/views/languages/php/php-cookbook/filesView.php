<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

      <div class="page-header">
        <h1>Files</h1>
      </div>
      


<table class="table table-responsive table-bordered">
	<caption>Table of Contents</caption>
    <tr>
    	<td><a href="#creating_opening">Creating or Opening a Local File</a></td>
        <td><a href="#creating_temp">Creating a Temporary File</a></td>
        <td><a href="#opening_remote">Opening a Remote File</a></td>
        <td><a href="#reading_standard">Reading from Standard Input</a></td>
    </tr>
    <tr>
    	<td><a href="#reading_into_string">Reading a File into a String</a></td>
        <td><a href="#counting">Counting Lines, Paragraphs, or Records in a File</a></td>
        <td><a href="#every_word">Processing Every Word in a File</a></td>
        <td><a href="#random_line">Picking a Random Line from a File</a></td>
    </tr>
    <tr>
    	<td><a href="#randomizing_all">Randomizing All Lines in a File</a></td>
        <td><a href="#variable_length">Processing Variable-Length Text Fields</a></td>
        <td><a href="#reading_conf_files">Reading Configuration Files</a></td>
        <td><a href="#modifying_in_place">Modifying a File in Place Without a Temporary File</a></td>
    </tr>
    <tr>
        <td><a href="#flushing_output">Flushing Output to a File</a></td>
        <td><a href="#writing_to_standard">Writing to Standard Output</a></td>
        <td><a href="#writing_to_many">Writing to Many Filehandles Simultaneously</a></td>
        <td><a href="#escaping_shell">Escaping Shell Metacharacters</a></td>
    </tr>
    <tr>
    	<td><a href="#passing_input">Passing Input to a Program</a></td>
        <td><a href="#reading_standard_output">Reading Standard Output from a Program</a></td>
        <td><a href="#reading_standard_error">Reading Standard Error from a Program</a></td>
        <td><a href="#locking_a_file">Locking a File</a></td>
    </tr>
    <tr>
    	<td><a href="#custom_file_types">Reading and Writing Custom File Types</a></td>
        <td><a href="#compressed_files">Reading and Writing Compressed Files</a></td>
        <td></td>
        <td></td>
    </tr>     
</table>

<hr />

<p>PHP’s interface for file I/O is similar to that of C, although less complicated. The fundamental
unit of identifying a file to read from or write to is a filehandle. This handle
identifies your connection to a specific file, and you use it for operations on the file.</p>

<pre class="prettyprint">
//This example opens /tmp/cookie-data and writes the contents of
//a specific cookie to the file:

$fh = fopen('/tmp/cookie-data', 'w') or die("can't open file");
if(-1 == fwrite($fh, $_COOKIE['flavor'])){ die("can't write data"); }
fclose($fh)  or die("can't close file");    
    </pre>


<p>Because most file-handling functions just return false on error, you have to do some
additional work to find more details about that error. When the track_errors configuration
directive is on, each error message is put in the global variable <b>$php_errormsg</b>.
Including this variable as part of your error output makes debugging easier, as shown:</p>

<pre class="prettyprint">
$fh = fopen('/tmp/cookie-data', 'w') or die("can't open: $php_errormsg");
if(-1 == fwrite($fh, $_COOKIE['flavor'])){ die("can't write: $php_errormsg"); }
fclose($fh)  or die("can't close: $php_errormsg");
    </pre>


<p>PHP functions that use a newline as a line-ending delimiter (for example, fgets())
work on both Windows and Unix because a newline is the character at the end of the
line on either platform.
To remove any line-delimiter characters, use the PHP function rtrim():</p>

<pre class="prettyprint">
$fh = fopen('/tmp/lines-of-data.txt', 'r') or die($php_errormsg);
while(false !== ($s = fgets($fh))){
    $s = rtrim($s);
    //do something with $s...
}
fclose($fh) or die($php_errormsg);
    </pre>


<p>This function removes any trailing whitespace in the line, including ASCII 13 and ASCII
10 (as well as tab and space). If there’s whitespace at the end of a line that you want to
preserve, but you still want to remove carriage returns and line feeds, provide rtrim()
with a string containing the characters that it should remove. Other characters are left
untouched, as shown:</p>

<pre class="prettyprint">
$fh = open('/tmp/lines-of-data.txt', 'r') or die($php_errormsg);
while(false !== ($s = fgets($fh))){
    $s = rtrim($s, "\r\n");
    //do something with $s...
}
fclose($fh) or die($php_errormsg);
    </pre>


<p>Unix and Windows also differ on the character used to separate directories in pathnames.
Unix uses a slash (/), and Windows uses a backslash (\). PHP makes sorting this
out easy, however, because the Windows version of PHP also understands / as a directory
separator. For example, this successfully prints the contents of C:\Alligator\Crocodile
Menu.txt:</p>

<pre class="prettyprint">
$fh = fopen('c:/alligator/crocodile menu.txt', 'r') or die($php_errormsg);
while(false !== ($s = fgets($fh))){
    print $s;
}
fclose($fh) or die($php_errormsg);
    </pre>


<hr />

<h2><a name="creating_opening">Creating or Opening a Local File</a></h2>
<p><b>Problem:</b> You want to open a local file to read data from it or write data to it.</p>
<p><b>Solution:</b> Use fopen():</p>

<p>Documentation on <a href="http://php.net/manual/en/function.fopen.php" target="_blank">fopen()</a></p>

<table class="table table-responsive table-bordered">
	<caption>fopen() file modes</caption>
    <thead>
    	<tr>
        	<th>Mode</th>
            <th>Readable?</th>
            <th>Writable?</th>
            <th>File Pointer</th>
            <th>Truncate?</th>
            <th>Create?</th>
        </tr>
    </thead>
        <tr>
            <td>r</td>
            <td>Yes</td>
            <td>No</td>
            <td>Beginning</td>
            <td>No</td>
            <td>No</td>
        </tr>
        <tr>
            <td>r+</td>
            <td>Yes</td>
            <td>Yes</td>
            <td>Beginning</td>
            <td>No</td>
            <td>No</td>
        </tr>
        <tr>
            <td>w</td>
            <td>No</td>
            <td>Yes</td>
            <td>Beginning</td>
            <td>Yes</td>
            <td>Yes</td>
        </tr>
        <tr>
            <td>w+</td>
            <td>Yes</td>
            <td>Yes</td>
            <td>Beginning</td>
            <td>Yes</td>
            <td>Yes</td>
        </tr>
        <tr>
            <td>a</td>
            <td>No</td>
            <td>Yes</td>
            <td>End</td>
            <td>No</td>
            <td>Yes</td>
        </tr>
        <tr>
            <td>a+</td>
            <td>Yes</td>
            <td>Yes</td>
            <td>End</td>
            <td>No</td>
            <td>Yes</td>
        </tr>
        <tr>
            <td>x</td>
            <td>No</td>
            <td>Yes</td>
            <td>Beginning</td>
            <td>No</td>
            <td>Yes</td>
        </tr>
        <tr>
            <td>x+</td>
            <td>Yes</td>
            <td>Yes</td>
            <td>Beginning</td>
            <td>No</td>
            <td>Yes</td>
        </tr>
</table>

<pre class="prettyprint">
$fh = fopen('file.txt', 'r') or die("Can't open file.txt: $php_errormsg");
    </pre>


<hr />

<h2><a name="creating_temp">Creating a Temporary File</a></h2>
<p><b>Problem:</b> You need a file to temporarily hold some data.</p>
<p><b>Solution:</b> If the file needs to last only the duration of the running script, use tmpfile():</p>
<p>If the file needs to last longer, generate a filename with tempnam(), and then use fopen():</p>

<p>Documentation on <a href="http://php.net/tmpfile" target="_blank">tmpfile()</a></p>
<p>Documentation on <a href="http://php.net/tempnam" target="_blank">tempnam()</a></p>

<pre class="prettyprint">
$temp_fh = tmpfile();
//write some data to the temp file
fputs($temp_fh, "The current time is " .strftime('%c'));
//the file goes away when the script ends
exit(1);

<hr />

$tempfilename = tempnam('/tmp', 'data-');
temp_fh = fopen($tempfilename, 'w') or die($php_errormsg);
fputs($temp_fh, "The current time is " . strftime('%c'));
fclose($temp_fh) or die($php_errormsg);
    </pre>


<hr />

<h2><a name="opening_remote">Opening a Remote File</a></h2>
<p><b>Problem:</b> You want to open a file that's accessible to you via HTTP or FTP.</p>
<p><b>Solution:</b> Pass the file's URL to fopen():</p>

<p>Documentation on <a href="http://php.net/features.remote-files" target="_blank">remote files</a></p>
<p>Documentation on <a href="http://php.net/wrappers" target="_blank">stream wrappers</a></p>

<pre class="prettyprint">
$fh = fopen('http://www.example.com/robots.txt', 'r') or die($php_errormsg);
    </pre>


<hr />

<h2><a name="reading_standard">Reading from Standard Input</a></h2>
<p><b>Problem:</b> You want to read from standard input in a command-line context-for example, to get user input from the keyboard or data piped to your PHP program.</p>
<p><b>Solution:</b> Use fopen() to open php://stdin:</p>

<pre class="prettyprint">
$fh = fopen('php://stdin', 'r') or die($php_errormsg);
while($s = fgets($fh)){
    print "You typed: $s";
}
    </pre>


<hr />

<h2><a name="reading_into_string">Reading a File into a String</a></h2>
<p><b>Problem:</b> You want to load the entire contents of a file into a variable. For example, you want to determine if the text in a file matches a regular expression.</p>
<p><b>Solution:</b> Use file_get_contents():</p>

<p>If you want the contents of a file in a string to manipulate, file_get_contents() is
great, but if you just want to print the entire contents of a file, there are easier (and more
efficient) ways than reading it into a string and then printing the string. PHP provides
two functions for this. The first is fpassthru($fh), which prints everything left on the
filehandle $fh and then closes it. The second, readfile($filename), prints the entire
contents of $filename.
You can use readfile() to implement a wrapper around images that shouldn’t always
be displayed. This program makes sure a requested image is less than a week old:</p>

<p>Documentation on <a href="http://php.net/filesize" target="_blank">filesize()</a></p>
<p>Documentation on <a href="http://php.net/fread" target="_blank">fread()</a></p>
<p>Documentatino on <a href="http://php.net/fpassthru" target="_blank">fpassthru()</a></p>
<p>Documentation on <a href="http://php.net/readfile" target="_blank">readfile()</a></p>

<pre class="prettyprint">
$people = file_get_contents('people.txt');
if(preg_match('/Names:.*(David|Susannah)/i',$people)){
    print "people.txt matches.";
}

<hr />

$image_directory = '/usr/local/images';

if(preg_match('/^[a-zA-Z0-9]+\.(gif|jpe?g)$/', $image, $matches) &amp;&amp;
   is_readable($image_directory."/$image") &amp;&amp;
   (filemtime($image_directory."/$image") >= (time() - 86400 * 7))){
   
   header('Content-Type: image/'.$matches[1]);
   header('Content-Length: '.filesize($image_directory."/$image"));
   
   readfile($image_directory."/$image");
   
}else{
    error_log("Can't serve image: $image");
}
    </pre>


<hr />

<h2><a name="counting">Counting Lines, Paragraphs, or Records in a File</a></h2>
<p><b>Problem:</b> You want to count the number of lines, paragraphs, or records in a file.</p>
<p><b>Solution:</b> To count lines, use fgets():</p>

<p>To count paragraphs, increment the counter only when you read a blank line:</p>

<p>To count records, increment the counter only when the line read contains just the record separator and whitespace. Here the record separator is stored in $record_separator:</p>

<p>Documentation on <a href="http://php.net/fgets" target="_blank">fgets()</a></p>
<p>Documentation on <a href="http://php.net/feof" target="_blank">feof()</a></p>
<p>Documentation on <a href="http://php.net/stream_get_line" target="_blank">stream_get_line()</a></p>

<pre class="prettyprint">
$lines = 0;

if($fh = fopen('orders.txt', 'r')){
    while(! feof($fh)){
        if(fgets($fh)){
            $lines++;
        }
    }
}

print $lines;

//Because <b>fgets()</b> reads a line at a time, you can count
//the number of times it's called before reaching the end of a file

<hr />

$paragraphs = 0;

if($fh = fopen('great-american-novel.txt', 'r')){
    while(! feof($fh)){
        $s = fgets($fh);
        if(("\n" == $s) || ("\r\n" == $s)){
            $paragraphs++;
        }
    }
}

print $paragraphs;

<hr />

$records = 0;
$record_separator = '--end--';

if($fh = fopen('great-american-textfile-database.txt','r')){
    while(! feof($fh)){
        $s = rtrim(fgets($fh));
        if($s == $record_separator){
            $records++;
        }
    }
}

print $records;
    </pre>


<hr />

<h2><a name="every_word">Processing Every Word in a File</a></h2>
<p><b>Problem:</b> You want to do something with every word in a file. For example, you want to build a concordance of how many times each word is used to compute similarities between documents.</p>
<p><b>Solution:</b> Read in each line with fgets(), separate the line into words, and process each word:</p>

<pre class="prettyprint">
$fh = fopen('great-american-novel.text', 'r') or die($php_errormsg);
while(! feof($fh)){
    if($s = fgets($fh)){
        $words = preg_split('/\s+/',$s,-1,PREG_SPLIT_NO_EMPTY);
        //process words
    }
}
fclose($fh) or die($php_errormsg);

<hr />
//This example calculates the average word length in a file:

$word_count = $word_length = 0;

if($fh = fopen('great-american-novel.txt', 'r')){
    while(! feof($fh)){
        if($s = fgets($fh)){
            $words = preg_split('/\s+/',$s,-1,PREG_SPLIT_NO_EMPTY);
            foreach($words as $word){
                $word_count++;
                $word_length += strlen($word);
            }
        }
    }
}

print sprintf("The average word lenght over %d words is %.02f characters.",
    $word_count,
    $word_length/$word_count);
    </pre>


<hr />

<h2><a name="random_line">Picking a Random Line from a File</a></h2>
<p><b>Problem:</b> You want to pick a line at random from a file; for example, you want to display a selection from a file of sayings</p>
<p><b>Solution:</b> Spread the selection odds evenly over all lines in a file:</p>

<pre class="prettyprint">
$line_number = 0;

$fh = fopen(__DIR__.'/sayings.txt', 'r') or die($php_errormsg);
while(! feof($fh)){
    if($s = fgets($fh)){
        $line_number++;
        if(mt_rand(0, $line_number -1) == 0){
            $line = $s;
        }
    }
}
fclose($fh) or die($php_errormsg);
    </pre>


<hr />

<h2><a name="randomizing_all">Randomizing All Lines in a File</a></h2>
<p><b>Problem:</b> You want to randomly reorder all lines in a file. You have a file of funny quotes, for example, and you want to pick out one at random.</p>
<p><b>Solution:</b> Read all the lines in the file into an array with file() and then shuffle the elements of the array:</p>

<pre class="prettyprint">
$lines = file(__DIR__.'/quotes-of-the-day.txt');

if(shuffle($lines)){
    //okay
    echo $lines[0];
}else{
    die("Failed to shuffle");
}
    </pre>


<hr />

<h2><a name="variable_length">Processing Variable-Length Text Fields</a></h2>
<p><b>Problem:</b> You want to read delimited text fields from a file. You might, for example, have a database program that prints records one per line, with tabs between each field in the record, and you want to parse this data into an array.</p>
<p><b>Solution:</b> Use fgetcsv() to read in each line and then split the fields based on their delimiter:</p>

<pre class="prettyprint">
$delim = '|';

$fh = fopen('books.txt', 'r') or die("Can't open: $php_errormsg");
while(! feof($fh)){
    $fields = fgetcsv($fh, 1000, $delim);
    //...do something with the data...
    print_r($fields);
}
fclose($fh) or die("can't close: $php_errormsg");
    </pre>


<hr />

<h2><a name="reading_conf_files">Reading Configuration Files</a></h2>
<p><b>Problem:</b> You want to use configuration files to initialize settings in your programs.</p>
<p><b>Solution:</b> Use parse_ini_file():</p>

<p>The function parse_ini_file() reads configuration files structured like PHP’s main
php.ini file. Instead of applying the settings in the configuration file to PHP’s configuration,
however, parse_ini_file() returns the values from the file in an array.</p>

<p>Documentation on <a href="http://php.net/parse-ini-file" target="_blank">parse_ini_file()</a></p>

<pre class="prettyprint">
$config = parse_ini_file('/etc/myapp.ini');

<hr />
//For example, when parse_ini_file() is given a file with
//these contents:

;physical features
eyes=brown
hair=brown
glasses=yes

;other features
name=Susannah
likes=monkeys, ice cream, reading

//The array it reaturns is:

Array
(
    [eyes] => brown
    [hair] => brown
    [glasses] => 1
    [name] => Susannah
    [likes] => monkeys, ice cream, reading
)

<hr />
//To parse sections from the configuration file, pass 1 as 
//a second argument to parse_ini_file(). Sections are set off
//by words in square brackets in the file:

[physical]
eyes=brown
hair=brown
glasses=yes

[other]
name=Susannah
likes=monkeys,ice cream, reading

//If this file is in /etc/myapp.ini, then:

$conf = parse_ini_file('/etc/myapp.ini',1);

//puts the array in $conf:

Array
(
    [physical] => Array
        (
            [eyes] => brown
            [hair] => brown
            [glasses] => 1
        )
    [other] => Array
        (
            [name] => Susannah
            [likes] => monkeys, ice cream, reading
        )
)

    </pre>


<hr />

<h2><a name="modifying_in_place">Modifying a File in Place Without a Temporary File</a></h2>
<p><b>Problem:</b> You want to change a file without using a temporary file to hold the changes.</p>
<p><b>Solution:</b> Read the file with file_get_contents(), make the changes, and rewrite the file with file_put_contents():</p>

<p>Documentation on <a href="http://php.net/fseek" target="_blank">fseek()</a></p>
<p>Documentation on <a href="http://php.net/rewind" target="_blank">rewind()</a></p>
<p>Documentation on <a href="http://php.net/ftruncate" target="_blank">ftruncate()</a></p>
<p>Documentation on <a href="http://php.net/file_get_contents" target="_blank">file_get_contents()</a></p>
<p>Documentation on <a href="http://php.net/file_put_contents" target="_blank">file_put_contents()</a></p>

<pre class="prettyprint">
$contents = file_get_contents('pickles.txt');
$contents = strtoupper($contents);
file_put_contents('pickles.txt', $contents);
    </pre>


<hr />

<h2><a name="flushing_output">Flushing Output to a File</a></h2>
<p><b>Problem:</b> You want to force all buffered data to be written to a filehandle.</p>
<p><b>Solution:</b> Use fflush():</p>

<p>To be more efficient, system I/O libraries generally don’t write something to a file when
you tell them to. Instead, they batch the writes together in a buffer and save all of them
to disk at the same time. Using fflush() forces anything pending in the write buffer to
be actually written to disk.</p>

<p>Flushing output can be particularly helpful when generating an access or activity log.
Calling fflush() after each message to the logfile makes sure that any person or program
monitoring the logfile sees the message as soon as possible.</p>

<p>Documentation on <a href="http://php.net/fflush" target="_blank">fflush()</a></p>

<pre class="prettyprint">
fwrite($fh, 'There are twelve pumpkins in my house.');
fflush($fh);
    </pre>


<hr />

<h2><a name="writing_to_standard">Writing to Standard Output</a></h2>
<p><b>Problem:</b> You want to write to standard output.</p>
<p><b>Solution:</b> use echo or print():</p>

<p>Whereas print() is a function, echo is a language construct. This means that print()
returns a value, and echo doesn’t. You can include print() but not echo in larger expressions,
as shown:</p>

<p>Documentation on <a href="http://php.net/print" target="_blank">print()</a></p>
<p>Documentation on <a href="http://php.net/echo" target="_blank">echo</a></p>

<pre class="prettyprint">
print "Where did my pastrami sandwich go?";
echo "It went into my stomach.";

<hr />
//this is OK
(12 == $status) ? print 'Status is good' : error_log('Problem with status!');

//this gives a parse error
(12 == $status) ? echo 'Status is good' : error_log('Problem with status!);

//Use php://stdout as the filename if you're using the file functions
// $fh = fopen('php://stdout', 'w') or die($php_errormsg);

    </pre>


<hr />

<h2><a name="writing_to_many">Writing to Many Filehandles Simultaneously</a></h2>
<p><b>Problem:</b> You want to send output to more than one filehandle; for example, you want to log messages to the screen and to a file.</p>
<p><b>Solution:</b> Wrap your output with a loop that iterates through your filehandles:</p>

<p>Documentation on <a href="http://php.net/fwrite" target="_blank">fwrite()</a></p>

<pre class="prettyprint">
function multi_fwrite($fhs, $s, $length=NULL){
    if(is_array($fhs)){
        if(is_null($length)){
            foreach($fhs as $fh){
                fwrite($fh, $s);
            }
        }else{
            foreach($fhs as $fh){
                fwrite($fh, $s, $length);
            }
        }
    }
}

$fhs = array();
$fhs['file'] = fopen('log.txt', 'w') or die($php_errormsg);
$fhs['screen'] = fopen('php://stdout', 'w') or die($php_errormsg);

multi_fwrite($fhs, 'The space shuttle has landed.');

    </pre>


<hr />

<h2><a name="escaping_shell">Escaping Shell Metacharacters</a></h2>
<p><b>Problem:</b> You need to incorporate external data in a command line, but you want to escape special characters so nothing unexpected happens; for example, you want to pass user input as an argument to a program.</p>
<p><b>Solution:</b> Use escapeshellarg() to handle arguments and escapeshellcmd() to handle program names:</p>

<p>Documentation on <a href="http://php.net/system" target="_blank">system()</a></p>
<p>Documentation on <a href="http://php.net/escapeshellarg" target="_blank">escapeshellarg()</a></p>
<p>Documentation on <a href="http://php.net/escapeshellcmd" target="_blank">escapeshellcmd()</a></p>

<pre class="prettyprint">
system('ls -al '.escapeshellarg($directory));
system(escapeshellcmd($ls_program.' -al');
    </pre>


<hr />

<h2><a name="passing_input">Passing Input to a Program</a></h2>
<p><b>Problem:</b> You want to pass input to an external program run from inside a PHP script. For example, your database requires you to run an external program to index text and you want to pass text to that program.</p>
<p><b>Solution:</b> Open a pipe to the program with popen(), write to the pipe with fputs() or fwrite(), and then close the pipe with pclose():</p>

<p>Documentation on <a href="http://php.net/popen" target="_blank">popen()</a></p>
<p>Documentation on <a href="http://php.net/pclose" target="_blank">pclose()</a></p>
<p>Dynamic DNS is described in <a href="http://www.faqs.org/rfcs/rfc2136.html" target="_blank">RFC 2136</a></p>

<pre class="prettyprint">
$ph = popen('/usr/bin/indexer --category=dinner', 'w') or die($php_errormsg);
if(-1 == fputs($ph, "red-cooked chicken\n")) { die($php_errormsg); }
if(-1 == fputs($ph, "chicken and dumplings\n")) { die($php_errormsg); }
pclose($ph)  or die($php_errormsg);

    </pre>


<hr />

<h2><a name="reading_standard_output">Reading Standard Output from a Program</a></h2>
<p><b>Problem:</b> You want to read the output from a program. For example, you want the output of a system utility, such as route(8), that provides network information.</p>
<p><b>Solution:</b> To read the entire contents of a program's output, use the backtick(`) operator:</p>
<p>To read the output incrementally, open a pipe with popen():</p>

<pre class="prettyprint">
$routing_table = `/sbin/route`;

<hr />

$ph = popen('/sbin/route','r') or die($php_errormsg);
while(! feof($ph)){
    $s = fgets($ph)  or die($php_errormsg);
}
pclose($ph) or die($php_errormsg);
    </pre>


<hr />

<h2><a name="reading_standard_error">Reading Standard Error from a Program</a></h2>
<p><b>Problem:</b> You want to read the error output from a program. For example, you want to capture the system calls displayed by strace(1).</p>
<p><b>Solution:</b> Redirect standard error to standard output by adding 2>&amp;1 to the command line passed to popen(). Read standard output by opening the pipe in r mode:</p>

<pre class="prettyprint">
$ph = popen('strace ls 2>&amp;1', 'r') or die($php_errormsg);
while(!feof($ph)){
    $s = fgets($ph) or die ($php_errormsg);
}
pclose($ph) or die($php_errormsg);
    </pre>

<hr />

<h2><a name="locking_a_file">Locking a File</a></h2>
<p><b>Problem:</b> You want to have exclusive access to a file to prevent it from being changed while you read or update it. For example, if you are saving guestbook information in a file, two users should be able to add guestbook entries at the same time without clobbering each other's entries.</p>
<p><b>Solution:</b> Use flock() to provide advisory locking:</p>

<p>Documentation on <a href="http://php.net/flock" target="_blank">flock()</a></p>

<pre class="prettyprint">
$fh = fopen('guestbook.txt', 'a')    or die($php_errormsg);
flock($fh,LOCK_EX)    or die($php_errormsg);
fwrite($fh, $_POST['guestbook_entry']) or die($php_errormsg);
fflush($fh) or die($php_errormsg);
flock($fh,LOCK_UN) or die($php_errormsg);
fclose($fh) or die($php_errormsg);
    </pre>


<hr />

<h2><a name="custom_file_types">Reading and Writing Custom File Types</a></h2>
<p><b>Problem:</b> You want to use PHP's standard file access functions to provide access to data that might not be in a file. For example, you want to use file access functions to read from and write to shared memory. Or you want to process file contents when they are read before they reach PHP.</p>
<p><b>Solution:</b> Use the PEAR Stream_SHM module, which implements a stream wrapper that reads from and writes to shared memory:</p>

<p>Documentation on <a href="http://php.net/stream_register_wrapper" target="_blank">stream_register_wrapper()</a></p>
<p>The <a href="http://pear.php.net/package/stream_shm" target="_blank">PEAR Stream_SHM module</a></p>
<p>Mike Naberezny's blog post <a href="http://mikenaberezny.com/2006/02/19/symphony-templates-ruby-erb/" target="_blank">"Symfony Templates and Ruby's ERb."</a></p>

<pre class="prettyprint">
require_once 'Stream/SHM.php';
stream_register_wrapper('shm','Stream_SHM') or die("Can't register shm");
$shm = fopen('shm://0xabcd','c');
fwrite($shm, "Current time is: " . time());
fclose($shm);
    </pre>


<hr />

<h2><a name="compressed_files">Reading and Writing Compressed Files</a></h2>
<p><b>Problem:</b> You want to read or write compressed files.</p>
<p><b>solution:</b> Use the compress.zlib or compress.bzip2 stream wrapper with the standard file functions.</p>

<p>To read data from a gzip-compressed file:</p>

<p>Documentation on <a href="http://php.net/wrappers.compression" target="_blank">compression stream wrappers</a></p>
<p>Documentation on <a href="http://php.net/filters.compression" target="_blank">compression filters</a></p>
<p>Documentation on <a href="http://php.net/stream_filter_append" target="_blank">stream_filter_append()</a></p>
<p>The <i>zlib</i> algorithm is detailed in <a href="http://www.faqs.org/rfcs/rfc1950.html" target="_blank">RFCs 1950</a> and <a href="http://www.faqs.org/rfcs/rfc1951.html" target="_blank">1951</a></p>

<pre class="prettyprint">
$file = __DIR__.'/lots-of-data.gz';
$fh = fopen("compress.zlib://$file",'r') or die("can't open: $php_errormsg");
if($fh){
    while($line = fgets($fh)){
        //$line is the next line of uncompressed data
    }
    fclose($fh) or die("can't close: $php_errormsg");
}
    </pre>




      
      
</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>