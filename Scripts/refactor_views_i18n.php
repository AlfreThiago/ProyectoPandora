<?php
// Script: Refactor __('key', params) -> I18n::t('key', params) in Views/*.php
// Usage: php Scripts/refactor_views_i18n.php

$root = realpath(__DIR__ . '/..');
$viewsDir = $root . DIRECTORY_SEPARATOR . 'Views';
if (!is_dir($viewsDir)) {
    fwrite(STDERR, "Views directory not found: $viewsDir\n");
    exit(1);
}

$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsDir, FilesystemIterator::SKIP_DOTS));
$changed = 0; $files = 0; $occ = 0;
foreach ($rii as $file) {
    if (!$file->isFile()) continue;
    $ext = strtolower(pathinfo($file->getPathname(), PATHINFO_EXTENSION));
    if ($ext !== 'php') continue;

    $path = $file->getPathname();
    $code = file_get_contents($path);
    if ($code === false) continue;

    $before = $code;
    // Replace function call __('...') with static call I18n::t('...')
    $code = preg_replace('/\b__\s*\(/', 'I18n::t(', $code, -1, $count);

    if ($count > 0 && $code !== $before) {
        $ok = file_put_contents($path, $code);
        if ($ok !== false) {
            $changed++; $occ += $count;
            echo "Updated: {$path} (replacements: {$count})\n";
        }
    }
    $files++;
}

echo "Done. Scanned {$files} files. Modified {$changed} files. Total replacements: {$occ}.\n";
