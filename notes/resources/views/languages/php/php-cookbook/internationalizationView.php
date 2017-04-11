<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

      <div class="page-header">
        <h1>Internationalization</h1>
      </div>


<table class="table table-responsive table-bordered">
	<caption>Table of Contents</caption>
    <tr>
    	<td><a href="#users_locale">Determining the User's Locale</a></td>
        <td><a href="#localizing_text">Localizing Text Messages</a></td>
        <td><a href="#localizing_dates">Localizing Dates and Times</a></td>
        <td><a href="#localizing_numbers">Localizing Numbers</a></td>
    </tr>
    <tr>
    	<td><a href="#localizing_currency">Localizing Currency Values</a></td>
        <td><a href="#localizing_images">Localizing Images</a></td>
        <td><a href="#localizing_files">Localizing Included Files</a></td>
        <td><a href="#sorting">Sorting in a Locale-Aware Order</a></td>
    </tr>
    <tr>
    	<td><a href="#localization_resources">Managing Localization Resources</a></td>
        <td><a href="#outgoing_data">Setting the Character Encoding of Outgoing Data</a></td>
        <td><a href="#incoming_data">Setting the Character Encoding of Incoming Data</a></td>
        <td><a href="#utf_8">Manipulating UTF-8 Text</a></td>
    </tr>    
</table>

<hr />
<p>A <b>locale</b> is a group of settings that describe text formatting and language customs in a particular area of the world. Locals describe behavior for:</p>

<dl>
	<dt>Collation</dt>
    <dd>How text is sorted: which letters go before and after others in alphabetical order.</dd>
    <dt>Numbers</dt>
    <dd>How numeric information (including currency amounts) is displayed, including how to group digits, what characters to use as the thousands operator and decimal point, and how to indicate negative amounts.</dd>
    <dt>Times and Dates</dt>
    <dd>How time and date information is formatted and displayed, such as names of months and days and whether to use 24- or 12-hour time.</dd>
    <dt>Messages</dt>
    <dd>Text messages used by applications that need to display information in multiple languages.</dd>
</dl>

<hr />

<h2><a name="users_locale">Determining The User's Locale</a></h2>
<p><b>Problem:</b> You want to use the correct locale as specified by a user's web browser.</p>
<p><b>Solution:</b> Pass the incoming Accept-Language HTTP header value to the Locale::acceptFromHttp() function to get the proper locale identifier:</p>

<p>Documentation for <a href="http://php.net/Locale.acceptFromHttp" target="_blank">Locale::acceptFromHttp()</a></p>
<p>Documentation for <a href="http://php.net/Locale.getDefault" target="_blank">Locale::getDefault()</a></p>
<p>Documentation for <a href="http://php.net/Locale.setDefault" target="_blank">Locale::setDefault()</a></p>
<p>More information about <a href="http://www.w3.org/Protocols/rfc2616/rfc2616.html" target="_blank">RFC 2616</a></p>

<pre class="prettyprint">
if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
    $localeToUse = Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
}else{
    $localeToUse = Locale::getDefault();
}
    </pre>


<hr />

<h2><a name="localizing_text">Localizing Text Messages</a></h2>
<p><b>Problem:</b> You want to display text messages in a locale-appropriate language.</p>
<p><b>Solution:</b> Maintain a message catalog of words and phrases and retrieve the appropriate string from the message catalog before passing it to a MessageFormatter object to format it for printing:</p>

<p>Documentation on <a href="http://php.net/MessageFormatter" target="_blank">MessageFormatter class.</a></p>
<p>Because <b>MessageFormatter</b> relies on ICU for its emplementation, the ICU documentation on message formatting and arguments is very helpful, in particular the <a href="http://userguide.icu-project.org/formatparse/messages" target="_blank">ICU User Guide</a> and <a href="http://icu-project.org/apiref/icu4c/classMessageFormat.html#details" target="_blank">ICU 53.1</a></p>

<pre class="prettyprint">
$messages = array();
$messages['un_US'] =
    array('FAVORITE_FOODS' => 'My favorite food is {0}.',
          'FRIES' => 'french fries',
          'CANDY' => 'candy',
          'CHIPS' => 'potato chips',
          'EGGPLANT' => 'eggplant');
