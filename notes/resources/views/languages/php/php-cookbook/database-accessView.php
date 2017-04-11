<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

      <div class="page-header">
        <h1>Database Access</h1>
      </div>


<table class="table table-responsive table-bordered">
	<caption>Table of Contents</caption>
    <tr>
    	<td><a href="#dbm_databases">Using DBM Databases</a></td>
        <td><a href="#sqlite_database">Using an SQLite Database</a></td>
        <td><a href="#connecting_sql">Connecting to an SQL Database</a></td>
        <td><a href="#querying_sql">Querying an SQL Database</a></td>
    </tr>
    <tr>
    	<td><a href="#retrieving_rows">Retrieving Rows Without a Loop</a></td>
        <td><a href="#modifying_sql_data">Modifying Data in an SQL Database</a></td>
        <td><a href="#repeating_queries">Repeating Queries Efficiently</a></td>
        <td><a href="#finding_num_rows">Finding the Number of Rows Returned by a Query</a></td>
    </tr>
    <tr>
    	<td><a href="#escaping_quotes">Escaping Quotes</a></td>
        <td><a href="#logging_debugging">Logging Debugging Information end Errors</a></td>
        <td><a href="#creating_unique">Creating Unique Identifiers</a></td>
        <td><a href="#queries_programmatically">Building Queries Programmatically</a></td>
    </tr>
    <tr>
        <td><a href="#paginated">Making Paginated Links for a Series of Records</a></td>
        <td><a href="#caching_queries">Cachine Queries and Results</a></td>
        <td><a href="#accessing_db_anywhere">Accessing a Database Connection Anywhere in Your Program</a></td>
        <td><a href="#program_storing">Program: Storing a Threaded Message Board</a></td>
    </tr>
    <tr>
    	<td><a href="#using_redis">Using Redis</a></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
    	<td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    
     
</table>

<hr />

<h2><a name="dbm_databases">Using DBM Databases</a></h2>
<p><b>Problem:</b> You have data that can be easily represented as key/value pairs, want to store it safely, and have very fast lookups based on those keys.</p>
<p><b>Solution:</b> Use the DBA abstraction layer to access a DBM-style database:</p>

<p>Documentation on <a href="http://php.net/dba" target="_blank">DBA functions</a></p>

<pre class="prettyprint">
    <h3 class="nocode">Using a DBM database</h3>
&lt;?php
$dbh = dba_open(__DIR__.'/fish.db','c','db4') or die($php_errormsg);

//retrieve and change values
if(dba_exists('flounder', $dbh)){
    $flounder_count = dba_fetch('flounder',$dbh);
    $flounder_count++;
    dba_replace('flounder',$flounder_count,$dbh);
    print "Updated the flounder count.";
}else{
    dba_insert('flounder',1,$dbh);
    print "Started the flounder count.";
}

//no more tilapia
dba_delete('tilapia',$dbh);

//what fish do we have?
for($key = dba_firstkey($dbh); key !== false; $key = dba_nextkey($dbh)){
    $value = dba_fetch($key, $dbh);
    print "$key: $value\n";
}

dba_close($dbh);
?>
    </pre>


<hr />

<h2><a name="sqlite_database">Using an SQLite Database</a></h2>
<p><b>Problem:</b> You want to use a relational database that doesn't involve a separate server process.</p>
<p><b>Solution:</b> Use SQLite. This robust, powerful database program is easy to use and doesn't require running a separate server. An SQLite database is just a file.</p>

<p>Documentation on <a href="http://www.sqlite.org/docs.html" target="_blank">SQLite</a></p>
<p>Documentation on <a href="http://www.sqlite.org/faq.html#q7" target="_blank">sqlite_master</a></p>

<pre class="prettyprint">
    <h3 class="nocode">Creating an SQLite database</h3>

&lt;programlisting>$db = new PDO('sqlite:/tmp/zodiac');

//Create the table and insert the data automically
$db->beginTransaction();
//Try to find a table named 'zodiac'
$q = $db->query("SELECT name FROM sqlite_master WHERE type= 'table'" .
              " AND name = 'zodiac'");
