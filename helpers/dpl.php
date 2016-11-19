<?php

function dpl_clear(&$val)
{
    $val = strtolower(trim($val));
    $splitted = preg_split("/[\\/\\/]{2}|[||]{2}/", $val);
    if (sizeof($splitted) > 1) $val = $splitted[0];
    return $val;
}

function prepare(&$val)
{
    switch ($val) {
        case 'true':
            $val = true;
            break;
        case 'false':
            $val = false;
            break;
    }
}

function dpl($arg, $default = false)
{
    dpl_clear($arg);
    if (!file_exists(DPL)) return false;
    $dpl_file = file_get_contents(DPL);
    $dpl_lines = explode("\n", $dpl_file);
    $dpl = [];
    foreach ($dpl_lines as $line) {
        if ($line == '' || $line[0] == '#' || in_array(substr($line, 0, 2), ['//', '||'])) continue;
        $line = explode('=', $line);
        if (sizeof($line) >= 2) {
            dpl_clear($line[0]);
            dpl_clear($line[1]);
            prepare($line[1]);
            $dpl[$line[0]] = $line[1];
        }
    }
    return (!empty($dpl[$arg]) ? dpl_clear($dpl[$arg]) : $default);
}