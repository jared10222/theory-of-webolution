<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

      <div class="page-header">
        <h1>Directories</h1>
      </div>


<table class="table table-responsive table-bordered">
	<caption>Table of Contents</caption>
    <tr>
    	<td><a href="#getting_setting">Getting and Setting File Timestamps</a></td>
        <td><a href="#file_info">Getting File Information</a></td>
        <td><a href="#changing_permissions">Changing File Permissions or Ownership</a></td>
        <td><a href="#splitting">Splitting a Filename into Its Component Parts</a></td>
    </tr>
    <tr>
    	<td><a href="#deleting">Deleting a File</a></td>
        <td><a href="#copying">Copying or Moving a File</a></td>
        <td><a href="#processing">Processing All Files in a Directory</a></td>
        <td><a href="#matching_pattern">Getting a List of Filenames Matching a Pattern</a></td>
    </tr>
    <tr>
    	<td><a href="#processing_all">Processing All Files in a Directory Recursively</a></td>
        <td><a href="#new_directories">Making New Directories</a></td>
        <td><a href="#removing_directory">Removing a Directory and Its Contents</a></td>
        <td><a href="#program_one">Program: Web Server Directory Listing</a></td>
    </tr>
    <tr>
        <td><a href="#program_two">Site Search</a></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>    
</table>

<hr />
<p>PHP provides a few ways to look in a directory to see what files it holds. The Directory-
Iterator class provides a comprehensive object-oriented interface for directory traversal.
This example uses DirectoryIterator to print out the name of each file in a
directory:</p>

<pre class="prettyprint">
foreach(new DirectoryIterator('/usr/local/images') as $file){
    print $file->getPathname() . "\n";
}
    </pre>


<table class="table table-responsive table-bordered table-striped">
	<caption>File information functions</caption>
    <thead>
    	<tr>
        	<th>Function name</th>
            <th>What file information does the function provide?</th>
        </tr>
    </thead>
    <tr>
    	<td>file_exists()</td>
        <td>Does the file exist?</td>
    </tr>
    <tr>
    	<td>fileatime()</td>
        <td>Last access time</td>
    </tr>
    <tr>
    	<td>filectime()</td>
        <td>Last metadata change time</td>
    </tr>
    <tr>
    	<td>filegroup()</td>
        <td>Group (numeric)</td>
    </tr>
    <tr>
    	<td>fileinode()</td>
        <td>Inode number</td>
    </tr>
    <tr>
    	<td>filemtime()</td>
        <td>Last change time of contents</td>
    </tr>
    <tr>
    	<td>fileowner()</td>
        <td>Owner (numeric)</td>
    </tr>
    <tr>
    	<td>fileperms()</td>
        <td>Permissions (decimal, numeric)</td>
    </tr>
    <tr>
    	<td>filesize()</td>
        <td>Size</td>
    </tr>
    <tr>
    	<td>filetype()</td>
        <td>Type (fifo, char, dir, block, link, file, unknown)</td>
    </tr>
    <tr>
    	<td>is_dir()</td>
        <td>Is it a directory?</td>
    </tr>
    <tr>
    	<td>is_executable()</td>
        <td>Is it executable?</td>
    </tr>
    <tr>
    	<td>is_file()</td>
        <td>Is it a regular file?</td>
    </tr>
    <tr>
    	<td>is_link()</td>
        <td>Is it a symbolic link?</td>
    </tr>
    <tr>
    	<td>is_readable()</td>
        <td>It it readable?</td>
    </tr>
    <tr>
    	<td>is_writable()</td>
        <td>Is it writable?</td>
    </tr>
</table>

<table class="table table-responsive table-bordered table-striped">
	<caption>File permission values</caption>
    <thead>
    	<tr>
        	<th>Value</th>
            <th>Permission meaning</th>
            <th>Special setting meaning</th>
        </tr>
    </thead>
    <tr>
    	<td>4</td>
        <td>Read</td>
        <td>setuid</td>
    </tr>
    <tr>
    	<td>2</td>
        <td>Write</td>
        <td>setgid</td>
    </tr>
    <tr>
    	<td>1</td>
        <td>Execute</td>
        <td>Sticky</td>
    </tr>
