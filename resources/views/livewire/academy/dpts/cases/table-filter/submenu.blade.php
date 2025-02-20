<x-nav sticky full-width class='flex flex-wrap'>

    <x-slot:brand>
		<div><a href="{{ route('admin.tests') }}" title=" {{ __('Test page') }} "> {{ __('Tests') }}Tests</div>
	</x-slot:brand>

	{{-- Right side actions --}}
<x-slot:actions class='flex flex-wrap'>

		<x-button label="Messages" icon="o-envelope" link="###" class="btn-ghost btn-sm" responsive/>
		<x-button label="Notification1s" icon="o-bell" link="###" class="btn-ghost btn-sm" responsive/>
		<x-button label="Notifications2" icon="o-bell" link="###" class="btn-ghost btn-sm" responsive/>
		<x-button label="Notifications3" icon="o-bell" link="###" class="btn-ghost btn-sm" responsive/>
		<x-button label="Notifications4" icon="o-bell" link="###" class="btn-ghost btn-sm" responsive/>
		<x-button label="Notifications5" icon="o-bell" link="###" class="btn-ghost btn-sm" responsive/>
		<x-button label="Notifications6" icon="o-bell" link="###" class="btn-ghost btn-sm" responsive/>
		<x-button label="Notifications7" icon="o-bell" link="###" class="btn-ghost btn-sm" responsive/>
	</x-slot:actions>
</x-nav>
