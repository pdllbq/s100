<div class="card">
	<div class="card-header">{{ __('user.Groups') }} &commat;{{ $user->name }}</div>
	<div class="card-body">
		
		@if($userGroups->count()==0)
			<div class="text-center">{{ __('group.User doesn\'t have groups') }}</div>
		@endif
		
		@foreach($userGroups as $group)
			<?php
			$url=route('group.destroy',[app()->getLocale(),$group->slug]);
			?>
		<div class="side-menu-list"><a href="{{ route('group.show',[app()->getLocale(),$group->slug]) }}">{{ $group->name }}</a></div>
			@auth
				<div class="float-right"><div onclick="Group.edit('{{ route('group.store',[app()->getLocale(),$group->slug]) }}','#userGroupEditModal','{{ $group->name }}','{{ $group->description }}','{{ $group->slug }}','{{ $group->id }}')" class="fa fa-pencil btn-link cursor-pointer"></div> 
				<div onclick="Group.delete('{{ $url }}','{{ __('group.Delete group?') }}')" class="fa fa-trash btn-link cursor-pointer"></div></div>
			@endauth
		@endforeach
		

			@if(isset(\Auth::user()->id) && $user->id==\Auth::user()->id)
				<div class="btn btn-primary d-flex justify-content-center" data-toggle="modal" data-target="#userGroupMakeModal">{{ __('user.Make group') }}</div>
			@endif
	</div>
</div>

