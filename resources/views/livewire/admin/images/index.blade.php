<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024.
 */

use App\Models\{Page, Post};
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

new #[Title('Images')] #[Layout('components.layouts.admin')] class extends Component {
    use Toast;
    use WithPagination;

    public array $allImages = [];
    public Collection $years;
    public Collection $months;
    public string $selectedYear;
    public string $selectedMonth;
    public int $perPage = 4;
    public int $page = 1;

    // Définir les en-têtes de table.
    public function headers(): array
    {
        return [['key' => 'url', 'label' => ''], ['key' => 'path', 'label' => __('Path')], ['key' => 'usage', 'label' => __('Used')]];
    }

    public function mount(): void
    {
        $this->years = $this->getYears();
        $this->months = $this->getMonths($this->selectedYear);
        $this->getImages();
    }

    public function updating($property, $value): void
    {
        if ('selectedYear' == $property) {
            $this->months = $this->getMonths($value);
        }
    }

    public function getImages(): LengthAwarePaginator
    {
        $imagesPath = "public/photos/{$this->selectedYear}/{$this->selectedMonth}";
        $allFiles = Storage::files($imagesPath);

        $this->allImages = collect($allFiles)
            ->map(function ($file) {
                return [
                    'path' => $file,
                    'url' => Storage::url($file),
                    'usage' => $this->imageIsUsed($file),
                ];
            })
            ->toArray();

        // Pagination logic
        $this->page = LengthAwarePaginator::resolveCurrentPage('page');
        $total = count($this->allImages);
        $images = array_slice($this->allImages, ($this->page - 1) * $this->perPage, $this->perPage, true);

        return new LengthAwarePaginator($images, $total, $this->perPage, $this->page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);
    }

    public function deleteImage($index): void
    {
        // Récupérer le chemin de l'image
        $path = $this->allImages[$index]['path'];

        // Supprimer l'image
        Storage::delete($path);

        $this->success(__('Image deleted with success.'));
        $this->getImages();
    }

    public function with(): array
    {
        return [
            'headers' => $this->headers(),
            'images' => $this->getImages(),
        ];
    }

    private function getYears(): Collection
    {
        $basePath = 'public/photos';
        $yearDirectories = Storage::directories($basePath);

        $years = collect($yearDirectories)->map(function ($yearPath) {
            $year = basename($yearPath);

            return ['id' => $year, 'name' => $year];
        });

        $this->selectedYear = $years->first()['id'];

        return $years;
    }

    private function getMonths($year): Collection
    {
        $basePath = "public/photos/{$year}";
        $monthDirectories = Storage::directories($basePath);

        $months = collect($monthDirectories)->map(function ($monthPath) {
            $month = basename($monthPath);

            return ['id' => $month, 'name' => $month];
        });

        $this->selectedMonth = $months->first()['id'];

        $this->getImages();

        return $months;
    }

    private function imageIsUsed(string $file): bool
    {
        $fileName = basename($file);

        // Check in posts
        if (
            Post::where('image', 'LIKE', "%{$fileName}%")
                ->orWhere('body', 'LIKE', "%{$fileName}%")
                ->count()
        ) {
            return true;
        }

        // Check in pages
        if (Page::where('body', 'LIKE', "%{$fileName}%")->count()) {
            return true;
        }

        return false;
    }
}; ?>

<div>
    <x-header title="{{ __('Images') }}" separator progress-indicator>
        <x-slot:actions class="lg:hidden">
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>

    <x-card title="{!! __('Select year and month') !!}" class="shadow-md">
        <x-select label="{{ __('Year') }}" :options="$years" wire:model="selectedYear" wire:change="$refresh" />
        <br>
        <x-select label="{{ __('Month') }}" :options="$months" wire:model="selectedMonth" wire:change="$refresh" />
    </x-card>

    <x-card>
        <x-table striped :headers="$headers" :rows="$images" with-pagination>
            @scope('cell_url', $image)
                <img src="{{ $image['url'] }}" width="100" alt="">
            @endscope
            @scope('cell_usage', $image)
                @if ($image['usage'])
                    <x-icon name="o-check-circle" />
                @endif
            @endscope
            @scope('actions', $image, $selectedYear, $selectedMonth, $perPage, $page, $loop)
                <div class="flex gap-2">
                    <x-popover>
                        <x-slot:trigger>
                            <x-button icon="s-briefcase" data-url="{{ $image['url'] }}" onclick="copyUrl(this)"
                                class="text-blue-500 btn-ghost btn-sm" spinner />
                        </x-slot:trigger>
                        <x-slot:content class="pop-small">
                            @lang('Copy url')
                        </x-slot:content>
                    </x-popover>
                    <x-popover>
                        <x-slot:trigger>
                            <x-button icon="c-wrench"
                                link="{{ route('images.edit', ['year' => $selectedYear, 'month' => $selectedMonth, 'id' => $loop->index + ($page - 1) * $perPage]) }}"
                                class="text-blue-500 btn-ghost btn-sm" spinner />
                        </x-slot:trigger>
                        <x-slot:content class="pop-small">
                            @lang('Manage image')
                        </x-slot:content>
                    </x-popover>
                    <x-popover>
                        <x-slot:trigger>
                            <x-button icon="o-trash" wire:click="deleteImage({{ $loop->index }})"
                                wire:confirm="{{ __('Are you sure to delete this image?') }}" spinner
                                class="text-red-500 btn-ghost btn-sm" />
                        </x-slot:trigger>
                        <x-slot:content class="pop-small">
                            @lang('Delete image')
                        </x-slot:content>
                    </x-popover>
                </div>
            @endscope
        </x-table>
    </x-card>
    <script>
        function copyUrl(button) {
            const url = button.getAttribute('data-url');
            const textArea = document.createElement('textarea');
            textArea.value = url;
            document.body.appendChild(textArea);
            textArea.select();
            try {
                document.execCommand('copy');
                alert('URL copiée: ' + url);
            } catch (err) {
                console.error('Erreur lors de la copie de l\'URL: ', err);
            }
            document.body.removeChild(textArea);
        }
    </script>

</div>
