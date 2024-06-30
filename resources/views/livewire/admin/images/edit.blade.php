<?php

/**
 * (ɔ) LARAVEL.Sillo.org - 2015-2024
 */

use App\Models\Page;
use App\Models\Post;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new #[Title('Edit Image'), Layout('components.layouts.admin')] class extends Component {
    use Toast;

    public int $year;
    public int $month;
    public int $id;
    public string $image;
    public string $displayImage;
    public array $usage;
    public string $fileName;
    public string $imagePath;
    public string $tempPath;
    public int $width;
    public int $height;
    public string $imageScale = '1';
    public array $selectValues = [['id' => '1', 'name' => '1'], ['id' => '0.95', 'name' => '0.95'], ['id' => '0.9', 'name' => '0.9'], ['id' => '0.85', 'name' => '0.85'], ['id' => '0.8', 'name' => '0.8']];
    public string $group;
    public int $brightness = 0;
    public int $contrast = 0;
    public int $gamma = 10;
    public int $red = 0;
    public int $green = 0;
    public int $blue = 0;
    public int $blur = 0;
    public int $sharpen = 0;
    public bool $changed;

    // Méthode de montage du composant
    public function mount($year, $month, $id): void
    {
        $this->year = $year;
        $this->month = $month;
        $this->id = $id;
        $this->getImage($year, $month, $id);
        $this->usage = $this->findUsage();
        $this->saveImageToTemp(false);
        $this->getImageInfos();
    }

    public function saveImageToTemp($viewToast): void
    {
        $tempDir = Storage::path('public/temp');
        $this->tempPath = $tempDir . '/' . $this->fileName;

        // Vérification que le répertoire temporaire existe, sinon on le crée
        if (!File::exists($tempDir)) {
            File::makeDirectory($tempDir, 0o755, true);
        }

        // Copier l'image dans le répertoire temporaire
        if (File::exists($this->imagePath)) {
            File::copy($this->imagePath, $this->tempPath);
        }

        if ($viewToast) {
            $this->success(__('Changes validated'));
        }

        $this->image = Storage::url('public/temp/' . $this->fileName);
    }

    public function restoreImage($cancel): void
    {
        if (File::exists($this->imagePath)) {
            File::copy($this->imagePath, $this->tempPath);
            $this->refreshImageUrl();
            $this->success(__('Image restored'));
        }

        $this->changed = false;

        if ($cancel) {
            $this->info(__('No modification has been made'));
            $this->exit();
        }
    }

    public function updated($property, $value)
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($this->tempPath);

        switch ($property) {
            case 'imageScale':
                if ('1' == $value) {
                    return;
                }
                $image->scale(height: $this->height * $value);
                $image->save();
                $this->width = $image->width();
                $this->height = $image->height();
                $this->imageScale = '1';

                break;
            case 'brightness':
                $image->brightness($value);
                $image->save();
                $this->brightness = 0;

                break;
            case 'contrast':
                $image->contrast($value);
                $image->save();
                $this->contrast = 0;

                break;
            case 'gamma':
                $image->gamma($value / 10.0);
                $image->save();
                $this->gamma = 10;

                break;
            case 'red':
                $image->colorize(red: $value);
                $image->save();
                $this->red = 0;

                break;
            case 'green':
                $image->colorize(green: $value);
                $image->save();
                $this->green = 0;

                break;
            case 'blue':
                $image->colorize(blue: $value);
                $image->save();
                $this->blue = 0;

                break;
            case 'blur':
                $image->blur($value);
                $image->save();
                $this->blur = 0;

                break;
            case 'sharpen':
                $image->sharpen($value);
                $image->save();
                $this->sharpen = 0;

                break;
        }
        $this->info(__('Image modified ! (Not saved yet)'));
        $this->changed = true;
        $this->refreshImageUrl();
    }

    public function getImage($year, $month, $id)
    {
        $imagesPath = "public/photos/{$year}/{$month}";
        $allFiles = Storage::files($imagesPath);
        $image = $allFiles[$id];
        $this->imagePath = Storage::path($image);
        $this->fileName = basename($this->imagePath);
        $this->image = Storage::url('public/temp/' . $this->fileName);
        $this->displayImage = Storage::url($image);
        $this->refreshImageUrl();
    }

    public function keepVersion(): void
    {
        if (File::exists($this->tempPath)) {
            File::copy($this->tempPath, $this->imagePath);
        }
        $this->success(__('Image changes applied successfully'));
        $this->exit();
    }

    public function exit(): void
    {
        if (File::exists($this->tempPath)) {
            File::delete($this->tempPath);
        }

        redirect()->route('images.index');
    }

    public function applyChanges(): void
    {
        if (File::exists($this->tempPath)) {
            File::copy($this->tempPath, $this->imagePath);
        }

        $this->changed = false;

        $this->success(__('Image changes applied successfully'));
    }

    private function getImageInfos(): void
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($this->tempPath);
        $this->width = $image->width();
        $this->height = $image->height();
    }

    private function findUsage(): array
    {
        $usage = [];

        // Check in posts
        $posts = Post::select('id', 'title', 'slug')
            ->where('image', 'LIKE', "%{$this->fileName}%")
            ->orWhere('body', 'LIKE', "%{$this->fileName}%")
            ->get();

        foreach ($posts as $post) {
            $usage[] = [
                'type' => 'post',
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
            ];
        }

        // Check in pages
        $pages = Page::where('body', 'LIKE', "%{$this->fileName}%")->get();

        foreach ($pages as $page) {
            $usage[] = [
                'type' => 'page',
                'id' => $page->id,
                'title' => $page->title,
            ];
        }

        return $usage;
    }

    private function refreshImageUrl(): void
    {
        $this->image = Storage::url('public/temp/' . $this->fileName) . '?' . now()->timestamp;
    }
}; ?>

