<?php declare(strict_types = 1);

function rglob(string $path = '.', bool $subdirs = false) // . = path to this file
{
	echo '<ul>';
	foreach(glob($path.'/*', GLOB_ONLYDIR) as $dir)
	{
		$basename = basename($dir);
		if(!str_starts_with($basename, '@')) echo('<li><a href="'.$dir.'">'.$basename.'</a></li>'); // @ = system hidden folders on some NAS
		if($subdirs) rglob($dir, $subdirs); // subdirs
	}
	echo '</ul>';
}

if(filter_var($_GET['phpinfo'] ?? false, FILTER_VALIDATE_BOOLEAN)) phpinfo();

//HTML OUTPUT
header('Content-Type: text/html; charset=utf-8');

echo('<!DOCTYPE html>');
echo('<html>');
echo('<head>');
echo('<style type="text/css">');
echo('body {background-color: #ddd;}');
echo('a,a:link {color: #222; text-decoration: none;}');
echo('@media (prefers-color-scheme: dark) {body {background: #222;} a,a:link {color: #ddd;}}');
echo('</style>');
echo('<title>Dir List</title>');
echo('<meta name="robots" content="noindex,nofollow,noarchive" />');
echo('</head>');
echo('<body>');

$subdirs = filter_var($_GET['subdirs'] ?? false, FILTER_VALIDATE_BOOLEAN);

if($subdirs) echo('<a href="?subdirs=">Hide SubDirs</a>');
else echo('<a href="?subdirs=true">Show SubDirs</a>');

echo('<hr>');
rglob(subdirs: $subdirs);
echo('<hr>');

echo('<a href="?phpinfo=true">Show phpinfo</a>');

echo('</body>');
echo('</html>');
?>
