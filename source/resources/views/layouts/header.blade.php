<div class="header">
    <div class="navbar navbar-expand-lg container custom-nav">
        <a class="navbar-brand" href="/" title="{{trans('b2c.header.menu.glamer_clinic')}}"><img
                src="/b2c-assets/img/logo.png" width="170px"
                title="{{trans('b2c.header.menu.glamer_clinic')}}"
                alt="{{trans('b2c.header.menu.glamer_clinic')}}" /></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars" style="color:#d9a434"></i>
        </button>
        @php
        $lang = Session::get('locale');
        @endphp
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                @foreach($menuInfos as $menu)
                @if(count($menu['subMenus'])==0)
                <li class="nav-item">
                    <a class="nav-link @if(\Request::path()==$menu->url)
                                active
                            @endif " href="{{ url("$menu->url") }}">{{$menu->name}}<span
                            class="sr-only">(current)</span></a>
                </li>
                @else
                <li class="nav-item">
                    <div class="dropdown">
                        <a class="dropdown-toggle nav-link" href="{{ url("$menu->url") }}" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{$menu->name}}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            @foreach($menu['subMenus'] as $sub_menu)
                            <a class="dropdown-item" href="{{url("$sub_menu->url")}}">{{$sub_menu->sub_menu_name}}</a>
                            @endforeach
                        </div>
                    </div>
                </li>
                @endif
                @endforeach
                <li class="nav-item">
                    @if($lang=='vi')
                    <a class="nav-link active" href="{{url('/languages/en')}}"
                        title="VIE-{{trans('b2c.header.menu.glamer_clinic')}}">VIE
                        <i class="fas fa-sync-alt"></i>
                    </a>
                    @endif
                    @if($lang=='en')
                    <a class="nav-link active" href="{{url('/languages/vi')}}"
                        title="ENG-{{trans('b2c.header.menu.glamer_clinic')}}">ENG
                        <i class="fas fa-sync-alt"></i>
                    </a>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</div>


<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>

<script>
    function logout(event) {
        event.preventDefault();
        $('#logout-form').submit();
    }
</script>
