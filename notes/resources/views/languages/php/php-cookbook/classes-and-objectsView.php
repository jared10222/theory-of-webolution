<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

      <div class="page-header">
        <h1>Classes &amp; Objects</h1>
      </div>
 


<table class="table table-responsive table-bordered">
	<caption>Table of Contents</caption>
    <tr>
    	<td><a href="#instantiating">Instantiating Objects</a></td>
        <td><a href="#defining_constructors">Defining Ojbect Constructors</a></td>
        <td><a href="#defining_destructors">Defining Object Destructors</a></td>
        <td><a href="#implementing_access_control">Implementing Access Control</a></td>
    </tr>
    <tr>
    	<td><a href="#preventing_changes">Preventing Changes to Classes and Methods</a></td>
        <td><a href="#stringification">Defining Object Stringification</a></td>
        <td><a href="#bahave_similarly">Requiring Multiple Classes to Behave Similarly</a></td>
        <td><a href="#abstract_classes">Creating Abstract Base Classes</a></td>
    </tr>
    <tr>
    	<td><a href="#assigning_reference">Assigning Object References</a></td>
        <td><a href="#cloning">Cloning Objects</a></td>
        <td><a href="#overriding">Overriding Property Accesses</a></td>
        <td><a href="#cmoaorbam">Calling Methods on an Object Returned by Another Method</a></td>
    </tr>
    <tr>
        <td><a href="#aggregating_objects">Aggregating Objects</a></td>
        <td><a href="#accessing_overridden_methods">Accessing Overridden Methods</a></td>
        <td><a href="#creating_methods_dynamically">Creating Methods Dynamically</a></td>
        <td><a href="#using_polymorphism">Using Method Polymorphism</a></td>
    </tr>
    <tr>
    	<td><a href="#defining_class_constants">Defining Class Constants</a></td>
        <td><a href="#Defining_static">Defining Static Properties and Methods</a></td>
        <td><a href="#controlling_serialization">Controlling Object Serialization</a></td>
        <td><a href="#introspecting">Introspecting Objects</a></td>
    </tr>
    <tr>
    	<td><a href="#ciaoiaioasc">Checking If an Object Is an Instance of a Specific Class</a></td>
        <td><a href="#autoloading">Autoloading Class Files upon Object Instantiation</a></td>
        <td><a href="#instantiating_dynamically">Instantiating an Object Dynamically</a></td>
        <td><a href="#Program">Program: whereis</a></td>
    </tr>
    
     
</table>

<hr />

<h2><a name="instantiating">Instantiating Objects</a></h2>
<p><b>Problem:</b> You want to create a new instance of an object.</p>
<p><b>Solution:</b> Define the class, then use <b>new</b> to create an instance of the class:</p>

<p>Documentation on <a href="http://php.net/oop" target="_blank">classes and objects</a></p>

<pre class="prettyprint">
class user {
    function load_info($username){
        //load profile from database
    }
}

$user = new user;
$user->load_info($_GET['username']);
    </pre>

<hr />

<h2><a name="defining_constructors">Defining Object Constructors</a></h2>
<p><b>Problem:</b> You want to define a method that is called when an object is instantiated. For example, you want to automatically load information from a database upon creation.</p>
<p><b>Solution:</b> Define a method named __construct():</p>

<p>Documentation on <a href="http://php.net/oop5.decon" target="_blank">object constructors</a></p>

<pre class="prettyprint">
class user {
    function __construct($username, $password){
        //...
    }
}
    </pre>


<hr />

<h2><a name="defining_destructors">Defining Object Destructors</a></h2>
<p><b>Problem:</b> You want to define a method that is called when an object is destroyed. For example, you want to automatically save information from a database into an object when it's deleted.</p>
<p><b>Solution:</b> Objects are automatically destroyed when a script terminates. To force the destruction of an object, use unset():</p>

<p>To make PHP call a method when an object is eliminated, define a method named __destruct():</p>

<pre class="prettyprint">
$car = new car; //buy new car
//...
uset($car); //car wreck

class car {
    function __destruct(){

        //head to car dealer
    }
}
    </pre>


<hr />

