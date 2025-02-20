<?php

use Livewire\Attributes\{Layout, Title};
use Livewire\Volt\Component;

new #[Layout('components.layouts.academy')] class extends Component {};
?>

<div class="w-full h-screen">
    <livewire:academy.components.page-title title='Divers' />
    <x-header shadow separator progress-indicator />

    <div class="border-0 border-white">
        <p>Ready.</p>
        <hr>
        <div class="text-justify mt-2 mr-2 space-y-5">

            <div class="my-5 border px-5 py-4 rounded-b-xl mx-3">
                <h2 class="text-lg text-white">Quelques commandes usuelles :</h2>
                php artisan optimize<br>
                php artisan view:clear<br>
                php artisan cache:clear<br>
                php artisan route:clear<br>
                php artisan config:clear<br>

                composer dump-autoload<br>
                composer dump-autoload & php artisan migrate:refresh --seed
            </div>

            <hr>
            
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ullam veniam blanditiis rem
                recusandae laudantium aspernatur nesciunt? Dolorem corporis blanditiis perspiciatis, vel error cum odit
                cumque, rerum nam voluptate aspernatur quas temporibus excepturi iste id ratione iusto? Aliquam eius
                iure, inventore incidunt praesentium rem impedit reiciendis consequatur enim possimus veritatis quae.
            </p>

            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos, nulla adipisci
                exercitationem beatae voluptates debitis, suscipit voluptate hic, perferendis vero doloribus.
                Consectetur quia possimus laudantium eius totam aut praesentium alias perferendis repellendus nihil! Id
                libero incidunt accusamus tenetur ratione ipsum porro cupiditate sapiente praesentium, eaque
                reprehenderit quis! Deserunt, ipsam tempore.</p>

            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam, voluptatem beatae unde
                excepturi ad voluptatibus incidunt repellat? Corrupti harum neque dolore reprehenderit, magnam autem
                nesciunt nihil explicabo, quis, eos recusandae cum nemo nam amet officiis voluptatem ratione laudantium
                excepturi? Rerum eos non, qui deleniti neque commodi at error perspiciatis voluptatum!</p>
        </div>
    </div>

</div>
