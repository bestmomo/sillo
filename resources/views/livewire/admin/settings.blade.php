<?php

use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Artisan;
use Livewire\Attributes\{Layout, Rule};
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new #[Title('Settings')] #[Layout('components.layouts.admin')] class extends Component {
	use Toast;

	private const SETTINGS_KEYS = ['pagination', 'excerptSize', 'title', 'subTitle', 'flash', 'newPost'];

	#[Rule('required|max:30')]
	public string $title;

	#[Rule('required|max:50')]
	public string $subTitle;

	#[Rule('required|integer|between:2,12')]
	public int $pagination;

	#[Rule('required|integer|between:30,60')]
	public int $excerptSize;

	#[Rule('required|integer|between:1,8')]
	public int $newPost;

	#[Rule('max:1000')]
	public string $flash;

	public bool $maintenance = false;
	public Collection $settings;

	public function mount(): void
	{
		$this->settings = Setting::all();

		$this->maintenance = App::isDownForMaintenance();

		foreach (self::SETTINGS_KEYS as $key) {
			$this->{$key} = $this->settings->where('key', $key)->first()->value ?? null;
		}
	}

	public function updatedMaintenance(): void
	{
		if ($this->maintenance) {
			Artisan::call('down', ['--secret' => env('APP_MAINTENANCE_SECRET')]);
		} else {
			Artisan::call('up');
		}
	}

	public function save()
	{
		$data = $this->validate();

		DB::transaction(function () use ($data) {
			foreach (self::SETTINGS_KEYS as $key) {
				$setting = $this->settings->where('key', $key)->first();
				if ($setting) {
					$setting->value = $data[$key];
					$setting->save();
				}
			}
		});

		$this->success(__('Settings updated successfully!'));
	}
};

?>

<div>
    <x-header title="{{ __('Settings') }}" separator progress-indicator>
        <x-slot:actions>
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>
    <x-card>
        <x-card separator class="mb-6 border-4 {{ $maintenance ? 'bg-red-300' : 'bg-zinc-100' }} border-zinc-950">
            <div class="flex items-center justify-between">
                <x-toggle label="{{ __('Maintenance mode') }}" wire:model="maintenance" wire:change="$refresh" />
                @if($maintenance)
                    <x-button label="{{ __('Go to bypass page')}}" link="/{{ env('APP_MAINTENANCE_SECRET') }}"  />
                @endif
            </div>
        </x-card>
        <x-form wire:submit="save">
            <x-card separator class="border-4 bg-zinc-100 border-zinc-950">
                <x-input label="{{ __('Site title') }}" wire:model="title" />
                <br>
                <x-input label="{{ __('Site sub title') }}" wire:model="subTitle" />
            </x-card>
            <x-card separator class="border-4 bg-zinc-100 border-zinc-950">
                <x-range min="2" max="12" wire:model="pagination" label="{!! __('Home pagination') !!}"
                    hint="{{ __('Between 2 and 12.') }}" class="range-info" wire:change="$refresh" />
                <x-badge value="{{ $pagination }}" class="my-2 badge-neutral" />
            </x-card>
            <x-card separator class="border-4 bg-zinc-100 border-zinc-950">
                <x-range min="30" max="60" step="5" wire:model="excerptSize"
                    label="{!! __('Post excerpt (number of words)') !!}" hint="{{ __('Between 30 and 60.') }}" class="range-info"
                    wire:change="$refresh" />
                <x-badge value="{{ $excerptSize }}" class="my-2 badge-neutral" />
            </x-card>
            <x-card separator class="border-4 bg-zinc-100 border-zinc-950">
                <x-range min="1" max="8" step="1" wire:model="newPost"
                    label="{!! __('Number of weeks a post is marked new') !!}" hint="{{ __('Between 1 and 8.') }}" class="range-info"
                    wire:change="$refresh" />
                <x-badge value="{{ $newPost }}" class="my-2 badge-neutral" />
            </x-card>
            <x-card separator class="border-4 bg-zinc-100 border-zinc-950">
                <x-editor wire:model="flash" label="{{ __('Flash message') }}" :config="config('tinymce.config')"
                    folder="{{ 'photos/' . now()->format('Y/m') }}" />
            </x-card>
            <x-slot:actions>
                <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
                    class="btn-primary" />
            </x-slot:actions>
        </x-form>

    </x-card>
</div>
