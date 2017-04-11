<?php

$router->add('/', 'indexController@home');
$router->add('/home', 'indexController@home');
$router->add('/tutorials', 'indexController@tutorials');
$router->add('/design', 'indexController@design');
$router->add('/links', 'indexController@links');
$router->add('/feed', 'indexController@feed');

$router->add('/html', 'languagesController@html');
$router->add('/css', 'languagesController@css');
$router->add('/javascript', 'languagesController@javascript');
$router->add('/jquery', 'languagesController@jquery');
$router->add('/mysql', 'languagesController@mysql');
$router->add('/php', 'languagesController@php');
$router->add('/cplusplus', 'languagesController@cplusplus');
$router->add('/xml', 'languagesController@xml');
$router->add('/java', 'languagesController@java');
$router->add('/csharp', 'languagesController@csharp');



/**
 * HTML NOTES ROUTES
 */
$router->add('/html/html5-missing-manual/introducing-html5', 'languagesController@html');
$router->add('/html/html5-missing-manual/structuring-pages-with-semantic-elements', 'languagesController@html');
$router->add('/html/html5-missing-manual/writing-more-meaningful-markup', 'languagesController@html');
$router->add('/html/html5-missing-manual/building-better-web-forms', 'languagesController@html');
$router->add('/html/html5-missing-manual/audio-and-video', 'languagesController@html');
$router->add('/html/html5-missing-manual/fancy-fonts-and-effects-with-css3', 'languagesController@html');
$router->add('/html/html5-missing-manual/responsive-web-design-with-css3', 'languagesController@html');
$router->add('/html/html5-missing-manual/basic-drawing-with-canvas', 'languagesController@html');
$router->add('/html/html5-missing-manual/advanced-canvas', 'languagesController@html');
$router->add('/html/html5-missing-manual/storing-your-data', 'languagesController@html');
$router->add('/html/html5-missing-manual/running-offline', 'languagesController@html');
$router->add('/html/html5-missing-manual/communicating-with-the-web-server', 'languagesController@html');
$router->add('/html/html5-missing-manual/geolocation', 'languagesController@html');
$router->add('/html/html5-missing-manual/essential-css', 'languagesController@html');
$router->add('/html/html5-missing-manual/javascript', 'languagesController@html');




/**
 * CSS NOTES ROUTES
 */
$router->add('/css/css-missing-manual/html-and-css', 'languagesController@css');
$router->add('/css/css-missing-manual/creating-styles-and-style-sheets', 'languagesController@css');
$router->add('/css/css-missing-manual/selectors', 'languagesController@css');
$router->add('/css/css-missing-manual/saving-time-with-style-inheritance', 'languagesController@css');
$router->add('/css/css-missing-manual/managing-multiple-styles', 'languagesController@css');
$router->add('/css/css-missing-manual/formatting-text', 'languagesController@css');
$router->add('/css/css-missing-manual/margins-padding-borders', 'languagesController@css');
$router->add('/css/css-missing-manual/adding-graphics', 'languagesController@css');
$router->add('/css/css-missing-manual/sprucing-up', 'languagesController@css');
$router->add('/css/css-missing-manual/transforms-transitions-animations', 'languagesController@css');
$router->add('/css/css-missing-manual/formatting-tables-and-forms', 'languagesController@css');
$router->add('/css/css-missing-manual/css-layout', 'languagesController@css');
$router->add('/css/css-missing-manual/positioning-elements', 'languagesController@css');
$router->add('/css/css-missing-manual/responsive-web-design', 'languagesController@css');
$router->add('/css/css-missing-manual/css-grid-system', 'languagesController@css');
$router->add('/css/css-missing-manual/flexbox', 'languagesController@css');
$router->add('/css/css-missing-manual/improving-habits', 'languagesController@css');
$router->add('/css/css-missing-manual/sass', 'languagesController@css');
$router->add('/css/css-missing-manual/css-property-reference', 'languagesController@css');
$router->add('/css/css-missing-manual/css-resources', 'languagesController@css');
$router->add('/css/css-missing-manual/float-based-layouts', 'languagesController@css');




/**
 * JAVASCRIPT NOTES ROUTES
 */
