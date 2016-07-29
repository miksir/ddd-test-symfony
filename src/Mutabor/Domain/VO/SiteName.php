<?php


namespace Mutabor\Domain\VO;


class SiteName implements ValueObject
{
    private $site_name;

    private $map = [
        'ый' => 'iy',
        'а' => 'a',
        'б' => 'b',
        'в' => 'v',
        'г' => 'g',
        'д' => 'д',
        'е' => 'e',
        'ё' => 'е',
        'ж' => 'j',
        'з' => 'z',
        'и' => 'i',
        'й' => 'y',
        'к' => 'k',
        'л' => 'l',
        'м' => 'm',
        'н' => 'n',
        'о' => 'o',
        'п' => 'p',
        'р' => 'r',
        'с' => 's',
        'т' => 't',
        'у' => 'u',
        'ф' => 'f',
        'x' => 'h',
        'ц' => 'ts',
        'ч' => 'ch',
        'ш' => 'sh',
        'щ' => 'shch',
        'ъ' => '',
        'ы' => 'y',
        'ь' => '',
        'э' => 'e',
        'ю' => 'yu',
        'я' => 'ya',
    ];
    private $max_length = 128;

    public function __construct(string $site_name)
    {
        $str = '';
        $current_length = -1;
        $words = preg_split('/[^0-9A-Za-zА-Яёа-яё\-_\.]+/u', $site_name);
        foreach ($words as $word) {
            $tr_word = $this->transliterate($word);
            $current_length += strlen($tr_word) + 1;
            if ($current_length > $this->max_length) {
                if (!$str) {
                    $str = substr($tr_word, 0, $this->max_length);
                }
                break;
            }
            $str .= ($str ? '-' : '') . $tr_word;
        }
        $this->site_name = $str;
    }
    
    public function __toString() : string
    {
        return $this->site_name;
    }

    public function equals(SiteName $object) : bool
    {
        return $this->site_name === (string)$object;
    }

    private function transliterate(string $string) : string
    {
        $string = mb_strtolower($string);
        return str_replace(array_keys($this->map), array_values($this->map), $string);
    }
}