<?
/**
 * A simple utility class to be used for formatting dates 
 */

trait DateFormatter 
{
    protected function format_date($time, $format = null, $modify = null)
    {
        if (!is_null($modify)) {
            return (new DateTime($time))->modify($modify)->format($format);    
        }

        return (new DateTime($time))->format($format);
    }
}