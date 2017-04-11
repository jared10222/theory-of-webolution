<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

      <div class="page-header">
        <h1>Security &amp; Encryption</h1>
      </div>


<table class="table table-responsive table-bordered">
	<caption>Table of Contents</caption>
    <tr>
    	<td><a href="#preventing_fixation">Preventing Session Fixation</a></td>
        <td><a href="#form_spoofing">Protecting Against Form Spoofing</a></td>
        <td><a href="#input_filtered">Ensuring Input Is Filtered</a></td>
        <td><a href="#cross_site">Avoiding Cross-Site Scripting</a></td>
    </tr>
    <tr>
    	<td><a href="#sql_injection">Eliminating SQL Injection</a></td>
        <td><a href="#keeping_password">Keeping Password Out of Your Site Files</a></td>
        <td><a href="#storing_passwords">Storing Passwords</a></td>
        <td><a href="#lost_passwords">Dealing with Lost Passwords</a></td>
    </tr>
    <tr>
    	<td><a href="#data_hashes">Verifying Data with Hashes</a></td>
        <td><a href="#encrypting_decrypting">Encrypting and Decrypting Data</a></td>
        <td><a href="#storing_encrypted">Storing Encrypted Data in a File or Database</a></td>
        <td><a href="#sharing_encrypted">Sharing Encrypted Data with Another Website</a></td>
    </tr>
    <tr>
        <td><a href="#detecting_ssl">Detecting SSL</a></td>
        <td><a href="#encrypting_email">Encrypting Email with GPG</a></td>
        <td></td>
        <td></td>
    </tr>     
</table>

<hr />

<h2><a name="preventing_fixation">Preventing Session Fixation</a></h2>
<p><b>Problem:</b> You need to ensure that a user's session identifier cannot be provided by a third party, such as an attacker who seeks to hijack the user's session.</p>
<p><b>Solution:</b> Regenerate the session identifier with session_regenerate_id() whenever there is a change in the user's privilege, such as after a successful login:</p>

<pre class="prettyprint">
session_regenerate_id();
$_SESSION['logged_in'] = true;
    </pre>


<hr />


<h2><a name="form_spoofing">Protecting Against Form Spoofing</a></h2>
<p><b>Problem:</b> You want to be sure that a form submission is valid and intentional.</p>
<p><b>Solution:</b> Add a hidden form field with a one-time token, and store this token in the user's session:</p>
<p>When you receive a request that represents a form submission, check the tokens to be sure they match:</p>

<pre class="prettyprint">
&lt;?php

session_start();
$_SESSION['token'] = md5(uniqid(mt_rand(), true));

?>

&lt;form action="buy.php" method="POST">
&lt;input type="hidden" name="token" value="&lt;?php echo $_SESSION['token']; ?>" />
&lt;p>Stock Symbol: &lt;input type="text" name="symbol" />&lt;/p>
&lt;p>Quantitiy: &lt;input type="text" name="quantity" />&lt;/p>
&lt;p>&lt;input type="submit" value="Buy Stocks" />&lt;/p>
&lt;/form>

<hr />
&lt;?php

session_start();
if((! isset($_SESSION['token'])) ||
   ($_POST['token'] != $_SESSION['token'])){
   
   /* Prompt user for password.*/   
}else{
    /*Continue.*/
}
?>
    </pre>


<hr />

<h2><a name="input_filtered">Ensuring Input Is Filtered</a></h2>
<p><b>Problem:</b> You want to filter all input prior to use.</p>
<p><b>Solution:</b> Initialize an empty array in which to store filtered data. After you've proven that something is valid, store it in this array:</p>

<pre class="prettyprint">
$filters = array('name' => array('filter' => FILTER_VALIDATE_REGEXP,
                           'options' => array('regexp' => '/^[a-z]+$/i')),
                 'age' => array('filter' => FILTER_VALIDATE_INT,
                           'options' => array('min_range' => 13)));
                           
$clean = filter_input_array(INPUT_POST, $filters);
    </pre>


<hr />