<div class="flex flex-col h-full lg:flex-row">

    <div class="w-full p-4 lg:w-3/4">
        <x-card title="{{ __('Manage an image') }}" shadow separator progress-indicator>
            <div class="flex items-center justify-between h-full">
                <p>@lang('The url of this image is :') <i>{{ $this->displayImage }}</i></p>
                <x-button label="{!! __('Copy url') !!}" data-url="{{ $this->displayImage }}" onclick="copyUrl(this)"
                    class="btn-sm" />
            </div>
            <br>
            @if (empty($this->usage))
                <x-badge value="{!! __('This image is not used') !!}" class="badge-warning" />
            @else
                @foreach ($this->usage as $use)
                    @if ($use['type'] == 'post')
                        <p>@lang('This image is in the post ') : <a href="{{ route('posts.show', $use['slug']) }}"
                                target="_blank">{{ $use['title'] }}</a></p>
                    @else
                        <p>@lang('This image is in the page ') : <a href="{{ route('pages.show', $use['slug']) }}"
                                target="_blank">{{ $use['title'] }}</a></p>
                    @endif
                @endforeach
            @endif
            <br>

            <br><br>
            <div class="flex items-center justify-center h-full">
                <img src="{{ $image }}" alt="">
            </div>

        </x-card>
    </div>

    <div class="w-full p-4 lg:w-1/4">
        <x-header shadow separator progress-indicator></x-header>

        <p class="mb-2 text-3xl">@lang('Settings')</p>
        <x-accordion wire:model="group" class="mb-4 shadow-md">
            <x-collapse name="group1">
                <x-slot:heading>
                    @lang('Size change')
                </x-slot:heading>
                <x-slot:content>
                    @lang('Height') :
                    <x-badge value="{{ $this->height }}px" class="badge-primary" /><br>
                    @lang('Width') :
                    <x-badge value="{{ $this->width }}px" class="badge-primary" /><br><br>
                    <x-radio inline label="{{ __('Select a rescale value') }}" :options="$selectValues"
                        wire:model="imageScale" wire:change="$refresh" />
                </x-slot:content>
            </x-collapse>
            <x-collapse name="group2">
                <x-slot:heading>
                    @lang('Brightness, contrast and gamma correction')
                </x-slot:heading>
                <x-slot:content>
                    <x-range wire:model.live.debounce="brightness" min="-20" max="20" step="2"
                        label="{{ __('Brightness') }}" class="range-primary" />
                    <x-range wire:model.live.debounce="contrast" min="-20" max="20" step="2"
                        label="{{ __('Contrast') }}" class="range-primary" />
                    <x-range wire:model.live.debounce="gamma" min="5" max="22"
                        label="{{ __('Gamma Correction') }}" class="range-primary" />
                </x-slot:content>
            </x-collapse>
            <x-collapse name="group3">
                <x-slot:heading>
                    @lang('Color correction')
                </x-slot:heading>
                <x-slot:content>
                    <x-range wire:model.live.debounce="red" min="-20" max="20" step="2"
                        label="{{ __('Red') }}" class="range-primary" />
                    <x-range wire:model.live.debounce="green" min="-20" max="20" step="2"
                        label="{{ __('Green') }}" class="range-primary" />
                    <x-range wire:model.live.debounce="blue" min="-20" max="20" step="2"
                        label="{{ __('Blue') }}" class="range-primary" />
                </x-slot:content>
            </x-collapse>
            <x-collapse name="group4">
                <x-slot:heading>
                    @lang('Blur and sharpen')
                </x-slot:heading>
                <x-slot:content>
                    <x-range wire:model.live.debounce="blur" min="0" max="20" step="2"
                        label="{{ __('Blur') }}" class="range-primary" />
                    <x-range wire:model.live.debounce="sharpen" min="0" max="20" step="2"
                        label="{{ __('Sharpen') }}" class="range-primary" />
                </x-slot:content>
            </x-collapse>
        </x-accordion>
        @if($changed)
            <x-button wire:click="restoreImage(false)" class="btn-sm">@lang('Restore image to its original state')
            </x-button><br>
            <x-button wire:click="applyChanges" class="mt-2 btn-sm">@lang('Valid changes')</x-button><br>        
            <x-button wire:click="restoreImage(true)" class="mt-2 btn-sm">@lang('Finish and discard this version')</x-button>
        @endif
        <x-button wire:click="keepVersion" class="mt-2 btn-sm">@lang('Finish and keep this version')</x-button><br>
    </div>

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
