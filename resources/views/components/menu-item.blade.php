{{--        @if($hasSub == '')--}}
{{--            <li class="sidebar-item {{$hasSub ? 'has-sub' : ''}} {{URL::current() == $link ||  Request::segments(1)[0] == explode("/", $link)[3] || in_array(URL::current(), Arr::flatten($subMenu)) || in_array(Request::segments()[0].'.index', Arr::flatten($subMenu)) ? 'active' : ''}}">--}}
{{--        @else--}}
{{--            <li class="sidebar-item {{$hasSub ? 'has-sub' : ''}} {{URL::current()==$link || in_array(URL::current(), Arr::flatten($subMenu)) ||in_array(Request::segments()[0], Arr::flatten($subMenu)) ? 'active' : ''}}">--}}
{{--        @endif--}}

@if($hasSub == '')
    <li class="sidebar-item {{$hasSub ? 'has-sub' : ''}} {{URL::current() == $link || Request::segments(1)[0] == explode("/", $link)[3] || in_array(URL::current(), Arr::flatten($subMenu)) || in_array(Request::segments()[0].'.index', Arr::flatten($subMenu)) ? 'active' : ''}}">
@else
    <li class="sidebar-item {{$hasSub ? 'has-sub' : ''}} {{URL::current() == $link || in_array(URL::current(), Arr::flatten($subMenu)) || in_array(Request::segments()[0].'.index', Arr::flatten($subMenu)) == true ? 'active' : ''}}"
        id="{{URL::current() == $link || in_array(URL::current(), Arr::flatten($subMenu)) || in_array(Request::segments()[0].'.index', Arr::flatten($subMenu)) == true ? 'active-menu' : ''}}">
        @endif
        <a href="{{ $link }}" class="sidebar-link" style="color: white">
            <i class="icon-color" data-feather="{{ $sideIcon }}"></i>
            {{ $title }}
        </a>
        @if($hasSub)
            @foreach($subMenu as $menu)

                @if(array_intersect(array($menu['permission']),Session::get('permissionTitle')) == array($menu['permission']))
                    @if(Request::segments(1)[count(Request::segments(1))-1] == "create")
                        @if(in_array(URL::current(), Arr::flatten($subMenu)) == true)
                            <ul class="submenu {{ $menu['link'] == URL::current()  ? 'submenu-active' : ''}}">
                                <li>
                                    <a href="{{url($menu['link'])}}">{{$menu['title']}}</a>
                                </li>

                            </ul>
                        @else
                            <ul class="submenu {{ (Str::contains($menu['link'].'/', Request::segments(1)[0].'/')) ? 'submenu-active' : ''}}">
                                <li>
                                    <a href="{{url($menu['link'])}}">{{$menu['title']}}</a>
                                </li>
                            </ul>
                        @endif
                    @else
                        <ul class="submenu {{ (Str::contains($menu['link'].'/', Request::segments(1)[0].'/')) == true && explode('/',$menu['link'])[count(explode('/',$menu['link']))-1] != "create"  ? 'submenu-active' : ''}}">
                            <li>
                                <a href="{{url($menu['link'])}}">{{$menu['title']}}</a>
                            </li>
                        </ul>
                    @endif
                @endif
            @endforeach
        @endif
    </li>
