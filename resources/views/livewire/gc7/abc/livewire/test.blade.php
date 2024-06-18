<?php
include_once 'test.php';
?>

<div>

    <x-header title="Test" shadow separator progress-indicator></x-header>

    <div x-init="console.log('ok')" x-data="{
        count: 10
    }">

        <div x-data="console.log('Go avec count = ' + count + '!')">
            <div x-data="{ count: 15 }" x-init="console.log('Init Go avec count = ' + count + '!')">

                <strong x-text="count"></strong>
                <x-button class='btn-primary ml-3' x-on:click="count++">Add</x-button>

                <div x-effect="console.log('Count is '+count)"></div>
                <div x-init="$watch('count', value => {
                    console.log('New count is ' + value)
                    console.log('New count2 is ' + value)
                })">Mis en log</div>
            </div>


        </div>



    </div>

</div>
