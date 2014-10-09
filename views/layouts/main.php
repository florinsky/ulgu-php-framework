<html>
<body>
<h1>This is a test application</h1>
<h3>The content of the action</h3>
<?php echo $content; ?>
<h3>The system log</h3>
<pre>
<?php echo X\components\helpers\File::get('runtime/x.framework.log'); ?>
</pre>
</body>