</table>

<hr />

<h2><a name="getting_setting">Getting and Setting File Timestamps</a></h2>
<p><b>Problem:</b> You want to know when a file was last accessed or changed, or you want to update a file's access or change time; for example, you want each page on your website to display when it was last modified.</p>
<p><b>Solution:</b> The fileatime(), filemtime(), and filectime() functions return the time of last access, modification, and metadata change of a file as shown:</p>

<p>Update a file's modification time with touch().</p>

<p>Documentation on <a href="http://php.net/fileatime" target="_blank">fileatime()</a></p>
<p>Documentation on <a href="http://php.net/filemtime" target="_blank">filemtime()</a></p>
<p>Documentation on <a href="http://php.net/filectime" target="_blank">filectime()</a></p>

<pre class="prettyprint">
$last_access = fileatime('larry.php');
$last_modification = filemtime('moe.php');
$last_change = filectime('curly.php');

<hr />

touch('shemp.php'); // set modification time to now
touch('joe.php', $timestamp); //set modification time to $timestamp

<hr />
//This code prints the time a page on your website was last 
//updated:

print "Last Modified: " .strftime('%c',filemtime($_SERVER['SCRIPT_FILENAME']));
    </pre>


<hr />

<h2><a name="file_info">Getting File Information</a></h2>
<p><b>Problem:</b> You want to read a file's metadata--for example, permissions and ownership.</p>
<p><b>Solution:</b> Use stat(), which returns an array of information about a file:</p>

<p>Documentation on <a href="http://php.net/stat" target="_blank">stat()</a></p>
<p>Documentation on <a href="http://php.net/lstat" target="_blank">lstat()</a></p>
<p>Documentation on <a href="http://php.net/fstat" target="_blank">fstat()</a></p>
<p>Documentation on <a href="http://php.net/clearstatcache" target="_blank">clearstatcache()</a></p>

<table class="table table-responsive table-bordered table-striped">
	<caption>Information returned by stat()</caption>
    <thead>
    	<tr>
        	<th>Numeric index</th>
            <th>String Index</th>
            <th>Value</th>
        </tr>
    </thead>
    <tr>
    	<td>0</td>
        <td>dev</td>
        <td>Device</td>
    </tr>
    <tr>
    	<td>1</td>
        <td>ino</td>
        <td>Inode</td>
    </tr>
    <tr>
    	<td>2</td>
        <td>mode</td>
        <td>Permissions</td>
    </tr>
    <tr>
    	<td>3</td>
        <td>nlink</td>
        <td>Link count</td>
    </tr>
    <tr>
    	<td>4</td>
        <td>uid</td>
        <td>Owner's user ID</td>
    </tr>
    <tr>
    	<td>5</td>
    	<td>gid</td>
        <td>Group's group ID</td>
    </tr>
    <tr>
    	<td>6</td>
        <td>rdev</td>
        <td>Device type for inode devices (--1 on Windows)</td>
    </tr>
    <tr>
    	<td>7</td>
        <td>size</td>
        <td>Size (in bytes)</td>
    </tr>
    <tr>
    	<td>8</td>
        <td>atime</td>
        <td>Last access time (epoch timestamp)</td>
    </tr>
    <tr>
    	<td>9</td>
        <td>mtime</td>
        <td>Last change time of contents (epoch timestamp)</td>
    </tr>
    <tr>
    	<td>10</td>
        <td>ctime</td>
        <td>Last change time of contents or metadata (epoch timestamp)</td>
    </tr>
    <tr>
    	<td>11</td>
        <td>blksize</td>
        <td>Block size for I/O (--1 on Windows)</td>
    </tr>
    <tr>
    	<td>12</td>
        <td>blocks</td>
        <td>Number of blocks allocated to this file</td>
    </tr>
</table>

<pre class="prettyprint">
$info = stat('harpo.php');

