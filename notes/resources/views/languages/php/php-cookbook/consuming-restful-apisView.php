<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

      <div class="page-header">
        <h1>Consuming RESTful APIs</h1>
      </div>


<table class="table table-responsive table-bordered">
	<caption>Table of Contents</caption>
    <tr>
    	<td><a href="#fetching_get">Fetching a URL with the GET Method</a></td>
        <td><a href="#fetching_post">Fetching a URL with the POST Method and Form Data</a></td>
        <td><a href="#fetching_arbitrary">Fetching a URL with an Arbitrary Method and POST body</a></td>
        <td><a href="#fetching_cookies">Fetching a URL with Cookies</a></td>
    </tr>
    <tr>
    	<td><a href="#fetching_headers">Fetching a URL with Arbitrary Headers</a></td>
        <td><a href="#fetching_timeout">Fetching a URL with a Timeout</a></td>
        <td><a href="#fetching_https">Fetching an HTTPS URL</a></td>
        <td><a href="#debugging">Debugging the Raw HTTP Exchange</a></td>
    </tr>
    <tr>
    	<td><a href="#oauth_1">Making an OAuth 1.0 Request</a></td>
        <td><a href="#oauth_2">Making an OAuth 2.0 Request</a></td>
        <td></td>
        <td></td>
    </tr>    
</table>

<h2><a name="fetching_get">Fetching a URL with the GET Method</a></h2>
<p><b>Problem:</b> You want to retrieve the contents of a URL. For example, you want to include part of one site in another site's content.</p>
<p><b>Solution:</b> Provide the URL to file_get_contents():</p>
<p>To retrieve a page that include query string variables, use http_build_query() to create the query string.</p>

<p>Documentation on <a href="http://php.net/file_get_contents" target="_blank">file_get_contents</a></p>
<p>Documentation on <a href="http://php.net/simplexml_load_file" target="_blank">simplexml_load_file()</a></p>
<p>Documentation on <a href="http://php.net/stream_context_create" target="_blank">stream_context_create()</a></p>
<p>Documentation on <a href="http://php.net/curl-init" target="_blank">curl_init()</a></p>
<p>Documentation on <a href="http://php.net/curl-setopt" target="_blank">curl_setopt()</a></p>
<p>Documentation on <a href="http://php.net/curl-exec" target="_blank">curl_exec()</a></p>
<p>Documentation on <a href="http://php.net/curl_getinfo" target="_blank">curl_getinfo()</a></p>
<p>Documentation on <a href="http://php.net/curl-close" target="_blank">curl_close()</a></p>
<p>The <a href="http://pear.php.net/package/HTTP_Request2" target="_blank">PEAR HTTP_Request2 class</a></p>

<pre class="prettyprint">
&lt;?php

$page = file_get_contents('http://www.example.com/robots.txt');

//Or you can use the cURL extension:
$c = curl_init('http://www.example.com/robots.txt');
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
$page = curl_exec($c);
curl_close($c);

//You can also use the HTTP_Request2 class from PEAR:
require_once 'HTTP/Request2.php';
$r = new HTTP_Request2('http://www.example.com/robots.txt');
$page = $r->send()->getBody();

<hr />
//http_build_query()
$vars = array('page' => 4, 'search' => 'this & that');
$qs = http_build_query($vars);
$url = 'http://www.example.com/search.php?' . $qs;
$page = file_get_contents($url);

?>
    </pre>


<hr />

<h2><a name="fetching_post">Fetching a URL with the POST Method and Form Data</a></h2>
<p><b>Problem:</b> You want to submit a document using the POST method, passing data formatted as an HTML form</p>
<p><b>Solution:</b> Set the method and content stream context options when using the http stream:</p>
<p>With cURL, set the CURLOPT_POST and CURLOPT_POSTFIELDS options:</p>
<p>Using HTTP_Request2, pass HTTP_Request2::METHOD_POST to setMethod() and chain calls to addPostParameter() for each name/value pair in the data to submit:</p>

<p>Documentation on <a href="http://php.net/wrappers.http" target="_blank">stream options</a></p>

<pre class="prettyprint">
&lt;?php

$url = 'http://www.example.com/submit.php';
//The submitted form data, encoded as query-string-style
//name-value pairs
$body = 'monkey=uncle&amp;amp;rhino=aunt';
$options = array('method' => 'POST',
                 'content' => $body,
                 'header' => 'Content-type: application/x-www-form-urlencoded');
//Create the stream context
$context = stream_context_create(array('http' => $options));
//Pass the context to file_get_contents()
print file_get_contents($url, false, $context);

<hr />
//cURL
$url = 'http://www.example.com/submit.php';
//The submitted form data, encoded as query-string-style
//name-value-pairs
$body = 'monkey=uncle&amp;rhino=aunt';
$c = curl_init($url);
curl_setopt($c, CURLOPT_POST, true);
curl_setopt($c, CURLOPT_POSTFIELS, $body);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
$page = curl_exec($c);
curl_close($c);

