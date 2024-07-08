<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

use App\Models\Category;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Post;
use App\Models\Serie;
use App\Models\Submenu;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new
#[Title('Nav Menu'), Layout('components.layouts.admin')]
class extends Component {
	use Toast;

	public Collection $menus;

	#[Rule('required|max:255|unique:menus,label')]
	public string $label = '';

	#[Rule('nullable|regex:/\/([a-z0-9_-]\/*)*[a-z0-9_-]*/')]
	public string $link = '';

	public string $sublabel = '';
	public string $sublink  = '';
	public int $subPost     = 0;
	public int $subPage     = 0;
	public int $subSerie    = 0;
	public int $subCategory = 0;
	public int $subOption   = 1;

	// Méthode appelée lors de l'initialisation du composant.
	public function mount(): void
	{
		$this->getMenus();
	}

	// Récupérer les menus avec leurs sous-menus triés par ordre.
	public function getMenus(): void
	{
		$this->menus = Menu::with(['submenus' => function (Builder $query) {
			$query->orderBy('order');
		}])->orderBy('order')->get();
	}

	// Méthode appelée lors de la mise à jour d'une propriété.
	public function updating($property, $value): void
	{
		if ('' != $value) {
			switch ($property) {
				case 'subPost':
					$post = Post::find($value);
					if ($post) {
						$this->sublabel = $post->title;
						$this->sublink  = route('posts.show', $post->slug);
					}

					break;
				case 'subPage':
					$page = Page::find($value);
					if ($page) {
						$this->sublabel = $page->title;
						$this->sublink  = route('pages.show', $page->slug);
					}

					break;
				case 'subSerie':
					$serie = Serie::find($value);
					if ($serie) {
						$this->sublabel = $serie->title;
						$this->sublink  = url('serie/' . $serie->slug);
					}

					break;
				case 'subCategory':
					$category = Category::find($value);
					if ($category) {
						$this->sublabel = $category->title;
						$this->sublink  = url('category/' . $category->slug);
					}

					break;
				case 'subOption':
					$this->sublabel    = '';
					$this->sublink     = '';
					$this->subPost     = 0;
					$this->subPage     = 0;
					$this->subSerie    = 0;
					$this->subCategory = 0;

					break;
			}
		}
	}

	// Monter un menu d'un rang.
	public function up(Menu $menu): void
	{
		$previousMenu = Menu::where('order', '<', $menu->order)
			->orderBy('order', 'desc')
			->first();

		$this->swap($menu, $previousMenu);
	}

	// Monter un sous-menu d'un rang.
	public function upSub(Submenu $submenu): void
	{
		$previousSubmenu = Submenu::where('menu_id', $submenu->menu_id)
			->where('order', '<', $submenu->order)
			->orderBy('order', 'desc')
			->first();

		$this->swapSub($submenu, $previousSubmenu);
	}

	// Descendre un menu d'un rang.
	public function down(Menu $menu): void
	{
		$previousMenu = Menu::where('order', '>', $menu->order)
			->orderBy('order', 'asc')
			->first();

		$this->swap($menu, $previousMenu);
	}

	// Descendre un sous-menu d'un rang.
	public function downSub(Submenu $submenu): void
	{
		$previousSubmenu = Submenu::where('menu_id', $submenu->menu_id)
			->where('order', '>', $submenu->order)
			->orderBy('order', 'asc')
			->first();

		$this->swapSub($submenu, $previousSubmenu);
	}

	// Supprimer un menu.
	public function deleteMenu(Menu $menu): void
	{
		$menu->delete();
		$this->reorderMenus();
		$this->getMenus();
		$this->success(__('Menu deleted with success.'));
	}

	// Supprimer un sous-menu.
	public function deleteSubmenu(Menu $menu, Submenu $submenu): void
	{
		$submenu->delete();
		$this->reorderSubmenus($menu);
		$this->getMenus();
		$this->success(__('Submenu deleted with success.'));
	}

