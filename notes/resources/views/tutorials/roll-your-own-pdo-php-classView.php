<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">


<div class="page-header">
        <h1>Roll Your Own PDO PHP Class</h1>
</div>


<pre class="prettyprint">
//tutorial.php
include 'database.class.php';

//Define configuration
define("DB_HOST", "localhost");
define("DB_USER", "username");
define("DB_PASS", "password");
define("DB_NAME", "database");

//Instantiate database.
$database = new Database();

<hr />

//Database Class
&lt;?php

class Database {

    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    
    private $dbh;
    private $error;
    
    private $stmt;
    
    public function __construct(){
        
        //Set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        
        //Set options
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        
        try {
           //$this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
           
           //CORRECT WAY WHEN EXTENDING THE PDO CLASS
           //class Database Extends PDO
           //OKAY, MAYBE NOT!
           $this->dbh = parent::__construct($dsn, $this->user, $this->pass, $options);
        }
        //Catch any errors
        catch (PDOException $e){
            $this->error = $e->getMessage();
        }
        
    }
    
    public function query($query){
        $this->stmt = $this->dbh->prepare($query);
    }
    
    public function bind($param, $value, $type = null){
        if(is_null($type)){
            switch(true){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        
        $this->stmt->bindValue($param, $value, $type);
    }
    
    public function execute(){
        return $this->stmt->execute();
    }
    
    public function resultset(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function single(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function rowCount(){
        return $this->stmt->rowCount();
    }
    
    public function lastInsertId(){
        return $this->dbh->lastInsertId();
    }
    
    public function beginTransaction(){
        return $this->dbh->beginTransaction();
    }
    
    public function endTransaction(){
        return $this->dbh->commit();
    }
    
    public function cancelTransaction(){
        return $this->dbh->rollBack();
    }
    
    public function debugDumpParams(){
        return $this->stmt->debugDumpParams();
    }
    
}
</pre>

<hr />
<h2>Using your PDO Class</h2>
<hr />

<h3>Insert a new record</h3>
<pre class="prettyprint">
$database = new Database();

$query = "INSERT INTO mytable (FName, LName, Age, Gender) VALUES (:fname, :lname, :age, :gender)";
$database->query($query);

$database->bind(':fname', 'John');
$database->bind(':lname', 'Smith');
$database->bind(':age', '24');
$database->bind(':gender', 'male');

$database->execute();

echo $database->lastInsertId();
</pre>

<hr />

<h3>Insert multiple records using a Transaction</h3>
<p>The next test we will try is to insert multiple records using a Transaction so that we don't have to repeat the query</p>

<pre class="prettyprint">
$database->beginTransaction();

$query = "INSERT INTO mytable (FName, LName, Age, Gender) VALUES (:fname, :lname, :age, :gender)";
$database->query($query);

$database->bind(':fname', 'Jenny');
$database->bind(':lname', 'Smith');
$database->bind(':age', '23');
$database->bind(':gender', 'female');

$database->execute();

$database->bind(':fname', 'Jilly');
$database->bind(':lname', 'Smith');
$database->bind(':age', '25');
$database->bind(':gender', 'female');

$database->execute();

echo $database->lastInsertId();

$database->endTransaction();
</pre>

<hr />
<h3>Select a single row</h3>

<pre class="prettyprint">
$query = "SELECT FName, LName, Age, Gender FROM mytable WHERE FName = :fname";
$database->query($query);
$database->bind(':fname', 'Jenny');
$row = $database->single();

echo "&lt;pre>";
print_r($row);
echo "&lt;/pre>";

</pre>

<hr />
<h3>Select multiple rows</h3>
<pre class="prettyprint">
&lt;?php
$query = "SELECT FName, LName, Age, Gender FROM mytable WHERE LName = :lname";
$database->query($query);
$database->bind(':lname', 'Smith');
$rows = $database->resultset();

echo "&lt;pre>";
print_r($rows);
echo "&lt;/pre>";

echo $database->rowCount();
?>
</pre>


<hr />
<a href="http://culttt.com/2012/10/01/roll-your-own-pdo-php-class/" target="_blank">Original Source</a>
<hr />

</div>

<?php require_once(assets("includes/footer.php")); ?>