<div id="header" class="header navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="{{ route('dashboard.index') }}" class="navbar-brand"><span class="navbar-logo"></span>
                {{ config('app.name') }}</a>
            <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                @switch(app()->getLocale())
                    @case('id')
                        <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle f-s-12">
                            <img src="{{ asset('img/id.png') }}" alt="" width="18px" />
                            {{ strtoupper(app()->getLocale()) }}
                        </a>
                    @break
                    @case('en')
                        <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle f-s-12">
                            <img src="{{ asset('img/en.png') }}" alt="" width="22px" />
                            {{ strtoupper(app()->getLocale()) }}
                        </a>
                    @break
                    @default
                @endswitch

                <ul class="dropdown-menu media-list pull-right animated fadeInDown">
                    <li class="dropdown">
                        <a href="{{ route('localization.switch', ['language' => 'id']) }}"><img
                                src="{{ asset('img/id.png') }}" alt="" width="22px" />
                            {{ trans('localization.id') }}</a>
                    </li>
                    <li class="dropdown">
                        <a href="{{ route('localization.switch', ['language' => 'en']) }}"><img
                                src="{{ asset('img/en.png') }}" alt="" width="22px" />
                            {{ trans('localization.en') }}</a>
                    </li>
                </ul>

            </li>

            <li class="dropdown navbar-user">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                    @if (auth()->user()->foto != null)
                        <img src="{{ asset('storage/img/foto/' . auth()->user()->foto) }}" alt="Avatar"
                            class="img-fluid rounded" style="width: 30px; height: 30px; object-fit: cover;">
                    @else
                        <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim(auth()->user()->email))) }}&s=30"
                            alt="Avatar" class="img-fluid rounded"
                            style="width: 30px; height: 30px; object-fit: cover;">
                    @endif
                    <span class="hidden-xs">{{ Auth::user()->name }}</span> <b class="caret"></b>
                </a>
                <ul class="dropdown-menu animated fadeInLeft">
                    <li class="arrow"></li>
                    <li>
                        <a href="{{ route('profile.index') }}">{{ trans('dashboard.link.profile') }}</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            {{ trans('dashboard.link.logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