$router->add('/javascript/pro-js-for-web-developers/what-is-javascript', 'languagesController@javascript');
$router->add('/javascript/pro-js-for-web-developers/javascript-in-html', 'languagesController@javascript');
$router->add('/javascript/pro-js-for-web-developers/language-basics', 'languagesController@javascript');
$router->add('/javascript/pro-js-for-web-developers/variables-scope-memory', 'languagesController@javascript');
$router->add('/javascript/pro-js-for-web-developers/reference-types', 'languagesController@javascript');
$router->add('/javascript/pro-js-for-web-developers/object-oriented-programming', 'languagesController@javascript');
$router->add('/javascript/pro-js-for-web-developers/function-expressions', 'languagesController@javascript');
$router->add('/javascript/pro-js-for-web-developers/browser-object-model', 'languagesController@javascript');
$router->add('/javascript/pro-js-for-web-developers/client-detection', 'languagesController@javascript');
$router->add('/javascript/pro-js-for-web-developers/document-object-model', 'languagesController@javascript');
$router->add('/javascript/pro-js-for-web-developers/dom-extensions', 'languagesController@javascript');
$router->add('/javascript/pro-js-for-web-developers/dom-levels-2-3', 'languagesController@javascript');
$router->add('/javascript/pro-js-for-web-developers/events', 'languagesController@javascript');
$router->add('/javascript/pro-js-for-web-developers/scripting-forms', 'languagesController@javascript');
$router->add('/javascript/pro-js-for-web-developers/graphics-with-canvas', 'languagesController@javascript');
$router->add('/javascript/pro-js-for-web-developers/html5-scripting', 'languagesController@javascript');
$router->add('/javascript/pro-js-for-web-developers/error-handling', 'languagesController@javascript');
$router->add('/javascript/pro-js-for-web-developers/xml', 'languagesController@javascript');
$router->add('/javascript/pro-js-for-web-developers/ecmascript-xml', 'languagesController@javascript');
$router->add('/javascript/pro-js-for-web-developers/json', 'languagesController@javascript');
$router->add('/javascript/pro-js-for-web-developers/ajax-comet', 'languagesController@javascript');
$router->add('/javascript/pro-js-for-web-developers/advanced-techniques', 'languagesController@javascript');
$router->add('/javascript/pro-js-for-web-developers/offline-applications', 'languagesController@javascript');
$router->add('/javascript/pro-js-for-web-developers/best-practices', 'languagesController@javascript');
$router->add('/javascript/pro-js-for-web-developers/emerging-apis', 'languagesController@javascript');
$router->add('/javascript/pro-js-for-web-developers/ecmascript-harmony', 'languagesController@javascript');
$router->add('/javascript/pro-js-for-web-developers/strict-mode', 'languagesController@javascript');
$router->add('/javascript/pro-js-for-web-developers/js-libraries', 'languagesController@javascript');
$router->add('/javascript/pro-js-for-web-developers/js-tools', 'languagesController@javascript');



/*
 / PHP NOTES ROUTES
*/
$router->add('/php/advanced-php-techniques', 'languagesController@php');
$router->add('/php/developing-web-apps', 'languagesController@php');
$router->add('/php/advanced-db-concepts', 'languagesController@php');
$router->add('/php/basic-oop', 'languagesController@php');
$router->add('/php/advanced-oop', 'languagesController@php');
$router->add('/php/more-advanced-oop', 'languagesController@php');
$router->add('/php/design-patterns', 'languagesController@php');
$router->add('/php/using-existing-classes', 'languagesController@php');
$router->add('/php/cms-with-oop', 'languagesController@php');
$router->add('/php/networking-with-php', 'languagesController@php');
$router->add('/php/php-and-the-server', 'languagesController@php');
$router->add('/php/php-command-line-interface', 'languagesController@php');
$router->add('/php/xml-and-php', 'languagesController@php');
$router->add('/php/debugging-testing-and-performance', 'languagesController@php');

