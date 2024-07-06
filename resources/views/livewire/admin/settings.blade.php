<?php

use App\Models\Setting;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\Attributes\Layout;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Rule;

new #[Title('Settings')] #[Layout('components.layouts.admin')] class extends Component {
    use Toast;

    #[Rule('required|max:30')]
    public string $title;

    #[Rule('required|max:50')]
    public string $subTitle;

    #[Rule('required|integer|between:2,12')]
    public int $pagination;

    #[Rule('required|integer|between:30,60')]
    public int $excerptSize;

    #[Rule('required|max:500')]
    public string $flash;

    public Collection $settings;

    private const SETTINGS_KEYS = ['pagination', 'excerptSize', 'title', 'subTitle', 'flash'];

    public function mount(): void
    {
        $this->settings = Setting::all();

        foreach (self::SETTINGS_KEYS as $key) {
            $this->$key = $this->settings->where('key', $key)->first()->value ?? null;
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
    <x-header title="{{ __('Settings') }}" separator progress-indicator />

    <x-card>
        <x-form wire:submit="save">
            <x-input label="{{ __('Site title') }}" wire:model="title" />
            <br>
            <x-input label="{{ __('Site sub title') }}" wire:model="subTitle" />
            <br><br>
            <x-range min="2" max="12" wire:model="pagination" label="{!! __('Home pagination') !!}"
                hint="{{ __('Between 2 and 12.') }}" class="range-info" wire:change="$refresh" />
            <x-badge value="{{ $pagination }}" class="my-2 badge-neutral" />
            <br><br>
            <x-range min="30" max="60" step="5" wire:model="excerptSize"
                label="{!! __('Post excerpt (number of words)') !!}" hint="{{ __('Between 30 and 60.') }}" class="range-info"
                wire:change="$refresh" />
            <x-badge value="{{ $excerptSize }}" class="my-2 badge-neutral" />
            <br>
            <x-textarea label="{{ __('Flash message') }}" wire:model="flash"
                hint="{{ __('Max 500 chars. Leave it empty to not show a message.') }}" rows="2" inline />
            <x-slot:actions>
                <x-button label="{{ __('Save') }}" icon="o-paper-airplane" spinner="save" type="submit"
                    class="btn-primary" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
