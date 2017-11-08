<?php

/**
 * Public header
 */

$page_title = $page_title ?? 'Public Area';
$preview = $preview ?? false;

?>
<!doctype html>
<html lang="en">

<head>
    <title>MyCMS - 
	<?php 
	echo h($page_title);
	if ($preview) {
		echo " [PREVIEW]";
	}
	?>
	</title>
    <meta charset="utf-8">
    <link rel="stylesheet" media="all" 
        href="<?php echo urlForPath('stylesheet/public.css'); ?>"
    />
</head>

<body>
<header>
<h1>
<a href="<?php echo urlForPath('index.php'); ?>">
MyCMS
</a>
</h1>
</header>