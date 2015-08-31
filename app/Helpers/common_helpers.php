<?php
function parent_link($url, $exact = false) {
    $class = '';
    if ($exact) {
        if (Request::is($url)) {
            $class = ' class="active_menu"';
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