<?php

/*
 * Ritorna codice di controllo EAN13
 * @param $barcode Il barcode non completo (12 caratteri)
 * @return string(1) Check digit come stringa
 */
function ean_checkdigit($barcode){
    $digits = $barcode;

    // 1. Add the values of the digits in the 
    // even-numbered positions: 2, 4, 6, etc.
    $even_sum = $digits[1] + $digits[3] + $digits[5] +
                $digits[7] + $digits[9] + $digits[11];

    // 2. Multiply this result by 3.
    $even_sum_three = $even_sum * 3;

    // 3. Add the values of the digits in the 
    // odd-numbered positions: 1, 3, 5, etc.
    $odd_sum = $digits[0] + $digits[2] + $digits[4] +
               $digits[6] + $digits[8] + $digits[10];

    // 4. Sum the results of steps 2 and 3.
    $total_sum = $even_sum_three + $odd_sum;

    // 5. The check character is the smallest number which,
    // when added to the result in step 4, produces a multiple of 10.
    $next_ten = (ceil($total_sum / 10)) * 10;
    $check_digit = $next_ten - $total_sum;

    return (string) $check_digit;
}

/*
 * Dato un numero casuale, lo avvolge nel formato EAN13 pubblico
 * ref. https://github.com/CroceRossaCatania/gaia/issues/84#issuecomment-39663074
 * @param string 7 cifre casuali
 * @return string EAN13 corretto
 */
function avvolgiCodicePubblico( $numeriCasuali ) {
    return (int) "8016{$numeriCasuali}" . ean_checkdigit($numeriCasuali);
}


/*
 * Dato un numero casuale, lo avvolge nel formato EAN13 privato
 * ref. https://github.com/CroceRossaCatania/gaia/issues/84#issuecomment-39663074
 * @param string 7 cifre casuali
 * @return string EAN13 corretto
 */
function avvolgiCodicePrivato( $numeriCasuali ) {
    return (int) "8017{$numeriCasuali}" . ean_checkdigit($numeriCasuali);
}

