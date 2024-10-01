<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024.
 */

use App\Models\{Category, Menu, Page, Post, Serie, Submenu};
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Attributes\{Layout, Validate, Title};
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new #[Title('Nav Menu'), Layout('components.layouts.admin')] 
class extends Component {
	use Toast;

	public Collection $menus;

	#[Validate('required|max:255|unique:menus,label')]
	public string $label = '';

	#[Validate('nullable|regex:/\/([a-z0-9_-]\/*)*[a-z0-9_-]*/')]
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
		$this->menus = Menu::with([
			'submenus' => function (Builder $query) {
				$query->orderBy('order');
			},
		])
			->orderBy('order')
			->get();
	}

	// Met à jour le libellé et le lien en fonction de la sous-option sélectionnée.
	public function updating($property, $value): void
	{
		if ($value === '') {
			return;
		}

		$modelMap = [
			'subPost' => ['model' => Post::class, 'route' => 'posts.show'],
			'subPage' => ['model' => Page::class, 'route' => 'pages.show'],
			'subSerie' => ['model' => Serie::class, 'route' => 'serie'],
			'subCategory' => ['model' => Category::class, 'route' => 'category'],
		];

		if (array_key_exists($property, $modelMap)) {
			$this->updateSubProperties($modelMap[$property], $value);
		} elseif ($property === 'subOption') {
			$this->resetSubProperties();
		}
	}
	
	private function updateSubProperties($modelInfo, $value): void
	{
		$model = $modelInfo['model']::find($value);
		if ($model) {
			$this->sublabel = $model->title;
			$this->sublink = $modelInfo['route'] === 'posts.show' || $modelInfo['route'] === 'pages.show'
				? route($modelInfo['route'], $model->slug)
				: url($modelInfo['route'] . '/' . $model->slug);
		}
	}

	private function resetSubProperties(): void
	{
		$this->sublabel = '';
		$this->sublink = '';
		$this->subPost = 0;
		$this->subPage = 0;
		$this->subSerie = 0;
		$this->subCategory = 0;
	}	

	// Méthode générique pour déplacer un élément (menu ou sous-menu)
	private function move($item, $direction, $isSubmenu = false): void
    {
        $operator = $direction === 'up' ? '<' : '>';
        $orderDirection = $direction === 'up' ? 'desc' : 'asc';
        
        $query = $isSubmenu 
            ? Submenu::where('menu_id', $item->menu_id)
            : Menu::query();

        $adjacentItem = $query->where('order', $operator, $item->order)
            ->orderBy('order', $orderDirection)
            ->first();

        if ($adjacentItem) {
            $this->swap($item, $adjacentItem);
        }
    }

    public function up(Menu $menu): void
    {
        $this->move($menu, 'up');
    }

    public function upSub(Submenu $submenu): void
    {
        $this->move($submenu, 'up', true);
    }

    public function down(Menu $menu): void
    {
        $this->move($menu, 'down');
    }

    public function downSub(Submenu $submenu): void
    {
        $this->move($submenu, 'down', true);
    }

    private function swap($item1, $item2): void
    {
        $tempOrder = $item1->order;
        $item1->order = $item2->order;
        $item2->order = $tempOrder;

        $item1->save();
        $item2->save();

        $this->getMenus();
    }

	// Méthode générique pour supprimer un élément (menu ou sous-menu)
    private function deleteItem($item, $parent = null): void
    {
        $isSubmenu = $parent !== null;
        
        //$item->delete();
        
        if ($isSubmenu) {
            $this->reorderItems($parent->submenus());
        } else {
            $this->reorderItems(Menu::query());
        }
        
        $this->getMenus();
        $this->success(__($isSubmenu ? 'Submenu' : 'Menu') . __(' deleted with success.'));
    }

    public function deleteMenu(Menu $menu): void
    {
        $this->deleteItem($menu);
    }

    public function deleteSubmenu(Menu $menu, Submenu $submenu): void
    {
        $this->deleteItem($submenu, $menu);
    }

    // Méthode générique pour réordonner les éléments
    private function reorderItems($query): void
    {
        $items = $query->orderBy('order')->get();
        foreach ($items as $index => $item) {
            $item->order = $index + 1;
            $item->save();
        }
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
			'sublink'  => 'required|regex:/\/([a-z0-9_-]\/*)*[a-z0-9_-]*/',
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
			'subOptions' => [['id' => 1, 'name' => __('Post')], ['id' => 2, 'name' => __('Page')], ['id' => 3, 'name' => __('Serie')], ['id' => 4, 'name' => __('Category')]],
		];
	}

}; ?>

