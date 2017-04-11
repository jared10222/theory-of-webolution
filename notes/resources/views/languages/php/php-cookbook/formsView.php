<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

      <div class="page-header">
        <h1>Forms</h1>
      </div>



<table class="table table-responsive table-bordered">
	<caption>Table of Contents</caption>
    <tr>
    	<td><a href="#processing_input">Processing Form Input</a></td>
        <td><a href="#validating_required">Validating Form Input: Required Fields</a></td>
        <td><a href="#validating_numbers">Validating Form Input: Numbers</a></td>
        <td><a href="#validating_email">Validating Form Input: Email Addresses</a></td>
    </tr>
    <tr>
    	<td><a href="#validating_menus">Validating Form Input: Drop-Down Menus</a></td>
        <td><a href="#validating_radio">Validating Form Input: Radio Buttons</a></td>
        <td><a href="#validating_checkboxes">Validating Form Input: Checkboxes</a></td>
        <td><a href="#validating_dates">Validating Form Input: Dates and Times</a></td>
    </tr>
    <tr>
    	<td><a href="#validating_credit">Validating Form Input: Credit Cards</a></td>
        <td><a href="#pcss">Preventing Cross-Site Scripting</a></td>
        <td><a href="#processing_uploaded">Processing Uploaded Files</a></td>
        <td><a href="#multipage_forms">Working with Multipage Forms</a></td>
    </tr>
    <tr>
        <td><a href="#inline_error_msg">Redisplaying Forms with Inline Error Messages</a></td>
        <td><a href="#multiple_submissions">Guarding Against Multiple Submissions of the Same Form</a></td>
        <td><a href="#var_injection">Preventing Global Variable Injection</a></td>
        <td><a href="#remote_period_vars">Handling Remote Variables with Periods in Their Names</a></td>
    </tr>
    <tr>
    	<td><a href="#multi_options">Using Form Elements with Multiple Options</a></td>
        <td><a href="#drop_down_date">Creating Drop-Down Menus Based on the Current Date</a></td>
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

<h2><a name="processing_input">Processing Form Input</a></h2>
<p><b>Problem:</b> You want to use the same HTML page to emit a form and then process the data entered into it. In other words, you're trying to avoid a proliferation of pages that each handle different steps in a transaction.</p>
<p><b>Solution:</b> Use the $_SERVER['REQUEST_METHOD'] variable to determine whether the request was submitted with the get or post method.  If the get method was used, print the form. If the post method was used, process the form.</p>

<p>If your form is complicated, you can benefit from splitting out the display logic into a template.</p>

<pre class="prettyprint">
&lt;?php if($_SERVER['REQUEST_METHOD'] == 'GET'){ ?>
&lt; action="&lt;?php echo htmlentities($_SERVER['SCRIPT_NAME']) ?>" method="post">
What is your first name?
&lt;input type="text" name="first_name" />
&lt;input type="submit" value="Say Hello" />
&lt;/form>
&lt;?php } else {
    echo 'Hello, ' . $_POST['first_name'] . '!';
}

<hr />
//Here's the form dispaly code:


&lt;form action="&lt;?= htmlentities($_SERVER['SCRIPT_NAME']) ?>" method="post">
What is your first name?
&lt;input type="text" name="first_name" />
&lt;input type="submit" value="Say Hello" />
&lt;/form>

//Here's the form processing logic:
Hello, &lt;?= $_POST['first_name'] ?> 

//And here's the logic that decides what to do:
&lt;?php
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    include __DIR__.'/getpost-get.php';
}else{
    include __DIR__.'/getpost-post.php';
}

//The deciding-what-to-do logic assumes that the form display
//code is saved as <i>getpost-get.php</i>, that the form processing
//code is saved as <i>getpost-post.php</i> and that all three files
//are in the same directory. The __DIR__ constant tells the program
//to look in the same directory as the executing code for the files
//being included.
    </pre>


<hr />

<h2><a name="validating_required">Validating Form Input: Required Fields</a></h2>
<p><b>Problem:</b>You want to make sure a value has been supplied for a form element. For example, you want to make sure a text box hasn't been left blank.</p>
<p><b>Solution:</b> Use filter_has_var() to see if the element exists in the appropriate input array:</p>

