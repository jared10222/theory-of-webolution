<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

      <div class="page-header">
        <h1>Web Fundamentals</h1>
      </div>



<table class="table table-responsive table-bordered">
	<caption>Table of Contents</caption>
    <tr>
    	<td><a href="#setting_cookies">Setting Cookies</a></td>
        <td><a href="#reading_cookies">Reading Cookie Values</a></td>
        <td><a href="#deleting_cookies">Deleting Cookies</a></td>
        <td><a href="#building_query">Building a Query String</a></td>
    </tr>
    <tr>
    	<td><a href="#Reading_post_body">Reading the POST Request Body</a></td>
        <td><a href="#http_basic">Using HTTP Basic or Digest Authentication</a></td>
        <td><a href="#cookie_authentication">Using Cookie Authentication</a></td>
        <td><a href="#reading_http_header">Reading an HTTP Header</a></td>
    </tr>
    <tr>
    	<td><a href="#writing_http_header">Writing an HTTP Header</a></td>
        <td><a href="#sending_http_code">Sending a Specific HTTP Status Code</a></td>
        <td><a href="#redirecting">Redirecting to a Different Location</a></td>
        <td><a href="#Flushing_output">Flushing Output to the Browser</a></td>
    </tr>
    <tr>
        <td><a href="#buffering_output">Buffering Output to the Browser</a></td>
        <td><a href="#compressing_output">Compressing Web Output</a></td>
        <td><a href="#reading_env_vars">Reading Environment Variables</a></td>
        <td><a href="#setting_env_vars">Setting Environment Variables</a></td>
    </tr>
    <tr>
    	<td><a href="#comm_within_apache">Communicating Within Apache</a></td>
        <td><a href="#redirecting_mobile">Redirecting Mobile Browsers to a Mobile Optimized Site</a></td>
        <td><a href="#program_account">Program: Website Account (De)activator</a></td>
        <td><a href="#program_wiki">Program: Tiny Wiki</a></td>
    </tr>
    <tr>
    	<td><a href="#program_http">Program: HTTP Range</a></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    
     
</table>

<hr />

<h2><a name="setting_cookies">Setting Cookies</a></h2>
<p><b>Problem:</b> You want to set a cookie so that your website can recognize subsequent requests from the same web browser.</p>
<p><b>Solution:</b> Call setcookie() with a cookie name and value:</p>

<p>If the third argument to setcookie() is missing(or empty), the cookie expires when the browser is closed.</p>

<p>The fourth argument to setcookie() is a path.</p>

<p>The fifth argument to setcookie() is a domain.</p>

<p>Documentation on <a href="http://php.net/setcookie" target="_blank">setcookie()</a></p>

<pre class="prettyprint">
setcookie('flavor', 'chocolate chip');

setcookie('flavor', 'chocolate chip', 1417608000);

setcookie('flavor', 'chocolate chip', 0, '/products/');

setcookie('flavor', 'chocolate chip', 0, '', '.example.com');
setcookie('flavor', 'chocolate chip', 0, '', 'jeannie.example.com');
    </pre>


<hr />

<h2><a name="reading_cookies">Reading Cookie Values</a></h2>
<p><b>Problem:</b> You want to read the value of a cookie that you've previously set.</p>
<p><b>Solution:</b> Look in the $_COOKIE superglobal array:</p>

<pre class="prettyprint">
if(isset($_COOKIE['flavor'])){
    print You ate a {$_COOKIE['flavor']} . " cookie.";
}

foreach($_COOKIE as $cookie_name => $cookie_value){
    print "$cookie_name = $cookie_value &lt;br />";
}
    </pre>


<hr />

<h2><a name="deleting_cookies">Deleting Cookies</a></h2>
<p><b>Problem:</b> You want to delete a cookie so a browser doesn't send it back to the server. For example, you're using cookies to track whether a user is logged in to your website, and a user logs out.</p>
<p><b>Solution:</b> Call setcookie() with no value for the cookie and an expiration time in the past:</p>

<pre class="prettyprint">
setcookie('flavor', '',1);
    </pre>

<hr />

