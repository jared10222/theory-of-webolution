<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

      <div class="page-header">
        <h1>Internet Services</h1>
      </div>



<table class="table table-bordered table-responsive">
	<caption>Table of Contents</caption>
    <tr>
    	<td><a href="#sending_mail">Sending Mail</a></td>
        <td><a href="#sending_mime">Sending MIME Mail</a></td>
        <td><a href="#reading_mail">Reading Mail with IMAP or POP3</a></td>
        <td><a href="#getting_putting">Getting and Putting Files with FTP</a></td>
    </tr>
    <tr>
    	<td><a href="#looking_up">Looking Up Addresses with LDAP</a></td>
        <td><a href="#using_ldap">Using LDAP for User Authentication</a></td>
        <td><a href="#dns_lookup">Performing DNS Lookups</a></td>
        <td><a href="#host_alive">Checking If a Host Is Alive</a></td>
    </tr>
    <tr>
    	<td><a href="#getting_info">Getting Information About a Domain Name</a></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>     
</table>

<hr />

<h2><a name="sending_mail">Sending Mail</a></h2>
<p><b>Problem:</b> You want to send an email message. This can be in direct response to a user's action, such as signing up for your site, or a recurring event at a set time, such as a weekly newsletter.</p>
<p><b>Solution:</b> Use Zetacomponent's ezcMailComposer class:</p>
<p>If you can't use Zetacomponent's ezcMailComposer class, use PHP's Built in mail() function:</p>

<p>The program mail() uses to send mail is specified in the sendmail_path configuration variable in your php.ini file. If you're running Windows, set the SMTP variable to the hostname of your SMTP server.</p>

<p>Regardless of which method you choose, it's a good idea to write a wrapper function to assist you in sending mail:</p>

<p>Documentation on <a href="http://php.net/manual/en/function.mail.php" target="_blank">mail()</a></p>
<p>The <a href="http://pear.php.net/package-info.php?package=Mail" target="_blank">PEAR Mail class;</a></p>
<p>The <a href="http://ezcomponents.org/docs/api/trunk/Mail/ezcMailComposer.html" target="_blank">ezcMailComposer class</a></p>


<pre class="prettyprint">
$message = new ezcMailComposer();
$message->from = new ezcMailAddress('webmaster@example.com');
$message->addTo(new ezcMailAddress('adam@example.com', 'Adam'));
$message->subject = 'New Version of PHP Released!';
$body = 'Go to http://www.php.net and download it today!';
$message->plainText = $body;
$message->build();

$sender = new ezcMailMtaTrasnport();
$sender->send($message);

<hr />

$to = 'adam@example.com';
$subject = 'New Version of PHP Released!';
$body = 'Go to http://www.php.net and download it today!';

mail($to, $subject, $body);

<hr />

//wrapper function

function mail_wrapper($to, $subject, $body, $headers){
    mail($to, $subject, $body, $headers);
    error_log("[MAIL][TO: $to]");
}
    </pre>


<hr />

<h2><a name="sending_mime">Sending MIME Mail</a></h2>
<p><b>Problem:</b> You want to send MIME email. For example, you want to send multipart messages with both plain text and HTML portions and have MIME-aware mail readers automatically display the correct portion.</p>
<p><b>Solution:</b> Use Zetacomponent's ezcMailComposer class, specifying both a plainText and an htmlText property as follows:</p>

<pre class="prettyprint">
$message = new ezcMailComposer();
$message->from = new ezcMailAddress('webmaster@example.com');
$message->addTo(new ezcMailAddress('adam@example.com', 'Adam'));
$message->subject = 'New Version of PHP Releases!';
$body = 'Go to http://www.php.net and download it today!';
$message->plainText = $body;
$html = '&lt;html>&lt;body>&lt;b>Hooray!&lt;/b> New PHP Version! &lt;/body>&lt;/html>';
$message->htmlText = $html;
$message->build();