<p>Use filter_has_var(), filter_input(), and strlen() for maximally strict form validation.</p>

<p>Documentatino on <a href="http://php.net/filter_has_var" target="_blank">filter_has_var()</a></p>
<p>Documentation on <a href="http://php.net/filter_input" target="_blank">filter_input()</a></p>
<p>Documentation on <a href="http://php.net/filter.filters.sanitize" target="_blank">Sanitization filters</a></p>
<p>A list of <a href="http://php.net/filter.filters.flags" target="_blank">filter flags</a></p>

<pre class="prettyprint">
if(! filter_has_var(INPUT_POST, 'flavor')){
    print 'You must enter your favorite ice cream flavor.';
}

    <hr />
    <h3 class="nocode">Strict form validation</h3>

//Making sure $_POST['flavor'] exists before checking its length
if(!(filter_has_var(INPUT_POST, 'flavor') &amp;&amp;
    (strlen(filter_input(INPUT_POST, 'flavor')) > 0))){
   print 'You must enter your favorite ice cream flavor.';   
}

//$_POST['color'] is optional, but if it's supplied, it must be
//more than 5 characters after being sanitized
if(filter_has_var(INPUT_POST, 'color') &amp;&amp;
   (strlen(filter_input(INPUT_POST, 'color', FILTER_SANITIZE_STRING)) &lt;=5)){
   print 'Color must be more than 5 characters.';  
}

//Making sure $_POST['choices'] exists and is an array
if(!(filter_has_var(INPUT_POST, 'choices') &amp;&amp;
    filter_input(INPUT_POST, 'choices', FILTER_DEFAULT,
                FILTER_REQUIRE_ARRAY))){
   print 'You must select some choices.';               
}

    </pre>


<hr />

<h2><a name="validating_numbers">Validating Form Input: Numbers</a></h2>
<p><b>Problem:</b> You want to make sure a number is entered in a form input box. For example, you don't want someone to be able to say that her age is <i>old enough</i> or <i>tangerine</i>, but instead want values such as 13 or 56.</p>
<p><b>Solution:</b> If your're looking for an integer, use the FILTER_VALIDATE_INT filter:</p>
<p>If you're looking for a decimal number, use the FILTER_VALIDATE_FLOAT filter:</p>

<pre class="prettyprint">
    <h3 class="nocode">FILTER_VALIDATE_INT</h3>

$age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
if($age === false){
    print "Submitted age is invalid.";
}

    <hr />
    <h3 class="nocode">FILTER_VALIDATE_FLOAT</h3>

$price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
if($price === false){
    print "Submitted price is invalid.";
}

    <hr />
    <h3 class="nocode">Validating numbers with regular expressions</h3>

//The pattern matches an optional-sign and then
//at least one digit
if(! preg_match('/^-?\d+$/',$_POST['rating'])){
    print 'Your rating must be an integer.';
}

//The pattern matches an optional-sign and then
//optional digits to go before a decimal point
//an optional decimal point
//and then at least one digit
if(!preg_match('/^-?\d*\.?\d+$/', $_POST['temperature'])){
    print 'Your temperature must be a number.';
}
    </pre>


<hr />

<h2><a name="validating_email">Validating Form Input: Email Addresses</a></h2>
<p><b>Problem:</b> You want to know whether an email address a user has provided is valid.</p>
<p><b>Solution:</b> Use the FILTER_VALIDATE_EMAIL filter. It tells you whether an email address is valid according to the rules in RFC 5321(mostly).</p>

<pre class="prettyprint">
    <h3 class="nocode">Validating an email address</h3>

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
if($email === false){
    print "Submitted email address is invalid.";
}
    </pre>


<hr />

<h2><a name="validating_menus">Validating Form Input: Drop-Down Menus</a></h2>
<p><b>Problem:</b> You want to make sure that a valid choice was selected from a drop-down menu generated by the HTML &lt;select/> element.</p>
<p><b>Solution:</b> Use an array of values to generate the menu. Then validate the input by checking that the value is in the array:</p>

