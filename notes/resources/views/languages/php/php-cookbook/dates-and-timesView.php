<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

      <div class="page-header">
        <h1>Dates &amp; Times</h1>
      </div>



<table class="table table-bordered table-responsive">
	<caption>Table of Contents</caption>
    <tr>
    	<td><a href="#finding_current">Finding the Current Date and Time</a></td>
        <td><a href="#converting_time">Converting Time &amp; Date Parts to an Epoch Timestamp</a></td>
        <td><a href="#converting_epoch">Converting an Epoch Timestamp to Time and Date Parts</td>
        <td><a href="#printing_date">Printing a Date or Time in a Specified Format</a></td>
    </tr>
    <tr>
    	<td><a href="#finding_difference">Finding the Difference of Two Dates</a></td>
        <td><a href="#finding_day">Finding the Day in a Week, Month, or Year</a></td>
        <td><a href="#validating_date">Validating a Date</a></td>
        <td><a href="#parsing_dates">Parsing Dates and Times from Strings</a></td>
    </tr>
     <tr>
    	<td><a href="#adding_subtracting">Adding to or Subtracting from a Date</a></td>
        <td><a href="#calculating_time">Calculating Time with Time Zones and Daylight Saving Time</a></td>
        <td><a href="#high_precision">Generating a High-Precision Time</a></td>
        <td><a href="#time_ranges">Generating Time Ranges</a></td>
    </tr>
     <tr>
    	<td><a href="#non-gregorian">Using Non-Gregorian Calendars</a></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
     
</table>
<hr />
<p>
Time handling is made much easier by two conventions. First, treat time internally as <b>Coordinated Universal Time (abbreviated UTC and also known as GMT, Greenwich Mean Time)</b>, the patriarch of the time-zone family with no DST(daylight savings time) or summer time observance. This is the time zone at 0 degrees longitude, and all other time zones are expressed as offsets (either positive or negative) from it. Second, treat time not as an array of different values for month, day, year, minute, second, etc., but as seconds since the <b>Unix epoch: midnight on January 1, 1970(UTC, of course)</b>.
</p>

<p>The function <b>mktime()</b> produces epoch timestamps from a given set of time parts, while <b>date()</b>, given an epoch timestamp, returns a formatted time string.</p>

<pre class="prettyprint">
    <h3 class="nocode">Using mktime() and date()</h3>

$stamp = mktime(0,0,0,1,1,1986);
print date('l', $stamp);

//prints
Wednesday
    </pre>

<hr />

<h2><a name="finding_current">Finding The Current Date &amp; Time</a></h2>
<p><b>Problem:</b> You want to know what the time or date is.</p>
<p><b>Solution:</b> Use date() for a formatted time string.</p>

<p><i>print date('r');</i></p>
<p>It obviously depends on the time and date the code is run, but the previous example prints something like:<br />
<i>Fri, 01 Feb 2013 14:23:33 -0500</i></p>

<p>Or, use a DateTime object. It's format() method works just like the date() function:</p>
<p><i>$when = new DateTime();<br />
print $when->format('r');</i></p>

<p>Use getdate() or localtime() if you want time parts:</p>
<p><i>
$now_1 = getdate();<br />
$now_2 = localtime();<br />
print "{$now_1['hours']}:{$now_1['minutes']}:{$now_1['seconds']}\n";<br />
print "$now_2[2]:$now_2[1]:$now_2[0]";<br />
//prints<br />
18:23:45<br />
18:23:45
</i></p>