<h2><a name="cross_site">Avoiding Cross-Site Scripting</a></h2>
<p><b>Problem:</b> You need to safely avoid cross-site scripting (XSS) attacks in your PHP applications.</p>
<p><b>Solution:</b> Excape all HTML output with htmlentities(), being sure to indicate the corect character encoding.</p>

<pre class="prettyprint">
/* Note the character encoding. */
header('Content-type: text/html; charset=UTF-8');

/* Initialize an array for escaped data. */
$html = array();

/* Escape the filtered data. */
$html['username'] = htmlentities($clean['username'], ENT_QUOTES, 'UTF-8');

echo "&lt;p>Welcome back, {$html['username']}.&lt;/p>";
    </pre>


<hr />

<h2><a name="sql_injection">Eliminating SQL Injection</a></h2>
<p><b>Problem:</b> You need to eliminate SQL injection vulnerabilities in your PHP application.</p>
<p><b>Solution:</b> Use a database library such as PDO that performs the proper escaping for your database:</p>

<p>Documentation on <a href="http://php.net/pdo" target="_blank">PDO</a></p>

<pre class="prettyprint">
$statement = $db->prepare("INSERT
                    INTO users (username, password)
                    VALUES (:username, :password)");
$statement->bindParam(':username', $clean['username']);
$statement->bindParam(':password', $clean['password']);

$statement->execute();
    </pre>


<hr />

<h2><a name="keeping_password">Keeping Passwords Out of Your Site Files</a></h2>
<p><b>Problem:</b> You need to use a password to connect to a database, for example. You don't want to put the password in the PHP files you use on your site in case those files are exposed.</p>
<p><b>Solution:</b> Store the password in an environment variable in a file the web server loads when starting up. Then, just reference the environment variable in your code:</p>

<p>Documentation on <a href="http://httpd.apache.org/docs/current/mod/core.html#include" target="_blank">Apache's Include directive.</a></p>

<pre class="prettyprint">
$db = new PDO($dsn, $_SERVER['DB_USER'], $_SERVER['DB_PASSWORD']);
    </pre>


<hr />

<h2><a name="storing_passwords">Storing Passwords</a></h2>
<p><b>Problem:</b> You need to keep track of user's passwords, so they can log in to your website.</p>
<p><b>Solution:</b> When a user signs up or registers, hash the chosen password with bcrypt and store the hashed password in your database of users.</p>
<p>With PHP 5.5 and later, use the built-in password_hash() function:</p>

<p>Then, when that user attempts to log in to your website, use the password_verify() function to see if the supplied password matches the stored, hashed value:</p>

<p>The <a href="https://github.com/ircmaxell/password_compat" target="_blank">password_compat library</a></p>
<p>Documentation on <a href="http://php.net/password_hash" target="_blank">password_hash()</a></p>
<p>Documentation on <a href="http://php.net/password_verify" target="_blank">password_verify()</a></p>
<p>Documentation on <a href="http://php.net/crypt" target="_blank">crypt()</a></p>
<p>Documentation on <a href="http://php.net/sha1" target="_blank">sha1()</a></p>

<pre class="prettyprint">
/* Initialize an array for filtered data. */
$clean = array();

/* Hash the password. */
$hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

/* Allow alphanumeric usernames. */
if(ctype_alnum($_POST['username'])){
   $clean['username'] = $_POST['username'];
}else{
   /* Error */
}

/* Store the user in the database. */
$st = $db->prepare('INSERT
           INTO users (username, password)
           VALUES (?, ?)');
$st->execute(array($clean['username'], $hashed_password));

<hr />

/* Initalize an array for filtered data. */
$clean = array();

/* Allow alphanumeric usernames. */
if(ctype_alnum($_POST['username'])){
    $clean['username'] = $_POST['username'];
}else{
    /* Error */
}

$stmt = $db->prepare('SELECT password
            FROM users
            WHERE username = ?');
$stmt->execute(array($clean['username']));
$hashed_password = $stmt->fetchColumn();


if(password_verify($_POST['password'], $hashed_password)){
    /* Login Succeeds. */
    print "Login OK!";
}else{
    /* Login Fails. */
}
    </pre>


<hr />

<h2><a name="lost_passwords">Dealing with Lost Passwords</a></h2>
<p><b>Problem:</b> You want to issue a password to a user who has lost her password.</p>
<p><b>Solution:</b> Generate a new password and send it to the user's email address (Which you should have on file):</p>

<p><a href="http://www.sitepoint.com/generating-one-time-use-urls/" target="_blank">Sitepoint</a> Describes how to make one-time-use URL's that you could use with a password reset capability.</p>

<pre class="prettyprint">
/* Generate new password. */
$new_password = '';

for($i=0, $i&lt;8; $i++){
    $new_password .= chr(mt_rand(33, 126));
}

/* Hash new password. */
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

/* Save new hashed password to the database. */
$st = $db->prepare('UPDATE users
           SET password = ?
           WHERE username = ?');

$st->execute(array($hashed_password, $clean['username']));

/* Email new plain text password to user. */
mail($clean['email'], 'New Password', "Your new password is: $new_password");

    </pre>


<hr />

<h2><a name="data_hashes">Verifying Data with Hashes</a></h2>
<p><b>Problem:</b> You want to make sure users don't alter data you've sent them in a cookie or form element.</p>
<p><b>Solution:</b> Along with the data, send a "message digest" hash of the data that uses a salt. When you recieve the data back, compute the hash of the received value with the same salt. If they dont' match, the user has altered the data.</p>

<p>Documentation on <a href="http://php.net/hash_hmac" target="_blank">hash_hmac()</a></p>

<pre class="prettyprint">
//Here's how to generate a hash in a hidden form field:

&lt;?php

/* Define a salt. */
define('SALT', 'flyingturtle');

$id = 1337;
$idcheck = hash_hmac('sha1', $id, SALT);

?>

&lt;input type="hidden" name="id" value="&lt;?php echo $id; ?>" />
&lt;input type="hidden" name="idcheck" value="&lt;?php echo $idcheck; ?>" />

<hr />
//Here's how to verify the hidden form field data when it's submitted:
/* Initialize an array for filtered data. */
$clean = array();

/* Define a salt. */
define('SALT', 'flyingturtle');

if(hash_hmac('sha1', $_POST['id'], SALT) === $_POST['idcheck']){
    $clean['id'] = $_POST['id'];
}else{
    /* Error */
}
    </pre>


<hr />

<h2><a name="encrypting_decrypting">Encrypting and Decrypting Data</a></h2>
<p><b>Problem:</b> You want to encrypt and decrypt data using one of a variety of popular algorithms.</p>
<p><b>Solution:</b> use PHP's mcrypt extension:</p>

<p>Documentation on <a href="http://php.net/mcrypt" target="_blank">mcrypt extension</a></p>
<p>The <a href="http://mcrypt.sourceforge.net/" target="_blank">mcrypt library</a></p>


<pre class="prettyprint">
$algorithm = MCRYPT_BLOWFISH;
$key = 'That golden key that opens the palace of eternity.';
$data = 'The chicken escapes at dawn. Send help with Mr. Blue.';
$mode = MCRYPT_MODE_CBC;

$iv = mcrypt_create_iv(mcrypt_get_iv_size($algorithm, $mode),
                       MCRYPT_DEV_URANDOM);

$encrypted_data = mycrypt_encrypt($algorithm, $key, $data, $mode, $iv);
$plain_text = base64_encode($encrypted_data);
echo $plain_text. "\n";

$encrypted_data = base64_decode($plain_text);
$decoded = mcrypt_decrypt($algorithm, $key, $encrypted_data, $mode, $iv);
//trim() will remove any trailing NULL bytes that mcrypt() may
//have added to pad the output to be a whole number of 8-byte blocks
echo trim($decoded) . "\n";
    </pre>


<hr />

<h2><a name="storing_encrypted">Storing Encrypted Data in a File or Database</a></h2>
<p><b>Problem:</b> You want to store encrypted data that needs to be retrieved and decrypted later by your web server.</p>
<p><b>Solution:</b> Store the additional information required to decrypt the data (such as algorithm, cipher mode, and initialization vector) along with the encrypted information, but not the key:</p>

<p>Documentation on <a href="http://php.net/mcrypt-encrypt" target="_blank">mcrypt_encrypt()</a></p>
<p>Documentation on <a href="http://php.net/mcrypt-decrypt" target="_blank">mycrypt_decrypt()</a></p>
<p>Documentation on <a href="http://php.net/mcrypt-create-iv" target="_blank">mcrypt_create_iv()</a></p>
<p>Documentation on <a href="http://php.net/mcrypt-get-iv-size" target="_blank">mcrypt_get_iv_size()</a></p>

<pre class="prettyprint">
/* Encrypt the data. */
$algorithm = MCRYPT_BLOWFISH;
$mode = MCRYPT_MODE_CBC;
$iv = mcrypt_create_iv(mcrypt_get_iv_size($algorithm, $mode),
                       MCRYPT_DEV_URANDOM);
$ciphertext = mcrypt_encrtype($algorithm, $_POST['key'], $_POST['data'],
                             $mode, $iv);
 
/* Store the encrypted data .*/
$st = $db->prepare('INSERT
            INTO noc_list (algorithm, mode, iv, data)
            VALUES (?,?,?,?)');
$st->execute(array($algorithm, $mode, $iv, $ciphertext));

<hr />
//To decrypt the data, retrieve a key from the user and use it
//with the saved data:

$row = db->query('SELECT *
                FROM noc_list
                WHERE id = 27')->fetch();
$plaintext = mcrypt_decrypt($row['algorithm'],
                           $_POST['key'],
                           $row['data'],
                           $row['mode'],
                           $row['iv']);
                           
    </pre>


<hr />

<h2><a name="sharing_encrypted">Sharing Encrypted Data with Another Website</a></h2>
<p><b>Problem:</b> You want to exchange data securely with another website.</p>
<p><b>Solution:</b> If the other website is pulling data from your site, put the data up on a password-protected page. you can also make the data available in encrypted form, with or without a password. If you need to push the data to another website, submit the potentially encrypted data via post to a password-protected URL.</p>



<hr />

<h2><a name="detecting_ssl">Detecting SSL</a></h2>
<p><b>Problem:</b> You want to know if a request arrived over SSL</p>
<p><b>Solution:</b> Test the value of $_SERVER['HTTPS']:</p>

<pre class="prettyprint">
if('on' == $_SERVER['HTTPS']){
    echo 'The secret ingredient in Coca-Cola is Soylent Green.';
}else{
    echo 'Coca-Cola contains many delicious natural and artificial flavors.';
}
    </pre>


<hr />

<h2><a name="encrypting_email">Encrypting Email with GPG</a></h2>
<p><b>Problem:</b> You want to send encrypted email messages. For example, you take orders on your website and need to send an email to your factory with order details for processing. By encrypting the email message, you prevent sensitive data such as credit card numbers from passing over the network in the clear.</p>
<p><b>Solution:</b> Use the functions provided by the gnupg extension to encrypt the body of the email message with GNU Privacy Guard (GPG) before sending it:</p>

<p>The GNU Privacy Guard <a href="https://www.gnupg.org/" target="_blank">homepage</a></p>

<pre class="prettyprint">
$plaintext_body = 'Some sensitive order data';
$recipient = 'ordertaker@example.com';

$g = gnupg_init();
gnupg_seterrormode($g, GNUPG_ERROR_WARNING);
//Fingerprint of the recipient's key
$a = gnupg_addencryptkey($g, "5495F0CA9C8F30A9274C2259D7EBE8584CEF302B");
// Fingerprint of the sender's key
$b = gnupg_addsignkey($g, "520D5FC5C85EF4F4F9D94E1C1AF1F7C5916FC221",
                     "passphrase");
                     
$encrypted_body = gnupg_encryptsign($g, $plaintext_body);

mail($recipient, 'Web Site Order', $encrypted_body);

    </pre>







      
      
      
</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>