<p>To work with a menu that sets value attributes on each &lt;option/> element, use array_key_exists() to validate the input:</p>

<pre class="prettyprint">
    <h3 class="nocode">Validating a drop-down menu with in_array()</h3>

//Generating the menu
$choices = array('Eggs', 'Toast', 'Coffee');
echo "&lt;select name='food'>\n";
foreach($choices as $choice){
    echo "&lt;option>$choice&lt;/option>\n";
}
echo "&lt;/select>";

//Then, later, validating the menu
if(! in_array($_POST['food'], $choices)){
    echo "You must select a valid choice.";
}

    <hr />
    <h3 class="nocode">Validating a drop-down menu with array_key_exists()</h3>

//Generating the menu
$choices = array('eggs' => 'Eggs Benedict',
                 'toast' => 'Buttered Toast with Jam',
                 'coffee' => 'Piping Hot Coffee');
echo "&lt;select name='food'>\n";
foreach($choices as $key => $choice){
    echo "&lt;option value='$key'>$choice&lt;/option>\n";
}
echo "&lt;/select>";

//Then, later, validating the menu
if(! array_key_exists($_POST['food'], $choices)){
    echo "You must select a valid choice.";
}
    </pre>


<hr />

<h2><a name="validating_radio">Validating Form Input: Radio Buttons</a></h2>
<p><b>Problem:</b> You want to make sure a valid radio button is selected from a group of radio buttons.</p>
<p><b>Solution:</b> Use an array of values to generate the menu. Then validate the input by checking that the submitted value is in the array.</p>

<pre class="prettyprint">
    <h3 class="nocode">validating a radio button</h3>

//Generating the radio buttons
$choices = array('eggs' => 'Eggs Benedict',
                 'toast' => 'Buttered Toast with Jam',
                 'coffee' => 'Piping Hot Coffee');
foreach($choices as $key => $choice){
    echo "&lt;input type='radio' name='food' value='$key' />$choice\n";
}

//Then, later, validating the radio button submission
if(! array_key_exists($_POST['food'], $choices)){
    echo "You must select a valid choice.";
}
    </pre>


<hr />

<h2><a name="validating_checkboxes">Validating Form Input: Checkboxes</a></h2>
<p><b>Problem:</b> You want to make sure only valid checkboxes are checked.</p>
<p><b>Solution:</b> For a single checkbox, ensure that if a value is supplied, it's the correct one. If a value isn't supplied for the checkbox, then the box wasn't checked.</p>

<p>For a group of checkboxes, use an array of values to generate the checkboxes. Then, use array_intersect() to ensure that the set of submitted values is contained within the set of acceptable values:</p>

<pre class="prettyprint">
    <h3 class="nocode">Validating a single checkbox</h3>

//Generating the checkbox
$value = 'yes';
echo "&lt;input type='checkbox' name='subscribe' value='yes'/> Subscribe?";

//then, later, validating the checkbox
if(filter_has_var(INPUT_POST, 'subscribe')){
    //A value was submitted and it's the right one
    if($_POST['subscribe'] == $value){
        $subscribed = true;
    }else{
        //A value was submitted and it's the wrong one
        $subscribed = false;
        print 'Invalid checkbox value submitted.';
    }
}else{
    //No value was submitted
    $subscribed = false;
}

if($subscribed){
    print 'You are subscribed.';
}else{
   print 'You are not subscribed.';
}

    <hr />
    <h3 class="nocode">validating a group of checkboxes</h3>

//Generatint the checkboxes
$choices = array('eggs' => 'Eggs Benedict',
                 'toast' => 'Buttered Toast with Jam',
                 'coffee' => 'Piping Hot Coffee');
foreach($choices as $key => $choice){
    echo "&lt;input type='checkbox' name='food[]' value='$key'/>$choice\n";
}

//Then, later, validating the radio button submission
if(array_intersect($_POST['food'], array_key($choices)) != $_POST['food']){
    echo "You must select only valid choices.";
}
    </pre>


<hr />

