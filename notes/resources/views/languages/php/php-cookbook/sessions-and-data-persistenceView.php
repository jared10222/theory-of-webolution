<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

      <div class="page-header">
        <h1>Sessions &amp; Data Persistence</h1>
      </div>



<table class="table table-responsive table-bordered">
	<caption>Table of Contents</caption>
    <tr>
    	<td><a href="#using_session_tracking">Using Session Tracking</a></td>
        <td><a href="#preventing_hijacking">Preventing Session Hijacking</a></td>
        <td><a href="#preventing_fixation">Preventing Session Fixation</a></td>
        <td><a href="#memcached">Storing Sessions in Memcached</a></td>
    </tr>
    <tr>
    	<td><a href="#database">Storing Sessions in a Database</a></td>
        <td><a href="#arbitrary_data">Storing Arbitrary Data in Shared Memory</a></td>
        <td><a href="#calculated">Caching Calculated Results in Summary Tables</a></td>
        <td></td>
    </tr>
   
</table>

<hr />

<h2><a name="using_session_tracking">Using Session Tracking</a></h2>
<p><b>Problem:</b> You want to maintain information about a user as she moves through your site.</p>
<p><b>Solution:</b> Use the sesions module. The session_start() function initializes a session, and accessing an element in the superglobal $_SESSION array tells PHP to keep track of the corresponding variable:</p>

<p>Documentation on <a href="http://php.net/session-start" target="_blank">session_start()</a></p>
<p>Documentation on <a href="http://php.net/session-save-path" target="_blank">session_save_path().</a></p>
<p>Sessions section of the <a href="http://php.net/manual/en/features.sessions.php" target="_blank">online manual</a></p>

<pre class="prettyprint">
&lt;?php

session_start();
if(!isset($_SESSION['visits'])){
    $_SESSION['visits'] = 0;
}
$_SESSION['visits']++;
print 'You have visisted here ' . $_SESSION['visists']. ' times.';

?>
    </pre>


<hr />

<h2><a name="preventing_hijacking">Preventing Session Hijacking</a></h2>
<p><b>Problem:</b> You want to make sure an attacker can't access another user's session.</p>
<p><b>Solution:</b> Allow passing of session IDs via cookies only, and generate an additional session token that is passed via URLs. Only requests that contain a valid session ID and a valid session token may access the session:</p>

<pre class="prettyprint">
ini_set('session.use_only_cookies', true);
session_start();

$salt = 'YourSpecialValueHere';
$tokenstr = strval(date('W')) . $salt;
$token = md5($tokenstr);

if(!isset($_REQUEST['token']) || $_REQUEST['token'] != $token){
    //prompt for login
    exit;
}
$_SESSION['token'] = $token;
output_add_rewrite_var('token', $token);
    </pre>


<hr />

<h2><a name="preventing_fixation">Preventing Session Fixation</a></h2>
<p><b>Problem:</b> You want to make sure that your application is not vulnerable to session fixation attacks, in which an attacker forces a user to use a predetermined session ID.</p>
<p><b>Solution:</b> Require the use of session cookies without session identifiers appended to URLs, and generate a new session ID frequently:</p>

<p><a href="http://www.acros.si/papers/session_fixation.pdf" target="_blank">Session Fixation Vulnerability in Web-based Applications</a></p>

<pre class="prettyprint">
ini_set('session.use_only_cookies', true);
session_start();
if(!isset($_SESSION['generated'])
    || $_SESSION['generated'] &lt; (time() - 30)){
        session_regenerate_id();
        $_SESSION['generated'] = time();
    }
    </pre>


<hr />

<h2><a name="memcached">Storing Sessions in Memcached</a></h2>
<p><b>Problem:</b> You want to store session data somewhere that's fast and can be accessed by multiple webservers.</p>
<p><b>Solution:</b> Use the session handler built into the memcached extension to store your sessions in one or more Memcached servers.

<p>Documentation on how to configure the <a href="http://php.net/memcached.configuration" target="_blank">memcached extension</a></p>
<p>Documentation on how to configure the <a href="http://php.net/memcache.ini" target="_blank">memcache extension</a></p>
<p><a href="http://memcached.org/" target="_blank">Memcached itself</a></p>
<hr />