	// Enregistrer un nouveau menu.
	public function saveMenu(): void
	{
		$data = $this->validate();

		$data['order'] = $this->menus->count() + 1;

		Menu::create($data);

		$this->success(__('Menu created with success.'), redirectTo: '/admin/menus/index');
	}

	// Enregistrer un nouveau sous-menu.
	public function saveSubmenu(Menu $menu): void
	{
		$data = $this->validate([
			'sublabel' => 'required|max:255',
			'sublink'  => 'required|url',
		]);

		$data['order'] = $menu->submenus->count() + 1;
		$data['label'] = $this->sublabel;
		$data['link']  = $this->sublink;

		$menu->submenus()->save(new Submenu($data));

		$this->sublabel = '';
		$this->sublink  = '';

		$this->success(__('Submenu created with success.'));
	}

	// Fournir les données nécessaires à la vue.
	public function with(): array
	{
		return [
			'pages'      => Page::select('id', 'title', 'slug')->get(),
			'posts'      => Post::select('id', 'title', 'slug', 'created_at')->latest()->take(10)->get(),
			'series'     => Serie::select('id', 'title', 'slug')->get(),
			'categories' => Category::all(),
			'subOptions' => [
				['id' => 1, 'name' => __('Post')],
				['id' => 2, 'name' => __('Page')],
				['id' => 3, 'name' => __('Serie')],
				['id' => 4, 'name' => __('Category')],
			],
		];
	}

	// Échanger les ordres de deux sous-menus.
	private function swapSub(Submenu $submenu, Submenu $previousSubmenu): void
	{
		$tempOrder              = $submenu->order;
		$submenu->order         = $previousSubmenu->order;
		$previousSubmenu->order = $tempOrder;

		$submenu->save();
		$previousSubmenu->save();

		$this->getMenus();
	}

	// Échanger les ordres de deux menus.
	private function swap(Menu $menu, Menu $previousMenu): void
	{
		$tempOrder           = $menu->order;
		$menu->order         = $previousMenu->order;
		$previousMenu->order = $tempOrder;

		$menu->save();
		$previousMenu->save();

		$this->getMenus();
	}

	// Réordonner les menus après suppression.
	private function reorderMenus(): void
	{
		$menus = Menu::orderBy('order')->get();
		foreach ($menus as $index => $menu) {
			$menu->order = $index + 1;
			$menu->save();
		}
	}

	// Réordonner les sous-menus après suppression.
	private function reorderSubmenus(Menu $menu): void
	{
		$submenus = $menu->submenus()->orderBy('order')->get();
		foreach ($submenus as $index => $submenu) {
			$submenu->order = $index + 1;
			$submenu->save();
		}
	}
}; ?>

