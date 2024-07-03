<?php
include_once 'chat-v2.php';
?>

<div>
  <h1>V 2</h1>
  <ul>
    @foreach ($conversation as $thread)
    <li>{{ $thread['username'] }}: {{ $thread['message'] }}</li>
    @endforeach
  </ul>

  @php
  $sendIconColor = 'greenyellow';
  @endphp

  <form class="mt-2" wire:submit="submitMessage">
    <x-input wire:model="message" />
    <button class="btn btn-outline btn-primary my-3" type="submit">
      Send
      <x-icon-send color="{{ $sendIconColor }}" />
    </button>
  </form>

</div>
