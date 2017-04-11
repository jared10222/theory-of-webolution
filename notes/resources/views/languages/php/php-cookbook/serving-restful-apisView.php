<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

      <div class="page-header">
        <h1>Serving RESTful APIs</h1>
      </div>


<table class="table table-responsive table-bordered">
	<caption>Table of Contents</caption>
    <tr>
    	<td><a href="#exposing_routing">Exposing and Routing to a Resource</a></td>
        <td><a href="#exposing_clean">Exposing Clean Resource Paths</a></td>
        <td><a href="#exposing_reading">Exposing a Resource for Reading</a></td>
        <td><a href="#creating_resource">Creating a Resource</a></td>
    </tr>
    <tr>
    	<td><a href="#editing_resource">Editing a Resource</a></td>
        <td><a href="#deleting_resource">Deleting a Resource</a></td>
        <td><a href="#errors">Indicating Errors and Failures</a></td>
        <td><a href="#multi_formats">Supporting Multiple Formats</a></td>
    </tr>
</table>

<hr />
<p>The original document describing REST is <a href="https://www.ics.uci.edu/~fielding/pubs/dissertation/top.htm" target="_blank">Roy Fielding's thesis</a></p>

<hr />

<h2><a name="exposing_routing">Exposing and Routing to a Resource</a></h2>
<p><b>Problem:</b> You want to provide access to a resource and handle request according to the HTTP method.</p>
<p><b>Solution:</b> Use the $_SERVER['REQUEST_METHOD'] variable to route the request:</p>

<p>Documentation on <a href="http://php.net/http_response_code" target="_blank">http_response_code()</a></p>

<pre class="prettyprint">
$request = explode('/', $_SERVER['PATH_INFO']);

$method = strtolower($_SERVER['REQUEST_METHOD']);
switch($method){
    case 'get':
        //handle a GET request
        break;
    case 'post':
        //handle a POST request
        break;
    case 'put':
        //handle a PUT request
        break;
    case 'delete':
        //handle a DELETE request
        break;
    default:
        //unimplemented method
        http_response_code(405);
}

<hr />

//parse the path into its components by breaking the 
//the $_SERVER['PATH_INFO'] apart on "/":

$request = explode('/', $_SERVER['PATH_INFO'];

//This breaks a request for /v1/books.php/9781449363758 into:
Array
(
    [0] =>
    [1] => 9781449363758
)
    </pre>


<hr />

<h2><a name="exposing_clean">Exposing Clean Resource Paths</a></h2>
<p><b>Problem:</b> You want your URLs to look clean and not include file extensions.</p>
<p><b>Solution:</b> Use Apache's mod_rewrite to map the path to your PHP script:</p>
<p>Then use $_GET['PATH_INFO'] in place of $_SERVER['PATH_INFO']:</p>

<p>Documentation on <a href="http://httpd.apache.org/docs/current/mod/mod_rewrite.html" target="_blank">Apache mod_rewrite module.</a></p>

<pre class="prettyprint">
RewriteEngine on
RewriteBase /v1/
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?PATH_INFO=$1[L,QSA]

<hr />

$request = explode('/', $_GET['PATH_INFO']);
    </pre>

<hr />

<h2><a name="exposing_reading">Exposing a Resource for Reading</a></h2>
<p><b>Problem:</b> You want to let people read a resource.</p>
<p><b>Solution:</b> Read request using GET. Return structured results, using formats such as JSON, XML, or HTML. Don't modify any resources.</p>

<pre class="prettyprint">
//For a GET request to the resource at
//http://api.example.com/v1/jobs/123:
GE /v1/jobs/123 HTTP/1.1
Host: api.example.com

&lt;?php
//Use this PHP code:
//Assume this was pulled from a database or other data store
$job[123] = [
    'id' => 123,
    'position' => [
        'title' => 'PHP Developer',
       ],
   ];
$json = json_encode($job[123]);

//Resource exists 200: OK
http_response_code(200);

//And it's being sent back as JSON
header('Content-Type: application/json');

print $json;

?>

//To generate this HTTP response:

HTTP/1.1 200 OK
Content-Type: application/json
Content-Length: 61
{
    "id": 123,
    "position":{
        "title": "PHP Developer"
    }
}
    </pre>

<hr />

<h2><a name="creating_resource">Creating a Resource</a></h2>
<p><b>Problem:</b> You want to let people add a new resource to the system.</p>
<p><b>Solution:</b> Accept request using POST. Read the POST body. Return success and the location of the new resource.</p>

<pre class="prettyprint">
//For a POST request to 
//httP//api.example.com/v1/jobs:

POST /v1/jobs HTTP/1.1
Host: api.example.com
Content-Type: application/json
Content-Length: 49

{
    "position" :{
        "title": "PHP Developer"
    }
}

//Use this PHP code:

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $body = file_get_contents('php://input');
    switch(strtolower($_SERVER['HTTP_CONTENT_TYPE'])){
        case "application/json":
            $job = json_decode($body);
            break;
        case "text/xml":
        	//parsing here
            break;
    }
    
    // Validate input
    
    // Create new Resource
    $id = create($job);//Returns id of 456
    $json = json_encode(array('id'=>$id));
    
    http_response_code(201); //Created
    $site = 'https://api.example.com';
    header("Location: $site/" . $_SERVER['REQUEST_URI'] . "/$id");
    header('Content-Type: application/json');
    print $json;
}

