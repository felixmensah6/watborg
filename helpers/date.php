<?php

/*
 |-----------------------------------------------------------------
 | Date Helper
 |-----------------------------------------------------------------
 |
 | Reusable date functions
 |
 */

/**
 * Button
 * --------------------------------------------
 *
 * @param string $content The tag content
 * @param array $attributes The button attributes
 * @return string
 */
function timeago($date)
{
    $strtotime = strtotime($date);
    $estimate_time = time() - $strtotime;

    if($estimate_time < 1)
    {
        return '1 second ago';
    }

    $condition = array(
                12 * 30 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach ($condition as $seconds => $string)
    {
        $date = $estimate_time / $seconds;

        if($date >= 1)
        {
            $round = round($date);
            return $round . ' ' . $string . ($round > 1 ? 's' : '') . ' ago';
        }
    }
}

/**
 * Date and Time Formatter
 * --------------------------------------------
 *
 * @param string $date The date string
 * @param string $date_format The date format
 * @param string $time The time string
 * @param string $time_format The time format
 * @return string
 */
function time_format($date, $date_format = null, $time = false, $time_format = null)
{
    $date = str_replace('/', '-', $date);

    switch ($time_format)
    {
        case "HH:mm":
            $time_format = "H:i";
            break;

        case "HH:mm:ss":
            $time_format = "H:i:s";
            break;

        case "h:mm tt":
            $time_format = "g:i A";
            break;

        case "h:mm:ss tt":
            $time_format = "g:i:s A";
            break;

        default:
            $time_format = ($time) ? "H:i:s" : null;
    }

    // Format date based on condition
    switch ($date_format)
    {
        case "DD-MM-YYYY":
            return date("d-m-Y {$time_format}", strtotime($date));
            break;

        case "YYYY-MM-DD":
            return date("Y-m-d {$time_format}", strtotime($date));
            break;

        case "DD/MM/YYYY":
            return rtrim(date("d/m/Y {$time_format}", strtotime($date)));
            break;

        case "DD-MMM-YY":
            return rtrim(date("j-M-y {$time_format}", strtotime($date)));
            break;

        case "DD MMM. YYYY":
            return rtrim(date("j M. Y {$time_format}", strtotime($date)));
            break;

        case "DDD, DD MMM. YYYY":
            return rtrim(date("D, j M. Y {$time_format}", strtotime($date)));
            break;

        default:
            return rtrim(date("Y-m-d {$time_format}", strtotime($date)));
    }
}

/**
 * Get Age
 * --------------------------------------------
 *
 * @param string $birthday Birth date
 * @return int
 */
function get_age($birthday)
{
    $birthday = strtotime($birthday);
    $year = date('Y');
    $birth_year = date('Y', $birthday);
    $age = $year - $birth_year;
    return $age;
}

/**
 * Get Execution Time
 * --------------------------------------------
 *
 * @return double
 */
function get_execution_time()
{
    $end_time = microtime(true);
    $time = $end_time - SYSTEM_START_TIME;
    return number_format($time, 4) . ' ms';
}