<hr />
//HTTP_Request2
require 'HTTP/Request2.php';

$url = 'http://www.example.com/submit.php';
$r = new HTTP_Request2($url);

$r->setMethod(HTTP_Request2::METHOD_POST)
  ->addPostParameter('monkey', 'uncle')
  ->addPostParameter('rhino', 'aunt');

$page = $r->send()->getBody();
    </pre>


<hr />

<h2><a name="fetching_arbitrary">Fetching a URL with an Arbitrary Method and POST Body</a></h2>
<p><b>Problem:</b> You want to request a URL using any method, such as POST, PUT, or DELETE. Your POST or PUT request may contain formatted data, such as JSON or XML.</p>
<p><b>Solution:</b> Set the method, header, and content stream context options when using the http stream:</p>
<p>With cURL, set the CURLOPT_CUSTOMREQUEST option to the method name.</p>
<p>In HTTP_Request2, call setMethod() with a method constant, setHeader() with the Content-Type, and setBody() with the contents of the request body:</p>

<pre class="prettyprint">
$url = 'http://www.example.com/meals/123';
$header = "Content-Type: application/json";
//The request body, in JSON
$body = '[{
    "type": "appetizer",
    "dish": "Chicken Soup"
}, {
    "type": "main course",
    "dish": "Fried Monkey Brains"
}]';

$options = array('method' => 'put',
    'header' => $header,
    'content' => $body);
//Create the stream context
$context = stream_context_create(array('http' => $options));
//Pass the context to file_get_contents()
print file_get_contents($url, false, $context);

<hr />
//cURL
$url = 'http://www.example.com/meals/123';
//The request body, in JSON
$body = '[{
    "type": "appetizer",
    "dish": "Chicken Soup"
}, {
    "type": "main course",
    "dish": "Fried Monkey Brains"
}]';
$c = curl_init($url);
curl_setopt($c, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($c, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($c, CURLOPT_POSTFIELDS, $body);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
$page = curl_exec($c);
curl_close($c);

<hr />
//HTTP_Request2
require 'HTTP/Request2.php';

$url = 'http://www.example.com/meals/123';
//The request body, in JSON
$body = '[{
    "type": "appetizer",
    "dish": "Chicken Soup"
}, {
    "type": "main course",
    "dish": "Fried Monkey Brains"
}]';
$r = new HTTP_Request2($url);
$r->setMethod(HTTP_Request2::METHOD_PUT);
$r->setHeader('Content-Type', 'application/json');
$r->setBody($body);

$page = $r->send()->getBody();

    <hr />
    <h3 class="nocode">Uploading a file with cURL and PUT</h3>
&lt;?php
$url = 'http://www.example.com/upload.php';
$filename = '/usr/local/data/pictures/piggy.jpg';
$fp = fopen($filename, 'r');
$c = curl_init($url);
curl_setopt($c, CURLOPT_PUT, true);
curl_setopt($c, CURLOPT_INFILE, $fp);
curl_setopt($c, CURLOPT_INFILESIZE, filesize($filename));
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
$page = curl_exec($c);
print $page;
curl_close($c);
    </pre>


<hr />

<h2><a name="fetching_cookies">Fetching a URL with Cookies</a></h2>
<p><b>Problem:</b> You want to retrieve a page that requires a cookie to be sent with the request for the page.</p>
<p><b>Solution:</b> Use the CURLOPT_COOKIE option with cURL:</p>
<p>With HTTP_Request2, use the addCookie() method:</p>

<p><a href="http://arxiv.org/abs/cs.SE/0105018" target="_blank">HTTP Cookies: Standards, Privacy, and Politics</a></p>

<pre class="prettyprint">
$c = curl_init('http://www.example.com/needs-cookies.php');
curl_opts($c, CURLOPT_COOKIE, 'user=ellen; activity=swimming');
curl_opts($c, CURLOPT_RETURNTRANSFER, true);
$page = curl_exec($c);
curl_close($c);

<hr />
//HTTP_Request2
require 'HTTP/Request2.php';
$r = new HTTP_Request2('http://www.example.com/needs-cookies.php');
$r->addCookie('user', 'ellen');
$r->addCookie('activity', 'swimming');
$page = $r->send()->getBody();
echo $page;
    </pre>


<hr />

<h2><a name="fetching_headers">Fetching a URL with Arbitrary Headers</a></h2>
<p><b>Problem:</b> You want to retrieve a URL that requires specific headers to be send with the request for the page.</p>
<p><b>Solution:</b> Set the header stream context when using the http stream:</p>
<p>With cURL, set the CURLOPT_HTTPHEADER option to an array of headers to send:</p>
<p>With HTTP_Request2, use the setHeader() method:</p>

