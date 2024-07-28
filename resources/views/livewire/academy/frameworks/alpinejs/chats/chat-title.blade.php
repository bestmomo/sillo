<?php

use Livewire\Volt\Component;

new class() extends Component {
	public $btn = '';
	public $links;

	public function mount()
	{
		$links = [
			'V1' => [
				'url'      => 'https://www.youtube.com/watch?v=huLSxcxFRl4&list=PLr0BjDocnuI1JdTA9aIj5LIM6wcYpvnbq&index=9',
				'duration' => 31,
			],
			'V2' => [
				'url'      => 'https://www.youtube.com/watch?v=BEKiNgcBqJw',
				'duration' => 50,
			],
		];

		$this->links = new stdClass();
		foreach ($links as $version => $link) {
			$this->links->{$version} = (object) $link;
		}
	}

	public function getUrlProperty()
	{
		return isset($this->links->{$this->btn}) ? $this->links->{$this->btn}->url : '#';
	}

	public function getDurationProperty()
	{
		return isset($this->links->{$this->btn}) ? $this->links->{$this->btn}->duration : '';
	}
}; ?>

{{-- Chat title --}}
<div class="absolute w-full flex justify-center mb-3">
    <div class="w-2/3 flex gap-4 items-center justify-around z-50">
        <h1>{{ $btn }}</h1>
        <p><a 
            class='link m-0 p-0 b-6' 
            href="{{ $this->url }}" 
            target='_blank' title='Vidéo source'
            >
            (Source {{ $btn }} - {{ $this->duration }}')
            {{-- {{ $this->url }} --}}
        </a>
    </div>
</div>
