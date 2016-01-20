<?php
function parent_link($url, $exact = false) {
    $class = '';
    if ($exact) {
        if (Request::is($url)) {
            /*$class = ' class="active_menu"';*/
            $class = ' ';
        }
    } else if (strpos(Request::url(), $url) != false) {
        $class = ' class="active"';
    }

    return $class;
}

function year_array()
{
    $years = DB::table('presensibaru')
                                    ->select([DB::raw('DISTINCT(year(TANGGAL)) as attendance_year')])
                                    ->whereRaw('year(TANGGAL) > 0')
                                    ->orderBy('attendance_year')
                                    ->get();
    $year_array = array();
    foreach ($years as $year)
    {
        $year_array[$year->attendance_year] = $year->attendance_year;
        //var_dump();
    }

    return $year_array;
}

function cleanNumber($number)
{
    if (false !== strpos($number, '.'))
    {
        return rtrim(rtrim($number, '0'), '.');
    }
    else
    {
        return $number;
    }

}

function naturalTime($hour)
{
    if (empty($hour))
    {
        return "";
    }

    $hour = explode(":", $hour);
    $time = intval($hour[0])." ".trans('common.hour');

    if ($hour[1] != "00")
    {
        $time .= " ".intval($hour[1])." ".trans('common.minute');
    }

    return $time;
}

function numberToRoman($num)
{
    $n = intval($num);
    $result = '';

    // Declare a lookup array that we will use to traverse the number:
    $lookup = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400,
        'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40,
        'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);

    foreach ($lookup as $roman => $value)
    {
        // Determine the number of matches
        $matches = intval($n / $value);

        // Store that many characters
        $result .= str_repeat($roman, $matches);

        // Substract that from the number
        $n = $n % $value;
    }

    // The Roman numeral should be built, return it
    return $result;
}

function localeDate($date, $display_time = true) {
    if ( empty($date) )  {
        return "";
    } else {
        $check = explode(" ",$date);

        $time = '';

        if (count($check) == '2') {
            $date = explode("-",$check[0]);
            $time = $check[1];
        } else {
            $date = explode("-",$date);
        }

        $month = trans('common.month_array');
        $month_idx = intval($date[1]);

        if($month_idx != 0) {
            $show_date = $date[2]." ".$month[$month_idx]." ".$date[0];

            if ((count($check) == '2') && ($display_time)) {
                return $show_date. "  ".$time;
            } else {
                return $show_date;
            }
        }
    }
}

function getDay($date)
{
    return substr($date, 8, 2);
}

function getMonth($date)
{
    /*month_array_short*/
    $month = intval(substr($date, 5, 2));
    return trans('common.month_array_short')[$month];
}


function convertToDatepicker($date, $separator = '-', $return_separator = '/')
{
    $date = explode($separator,$date);

    return $date[2].$return_separator.$date[1].$return_separator.$date[0];
}

function terbilang($x)
{
    $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    if ($x < 12)
        return " " . $abil[$x];
    elseif ($x < 20)
        return terbilang($x - 10) . " belas";
    elseif ($x < 100)
        return terbilang($x / 10) . " puluh" . terbilang($x % 10);
    elseif ($x < 200)
        return " seratus" . terbilang($x - 100);
    elseif ($x < 1000)
        return terbilang($x / 100) . " ratus" . terbilang($x % 100);
    elseif ($x < 2000)
        return " seribu" . terbilang($x - 1000);
    elseif ($x < 1000000)
        return terbilang($x / 1000) . " ribu" . terbilang($x % 1000);
    elseif ($x < 1000000000)
        return terbilang($x / 1000000) . " juta" . terbilang($x % 1000000);
    else
        return "Angka terlalu besar";
}

function link_new_window($url)
{
    $html = '<script type="text/javascript"> w = window.open( "'.$url.'" );w.print();w.close()</script>';

    echo $html;
}

/**
 * This file is part of the array_column library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) Ben Ramsey (http://benramsey.com)
 * @license http://opensource.org/licenses/MIT MIT
 */

if (!function_exists('array_column')) {
    /**
     * Returns the values from a single column of the input array, identified by
     * the $columnKey.
     *
     * Optionally, you may provide an $indexKey to index the values in the returned
     * array by the values from the $indexKey column in the input array.
     *
     * @param array $input A multi-dimensional array (record set) from which to pull
     *                     a column of values.
     * @param mixed $columnKey The column of values to return. This value may be the
     *                         integer key of the column you wish to retrieve, or it
     *                         may be the string key name for an associative array.
     * @param mixed $indexKey (Optional.) The column to use as the index/keys for
     *                        the returned array. This value may be the integer key
     *                        of the column, or it may be the string key name.
     * @return array
     */
    function array_column($input = null, $columnKey = null, $indexKey = null)
    {
        // Using func_get_args() in order to check for proper number of
        // parameters and trigger errors exactly as the built-in array_column()
        // does in PHP 5.5.
        $argc = func_num_args();
        $params = func_get_args();

        if ($argc < 2) {
            trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);
            return null;
        }

        if (!is_array($params[0])) {
            trigger_error(
                'array_column() expects parameter 1 to be array, ' . gettype($params[0]) . ' given',
                E_USER_WARNING
            );
            return null;
        }

        if (!is_int($params[1])
            && !is_float($params[1])
            && !is_string($params[1])
            && $params[1] !== null
            && !(is_object($params[1]) && method_exists($params[1], '__toString'))
        ) {
            trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);
            return false;
        }

        if (isset($params[2])
            && !is_int($params[2])
            && !is_float($params[2])
            && !is_string($params[2])
            && !(is_object($params[2]) && method_exists($params[2], '__toString'))
        ) {
            trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);
            return false;
        }

        $paramsInput = $params[0];
        $paramsColumnKey = ($params[1] !== null) ? (string) $params[1] : null;

        $paramsIndexKey = null;
        if (isset($params[2])) {
            if (is_float($params[2]) || is_int($params[2])) {
                $paramsIndexKey = (int) $params[2];
            } else {
                $paramsIndexKey = (string) $params[2];
            }
        }

        $resultArray = array();

        foreach ($paramsInput as $row) {
            $key = $value = null;
            $keySet = $valueSet = false;

            if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row)) {
                $keySet = true;
                $key = (string) $row[$paramsIndexKey];
            }

            if ($paramsColumnKey === null) {
                $valueSet = true;
                $value = $row;
            } elseif (is_array($row) && array_key_exists($paramsColumnKey, $row)) {
                $valueSet = true;
                $value = $row[$paramsColumnKey];
            }

            if ($valueSet) {
                if ($keySet) {
                    $resultArray[$key] = $value;
                } else {
                    $resultArray[] = $value;
                }
            }

        }

        return $resultArray;
    }

}