$sender = new ezcMailMtaTransport();
$sender->send($message);

<hr />
//Including pictures
$message = new ezcMailComposer();
$message->from = new ezcMailAddress('webmaster@example.com');
$message->addTo(new ezcMailAddress('adam@example.com', 'Adam'));
$message->subject = 'New Version of PHP Released!';
$body = 'Go to http://www.php.net and download it today!';
$message->plainText = $body;
$html = '&lt;html>Me: &lt;img src="file:///home/me/picture.png"/>&lt;/html>';
$message->htmlText = $html;
$message->build();
$sender = new ezcMailMtaTransport();
$sender->send($message);

<hr />
//add attachments
$message = new ezcMailComposer();
$message->from = new ezcMailAddress('webmaster@example.com');
$message->addTo(new ezcMailAddress('adam@example.com', 'Adam'));
$message->subject = 'New Version of PHP Released!';
$body = 'Go to http://www.php.net and download it today!';
$message->plainText = $body;
$message->addFileAttachment('/home/me/details.png','image','png');
$message->addStringAttachment('extra.txt','Some text', 'text/plain');
$message->build();
$sender = new ezcMailMtaTransport();
$sender->send($message);
    </pre>


<hr />

<h2><a name="reading_mail">Reading Mail with IMAP or POP3</a></h2>
<p><b>Problem:</b> You want to read mail using IMAP or POP3, which allows you to create a web-based email client.</p>
<p><b>Solution:</b> use PHP's IMAP extension, which speaks both IMAP and POP3:</p>

<p><a href="http://php.net/imap" target="_blank">IMAP in general</a></p>

<pre class="prettyprint">
//open IMAP connection
$mail = imap_open('{mail.server.com:143}',  'username', 'password');
//or, open POP3 connection
$mail = imap_open('{mail.server.com:110/pop3}', 'username', 'password');

//grab a list of all the mail headers
$headers = imap_headers($mail);

//grab a header object for the last message in the mailbox
$last = imap_num_msg($mail);
$header = imap_header($mail, $last);

//grab the body for the same message
$body = imap_body($mail, $last);

//close the connection
imap_close($mail);
    </pre>


<hr />

<h2><a name="getting_putting">Getting and Putting Files with FTP</a></h2>
<p><b>Problem:</b> You want to transfer files using FTP</p>
<p><b>Solution:</b> Use PHP's built-in FTP functions:</p>
<p>You can also use the cURL extension:</p>

<p>Documentation on <a href="http://php.net/ftp" target="_blank">FTP extension</a></p>
<p><a href="http://php.net/curl" target="_blank">cURL</a></p>

<pre class="prettyprint">
$c = ftp_connect('ftp.example.com') or die("Can't connect");
ftp_login($c, $username, $password) or die("Can't login");
ftp_put($c, $remote, $local, FTP_ASCII) or die("Can't transfer");
ftp_close($c) or die("Can't close");

<hr />
//cURL
$c = curl_init("ftp//$username:$password@ftp.example.com/$remote");
//$local is the location to store file on local machine
$fh = fopen($local, 'w') or die($php_errormsg);
curl_setopt($c, CURLOPT_FILE, $fh);
curl_exec($c);
curl_close($c);
    </pre>


<hr />

<h2><a name="looking_up">Looking Up Addresses with LDAP</a></h2>
<p><b>Problem:</b> You want to query an LDAP server for address information.</p>
<p><b>Solution:</b> Use PHP's LDAP extension:</p>

<p>Documentation on <a href="http://php.net/ldap" target="_blank">LDAP</a></p>

<pre class="prettyprint">
$ds = ldap_connect('ldap.example.com') or die($php_errormsg);
ldap_bind($ds) or die($php_errormsg);
$sr = ldap_search($ds, 'o=Example Inc., c=US', 'sn=*') or die($php_errormsg);
$e = ldap_get_entries($ds, $sr) or die($php_errormsg);