<h2><a name="implementing_access_control">Implementing Access Control</a></h2>
<p><b>Problem:</b> You want to assign a visibility to methods and properties so they can only be accessed within classes that have a specific relationshiop to the object.</p>
<p><b>Solution:</b> Use the public, protected, and private keywords</p>

<pre class="prettyprint">
class Person {
    public $name; //accessible anywhere
    protected $age; //accessible within the class and child classes
    private $salary; //accessible only within this specific class
    
    public function __construct(){
      //...
    }
    
    protected function set_age(){
      //...
    }
    
    private function set_salary(){
      //...
    }
}
    </pre>


<hr />

<h2><a name="preventing_changes">Preventing Changes to Classes and Methods</a></h2>
<p><b>Problem:</b> You want to prevent another developer from redefining specific methods within a child class, or even from subclassing the entire class itself.</p>
<p><b>Solution:</b> Label the particular methods or class as final:</p>

<pre class="prettyprint">
final public function connect($server, $username, $password){
    //Method defined here
}
 
final class MySQL {
    //Class definition here
}
    </pre>


<hr />

<h2><a name="stringification">Defining Object Stringification</a></h2>
<p><b>Problem:</b> You want to control how PHP displays an object when you print it.</p>
<p><b>Solution:</b> Implement a __toString() method:</p>

<pre class="prettyprint">
class Person {
    //Rest of class here
    
    public function __toString(){
        return "$this->name &lt;$this->email>";
    }
}
    </pre>


<hr />

<h2><a name="bahave_similarly">Requiring Multiple Classes to Behave Similarly</a></h2>
<p><b>Problem:</b> You want multiple classes to use the same methods, but it doesn't make sense for all the classes to inherit from a common parent class.</p>
<p><b>Solution:</b> Define an interface and declare that your class will implement that interface:</p>

<p>When you want to include the code that implements the interface, define a trait and declare that your classes will use that trait:</p>

<p>To check if a class implements a specific interface, use class_implements():</p>

<p>When you want to share code across two classes, use a trait:</p>

<p>You can use interfaces and traits together. This is actually a best-practice design:</p>

<p>Documentation on <a href="http://php.net/class_implements" target="_blank">class_implements()</a></p>
<p>Documentation on <a href="http://php.net/interfaces" target="_blank">interfaces</a></p>
<p>Documentation on <a href="http://php.net/traits" target="_blank">traits</a></p>

<pre class="prettyprint">
interface NameInterface {
    public function getName();
    public function setName($name);
}

class Book implements NameInterface {
    private $name;
    
    public function getName(){
        return $this->name;
    }
    
    public function setName($name){
        return $this->name = $name;
    }
}

<hr />
trait NameTrait {
	private $name;
    
    public function getName(){
        return $this->name;
    }
    
    public function setName($name){
        return $this->name = $name;
    }
}

class Book {
    use NameTrait;
}

class Child {
    use NameTrait;
}

    <hr />
    <h3 class="nocode">class_implements</h3>

class Book implements NameInterface {
    //..Code here
}

$interfaces = class_implements('Book');
if(isset($interfaces['NameInterface'])){
    //Book Implements NameInterface
}

//You can also use the Reflection classes:
class Book implements NameInterface {
    //..Code here
}

$rc = new ReflectionClass('Book');
if($rc->implementsInterface('NameInterface')){
    print "Book implements NameInterface\n";
}

    <hr />
    <h3 class="nocode">trait:</h3>

trait NameTrait {
    private $name;
    
    public function getName(){
        return $this->name;
    }
    
    public function setName($name){
        return $this->name = $name;
    }
}

class Book {
    use NameTrait;
}

$book = new Book;
$book->setName('PHP Cookbook');
print $book->getName();

    <hr />
    <h3 class="nocode">interfaces and traits together</h3>

class Book implements NameInterface {
    use NameTrait;
}

//implement multiple
class Book implements NameInterface, SizeInterface {
    use NameTrait, SizeTrait;
}
    </pre>


<hr />

<h2><a name="abstract_classes">Creating Abstract Base Classes</a></h2>
<p><b>Problem:</b> you want to create an <i>abstract class</i>, or, in other words, one that is not directly instantiable, but acts as a common base for children classes.</p>
<p><b>Solution:</b> Label the class as abstract:</p>

