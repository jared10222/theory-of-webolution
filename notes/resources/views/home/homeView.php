<?php
require_once(assets("includes/header.php"));
?>
    <!-- Begin page content -->
    <div class="container">
      <div class="page-header">
        <h1><?php echo $site_name; ?></h1>
      </div>
      <p class="lead">This site is for all the notes I take while studying various programming languages as well as design techniques. It's main purpose is to serve as a reference for future use.</p>
      
<pre class="prettyprint">
&lt;pre class="prettyprint">


&lt;?php
namespace livid\controllers;
use livid\controllers\Controller;

class homeController extends Controller {

    private $method
    
    public function __construct($method = NULL){
        $this->method = $method;
    }
    
    /**
     * Load the view
    */
    public function index($uri, $data){
        return parent::view($uri, $data);
    }
    
}
?>

&lt;/pre>
</pre>
      
    </div>

<?php require_once(assets("includes/footer.php")); ?>