<pre class="prettyprint">
$url = 'http://www.example.com/special-header.php';
$header = "X-Factor: 12\r\nMy-Header: Bob";
$options = array('header' => $header);
//Create the stream context
$context = stream_context_create(array('http' => $options));
//Pass the context to file_get_contents()
print file_get_contents($url, false, $context);

<hr />
//cURL
$c = curl_init('http://www.example.com/special-header.php');
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
curl_setopt($c, CURLOPT_HTTPHEADER, array('X-Factor: 12', 'My-Header: Bob'));
$page = curl_exect($c);
curl_close($c);

<hr />
//HTTP_Request2
require 'HTTP/Request2.php';

$r = new HTTP_Request2('http://www.example.com/special-header.php');
$r->setHeader(array('X-Factor' => 12, 'My-Header', 'Bob'));
$page = $r->send()->getBody();
print $page;
    </pre>


<hr />

<h2><a name="fetching_timeout">Fetching a URL with a Timeout</a></h2>
<p><b>Problem:</b> You want to fetch a remote URL, but don't want to wait around too long if the remote server is busy or slow.</p>
<p><b>Solution:</b> With the http stream, set the default_socket_timeout configuration option:</p>
<p>With cURL, set the CURLOPT_CONNECTTIMEOUT option:</p>
<p>With HTTP_Request2, set the timeout element in a parameter array passed to the HTTP_Request2 constructor:</p>

<p>Documentation on <a href="http://php.net/stream_set_timeout" target="_blank">stream_set_timeout()</a></p>
<p>Documentation on <a href="http://php.net/filesystem" target="_blank">default_socket_timeout</a></p>

<pre class="prettyprint">
//15 second timeout
ini_set('default_socket_timeout', 15);
$page = file_get_contents('http://slow.example.com/');

<hr />
//cURL
$c = curl_init('http://slow.example.com/');
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 15);
$page = curl_exec($c);
curl_close($c);

<hr />
//HTTP_Request2
require_once 'HTTP/Request2.php';

$r = new HTTP_Request2('http://slow.example.com/');
$r->setConfig(array(
    'connect_timeout' => 15
));

$page = $r->send()->getBody();
    </pre>


<hr />

<h2><a name="fetching_https">Fetching an HTTPS URL</a></h2>
<p><b>Problem:</b> You want to retrieve a secure URL</p>
<p><b>Solution:</b> Use any of the techniques described in Recipe 14.1 or Recipe 14.2 , providing a URL that begins with https.</p>

<p>As long as PHP has been built with the OpenSSL library, all of the functions that can
retrieve regular URLs can retrieve secure URLs. Look for the “openssl” section in the
output of phpinfo() to see if your PHP setup has SSL support.</p>

<hr />

<h2><a name="debugging">Debugging the Raw HTTP Exchange</a></h2>
<p><b>Problem:</b> You want to analyze the HTTP request a browser makes to your server and the corresponding HTTP response. For example, your server doesn't supply the expected response to a particular request so you want to see exactly what the components of the request are.</p>
<p><b>Solution:</b> For simple request, connect to the web server with Telnet and type in the request headers:</p>

