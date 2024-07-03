<?php
include_once 'chat-v1.php';
?>

<div>
  <p class="w-1/4 flex justify-between items-center">N.B.:
    <x-icon-student color="#f22" />
    <x-icon-smiley />
  </p>
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
