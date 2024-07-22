@extends('themes::themerrdyw.layout')
@php
    $watch_url = '';
    if (!$currentMovie->is_copyright && count($currentMovie->episodes) && $currentMovie->episodes[0]['link'] != '') {
        $watch_url = $currentMovie->episodes
            ->sortBy([['server', 'asc']])
            ->groupBy('server')
            ->first()
            ->sortByDesc('name', SORT_NATURAL)
            ->groupBy('name')
            ->last()
            ->sortByDesc('type')
            ->first()
            ->getUrl();
    }
@endphp

@section('content')
    <div class="row">
        @if ($currentMovie->notify || $currentMovie->showtimes)
        <div class="stui-pannel stui-pannel-bg clearfix">
            <div class="stui-pannel-box clearfix">
                <div class="stui-pannel_hd">
                    @if ($currentMovie->showtimes)
                        <p><strong>Lịch chiếu : </strong> {{$currentMovie->showtimes}}</p>
                    @endif
                    @if ($currentMovie->notify )
                        <p><strong>Thông báo : </strong> {{$currentMovie->notify}}</p>
                    @endif
                </div>
            </div>
        </div>
        @endif
        <div class="stui-pannel stui-pannel-bg clearfix">
            <div class="stui-pannel-box clearfix">
                <div class="stui-pannel_bd clearfix">
                    <div class="col-md-wide-75 col-xs-1">
                        <div class="stui-content clearfix">
                            <div class="stui-content__thumb"><a class="stui-vodlist__thumb v-thumb lazyload"
                                                                href="{{ $watch_url }}"
                                                                title="{{ $currentMovie->name }}"
                                                                data-original="{{ $currentMovie->getThumbUrl() }}"
                                                                style="background-image: url({{ $currentMovie->getThumbUrl() }});"><span
                                        class="play active hidden-xs"></span><span
                                        class="pic-text text-right">{{$currentMovie->getStatus()}}</span></a></div>
                            <div class="stui-content__detail">
                                <h3 class="title">{{ $currentMovie->name }}</h3>
                                <p class="data"><span class="text-muted">Năm ：</span>{{ $currentMovie->publish_year }}</p>
                                <p class="data"><span class="text-muted">Đạo diễn ：</span>{!! $currentMovie->directors->map(function ($director) {
                        return '<a href="' . $director->getUrl() . '" title="' . $director->name . '">' . $director->name . '</a>';
                    })->implode(', ') !!}
                                </p>
                                <p class="data"><span class="text-muted">Diễn viên：</span>{!! $currentMovie->actors->map(function ($director) {
                        return '<a href="' . $director->getUrl() . '" title="' . $director->name . '">' . $director->name . '</a>';
                    })->implode(', ') !!}</p>

                                <p class="data"><span class="text-muted">Quốc gia：</span> {!! $currentMovie->regions->map(function ($region) {
                        return '<a href="' . $region->getUrl() . '" title="' . $region->name . '">' . $region->name . '</a>';
                    })->implode(', ') !!}</p>
                                <p class="data"><span class="text-muted">Thời lượng ：</span> {{$currentMovie->episode_time}}</p>
                                <p class="desc detail hidden-xs"><span class="left text-muted">Nội dung：</span><span
                                        class="detail-sketch">　 {!! strip_tags($currentMovie->content) !!}</span></p>
                                <div class="play-btn clearfix">
                                    @if($watch_url)
                                    <a class="btn btn-primary" href="{{ $watch_url }}">Xem phim</a>
                                    @endif

                                        @if ($currentMovie->trailer_url && strpos($currentMovie->trailer_url, 'youtube'))
                                            @php
                                                parse_str( parse_url( $currentMovie->trailer_url, PHP_URL_QUERY ), $my_array_of_vars );
                                                $video_id = $my_array_of_vars['v'] ?? null;
                                            @endphp

                                            <a class="btn btn-primary fancybox fancybox.iframe"
                                               href="https://www.youtube.com/embed/{{$video_id}}">Trailer</a>
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-wide-25 hidden-md hidden-sm hidden-xs">
                        <div class="text-center" style="padding: 15px;margin-top: 50px">
                            <div class="rating-content">
                                <div id="movies-rating-star" style="height: 18px;"></div>
                                <div style="margin-top: 5px">
                                    ({{$currentMovie->getRatingStar()}}
                                    sao
                                    /
                                    {{$currentMovie->getRatingCount()}} đánh giá)
                                </div>
                                <div id="movies-rating-msg"></div>
                            </div>
                            <div style="margin-top: 20px">
                                <p class="font-12">Đánh giá</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="stui-pannel stui-pannel-bg clearfix">
            <div class="stui-pannel-box">
                <div class="stui-pannel_hd">
                    <div class="stui-pannel__head bottom-line active clearfix">
                        <h3 class="title"><img src="{{ asset('/themes/rrdyw/statics/icon/icon_23.png') }}"
                                               alt="404">Bình luận</h3></div>
                </div>
                <div class="stui-pannel_bd col-pd clearfix">
                    <div style="width: 100%; background-color: #fff;margin-top: 10px">
                        <div class="fb-comments w-full" data-href="{{ $currentMovie->getUrl() }}" data-width="100%"
                             data-numposts="5" data-colorscheme="light" data-lazy="true">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="stui-pannel stui-pannel-bg clearfix">
            <div class="stui-pannel-box">
                <div class="stui-pannel_hd">
                    <div class="stui-pannel__head clearfix">
                        <h3 class="title">
                            <img src="{{ asset('/themes/rrdyw/statics/icon/icon_6.png') }}">Có thể bạn thích
                        </h3>
                    </div>
                </div>
                <div class="stui-pannel_bd">
                    <ul class="stui-vodlist__bd clearfix">
                            @foreach ($movie_related as $movie)
                                <li class="col-md-6 col-sm-4 col-xs-3">
                                @include('themes::themerrdyw.inc.section.movie_card')
                                </li>
                            @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('/themes/rrdyw/plugins/jquery-raty/jquery.raty.js') }}"></script>
        <link href="{{ asset('/themes/rrdyw/plugins/jquery-raty/jquery.raty.css') }}" rel="stylesheet" type="text/css" />
        <script>
            var rated = false;
            $('#movies-rating-star').raty({
                score: {{$currentMovie->getRatingStar()}},
                number: 10,
                numberMax: 10,
                hints: ['quá tệ', 'tệ', 'không hay', 'không hay lắm', 'bình thường', 'xem được', 'có vẻ hay', 'hay',
                    'rất hay', 'siêu phẩm'
                ],
                starOff: '{{ asset('/themes/rrdyw/plugins/jquery-raty/images/star-off.png') }}',
                starOn: '{{ asset('/themes/rrdyw/plugins/jquery-raty/images/star-on.png') }}',
                starHalf: '{{ asset('/themes/rrdyw/plugins/jquery-raty/images/star-half.png') }}',
                click: function(score, evt) {
                    if (rated) return
                    fetch("{{ route('movie.rating', ['movie' => $currentMovie->slug]) }}", {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]')
                                .getAttribute(
                                    'content')
                        },
                        body: JSON.stringify({
                            rating: score
                        })
                    });
                    rated = true;
                    $('#movies-rating-star').data('raty').readOnly(true);
                    $('#movies-rating-msg').html(`Bạn đã đánh giá ${score} sao cho phim này!`);
                }
            });
        </script>
        <script src="{{ asset('/themes/rrdyw/source/jquery.fancybox.pack.js?v=2.1.5') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('/themes/rrdyw/source/jquery.fancybox.css?v=2.1.5') }}" media="screen"/>
        <script type="text/javascript">
            $(document).ready(function () {
                $(".fancybox").fancybox({
                    maxWidth    : 800,
                    maxHeight   : 600,
                    fitToView   : false,
                    width       : '70%',
                    height      : '70%',
                    autoSize    : false,
                    closeClick  : false,
                    openEffect  : 'none',
                    closeEffect : 'none'
                });
            });
        </script>

        {!! setting('site_scripts_facebook_sdk') !!}
    @endpush

@endsection