$router->add('/php/php-cookbook/strings', 'languagesController@php');
$router->add('/php/php-cookbook/numbers', 'languagesController@php');
$router->add('/php/php-cookbook/dates-and-times', 'languagesController@php');
$router->add('/php/php-cookbook/arrays', 'languagesController@php');
$router->add('/php/php-cookbook/variables', 'languagesController@php');
$router->add('/php/php-cookbook/functions', 'languagesController@php');
$router->add('/php/php-cookbook/classes-and-objects', 'languagesController@php');
$router->add('/php/php-cookbook/web-fundamentals', 'languagesController@php');
$router->add('/php/php-cookbook/forms', 'languagesController@php');
$router->add('/php/php-cookbook/database-access', 'languagesController@php');
$router->add('/php/php-cookbook/sessions-and-data-persistence', 'languagesController@php');
$router->add('/php/php-cookbook/xml', 'languagesController@php');
$router->add('/php/php-cookbook/web-automation', 'languagesController@php');
$router->add('/php/php-cookbook/consuming-restful-apis', 'languagesController@php');
$router->add('/php/php-cookbook/serving-restful-apis', 'languagesController@php');
$router->add('/php/php-cookbook/internet-services', 'languagesController@php');
$router->add('/php/php-cookbook/graphics', 'languagesController@php');
$router->add('/php/php-cookbook/security-and-encryption', 'languagesController@php');
$router->add('/php/php-cookbook/internationalization', 'languagesController@php');
$router->add('/php/php-cookbook/error-handling', 'languagesController@php');
$router->add('/php/php-cookbook/software-engineering', 'languagesController@php');
$router->add('/php/php-cookbook/performance-tuning', 'languagesController@php');
$router->add('/php/php-cookbook/regular-expressions', 'languagesController@php');
$router->add('/php/php-cookbook/files', 'languagesController@php');
$router->add('/php/php-cookbook/directories', 'languagesController@php');
$router->add('/php/php-cookbook/command-line-php', 'languagesController@php');
$router->add('/php/php-cookbook/packages', 'languagesController@php');




/**
 / C# NOTES
*/
$router->add('/csharp/yellow-book/computers-programs', 'languagesController@csharp');
$router->add('/csharp/yellow-book/simple-data-processing', 'languagesController@csharp');
$router->add('/csharp/yellow-book/creating-programs', 'languagesController@csharp');
$router->add('/csharp/yellow-book/creating-solutions', 'languagesController@csharp');
$router->add('/csharp/yellow-book/advanced-programming', 'languagesController@csharp');


$router->add('/csharp/nutshell/introducing-csharp', 'languagesController@csharp');
$router->add('/csharp/nutshell/language-basics', 'languagesController@csharp');
$router->add('/csharp/nutshell/creating-types', 'languagesController@csharp');
$router->add('/csharp/nutshell/advanced', 'languagesController@csharp');
$router->add('/csharp/nutshell/framework-overview', 'languagesController@csharp');
$router->add('/csharp/nutshell/framework-fundamentals', 'languagesController@csharp');
$router->add('/csharp/nutshell/collections', 'languagesController@csharp');
$router->add('/csharp/nutshell/linq-queries', 'languagesController@csharp');
$router->add('/csharp/nutshell/linq-operators', 'languagesController@csharp');
$router->add('/csharp/nutshell/linq-to-xml', 'languagesController@csharp');
$router->add('/csharp/nutshell/other-xml', 'languagesController@csharp');
$router->add('/csharp/nutshell/garbage-collection', 'languagesController@csharp');
$router->add('/csharp/nutshell/diagnostics-code-contracts', 'languagesController@csharp');
$router->add('/csharp/nutshell/concurrency-asynchrony', 'languagesController@csharp');
$router->add('/csharp/nutshell/streams-io', 'languagesController@csharp');
$router->add('/csharp/nutshell/networking', 'languagesController@csharp');
$router->add('/csharp/nutshell/serialization', 'languagesController@csharp');
$router->add('/csharp/nutshell/assemblies', 'languagesController@csharp');
$router->add('/csharp/nutshell/reflection-metadata', 'languagesController@csharp');
$router->add('/csharp/nutshell/dynamic-programming', 'languagesController@csharp');
$router->add('/csharp/nutshell/security', 'languagesController@csharp');
$router->add('/csharp/nutshell/advanced-threading', 'languagesController@csharp');
$router->add('/csharp/nutshell/parallel-programming', 'languagesController@csharp');
$router->add('/csharp/nutshell/application-domains', 'languagesController@csharp');
$router->add('/csharp/nutshell/interoperability', 'languagesController@csharp');
$router->add('/csharp/nutshell/regex', 'languagesController@csharp');
$router->add('/csharp/nutshell/roslyn-compiler', 'languagesController@csharp');


