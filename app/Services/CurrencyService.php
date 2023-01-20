<?php
    namespace App\Services;

    class CurrencyService{
        
        public function getIndianCurrency($amount) {

            $decimal = round($amount - ($no = floor($amount)), 2) * 100;
            $hundred = null;
            $digits_length = strlen($no);
            $i = 0;
            $str = array();
            $words = array(0 => '', 1 => 'One', 2 => 'Two',
                3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
                7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
                10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
                13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
                16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
                19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
                40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
                70 => 'seventy', 80 => 'Eighty', 90 => 'Ninety');
            $digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
        
            while( $i < $digits_length ) {
                $divider = ($i == 2) ? 10 : 100;
                $amount = floor($no % $divider);
                $no = floor($no / $divider);
                $i += $divider == 10 ? 1 : 2;
                if ($amount) {
                    $plural = (($counter = count($str)) && $amount > 9) ? '' : null;
                    $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                    $str [] = ($amount < 21) ? $words[$amount].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($amount / 10) * 10].' '.$words[$amount % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
                } else $str[] = null;
            }
        
            $rupees = implode('', array_reverse($str));
            $paise = '';
        
            if ($decimal) {
                $paise = 'and ';
                $decimal_length = strlen($decimal);
        
                if ($decimal_length == 2) {
                    if ($decimal >= 20) {
                        $dc = $decimal % 10;
                        $td = $decimal - $dc;
                        $ps = ($dc == 0) ? '' : '-' . $words[$dc];
        
                        $paise .= $words[$td] . $ps;
                    } else {
                        $paise .= $words[$decimal];
                    }
                } else {
                    $paise .= $words[$decimal % 10];
                }
        
                $paise .= ' paise';
            }
        
            return ($rupees ? $rupees . 'Only' : '') . $paise ;
        }
    }

?>