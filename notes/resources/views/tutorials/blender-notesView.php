<?php
require_once(assets("includes/header.php"));
?>
<!-- Begin page content -->
<div class="container">

<div class="page-header">
        <h1>Blender Notes</h1>
</div>

<p><kbd>F12</kbd> - Renders</p>
<p><kbd>Esc</kbd> - Exits Render Screen</p>
<p><kbd>F11</kbd> - View Previous Render</p>
<p><kbd><kbd>Ctrl</kbd> + <kbd>Q</kbd></kbd> - Exits Blender</p>
<p><kbd>Home</kbd> - Zooms Out</p>
<p><kbd><kbd>Ctrl</kbd> + <kbd><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span></kbd></kbd> - Toggle Between Maximize Area &amp; Tile Area.</p>

<h3>3D Views</h3>
<p><kbd>N</kbd> - Properties Panel</p>
<p><kbd>T</kbd> - Tool Shelf</p>

<p><kbd><kbd>Ctrl</kbd> + <kbd>MMB</kbd></kbd> - Zoom in and out</p>
<p><kbd><kbd>Shift</kbd> + <kbd>MMB</kbd></kbd> - Pan</p>
<p>Mouse wheel only - Zooms in and out.</p>

<p><kbd>Shift + Mouse Wheel</kbd> - Pans Up and Down</p>
<p><kbd>Ctrl + Mouse Wheel</kbd> - Pans Side to Side</p>
<p><kbd>Shift + Alt + Mouse Wheel</kbd> - Rotates Up and Down</p>
<p><kbd>Ctrl + Alt + Mouse Wheel</kbd> - Rotates Side to Side</p>

<hr />
<p><kbd>5</kbd> - Toggle Between Perspective and Orthographic Views</p>
<dd>
	<dt>Perspective</dt>
    <dd>Is good for checking to see how a scene will look in your 3D image or animation.</dd>
    
    <dt>Orthographic</dt>
    <dd>Is better when you are modeling an object.</dd>
</dd>
<hr />

<p><kbd>Ctrl + Alt + Q</kbd> - Toggling the Quad View</p>

<hr />
<h3>Move Lamp</h3>
<p>Hold down <kbd>RMB</kbd>, begin to drag the mouse. When the lamp begins to move, release. Move the lamp. <kbd>LMB</kbd> to release. <kbd>RMB</kbd> to cancel</p>

<h3>Move Lamp #2</h3>
<p>Cursor over the lamp, press <kbd>RMB</kbd> to select the lamp. Press and release (tap) the <kbd>G</kbd> Key, move the mouse. <kbd>LMB</kbd> to release.</p>

<hr />

<h3>Check lighting without rendering</h3>
<p><u>Viewport Shading Menu</u> (Solid to texture). On the header at the bottom of the 3D window there is a blank white circle. Click on the circle with <kbd>LMB</kbd>. <kbd>LMB</kbd> the word texture</p>

<hr />
<h3>Adding Color</h3>
<p>Select lamp. Move the mouse over the header of properties window. Select the button that has the glowing dot with 4 arrows coming out of it with <kbd>LMB</kbd>.</p>

<hr />
<h3>Multiple Lamps</h3>
<p><kbd>Shift + D</kbd> Copies Lamp</p>

<hr />
<h3>Moving an object in one place in global mode</h3>
<p>Select the camera with the <kbd>RMB</kbd>. Press the <kbd>G</kbd>(Grab) Key to grab it. Tap <kbd>Z</kbd>, <kbd>X</kbd> or <kbd>Y</kbd> and move your mouse. Press <kbd>RMB</kbd> to let go of the camera.</p>

<hr />
<h3>Fundamental Camera Moves</h3>
<p>There are 6 fundamental camera moves</p>
<ol>
	<li>in and out (dolly)</li>
    <li>side to side (truck)</li>
    <li>up and down (boom)</li>
    <li>tilting right and left (roll)</li>
    <li>up and down (tilt)</li>
    <li>swiveling right and left (pan)</li>