<h2><a name="building_query">Building a Query String</a></h2>
<p><b>Problem:</b> You need to construct a link that includes name/value pairs in a query string.</p>
<p><b>Solution:</b> Ust the http_build_query() function:</p>

<p>Documentation on <a href="http://php.net/http_build_query" target="_blank">http_build_query()</a></p>

<pre class="prettyprint">
$vars = array('name' => 'Oscar the Grouch',
              'color' => 'green',
              'favorite_punctuation' => '#');
$query_string = http_build_query($vars);
$url = '/muppet/select.php?' . $query_string;

//The URL built in the Solution is:
/muppet/select.php?name=Oscar+the+Grouch&amp;color=green&amp;
favorite_punctuation=%23

$url = '/muppet/select.php' . htmlentities($query_string);
    </pre>


<hr />

<h2><a name="Reading_post_body">Reading the POST Request Body</a></h2>
<p><b>Problem:</b> You want direct access to the body of a request, not just the parsed data that PHP puts in $_POST for you. For example, you want to handle an XML document that's been posted as part of a web services request.</p>
<p><b>Solution:</b> Read from the php://input stream:</p>

<p>Documentation on <a href="http://php.net/wrappers" target="_blank">php://input</a></p>
<p>Documentation on <a href="http://php.net/ini.core#ini.always-populate-raw-post-data" target="_blank">always_populate_raw_post_data</a></p>

<pre class="prettyprint">
$body = file_get_contents('php://input');
    </pre>


<hr />

<h2><a name="http_basic">Using HTTP Basic or Digest Authentication</a></h2>
<p><b>Problem:</b> You want to use PHP to protect parts of your website with passwords. Instead of storing the passwords in an external file and letting the web server handle the authentication, you want the password verification logic to be in a PHP program.</p>
<p><b>Solution:</b> The $_SERVER['PHP_AUTH_USER'] and $_SERVER['PHP_AUTH_PW'] superglobal variables contain the username and password supplied by the user, if any. To deny access to a page, send a WWW-Authenticate header identifying the authentication realm as part of a response with HTTP status code 401:</p>

<pre class="prettyprint">
http_response_code(401);
header('WWW-Authenticate: Basic realm="My Website"');
echo "You need to enter a valid username and password.";
exit();

    <hr />
    <h3 class="nocode">validate()</h3>

function validate($user, $pass){
    /*replace with appropriate username and password checking
    such as checking a database*/
    $users = array('david' => 'fadj&amp;32',
                   'adam' => '8HEj838');
                   
    if(isset($users[$user]) &amp;&amp; ($user[$user] === $pass)){
        return true;
    }else{
        return false;
    }
}

    <hr />
    <h3 class="nocode">Using a validation function</h3>

if(! validate($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])){
    http_response_code(401);
    header('WWW-Authenticate: Basic realm="My Website"');
    echo "You need to entar a valid username and password.";
    exit;

}

    <hr />
    <h3 class="nocode">Using Digest authentication</h3>

/*replace with appropriate username and password checking
such as checking a database*/
$users = array('david' => 'fadj&amp;32',
               'adam'  => '8HEj838');
$realm = 'My website';

$username = validate_digest($realm, $users);

//Execution never reaches this point if invalid auth data is provided
print "Hello, " . htmlentities($username);

function validate_digest($realm, $users){
    //Fail if no digest has been provided by the client
    if(! isset($_SERVER['PHP_AUTH_DIGEST'])){
        send_digest($realm);
    }
    //Faile if digest can't be parsed
    $username = parse_digest($_SERVER['PHP_AUTH_DIGEST'], $realm, $users);
    if($username === false){
        send_digest($realm);
    }
    
    //Valid username was specified in the digest
    return $username;
}

function send_digest($realm){
    http_response_code(401);
    $nonce = md5(uniqid());
    $opaque = md5($realm);
    header("WWW-Authenticate: Digest realm=\"$realm\" qop=\"auth\"".
        "nonce=\"$nonce\" opaque=\"$opaque\"");
    echo "You need to enter a valid username and password.";
    exit
}