<h2><a name="database">Storing Sessions in a Database</a></h2>
<p><b>Problem:</b> You want to store session data in a database instead of in files. if multiple web servers all have access to the same database, the session data is then mirrored across all the web servers.</p>
<p><b>Solution:</b> Use a class in conjunction with the session_set_save_handler() function to define database-aware routines for session management.</p>

<p>Documentation on <a href="http://php.net/session-set-save-handler" target="_blank">session_set_save_handler()</a></p>
<p>Documentation on <a href="http://php.net/class.SessionHandlerInterface" target="_blank">SessionHandlerInterface</a></p>

<pre class="prettyprint">
    <h3 class="nocode">Database-backed session handler</h3>
&lt;?php

/**Implementing SessionHandlerInterface is mandatory as of PHP 5.4
* and will fail in previous versions
*/
class DBHandler implements SessionHandlerInterface {
    protected $dbh;
    
    public function open($save_path, $name){
        try {
            $this->connect($save_path, $name){
            return true;
        }catch (PDOException $e){
            return false;
        }
    }
    
    public function close(){
        return true;
    }
    
    public function destroy($session_id){
        $sth = $this->dbh->prepare("DELETE FROM sessions WHERE session_id = ?");
        $sth->execute(array($session_id));
        return true;
    }
    
    public function gc($maxlifetime){
        $sth = $this->dbh->prepare("DELETE FROM sessions WHERE last_update &lt; ?");
        $sth = execute(array(time() - $maxlifetime));
        return true;
    }
    
    public function read($session_id){
        $sth = $this->dbh->prepare("SELECT session_data FROM sessions WHERE
                                   session_id=?");
        $sth->execute(array($session_id));
        $rows = $sth->fetchAll(PDO::FETCH_NUM);
        if(count($rows) == 0){
            return '';
        }else{
            return $rows[0][0];
        }
    }
    
    public function write($session_id, $session_data){
        $now = time();
        $sth = $this->dbh->prepare("UPDATE sessions SET session_data = ?,
                                   last_update = ? WHERE session_id = ?");
        $sth->execute(array($session_data, $now, $session_id));
        if($sth->rowCount() == 0){
            $sth2 = $this->dbh->prepare('INSERT INTO sessions (session_id,
                                        session_data, last_update)
                                        VALUES(?,?,?)');
            $sth2->execute(array($session_id, $session_data, $now));
        }
    }
    
    public function createTable($save_path, $name, $connect = true){
        if($connect){
            $this->connect($save_path, $name);
        }
        $sql=&lt;&lt;&lt;_SQL_
        CREATE TABLE sessions (
          session_id VARCHAR(64) NOT NULL,
          session_data MEDIUMTEXT NOT NULL,
          last_update TIMESTAMP NOT NULL,
          PRIMARY KEY (session_id)
        )
        _SQL_;
            $this->dbh->exec($sql);
    }
    
    protected function connect($save_path){
        /*Look for user and password in DSN as "query string" params*/
        $parts = parse_url($save_path);
        if(isset($parts['query'])){
            parse_str($parts['query'], $query);
            $user = isset($query['user']) ? $query['user'] : nuyll;
            $password = isset($query['password']) ? $query['password'] : null;
            $dsn = $parts['scheme'] . ':';
            if(isset($parts['host'])){
                $dsn .='//' . $parts['host'];
            }
            $dsn .= $parts['path'];
            $this->dbh = new PDO($dsn, $user, $password);
        }else{
            $this->dbh = new PDO($save_path);
        }
        $this->dbh-setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //A very simple way to creat the session table if it doesn't exist.
        try {
            $this->dbh->query('SELECT 1 FROM sessions LIMIT 1');
        }catch (Exception $e){
            $this->createTable($save_path, NULL, false);
        }
    }
}


//To use this session handler, instantiate the class and pass
//it to session_set_save_handler():

include __DIR__.'/db.php';
ini_set('session.save_path', 'sqlit:/tmp/sessions.db');
session_set_save_handler(new DBHandler);

session_start();
if(!isset($_SESSION['visits'])){
    $_SESSION['visits'] = 0;
}
$_SESSION['visits']++;

?>
    </pre>


<hr />

<h2><a name="arbitrary_data">Storing Arbitrary Data in Shared Memory</a></h2>
<p><b>Problem:</b> You want a chunk of data to be available to all server processes through shared memory.</p>
<p><b>Solution:</b> If you want to share data only amongst PHP processes, use APC. If you want to share data with other processes as well, use the pc_Shm class below:</p>

<p>Documentation on <a href="http://php.net/shmop" target="_blank">shmop functions</a></p>

<pre class="prettyprint">
//for example, to store a string in shared memory, use the pc_Shm::write()
//method, which accepts a key, a length, and a valu.
$shm = new pc_Shm();
$secret_code = 'land shark';
$shm->write('mysecret', strlen($secret_code), $secret_code);

    <hr />
    <h3 class="nocode">Storing arbitrary data in shared memory</h3>

class pc_Shm {
    
    protected $tmp;
    
    public function __construct($tmp = '') {
        if (!function_exists('shmop_open')) {
            trigger_error('pc_Shm: shmop extension is required.', E_USER_ERROR);
            return;
        }
        if ($tmp != '' && is_dir($tmp) && is_writable($tmp)) {
            $this->tmp = $tmp;
        } else {
            $this->tmp = '/tmp';
        }
    }
    
    public function read($id, $size) {
        $shm = $this->open($id, $size);
        $data = shmop_read($shm, 0, $size);
        $this->close($shm);
        if (!$data) {
            trigger_error('pc_Shm: could not read from shared memory block', E_USER_ERROR);
            return false;
        }
            return $data;
    }
    
    public function write($id, $size, $data) {
        $shm = $this->open($id, $size);
        $written = shmop_write($shm, $data, 0);
        $this->close($shm);
        if ($written != strlen($data)) {
            trigger_error('pc_Shm: could not write entire length of data', E_USER_ERROR);
            return false;
        }
            return true;
    }
    
    public function delete($id, $size) {
        $shm = $this->open($id, $size);
        if (shmop_delete($shm)) {
            $keyfile = $this->getKeyFile($id);
                if (file_exists($keyfile)) {
                    unlink($keyfile);
                }
            }
        return true;
    }
    
    protected function open($id, $size) {
        $key = $this->getKey($id);
        $shm = shmop_open($key, 'c', 0644, $size);
        if (!$shm) {
            trigger_error('pc_Shm: could not create shared memory segment', E_USER_ERROR);
            return false;
        }
            return $shm;
     }
     
    protected function close($shm) {
        return shmop_close($shm);
    }
    
    protected function getKey($id) {
        $keyfile = $this->getKeyFile($id);
        if (! file_exists($keyfile)) {
            touch($keyfile);
        }
        return ftok($keyfile, 'R');
    }
    
    protected function getKeyFile($id) {
        return $this->tmp . DIRECTORY_SEPARATOR . 'pcshm_' . $id;
    }
}
}
    </pre>


<hr />

<h2><a name="calculated">Caching Calculated Results in Summary Tables</a></h2>
<p><b>Problem:</b> You need to collect statistics from log tables that are too large to efficiently query in real time.</p>
<p><b>Solution:</b> Create a table that stores summary data from the complete log table, and query the summary table to generate reports in nearly real time.</p>

<pre class="prettyprint">
CREATE TABLE searches
(
searchterm VARCHAR(255) NOT NULL, -- search term determined from
-- HTTP_REFERER parsing
dt DATETIME NOT NULL, -- request date
source VARCHAR(15) NOT NULL -- site where search was performed
);

CREATE TABLE searchsummary
(
searchterm VARCHAR(255) NOT NULL, -- search term
source VARCHAR(15) NOT NULL, -- site where search was performed
sdate DATE NOT NULL, -- date search performed
searches INT UNSIGNED NOT NULL, -- number of searches
PRIMARY KEY (searchterm, source, sdate)
);

$st = $db->prepare('SELECT COUNT(*)
FROM
searchsummary
WHERE
sdate = ?');
$st->execute(array(date('Y-m-d', strtotime('yesterday'))));
$row = $st->fetch();
// no matches in cache
if ($row[0] == 0) {
$st2 = $db->prepare('SELECT
searchterm,
source,
date(dt) AS sdate,
COUNT(*) as searches
FROM
searches
WHERE
date(dt) = ?');
$st2->execute(array(date('Y-m-d', strtotime('yesterday'))));
$stInsert = $db->prepare('INSERT INTO searchsummary
(searchterm,source,sdate,searches)
VALUES (?,?,?,?)');
while ($row = $st2->fetch(PDO::FETCH_NUM)) {
$stInsert->execute($row);
}
}
    </pre>



      
      
      
</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>