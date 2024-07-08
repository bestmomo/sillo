<?php
include_once 'test.php';
?>

<div>

    <x-header title="Test" shadow separator progress-indicator></x-header>

    <div x-init="console.log('ok')" x-data="{
        count: 10
    }">

        <div x-data="console.log('Go avec count = ' + count + ' !')">
            <div    
                    x-init="console.log('Init Go avec count = ' + count + '!')"
                    x-data="{ count: count*2 }" 
                    x-init="console.log('After Init Go avec count = ' + count + '!')">

                <strong x-text="count"></strong>
                <x-button class='btn-primary ml-3' x-on:click="count++">Add</x-button>

                <div x-effect="console.log('Count is '+count)"></div>
                <div x-init="$watch('count', value => {
                    console.log('New count is ' + value)
                    console.log('New count2 is ' + value)
                })">Mis en log</div>
                
                Nest: <strong x-text="count"></strong>


                <div x-init="count = getCount()">
                    After function: : <strong x-text="count"></strong>
                </div>
            </div>

            Final: <strong x-text="count"></strong>
            <script>
                function getCount() {
                    return 25;
                }
            </script>
        </div>



    </div>

</div>