<p>You must also define at least one abstract method in your class. Do this by placing the abstract keyword in front of the method definition:</p>

<p>Abstract methods, like methods listed in an interface, are not implemented inside the abstract class. Instead, abstract methods are implemented in a child class that extends the abstract parent. For instance, you could use a MySQL class:</p>

<p>There are two requirements for abstract methods:</p>
<ul>
    <li>Abstract methods cannot be defined <b>private</b>, because they need to be inherited.</li>
    <li>Abstract methods cannot be defined <b>final</b>, because they need to be overridden.</li>
</ul>

<p>You should also use abstract classes when the "is a" rule applies. For example, because you can say "MySQL is a Database", it makes send for Database to be an abstract class. In contrast, you cannot say, "Book is a NameInterface" or "Book is a Name", so NameInterface should be an interface.</p>

<pre class="prettyprint">
abstract class Database {
    //...
}

abstract class Database {
   abstract public function connect($server, $user, $pass, $db);
   abstract public function query($sql);
   abstract public function fetch();
   abstract public function close();
}

class MySQL extends Database {
    protected $dbh;
    protected $query;
    
    public function connect($server, $user, $pass, $db){
        $this->dbh = mysqli_connect($server, $user,
                                    $pass, $db);
    }
    
    public function query($sql){
        $this->query = myqsli_query($this->dbh, $sql);
    }
    
    public function fetch(){
        return mysqli_fetch_row($this->dbh, $this->query);
    }
    
    public function close(){
        mysqli_close($this->dbh);
    }
}
    </pre>


<hr />

<h2><a name="assigning_reference">Assigning Object References</a></h2>
<p><b>Problem:</b> You want to link two objects, so when you update one, you also update the other.</p>
<p><b>Solution:</b> Use = to assign one object to another by reference:</p>

<p>When you do an object assignment using =, you don't create a new copy of an object, but a reference to the first. So, modifying one alters the other.</p>

<p>Documentation on <a href="http://php.net/references" target="_blank">references</a></p>

<pre class="prettyprint">
$adam = new user;
$dave = $adam;
    </pre>


<hr />

<h2><a name="cloning">Cloning Objects</a></h2>
<p><b>Problem:</b> You want to copy an object.</p>
<p><b>Solution:</b> Copy objects by reference using =:</p>
<p>Copy objects by value using clone:</p>

<p>Control how PHP clones an object by implementing a __clone() method in your class. When this method exists, PHP allows __clone() to override its default behavior:</p>

<pre class="prettyprint">
$rasmus = $zeev;

$rasmus = clone $zeev;

<hr />

class Person {
    //...everything from before
    public function __clone(){
        $this->address = clone $this->address;
    }
}
    </pre>


<hr />

<h2><a name="overriding">Overriding Property Accesses</a></h2>
<p><b>Problem:</b> You want handler functions to execute whenever you read and write object properties. This lets you write generalized code to handle property access in your class.</p>
<p><b>Solution:</b> Use the magic methods __get() and set() to intercept property requests.</p>

<p>To improve this abstraction, also implement __isset() and __unset() methods to make the class behave correctly when you check a property using isset() or delete it using unset().</p>

<p>Property overloading allows you to seamlessluy obscure from the user the actual location of your object's properties and the data structure you use to store them.</p>