<h2><a name="validating_dates">Validating Form Input: Dates and Times</a></h2>
<p><b>Problem:</b> You want to make sure that a date or time a user entered is valid. For example, you want to ensure that a user hasn't attempted to schedule an event for the 45th of August or provided a credit card that has already expired.</p>
<p><b>Solution:</b> If your form provides month, day, and year as separate elements, plug those values into checkdate(). This tells you whether or not the month, day, and year are valid.</p>

<p>To check that a date is before or after a particular value, convert the user-supplied values to a timestamp, computer the timestamp for the threshhold date, and compare the two.</p>

<pre class="prettyprint">
    <h3 class="nocode">Checking a particular date</h3>

if(! checkdate($_POST['month'], $_POST['day'], $_POST['year'])){
    print "The date you entered doesn't exist!";
}

    <hr />
    <h3 class="nocode">Checking credit card expiration</h3>

//The beginning of the month in which the credit card expires
$expires = mktime(0,0,0,$_POST['month'], 1,$_POST['year']);
//The beginning of the previous month
$lastMonth = strtotime('last month', $expires);
if(time() > $lastMonth){
    print "Sorry, that credit card expires too soon.";
}
    </pre>


<hr />

<h2><a name="validating_credit">Validating Form Input: Credit Cards</a></h2>
<p><b>Problem:</b> You want to make sure a user hasn't entered a bogus credit card number.</p>
<p><b>Solution:</b> The is_valid_credit_card() function below tells you whether a provided credit card number is syntactically valid.</p>

<pre class="prettyprint">
    <h3 class="nocode">Validating a credit card number</h3>

function is_valid_credit_card($s){
    //Remove non-digits and reverse
    $s = strrev(preg_replace('/[^\d]/','',$s));
    //compute checksum
    $sum = 0;
    for($i = 0, $j = strlen($s); $i &lt; $j; $i++){
        //Use even digits as-is
        if(($i % 2) == 0){
            $val = $s[$i];
        }else{
            //Double odd digits and subtract 9 if greater than 9
            $val = $s[$i] * 2;
            if($val > 9) {$val -= 9;}
        }
        $sum += $val;
    }
    //Number is valid if sum is a multiple of ten
    return (($sum % 10) == 0);
}

if(! is_valid_credit_card($_POST['credit_card'])){
    print 'Sorry, that card number is invalid.';
}
    </pre>


<hr />

<h2><a name="pcss">Preventing Cross-Site Scripting</a></h2>
<p><b>Problem:</b> You want to securely display user-entered data on an HTML page. For example, you want to allow users to add comments to a blog post without worrying that HTML or JavaScript in a comment will cause problems.</p>
<p><b>Solution:</b> Pass user input through htmlentities() before displaying it.</p>

<pre class="prettyprint">
    <h3 class="nocode">Escaping HTML</h3>

print 'The comment was: ';
print htmlentities($_POST['comment']);
    </pre>


<hr />

<h2><a name="processing_uploaded">Processing Uploaded Files</a></h2>
<p><b>Problem:</b> You want to process a file uploaded by a user. For example, you're building a photo-sharing website and you want to store user-supplied photos.</p>
<p><b>Solution:</b> Use the $_FILES array to get information about uploaded files:</p>

<p>Documentation on <a href="http://php.net/features.file-upload" target="_blank">handling file uploads</a></p>
<p>Documentation on <a href="http://php.net/basename" target="_blank">basename()</a></p>

<pre class="prettyprint">
    <h3 class="nocode">Uploading a file</h3>

&lt;?php if ($_SERVER['REQUEST_METHOD'] == 'GET'){ ?>
&lt;form method="post" action="&lt;?php echo htmlentities($_SERVER['SCRIPT_NAME']) ?>"
    enctype="multipart/form-data">
&lt;input type="file" name="document"/>
&lt;input type="submit" value="Send File"/>
&lt;/form>
&lt;?php } else {
if(isset($_FILES['document']) &amp;&amp;
($_FILES['document']['error'] == UPLOAD_ERR_OK)){
    $newPath = '/tmp/' . basename($_FILES['document']['name']);
    if(move_uploaded_file($_FILES['document']['tmp_name'], $newPath)){
        print "File saved in $newPath";
    }else{
        print "Coudn't move file to $newPath";
    }
}else{
    print "No valid file uploaded.";
}
}
    </pre>

