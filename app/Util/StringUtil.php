<?php

namespace App\Util;

use Illuminate\Support\Str;

class StringUtil extends Str
{

  /**
   * Converts a pascal case e.g. AModelName into A Model Name
   *
   * @param String $action  The name of an action
   *
   * @return string
   */
  public static function expandPascalCaseToSentence(String $action)
  {
    return @trim(preg_replace('/(?<!\ )[A-Z]/', ' $0', $action));
  }

  /**
   * Checks if first letter of a word is a Vowel
   *
   * @param String $word  The word under check
   *
   * @return bool
   */

  public static function checkWordForVowel(string $word): bool
  {
    $vowel = ['a', 'e', 'i', 'o', 'u'];
    return (in_array(strtolower(substr($word, 0, 1)), $vowel)) ? true : false;
  }
}
