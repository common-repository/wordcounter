<?php

/**
 * The core plugin functions.
 *
 * This is used to define functions for the admin and public side.
 *
 * @since      1.0.0
 * @package    Wordcounter
 * @subpackage Wordcounter/admin
 * @link       https://nearchx.com
 * @author     NearchX <contact@nearchx.com>
*/

function wordcounter_remove_uncountable_characters_from_text($text) {
  $filtered_text = wp_strip_all_tags($text);
  $open_index = 0;
  $close_index = 0;
  $index = 0;

  while (true) {
    if (strpos($filtered_text, '~~~') !== false) {
      $open_index = strpos($filtered_text, '~~~');
      $index = $open_index + 3;
      if (strpos($filtered_text, '~~~', $index) !== false) {
        $close_index = strpos($filtered_text, '~~~', $index) + 3;
        $filtered_text = substr($filtered_text, 0, $open_index) . substr($filtered_text, $close_index);
      } else {
        break;
      }
    } else {
      break;
    }
  }

  return $filtered_text;
}

function wordcounter_count_words($text) {
  $words = wordcounter_words_of_text($text);
  return count($words);
}

function wordcounter_words_of_text($text) {
  $words = null;
  $matches = null;
  $text_without_space = preg_replace('/\s+/', '', $text);
  preg_match_all('/([^\x00-\x7F\x{2013}\x{2014}])+/iu', $text_without_space, $matches);
  $flattened_array = [];
  array_walk_recursive($matches, function($a) use (&$flattened_array) {
    $flattened_array[] = $a;
  });

  $latin_only = count($flattened_array) == 0;
  if ($latin_only == false) {
    preg_match_all('/\S+/', $text, $matches);
    $words = $matches[0];
  } else {
    $words = preg_replace('/[;!:—\/]/', ' ', $text);
    $words = preg_replace('/\.\s+/', ' ', $words);
    $words = preg_replace('/[^a-zA-Z\d\s&:,]/', '', $words);
    $words = preg_replace('/,([^0-9])/', ' $1', $words);
    preg_match_all('/\S+/', $words, $matches);
    $words = $matches[0];
  }

  return is_array($words) ? $words : [];
}

function wordcounter_count_reading_time($word_count) {
  $int_part_of_number = null;
  $decimal_part_of_number = null;
  // Average based on http://crr.ugent.be/papers/Brysbaert_JML_2019_Reading_rate.pdf
  $words_per_minute_for_reading = 250;

  $reading_time = $word_count / $words_per_minute_for_reading;

  if ($reading_time < 1) {
    return ceil($reading_time * 60) . ' sec';
  } else if ($reading_time >= 1 && $reading_time < 60) {
    $reading_time = round($reading_time * 100) / 100;
    $int_part_of_number = floor($reading_time);
    $decimal_part_of_number = round(fmod($reading_time, 1) * 60);
    return $int_part_of_number . ' min and ' . $decimal_part_of_number . " sec";
  } else {
    $reading_time = round(($reading_time / 60) * 100) / 100;
    $int_part_of_number = floor($reading_time);
    $decimal_part_of_number = round(fmod($reading_time, 1) * 60);
    return $int_part_of_number . ' hr and ' . $decimal_part_of_number . ' min';
  }
}