<hr />
//The mode element of the returned array contains the permissions
//expressed as a base 10 integer. This is confusing because permissions
//are usually either expressed symbolically (e.g., ls's -rw-r--r-- output)
//or as an octal integer(e.g., 0644). To convert the permissions to the
//more understandable octal format, use base_convert():

$file_info = stat('/tmp/session.txt');
$permissions = base_convert($file_info['mode'],10,8);

//Here, $permissions is a six-digit octal number. For example, if
//ls displays the following about /tmp/session.txt:

-rw-rw-r-- 1 sklar sklar 12 Oct 23 17:55 /tmp/session.txt

//Then $file_info['mode'] is 33204 and $permissions is 100664.
//The last three digits (664) are the user (read and write), 
//group(read and write), and other (read) permissions for the file.
    </pre>


<hr />

<h2><a name="changing_permissions">Changing File Permissions or Ownership</a></h2>
<p><b>Problem:</b> You want to change a file's permissions or ownership; for example, you want to prevent other users from being able to look at a file of sensitive data.</p>
<p><b>Solution:</b> Use chmod() to change the permissions of a file:</p>
<p>Use chown() to change a file's owner and chgrp() to change a file's group:</p>

<p>Documentation on <a href="http://php.net/chmod" target="_blank">chmod()</a></p>
<p>Documentation on <a href="http://php.net/chown" target="_blank">chown()</a></p>
<p>Documentation on <a href="http://php.net/chgrp" target="_blank">chgrp()</a></p>

<pre class="prettyprint">
chmod('/home/user/secrets.txt', 0400);
<hr />
chown('/tmp/myfile.txt', 'sklar'); //specify user by name
chgrp('/home/sklar/schedule.txt', 'soccer'); //specify group by name

chown('/tmp/myfile.txt', 5001); //specify user by uid
chgrp('/home/sklar/schedule.txt', 102); //specify group by gid
    </pre>


<hr />

<h2><a name="splitting">Splitting a Filename into Its Component Parts</a></h2>
<p><b>Problem:</b> You want to find a file's path and filename; for example, you want to create file in the same directory as an existing file.</p>
<p><b>Solution:</b> Use basename() to get the filename and dirname() to get the path:</p>
<p>Use pathinfo() to get the directory name, base name, and extension in an associative array:</p>

<p>Documentation on <a href="http://php.net/basename" target="_blank">basename()</a></p>
<p>Documentation on <a href="http://php.net/dirname" target="_blank">dirname()</a></p>
<p>Documentation on <a href="http://php.net/pathinfo" target="_blank">pathinfo()</a></p>
<p>Documentation on <a href="http://php.net/language.constants.predefined" target="_blank">__FILE__</a></p>

<pre class="prettyprint">
$full_name = '/usr/local/php/php.ini';
$base = basename($full_name); //$base is "php.ini"
$dir = dirname($full_name); //$dir is "/usr/local/php"

<hr />
$info = pathinfo('/usr/local/php/php.ini');
//$info['dirname'] is "/usr/local/php"
//$info['basename'] is "php.ini"
//$info['extension'] is "ini"
    </pre>


<hr />

<h2><a name="deleting">Deleting a File</a></h2>
<p><b>Problem:</b> You want to delete a file.</p>
<p><b>Solution:</b> Use unlink():</p>

<p>Documentation on <a href="http://php.net/unlink" target="_blank">unlink()</a></p>

<pre class="prettyprint">
$file = '/tmp/junk.txt';
unlink($file) or die("can't delete $file: $php_errormsg");
    </pre>


<hr />

<h2><a name="copying">Copying or Moving a File</a></h2>
<p><b>Problem:</b> You want to copy or move a file.</p>
<p><b>Solution:</b> Use copy() to copy a file:</p>
<p>Use rename() to move a file:</p>

<p>Documentation on <a href="http://php.net/copy" target="_blank">copy()</a></p>
<p>Documentation on <a href="http://php.net/rename" target="_blank">rename()</a></p>

<pre class="prettyprint">
$old = '/tmp/yesterday.txt';
$new = '/tmp/today.txt';
copy($old,$new) or die("couldn't copy $old to $new: $php_errormsg");