//If the query didn't return a row, then create the table
//and insert the data
if($q->fetch() === false){
    $db->exec(&lt;&lt;&lt;_SQL_
CREATE TABLE zodiac (
    id INT UNSIGNED NOT NULL,
    sign CHAR(11),
    symbol CHAR(13),
    planet CHAR(7),
    element CHAR(5),
    start_month TINYINT,
    start_day TINYINT,
    end_month TINYINT,
    end_day TINYINT,
    PRIMARY KEY(id)
)
_SQL_
};

//The individual SQL statements
    $sql&lt;&lt;&lt;_SQL_
INSERT INTO zodiac VALUES(1,'ARIES', 'RAM', 'MARS', 'fire',3, 21,4,19);
INSERT INTO zodiac VALUES(2,'Taurus','BULL','Venus','earth',4,20,5,20);
_SQL_;

    //Chop up each line of SQL and execute it
    forech(explode("\n",trim($sql)) as $q){
        $db->exec(trim($q));
    }
    $db->commit();
}else{
    //Nothing happened, so end the transaction
    $db->rollback();
}&lt;/progrmlisting>
    </pre>


<hr />

<h2><a name="connecting_sql">Connecting to an SQL Database</a></h2>
<p><b>Problem:</b> You want access to a SQL database to store or retieve information.</p>
<p><b>Solution:</b> Create a new PDO object with the appropriate connection string.</p>

<p><b>NOTE:</b> Note that to use a particular PDO backend, PHP must be built with suport for that backend. Use the output from the PDO::getAvailableDrivers() method to determine what PDO backends your PHP setup has.</p>

<p>Documentation on <a href="http://php.net/PDO" target="_blank">PDO</a></p>

<pre class="prettyprint">
    <h3 class="nocode">Connecting with PDO</h3>

//MySQL expectes parameters in the string
$mysql = new PDO('mysql:host=db.example.com', $user,$password);
//Separate multiple parameters with;
$mysql = new PDO('mysql:host=db.example.com;port31075', $user, $password);
$mysql = new PDO('mysql:host=db.example.com;prot31075;dbname=food', $user,
                 $password);
//Connect to a local MySQL server
$mysql = new PDO('mysql:unix_socket=/tmp/mysql.sock', $user, $password);

//PostgreSQL also expects parameters in the string
$pgsql = new PDO('pgsql:host=db.example.com',$user,$password);
//Separate multiple parameters with ' ' or ;
$pgsql = new PDO('pgsql:host=db.example.com port=31075',$user,$password);
$pgsql = new PDO('pgsql:host=db.example.com;port=31075;dbname=food', $user,
                 $password);