$messages['en_GB'] =
    array('FAVORITE_FOODS' => 'My Favourite food is {0}.',
          'FRIES' => 'chips',
          'CANDY' => 'sweets',
          'CHIPS' => 'crisps',
          'EGGPLANT' => 'aubergine');

foreach(array('en_US', 'en_GB') as $locale){
    $candy = new MessageFormatter($locale, $messages[$locale]['CANDY']);
    $favs = new MessageFormatter($locale, $messages[$locale]['FAVORITE_FOODS']);
    print $favs->format(array($candy->format(array()))). "\n";
}   

//This prints:

//My favorite food is candy.
//My favorite food is sweets. 
    </pre>


<hr />

<h2><a name="localizing_dates">Localizing Dates and Times</a></h2>
<p><b>Problem:</b> You want to display dates and times in a locale-specific manner.</p>
<p><b>Solution:</b> Use the date or time argument type, with an optional short, medium, long, or full style inside a MessageFormatter message:</p>

<p>Use a formatting pattern with a date or time argument type inside a messageFormatter message:</p>

<p>Use the format() method of an IntlDateFormatter:</p>

<p>Documentation on <a href="http://php.net/IntlDateFormatter" target="_blank">IntlDateFormatter</a></p>
<p>Documentation on <a href="http://php.net/IntlDateFormatter.format" target="_blank">IntlDateFormatter::format()</a></p>
<p>Documentation on <a href="http://php.net/IntlDateFormatter.formatObject" target="_blank">IntlDateFormatter::formatObject()</a></p>

<pre class="prettyprint">
$when = 1376943432; //Seconds since epoch
$message = "It is {0,time,short} on {0,date,medium}."; 
$fmt = new MessageFormatter('en_US', $message);
print $fmt->format(array($when));

//This prints:

//It is 4:17 PM on Aug 19, 2013.

<hr />

$when = 1376943432; //Seconds since epoch
$message = "Maintenant: {0, date, eeee dd MMMM y}";
$fmt = new MessageFormatter('fr_FR', $message);
print $fmt->format(array($when));

//This Prints:

//Maintenant: lundi 19 aou`t 2013

<hr />

$when = 1376943432; //Seconds since epoch
$fmt = new IntlDateFormatter('en_US', IntlDateFormatter::FULL,
                             IntlDateFormatter::FULL);
print $fmt->format($when);

//This prints:

//Monday, August 19, 2013 at 8:17:12 PM GMT  
    </pre>


<hr />

<h2><a name="localizing_numbers">Localizing Numbers</a></h2>
<p><b>Problem:</b> You want do display numbers in a locale-specific format.</p>
<p><b>Solution:</b> Use the number argument type with MessageFormatter:</p>

<p>Documentation for <a href="http://php.net/numberformatter" target="_blank">NumberFormatter class</a></p>
<p>Documentation for <a href="http://icu-project.org/apiref/icu4c/classicu_1_1DecimalFormatSymbols.html" target="_blank">ICU's deciaml format pattern characters.</a></p>

<pre class="prettyprint">
$message = '{0,number} / {1,number} = {2,number}';
$args = array(5327, 98, 5327/98);

$us = new MessageFormatter('en_US', $message);
$fr = new MessageFormatter('fr_FR', $message);
print $us->format($args) . "\n";
print $fr->format($args) . "\n";

//This prints:

//5,327 / 98 = 54.357
//5 327 / 98 = 54,357
    </pre>


<hr />

<h2><a name="localizing_currency">Localizing Currency Values</a></h2>
<p><b>Problem:</b> You want to display currency amounts in a locale-specific format.</p>
<p><b>Solution:</b> For default formatting inside a message, use the currency style of the number argument type:</p>

<p>For more specific formatting, use the formatCurrencty() method of a NumberFormatter:</p>

<p>Documentation on <a href="http://php.net/numberformatter.formatcurrency" target="_blank">NumberFormatter::formatCurrency()</a></p>
<p>Documentation on <a href="http://php.net/numberformatter" target="_blank"> the differenct formatting attributes.</a></p>

<pre class="prettyprint">
$income = 5549.3;
$debit = -25.95;

$fmt = new MessageFormatter('en_US',
                    '{0,number,currencty} in and {1,number,currencty} out');
print $fmt->format(array($income,$debit));

//This prints:
//$5,549.30 in and -$25.95 out

<hr />

