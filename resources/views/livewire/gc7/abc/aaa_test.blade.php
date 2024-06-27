<?php
include_once 'aa_test.php';
?>

<div class="w-[98%]">

    @php
        //Appel direct au helper possible dans la Vue
        $frameworksLinks = getGc7FrameworksLinks();
        // dd($frameworksLinks);
    @endphp
    {{-- {{ dd($frameworksLinks) }} --}}
    <div class="mx-[-.75rem] mt-[-1rem]">
        <livewire:gc7.frameworks.livewire.serie7.03_offset />
    </div>

</div>