<div>
	<a href="/admin/dashboard" title="{{ __('Back to Dashboard') }}">
  	<x-header title="{{__('Navigation')}}" separator progress-indicator />
	</a>
	
  <x-card>

    @foreach($menus as $menu)
    <x-list-item :item="$menu" no-separator no-hover>
      <x-slot:value>
        {{ $menu->label }}
      </x-slot:value>
      <x-slot:sub-value>
        @if($menu->link)
        {{ $menu->link }}
        @else
        @lang('Root menu')
        @endif
      </x-slot:sub-value>
      <x-slot:actions>
        @if($menu->order > 1)
        <x-button icon="s-chevron-up" wire:click="up({{ $menu->id }})" tooltip-left="{{ __('Up') }}" spinner />
        @endif
        @if($menu->order < $menus->count())
          <x-button icon="s-chevron-down" wire:click="down({{ $menu->id }})" tooltip-left="{{ __('Down') }}" spinner />
          @endif
          <x-button icon="c-arrow-path-rounded-square" link="{{ route('menus.edit', $menu->id) }}"
            tooltip-left="{{ __('Edit') }}" class="btn-ghost btn-sm text-blue-500" spinner />
          <x-button icon="o-trash" wire:click="deleteMenu({{ $menu->id }})"
            wire:confirm="{{__('Are you sure to delete this menu?')}}" tooltip-left="{{ __('Delete') }}" spinner
            class="btn-ghost btn-sm text-red-500" />
      </x-slot:actions>
    </x-list-item>

    <x-collapse collapse-plus-minus no-icon class="ml-8">
      <x-slot:heading>
        <x-icon name="o-chevron-down" /><span class="text-sm pl-2">{{ __('Submenus') }}</span>
      </x-slot:heading>
      <x-slot:content>
        @foreach($menu->submenus as $submenu)
        <x-list-item :item="$menu" no-separator no-hover>
          <x-slot:value>
            {{ $submenu->label }}
          </x-slot:value>
          <x-slot:sub-value>
            {{ $submenu->link }}
          </x-slot:sub-value>
          <x-slot:actions>
            @if($submenu->order > 1)
            <x-button icon="s-chevron-up" wire:click="upSub({{ $submenu->id }})" tooltip-left="{{ __('Up') }}"
              spinner />
            @endif
            @if($submenu->order < $menu->submenus->count())
              <x-button icon="s-chevron-down" wire:click="downSub({{ $submenu->id }})" tooltip-left="{{ __('Down') }}"
                spinner />
              @endif
              <x-button icon="c-arrow-path-rounded-square" link="{{ route('submenus.edit', $submenu->id) }}"
                tooltip-left="{{ __('Edit') }}" class="btn-ghost btn-sm text-blue-500" spinner />
              <x-button icon="o-trash" wire:click="deleteSubmenu({{ $menu->id }}, {{ $submenu->id }})"
                wire:confirm="{{__('Are you sure to delete this submenu?')}}" tooltip-left="{{ __('Delete') }}" spinner
                class="btn-ghost btn-sm text-red-500" />
          </x-slot:actions>
        </x-list-item>
        @endforeach

        <br>

        <x-card class="" title="{{__('Create a new submenu')}}">

          <x-form wire:submit="saveSubmenu({{ $menu->id }})">
            <x-radio :options="$subOptions" wire:model="subOption" wire:change="$refresh" />
            @if($subOption == 1)
            <x-select label="{{__('Post')}}" option-label="title" :options="$posts"
              placeholder="{{__('Select a post')}}" wire:model="subPost" wire:change="$refresh" />
            @elseif($subOption == 2)
            <x-select label="{{__('Page')}}" option-label="title" :options="$pages"
              placeholder="{{__('Select a page')}}" wire:model="subPage" wire:change="$refresh" />
            @elseif($subOption == 3)
            <x-select label="{{__('Serie')}}" option-label="title" :options="$series"
              placeholder="{{__('Select a serie')}}" wire:model="subSerie" wire:change="$refresh" />
            @elseif($subOption == 4)
            <x-select label="{{__('Category')}}" option-label="title" :options="$categories"
              placeholder="{{__('Select a category')}}" wire:model="subCategory" wire:change="$refresh" />
            @endif
            <x-input label="{{__('Title')}}" wire:model="sublabel" />
            <x-input type="text" wire:model="sublink" label="{{ __('Link') }}" />
            <x-slot:actions>
              <x-button label="{{__('Save')}}" icon="o-paper-airplane" spinner="save" type="submit"
                class="btn-primary" />
            </x-slot:actions>
          </x-form>

        </x-card>
      </x-slot:content>
    </x-collapse>

    @endforeach

  </x-card>

  <br>

  <x-card class="" title="{{__('Create a new menu')}}">

    <x-form wire:submit="saveMenu">
      <x-input label="{{__('Title')}}" wire:model="label" />
      <x-input type="text" wire:model="link" label="{{ __('Link') }}" />
      <x-slot:actions>
        <x-button label="{{__('Save')}}" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary" />
      </x-slot:actions>
    </x-form>

  </x-card>
</div>
