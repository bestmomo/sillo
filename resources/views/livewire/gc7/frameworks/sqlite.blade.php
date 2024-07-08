<?php

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Volt\Component;

new class() extends Component {
	public $posts;
	public $page;
	public $perPage;
	public $total;
	public $data = 'Explicabo dolore repudiandae aut repellat. Iste eum accusantium sed quidem consectetur iste. Adipisci beatae itaque dolorem magnam laudantium. Ad sit et debitis. Ad quibusdam qui voluptas. Quae voluptates autem aspernatur temporibus vitae consequatur. Et nisi natus eligendi consequuntur est sunt.';

	public function mount()
	{
		$paginator = $this->getBaseQuery()->paginate(6);
		$posts     = $paginator->getCollection();
		foreach ($posts as $post) {
			// $post->excerpt = preg_replace("/\r|\n/", " ", $post->excerpt);
			$post->excerpt = rtrim($post->excerpt, '-;,!?….\n\r\t');
			$post->excerpt = preg_replace('/\s+\S+$/', '', $post->excerpt);
		}
		$this->posts = $posts;
		// $this->page = $paginator->currentPage();
		// $this->perPage = $paginator->perPage();
		$this->total = $paginator->total();

		$this->data = rtrim($this->data, '-;,!?….\n\r\t');
		$this->data = preg_replace('/\s+\S+$/', 'fdgdfg', $this->data);

		// All that, in the view: {{ str($post->excerpt)->limit(100) }} or
		//                        {{ str($post->excerpt)->wordss(30) }}
	}

	protected function getBaseQuery(): Builder
	{
		$specificReqs = [
			'mysql'  => "LEFT(body, LOCATE(' ', body, 300))",
			'sqlite' => 'substr(body, 1, 300)',
			'pgsql'  => "substring(body from '^.{1,300}\\b')",
		];
		$usedDbSystem = env('DB_CONNECTION', 'mysql');
		$adaptedReq   = $specificReqs[$usedDbSystem];

		return Post::select('id', 'slug', 'image', 'title', 'user_id', 'category_id', 'serie_id', 'created_at')
			->selectRaw(
				"
                    CASE
                        WHEN LENGTH(body) <= 300 THEN body
                        ELSE {$adaptedReq}
                    END AS excerpt
                ",
			)
			->with('user:id,name', 'category', 'serie')
			->whereActive(true)
			->where('id', 4)
			->latest();
	}
}; ?>

<div>
    <h1>SqLite {{ $this->total }}</h1>
    <hr>
    @foreach ($posts as $post)
        {{ $post->title }}:<br>{{ $post->excerpt }}<br><br>
    @endforeach
    
    {{ strlen($post->excerpt) }}
    
    <hr>
    
    {{ $data ?? 'no' }}
</div>