$income = 5549.3;
$debit = -25.95;

$fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
print $fmt->formatCurrency($income, 'USD') . ' in and ' .
   $fmt->formatCurrency($debit, 'EUR') . ' out';
   
//This prints:

//$5,549.30 in and -&euro;25.95 out
    </pre>


<hr />

<h2><a name="localizing_images">Localizing Images</a></h2>
<p><b>Problem:</b> You want to display images that have text in them and have that text in a locale-appropriate language.</p>
<p><b>Solution:</b> Make an image directory for each locale you want to support, as well as a global image directory for images that have no locale-specific information in them. Create copies of each locale-specific image in the appropriate locale-specific directory. Make sure that the images have the same filename in the different directories. Instead of printing out image URLs directly, treat their paths as localizable strings, either by explicitly storing them in your message catalogs or by computing the right path at runtime.</p>

<p>The img() wrapper function below looks for a locale-specific version of an image first, then a global one. If neither are present, it prints a message to the error log.</p>

<pre class="prettyprint">
    <h3 class="nocode">Finding locale-specific images</h3>

function img($locale, $f){
    static $image_base_path = '/usr/local/www/images';
    static $image_base_url = '/images';
    
    if(is_readable("$image_base_path/$locale/$f")){
        return "$image_base_url/$locale/$f";
    }elseif(is_readable("$image_base_path/global/$f")){
        return "$image_base_url/global/$f";
    }else{
        error_log("l10n error: locale: $local, image: '$f'");
    }
}

    <hr />
    <h3 class="nocode">A localized &lt;img> element</h3>

print '&lt;img src="' . img($locale, 'cancel.png') . '" ' .
    'alt="' . $message[$locale]['CANCEL'] . '"/>';

    <hr />
    <h3 class="nocode">A localized &lt;img> element with height and width</h3>

print '&lt;img src="' . img($locale, 'cancel.png') . '" ' .
    'alt="' . $messages[$locale]['CANCEL'] . '" ' . 
    'height="' . $messages[$locale]['CANCEL_IMG_HEIGHT']. '" ' .
    'width="' . $messages[$locale]['CANCEL_IMG_WIDTH'] . '"/>';
    </pre>


<hr />

<h2><a name="localizing_files">Localizing Included Files</a></h2>
<p><b>Problem:</b> You want to include locale-specific files in your pages.</p>
<p><b>Solution:</b> Modify include_path once you've determined the appropriate locale:</p>

<p>Documentation on <a href="http://php.net/manual-lookup.php?pattern=ini.core.php&lang=en&scope=404quickref#ini.include-path" target="_blank">include_path</a></p>
<p>Documentation on <a href="http://php.net/manual-lookup.php?pattern=ini.core.php&lang=en&scope=404quickref#ini.auto-prepend-file" target="_blank">auto_prepend_file</a></p>

<pre class="prettyprint">
    <h3 class="nocode">Modifying include_path for localization</h3>

$base = '/usr/local/php-include';
$locale = 'en_US';

$include_path = ini_get('include_path');
ini_set('include_path', "$base/$locale:$base/global:$include_path");
    </pre>


<hr />

<h2><a name="sorting">Sorting in a Locale-Aware Order</a></h2>
<p><b>Problem:</b> You need to sort text in a way that respects a particular locale's rules for character ordering.</p>
<p><b>Solution:</b> Instantiate a Collator object for your locale, and then call its sort() method:</p>

<p>Documentation on <a href="http://php.net/Collator" target="_blank">Collator</a></p>

<pre class="prettyprint">
$words = array('Mannha', 'kny6hnka', 'Orypeu');
$collator = new Collator('ru_RU');
//Sorts in-place, just like sort()
$collator->sort($words);
    </pre>


<hr />

<h2><a name="localization_resources">Managing Localization Resources</a></h2>
<p><b>Problem:</b> You need to keep track of your various message catalogs and images.</p>
<p><b>Solution:</b> Store each message catalog as a serialized PHP array that maps keys to locale-specific message values. Or, if you need interoperability with ICU-aware tools or other languages, use the ResourceBundle class.</p>

<p>At its heart, a message catalog is just a mapping from keys to values. An English message catalog may map HELLO_WORLD to "Hello, World" but a Spanish one maps it to "Hola, Mundo."</p>

