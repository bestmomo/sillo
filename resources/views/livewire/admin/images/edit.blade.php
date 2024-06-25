<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;
use App\Models\{ Post, Page };
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;
use Mary\Traits\Toast;

new 
#[Layout('components.layouts.auth')]
class extends Component {

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
    public array $selectValues = [
        ['id' => '1', 'name' => '1'],
        ['id' => '0.95', 'name' => '0.95'],
        ['id' => '0.9', 'name' => '0.9'],
        ['id' => '0.85', 'name' => '0.85'],
        ['id' => '0.8', 'name' => '0.8'],
    ];
    public string $group;
    public int $brightness = 0;
    public int $contrast = 0;
    public int $gamma = 10;
    public int $red = 0;
    public int $green = 0;
    public int $blue = 0;
    public int $blur = 0;
    public int $sharpen = 0;  

    // Méthode de montage du composant
    public function mount($year, $month, $id): void
    {
        $this->year = $year;
        $this->month = $month;
        $this->id = $id;
        $this->getImage($year, $month, $id);
        $this->usage = $this->findUsage();
        $this->getImageInfos();
        $this->saveImageToTemp(false);
    }

    public function saveImageToTemp($viewToast): void
    {
        $tempDir = Storage::path('public/temp');
        $tempPath = $tempDir . '/' . $this->fileName;

        // Vérification que le répertoire temporaire existe, sinon on le crée
        if (!File::exists($tempDir)) {
            File::makeDirectory($tempDir, 0755, true);
        }

        // Copier l'image dans le répertoire temporaire
        if (File::exists($this->imagePath)) {
            File::copy($this->imagePath, $tempPath);
        } 
        
        if($viewToast) $this->success(__('Changes validated'));
    }

    public function restoreImage($cancel): void
    {
        $tempPath = Storage::path('public/temp/' . $this->fileName);

        if (File::exists($tempPath)) {
            File::copy($tempPath, $this->imagePath);
            $this->refreshImageUrl();
        }

        if($cancel) $this->exit();
    }

    public function updated($property, $value)
    {                
        $manager = new ImageManager(new Driver());
        $image = $manager->read($this->imagePath);

        switch ($property) {
            case 'imageScale':
                if($value == '1') return;
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
        $this->refreshImageUrl();
    }

    private function getImageInfos(): void
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($this->imagePath);
        $this->width = $image->width();
        $this->height = $image->height();
    }

    public function getImage($year, $month, $id)
    {
        $imagesPath = "public/photos/{$year}/{$month}";
        $allFiles = Storage::files($imagesPath);
        $image = $allFiles[$id];
        $this->imagePath = Storage::path($image);
        $this->fileName = basename($this->imagePath);
        $this->image = Storage::url($image);
        $this->displayImage = $this->image;
        $this->refreshImageUrl();
    }

    private function findUsage(): array
    {
        $usage = [];

        // Check in posts
        $posts = Post::select('id', 'title', 'slug')
                    ->where('image', 'LIKE', "%$this->fileName%")
                    ->orWhere('body', 'LIKE', "%$this->fileName%")
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
        $pages = Page::where('body', 'LIKE', "%$this->fileName%")->get();

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
        $this->image = $this->image . '?' . now()->timestamp;
    }

    public function exit(): void
    {
        $tempPath = Storage::path('public/temp/' . $this->fileName);

        if (File::exists($tempPath)) {
            File::delete($tempPath);
        }

        redirect()->route('images.index');
    }

}; ?>