function parse_digest($digest, $realm, $users){
    //We need to find the following values in the digest header
    //username, uri, qop, cnonce, nc, and response
    $digest_info = array();
    foreach(array('username', 'uri', 'nonce', 'cnonce', 'response') as $part){
        //Delimiter can either ba ' or " or nothing (for qop and nc)
        if(preg_match('/'.$part.'=([\'"]?)(.*?)\1/', $digest, $match)){
            //The part was found, save it for calculation
            $digest_info[$part] = $match[2];
        }else{
            //If the part is missing, the digest can't be validated
            return false;
        }
    }
    
    //Make sure the right qop has been provided
    if(preg_match('/qop=auth(,|$)/', $digest)){
        $digest_info['qop'] = 'auth';
    }else{
        return false;
    }
    
    //Make sure a valid nonce count has been provided
    if(preg_match('/nc=([0-9a-f]{8})(,|$)/', $digest, $match)){
        $digest_info['nc'] = $match[1];
    }else{
        return false;
    }
    
    //Now that all the necessary values have been slurped out of the
    //digest header, do the algorithmic computations necessary to
    //make sure that the right information was provided.
    //
    //These calcuations are described in sections 3.2.2, 3.2.2.1,
    //and 3.2.2.2 of RFC 2617.
    //Algorithm is MD5
    $A1 = $digest_info['username'] . ':' . $realm . ':' .
        $users[$digest_info['username']];
    //qop is 'auth'
    $A2 = $_SERVER['REQUEST_METHOD'] . ':' . $digest_info['uri'];
    $request_digest = md5(implode(':', array(md5($A1), $digest_info['nonce'],
        $digest_info['nc'],
    $digest_info['cnonce'], $digest_info['qop'], md5($A2))));
    
    //Did what was sent match what we computed?
    if($request_digest != $digest_info['response']){
        return false;
    }
    
    //Everything's OK, return the username
    return $digest_info['username'];
}
    
    </pre>


<hr />

<h2><a name="cookie_authentication">Using Cookie Authentication</a></h2>
<p><b>Problem:</b> You want more control over the user login procedure, such as presenting your own login form.</p>
<p><b>Solution:</b> Store authentication status in a cookie or as part of a session. When a user logs in successfully, put her username (or another unique value) in a cookie. Also include a hash of the username and a secret word so a user can't just make up an authentication cookie with a username in it:</p>

<p>Documentation on <a href="http://php.net/md5" target="_blank">md5()</a></p>

<pre class="prettyprint">
$secret_word = 'if i ate spinach';
if(validate($_POST['username'],$_POST['password'])){
    setcookie('login',
           $_POST['username'].','.md5($_POST['username'].$secret_word));
}

    <hr />
    <h3 class="nocode">Verifying a login cookie</h3>

unset($username);
if(isset($_COOKIE['login'])){
    list($c_username, $cookie_hash) = split(',', $_COOKIE['login']);
    if(md5($c_username.$secret_word) == $cookie_hash){
        $username = $c_username;
    }else{
        print "You have sent a bad cookie.";
    }
}

if(isset($username)){
    print "Welcome, $username.";
}else{
    print "Welcome, anonymous user.";
}

    <hr />
    <h3 class="nocode">Storing login info in a session</h3>

if(validate($_POST['username'],$_POST['password'])){
    $_SESSION['login']=
       $_POST['username'].','.md5($_POST['username'].$secret_word);
}


    <hr />
    <h3 class="nocode">Verifying session info</h3>

unset($username);
if(isset($_SESSION['login'])){
    list($c_username,$cookie_hash) = explode(',',$_SESSION['login']);
    if(md5($c_username.$secret_word) == $cookie_hash){
        $username = $c_username;
    }else{
        print "You have tampered with your session.";
    }
}

    <hr />
    <h3 class="nocode">Connectin logged-out and logged-in usage</h3>

if(validate($_POST['username'], $_POST['password'])){
    $_SESSION['login'] =
      $_POST['username'].','.md5($_POST['username'].$secret_word);
    error_log('Session id ' .session_id(). ' log in as '.$_POST['username']);
}
    </pre>

