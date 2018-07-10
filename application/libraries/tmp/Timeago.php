<?php (defined('BASEPATH')) OR exit('No direct script acc ess allowed');

/*
 * Thanks to https://www.sitepoint.com/author/ovalutis/ for Articles
 * Time Ago : How to display publish dates as time since posted
 */

// please references into strftime PHP function
class Timeago
{
  private $format;
  private $diff;

  private function _now()
  {
    return 'now';
  }

  private function _second()
  {
    return 'few seconds';
  }

  private function _minute()
  {
    return '{num} minute ago';
  }

  private function _minutes()
  {
    return '{num} minutes ago';
  }

  private function _hour()
  {
    return '{num} hour ago';
  }

  private function _hours()
  {
    return '{num} hours ago';
  }

  private function _yesterday()
  {
    return 'yesterday';
  }

  public function __construct()
  {
    $this->format = '%d %B %Y';
  }

  // private function _week()
  // {
  //   return 'week ago';
  // }
  //
  // private function _weeks()
  // {
  //   return 'weeks ago';
  // }
  //
  // private function _month()
  // {
  //   return 'month ago';
  // }

  public function format($format)
  {
    $this->format = $format;
  }

  public function time_ago($time)
  {
    $out    = ''; // what we will print out
    $now    = time(); // current time
    $diff   = $now - $time; // difference between the current and the provided dates

    if ($diff < 1)
      return $this->_now();

    elseif( $diff < 60 ) // it happened now
      return $this->_second();

    elseif( $diff < 3600 ) // it happened X minutes ago
      return str_replace( '{num}', ($out = round( $diff / 60 ) ), $out == 1 ? $this->_minute() : $this->_minutes());

    elseif( $diff < 3600 * 24 ) // it happened X hours ago
      return str_replace( '{num}', ($out = round( $diff / 3600 ) ), $out == 1 ? $this->_hour() : $this->_hours() );

    elseif( $diff < 3600 * 24 * 2 ) // it happened yesterday
      return $this->_yesterday();

    else // falling back on a usual date format as it happened later than yesterday
        return strftime($this->format, $time);
  }
}