<hr />

<h2><a name="multipage_forms">Working with Multipage Forms</a></h2>
<p><b>Problem:</b> You want to use a form that displays more than one page and preserves data from one page to the next. For example, your form is for a survey that has too many questions to put them all on one page.</p>
<p><b>Solution:</b> Use session tracking to store form information for each stage as well as a variable to keep track of what stage to display:</p>

<pre class="prettyprint">
    <h3 class="nocode">Making a multipage form</h3>

//The "deciding what to do" logic (stage.php):
//Turn on sessions
session_start();

//Figure out what stage to use
if(($_SERVER['REQUEST_METHOD'] == 'GET') || (!isset($_POST['stage']))){
    $stage = 1;
}else{
    $stage = (int) $_POST['stage'];
}

//Make sure the stage isn't too big or too small
$stage = max($stage, 1);
$stage = min($stage, 3);

//Save any submitted data
if($stage > 1){
    foreach($_POST as $key => $value){
        $_SESSION[$key] = $value;
    }
}

include __DIR__."/stage-$stage.php";

//The first page of the form(stage-1.php):
&lt;form action='&lt;? = htmlentities($_SERVER['SCRIPT_NAME']) ?>' method='post'>

Name: &lt;input type='text' name='name'/>&lt;br />
Age: &lt;input type='text' name='age'/> &lt;br />

&lt;input type='hidden' name='stage' value='&lt;?= $stage + 1 ?>'/>
&lt;input type='submit' value='Next' />
&lt;/form>

//The second page of the form (stage-2.php):
&lt;form action='&lt;?= htmlentities($_SERVER['SCRIPT_NAME']) ?>' method='post'>

Favorite Color: &lt;input type='text' name='color'/> &lt;br />
Favorite Food; &lt;input type='text' name='food'/> &lt;br />

&lt;input type='hidden' name='stage' value='&lt;?= $stage + 1 ?>'/>
&lt;input type='submit' value='Done' />

//The displaying-results page (stage-3.php):

Hello &lt;?= htmlentities($_SESSION['name']) ?>.
You are &lt;= htmlentities($_SESSION['age']) ?> years old.
Your favorite color is &lt;?= htmlentities($_SESSION['color']) ?>
and your favorite food is &lt;?= htmlentities($_SESSION['food']) ?>.
    </pre>


<hr />

<h2><a name="inline_error_msg">Redisplaying Forms with Inline Error Messages</a></h2>
<p><b>Problem:</b> When there's a problem with data entered in a form, you want to print out error messages alongside the problem fields, instead of a generic error message at the top of the form. You also want to preserve the values the user entered in the form, so they don't have to redo the entire thing</p>
<p><b>Solution:</b> As you validate, keep track of form errors in an array keyed by element name. Then, when it's time to display the form, print the appropriate error message next to each element. To preserve user input, use the appropriate HTML idiom: a value attribute (with entity encoding) for most &lt;input/> elements, a checked='checked' attribute for radio buttons and checkboxes, and a selected='selected' attribute on &lt;option/> elements in drop-down menus.</p>

<pre class="prettyprint">
    <h3 class="nocode">Redisplaying a form with error messages and preserved input</h3>

//The main logic and validation function:
//set up some options for the drop-down menu
$flavors = array('Vanilla', 'Chocolate', 'Rhinoceros');

//set up empty defaults when nothing is chosen
$defaults = array('name' => '',
                  'age' => '',
                  'flavor' => array());
foreach($flavors as $flavor){
    $defaults['flavor'][$flavor] = '';
}

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $errors = array();
    include __DIR__.'/show-form.php';
}else{
    //the request is a POST, so validate the form
    $errors = validate_form();
    if(count($errors)){
        //If there were errors, redisplay the form with the errors,
        //preserving defaults
        if(isset($_POST['name'])) { $defaults['name'] = $_POST['name']; }
        if(isset($_POST['age'])) { $defaults['age'] = "checked='checked'";}
        foreach($flavors as $flavor){
            if(isset($_POST['flavor']) &amp;&amp;($_POST['flavor'] == $flavor)){
                $defaults['flavor'][$flavor] = "selected='selected'";
            }
        }
        include __DIR__.'/show-form.php';
    }else{
        //The form data was valid, so congratulate the user. In "Real Life"
        //Perhaps here you'd redirect somewhere else of include another
        //file to display
        print 'The form is submitted!';
    }
}