$router->add('/csharp/players-guide/programming-language', 'languagesController@csharp');
$router->add('/csharp/players-guide/installing-visual-studio', 'languagesController@csharp');
$router->add('/csharp/players-guide/hello-world', 'languagesController@csharp');
$router->add('/csharp/players-guide/comments', 'languagesController@csharp');
$router->add('/csharp/players-guide/variables', 'languagesController@csharp');
$router->add('/csharp/players-guide/type-system', 'languagesController@csharp');
$router->add('/csharp/players-guide/basic-math', 'languagesController@csharp');
$router->add('/csharp/players-guide/user-input', 'languagesController@csharp');
$router->add('/csharp/players-guide/more-math', 'languagesController@csharp');
$router->add('/csharp/players-guide/decision-making', 'languagesController@csharp');
$router->add('/csharp/players-guide/switch-statements', 'languagesController@csharp');
$router->add('/csharp/players-guide/looping', 'languagesController@csharp');
$router->add('/csharp/players-guide/arrays', 'languagesController@csharp');
$router->add('/csharp/players-guide/enumerations', 'languagesController@csharp');
$router->add('/csharp/players-guide/methods', 'languagesController@csharp');
$router->add('/csharp/players-guide/reference-types', 'languagesController@csharp');
$router->add('/csharp/players-guide/classes-objects', 'languagesController@csharp');
$router->add('/csharp/players-guide/making-classes', 'languagesController@csharp');
$router->add('/csharp/players-guide/properties', 'languagesController@csharp');
$router->add('/csharp/players-guide/structs', 'languagesController@csharp');
$router->add('/csharp/players-guide/inheritance', 'languagesController@csharp');
$router->add('/csharp/players-guide/polymorphism', 'languagesController@csharp');
$router->add('/csharp/players-guide/interfaces', 'languagesController@csharp');
$router->add('/csharp/players-guide/using-generics', 'languagesController@csharp');
$router->add('/csharp/players-guide/making-generic-types', 'languagesController@csharp');
$router->add('/csharp/players-guide/namespaces', 'languagesController@csharp');
$router->add('/csharp/players-guide/methods-revisited', 'languagesController@csharp');
$router->add('/csharp/players-guide/reading-writing-files', 'languagesController@csharp');
$router->add('/csharp/players-guide/error-handling', 'languagesController@csharp');
$router->add('/csharp/players-guide/delegates', 'languagesController@csharp');
$router->add('/csharp/players-guide/events', 'languagesController@csharp');
$router->add('/csharp/players-guide/operator-overloading', 'languagesController@csharp');
$router->add('/csharp/players-guide/indexers', 'languagesController@csharp');
$router->add('/csharp/players-guide/extension-methods', 'languagesController@csharp');
$router->add('/csharp/players-guide/lambda-expressions', 'languagesController@csharp');
$router->add('/csharp/players-guide/query-expressions', 'languagesController@csharp');
$router->add('/csharp/players-guide/threads', 'languagesController@csharp');
$router->add('/csharp/players-guide/asynchronous-programming', 'languagesController@csharp');
$router->add('/csharp/players-guide/other-features', 'languagesController@csharp');
$router->add('/csharp/players-guide/csharp-dotnet', 'languagesController@csharp');
$router->add('/csharp/players-guide/visual-studio', 'languagesController@csharp');
$router->add('/csharp/players-guide/referencing-other-projects', 'languagesController@csharp');
$router->add('/csharp/players-guide/handling-common-compiler-errors', 'languagesController@csharp');
$router->add('/csharp/players-guide/debugging-code', 'languagesController@csharp');
$router->add('/csharp/players-guide/organized-project-files', 'languagesController@csharp');
$router->add('/csharp/players-guide/try-it-out', 'languagesController@csharp');
$router->add('/csharp/players-guide/whats-next', 'languagesController@csharp');



/*
 / Tutorials Routes
*/
$router->add('/tutorials/autoloading-classes-using-namespaces', 'indexController@tutorials');
$router->add('/tutorials/5-minute-png-image-optimization', 'indexController@tutorials');
$router->add('/tutorials/roll-your-own-pdo-php-class', 'indexController@tutorials');
$router->add('/tutorials/reroute-all-request-to-index', 'indexController@tutorials');
$router->add('/tutorials/fix-project-links-wamp', 'indexController@tutorials');
$router->add('/tutorials/udemy-writing-class', 'indexController@tutorials');
$router->add('/tutorials/udemy-focus', 'indexController@tutorials');
$router->add('/tutorials/blender-notes', 'indexController@tutorials');




/**
 * Design Routes
 */
$router->add('/design/logo-design-workbook/notes', 'indexController@design');
$router->add('/design/foundations-of-logo-design/notes', 'indexController@design');
$router->add('/design/principles-of-beautiful-web-design/notes', 'indexController@design');
$router->add('/design/identity-design/notes', 'indexController@design');
$router->add('/design/responsive-web-design-intro/notes', 'indexController@design');
$router->add('/design/responsive-web-design-intermediate/notes', 'indexController@design');
$router->add('/design/responsive-web-design-advanced/notes', 'indexController@design');

?>