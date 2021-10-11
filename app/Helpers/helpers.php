<?php

use Illuminate\Support\Carbon;

if (!function_exists('greeting')) {
  function greeting(string $name = null): string
  {
    $hour = (int) Carbon::now()->format('H');

    if ($hour < 12) {
      return  $name ? 'Pagi, ' . $name  : 'Selamat Pagi';
    } else if ($hour >= 12 && $hour < 17) {
      return $name ? 'Siang, ' . $name  : 'Selamat Siang';
    } else if ($hour >= 17 && $hour < 19) {
      return $name ? 'Sore, ' . $name  : 'Selamat Sore';
    } else if ($hour >= 19) {
      return $name ? 'Malam, ' . $name  : 'Selamat Malam';
    } else {
      return '';
    }
  }
}

if (!function_exists('time_format_last_updated')) {
  function time_format_last_updated($model)
  {
    return  'Terakhir diubah pada ' . $model->updated_at->isoFormat('dddd, D MMMM YYYY h:mm A');
  }
}


if (!function_exists('get_classname')) {
  function get_classname($class, $with_extension = true)
  {
    $name = substr(strrchr($class, '\\'), 1);
    return $with_extension ? $name . '.php' : $name;
  }
}
