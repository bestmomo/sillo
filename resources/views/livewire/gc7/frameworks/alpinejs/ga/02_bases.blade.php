<div>

    @section('styles')
        <style>
            {{ file_get_contents(resource_path('views\\livewire\\gc7\\frameworks\\alpinejs\\ga\\02_css.css')) }}
        </style>
    @endsection

    <script>
        // document.addEventListener("DOMContentLoaded", () => {
        document.addEventListener("alpine:init", () => {

            Alpine.data('tabs', (defaultTab) => ({
                tab: defaultTab,
                toggleTab(e) {
                    this.tab = e.target.id;
                    console.log('tab active: ' + this.tab)
                    console.log(this.isActive(this.tab))
                },
                isActive(tab) {
                    return this.tab === tab;
                },
            }))

            Alpine.store('posts', {
                loading: false,
                posts: [],
                loaded: false,
                loadPosts() {
                    this.loading = true
                    setTimeout(() => {

                        fetch('https://jsonplaceholder.typicode.com/posts?_limit=4')
                            .then(response => response.json())
                            .then(data => {
                                this.posts = data;
                                this.loaded = true;
                                this.loading = false;
                            });

                    }, 3000);
                }
            })

            Alpine.data('posts', () => ({
                init() {
                    console.log('Start Posts page');
                }
            }))

        });
        // });
    </script>


    <div x-data="tabs('tab2')">

        <p x-text="tab"></p>

        <div role="tablist" class="tabs tabs-lifted mt-3 border-b border-orange-400">

            <button id='tab1' type="radio" role="tab"
                class="tab brdb0 [--tab-border-color:orange-400] border-orange-400 font-bold text-orange-400"
                @click="toggleTab($event)" :class="{ 'glass': isActive('tab1'), 'tab-active': isActive('tab1') }">Tab
                1</button>

            <button id='tab2' type="radio" role="tab"
                class="tab brdb0 [--tab-border-color:orange-400] border-orange-400 font-bold text-orange-400"
                @click="toggleTab($event)" :class="{ 'glass': isActive('tab2'), 'tab-active': isActive('tab2') }">Tab
                2</button>

            <button id='tab3' type="radio" role="tab"
                class="tab brdb0 [--tab-border-color:orange-400] border-orange-400 font-bold text-orange-400"@click="toggleTab($event)"
                :class="{ 'glass': isActive('tab3'), 'tab-active': isActive('tab3') }">Tab 3</button>
        </div>

        <div class="bg-gray-700 glass rounded-b-box mt-3 text-white text-black text-justify">

            <template x-if="isActive('tab1')">
                <div role="tabpanel" class="p-6">
                    <h2>Tab content 1</h2>
                    <p @click="tab='tab3'" class="link">Aller à l'onglet 3</p>
                </div>
            </template>

            <template x-if="isActive('tab2')">

                <div role="tabpanel" class="p-6">
                    <h2>Tab 2</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique, libero saepe exercitationem:
                    </p>
                    
                    <div x-data="posts()">

                        <p x-show="!$store.posts.loaded"><button class="btn primary"
                                :disabled="$store.posts.loading"loading" @click="$store.posts.loadPosts()">Charger les
                                articles</button></p>

                        <div x-show="$store.posts.loading" x-transition.duration.1000ms class="spinner text-center">
                            <span class="loading loading-spinner loading-lg"></span></div>

                        <template x-for="post in $store.posts.posts" :key="post.id">
                            <article class="card w-full my-3">
                                <div class="card-body border rounded-box">
                                    <h3 x-text="post.title" class="text-xl">T</h3>
                                    <p x-text="post.body"></p>
                                </div>
                            </article>
                        </template>

                    </div>
                </div>
            </template>

            <template x-if="isActive('tab3')">
                <div role="tabpanel" class="p-6">
                    <h2>Onglet 3</h2>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Repellendus assumenda harum doloribus
                        ea
                        illum,
                        neque nam velit a enim saepe quos, fuga necessitatibus, ut minus? Alias sunt laudantium dolorem
                        quibusdam.</p>
                </div>
            </template>

        </div>
    </div>

</div>
