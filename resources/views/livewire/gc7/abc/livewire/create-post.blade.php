 <?php
 include_once 'create-post.php';
 ?>

 <div>
     <x-header title="New Post" shadow separator progress-indicator>
     </x-header>
     {{ env('APP_MAX_NUMBER_OF_CHARS_IN_COMMENTS_FORM') }}

     Current title: <span x-text="$wire.title.toUpperCase()"></span>

     @php
         $contentLength = strlen($content);
         $maxChars = env('APP_MAX_NUMBER_OF_CHARS_IN_COMMENTS_FORM');
         $messageKey = $contentLength >= $maxChars ? 'All chars used :m' : 'Chars2 used: :n :m';
     @endphp

     <form wire:submit="save">
         @error('title')
             Attention: <em>{{ $message }}</em><br>
         @enderror

         <label for="title">
             <span>Title</span>
             <x-input class="mt-1 mb-2" type="text" wire:model='title'></x-input>
         </label>

         <label for="content">
             <span>Content</span>
             <x-textarea class="mt-1" name="" id="" cols="30" rows="7"
                 wire:model.live='content' maxlength="{{ $maxChars }}"></x-textarea>
         </label>
         <span
             x-text="'{{ trans_choice($messageKey, $contentLength, ['n' => $contentLength, 'm' => $maxChars]) }}'"></span>

         <div class="text-right w-full>
             <x-button type="submit" class="btn-primary mt-2 mr-5">
             Save</x-button>
         </div>
     </form>
 </div>