<div>
    <x-header title="{{ __('Navigation') }}" separator progress-indicator>
        <x-slot:actions class="lg:hidden">
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>
    <x-card>
        @foreach ($menus as $menu)
            <x-list-item :item="$menu" no-separator no-hover>
                <x-slot:value>
                    {{ $menu->label }}
                </x-slot:value>
                <x-slot:sub-value>
                    @if ($menu->link)
                        {{ $menu->link }}
                    @else
                        @lang('Root menu')
                    @endif
                </x-slot:sub-value>
                <x-slot:actions>
                    @if ($menu->order > 1)
                        <x-popover>
                            <x-slot:trigger>
                                <x-button icon="s-chevron-up" wire:click="up({{ $menu->id }})" spinner />
                            </x-slot:trigger>
                            <x-slot:content class="pop-small">
                                @lang('Up')
                            </x-slot:content>
                        </x-popover>
                    @endif
                    @if ($menu->order < $menus->count())
                        <x-popover>
                            <x-slot:trigger>
                                <x-button icon="s-chevron-down" wire:click="down({{ $menu->id }})" spinner />
                            </x-slot:trigger>
                            <x-slot:content class="pop-small">
                                @lang('Down')
                            </x-slot:content>
                        </x-popover>
                    @endif
                    <x-popover>
                        <x-slot:trigger>
                            <x-button icon="c-arrow-path-rounded-square" link="{{ route('menus.edit', $menu->id) }}"
                                class="text-blue-500 btn-ghost btn-sm" spinner />
                        </x-slot:trigger>
                        <x-slot:content class="pop-small">
                            @lang('Edit')
                        </x-slot:content>
                    </x-popover>
                    <x-popover>
                        <x-slot:trigger>
                            <x-button icon="o-trash" wire:click="deleteMenu({{ $menu->id }})"
                                wire:confirm="{{ __('Are you sure to delete this menu?') }}" spinner
                                class="text-red-500 btn-ghost btn-sm" />
                        </x-slot:trigger>
                        <x-slot:content class="pop-small">
                            @lang('Delete')
                        </x-slot:content>
                    </x-popover>
                </x-slot:actions>
            </x-list-item>

            <x-collapse collapse-plus-minus no-icon class="ml-8">
                <x-slot:heading>
                    <x-icon name="o-chevron-down" /><span class="pl-2 text-sm">{{ __('Submenus') }}</span>
                </x-slot:heading>
                <x-slot:content>
                    @foreach ($menu->submenus as $submenu)
                        <x-list-item :item="$menu" no-separator no-hover>
                            <x-slot:value>
                                {{ $submenu->label }}
                            </x-slot:value>
                            <x-slot:sub-value>
                                {{ $submenu->link }}
                            </x-slot:sub-value>
                            <x-slot:actions>
                                @if ($submenu->order > 1)
									<x-popover>
										<x-slot:trigger>
											<x-button icon="s-chevron-up" wire:click="upSub({{ $submenu->id }})" spinner />
										</x-slot:trigger>
										<x-slot:content class="pop-small">
											@lang('Up')
										</x-slot:content>
									</x-popover>
                                @endif
                                @if ($submenu->order < $menu->submenus->count())
									<x-popover>
										<x-slot:trigger>
											<x-button icon="s-chevron-down" wire:click="downSub({{ $submenu->id }})" spinner />
										</x-slot:trigger>
										<x-slot:content class="pop-small">
											@lang('Down')
										</x-slot:content>
									</x-popover>
                                @endif
								<x-popover>
									<x-slot:trigger>
										<x-button icon="c-arrow-path-rounded-square" link="{{ route('submenus.edit', $submenu->id) }}"
											class="text-blue-500 btn-ghost btn-sm" spinner />
									</x-slot:trigger>
									<x-slot:content class="pop-small">
										@lang('Edit')
									</x-slot:content>
								</x-popover>
								<x-popover>
									<x-slot:trigger>
										<x-button icon="o-trash" wire:click="deleteSubmenu({{ $menu->id }}, {{ $submenu->id }})"
											wire:confirm="{{ __('Are you sure to delete this menu?') }}" spinner
											class="text-red-500 btn-ghost btn-sm" />
									</x-slot:trigger>
									<x-slot:content class="pop-small">
										@lang('Delete')
									</x-slot:content>
								</x-popover>                               
                            </x-slot:actions>
                        </x-list-item>
                    @endforeach

                    <br>

                    <x-card class="" title="{{ __('Create a new submenu') }}">

                        <x-form wire:submit="saveSubmenu({{ $menu->id }})">
                            <x-radio :options="$subOptions" wire:model="subOption" wire:change="$refresh" />
                            @if ($subOption == 1)
                                <x-select label="{{ __('Post') }}" option-label="title" :options="$posts"
                                    placeholder="{{ __('Select a post') }}" wire:model="subPost"
                                    wire:change="$refresh" />
                            @elseif($subOption == 2)
                                <x-select label="{{ __('Page') }}" option-label="title" :options="$pages"
                                    placeholder="{{ __('Select a page') }}" wire:model="subPage"
                                    wire:change="$refresh" />
                            @elseif($subOption == 3)
                                <x-select label="{{ __('Serie') }}" option-label="title" :options="$series"
                                    placeholder="{{ __('Select a serie') }}" wire:model="subSerie"
                                    wire:change="$refresh" />
                            @elseif($subOption == 4)
                                <x-select label="{{ __('Category') }}" option-label="title" :options="$categories"
                                    placeholder="{{ __('Select a category') }}" wire:model="subCategory"
                                    wire:change="$refresh" />
                            @endif
                            <x-input label="{{ __('Title') }}" wire:model="sublabel" />
                            <x-input type="text" wire:model="sublink" label="{{ __('Link') }}" />
                            <x-slot:actions>
                                <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save"
                                    type="submit" class="btn-primary" />
                            </x-slot:actions>
                        </x-form>

                    </x-card>
                </x-slot:content>
            </x-collapse>
        @endforeach

    </x-card>

    <br>

    <x-card class="" title="{{ __('Create a new menu') }}">

        <x-form wire:submit="saveMenu">
            <x-input label="{{ __('Title') }}" wire:model="label" />
            <x-input type="text" wire:model="link" label="{{ __('Link') }}" />
            <x-slot:actions>
                <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
                    class="btn-primary" />
            </x-slot:actions>
        </x-form>

    </x-card>
</div>