<hr />

$old = '/tmp/today.txt';
$new = '/tmp/tomorrow.txt';
rename($old,$new) or die("couldn't move $old to $new: $php_errormsg");
    </pre>


<hr />

<h2><a name="processing">Processing All Files in a Directory</a></h2>
<p><b>Problem:</b> You want to iterate over all files in a directory. For example, you want to create a &lt;select/> box in a form that lists all the files in a directory.</p>
<p><b>Solution:</b> Use a DirectoryIterator to get each file in the directory:</p>

<p>A DirectoryIterator yields an object for all directory elements including . (current directory) and ..(parent directory). Fortunately, that object has some methods that help us identify what it is. The isDot() method returns true if it's either . or ... This example uses isDot() to prevent those two entries from showing up in the output:</p>

<p>Documentation on <a href="http://php.net/DirectoryIterator" target="_blank">DirectoryIterator</a></p>

<table class="table table-responsive table-bordered table-striped">
	<caption>DirectoryIterator object information methods</caption>
    <thead>
    	<tr>
        	<th>Method name</th>
            <th>Return value</th>
            <th>Example</th>
        </tr>
    </thead>
    <tr>
    	<td>isDir()</td>
        <td>Is the element a directory?</td>
        <td>false</td>
    </tr>
    <tr>
    	<td>isDot()</td>
        <td>Is the element either . or ..?</td>
        <td>false</td>
    </tr>
    <tr>
    	<td>isFile()</td>
        <td>Is the element a regular file?</td>
        <td>true</td>
    </tr>
    <tr>
    	<td>isLink()</td>
        <td>Is the element a link?</td>
        <td>false</td>
    </tr>
    <tr>
    	<td>isReadable()</td>
        <td>Is the element readable?</td>
        <td>true</td>
    </tr>
    <tr>
    	<td>isWritable()</td>
        <td>Is the element writable?</td>
        <td>true</td>
    </tr>
    <tr>
    	<td>isExecutable()</td>
        <td>Is the element executable?</td>
        <td>false</td>
    </tr>
    <tr>
    	<td>getATime()</td>
        <td>The last access time of the element</td>
        <td>1144509622</td>
    </tr>
    <tr>
    	<td>getCTime()</td>
        <td>The creation time of the element</td>
        <td>1144509600</td>
    </tr>
    <tr>
    	<td>getMTime()</td>
        <td>The last modification time of the element</td>
        <td>1144509620</td>
    </tr>
    <tr>
    	<td>getFilename()</td>
        <td>The filename (without leading path) of the element</td>
        <td>eggplant.png</td>
    </tr>
    <tr>
    	<td>getPathname()</td>
        <td>The full pathname of the element</td>
        <td>/usr/local/images/eggplant.png</td>
    </tr>
    <tr>
    	<td>getPath()</td>
        <td>The leading path of the element</td>
        <td>/usr/local/images</td>
    </tr>
    <tr>
    	<td>getGroup()</td>
        <td>The group ID of the element</td>
        <td>500</td>
    </tr>
    <tr>
    	<td>getOwner()</td>
        <td>The owner ID of the element</td>
        <td>1000</td>
    </tr>
    <tr>
    	<td>getPerms()</td>
        <td>The permissions of the element, as an octal value</td>
        <td>16895</td>
    </tr>
    <tr>
    	<td>getSize()</td>
        <td>The size of the element</td>
        <td>328742</td>
    </tr>
    <tr>
    	<td>getType()</td>
        <td>The type of the element(dir,file,link,etc.)</td>
        <td>file</td>
    </tr>
    <tr>
    	<td>getInode()</td>
        <td>The inode number of the element</td>
        <td>28720</td>
    </tr>
</table>

<pre class="prettyprint">
echo "&lt;select name='file'>\n";
foreach(new DirectoryIterator('/usr/local/images') as $file){
    echo '&lt;option>' . htmlentities($file) . "&lt;/option>\n";
}
echo '&lt;/select>';

<hr />

