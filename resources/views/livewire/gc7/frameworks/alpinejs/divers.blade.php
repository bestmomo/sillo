<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

// Src: https://www.youtube.com/watch?v=rW3xVeMtBa8&list=PLKbhw6n2iYKhVSp9wAOPFcdD6EDlfDxQt&index=9

new #[Title('Divers')] #[Layout('components.layouts.gc7.main')] class extends Component {}; ?>

<div>
    <x-header title="Divers" shadow separator progress-indicator></x-header>

    <h1>Drag and drop file upload</h1>

    <div x-data="fileUpload()" class="my-5 mx-auto w-3/4">

        <input type="file" @change="handleFileUpload" class="hidden" x-ref="fileInput" accept="images/*">

        <div x-show="!imageUrl" class="border-2 border-dashed broder-gray-300 rounded-lg p-4 text-center cursor-pointer"
            @click="$refs.fileInput.click()" @dragover.prevent="dragover=true" @dragleave.prevent="dragover=false"
            @drop.prevent="handleDrop" :class="{ 'border-blue-500': dragover }">
            <p x-show="!imageUrl">Drag and Drop you image here / Select image</p>
        </div>

        <div x-show="imageUrl" class="mt-4" x-transition.duration.1500ms>
            <img :src="imageUrl" class="w-96 rounded-md" alt="tof">
            <button @click="removeImage" class="mt-2 bg-red-500 text-white px-4 py-2 rounded-md"
                x-transition.duration.1500ms>Remove
                Image</button>
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

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.imageUrl = e.target.result;
                    }
                    reader.readAsDataURL(file);

                    this.saveImage(file);
                },

                saveImage(file) {
                    // Envoyer le fichier au serveur
                    const formData = new FormData();
                    formData.append('image', file);

                    fetch('/upload-image', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log('Image enregistrée sur le serveur:', data.url);
                                // Optionnel : mettre à jour l'URL de l'image avec celle du serveur
                                // this.imageUrl = data.url;
                            } else {
                                console.error('Erreur lors de l\'enregistrement de l\'image sur le serveur');
                            }
                        })
                        .catch(error => {
                            console.error('Erreur:', error);
                        });
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