for($i=0; $i&lt;$e['count']; $i++){
    echo $info[$i]['cn'][0].' (' .$info[$i]['mail'][0].')&lt;br>';
}

ldap_close($ds) or die($php_errormsg);
    </pre>


<hr />

<h2><a name="using_ldap">Using LDAP for User Authentication</a></h2>
<p><b>Problem:</b> You want to restrict parts of your site to authenticated users. Instead of verifying people against a database or using HTTP Basic Authentication, you want to use an LDAP server. Holding all user information in an LDAP server makes centralized user administration easier.</p>
<p><b>Solution:</b> Use PEAR's Auth class, which supports LDAP authentication:</p>

<pre class="prettyprint">
$options = array('host' => 'ldap.example.com',
                 'port' => '389',
                 'base' => 'o=Example Inc., c=US',
                 'userattr' => 'uid');
$auth new Auth('LDAP', $options);

//begin validation
//print login screen for anonymous users
$auth->start();

if($auth->getAuth()){
    //content for validated users
}else{
    //content for anonymous users
}

//log users out
$auth->logout();
    </pre>


<hr />

<h2><a name="dns_lookup">Performing DNS Lookups</a></h2>
<p><b>Problem:</b> You want to lookup a domain name or an IP address.</p>
<p><b>Solution:</b> Use gethostbyname() and gethostbyaddr():</p>

<p>Documentation on <a href="http://php.net/gethostbyname" target="_blank">gethostbyname()</a></p>
<p>Documentation on <a href="http://php.net/gethostbyaddr" target="_blank">gethostbyaddr()</a></p>
<p>Documentation on <a href="http://php.net/gethostbynamel" target="_blank">gethostbynamel()</a></p>
<p>Documentation on <a href="http://php.net/getmxrr" target="_blank">getmxrr()</a></p>
<p>Documentation on <a href="http://php.net/dns-get-record" target="_blank">dns_get_record()</a></p>
<p><a href="http://pear.php.net/package-info.php?package=Net_DNS2" target="_blank">PEAR's NET_DNS2 package</a></p>

<pre class="prettyprint">
$ip = gethostbyname('www.example.com');//93.184.216.119
$host = gethostbyaddr('93.184.216.119');//www.example.com


<hr />
$host = 'this is not a good host name!';
if($host == ($ip = gethostbyname($host))){
    //failure
}

<hr />
//get the MX records
getmxrr('yahoo.com', $hosts, $weight);
for($i=0; $i&lt;count($hosts); $i++){
    echo "$weight[$i] $hosts[$i]\n";
}
    </pre>


<hr />

<h2><a name="host_alive">Checking If a Host is Alive</a></h2>
<p><b>Problem:</b> You want to ping a host to see if it is still up and accessible from your location.</p>
<p><b>Solution:</b> Use PEAR's Net_Ping package:</p>

<p><a href="http://pear.php.net/package-info.php?package=Net_Ping" target="_blank">PEAR's Net_Ping package.</a></p>

<pre class="prettyprint">
require 'Net/Ping.php';

$ping = Net_Ping::factory();
if($ping->checkHost('www.oreilly.com')){
    print 'Reachable';
}else{
    print 'Unreachable';
}

$data = $ping->ping('www.oreilly.com');
    </pre>


<hr />

<h2><a name="getting_info">Getting Information About a Domain Name</a></h2>
<p><b>Problem:</b> You want to look up contact information or other details about a domain name.</p>
<p><b>Solution:</b> Use PEAR's Net_Whois class:</p>

<p><a href="http://pear.php.net/package-info.php?package=Net_Whois" target="_blank">PEAR's Net_Whois class</a></p>

<pre class="prettyprint">
require 'Net/Whois.php';
$server = 'whois.godaddy.com';
$query = 'oreilly.com';

$whois = new Net_Whois();
$data = $whois->query($query, $server);
    </pre>






      
      
      
</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>