echo "&lt;select name='file'>\n";
foreach(new DirectoryIterator('/usr/local/images') as $file){
    if(! $file->isDot()){
        echo '&lt;option>' . htmlentities($file) . "&lt;/option>\n";
    }
}
echo '&lt;/select>';
    </pre>


<hr />

<h2><a name="matching_pattern">Getting a List of Filenames Matching a Pattern</a></h2>
<p><b>Problem:</b> You want to find all filenames that match a pattern.</p>
<p><b>Solution:</b> Use a FilterIterator subclass with DirectoryIterator. The FilterIterator subclass needs its own accept() method that decides whether of not a particular value is acceptable.</p>

<p>Documentation on <a href="http://php.net/class.filteriterator" target="_blank">FilterIterator</a></p>
<p>Documentation on <a href="http://php.net/glob" target="_blank">glob()</a></p>
<p>Information about <a href="http://www.gnu.org/software/bash/manual/bashref.html#SEC35" target="_blank">shell pattern matching</a></p>

<pre class="prettyprint">
//To only accept filenames that end with common extensions for images:

class ImageFilter extends FilterIterator {
    public function accept(){
        retur preg_match('@\.(gif|jpe?g|png)$@i', $this->current());
    }
}
foreach(new ImageFilter(new DirectoryIterator('/user/local/images')) as $img)){
    print "&lt;img src='".htmlentities($img)."'/>\n";
}
    </pre>


<hr />

<h2><a name="processing_all_recursivley">Processing All Files in a Directory Recursively</a></h2>
<p><b>Problem:</b> You want to do something to all the files in a directory and in any subdirectories. For example, you want to see how much disk space is consumed by all the files under a directory.</p>
<p><b>Solution:</b> Use a RecursiveDirectoryIterator and a RecursiveIteratorIterator. The RecursiveDirectoryIterator extends the DirectoryIterator with a getChildren() method that provides access to the elements in a subdirectory. The RecursiveIteratorIt
erator flattens the hierarchy that the RecursiveDirectoryIterator returns into one
list. This example counts the total size of files under a directory:</p>

<p>Documentation on <a href="http://php.net/RecursiveDirectoryIterator" target="_blank">RecursiveDirectoryIterator</a></p>
<p>Documentation on <a href="http://php.net/RecursiveIteratorIterator" target="_blank">RecursiveIteratorIterator</a></p>

<pre class="prettyprint">
$dir = new RecursiveDirectoryIterator('/usr/local');
$totalSize = 0;
foreach(new RecursiveIteratorIterator($dir) as $file){
    $totalSize += $file->getSize();
}
print "The total size is $totalSize.\n";
    </pre>

<hr />

<h2><a name="new_directories">Making New Directories</a></h2>
<p><b>Problem:</b> You want to create a directory:</p>
<p><b>Solution:</b> Use mkdir():</p>

<p>Documentation on <a href="http://php.net/mkdir" target="_blank">mkdir()</a></p>

<pre class="prettyprint">
mkdir('/tmp/apples',0777) or die($php_errormsg);
    </pre>


<hr />

<h2><a name="removing_directory">Removing a Directory and Its Contents</a></h2>
<p><b>Problem:</b> You want to remove a directory and all of its contents, including subdirectories and their contents.</p>
<p><b>Solution:</b> Use RecursiveDirectoryIterator and RecursiveIteratorIterator, specifying that children (files and subdirectories) should be listed before their parents:</p>

<p>Documentation on <a href="http://php.net/rmdir" target="_blank">rmdir()</a></p>

<pre class="prettyprint">
function obliterate_directory($dir){
    $iter = new RecursiveDirectoryIterator($dir);
    forech(new RecursiveIteratorIterator($iter,
        RecursiveIteratorIterator::CHILD_FIRST) as $f){
     if($f->isDir()){
         rmdir($f->getPathname());
     }else{
         unlink($f->getPathname());
     }
    }
    rmdir($dir);
}
obliterate_directory('/tmp/junk');
    </pre>


<hr />

<h2><a name="program_one">Program: Web Server Directory Listing</a></h2>

<h2><a name="program_two">Site Search</a></h2>




      
      
      
</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>