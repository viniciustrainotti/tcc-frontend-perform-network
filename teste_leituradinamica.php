<?php

function no_response($line, $time, $ms){

//64 bytes from 8.8.8.8: icmp_seq=1 ttl=120 time=9.17 ms

//$line = '64 bytes from 8.8.8.8: icmp_seq=1 ttl=120 time=9.17 ms';

//devido ao strpos ser a primeira aparição da string preciso contar a mais o tamanho dela ou seja na $line a string 'time=' está na posicao 42 e o tamanho dela é 5;
$mystring = $line;
//$findme   = 'time=';
$findme = $time;
$legthTime = strlen($time);
$pos = $legthTime + strpos($mystring, $findme);

// $mystring0 = $line;
//$findme0   = 'ms';
// $findme0 = $ms;
// $pos0 = strpos($mystring0, $findme0);
$pos0 = $ms;

// Note o uso de ===.  Simples == não funcionaria como esperado
// por causa da posição de 'a' é 0 (primeiro) caractere.
/*if ($pos === false) {
    echo "A string '$findme' não foi encontrada na string '$mystring'";
} else {
    echo "A string '$findme' foi encontrada na string '$mystring'";
    echo " e existe na posição $pos";
}

// Note o uso de ===.  Simples == não funcionaria como esperado
// por causa da posição de 'a' é 0 (primeiro) caractere.
if ($pos0 === false) {
    echo "A string '$findme0' não foi encontrada na string '$mystring0'";
} else {
    echo "A string '$findme0' foi encontrada na string '$mystring0'";
    echo " e existe na posição $pos0";
}*/

$posfinal = $pos0 - $pos;

//$posfinal *= -1;

//echo "posicao final ". $posfinal;

$rest = substr($mystring, $pos, $posfinal);

//echo nl2br("\n\n " . $rest);

//retorna o valor do time na string;
//no exemplo 9.17

return $rest;

}

$line = 'no answer yet for icmp_seq=5';
// $line = '64 bytes from 8.8.8.8: icmp_seq=1 ttl=120 time=9.17777777 ms';
$icmp_seq = 'icmp_seq=';
$ms = strlen($line);

$no_response_icmp = no_response($line, $icmp_seq, $ms);

echo trim($no_response_icmp);

?>