function validate_form(){
    global $flavors;
    
    //Start out with no errors
    $errors = array();
    
    //name is required and must be at least 3 characters
    if(!(isset($_POST['name'] &amp;&amp; (strlen($_POST['name']) > 3))){
        $errors['name'] = 'Enter a name of at least 3 letters';
    }
    if(isset($_POST['age']) &amp;&amp;($_POST['age'] != '1')){
        $errors['age'] = 'Invalid age checkbox value.';
    }
    //flavor is optional but if submitted must b in $flavors
    if(isset($_POST['flavor']) &amp;&amp;(! in_array($_POST['flavor'], $flavors))){
        $errors['flavor'] = 'Choose a valid flavor.';
    }
    
    return $errors;
}

//The form (show-form.php):
&lt;form action='&lt;?= htmlentities($_SERVER['SCRIPT_NAME']) ?>' method='post'>
&lt;dl>
&lt;dt>Your Name:&lt;/dt>
&lt;?php if(isset($errors['name'])){ ?>
&lt;dd class="error">&lt;?= htmlentities($errors['name']) ?>&lt;/dd>
&lt;?php } ?>
&lt;dd>&lt;input type='text' name='name'
    value="&lt;?= htmlentities($defaults['name']) ?>">&lt;/dd>
&lt;?php } ?>
&lt;dd>&lt;input type='text' name='name'
value='&lt;?= htmlentities($defaults['name']) ?>'/>&lt;/dd>
&lt;dt>Are you over 18 years old?&lt;/dt>
&lt;?php if (isset($errors['age'])) { ?>
&lt;dd class="error">&lt;?= htmlentities($errors['age']) ?></dd>
&lt;?php } ?>
&lt;dd>&lt;input type='checkbox' name='age' value='1'
&lt;?= $defaults['age'] ?>/> Yes&lt;/dd>
&lt;dt>Your favorite ice cream flavor:&lt;/dt>
&lt;?php if (isset($errors['flavor'])) { ?>
&lt;dd class="error">&lt;?= htmlentities($errors['flavor']) ?>&lt;/dd>
&lt;?php } ?>
&lt;dd>&lt;select name='flavor'>
&lt;?php foreach ($flavors as $flavor) { ?>
&lt;option &lt;?= isset($defaults['flavor'][$flavor]) ?
$defaults['flavor'][$flavor] :
"" ?>>&lt;?= htmlentities($flavor) ?>&lt;/option>
&lt;?php } ?>
&lt;/select>&lt;/dd>
&lt;/dl>
&lt;input type='submit' value='Send Info'/>
&lt;/form>
    </pre>


<hr />

<h2><a name="multiple_submissions">Guarding Against Multiple Submissions of the Same Form</a></h2>
<p><b>Problem:</b> You want to prevent a user from submitting the same form more than once.</p>
<p><b>Solution:</b>Include a hidden field in the form with a unique value. When validating the form, check if a form has already been submitted with that value. If it has, reject the submission. If it hasn't, process the form and record the value for later use. Additionally, use JavaScript to disable the form Submit button once the form has been submitted.</p>

<p>Documentation on <a href="http://php.net/uniqid" target="_blank">uniqid()</a></p>
<p>An easy to implement CAPTCHA is available from <a href="http://www.google.com/recaptcha/intro/index.html" target="_blank">Google</a></p>

<pre class="prettyprint">
    <h3 class="nocode">Insert a unique ID into a form</h3>
&lt;!doctype html>
&lt;html lang="en">
&lt;head>
    &lt;meta charset="utf-8" />
    &lt;meta name="viewport" content="width=device-width, initial-scale=1"/>
    &lt;title>Example&lt;/title> 