<table class="table table-responsive table-bordered">
	<caption>Return Array from getdate()</caption>
	<thead>
    	<tr>
        	<th>Key</th>
            <th>Value</th>
        </tr>	
    </thead>
    <tr>
    	<td>seconds</td>
        <td>Seconds</td>
    </tr>
        <tr>
    	<td>minutes</td>
        <td>Minutes</td>
    </tr>
    <tr>
    	<td>hours</td>
        <td>Hours</td>
    </tr>
    <tr>
    	<td>mday</td>
        <td>Day of the month</td>
    </tr>
    <tr>
    	<td>wday</td>
        <td>Day of the week, numeric (Sunday is 0, Saturday is 6)</td>
    </tr>
    <tr>
    	<td>mon</td>
        <td>Month, numeric</td>
    </tr>
    <tr>
    	<td>year</td>
        <td>year, numeric (4 digits)</td>
    </tr>
    <tr>
    	<td>yday</td>
        <td>Day of the year, numeric(e.g.,299)</td>
    </tr>
    <tr>
    	<td>weekday</td>
        <td>Day of the week, textual, full (e.g., "Friday"</td>
    </tr>
    <tr>
    	<td>month</td>
        <td>Month, textual, full (e.g.,"January")</td>
    </tr>
    <tr>
    	<td>0</td>
        <td>Seconds since epoch (what time() returns)</td>
    </tr>
</table>

<pre class="prettyprint">
    <h3 class="nocode">getdate()</h3>

//Finding the month, day, and year
$a = getdate();
printf('%s %d, %d', $a['month'], $a['mday'], $a['year']);
//prints
February 4, 2013

    <hr />

//pass getdate() an epoch timestamp as an argument to make the returned
//array the appropriate values for local time at that timestamp.

$a = getdate(163727100);
printf('%s %d, %d', $a['month'],$a['mday'],$a['year']);
//prints
March 10, 1975
    </pre>

<p>The function localtime() also returns an array of time and date parts. It also takes an epoch timestamp as an optional first argument, as well as a boolean as an optional second argument. If that second argument is <b>true, localtime()</b> returns an associative array instead of a numerically indexed array.</p>
<table class="table table-responsive table-bordered">
	<caption>Return array from localtime()</caption>
    <thead>
    	<tr>
        	<th>Numeric position</th>
            <th>key</th>
            <th>Value</th>
        </tr>
    </thead>
    <tr>
    	<td>0</td>
        <td>tm_sec</td>
        <td>Second</td>
    </tr>
    <tr>
    	<td>1</td>
        <td>tm_min</td>
        <td>Minutes</td>
    </tr>
    <tr>
    	<td>2</td>
        <td>tm_hour</td>
        <td>Hour</td>
    </tr>
    <tr>
    	<td>3</td>
        <td>tm_mday</td>
        <td>Day of the month</td>
    </tr>
    <tr>
    	<td>4</td>
        <td>tm_mon</td>
        <td>Month of the year (January is 0)</td>
    </tr>
    <tr>
    	<td>5</td>
        <td>tm_year</td>
        <td>Years since 1900</td>
    </tr>
    <tr>
    	<td>6</td>
        <td>tm_wday</td>
        <td>Day of the week (Sunday is 0)</td>
    </tr>
    <tr>
    	<td>7</td>
        <td>tm_yday</td>
        <td>Day of the year</td>
    </tr>
    <tr>
    	<td>8</td>
        <td>tm_isdst</td>
        <td>Is daylight saving time in effect?</td>
    </tr>
</table>

<pre class="prettyprint">
    <h3 class="nocode">Using localtime()</h3>

$a = localtime();
$a[4] += 1;
$a[5] += 1900;
print "$a[4]/$a[3]/$a[5]";

//prints
2/4/2013
    </pre>


<p>Documentation on <a href="http://php.net/manual/en/function.date.php" target="_blank">date()</a></p>
<p>Documentation on <a href="http://php.net/class.datetime" target="_blank">DateTime class</a></p>
<p>Documentation on <a href="http://php.net/getdate" target="_blank">getdate()</a></p>
<p>Documentation on <a href="http://php.net/localtime" target="_blank">localtime()</a></p>
<hr />

<h2><a name="converting_time">Converting Time &amp; Date Parts to an Epoch Timestamp</a></h2>
<p><b>Problem:</b>You want to know what epoch timestamp corresponds to a set of time and date parts</p>
<p><b>Solution:</b> Use mktime() if your time and date parts are in the local time zone</p>

<p>Use gmmktime() if your time and date parts are in GMT</p>

<p>Use DateTime::createFromFormat() if your time and date parts are in a formatted time string.</p>

<p>Documentation for <a href="http://php.net/mktime" target="_blank">mktime()</a></p>
<p>Documentation for <a href="http://php.net/gmmktime" target="_blank">gmmktime()</a></p>
<p>Documentation for <a href="http://php.net/date_default_timezone_set" target="_blank">date_default_timezone_set()</a></p>
<p>Documentation for <a href="http://php.net/datetime.createfromformat" target="_blank">DateTime::createFromFormat</a></p>

<table class="table table-responsive table-bordered">
	<caption>Format characters for DateTime::createFromFormat()</caption>
    <thead>
    	<tr>
        	<th>Character</th>
            <th>Meaning</th>
        </tr>
    </thead>
    <tr>
        <td>space or tab</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>#</td>
        <td>Any one of the separation bytes ;,:,/,.,,,-,(,)</td>
    </tr>
    <tr>
        <td>;,:,/,.,,,-,(,)</td>
        <td>Literal character</td>
    </tr>
    <tr>
        <td>?</td>
        <td>Any byte (not a character, just one byte)</td>
    </tr>
    <tr>
        <td>*</td>
        <td>Any number of bytes until the next digit or separation character</td>
    </tr>
    <tr>
        <td>!</td>
        <td>Reset all fields to "start of Unix epoch" values (without this, any unspecified fields will be set to the current date/time)</td>
    </tr>
    <tr>
        <td>|</td>
        <td>Reset any uparsed fields to "start of Unix epoch" values</td>
    </tr>
    <tr>
        <td>+</td>
        <td>Treat unparsed trailing data as a warning rather than an error</td>
    </tr>
</table>

<pre class="prettyprint">
    <h3 class="nocode">getting a specific epoch timestamp</h3>

//7:45:03 PM on March 10, 1975, local time
//Assuming your "local time" is US Eastern time
$then = mktime(19,45,3,3,10,1975);

    <hr />
    <h3 class="nocode">getting a specific GMT-based epoch timestamp</h3>

//7:45:03 PM on March 10, 1975, in GMT
$then = gmmktime(19,45,3,3,10,1975);

    <hr />
    <h3 class="nocode">getting a specific epoch timestamp from a formatted time string</h3>

//7:45:03 PM on March 10, 1975, in a particular timezone
$then = DateTime::createFromFormat(DateTime::ATOM,"1975-03-10T19:45:03-04:00");

    <hr />
    <h3 class="nocode">working with epoch timestamps</h3>

date_default_timezone_set('America/New_York');
//$stamp_future is 1733257500
$stamp_future = mktime(15,25,0,12,3,2024);
//$formatted is '2024-12-03T15:25:00-05:00'
$formatted = date('c', $stamp_future);

    <hr />
    <h3 class="nocode">Using DateTime::createFromFormat()</h3>

$text = "Birthday: May 11, 1918.";
$when = DateTime::createFromFormat("*: F j, Y.|", $text);
//$formatted is "Saturday, 11-May-18 00:00:00 UTC"
$formatted = $when->format(DateTime::RFC850);
    </pre>


<hr />

<h2><a name="converting_epoch">Converting an Epoch Timestamp to Time &amp; Date parts</a></h2>
<p><b>Problem:</b> You want the set of time and date parts that corresponds to a particular epoch timestamp.</p>
<p><b>Solution:</b> Pass an epoch timestamp to getdate():$time_parts = getdate(163727100);</p>

<pre class="prettyprint">
$when = new DateTime("@163727100");
$when->setTimezone(new DateTimeZone('America/Los_Angeles'));
$parts = explode('/', $when->format('Y/m/d/H/i/s'));
//Year, month, day, hour, minute, second
//$parts is array ('1975', '03', '10', '16', '45', '00')

//The @ character tells DateTime that the rest of the argument to 
//the constructor is an epoch timestamp.
    </pre>


<hr />

<h2><a name="printing_date">Printing a Date or Time in a Specified Format</a></h2>
<p><b>Problem:</b> You need to print a date or time formatted in a particular way</p>
<p><b>Solution:</b> Use date() or DateTime::format():</p>

<pre class="prettyprint">
    <h3 class="nocode">Using date() and DateTime::format()</h3>

print date('d/M/Y') . "\n";
$when = new DateTime();
print $when->format('d/M/Y');

//prints
06/Feb/2013
06/Feb/2013
    </pre>


<table class="table table-responsive table-bordered table-striped">
	<caption>date() format characters</caption>
    <thead>
    	<tr>
        	<th>Type</th>
            <th>Character</th>
            <th>Description</th>
            <th>Range or examples</th>
        </tr>
    </thead>
    <tr>
    	<td>Hour</td>
        <td>H</td>
        <td>Hour, numeric, 24-hour clock, leading zero</td>
        <td>00-23</td>
    </tr>
    <tr>
    	<td>Hour</td>
        <td>h</td>
        <td>Hour, numeric, 12-hour clock, leading zero</td>
        <td>01-12</td>
    </tr>
    <tr>
    	<td>Hour</td>
        <td>G</td>
        <td>Hour, numeric, 23-hour clock</td>
        <td>0-23</td>
    </tr>
    <tr>
    	<td>Hour</td>
        <td>g</td>
        <td>hour, numeric, 12-hour clock</td>
        <td>1-12</td>
    </tr>
    <tr>
    	<td>Hour</td>
        <td>A</td>
        <td>Ante/Post Meridiem designation</td>
        <td>AM, PM</td>
    </tr>
    <tr>
    	<td>Hour</td>
        <td>a</td>
        <td>Ante/Post Meridiem designation</td>
        <td>am, pm</td>
    </tr>
    <tr>
    	<td>Minute</td>
        <td>i</td>
        <td>minute, numeric</td>
        <td>00-59</td>
    </tr>
    <tr>
    	<td>Second</td>
        <td>s</td>
        <td>Second, numeric</td>
        <td>00-59</td>
    </tr>
    <tr>
    	<td>Second</td>
        <td>u</td>
        <td>Microseconds, string</td>
        <td> 000000-999999</td>
    </tr>
    <tr>
    	<td>Day</td>
        <td>d</td>
        <td>Day of the month, numeric, leading zero</td>
        <td>01-31</td>
    </tr>
    <tr>
    	<td>Day</td>
        <td>j</td>
        <td>Day of the month, numeric</td>
        <td>1-31</td>
    </tr>
    <tr>
    	<td>Day</td>
        <td>z</td>
        <td>Day of the year, numeric</td>
        <td>0-365</td>
    </tr>
    <tr>
    	<td>Day</td>
        <td>N</td>
        <td>Day of the week, numeric (Monday is 1)</td>
        <td>1-7</td>
    </tr>
    <tr>
    	<td>Day</td>
        <td>w</td>
        <td>Day of the week, numeric(Sunday is 0)</td>
        <td>0-6</td>
    </tr>
    <tr>
    	<td>Day</td>
        <td>S</td>
        <td>English ordinal suffix for day of the month, textual</td>
        <td>"st," "th," "nd," "rd"</td>
    </tr>
    <tr>
    	<td>Week</td>
        <td>D</td>
        <td>Abbrevieated weekday name</td>
        <td>Mon, Tue, Wed, Thu, Fri, Sat, Sun</td>
    </tr>
    <tr>
    	<td>Week</td>
        <td>l</td>
        <td>Full weekday name</td>
        <td>Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday</td>
    </tr>
    <tr>
    	<td>Week</td>
        <td>W</td>
        <td>ISO8601:1988 week number in the year, numeric, week 1 is the first week that has at least 4 days in the current year, Monday is the first day of the week</td>
        <td>1-53</td>
    </tr>
    <tr>
    	<td>Month</td>
        <td>F</td>
        <td>Full Month Name</td>
        <td>January-December</td>
    </tr>
    <tr>
    	<td>Month</td>
        <td>M</td>
        <td>Abbreviated month name</td>
        <td>Jan-Dec</td>
    </tr>
    <tr>
    	<td>Month</td>
        <td>m</td>
        <td>Month, numeric, leading zero</td>
        <td>01-12</td>
    </tr>
    <tr>
    	<td>Month</td>
        <td>n</td>
        <td>Month, numeric</td>
        <td>1-12</td>
    </tr>
    <tr>
    	<td>Month</td>
        <td>t</td>
        <td>Month length in days, numeric</td>
        <td>28,29,30,31</td>
    </tr>
    <tr>
    	<td>Year</td>
        <td>Y</td>
        <td>Year, numeric, including centry</td>
        <td>2016</td>
    </tr>
    <tr>
    	<td>Year</td>
        <td>y</td>
        <td>Year without century, numeric</td>
        <td>16</td>
    </tr>
    <tr>
    	<td>Year</td>
        <td>o</td>
        <td>ISO8601 year with century; numeric; the four digit year corresponding to the ISO week number; same as Y except if the ISO week number belongs to the previous or next year, that year is used instead</td>
        <td>2016</td>
    </tr>
    <tr>
    	<td>Year</td>
        <td>L</td>
        <td>Leap year flag(yes is 1)</td>
        <td>0,1</td>
    </tr>
    <tr>
    	<td>Time zone</td>
        <td>O</td>
        <td>Hour offset from GMT,+-HHMM(e.g.,--0400, +0230)</td>
        <td>--1200-+1200</td>
    </tr>
    <tr>
    	<td>Time zone</td>
        <td>P</td>
        <td>Like 0, but with a colon</td>
        <td>-12:00-+12:00</td>
    </tr>
    <tr>
    	<td>Time zone</td>
        <td>Z</td>
        <td>Seconds offset from GMT; west of GMT is negative, east of GMT is positive</td>
        <td>-43200--50400</td>
    </tr>
    <tr>
    	<td>Time zone</td>
        <td>e</td>
        <td>Time zone identifier</td>
        <td>e.g.,America/New_York</td>
    </tr>
    <tr>
    	<td>Time zone</td>
        <td>T</td>
        <td>Time zone abbreviation</td>
        <td>e.g., EDT</td>
    </tr>
    <tr>
    	<td>Time zone</td>
        <td>I</td>
        <td>Daylight saving time flag (yes is 1)</td>
        <td>0,1</td>
    </tr>
    <tr>
    	<td>Compound</td>
        <td>c</td>
        <td>ISO8601 - formatted date and time</td>
        <td>e.g., 2012-09-06T15:29:34+0000</td>
    </tr>
    <tr>
    	<td>Compound</td>
        <td>r</td>
        <td>RFC2822 - formatted date</td>
        <td>e.g., Thu, 22 Aug 2002 16:01:07 +0200</td>
    </tr>
    <tr>
    	<td>Other</td>
        <td>U</td>
        <td>Seconds since the Unix epoch</td>
        <td>0-2147483647</td>
    </tr>
    <tr>
    	<td>Other</td>
        <td>B</td>
        <td>Swatch Internet time</td>
        <td>000-999</td>
    </tr>
</table>

<hr />

<h2><a name="finding_difference">Finding the Difference of Two Dates</a></h2>
<p><b>Problem:</b> You want to find the elapsed time between two dates. For example, you want to tell a user how long it's been since she last logged on to your site.</p>
<p><b>Solution:</b> Create DateTime objects for each date. Then use the DateTime::diff() method to obtain a DateInverval object that describes the difference between the dates.</p>

<p>Documentation on <a href="http://php.net/datetime.diff" target="_blank">DateTime::diff()</a></p>
<p>Documentation on <a href="http://php.net/class.dateinterval" target="_blank">DateInterval</a></p>
<p>More information on <a href="https://bugs.php.net/bug.php?id=52480" target="_blank">PHP Bug 52480</a></p>

<pre class="prettyprint">
    <h3 class="nocode">Calculating the difference between two dates</h3>

//7:32:56 pm on May 10, 1965
$first = new DateTime("1965-05-10 7:32:56pm",
         new DateTimeZone('America/New_York'));
//4:29:11 am on November 20, 1962
$second = new DateTime("1962-11-20 4:29:11am",
          new DateTimeZone('America/New_York'));
$diff = $second->diff($first);

printf("The two dates have %d weeks, %s days, " .
	   "%d hours, %d minutes, and %d seconds " .
       "elapsed between them. ",
       floor($diff->format('%a') / 7),
       $diff->format('%a') % 7,
       $diff->format('%h'),
       $diff->format('%i'),
       $diff->format('%s'));

//prints
The two dates have 128 weeks, 6 days, 15 hours, 3 minutes, and 45 seconds
elapsed between them.
    </pre>

<hr />

<h2><a name="finding_day">Finding the Day in a Week, Month, or Year</a></h2>
<p><b>Problem:</b> You want to know the day or week of the year, the day of the week, or the day of the month. For example, you wan to print a special message every Monday, or on the first of every month.</p>
<p><b>Solution:</b> Use the appropriate arguments to date() or DateTime::format()</p>

<pre class="prettyprint">
    <h3 class="nocode">Finding days of the week, month, and year</h3>

print "Today is day " . day('d') . ' of the month and ' . date('z') .
      ' of the year. ';
print "\n";

$birthday = new DateTime('January 17, 1706', new DateTimeZone(
            'America/New_York'));
print "Benjamin Franklin was born on a " . $birthday->format('l') . ", " . 
"day " . $birthday->format('N') . " of the week.";


    <hr />
    <h3 class="nocode">Checking for the day of the week</h3>

//to print out something only on Mondays
//use the w format character
if(1 == date('w')){
    print "Welcome to the beginning of your work week.";
}
    </pre>


<table class="table table-responsive table-bordered">
	<caption>Day and week number format characters</caption>
    <thead>
    	<tr>
        	<th>Type</th>
            <th>Character</th>
            <th>Description</th>
            <th>Range</th>
        </tr>
    </thead>
    <tr>
    	<td>Day</td>
        <td>d</td>
        <td>Day of the month, numeric, leading zero</td>
        <td>01-31</td>
    </tr>
    <tr>
    	<td>Day</td>
        <td>j</td>
        <td>Day of the month, numeric</td>
        <td>1-31</td>
    </tr>
    <tr>
    	<td>Day</td>
        <td>z</td>
        <td>Day of the year, numeric</td>
        <td>0-365</td>
    </tr>
    <tr>
    	<td>Day</td>
        <td>N</td>
        <td>Day of the week, numeric (Monday is 1)</td>
        <td>1-7</td>
    </tr>
    <tr>
    	<td>Day</td>
        <td>w</td>
        <td>Day of the week, numeric (Sunday is 0)</td>
        <td>0-6</td>
    </tr>
    <tr>
    	<td>Day</td>
        <td>S</td>
        <td>English ordinal suffix for day of the month, textual</td>
        <td>st, th, nd, rd</td>
    </tr>
    <tr>
    	<td>Week</td>
        <td>D</td>
        <td>Abbreviated weekday name</td>
        <td>Mon, Tue, Wed, Thu, Fri, Sat, Sun</td>
    </tr>
    <tr>
    	<td>Week</td>
        <td>l</td>
        <td>Full weekday name</td>
        <td>Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday</td>
    </tr>
    <tr>
    	<td>Week</td>
        <td>W</td>
        <td>ISO 8601:1988 week number in the year, numeric, week 1 is the first week that has at least 4 days in the current year, Monday is the first day of the week</td>
        <td>1-53</td>
    </tr>
</table>
<hr />

<h2><a name="validating_date">Validating a Date</a></h2>
<p><b>Problem:</b> You want to check if a date is valid. For example, you want to make sure a user hasn't provided a birthdate such as February 30, 1962.</p>
<p><b>Solution:</b> Use checkdate():</p>

<p>Documentation on <a href="http://php.net/checkdate" target="_blank">checkdate()</a></p>

<pre class="prettyprint">
    <h3 class="nocode">checkdate()</h3>

//$ok is true - March 10, 1993 is a valid date
$ok = checkdate(3,10,1993);
//$no_ok is false - February 30, 1962 is not a valid date
$not_ok = checkdate(2,30,1962);

    <hr />
    <h3 class="nocode">checkbirthdate()</h3>

//checks that a birthdate indicates that a user is between
//18 and 122 years old

function checkbirthdate($month, $day, $year){
	$min_age = 18;
    $max_age = 122;
}
if(! checkdate($month, $day, $year)){
	return false;
}

$now = new DateTime();
$then_formatted = sprintf("%d-%d-%d", $year, $month, $day);
$then = DateTime::createFromFormat("Y-n-j|", $then_formatted);
$age = $now->diff($then);

if(($age->y &lt; $min-age) || ($age->y > $max_age)){
    return FALSE;
}
else{
    return TRUE;
}
}

