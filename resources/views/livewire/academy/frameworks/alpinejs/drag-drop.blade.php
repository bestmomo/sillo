<?php

use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;

// Src: https://www.youtube.com/watch?v=rW3xVeMtBa8&list=PLKbhw6n2iYKhVSp9wAOPFcdD6EDlfDxQt&index=9

// Autre src: Multifiles Drag And Drop
// https://pqina.nl/filepond/#multi-file-code → https://codepen.io/rikschennink/pen/WXavEx

new #[Title('Divers')] #[Layout('components.layouts.academy')] class extends Component {
}; ?>

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


                <div x-show="!imageUrl"
                    class="border-2 border-dashed broder-gray-300 rounded-lg p-4 text-center cursor-pointer"
                    @click="$refs.fileInput.click()" @dragover.prevent="dragover=true"
                    @dragleave.prevent="dragover=false" @drop.prevent="handleDrop"
                    :class="{ 'border-blue-500': dragover }">
                    <p x-show="!imageUrl" class="text-gray-500">Drag and Drop you image here / select image</p>
                </div>

                <div x-show="imageUrl" class="mt-4">
                    <img :src="imageUrl" class="w-full reounded-md" alt="">
                    <button @click="removeImage" class="mt-2 bg-red-500 text-white px-4 py-2 rounded-md">Remove
                        Image</button>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        
        dev = <?php echo json_encode(app()->environment()); ?> == 'local'
        
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

                    if(dev) this.saveImage(file);
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

</div>
