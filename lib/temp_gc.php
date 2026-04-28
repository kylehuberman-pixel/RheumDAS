<?php
// Garbage collection for transient upload directories.
// Cheap (~1ms scandir on a small dir), so by default runs on every call.
// Pass a probability < 1.0 to sample if the dir ever grows large enough
// that a per-request scan becomes noticeable.

function temp_gc($dir, $maxAgeSeconds = 3600, $probability = 1.0)
{
    if ($probability < 1.0 && mt_rand() / mt_getrandmax() > $probability) {
        return;
    }
    if (!is_dir($dir)) {
        return;
    }

    $cutoff = time() - $maxAgeSeconds;

    foreach (scandir($dir) as $item) {
        if ($item === '.' || $item === '..' || $item === '.gitkeep') {
            continue;
        }
        $path = rtrim($dir, '/\\') . DIRECTORY_SEPARATOR . $item;
        if (is_file($path) && filemtime($path) < $cutoff) {
            @unlink($path);
        }
    }
}
