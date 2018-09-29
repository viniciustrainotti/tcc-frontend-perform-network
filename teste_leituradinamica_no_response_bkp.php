<?php

function ping_var($line, $time, $ms){

//64 bytes from 8.8.8.8: icmp_seq=1 ttl=120 time=9.17 ms

//$line = '64 bytes from 8.8.8.8: icmp_seq=1 ttl=120 time=9.17 ms';

//devido ao strpos ser a primeira aparição da string preciso contar a mais o tamanho dela ou seja na $line a string 'time=' está na posicao 42 e o tamanho dela é 5;
$mystring = $line;

$findme = $time;
$legthTime = strlen($time);
$pos = $legthTime + strpos($mystring, $findme);

$mystring0 = $line;

$findme0 = $ms;
$pos0 = strpos($mystring0, $findme0);

$posfinal = $pos0 - $pos;

$rest = substr($mystring, $pos, $posfinal);

return $rest;

}

// $line = 'no answer yet for icmp_seq=5';
$line = '64 bytes from 192.168.100.43: icmp_seq=10 ttl=127 time=2.25 ms';
$icmp_seq = 'ttl=';
$ms = 'time';

$icmp = ping_var($line, $icmp_seq, $ms);

echo trim($icmp);

?>