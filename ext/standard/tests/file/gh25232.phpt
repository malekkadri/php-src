--TEST--
GH-25232: Truncating a file invalidates the stat cache
--FILE--
<?php
$file = __DIR__ . '/gh25232.tmp';
file_put_contents($file, 'abcdefgh');

$handle = fopen($file, 'r+');
var_dump(filesize($file));
var_dump(ftruncate($handle, 3));
var_dump(filesize($file));
fclose($handle);

$object = new SplFileObject($file, 'r+');
var_dump(filesize($file));
var_dump($object->ftruncate(6));
var_dump(filesize($file));
?>
--CLEAN--
<?php
unlink(__DIR__ . '/gh25232.tmp');
?>
--EXPECT--
int(8)
bool(true)
int(3)
int(3)
bool(true)
int(6)
