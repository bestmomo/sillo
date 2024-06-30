<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

// Src: https://www.youtube.com/watch?v=rW3xVeMtBa8&list=PLKbhw6n2iYKhVSp9wAOPFcdD6EDlfDxQt&index=9

new #[Title('Divers')] #[Layout('components.layouts.gc7.main')] class extends Component {}; ?>

<div>
    <x-header title="Divers" shadow separator progress-indicator></x-header>

    <p id="p1" @click="console.log($event.target)">Ready.</p>

    <div class="container mx-auto max-w-xl bg-white p-4 mt-10 rounded-md">
        <h1 class="text-center font-bold text-xl md:text-4xl my-10">
            Drag and drop file upload
        </h1>
        <div class="my-5">

            <div x-data="fileUpload()" class="max-w-ful mx-auto">
                <input type="file" @change="handleFileUpload" class="hidden" x-ref="fileInput" accept="images/*">


                <div 
                x-show="!imageUrl"
                class="border-2 border-dashed broder-gray-300 rounded-lg p-4 text-center cursor-pointer"
                @click="$refs.fileInput.click()"
                @dragover.prevent="dragover=true"
                @dragleave.prevent="dragover=false"
                @drop.prevent="handleDrop"
                :class="{'border-blue-500' : dragover}"
                >
                <p x-show="!imageUrl" class="text-gray-500">Drag and Drop you image here / select image</p>
                </div>

                <div x-show="imageUrl" class="mt-4">
                    <img :src="imageUrl" class="w-full reounded-md" alt="">
                    <button @click="removeImage" class="mt-2 bg-red-500 text-white px-4 py-2 rounded-md">Remove Image</button>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>

        function fileUpload() {
            return {
                dragover: false,
                imageUrl: null,

                handleFileUpload(event) {
                    const file = event.target.files[0];
                    this.uploadFile(file);
                },

                uploadFile(file) {
                    if (!file || !file.type.startsWith('image/')) return;

                    const render = new FileReader();
                    render.onload = (e) => {
                        this.imageUrl = e.target.result;
                    }
                    render.readAsDataURL(file);
                },

                handleDrop(event) {
                    this.dragover = false;
                    const file = event.dataTransfer.files[0];
                    this.uploadFile(file);
                },

                removeImage() {
                    this.imageUrl = null;
                    this.$refs.fileInput.value = null;
                }
            }
        }
    </script>
@endsection

{{-- //2see https://pqina.nl/filepond/#multi-file-code --}}

{{-- //2see https://codepen.io/rikschennink/pen/WXavEx --}}

</div>
