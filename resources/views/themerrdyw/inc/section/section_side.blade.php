<div class="stui-pannel stui-pannel-bg clearfix">
    <div class="stui-pannel-box clearfix">
        <div class="col-lg-wide-75 col-xs-1 padding-0">
            <div class="stui-pannel_hd">
                <div class="stui-pannel__head clearfix"><a class="more text-muted pull-right"
                                                           href="{{$item['link']}}">Xem thêm <i
                            class="icon iconfont icon-more"></i></a>
                    <h3 class="title"><img src="{{ asset('/themes/rrdyw/statics/icon/icon_1.png') }}"><a
                            href="{{$item['link']}}">{{$item['label']}}</a></h3>
                </div>
            </div>
            <div class="stui-pannel_bd clearfix">
                <ul class="stui-vodlist clearfix">
                        @foreach ($item['data'] as $movie)
                            <li class="col-md-5 col-sm-4 col-xs-3">
                            @include('themes::themerrdyw.inc.section.movie_card')
                            </li>
                        @endforeach
                </ul>
            </div>
        </div>
        <div class="col-lg-wide-25 hidden-md hidden-sm hidden-xs">
            <div class="stui-pannel_hd">
                <div class="stui-pannel__head clearfix">
                    <h3 class="title"><img src="{{ asset('/themes/rrdyw/statics/icon/icon_23.png') }}">Xem
                        nhiều</h3></div>
            </div>
            <div class="stui-pannel_bd">
                <ul class="stui-vodlist__media active col-pd clearfix">
                    @foreach ($item['topview'] as $key => $movie)
                        @if($key +1 <4)
                            <li>
                                <div class="thumb"><a class="m-thumb stui-vodlist__thumb lazyload"
                                                      href="{{$movie->getUrl()}}" title="{{$movie->name}}"
                                                      data-original="{{$movie->getThumbUrl()}}"><span
                                            class="pic-tag pic-tag-h">{{$key+1}}</span></a></div>
                                <div class="detail detail-side">
                                    <h4 class="title"><a href="{{$movie->getUrl()}}"><i
                                                class="icon iconfont icon-more text-muted pull-right"></i> {{$movie->name}}</a>
                                    </h4>
                                    <p class="font-12">
                                        <span class="text-muted">Quốc gia： {!! $movie->regions->map(function ($region) {
                        return '<a href="' . $region->getUrl() . '" title="' . $region->name . '">' . $region->name . '</a>';
                    })->implode(', ') !!}</span>

                                    </p>
                                    <p class="font-12 margin-0">
                                        <span class="text-muted">Diễn viên：{!! $movie->actors->take(2)->map(function ($director) {
                        return '<a href="' . $director->getUrl() . '" title="' . $director->name . '">' . $director->name . '</a>';
                    })->implode(', ') !!}</span>

                                    </p>
                                </div>
                            </li>
                        @else
                            <li><a href="{{$movie->getUrl()}}" title="{{$movie->name}}"><span
                                        class="text-muted pull-right">{{ $movie->quality }}</span><span class="badge">{{$key+1}}</span>{{$movie->name}}</a>
                            </li>
                            @endif
                    @endforeach


                </ul>

            </div>
        </div>
    </div>
</div>