</ol>
<h3>More specifically, in Blender terms:</h3>
<dl>
	<dt>Dolly:</dt>
    <dd>Moves the camera towards or away from the scene along its local Z axis.</dd>
    
    <dt>Roll:</dt>
    <dd>This turns the camera on its local Z axis.</dd>
    
    <dt>Boom:</dt>
    <dd>This moves the the camera up and down on its local Y axis.</dd>
    
    <dt>Pan:</dt>
    <dd>This turns the camera on its local Y axis.</dd>
    
    <dt>Truck:</dt>
    <dd>This moves the camera sideways along its local X axis.</dd>
    
    <dt>Tilt:</dt>
    <dd>This turns the camera on its local X axis.</dd>
</dl>

<hr />

<h3>Rotating and Scaling an Object</h3>
<p><kbd>R</kbd> Key to Rotate</p>
<p><kbd>S</kbd> Key to Scale</p>
<p>Example: <kbd>G</kbd> <kbd>Z</kbd> <kbd>1</kbd> <kbd>Enter</kbd></p>
<p>Example: <kbd>G</kbd> <kbd>S</kbd> <kbd>X</kbd> <kbd>1</kbd> <kbd>Enter</kbd></p>

<hr />

<p><kbd>I</kbd> - (select <u>Location</u>) to insert keyframes.</p>
<p><kbd>Alt + A</kbd> - Preview Animation</p>
<p><kbd>Ctrl + F12</kbd> - To Render Animation</p>
<p><kbd>Ctrl + F11</kbd> - To View Animation</p>

<p><kbd>Tab</kbd> - Toggles Between Object Mode and Edit Mode</p>

<hr />
<h5>Edit View</h5>
<p><kbd>A</kbd> - Select/Deselect All</p>
<p><kbd>B</kbd> - Border Selection (Middle Mouse Button to Unselect Vertices)</p>
<p><kbd>C</kbd> - Circle Selection (Middle Mouse Button to Unselect Vertices)</p>
<p><kbd>Ctrl + LMB</kbd> - Lasso Selection</p>
<p><kbd>Ctrl + Shift + LMB</kbd> - Undo</p>

<p><kbd>Shift + A</kbd> - Create a New Object (mesh -> plane)</p>
<p><kbd>X</kbd> - To Delete Objects</p>
<p><kbd>Shift + RMB</kbd> - Select and Deselect Vertices</p>
<p><kbd>H</kbd> - Hides Vertices You Aren't Working On</p>
<p><kbd>Alt + H</kbd> - Shows Hidden Vertices</p>
<p><kbd>Shift + S</kbd> - Snap Menu</p>
<p><kbd>E</kbd> - Extrude</p>
<p><kbd>F</kbd> - Join Vertices (Fill)</p>
<p><kbd>W</kbd> - Subdivide</p>
<p><kbd>Ctrl + R</kbd> - Add Edge Loops</p>
<p><kbd>I</kbd> - To Intrude</p>
<p><kbd>Ctrl + b</kbd> - Bevel</p>
<p><kbd>K</kbd> - Knife</p>
<p><kbd>Alt + RMB</kbd> - Selecting Edge Loops</p>
<p><kbd>X</kbd> - To dissolve instead of delete</p>

<hr />
<h3>Tracking an Object with the Camera</h3>
<p class="text-muted">Works with lights as well.</p>

<ol>
	<li>Select the Camera with <kbd>RMB</kbd></li>
    <li>Press <kbd>Shift + RMB</kbd> to select the object</li>
    <li>Press <kbd>Ctrl + T</kbd> to get tracking menu. <b>Select Track To Constraint</b>.</li>
    <li>Press the numpad <kbd>0</kbd> Key to get the camera's view.</li>
    <li>Press <kbd>Alt + A</kbd> to preview the animation.</li>
</ol>
	
<hr />
<div class="clearfix"></div>
<img src="/resources/assets/images/keypad.png" alt="keypad" /><br />
<hr />
<img src="/resources/assets/images/xyz.png" alt="XYZ" />
<hr />
</div><!--end container-->

<?php require_once(assets("includes/footer.php")); ?>