<p>For example, the Person class stores variables in an array, $__data(The name of the variable doesn't need begin with two underscores, that's just to indicate to you that it's used by a magic method.)</p>

<p>When you set data, __set() rewrites the element inside of $__data. Likewise, use __get() to trap the call and return the correct array element.</p>

<p>Using these methods and an array as the alternate variable storage source makes it less painful to implement object encapsulation. Instead of writing a pair of accessor methods for every class property, you use __get() and __set().</p>

<p>Documentation on <a href="http://php.net/oop5.overloading" target="_blank">overloaded methods</a></p>

<pre class="prettyprint">
class Person {
    private $_data = array();
    
    public function __get($property){
        if(isset($this->__data[$property])){
            return $this->__data[$property];
        }else{
            return false;
        }
    }
    
    public function __set($property, $value){
        $this->__data[$property] = $value;
    }
} 

$johnwood = new Person;
$johnwood->email = 'jonathan@wopr.mil'; //sets $user->__data['email']
print $johnwood->email;  //reads $user->__data['email']; 

//here's how to also enforce exactly what properties are legal 
//and illegal for a given class:
class Person {
    //list person and email as valid properties
    protected $__data = array('person'=>false, 'email'=>false);
    
    public function __get($property){
        if(isset($this->__data[$property])){
            return $this->__data[$property];
        }else{
            return false;
        }
    }
    
    //enforce the restriction of only setting
    //predefined properties
    public function __set($property, $value){
        if(isset($this->__data[$property])){
            return $this->__data[$property] = $value;
        }else{
            return false;
        }
    }
}  
    </pre>


<hr />

<h2><a name="cmoaorbam">Calling Methods on an Object Returned by Another Method</a></h2>
<p><b>Problem:</b> You need to call a method on an object returned by another method.</p>
<p><b>Solution:</b> Call the second method directly from the first:</p>

<p>You can design your classes to facilitate chaining calls repeatedly as if you're writing a sentence. This is known as <b>fluent interface.</b>

<pre class="prettyprint">
$orange = $fruit->get('citrus')->peel();

    <hr />
    <h3 class="nocode">fluent interface</h3>

$tweet = new Tweet;
$tweet->from('@rasmus')
      ->withStatus('PHP 6 released! #php')
      ->send();
//By stringing together a set of method calls, you build up the 
//Tweet one segment at a time, then send it to the world.
    </pre>


<hr />

<h2><a name="aggregating_objects">Aggregating Objects</a></h2>
<p><b>Problem:</b> You want to compose two or more object together so that they appear to behave as a single object.</p>
<p><b>Solution:</b> Aggregate the objects together and use the __call() and __callStatic() magic methods to intercept method invocations and route them accordingly</p>

<p>Documentation on <a href="http://php.net/oop5.magic" target="_blank">magic methods</a></p>

<pre class="prettyprint">
class Address {
    protected $city;
    
    public function setCity($city){
        $this->city = $city;
    }
    
    public function getCity(){
        return $this->city;
    }
}

class Person {
    protected $name;
    protected $address;
    
    public function __construct(){
        $this->address = new Address;
    }
    
    public function setName($name){
        $this->name = $name;
    }
    
    public function getName(){
        return $this->name;
    }
    
    public function __call($method, $arguments){
        if(method_exists($this->address, $method)){
            return call_user_func_array(
                array($this->address, $method), $arguments);
                
        }
    }
}

$rasmus = new Person;
$rasmus->setName('Rasmus Lerdorf');
$resmus->SetCity('Sunnyvale');

print $rasmus->getName() . ' lives in ' . $rasmus->getCity() . '.';
    </pre>


<hr />

<h2><a name="accessing_overridden_methods">Accessing Overridden Methods</a></h2>
<p><b>Problem:</b> You want to access a method in the parent class that's been overridden in the child.</p>
<p><b>Solution:</b> Prefix parent to the method name:</p>

<p>Documentation on <a href="http://php.net/keyword.parent" target="_blank">class parents</a></p>
<p>Documentation on <a href="http://php.net/get-parent-class" target="_blank">get_parent_class()</a></p>

<pre class="prettyprint">
class shape {
    function draw(){
        //write to screen
    }
}

class circle extends shape {
    function draw($origin, $radius){
        //validate data
        if($radius > 0){
            parent::draw();
            return true;
        }
        return false;
    }
}
    </pre>


<hr />

<h2><a name="creating_methods_dynamically">Creating Methods Dynamically</a></h2>
<p><b>Problem:</b> You want to dynamically provide methods without explicitly defining them.</p>
<p><b>Solution:</b> Use the __call() and __callStatic() magic methods to intercept method invocations and route them accordingly</p>

<pre class="prettyprint">
    <h3 class="nocode">__callStatic()</h3>

class Users {
    static function find($args){
        //here's where the real logic lives
        //for example a database query:
        //SELECT user FROM users WHERE $args['field'] = $args['value']
    }
    
    static function __callStatic($method, $args){
        if(preg_match('/^findBy(.+)$/', $method, $matches){
            return static::find(array('field'=>$matches[1],
                                      'value'=>$args[0]));
        }
    }
}

$user = User::findById(123);
$user = User::findByEmail('rasmus@php.net');
    </pre>


<hr />

<h2><a name="using_polymorphism">Using Method Polymorphism</a></h2>
<p><b>Problem:</b> You want to execute different code depending on the number and type of arguments passed to a method</p>
<p><b>Solution:</b> PHP doesn't support method polymorphism as a built-in feature. However, you can emulate it using various type-checking functions. The following combine() function uses is_numeric(), is_string(), is_array(), and is_bool():</p>

<p>Documentation on <a href="http://nl1.php.net/is-resource" target="_blank">is_resource()</a></p>
<p>Documentation on <a href="http://jm2.php.net/pathinfo" target="_blank">pathinfo()</a></p>

<pre class="prettyprint">
//combine() adds numbers, concatenates strings, mergers arrays,
//and ANDs bitwise and boolean arguments

function combine($a, $b){
    if(is_int($a) && is_int($b)){
        return $a + $b;
    }
    
    if(is_float($a) && is_float($b)){
        return $a + $b;
    }
    
    if(is_string($a) && is_string($b)){
        return "$a$b";
    }
    
    if(is_array($a) && is_array($b)){
        return array_merge($a, $b);
    }
    
    if(is_bool($a) && is_bool($b)){
        return $a & $b;
    }
    
    return false;
}
    </pre>


<hr />

<h2><a name="defining_class_constants">Defining Class Constants</a></h2>
<p><b>Problem:</b> You want to define constants on a per-class basis, not on a global basis.</p>
<p><b>Solution:</b> Define them like class properties, but use the const label instead:</p>

<p>Documentation on <a href="http://php.net/oop5.constants" target="_blank">class constants</a></p>

<pre class="prettyprint">
class Math {
   const pi = 3.14159; //universal
   const e = 2.71828 //constants
}

$area = math::pi * $radius * $radius;
    </pre>


<hr />

<h2><a name="Defining_static">Defining Static Properties and Methods</a></h2>
<p><b>Problem:</b> You want to define methods in an object, and be able to access them without instantiating a object.</p>
<p><b>Solution:</b> Declare the method static:</p>

<p><i>self</i> is to static properties and methods as <i>$this</i> is to instantiated properties and methods</p>

<p>Documentation on <a href="http://php.net/oop5.static" target="_blank">static keyword</a></p>

<pre class="prettyprint">
class Format {
    public static function number($number, $decimals = 2,
                                  $decimal = '.', $thousands = ','){
         return number_format($number, $decimals, $decimal, $thousands);                             
    }
}

print Format::number(1234.567);
    </pre>


<hr />

<h2><a name="controlling_serialization">Controlling Object Serialization</a></h2>
<p><b>Problem:</b> You want to control how an object behaves when you serialize() and unserialize() it. This is useful when you need to establish and close connections to remote resources, such as databases, files, and web services.</p>
<p><b>Solution:</b> Define the magical methods __sleep() and __wakeup():</p>

<pre class="prettyprint">
class LogFile {
    protected $filename;
    protected $handle;
    
    public function __construct($filename){
        $this->filename = $filename;
        $this->open();
    }
    
    private function open(){
        $this->handle = fopen($this->filename, 'a');
    }
    
    private function __destruct($filename){
        fclose($this->handle);
    }
    
    //called when object is serialized
    //should return an array of object properties to serialize
    public function __sleep(){
        return array('filename');
    }
    
    //called when object is unserialized
    public function __wakeup(){
        $this->open();
    }
}
    </pre>


<hr />

<h2><a name="introspecting">Introspecting Objects</a></h2>
<p><b>Problem:</b> You want to inspect an object to see what methods and properties it has, which lets you write code that works on any generic object, regardless of type.</p>
<p><b>Solution:</b> Use the Reflection classes to probe an object for information.</p>

<pre class="prettyprint">
//learn about cars
Reflection::export(new ReflectionClass('car'));

//Or probe for specific data:
$car = new ReflectionClass('car');
if($car->hasMethod('retractTop')){
    //car is a convertible
}
    </pre>


<hr />

<h2><a name="ciaoiaioasc">Checking If an Object Is an Instance of a Specific Class</a></h2>
<p><b>Problem:</b> You want to check if an object is an instance of a specific class.</p>
<p><b>Solution:</b> To check that a value passed as a function argument is an instance of a specific class, specify the class name in your function prototype:</p>

<p>Documentation on <a href="http://php.net/oop5.typehinting" target="_blank">type hints</a></p>
<p>Documentation on <a href="http://php.net/operators.type" target="_blank">instanceof</a></p>

<pre class="prettyprint">
public function add(Person $person){
    //add $person to address book
    }
}

//In other context, use the instanceof operator:
$media = get_something_from_catalog();
if($media instanceof Book){
    //do bookish things
}else if($media instanceof DVD){
    //watch the movie
}
    </pre>


<hr />

<h2><a name="autoloading">Autoloading Class Files Upon Object Instantiation</a></h2>
<p><b>Problem:</b> You don't want to include all your class definitions within every page. Instead, you want to dynamically load only the ones necessary in that page.</p>
<p><b>Solution:</b> Use the __autoload() magic method:</p>

<p>Documentation on <a href="http://php.net/oop5.autoload" target="_blank">autoloading</a></p>


<pre class="prettyprint">
function __autoload($class_name){
    include "$class_name.php";
}

$person = new Person;
    </pre>


<hr />

<h2><a name="instantiating_dynamically">Instantiating an Object Dynamically</a></h2>
<p><b>Problem:</b> You want to instantiate an object, but you don't know the name of the class until your code is executed. For example, you want to localize your site by creating an object belonging to a specific language. However, until the page is requested, you don't know which language to select.</p>
<p><b>Solution:</b> Use a variable for your class name:</p>

<p>Documentation on <a href="http://php.net/class-exists" target="_blank">class_exists()</a></p>

<pre class="prettyprint">
$language = $_REQUEST['language'];
$value_langs = array('en_US' => 'US English',
                     'en_UK' => 'British English',
                     'es_US' => 'US Spanish',
                     'fr_CA' => 'Canadian French');
if(isset($valid_langs[$language]) && class_exists($language)){
    $lang = new $language;
}
    </pre>


<hr />

<h2><a name="Program">Program: whereis</a></h2>
<p>Although tools such as phpDocumentor provide quite detailed information about an entire series of classes, it can be useful to get a quick dump that lists all the functions and methods defined in a list of files.</p>

<p>The following program loops through a list of files, includes them, and then uses the Reflection classes to gather information about them. Once the master list is compiled, the functions and methods are sorted alphabetically and printed out.</p>

<pre class="prettyprint">
    <h3 class="nocode">wheris</h3>

if($arcc &lt; 2){
    print "$argv[0]: classes1.php[, ...]\n";
    exit;
}

//Include the files
foreach(array_slice($argv,1) as $filename){
    include_once $filename;
}

//Get all the method and function information
//Start with the classes
$methods = array();
foreach(get_declared_classes() as $class){
    $r = new ReflectionClass($class);
    //Eliminate built-in classes
    if($r->isUserDefined()){
        foreach($r->getMethods() as $method){
            //Eliminate inherited methods
            if($method->getDeclaringClass()->getName() == $class){
                $signature = "$class::" . $method->getName();
                $methods[$signature] = $method;
            }
        }
    }
}

//Then add the functions
$functions = array();
$defined_functions = get_defined_functions();
foreach($defined_functions['user'] as $function){
    $functions[$function] = new ReflectionFunction($function);
}

//Sort methods alpahbetically by class
function sort_methods($a, $b){
    list($a_class, $a_method) = explode('::', $a);
    list($b_class, $b_method) = explode('::', $b);
    
    if($cmp = strcasecmp($a_class, $b_class)){
        return $cmp;
    }
    
    return strcasecmp($a_method, $b_method);
}
uksort($methods, 'sort_methods');

//Sort functions alphabetically
//This is less complicated, but don't forget to
//remove them method sorting function from the list
unset($funcitons['sort_methods']);
//Sort 'em
ksort($functions);

//print out information
foreach(array_merge($functions, $methods) as $name => $reflect){
    $file = $reflect->getFileName();
    $line = $reflect->getStartLine();
    
    printf("%-25s | %-40s | %6d\n", "$name()", $file, $line);
}
    </pre>



 
      
      
      
</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>