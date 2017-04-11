<!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/"><?php echo $site_name; ?></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li <?php checkActiveLink($body_class, "index"); ?>><a href="/">Home</a></li>
            <li <?php checkActiveLink($body_class, "tutorials"); ?>><a href="/tutorials">Tutorials</a></li>
            <li <?php checkActiveLink($body_class, "design"); ?>><a href="/design">Design</a></li>
            <li <?php checkActiveLink($body_class, "links"); ?>><a href="/links">Links</a></li>
            <li <?php checkActiveLink($body_class, "feed"); ?>><a href="/feed">Feed</a></li>
            
            <li class="dropdown <?php checkDropDownLink($body_class); ?>">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Languages <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li <?php checkActiveLink($body_class, "html"); ?>><a href="/html">HTML</a></li>
                <li <?php checkActiveLink($body_class, "css"); ?>><a href="/css">CSS</a></li>
                <li <?php checkActiveLink($body_class, "javascript"); ?>><a href="/javascript">JavaScript</a></li>
                <li <?php checkActiveLink($body_class, "jquery"); ?>><a href="/jquery">jQuery</a></li>
                <li <?php checkActiveLink($body_class, "mysql"); ?>><a href="/mysql">MySQL</a></li>
                <li <?php checkActiveLink($body_class, "php"); ?>><a href="/php">PHP</a></li>
                <li <?php checkActiveLink($body_class, "cplusplus"); ?>><a href="/cplusplus">C++</a></li> 
                <li <?php checkActiveLink($body_class, "xml"); ?>><a href="/xml">XML</a></li>
                <li <?php checkActiveLink($body_class, "java"); ?>><a href="/java">Java</a></li>
                <li <?php checkActiveLink($body_class, "csharp"); ?>><a href="/csharp">C#</a></li>
              </ul>
            </li>
            
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>