<div class="flex flex-col lg:flex-row h-full">

    <div class="w-full lg:w-3/4 p-4">
        <x-card title="{{ __('Manage an image') }}" shadow separator progress-indicator>
            <div class="flex justify-between items-center h-full">
                <p>@lang('The url of this image is :') <i>{{ $this->displayImage }}</i></p>
                <x-button 
                    label="{!! __('Copy url') !!}" 
                    data-url="{{ $image }}"
                    onclick="copyUrl(this)"
                    class="btn-sm" />
            </div>
            <br>
            @if(empty($this->usage))
                <x-badge value="{!!__('This image is not used')!!}" class="badge-warning" />
            @else
                @foreach($this->usage as $use)
                    @if($use['type'] == 'post')
                        <p>@lang('This image is in the post ') : <a href="{{ route('posts.show', $use['slug']) }}" target="_blank">{{ $use['title'] }}</a></p>
                    @else
                        <p>@lang('This image is in the page ') : <a href="{{ route('pages.show', $use['slug']) }}" target="_blank">{{ $use['title'] }}</a></p>
                    @endif
                @endforeach
            @endif
            <br>

            <br><br>
            <div class="flex justify-center items-center h-full">
                <img src="{{ $image }}" alt="">
            </div>

        </x-card>
    </div>

    <div class="w-full lg:w-1/4 p-4">
        <p class="text-3xl mb-2">@lang('Settings')</p>
        <x-accordion wire:model="group" class="shadow-md">
            <x-collapse name="group1">
                <x-slot:heading>
                    @lang('Size change')
                </x-slot:heading>
                <x-slot:content>
                    @lang('Height') : <x-badge value="{{ $this->height }}px" class="badge-primary" /><br>
                    @lang('Width') : <x-badge value="{{ $this->width }}px" class="badge-primary" /><br><br>
                    <x-radio 
                        inline
                        label="{{ __('Select a rescale value')}}" 
                        :options="$selectValues"                
                        wire:model="imageScale"
                        wire:change="$refresh" />
                </x-slot:content>
            </x-collapse>
            <x-collapse name="group2">
                <x-slot:heading>
                    @lang('Brightness, contrast and gamma correction')
                </x-slot:heading>
                <x-slot:content>
                    <x-range
                        wire:model.live.debounce="brightness"
                        min="-20"
                        max="20"
                        step="2"
                        label="{{__('Brightness')}}"
                        class="range-primary" />
                    <x-range
                        wire:model.live.debounce="contrast"
                        min="-20"
                        max="20"
                        step="2"
                        label="{{__('Contrast')}}"
                        class="range-primary" />
                    <x-range
                        wire:model.live.debounce="gamma"
                        min="5"
                        max="22"
                        label="{{__('Gamma Correction')}}"
                        class="range-primary" />
                </x-slot:content>
            </x-collapse>
            <x-collapse name="group3">
                <x-slot:heading>
                    @lang('Color correction')
                </x-slot:heading>
                <x-slot:content>
                    <x-range
                        wire:model.live.debounce="red"
                        min="-20"
                        max="20"
                        step="2"
                        label="{{__('Red')}}"
                        class="range-primary" />
                    <x-range
                        wire:model.live.debounce="green"
                        min="-20"
                        max="20"
                        step="2"
                        label="{{__('Green')}}"
                        class="range-primary" />
                    <x-range
                        wire:model.live.debounce="blue"
                        min="-20"
                        max="20"
                        step="2"
                        label="{{__('Blue')}}"
                        class="range-primary" />
                </x-slot:content>
            </x-collapse>
            <x-collapse name="group4">
                <x-slot:heading>
                    @lang('Blur and sharpen')
                </x-slot:heading>
                <x-slot:content>
                    <x-range
                        wire:model.live.debounce="blur"
                        min="0"
                        max="20"
                        step="2"
                        label="{{__('Blur')}}"
                        class="range-primary" />
                    <x-range
                        wire:model.live.debounce="sharpen"
                        min="0"
                        max="20"
                        step="2"
                        label="{{__('Sharpen')}}"
                        class="range-primary" />
                </x-slot:content>
            </x-collapse>
        </x-accordion>
        <x-button wire:click="restoreImage(false)" class="btn-sm mt-4">@lang('Restore image to its original state')</x-button><br>
        <x-button wire:click="saveImageToTemp(true)" class="btn-sm mt-2">@lang('Valid changes')</x-button><br>
        <x-button wire:click="exit" class="btn-sm mt-2">@lang('Finish and keep this version')</x-button><br>
        <x-button wire:click="restoreImage(true)" class="btn-sm mt-2">@lang('Finish and discard this version')</x-button>
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
