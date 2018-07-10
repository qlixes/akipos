<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Slug {

	private $CI;

	public function __construct(){
		log_message('debug', 'Slug: library initialized');

		$this->CI =& get_instance();
  }

    /**
   * Create a web friendly URL slug from a string.
   *
   * Although supported, transliteration is discouraged because
   *     1) most web browsers support UTF-8 characters in URLs
   *     2) transliteration causes a loss of information
   *
   * @author Sean Murphy <sean@iamseanmurphy.com>
   * @copyright Copyright 2012 Sean Murphy. All rights reserved.
   * @license http://creativecommons.org/publicdomain/zero/1.0/
   *
   * @param string $str
   * @param array $options
   * @return string
   */
  function url_slug($str, $options = array()) {
  	// Make sure string is in UTF-8 and strip invalid UTF-8 characters
  	$str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

  	$defaults = array(
  		'delimiter' => '-',
  		'limit' => null,
  		'lowercase' => true,
  		'replacements' => array()
  	);

  	// Merge options
  	$options = array_merge($defaults, $options);

  	// Make custom replacements
  	$str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

  	// Replace non-alphanumeric characters with our delimiter
  	$str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

  	// Remove duplicate delimiters
  	$str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

  	// Truncate slug to max. characters
  	$str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

  	// Remove delimiter from ends
  	$str = trim($str, $options['delimiter']);

  	return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
  }
}