&lt;/head>
&lt;body>
&lt;form method="post" action="&lt;?php echo $_SERVER['SCRIPT_NAME'] ?>"
   onsubmit="document.getElementById('submit-button').disabled = true;">
&lt;!-- insert all the normal form elements you need-->
&lt;input type='hidden' name='token' value='&lt;?= md5(unique()) ?>' />
&lt;input type='submit' value='Save Data' id='submit-button' />
&lt;/form>

&lt;?php
//checking a form for resubmission
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $db = new PDO(sqlite:/tmp/formjs.db);
    $db->beginTransaction();
    $sth = $db->prepare('SELECT * FROM forms WHERE token = ?');
    $sth->execute(array($_POST['token']));
    if(count($sth->fetchAll())){
        print "This form has already been submitted!";
        $db->rollback();
    }else{
        /*Validation code for the rest of the form goes here--
        * Validate everything before inserting the token */
        $sth = $db->prepare('INSERT INTO forms (token) VALUES (?)');
        $sth->execute(array($_POST['token']));
        $db->commit();
        print "The form is submitted successfully.";
    }
}
?>
&lt;/body>
&lt;/html>
    </pre>


<hr />

<h2><a name="var_injection">Preventing Global Variable Injection</a></h2>
<p><b>Problem:</b> You are using an old version of PHP and want to access form input variables without allowing malicious users to get arbitrary global variables in your program.</p>
<p><b>Solution:</b> The easiset solution is to use PHP version 5.4.0 or later. Startint with that version, the register_globals configuration directive--the source of this global variable injection problem--is removed.</p>

<p>It's best to just turn off register_globals</p>

<hr />

<h2><a name="remote_period_vars">Handling Remote Varibles with Periods in Their names</a></h2>
<p><b>Problem:</b> You want to process a variable with a period in its name, but when a form is submitted, you can't find the variable in $_GET or $_POST.</p>
<p><b>Solution:</b> Replace the period in the variable's name with an underscore. For example, if you have a form input element named hot.dog, you access it inside PHP as the variable $_GET['hot_dog'] or $_POST['hot_dog'].</p>

<p>Documentation on <a href="http://php.net/language.variables.external" target="_blank">variables from outside PHP</a></p>

<hr />

<h2><a name="multi_options">Using Form Elements with Multiple Options</a></h2>
<p><b>Problem:</b> You have form elements that let a user select multiple choices, such as drop-down menu or a group of checkboxes, but PHP sees only one of the submitted values.</p>
<p><b>Solution:</b> End the form element's name with a pair of square brackets([]).</p>
<p>Then, treat the submitted data as an array inside of $_GET or $_POST:</p>

<pre class="prettyprint">
    <h3 class="nocode">Naming a checkbox group</h3>

&lt;input type="checkbox" name="boroughs[]" value="bronx"> The Bronx
&lt;input type="checkbox" name="boroughs[]" value="brooklyn"> Brooklyn
&lt;input type="checkbox" name="boroughs[]" value="manhattan"> Manhattan
&lt;input type="checkbox" name="boroughs[]" value="queens"> Queens
&lt;input type="checkbox" name="boroughs[]" value="statenisland"> Staten Island

    <hr />
    <h3 class="nocode">Handling a submitted checkbox group</h3>
&lt;?php 
print 'I love ' . join(' and ', $_POST['boroughs']) . '!';
?>
    </pre>


<hr />

<h2><a name="drop_down_date">Creating Drop-Down Menus Based on the Current Date</a></h2>
<p><b>Problem:</b> You want to create a series of drop-down menus that are based automatically on the current date.</p>
<p><b>Solution:</b> Create a DateTime object and loop through the days you care about, modifying the object with its modify() mothod.</p>

<pre class="prettyprint">
    <h3 class="nocode">Generating date-based drop-down menu options</h3>

$options = array();
$when = new DateTime();
//print out one week's worth of days
for($i = 0; $i &lt; 7; ++$i){
    $options[$when->getTimestamp()] = $when->format("D, F j, Y");
    $when->modify("+1 day");
}

foreach($options as $value => $label){
    print "&lt;option value='$value'>$label&lt;/option>\n";
}
    </pre>




      
      
      
</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>