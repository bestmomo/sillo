 <?php
 include_once 'create-post.php';
 ?>

 <div>
     <h2 class="text-lg mb-3">New Post</h2>

     <form wire:submit="save">
         @error('title') Attention: <em>{{ $message }}</em><br> @enderror

         <label for="title">
             <span>Title</span>
             <x-input type="text" wire:model='title'></x-input>
         </label>

         <label for="content">
             <span>Content</span>
             <x-textarea name="" id="" cols="30" rows="7" wire:model='content'></x-textarea>
         </label>

         <div class="text-right w-full">
             <x-button type="submit" class="btn-primary mt-2 mr-5">Save</x-button>
         </div>
     </form>
 </div>
