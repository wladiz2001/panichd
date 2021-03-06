<li class="nav-item {!! $n_notices == 0 ? 'disabled' : ($tools->fullUrlIs(route($setting->grab('main_route').'.notices')) ? 'active' : '') !!}" >
	<a class="nav-link" href="{{ $n_notices == 0 ? '#' : route($setting->grab('main_route').'.notices') }}" title="{{ $n_notices == 0 ? trans('panichd::lang.ticket-notices-empty') : trans('panichd::lang.nav-notices-number-title', ['num' => $n_notices]) }}">{{ trans('panichd::lang.ticket-notices-title') }} <span class="badge">{{ $n_notices }}</span></a>
</li>

@if($u->canViewNewTickets())
	<li class="nav-item dropdown {!! $tools->fullUrlIs(action('\PanicHD\PanicHD\Controllers\TicketsController@indexNewest')) || $tools->fullUrlIs(action('\PanicHD\PanicHD\Controllers\TicketsController@create')) || (isset($ticket) && $ticket->isNew()) ? "active" : "" !!}">
		<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" title="{{ trans('panichd::lang.nav-new-tickets-title') }}">
			<span>{{ trans('panichd::lang.nav-new-tickets') }}</span>

			<span class="badge" style="cursor: help">
				{{ PanicHD\PanicHD\Models\Ticket::newest()->visible()->count() }}
			</span>
		</a>
		<ul class="dropdown-menu">
			<a class="dropdown-item {!! $tools->fullUrlIs(action('\PanicHD\PanicHD\Controllers\TicketsController@indexNewest').'*') ? "active" : "" !!}" href="{{ action('\PanicHD\PanicHD\Controllers\TicketsController@indexNewest') }}" title="{{ trans('panichd::lang.nav-new-dd-list-title') }}">{{ trans('panichd::lang.nav-new-dd-list') }}</a>
			<a class="dropdown-item {!! $tools->fullUrlIs(action('\PanicHD\PanicHD\Controllers\TicketsController@create').'*') ? "active" : "" !!}" href="{{ action('\PanicHD\PanicHD\Controllers\TicketsController@create') }}" title="{{ trans('panichd::lang.nav-create-ticket-title') }}">{{ trans('panichd::lang.nav-new-dd-create') }}</a>
		</ul>
	</li>
@else
	<li class="nav-item {!! $tools->fullUrlIs(action('\PanicHD\PanicHD\Controllers\TicketsController@create')) ? "active" : "" !!}">
		<a class="nav-link" href="{{ action('\PanicHD\PanicHD\Controllers\TicketsController@create') }}" title="{{ trans('panichd::lang.nav-create-ticket-title') }}">
		<span>{{ trans('panichd::lang.nav-create-ticket') }}</span>
		</a>
	</li>
@endif

<li class="nav-item {!! $tools->fullUrlIs(action('\PanicHD\PanicHD\Controllers\TicketsController@index')) || (isset($ticket) && $ticket->isActive()) ? "active" : "" !!}">
	<a class="nav-link" href="{{ action('\PanicHD\PanicHD\Controllers\TicketsController@index') }}" title="{{ trans('panichd::lang.nav-active-tickets-title') }}">
		<span>{{ trans('panichd::lang.active-tickets-adjective') }}</span>

		<span class="badge" style="cursor: help">
			{{ PanicHD\PanicHD\Models\Ticket::active()->visible()->count() }}
		</span>
	</a>
</li>
<li class="nav-item {!! $tools->fullUrlIs(action('\PanicHD\PanicHD\Controllers\TicketsController@indexComplete')) || (isset($ticket) && $ticket->isComplete()) ? "active" : "" !!}">
	<a class="nav-link" href="{{ action('\PanicHD\PanicHD\Controllers\TicketsController@indexComplete') }}" title="{{ trans('panichd::lang.nav-completed-tickets-title') }}">
		<span>{{ trans('panichd::lang.complete-tickets-adjective') }}</span>

		<span class="badge" style="cursor: help">
			{{ PanicHD\PanicHD\Models\Ticket::visible()->completedOnYear()->count() }}
		</span>
	</a>
</li>

@if($u->isAdmin())

	<li class="nav-item dropdown {!!
		$tools->fullUrlIs(action('\PanicHD\PanicHD\Controllers\DashboardController@index').'*') ||
		$tools->fullUrlIs(action('\PanicHD\PanicHD\Controllers\StatusesController@index').'*') ||
		$tools->fullUrlIs(action('\PanicHD\PanicHD\Controllers\PrioritiesController@index').'*') ||
		$tools->fullUrlIs(action('\PanicHD\PanicHD\Controllers\AgentsController@index').'*') ||
		$tools->fullUrlIs(action('\PanicHD\PanicHD\Controllers\MembersController@index').'*') ||
		$tools->fullUrlIs(action('\PanicHD\PanicHD\Controllers\CategoriesController@index').'*') ||
		$tools->fullUrlIs(action('\PanicHD\PanicHD\Controllers\NoticesController@index').'*') ||
		$tools->fullUrlIs(action('\PanicHD\PanicHD\Controllers\ConfigurationsController@index').'*') ||
		$tools->fullUrlIs(action('\PanicHD\PanicHD\Controllers\AdministratorsController@index').'*')
		? "active" : "" !!}">

		<a class="nav-link" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" title="{{ trans('panichd::admin.nav-settings') }}">
			<span>{{ $setting->grab('admin_button_text') }}</span>
		</a>

		@include('panichd::shared.nav_dropdown')
	</li>
@endif