//To generate this output:

HTTP/1.1 201 Created
Location: https://api.example.com/jobs/456
Content-Type: application/json
Content-Length: 15
{
    "id":456
}
    </pre>


<hr />

<h2><a name="editing_resource">Editing a Resource</a></h2>
<p><b>Problem:</b> You want to let people update a resource</p>
<p><b>Solution:</b> Accept request using PUT. Read the POST body. Return success.</p>

<p>Documentation on <a href="http://tools.ietf.org/html/rfc5789" target="_blank">HTTP PATCH method</a></p>

<pre class="prettyprint">
PUT /v1/jobs/123 HTTP/1.1
Host: api.example.com
Content-Type: application/json
Content-Length: 49
{
    "position":{
        "title": "PHP Developer"
    }
}

//Use this PHP code:
if($_SERVER['REQUEST_METHOD'] == 'PUT'){
    $body = file_get_contents('php://input');
    switch(strtolower($_SERVER['HTTP_CONTENT_TYPE'])){
        case "application/json":
            $job = json_decode($body);
            break;
        case "text/xml":
            //parsing here
            break;
    }
    //Validate input
    
    //Modify the Resource
    
    $request = explode('/', substr($_SERVER['PATH_INFO'],1));
    $resource = array_shift($request);
    $id = update($job, $request[0]); //Uses id from request
    
    http_response_code(204); //No content
}

//To generate this output:
HTTP/1.1 204 No Content
    </pre>


<hr />

<h2><a name="deleting_resource">Deleting a Resource</a></h2>
<p><b>Problem:</b> You want to let people delete a resource.</p>
<p><b>Solution:</b> Accept requests using DELETE. Return success.</p>

<pre class="prettyprint">
//For a DELETE request to
//http://api.example.com/v1/jobs/123:
DELETE /v1/jobs/123 HTTP/1.1
Host: api.example.com

//Use this PHP code:
if($_SERVER['REQUEST_METHOD'] == 'DELETE']{
    //DELETE the Resource
    
    $request = explode('/', substr($_SERVER['PATH_INFO'],1));
    $resource = array_shift($request);
    $success = delete($request[0]); //Uses id from request
    
    http_response_code(204); //No Content
}

//To generate this output:
HTTP/1.1 204 No Content
    </pre>


<hr />

<h2><a name="errors">Indicating Erros and Failures</a></h2>
<p><b>Problem:</b> You want to indicate that a failure occurred.</p>
<p><b>Solution:</b> Return a 4xx status code for client failures. Provide a message with more information.</p>

<p>Return a 5xx code for server failures. Provide a message with more information.</p>

<pre class="prettyprint">
http_response_code(401); //Unauthorized

$error_body = [
    "error" => "Unauthorized",
    "code" => 1,
    "message" => "Only authenticated users can read " . $_SERVER['REQUEST_URI'],
    "url" => "http://developer.example.com/error/1"
];

print json_encode($error_body);

<hr />

http_response_code(503); //Site Down

$error_body = [
    "error" => "Down for maintencance",
    "code" => 2,
    "message" => "Check back in two hours.",
    "url" => "http://developer.example.com/error/2"
];

print json_encode($error_body);
    </pre>


<hr />

<h2><a name="multi_formats">Supporting Multiple Formats</a></h2>
<p><b>Problem:</b> You want to support multiple formats, such as JSON and XML.</p>
<p><b>Solution:</b> Use file extensions:</p>

<p>Or, support the Accept HTTP header:</p>

<pre class="prettyprint">
http://api.example.com/people/rasmus.json
http://api.example.com/people/rasmus.xml

//Break apart URL
$request = explode('/', $_SERVER['PATH_INFO']);

//Extract the root resource and type
$resource = array_shift($request);
$file = array_pop($request);
$dot = strrpos($file, ".");
if($dot === false) {// note: three equal signs
    $request[] = $file;
    $type = 'json'; //default value
}else{
    $request[] substr($file, 0, $dot);
    $type = substr($file, $dot + 1);
}
    </pre>







      
      
      
</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>