<hr />

<h2><a name="reading_http_header">Reading an HTTP Header</a></h2>
<p><b>Problem:</b> You want to read an HTTP request header.</p>
<p><b>Solution:</b> For a single header, look in the $_SERVER superglobal array:</p>
<p>For all header, call getallheaders():</p>

<pre class="prettyprint">
//User-Agent Header
echo $_SERVER['HTTP_USER_AGENT'];

$headers = getallheaders();
echo $headers['User-Agent'];
    </pre>


<hr />

<h2><a name="writing_http_header">Writing an HTTP Header</a></h2>
<p><b>Problem:</b> You want to write an HTTP header.</p>
<p><b>Solution:</b> Call the header() function:</p>

<p>Documentation on <a href="http://php.net/manual/en/function.header.php" target="_blank">header()</a></p>

<pre class="prettyprint">
//Tell em its a PNG
header('Content-Type: image/png');
    </pre>


<hr />

<h2><a name="sending_http_code">Sending a Specific HTTP Status Code</a></h2>
<p><b>Problem:</b> You want to explicitly set the HTTP status code. For example, you want to indicate that the user is unauthorized to view the page or the page is not found.</p>
<p><b>Solution:</b> Use http_response_code() to set the response:</p>

<p>Documentation on <a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html" target="_blank">status codes</a></p>

<pre class="prettyprint">
http_response_code(401);
    </pre>


<hr />

<h2><a name="redirecting">Redirecting to a Different Location</a></h2>
<p><b>Problem:</b> you want to automatically send a user to a new URL. For example, after successfully saving form data, you want to redirect a user to a page that confirms that the data has been saved.</p>
<p><b>Solution:</b> Before any output is printed, use header() to send a Location header with the new URL, and then call exit() so that nothing is printed:</p>

<p>To pass variables to the new page, include them in the query string of the URL:</p>

<p>Redirect URLs must include the protocal name and hostname. They cannot be just a pathname.</p>

<p>Documentation on <a href="http://php.net/manual/en/function.header.php" target="_blank">header()</a></p>

<pre class="prettyprint">
header('Location: http://www.example.com/confirm.html');
exit();

header('Location: http://www.example.com/?monkey=turtle');
exit();

<hr />

//Good Redirect
header('Location: http://www.example.com/catalog/food/pemmican.php');

//Bad Redirect
header('Location: /catalog/food/pemmican.php');
    </pre>


<hr />

<h2><a name="Flushing_output">Flushing Output to the Browser</a></h2>
<p><b>Problem:</b> You want to force output to be sent to the browser. For example, before doing a slow database query, you want to give the user a status update.</p>
<p><b>Solution:</b> Use flush():</p>

<p>Documentation on <a href="http://php.net/flush" target="_blank">flush()</a></p>

<pre class="prettyprint">
print "Finding identical snowflakes...";
flush();
$sth = $dbh->query(
    'SELECT shape, COUNT(*) AS c FROM snowflakes GROUP BY shape HAVING c > 1');

    <hr />
    <h3 class="nocode">Forcing IE to display content immediately</h3>

//To force IE to display content, print blank spaces
//at the beginning of the page    

print str_repeat(' ',300);
print 'Finding identical snowflakes...';
flush();
$sth = $dbh->query(
    'SELECT shape, COUNT(*) AS c FROM snowflakes GROUP BY shape HAVING c > 1');

    </pre>


<hr />

<h2><a name="buffering_output">Buffering Output to the Browser</a></h2>
<p><b>Problem:</b> You want to start generating output before you're finished sending headers or cookies.</p>
<p><b>Solution:</b> Call ob_start() at the top of your page and ob_end_flush() at the bottom. You can then intermix commands that generate output and commands that send headers. The output won't be send until ob_end_flush() is called:</p>

<p>Documentation on <a href="http://php.net/ob-start" target="_blank">ob_start()</a></p>
<p>Documentation on <a href="http://php.net/ob-end-flush" target="_blank">ob_end_flush()</a></p>
<p>Documentation on <a href="http://php.net/outcontrol" target="_blank">output buffering</a></p>