//check December 3, 1974
if(checkbirthdate(12,3,1974)){
  print "you may use this web site.";
}else{
  print "You are too young (or too old!!) to proceed.";
}
    </pre>

<hr />

<h2><a name="parsing_dates">Parsing Dates &amp; Times from Strings</a></h2>
<p><b>Problem:</b> You need to get a date or time in a string into a format you can use in calculations. For example, you want to convert date expressions such as "last Thursday" or "February 9, 2004" into epoch timestamp.</p>
<p><b>Solution:</b> The simplest way to parse a date or time string of arbitrary format is with strtotime(), which turns a variety of human-readable date and time strings into epoch timestamps:</p>

<p>Documentation on <a href="http://php.net/strtotime" target="_blank">strtotime()</a></p>
<p>Documentation on <a href="http://php.net/datetime.createfromformat" target="_blank">DateTime::createFromFormat()</a></p>
<p><a href="http://php.net/datetime.formats" target="_blank">Rules describing what strtotime() can parse.</a></p>

<pre class="prettyprint">
    <h3 class="nocode">Parsing strings with strtotime()</h3>

$a = strtotime('march 10'); //defaults to the current year
$b = strtotime('last thursday');
$c = strtotime('now + 3 months');

//the function strtotime() understands words about the current time:
$a = strtotime('now');
print date(DATE_RFC850, $a);
print "\n";

