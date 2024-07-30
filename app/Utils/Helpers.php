<?php

namespace App\Utils;

class Helpers
{
  static function numberFormat($number)
  {
    // return number_format((int) $number, 0, ',', ' ');
    return $number;
  }

  static function moneyFormat($number)
  {
    $toFormat = (int) $number;

    if ($toFormat > 999999999) {
      return number_format($toFormat / 1000000000, 0, ',', ' ') . ' Milliards';
    } else if ($toFormat > 999999) {
      return number_format($toFormat / 1000000, 0, ',', ' ') . ' Millions';
    } else if ($toFormat > 999) { 
      return number_format($toFormat / 1000, 0, ',', ' ') . ' Milles';
    } else {
      return number_format($toFormat, 0, ',', ' ');
    }
  }

}