<pre class="prettyprint">
&lt;?php ob_start(); ?>

I haven't decided if I want to send a cookie yet.

&lt;?php setcookie('heron', 'great blue'); ?>

Yes, sending that cookie was the right decision.

&lt;?php
ob_end_flush();
?>
    </pre>

<hr />

<h2><a name="compressing_output">Compressing Web Output</a></h2>
<p><b>Problem:</b> You want to send compressed content to browsers that support automatic decompression.</p>
<p><b>Solution:</b> Add this setting to your php.ini file:</p>
<p>zlib:output_compression=1</p>

<p>Documentation on <a href="http://php.net/zlib" target="_blank">zlib extension</a></p>

<hr />

<h2><a name="reading_env_vars">Reading Environment Variables</a></h2>
<p><b>Problem:</b> You want to get the value of an environment variable.</p>
<p><b>Solution:</b> Use getenv():</p>

<p>Documentation on <a href="http://php.net/getenv" target="_blank">getenv()</a></p>

<pre class="prettyprint">
$path = getenv('PATH');
    </pre>


<hr />

<h2><a name="setting_env_vars">Setting Environment Variables</a></h2>
<p><b>Problem:</b> You want to set an environment variable in a script or in your server configuration. Setting environment varibles in your server configuration on a host-by-host basis allows you to configure virtual hosts differently.</p>
<p><b>Solution:</b> To set an environment variable in a script, use putenv():</p>
<p>To se an environment variable in your Apache httpd.conf file, use SetEvn:</p>

<p>Documentation on <a href="http://php.net/putenv" target="_blank">putenv()</a></p>
<p>Information on <a href="http://httpd.apache.org/docs/current/mod/mod_env.html" target="_blank">setting environment variables in Apache</a></p>

<pre class="prettyprint">
putenv('ORACLE_SID=ORACLE'); //configure oci extension

SetEnv DATABASE_PASSWORD password
    </pre>


<hr />

<h2><a name="comm_within_apache">Communicating Within Apache</a></h2>
<p><b>Problem:</b> You want to communicate from PHP to other parts of the Apache request process. This includes setting variables in the access_log.</p>
<p><b>Solution:</b> Use apache_note():</p>

<p>Documentation on <a href="http://php.net/apache-note" target="_blank">apache_note()</a></p>
<p>Information on <a href="http://httpd.apache.org/docs/current/mod/mod_log_config.html" target="_blank">loggin in Apache.</a></p>

<pre class="prettyprint">
//get value
$session = apache_note('session');

//set value
apache_note('session', $session);
    </pre>


<hr />

<h2><a name="redirecting_mobile">Redirecting Mobile Browsers to a Mobile Optimized Site</a></h2>
<p><b>Problem:</b> You want to send mobile or tablet browsers an alternative site or alternative content that is optimized for their device.</p>
<p><b>Solution:</b> use the object returned by get_browser() to determine if it's a mobile browser:</p>

<p>One source for a browser capability file is <a href="http://browscap.org/" target="_blank">Browscap</a>. Download the php_browscap.ini file from that site (not the standard version).</p>
<p>Once you download a browser capability file, you need to tell PHP where to find it by setting the browscap configuration directive to the pathname of the file. If you use PHP as a CGI, set the directive in the php.ini file:</p>
<p>After you identify the device as mobile, you can then redirect the request to a specific mobile optimized site or render a mobile optimized page:</p>

<p>Documentation on <a href="http://php.net/get-browser" target="_blank">get_browser()</a></p>

<pre class="prettyprint">
if($browser->ismobilebrowser){
    //print mobile layout
}else{
    //print desktop layout
}
<hr />

browscap=/usr/local/lib/php_browscap.ini

header('Location: http://m.example.com/');
    </pre>

<hr />

<h2><a name="program_account">Program: Website Account (De)activator</a></h2>

<h2><a name="program_wiki">Program: Tiny Wiki</a></h2>

<h2><a name="program_http">Program: HTTP Range</a></h2>





     
      
      
</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>