<pre class="prettyprint">
POST /submit.php HTTP/1.1
User_Agent: PEAR HTTP_Request2 class ( http://pear.php.net/ )
Content-Type: application/x-www-form-urlencoded
Connection: close
Host: www.example.com
Content-Length: 12

monkey=uncle
    </pre>


<hr />

<h2><a name="oauth_1">Making an OAuth 1.0 Request</a></h2>
<p><b>Problem:</b> You want to make an OAuth 1.0 signed request.</p>
<p><b>Solution:</b> Use the PECL oauth extension.</p>

<p>Using the PECL oauth extension, you don't need to worry about the specifics of the algorithm itself. What you need to know instead is the general authorization flow, nickenamed the OAuth Dance:</p>

<ol>
	<li>You get an initial set of user tokens. These are also called request tokens or temporary tokens, because they’re only used during the authorization process and not to make actual API calls.</li>
	<li>You redirect the user to the API provider.</li>
	<li>The user signs into that site, which authenticates the user and asks him to authorize your application to make API calls on his behalf.</li>
	<li>After the user authorizes your application, the API provider redirects the user back to your application, passing along two pieces of data: the same temporary public key you provided to match up each reply with its corresponding user and a PIN to prevent against session fixation attacks.</li>
	<li>You exchange the PIN for permanent OAuth tokens for the user.</li>
	<li>You make API calls on behalf of the user.</li>
</ol>

<p>Documentation on <a href="http://php.net/oauth" target="_blank">oauth extension</a></p>
<p>The <a href="http://tools.ietf.org/html/rfc5849" target="_blank">OAuth 1.0 specification</a></p>
<p>The <a href="https://developer.linkedin.com/" target="_blank">LinkedIn Developer Network</a></p>

<hr />

<h2><a name="oauth_2">Making an OAuth 2.0 Request</a></h2>
<p><b>Problem:</b> You want to make an OAuth 2.0 signed request.</p>
<p><b>Solution:</b> Use the stream functions.</p>

<p>The OAuth 2.0 flow goes as follows:</p>

<ol>
	<li>You redirect the user to the API provider, passing along a self-generated secret value, known as the state, and the URL where the user should be redirected after sign in.</li>
	<li>The user signs into that site, which authenticates him and asks him to authorize your application to make API calls on his behalf.</li>
	<li>After the user authorizes your application, the API provider redirects the user back to your application, passing along two pieces of data: the same state you provided to match up each reply with its corresponding user and a code.</li>
	<li>You exchange the code for a permanent OAuth token for the user, passing along
your application ID and secret to identify yourself.</li>
	<li>You make API calls on behalf of the user.</li>
</ol>

<p>This "Hello World" example used LinkedIn's REST APIs to greet the user with his first name:</p>

<pre class="prettyprint">
//Change these
define('API_KEY',      'YOUR_API_KEY_HERE');
define('API_SECRET',   'YOUR_API_SECRET_HERE');
define('REDIRECT_URI', 'http://' . $_SERVER['SERVER_NAME'] .
                                   $_SERVER['SCRIPT_NAME']);
define('SCOPE',        'r_fullprofile r_emailaddress rw_nus');

//You'll probably use a database
session_name('linkedin');
session_start();

//Oauth 2 Control Flow
if(isset($_GET['error'])){
    //LinkedIn returned an error
    print $_GET['error'] . ': ' . $_GET['error_description'];
    exit;
}elseif(isset($_GET['code'])){
    //User authorized your application
    if($_SESSION['state'] == $_GET['state']){
        //Get token so you can make API calls
        getAccessToken();
    }else{
        //CSRF attack? or did you mix up your states?
        exit;
    }
}else{
    if((empty($_SESSION['expires_at'])) || (time() > $_SESSION['expires_at'])){
        //Token has expired, clear the state
        $_SESSION = array();
    }
    if(empty($_SESSION['access_token'])){
        //Start authorization process
        getAuthorizationCode();
    }
}

//Congratulations! You have a valid token. Now fetch a profile
$user = fetch('GET', '/v1/people/~:(firstName)');
print "Hello $user->firstName.\n";
exit;

function getAuthorizationCode(){
    $params = array('response_type' => 'code',
                    'client_id' => API_KEY,
                    'scopte' => SCOPE,
                    'state' => uniqid('', true), //unique long string
                    'redirect_uri' => REDIRECT_URI,
            );
            
    //Authentication request
    $url = 'https://www.linkedin.com/uas/oauth2/authorization?' . 
            http_build_query($params);
    
    //Needed to identify request when it returns to us
    $_SESSION['state'] = $params['state'];
    
    //Redirect user to authenticate
    header("Location: $url");
    exit;
}

function getAccessToken(){
    $params = array('grant_type' => 'authorization_code',
                    'client_id' => API_KEY,
                    'client_secret' => API_SECRET,
                    'code' => $_GET['code'],
                    'redirect_uri' => REDIRECT_URI,
            );
    //Access Token Request
    $url = 'https://www.linkedin.com/uas/oauth2/accessToken?' .
            http_build_query($params);
    //Tell streams to make a POST request
    $context = stream_context_create(
                array('http' =>
                    array('method' => 'POST',
                    )
                )
            );
    
    //Retrieve access token information
    $response = file_get_contents($url, false, $context);
    
    //native PHP object, please
    $token = json_decode($response);
    
    //Store access token and expiration time
    $_SESSION['access_token'] = $token->access_token; // guard this!
    $_SESSION['expires_in'] = $token->expires_in; //relative time (in seconds)
    $_SESSION['expires_at'] = time() + $_SESSION['expires_in']; //absolute time
    
    return true;
}

function fetch($method, $resource, $body = ''){
    $params = array('oath2_access_token' => $_SESSION['access_token'],
                    'format' => 'json',
              );
    
    //Need to use HTTPS
    $url = 'https://api.linkedin.com' . $resource . '?' .
           http_build_query($params);
    //Tell streams to make a (GET, POST, PUT, or DELETE) request
    $context = stream_context_create(
                   array('http' =>
                       array('method' => $method,
                       )
                   )
               );
    //Hocus Pocus
    $response = file_get_contents($url, false, $context);
    
    //Native PHP object, please
    return json_decode($response);
}
    </pre>


<p>For other API providers, the OAuth flow is the same, but you will need to alter the keys and URLs in this example and the API call itself.</p>




      
      
      
</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>