<?php

function check_empty($data)
{
    $result = empty($data) ? '-' : $data;
    return $result;
}

function format_rupiah($nominal)
{
    return 'Rp ' . number_format($nominal, 0, ',', '.');
}
