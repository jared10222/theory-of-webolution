<nav class="main-nav">
<button id="showPhoneNav">Show Menu <i class="fa fa-bars fa-lg"></i></button>
<ul id="myNav">
	<li class="<?php echo checkActiveLink($body_class, "home"); ?>"><a href="/">Home</a></li>
    <li class="<?php echo checkActiveLink($body_class, "contact-us"); ?>"><a href="/contact-us">Contact Us</a></li>
    <li class="<?php echo checkActiveLink($body_class, "portfolio"); ?>"><a href="/portfolio">Portfolio</a></li>
</ul>
</nav>