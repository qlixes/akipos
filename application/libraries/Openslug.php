<?php (defined('BASEPATH')) OR exit('No direct script acc ess allowed');

class Openslug extends URLify
{
    private $lang;
    private $lowerCase;
    private $underAsSpace;

    private $country = array(
        'German'  =>  'de',
        'Latin' =>  'latin',
        'LatinSymbols' => 'latin_symbols',
        'Turkish' => 'tr',
        'Bulgarian' => 'bg',
        'Russian' => 'ru',
        'Ukrainian' => 'uk',
        'Kazakh' => 'kk',
        'Czech' => 'cs',
        'Polish' => 'pl',
        'Romanian' => 'ro',
        'Latvian' => 'lv',
        'Lithuanian' => 'lt',
        'Vietnamese' => 'vn',
        'Arabic' => 'ar',
        'Persian' => 'fa',
        'Serbian' => 'sr',
        'Azerbaijani' => 'az',
    );

    public function __construct($lang = '', $lowerCase = true, $underAsSpace = true){
        log_message('debug', 'OpenSlug: library initialized');
        $this->lang = ($lang) ? $this->country[$lang] : '';
        $this->lowerCase = $lowerCase;
        $this->underAsSpace = $underAsSpace;
    }

    /**
     * @return string
     */
    public function prettyText($text, $maxLength = 60)
    {
        /**
         * @param string $text
         * @param integer $length
         * @param string $language
         * @param boolean $fileName = false
         * @param boolean $useRemoveList = false
         * @param boolean $lowerCase = true
         * @param boolean $underscoreAsSpace = true
         */
        return self::filter($filter, $maxLength, $this->lang, false, true, $this->lowerCase, $this->underAsSpace);
    }

    /**
     * @param array $word
     */
    public function badWords($word = array())
    {
        self::remove_words($word);
        return $this;
    }
} 