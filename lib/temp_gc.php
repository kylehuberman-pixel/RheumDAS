<?php
// Probabilistic garbage collection for transient upload directories.
// Same pattern as PHP's session GC: cheap on most requests, occasionally
// sweeps stale files. Call from any endpoint that writes to a temp dir.

function temp_gc($dir, $maxAgeSeconds = 3600, $probability = 0.01)
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
