<?php
function mail_load_env(string $path): array
{
    $vars = [];
    if (!file_exists($path)) {
        return $vars;
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }
        $pos = strpos($line, '=');
        if ($pos === false) {
            continue;
        }
        $key = trim(substr($line, 0, $pos));
        $value = trim(substr($line, $pos + 1));
        if (((str_starts_with($value, '"') && str_ends_with($value, '"')) || (str_starts_with($value, "'") && str_ends_with($value, "'"))) && strlen($value) >= 2) {
            $value = substr($value, 1, -1);
        }
        $vars[$key] = $value;
    }
    return $vars;
}

function mail_env(string $key, ?string $default = null): ?string
{
    static $env = null;
    if ($env === null) {
        $root = dirname(__DIR__);
        $env = [];
        foreach ([$root . '/.env', $root . '/.env.local'] as $path) {
            $env = array_merge($env, mail_load_env($path));
        }
        foreach ($_ENV as $k => $v) {
            $env[$k] = $v;
        }
    }
    return $env[$key] ?? $default;
}
