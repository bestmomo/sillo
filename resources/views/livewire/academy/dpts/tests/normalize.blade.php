<?php
use Livewire\Volt\Component;

new class extends Component {
    public $withoutAccents = '';

    public function mount()
    {
        //
    }

    public function normalize($str)
    {
        // 2do suppr accents
        $transliteration = [
            'à' => 'a',
            'â' => 'a',
            'ä' => 'a',
            'á' => 'a',
            'ã' => 'a',
            'å' => 'a',
            'ç' => 'c',
            'è' => 'e',
            'é' => 'e',
            'ê' => 'e',
            'ë' => 'e',
            'ì' => 'i',
            'í' => 'i',
            'î' => 'i',
            'ï' => 'i',
            'ñ' => 'n',
            'ò' => 'o',
            'ó' => 'o',
            'ô' => 'o',
            'õ' => 'o',
            'ö' => 'o',
            'ù' => 'u',
            'ú' => 'u',
            'û' => 'u',
            'ü' => 'u',
            'ý' => 'y',
            'ÿ' => 'y',
        ];

        return strtr($str, $transliteration);
    }
};
?>

<div>
    //2do Test pour ôter accents, cédilles, etc... Ready.
</div>