$a = strtotime('today');
print date(DATE_RFC850, $a);

Tuesday, 12-Feb-13 19:12:14 UTC
Tuesday, 12-Feb-14 00:00:00 UTC

//It understands different ways to identify a time and date:
$a = strtotime('5/12/2014');
print date(DATE_RFC850, $a);
print "\n";

$a = strtotime('12 may 2014');
print date(DATE_RFC850, $a);

Monday, 12-May-14 00:00:00 UTC
Monday, 12-May-14 00:00:00 UTC

//It understands relative times and dates
$a = strtotime('last thursday'); //on February 12, 2013
print date(DATE_RFC850, $a);
print "\n";

$a = strtotime(2015-07-12 2pm + 1 month');
print date(DATE_RFC850, $a);

Thursday, 07-Feb-13 00:00:00 UTC
Wednesday, 12-Aug-15 14:00:00 UTC


    </pre>


<hr />

<h2><a name="adding_subtracting">Adding to or Subtracting from a Date</a></h2>
<p><b>Problem:</b> You need to add or subtract an interval from a date.</p>
<p><b>Solution:</b> Apply a DateInterval object to a DateTime object with either the DateTime::add() or DateTime::sub() method:</p>

<p>Documentation on <a href="http://jp2.php.net/dateinterval.construct" target="_blank">creating DateInverval object</a></p>
<p>Documentation on <a href="http://php.net/datetime.add" target="_blank">DateTime::add()</a></p>
<p>Documentation on <a href="http://php.net/datetime.sub" target="_blank">DateTime::sub()</a></p>
<p>Documentation on <a href="http://php.net/datetime.modify" target="_blank">DateTime::modify()</a></p>

<pre class="prettyprint">
    <h3 class="nocode">Adding and subtracting a date interval</h3>

$birthday = new DateTime('March 10, 1975');

//When is 40 weeks before $birthday?
$human_gestation = new DateInterval('P40W');
$birthday->sub($human_gestation);
print $birthday->format(DateTime::RFC850);
print "\n";

//what if it was an elephant, not a human?
$elephant_gestation = new DateInterval('P616D');
$birthday->add($elephan_gestation);
print $birthday->format(DateTime::RFC850);
    </pre>


<hr />

<h2><a name="calculating_time">Calculating Time with Time Zones and Daylight Saving Time</a></h2>
<p><b>Problem:</b> You need to calculate times in different time zones. For example, you want to give users information adjusted to their local time, not the local time of your server.</p>
<p><b>Solution:</b> Use appropriate DateTimeZone objects when you build DateTime object and PHP wil do all the work for you.</p>

<p>Documentation on <a href="http://php.net/date_default_timezone_set" target="_blank">date_default_timezone_set()</a></p>
<p>Documentation on <a href="http://php.net/date_default_timezone_get" target="_blank">date_default_timezone_get()</a></p>
<p>Documentation on <a href="http://php.net/class.datetimezone" target="_blank">DateTimeZone class</a></p>
<p>The <a href="http://php.net/timezones" target="_blank">time zones</a> that PHP knows about</p>
<p>The <a href="http://www.iana.org/time-zones" target="_blank">IANA Time Zone Database</a></p>
<p>The <a href="http://pecl.php.net/package/timezonedb" target="_blank">timezonedb PECL extension</a></p>

<pre class="prettyprint">
    <h3 class="nocode">Simple time zone usage</h3>

$nowInNewYork = new DateTime('now', new DateTimeZone('America/New_York'));
$nowInCalifornia = new DateTime('now', new DateTimeZone('America/Los_Angeles'));

printf("It's %s in New York but %s in California.",
        $nowInNewYork->format(DateTime::RFC850),
        $nowInCalifornia->format(DateTime::RFC850));

//this prints
It's Friday, 15-Feb-13 14:50:25 EST in New York but
Friday, 15-Feb-14 11:50:25 PST in California.
    </pre>


<hr />

<h2><a name="high_precision">Generating a High-Precision Time</a></h2>
<p><b>Problem:</b> You need to measure time with finer than one-second resolutions--for example, to generate a unique ID or benchmark a function call</p>
<p><b>Solution:</b> Use microtime(true) to get the current time in seconds and microseconds.</p>

<p>Documentation on <a href="http://php.net/microtime" target="_blank">microtime()</a></p>
<p>Documentation on <a href="http://php.net/manual/en/function.list.php" target="_blank">list()</a></p>

<pre class="prettyprint">
    <h3 class="nocode">Timing with microtime()</h3>

$start = microtime(true);
for($i = 0; $i &lt; 1000; $i++){
    preg_match('/age=\d{1,5}/', $_SERVER['QUERY_STRING']);
}
$end = microtime(true);
$elapsed = $end - $start;

    <hr />
    <h3 class="nocode">Generating an ID with microtime()</h3>

list($microseconds, $seconds) = explode(' ', microtime());
$id = $seconds.$microseconds.getmyid();
    </pre>


<hr />

<h2><a name="time_ranges">Generating Time Ranges</a></h2>
<p><b>Problem:</b> You need to know all the days in a week or a month. For example, you want to print out a list of appointments for a week.</p>
<p><b>Solution:</b> Use the DatePeriod class.</p>

<p>Documentation for <a href="http://php.net/class.dateperiod" target="_blank">DatePeriod</a></p>
<p>Documentation for <a href="http://php.net/class.dateinterval" target="_blank">DateInterval()</a></p>

<pre class="prettyprint">
    <h3 class="nocode">DatePeriod</h3>

//Start on August 1
$start = new DateTime('August 1, 2014');
//End date is exclusive, so this will stop on August 31
$end = new DateTime('September 1, 2014');
//Go 1 day at a time
$interval = new DateInterval('P1D');

$range = new DatePeriod($start, $interval, $end);
    </pre>


<hr />

<h2><a name="non_gregorian">Using Non-Gregorian Calendars</a></h2>
<p><b>Problem:</b> You want to use a non-Gregorian calendar, such as Julian, Jewish, or French Republican calendar.</p>
<p><b>Solution:</b> PHP's Calendar extension provides conversion functions for working with the Julian calendar as well as the French Republican and Jewish calendars. To use these funcitons, the calendar extension must be loaded.</p>

<p>Documentation on <a href="http://php.net/calendar" target="_blank">calendar functions</a></p>

<pre class="prettyprint">
    <h3 class="nocode">Converting between Julian days and the Gregorian Calendar</h3>

//March 8, 1876
//$jd is 2406323, the Julian day count
$jd = gregoriantojd(3,9,1876);

$gregorian = cal_from_jd($jd, CAL_GREGORIAN);
/*$gregorian is array('date' => '3/9/1876',
                      'month' => 3,
                      'day' => 9,
                      'year' => 1876,
                      'dow' => 4,
                      'abbrevdayname' => 'Thu',
                      'dayname' => 'Thursday',
                      'abbrevmonth' => 'Mar',
                      'monthname' => 'March'));
                      
    </pre>


<hr />
<h2>Program: Calendar</h2>
<p><i>Little Calendar</i></p>

<pre class="prettyprint">
    <h3 class="nocode">Using LittleCalendar()</h3>

&lt;style type="text/css">
.prev { text-align:left; }
.next { text-align:right; }
.day, .month, .weekday { text-align: center; }
.today { background: yellow; }
.blank { }
&lt;/style>
&lt;?php
//print the calendar for the current month if a month
//or year isn't in the query string
$month = isset($_GET['month']) ? intval($_GET['month']) : date('m');
$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

$cal = new LittleCalendar($month, $year);

print $cal->html();

    
    <hr />
    <h3 class="nocode">littleCalendar Class</h3>

class LittleCalendar {
    /**DateTime*/
    protected $monthToUse;
    protected $prepared = false;
    protected $days = array();
    
    public function __construct($month, $year){
      /*Build a Datetime for the month we're going to display*/
      $this->monthToUse = DateTime::createFromFormat('Y-m|',
                                                  sprintf("%04d-%02d",
                                                  $year, $month));
      $this->prepare();
    }
    
    protected function prepare(){
      //Build up an array of information about each day
      //in the month including appropriate padding at the
      //beginning and end
      //First, days of the week across the first row
      
      foreach(array('Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa') as $dow){
          $endOfRow = ($dow == 'Sa');
          $this->days[] = array('type'=>'dow',
                                'label' => $dow,
                                'endOfRow' => $endOfRow);
      }
      
      //Next, placeholders up to the first day of the week
      for($i = 0, $j = $this->monthToUse->format('w'); $i &lt; $j; $i++){
          $this->days[] = array('type' => 'blank');
      }
      
      //Then, one item for each day in the month
      $today = date('Y-m-d');
      $days = new DatePeriod($this->monthToUse,
                             new DateInterval('P1D'),
                             $this->monthToUse->format('t') - 1);
      foreach ($days as $day){
          $isToday = ($day->format('Y-m-d') == $today);
          $endOfRow = ($day->format('w') == 6);
          $this->days[] = array('type' => 'day',
                                'label' => $day->format('j'),
                                'today' => $isToday,
                                'endOfRow' => $endOfRow);
        
      }
      
      //Last, any placeholders for the end of the month, if we
      //didn't have an endOfWeek day as the last day in the month
      if(! $endOfRow){
          for($i = 0, $j = 6 - $day->format('w'); $i &lt; $j; $i++){
              $this->days[] = array('type' => 'blank');
          }
      }
    }
    
    public function html($opts = array()){
      if(! isset($opts['id'])){
        $opts['id'] = 'calendar';
      }
      if(! isset($opts['month_link'])){
        $opts['month_link'] = 
          '&lt;a href="'.htmlentities($_SERVER['PHP_SELF']) . '?' .
          'month=%d&amp;amp;year=%d">%s&lt;/a>';
      }
      $classes = array();
      foreach(array('prev', 'month', 'next', 'weekday', 'blank', 'day', 'today')
      as $class){
        if(isset($opts['class']) && isset($opts['class'][$class])){
          $classes[$class] = $opts['class']['$class'];
        }
        else{
          $classes[$class] = $class;
        }
      }
      
    /* Build a DateTime for the previous month */
    $prevMonth = clone $this->monthToUse;
    $prevMonth->modify("-1 month");
    $prevMonthLink = sprintf($opts['month_link'],
    $prevMonth->format('m'),
    $prevMonth->format('Y'),
    '&laquo;');
    /* Build a DateTime for the following month */
    $nextMonth = clone $this->monthToUse;
    $nextMonth->modify("+1 month");
    $nextMonthLink = sprintf($opts['month_link'],
    $nextMonth->format('m'),
    $nextMonth->format('Y'),
    '&raquo;');
    $html = '&lt;table id="'.htmlentities($opts['id']).'">
    &lt;tr>
    &lt;td class="'.htmlentities($classes['prev']).'">' .
    $prevMonthLink . '&lt;/td>
    &lt;td class="'.htmlentities($classes['month']).'" colspan="5">'.
    $this->monthToUse->format('F Y') .'&lt;/td>
    &lt;td class="'.htmlentities($classes['next']).'">' .
    $nextMonthLink . '&lt;/td>
    &lt;/tr>';
    $html .= '&lt;tr>';
    $lastDayIndex = count($this->days) - 1;
    foreach ($this->days as $i => $day) {
    switch ($day['type']) {
    case 'dow':
    $class = 'weekday';
    $label = htmlentities($day['label']);
    break;
    case 'blank':
    $class = 'blank';
    $label = '&nbsp;';
    break;
    case 'day':
    $class = $day['today'] ? 'today' : 'day';
    $label = htmlentities($day['label']);
    break;
    }
    $html .=
    '&lt;td class="' . htmlentities($classes[$class]).'">'.
    $label . '&lt;/td>';
    if (isset($day['endOfRow']) && $day['endOfRow']) {
    $html .= "&lt;/tr>\n";
    if ($i != $lastDayIndex) {
    $html .= '&lt;tr>';
    }
    }
    }
    $html .= '&lt;/table>';
    return $html;
    }
    public function text() {
    $lineLength = strlen('Su Mo Tu We Th Fr Sa');
    $header = $this->monthToUse->format('F Y');
    $headerSpacing = floor(($lineLength - strlen($header))/2);
    $text = str_repeat(' ', $headerSpacing) . $header . "\n";
    foreach ($this->days as $i => $day) {
    switch ($day['type']) {
    case 'dow':
    $text .= sprintf('% 2s', $day['label']);
    break;
    case 'blank':
    $text .= ' ';
    break;
    case 'day':
    $text .= sprintf("% 2d", $day['label']);
    break;
    }
    $text .= (isset($day['endOfRow']) && $day['endOfRow']) ? "\n" : " ";
    }
    if ($text[strlen($text)-1] != "\n") {
    $text .= "\n";
    }
    return $text;
        }
    }
    </pre>



      
      
      
</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>