<p>Documentation on <a href="http://php.net/ResourceBundle" target="_blank">ResourceBundle</a></p>
<p>An overview of ICU resource management, including the syntax for <a href="http://userguide.icu-project.org/locale/resources" target="_blank">writing resource bundle files.</a></p>

<pre class="prettyprint">
    <h3 class="nocode">Saving message catalogs as serialized arrays</h3>

$messages = array();
$messages['en_US'] =
    array('FAVORITE_FOODS' => 'My favorite food is {0}.',
          'FRIES' => 'french fries',
          'CANDY' => 'candy',
          'CHIPS' => 'potato chips',
          'EGGPLANT' => 'eggplant');
$messages['en_GB'] =
    array('FAVORITE_FOODS' => 'My favorite food is {0}.',
          'FRIES' => 'chips',
          'CANDY' => 'sweets',
          'CHIPS' => 'crisps',
          'EGGPLANT' => 'aubergine');
foreach($messages as $locale => $entries){
    file_put_contents(__DIR__."/$locale.ser", serialize($entries));
}

    <hr />
    <h3 class="nocode">Using message catalogs from serialized arrays</h3>

/*This might come from user input or the browser*/
define('LOCALE', 'en_US');
/*If you can't trust the locale, add some error checking
* in case the file doesn't exist or can't be
* unserialized. */
$messages = unserialize(file_get_contents(__DIR__.'/'.LOCALE.'.ser'));

$candy = new MessageFormatter(LOCALE, $messages['CANDY']);
$favs = new MessageFormatter(LOCALE, $messages['FAVORITE_FOODS']);
print $favs->format(array($candy->format(array()))) . "\n";
    </pre>


<hr />

<h2><a name="outgoing_data">Setting the Character Encoding of Outgoing Data</a></h2>
<p><b>Problem:</b> You want to make sure that browsers correctly handle the UTF-8-encoded text that your programs emit.</p>
<p><b>Solution:</b> Set PHP's default_encoding configuration directive to utf-8. This ensures that the Content-Type header PHP emits on HTML responses includes the charset=utf-8 piece, which tells web browsers to interpret the page contents as UTF-8 encoded.</p>

<p>If you can't change the default_encoding configuration directive, send the proper Content-Type header yourself with the header() function:</p>

<pre class="prettyprint">
    <h3 class="nocode">Setting character encoding</h3>

header('Content-Type: text/html;charset=utf-8');
    </pre>


<hr />

<h2><a name="incoming_data">Setting the Character Encoding of Incoming Data</a></h2>
<p><b>Problem:</b> You want to make sure that data flowing into your program has a consistent character encoding so you can handle it properly. For example, you want to treat all incoming submitted form data as UTF-8.</p>
<p><b>Solution:</b> You can't guarantee that browsers will respect the instructions you give them with regard to character encoding, but you can do a number of things that make well-behaved browsers generally follow the rules.</p>

<p>First, make sure your programs tell browsers that they are emitting UTF-8-encoded text. A Content-Type header with a charset is a good hint to a browser that submitted forms should be encoded using the character encoding the header specifies.</p>

<p>Second, include an accept-charset="utf-8" attribute in &lt;form/> elements that you output. Although it's not supported by all web browsers, it instructs the browser to encode the user-entered data in the form as UTF-8 before sending it to the server.</p>

<hr />

<h2><a name="utf_8">Manipulating UTF-8 Text</a></h2>
<p><b>Problem:</b> You want to work with UTF-8-encoded text in your programs. For example, you want to properly calculate the length of multibyte strings and make sure that all text is output as proper UTF-8-encoded characters.</p>
<p><b>Solution:</b> Use a combination of PHP functions for the variety of tasks that UTF-8 compliance demands.</p>

<p>If the mbstring extension is available, use its string functions for UTF-8-aware string manipulation:</p>

<pre class="prettyprint">
    <h3 class="nocode">Using mb_strlen()</h3>

//Set the encoding properly
mb_internal_encoding('UTF-8');

$name = 'Kurt Godel';
$name_len_bytes = strlen($name);
$name_len_chars = mb_strlen($name);

print "$name is $name_len_bytes bytes and $name_len_chars chars\n";

//prints:
//Kurt Godel is 11 bytes and 10 chars
    </pre>
    </div>
</div>








      
      
      
</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>