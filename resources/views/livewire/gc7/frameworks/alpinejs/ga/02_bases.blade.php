<div>

    @section('styles')
        <style>
            {{ file_get_contents(resource_path('views\\livewire\\gc7\\frameworks\\alpinejs\\ga\\02_css.css')) }}
        </style>
    @endsection

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Alpine.data("tabs", (defaultTab) => ({
                tab: defaultTab,
                toggleTab(e) {
                    this.tab = e.target.id;
                    console.log('tab active: ' + this.tab)
                    console.log(this.isActive(this.tab));
                },
                isActive(tab) {
                    return this.tab === tab;
                },
            }));

        });
    </script>


    <div x-data="tabs('tab1')">

        <p x-text="tab"></p>

        <div role="tablist" class="tabs tabs-lifted mt-3 border-b border-orange-400">

            <button id='tab1' type="radio" role="tab"
                class="tab brdb0 [--tab-border-color:orange-400] border-orange-400 font-bold text-orange-400" @click="toggleTab($event)" :class="{ 'tab-active': isActive('tab1')}">Tab 1</button>

            <button id='tab2' type="radio" role="tab"
                class="tab brdb0 [--tab-border-color:orange-400] border-orange-400 font-bold text-orange-400" @click="toggleTab($event)" :class="{ 'tab-active': isActive('tab2')}">Tab 2</button>

            <button id='tab3' type="radio" role="tab"
                class="tab brdb0 [--tab-border-color:orange-400] border-orange-400 font-bold text-orange-400"@click="toggleTab($event)" :class="{ 'tab-active': isActive('tab3')}">Tab 3</button>
        </div>

        <div>

            <template x-if="isActive('tab1')">
                <div role="tabpanel" class="border-base-300 rounded-box p-6">Tab content 1
                </div>
            </template>

            <template x-if="isActive('tab2')">
                <div role="tabpanel" class="border-base-300 rounded-box p-6">
                    <h2>Onglet 2</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique, libero saepe exercitationem
                        ducimus dicta cumque nemo, ab esse itaque deleniti sunt atque sequi repudiandae, architecto
                        alias repellendus consequuntur ipsam pariatur.</p>
                </div>
            </template>

            <template x-if="isActive('tab3')">
                <div role="tabpanel" class="border-orange-400 rounded-box p-6 text-justify">
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

    {{-- @section('scripts')
        <script src="/assets/js/ga/02_app.js"></script>
    @endsection --}}
</div>