//You can put the user and password in the DSN if you like.
$pgsql = new PDO("pgsql:host=db.example.com port=31075 dbname=food user=$user
                $password=$password");

//Oracle
//If a database name is defined in tnsnames.ora, just put that in the DSN
//as the value of the dbname parameter
$oci = new PDO('oci:dbname=food', $user, $password);
//Otherwise, specifiy an Instant Client URI
$oci = new PDO('oci:dbname=//db.example.com:1521/food', $user, $password);
// Sybase (If PDO is using Sybase's ct-lib library)
$sybase = new PDO('sybase:host=db.example.com;dbname=food', $user, $password);
// Microsoft SQL Server (If PDO is using MS SQL Server libraries)
$mssql = new PDO('mssql:host=db.example.com;dbname=food', $user, $password);
// DBLib (for FreeTDS)
$dblib = new PDO('dblib:host=db.example.com;dbname=food', $user, $password);
// ODBC -- a predefined connection
$odbc = new PDO('odbc:food');
// ODBC -- an ad-hoc connection. Provide whatever the underlying driver needs
$odbc = new PDO('odbc:Driver={Microsoft Access Driver
(*.mdb)};DBQ=C:\\data\\food.mdb;Uid=Chef');
// SQLite just expects a filename -- no user or password
$sqlite = new PDO('sqlite:/usr/local/zodiac.db');
$sqlite = new PDO('sqlite:c:/data/zodiac.db');
// SQLite can also handle in-memory, temporary databases
$sqlite = new PDO('sqlite::memory:');
// SQLite v2 DSNs look similar to v3
$sqlite2 = new PDO('sqlite2:/usr/local/old-zodiac.db');
    </pre>


<hr />

<h2><a name="querying_sql">Querying an SQL Database</a></h2>
<p><b>Problem:</b> You want to retrieve some data from your database.</p>
<p><b>Solution:</b> Use PDO::query() to send the SQL query to the database, and then a foreach loop to retrieve each row of the result:</p>

<pre class="prettyprint">
    <h3 class="nocode">Sending a query to the database</h3>

$st = $db->query('SELECT symbol, planet FROM zodiac');
foreach($st->fetchAll as $row){
    print "{$row['symbol']} goes with {$row['planet']}&lt;br />\n";
}

    <hr />
    <h3 class="nocode">Fetching individual rows</h3>

$rows = $db->query('SELECT symbol, planet FROM zodiac ORDER BY planet');
$firstRow = $rows->fetch();
print "The first results are that {$firstRow['symbol']} goes with
{$firstRow['planet']}";
    </pre>

<hr />

<h2><a name="retrieving_rows">Retrieving Rows Without a Loop</a></h2>
<p><b>Problem:</b> You want a concise way to execute a query and retrieve the data it returns.</p>
<p><b>Solution:</b> Use fetchAll() to get all the results from a query at once:</p>

<pre class="prettyprint">
    <h3 class="nocode">Getting all results at once</h3>

$st = $db->query('SELECT planet, element FROM zodiac');
$results = $st->fetchAll();
foreach($results as $i => $result){
    print "Planet $i is {$result['planet']}&lt;br />\n";
}
    </pre>


<hr />

<h2><a name="modifying_sql_data">Modifying Data in an SQL Database</a></h2>
<p><b>Problem:</b> You want to add, remove, or change data in an SQL database.</p>
<p><b>Solution:</b> Use PDO::exec() to send an INSERT, DELETE, or UPDATE command:</p>

<p>You can also prepare a query with PDO::prepare() and execute it with PDOStatement::execute():</p>

<p>Documentation on <a href="http://php.net/PDO.exec" target="_blank">PDO::exec()</a></p>
<p>Documentation on <a href="http://php.net/PDO.prepare" target="_blank">PDO::prepare()</a></p>
<p>Documentation on <a href="http://php.net/PDOStatement.execute" target="_blank">PDOStatement::execute()</a></p>

<pre class="prettyprint">
    <h3 class="nocode">Using PDO::exec()</h3>

$db->exec("INSERT INTO family (id,name) VALUES (1, 'Vito')");
$db->exec("DELETE FROM family WHERE name LIKE 'Fredo'");
$db->exec("UPDATE family SET is_naive = 1 WHERE name LIKE 'Key'");

    <hr />
    <h3 class="nocode">Preparing and executing a query</h3>

$st = $db->prepare('INSERT INTO family (id,name) VALUES(?,?)');
$st->execute(array(1,'Vito'));

$st->$db->prepare('DELETE FROM family WHERE name LIKE ?');
$st->$db->execute(array('Fredo'));
    </pre>


<hr />

<h2><a name="repeating_queries">Repeating Queries Efficiently</a></h2>
<p><b>Problem:</b> You want to run the same query multiple times, substituting in different values each time.</p>
<p><b>Solution:</b> Set up the query with PDO::prepare() and then run it by calling execute() on the prepared statement that prepare() returns. The placeholders in the query passed to prepare() are replaced with data by execute():</p>

<p>Documentation on <a href="http://php.net/pdostatement.bindparam" target="_blank">PDOStatment::bindParam()</a></p>
<p>Documentation on <a href="http://php.net/pdo.lobs" target="_blank">Large Objects</a></p>

<p>Force bindParam() to treat the value as a particular type by passing a type constant as a third agrument.</p>
<table class="table table-responsive table-bordered table-striped">
	<caption>PDO::PARAM_* constants</caption>
    <thead>
      <tr>
      	<th>Constant</th>
        <th>Type</th>
      </tr>
    </thead>
    <tr>
    	<td>PDO::PARAM_NULL</td>
        <td>NULL</td>
    </tr>
    <tr>
    	<td>PDO::PARAM_BOOL</td>
        <td>boolean</td>
    </tr>
    <tr>
    	<td>PDO::PARAM_INT</td>
        <td>integer</td>
    </tr>
    <tr>
    	<td>PDO::PARAM_STR</td>
        <td>string</td>
    </tr>
    <tr>
    	<td>PDO::PARAM_LOB</td>
        <td>"large object"</td>
    </tr>
</table>

<pre class="prettyprint">
    <h3 class="nocode">Running prepared statements</h3>

//Prepare
$st = $db->prepare("SELECT sign FROM zodiac WHERE element LIKE ?");
//Execute once
$st->execute(array('fire'));
while($row = $st->fetch()){
    print $row[0] . "&l;br />\n";
}
//Execute again
$st->execute(array('water'));
while($row = $st->fetch()){
	print $row[0] . "&lt;br />\n";
}

    <hr />
    <h3 class="nocode">Multiple placeholders</h3>

$st = $db->prepare(
    "SELECT sign FROM zodiac WHERE element LIKE ? OR planet LIKE ?");
    
//SELECT sign FROM zodiac WHERE element LIKE 'earth' OR planet LIKE 'mars'
$st->execute(array('earth', 'Mars'));

    <hr />
    <h3 class="nocode">Using named placeholders</h3>

$st = $db-prepare(
    "SELECT sign FROM zodiac WHERE element LIKE :element OR planet LIKE :planet");
$st->execute(array('planet'=>'Mars', 'element' => 'earth'));
$row = $st->fetch();

    <hr />
    <h3 class="nocode">Using bindParam()</h3>

$pairs = array('Mars' => 'water',
               'Moon' => 'water',
               'Sun' => 'fire');
$st = $db->prepare(
    "SELECT sign FROM zodiac WHERE element LIKE :element AND planet LIKE
    :planet");
$st->bindParam(':element', $element);
$st->bindParam(':planet', $planet);
foreach($pairs as $planet => $element){
    //No need to pass anything to execute()--
    //the values come from $element and $planet
    $st->execute();
    var_dump($st->fetch());
}

    <hr />
    <h3 class="nocode">Putting file contents into a database with PDO::PARAM_LOB</h3>

$st = $db->prepare('INSERT INTO files(path,contents) VALUES(:path,:contents)');
$st->bindParam(':path', $path);
$st->bindParam(':contents',$fp,PDO::PARAM_LOB);
foreach(glob('/usr/local/*') as $path){
    //Get a filehandle that PDO::PARAM_LOB can work with
    $fp = fopen($path, 'r');
    $st->execute();
}
    </pre>


<hr />

<h2><a name="finding_num_rows">Finding the Number of Rows Returned by a Query</a></h2>
<p><b>Problem:</b> You want to know how many rows a SELECT query returned, or you want to know how many rows an INSERT, UPDATE, or DELETE query changed.</p>
<p><b>Solution:</b> If you're issuing an INSERT, UPDATE, or DELETE with PDO::exec(), the return value from exec() is the number of modified rows.</p>
<p>If you're issuing an INSERT, UPDATE, or DELETE with PDO::prepare() and PDOStatment::execute(), call PDOStatment::rowCount() to get the number of modified rows.</p>

<p>If you're issuing a SELECT statment, the only foolproof way to find out how many rows are returned is to retrieve them all with fetchAll() and then count how many rows you have</p>

<p>Documentation on <a href="http://php.net/pdostatement.rowcount" target="_blank">PDOStatment::rowCount</a></p>

<pre class="prettyprint">
    <h3 class="nocode">Counting rows with rowCount()</h3>

$st = $db->prepare('DELETE FROM family WHERE name LIKE ?');
$st->execute(array('Fredo'));
print "Deleted rows: " . $st->rowCount();
$st->execute(array('Sonny'));
print "Deleted rows: " . $st->rowCount();

    <hr />
    <h3 class="nocode">Counting rows from a SELECT</h3>

$st = $db->query('SELECT symbol, planet FROM zodiac');
$all = $st->fetchAll(PDO::FETCH_COLUMN,1);
print "Retrieved " . count($all) . " Rows";
    </pre>


<hr />

<h2><a name="escaping_quotes">Escaping Quotes</a></h2>
<p><b>Problem:</b> You need to make text or binary data safe for queries.</p>
<p><b>Solution:</b> Write all your queries with placeholders so that prepare() and execute() can escape string for you.</p>

<p>If you need to apply escaping yourself, use the PDO::quote() method. The rare circumstance you might need to do this could be if you want to escape SQL wildcards coming from user input:</p>

<p>Documentation on <a href="http://php.net/PDO.quote" target="_blank">PDO::quote()</a></p>

<pre class="prettyprint">
    <h3 class="nocode">Manual quoting</h3>
&lt;?php
$safe = $db->quote($_GET['searchTerm']);
$safe = strtr($safe,array('_' => '\_', '%' => '\%'));
$st = $db->query("SELECT * FROM zodiac WHERE planet LIKE $safe");
?>
    </pre>


<hr />

<h2><a name="logging_debugging">Logging Debugging Information and Errors</a></h2>
<p><b>Problem:</b> you want access to information to help you debug database problems. For example, when a query fails, you want to see what error message the database returns.</p>
<p><b>Solution:</b> Use PDO::errorCode() or PDOStatment::errorCode() after an operation to get an error code if the operation failed.</p>

<p>Documentation on <a href="http://php.net/PDO.errorCode" target="_blank">PDO::errorCode()</a></p>
<p>Documentation on <a href="http://php.net/PDO.errorInfo" target="_blank">PDO::errorInfo()</a></p>
<p>Documentation on <a href="http://php.net/PDOStatement.errorCode" target="_blank">PDOStatement::errorCode()</a></p>
<p>Documentation on <a href="http://php.net/PDOStatement.errorInfo" target="_blank">PDOStatement::errorInfo()</a></p>
<p>Documentation on <a href="http://php.net/set_exception_handler" target="_blank">set_exception_handler()</a></p>
<p>Documentation on <a href="http://php.net/set-error-handler" target="_blank">set_error_handler()</a></p>

<pre class="prettyprint">
    <h3 class="nocode">Printing error information</h3>

$st = $db->prepare('SELECT * FROM imaginary_table');
if(! $st){
    $error = $db->errorInfo();
    print "Problem ({$error[2]})";
}

    <hr />
    <h3 class="nocode">Catching database exceptions</h3>

try {
    $db = new PDO('sqlite:/tmp/zodiac.db');
    //Make all DB errors throw exceptions
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $st = $db->prepare('SELECT * FROM zodiac');
    $st->execute();
    while($row = $st->fetch(PDO::FETCH_NUM)){
        print implode(',',$row). "&lt;br />\n";
    }
} catch (Exception $e){
    print "Database Problem: " . $e->getMessage();
}
    </pre>


<hr />

<h2><a name="creating_unique">Creating Unique Identifiers</a></h2>
<p><b>Problem:</b> You want to assign unique IDs to users, articles, or other objects as you add them to your database.</p>
<p><b>Solution:</b> Use PHP's uniqid() function to generate an identifier. To restrict the set of characters in the identifier, pass it through md5(), which returns a string containing only numerals and letters a through f:</p>

<pre class="prettyprint">
    <h3 class="nocode">Creating unique identifiers</h3>

$st = $db->prepare('INSERT INTO users (id, name) VALUES(?,?)');
$st->execute(array(uniqid(), 'Jacob'));
$st->execute(array(md5(uniqid()), 'Ruby'));
    </pre>


<hr />

<h2><a name="queries_programmatically">Building Queries Programmatically</a></h2>
<p><b>Problem:</b> You want to construct an INSERT or UPDATE query from an array of field names. For example, you want to insert a new user into your database. Instead of hardcoding each field of user information(such as username, email address, postal address, birthdate, etc.), you put the field names in an array and use the array to build the query. This is easy to maintain, especially if you need to conditionally INSERT or UPDATE with the same set of fields.</p>
<p><b>Solution:</b> To construct an UPDATE query, build an array of field/value pairs and them implode() together each element of that array:</p>

<pre class="prettyprint">
    <h3 class="nocode">Building an UPDATE query</h3>

//A list of field names
$fields = array('symbol', 'planet', 'element');

$update_fields = array();
$update_values = array();
foreach($fields as $field){
    $update_fields[] = "$field = ?";
    //Assume the data is coming from a form
    $update_values[] = $_POST[$field];
}   
$st = $db->prepare("UPDATE zodiac SET " . 
                   implode(',',$update_fields) .
                   'WHERE sign = ?');
//Add 'sign' to the values array
$update_values[] = $_GET['sign'];

//Execute the query
$st->execute($update_values); 

    <hr />
    <h3 class="nocode">Building an INSERT query</h3>

// A list of field names
$fields = array('symbol','planet','element');
$placeholders = array();
$values = array();
foreach ($fields as $field) {
    // One placeholder per field
    $placeholders[] = '?';
    // Assume the data is coming from a form
    $values[] = $_POST[$field];
}
$st = $db->prepare('INSERT INTO zodiac (' .
                   implode(',',$fields) .
                   ') VALUES (' .
                   implode(',', $placeholders) .
                   ')');
// Execute the query
$st->execute($values);
    </pre>


<hr />

<h2><a name="paginated">Making Paginated Links for a Series of Records</a></h2>
<p><b>Problem:</b> You want do display a large dataset a page at a time and provide links that move through the dataset.</p>
<p><b>Solution:</b> Use database-appropriate syntax to grab just a section of all the rows that match your query:</p>

<p>Documentation on <a href="http://troels.arvin.dk/db/rdbms/#select-limit-offset" target="_blank">database paging syntaxes</a></p>

<pre class="prettyprint">
    <h3 class="nocode">Paging with SQLite</h3>

//Select 5 rows, starting after the first 3
foreach($db->query('SELECT * FROM zodiac ' .
                   'ORDER By sign LIMIT 5 ' .
                   'OFFSET 3') as $row){
    //Do something with each row                  
}

    <hr />
    <h3 class="nocode">Displaying paginated results</h3>

$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 1;
if(! $offset){$offset = 1;}
$per_page = 5;
$total = $db->query('SELECT COUNT(*) FROM zodiac')->fetchColumn(0);

$limtedSQL = 'SELECT * FROM zodiac ORDER BY id ' .
             "LIMIT $per_page OFFSET " . ($offset-1);
$lastRowNumber = $offset - 1;

foreach ($db->query($limitedSQL) as $row){
    $lastRowNumber++;
    print "{$row['sign']}, {$row['symbol']} ({$row['id']}) &lt;br />\n";
}
indexed_links($total, $offset, $per_page);
print "&lt;br />";
print ("Displaying $offset - $lastRowNumber of $total)";

    <hr />
    <h3 class="nocode">print_link()</h3>

function print_link($inactive,$text,$offset=''){
    if($inactive){
        print "&lt;span class='inactive'>$text&lt;/span>";
    }else{
        print "&lt;span class='active'>".
        "&lt;a href='" . htmlentities($_SERVER['PHP_SELF']) .
        "?offset=$offset'>$test&lt;/a>&lt;/span>";
    }
}

    <hr />
    <h3 class="nocode">indexed_links()</h3>

function indexed_links($total, $offset, $per_page){
    $separator = ' | ';
    
    //print "&lt;&lt;Prev" link
    print_link($offset == 1, '&lt;&lt; Prev', max(1, $offset - $per_page));
    
    //print all groupings except last one
    for($start = 1, $end = $per_page;
        $end &lt; $total;
        $start += $per_page, $end += $per_page){
            print $separator;
            print_link($offset == $start, "$start-$end", $start);
        }
    /* print the last grouping -
     * at this point, $start points to the element at the beginning
     * of the last grouping
     */
    /* The text should only contain a range if there's more than
     * one element on the last page. For example, the last grouping
     * of 11 elements with 5 per page should just say "11", not "11-11"
     */
    $end = ($total > $start) ? "-$total" : '';
    
    print $separator;
    print_link($offset == $start, "$start$end", $start);
    
    //print "Next>>" link
    print $separator;
    print_link($offset == $start, 'Next >>', $offset + $per_page);
}
    </pre>


<hr />

<h2><a name="caching_queries">Caching Queries and Results</a></h2>
<p><b>Problem:</b> You don't want to rerun potentially expensive database queries when the results haven't changed.</p>
<p><b>Solution:</b> Use PEAR's Cache_Lite package. It makes it simple to cache arbitrary data. In this case, cache the results of a SELECT query and use the text of the query as a cache key.</p>

<p>How to <a href="http://dev.mysql.com/doc/refman/5.1/en/query-cache.html" target="_blank">enable MySQL's query cache.</a></p>
<p>Documentation on <a href="http://pear.php.net/manual/en/package.caching.cache-lite.php" target="_blank">Cache_Lite</a></p>

<pre class="prettyprint">
    <h3 class="nocode">Caching query results</h3>
&lt;?php

require_once 'Cache/Lite.php';

$opts = array(
    //Where to put the cached data
    'cacheDir' => '/tmp/',
    //Let us store arrays in the cache
    'automaticSerialization' => true,
    //How long stuff lives in the cache
    'lifetime' => 600 /* ten minutes */);

//Create the cache
$cache = new Cache_Lite($opts);

//Connect to the database
$db = new PDO(sqlite:/tmp/zodiac.db);

//Define our query and its parameters
$sql = "SELECT * FROM zodiac WHERE planet = ?";
$params = array($_GET['planet']);

//Get the unique cache key
$key = cache_key($sql, $params);

//Try to get results from the cache
$results = $cache->get($key);

if($results === false){
    //No results found, so do the query and put the resulst in the cache
    $st = $db->prepare($sql);
    $st->execute($params);
    $results = $st->fetchAll();
    $cache->save($results);
}

//Whether from the cache or not, $results has our data
foreach($results as $result){
    print "$result[id]: $result[planet], $result[sign] &lt;br />\n";
}

function cache_key($sql, $params){
    return md5($sql.
           implode('|',array_key($params)) .
           implode('|',$params));
}

?>
    </pre>


<hr />

<h2><a name="accessing_db_anywhere">Accessing a Database Connection Anywhere in Your Program</a></h2>
<p><b>Problem:</b> You've got a program with lots of functions and classes in it, and you want to maintain a single database connection that's easily accessible from anywhere in the program.</p>
<p><b>Solution:</b> Use a static method that creates the connection if it doesn't exist and returns the connection</p>

<p>Documentation on <a href="http://php.net/PDO.__construct" target="_blank">PDO::__construct()</a></p>
<p>Documentation on <a href="http://php.net/language.oop5.reflection" target="_blank">ReflectionClass::newInstanceArgs()</a></p>

<pre class="prettyprint">
    <h3 class="nocode">Creating a database connection in a static class method</h3>
&lt;?php

class DBCxn {
    //What DSN to connect to?
    public static $dsn = 'sqlite:c:/data/zodiac.db';
    public static $user = null;
    public static $pass = null;
    public static $driverOpts = null;
    
    //Internal variable to hold the connection
    private static $db;
    //No cloning or instantiating allowed
    final private function __construct(){}
    final private function __clone(){}
    
    public static function get(){
        //Connect if not already connected
        if(is_null(self::$db)){
            self::$db = new PDO(self::$dsn, self::$user, self::$pass,
                                self::$driverOpts);
           
        }
        //Return the connection
        return self::$db;
    }
}
?>

    <hr />
    <h3 class="nocode">Handling connections to multiple databases</h3>
&lt;?php

class DBCxn {

    // What DSNs to connect to?
    public static $dsn = array(
             'zodiac' => 'sqlite:c:/data/zodiac.db',
             'users' => array('mysql:host=db.example.com','monty','7f2iuh'),
             'stats' => array('oci:statistics', 'statsuser','statspass')
            );
            
    // Internal variable to hold the connection
    private static $db = array();
    
    // No cloning or instantiating allowed
    final private function __construct() { }
    
    final private function __clone() { }
    
    public static function get($key) {
        if (! isset(self::$dsn[$key])) {
            throw new Exception("Unknown DSN: $key");
        }
        
        // Connect if not already connected
        if (! isset(self::$db[$key])) {
            if (is_array(self::$dsn[$key])) {
                $c = new ReflectionClass('PDO');
                self::$db[$key] = $c->newInstanceArgs(self::$dsn[$key]);
            else {
                self::$db[$key] = new PDO(self::$dsn[$key]);
            }
        }
        
        // Return the connection
        return self::$db[$key];
    }
} 

?>  
    </pre>


<hr />

<h2><a name="program_storing">Program: Storing a Threaded Message Board</a></h2>
<hr />

<h2><a name="using_redis">Using Redis</a></h2>
<p><b>Problem:</b> You want to use Redis key-value store from your PHP program.</p>
<p><b>Solution:</b> If you can install PECL extensions, install the redis extension and then use it:</p>

<p>If you can't, use the Predis library</p>

<pre class="prettyprint">
$redis = new Redis();
$redis->connect('counter', 0);
$redis->set('counter', 0);
$resis->incrBy('counter', 7);
$counter = $redis->get('counter');
print $counter;

<hr />
require 'Predis/Autoloader.php';
Predis\Autoloader::register();

$redis = new Predis\Client(array('host'=>'127.0.0.1'));
$redis->set('counter',0);
$redis->incrBy('counter',7);
$counter = $redis->get('counter');
print $counter;
    </pre>





      
      
      
</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>