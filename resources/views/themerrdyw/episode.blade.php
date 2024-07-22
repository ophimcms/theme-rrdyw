@extends('themes::themerrdyw.layout')
@section('content')
    <style>
        .activeplay {
            background-color: #FF9900;
            color: #FFFFFF;
            border: 1px solid #FF9900;
        }

        .active-server {
            background: #d9a0a0 !important;
            color: #FFF !important;
        }

        .playactive {
            color: #FFF !important;
            background: #c92626 !important;
        }

        #streaming-sv {
            cursor: pointer !important;
        }
    </style>
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
            <div class="stui-pannel-box">
                <div class="stui-pannel-bd">
                    <div class="stui-player col-pd">
                        <div class="stui-player__video embed-responsive embed-responsive-16by9 clearfix"
                             id="player-wrapper">
                        </div>
                        <div class="stui-player__detail detail">
                            <h4 class="title"><a href="{{ $currentMovie->getUrl() }}">{{$currentMovie->name}}</a> -
                                Tập {{ $episode->name }}</h4>
                            <p class="data margin-0">
                                <span class="text-muted hidden-xs">Quốc gia：</span> {!! $currentMovie->regions->map(function ($region) {
                        return '<a href="' . $region->getUrl() . '" title="' . $region->name . '">' . $region->name . '</a>';
                    })->implode(', ') !!}
                                <span class="split-line"></span><span
                                    class="text-muted hidden-xs">Năm ：</span>{{ $currentMovie->publish_year }}
                                <span class="split-line"></span><a class="detail-more" href="javascript:">Đổi Server<i
                                        class="icon iconfont icon-moreunfold"></i></a>

                            </p>
                            <div class="detail-content" style="display: none;margin-top: 20px">
                                @foreach ($currentMovie->episodes->where('slug', $episode->slug)->where('server', $episode->server) as $server)
                                    <a onclick="chooseStreamingServer(this)" data-type="{{ $server->type }}" id="streaming-sv"
                                       data-id="{{ $server->id }}" data-link="{{ $server->link }}"
                                       class="streaming-server tag-link"
                                       style="background: #303033;color: #FFF;padding: 10px;border-radius: 10px;margin: 5px">
                                        Nguồn #{{ $loop->index + 1 }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 播放器-->
            @foreach ($currentMovie->episodes->sortBy([['server', 'asc']])->groupBy('server') as $server => $data)
        <div class="stui-pannel stui-pannel-bg clearfix">
            <div class="stui-pannel-box">
                <div class="stui-pannel_hd">
                    <div class="stui-pannel__head bottom-line active clearfix">
                        <h3 class="title">
                            <img src="{{ asset('/themes/rrdyw/statics/icon/icon_1.png') }}"
                                 alt="">{{ $server }}</h3>
                    </div>
                </div>
                <div class="stui-pannel_bd col-pd clearfix">
                    <ul class="stui-content__playlist column10 clearfix">
                        @foreach ($data->sortBy('name', SORT_NATURAL)->groupBy('name') as $name => $item)
                        <li><a @if ($item->contains($episode)) class="activeplay" @endif href="{{ $item->sortByDesc('type')->first()->getUrl() }}" target="_self"> {{ $name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
            @endforeach
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

        <!-- 播放列表-->
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
        <!-- 猜你喜欢-->
    </div>
@endsection

@push('scripts')

    <script src="{{ asset('/themes/rrdyw/plugins/jquery-raty/jquery.raty.js') }}"></script>
    <link href="{{ asset('/themes/rrdyw/plugins/jquery-raty/jquery.raty.css') }}" rel="stylesheet" type="text/css"/>
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
            click: function (score, evt) {
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

    <script src="/themes/rrdyw/player/js/p2p-media-loader-core.min.js"></script>
    <script src="/themes/rrdyw/player/js/p2p-media-loader-hlsjs.min.js"></script>

    <script src="/js/jwplayer-8.9.3.js"></script>
    <script src="/js/hls.min.js"></script>
    <script src="/js/jwplayer.hlsjs.min.js"></script>

    <script>
        var episode_id = {{ $episode->id }};
        const wrapper = document.getElementById('player-wrapper');
        const vastAds = "{{ Setting::get('jwplayer_advertising_file') }}";

        function chooseStreamingServer(el) {
            const type = el.dataset.type;
            const link = el.dataset.link.replace(/^http:\/\//i, 'https://');
            const id = el.dataset.id;

            const newUrl =
                location.protocol +
                "//" +
                location.host +
                location.pathname.replace(`-${episode_id}`, `-${id}`);

            history.pushState({
                path: newUrl
            }, "", newUrl);
            episode_id = id;


            Array.from(document.getElementsByClassName('streaming-server')).forEach(server => {
                server.classList.remove('active-server');
            })
            el.classList.add('active-server');

            link.replace('http://', 'https://');
            renderPlayer(type, link, id);
        }

        function renderPlayer(type, link, id) {
            if (type == 'embed') {
                if (vastAds) {
                    wrapper.innerHTML = `<div id="fake_jwplayer"></div>`;
                    const fake_player = jwplayer("fake_jwplayer");
                    const objSetupFake = {
                        key: "{{ Setting::get('jwplayer_license') }}",
                        aspectratio: "16:9",
                        width: "100%",
                        file: "/themes/vung/player/1s_blank.mp4",
                        volume: 100,
                        mute: false,
                        autostart: true,
                        advertising: {
                            tag: "{{ Setting::get('jwplayer_advertising_file') }}",
                            client: "vast",
                            vpaidmode: "insecure",
                            skipoffset: {{ (int) Setting::get('jwplayer_advertising_skipoffset') ?: 5 }}, // Bỏ qua quảng cáo trong vòng 5 giây
                            skipmessage: "Bỏ qua sau xx giây",
                            skiptext: "Bỏ qua"
                        }
                    };
                    fake_player.setup(objSetupFake);
                    fake_player.on('complete', function (event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });

                    fake_player.on('adSkipped', function (event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });

                    fake_player.on('adComplete', function (event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });
                } else {
                    if (wrapper) {
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                    }
                }
                return;
            }

            if (type == 'm3u8' || type == 'mp4') {
                wrapper.innerHTML = `<div id="jwplayer"></div>`;
                const player = jwplayer("jwplayer");
                const objSetup = {
                    key: "{{ Setting::get('jwplayer_license') }}",
                    aspectratio: "16:9",
                    width: "100%",
                    image: "{{ $currentMovie->getPosterUrl() }}",
                    file: link,
                    playbackRateControls: true,
                    playbackRates: [0.25, 0.75, 1, 1.25],
                    sharing: {
                        sites: [
                            "reddit",
                            "facebook",
                            "twitter",
                            "googleplus",
                            "email",
                            "linkedin",
                        ],
                    },
                    volume: 100,
                    mute: false,
                    autostart: true,
                    logo: {
                        file: "{{ Setting::get('jwplayer_logo_file') }}",
                        link: "{{ Setting::get('jwplayer_logo_link') }}",
                        position: "{{ Setting::get('jwplayer_logo_position') }}",
                    },
                    advertising: {
                        tag: "{{ Setting::get('jwplayer_advertising_file') }}",
                        client: "vast",
                        vpaidmode: "insecure",
                        skipoffset: {{ (int) Setting::get('jwplayer_advertising_skipoffset') ?: 5 }}, // Bỏ qua quảng cáo trong vòng 5 giây
                        skipmessage: "Bỏ qua sau xx giây",
                        skiptext: "Bỏ qua"
                    }
                };

                if (type == 'm3u8') {
                    const segments_in_queue = 50;

                    var engine_config = {
                        debug: !1,
                        segments: {
                            forwardSegmentCount: 50,
                        },
                        loader: {
                            cachedSegmentExpiration: 864e5,
                            cachedSegmentsCount: 1e3,
                            requiredSegmentsPriority: segments_in_queue,
                            httpDownloadMaxPriority: 9,
                            httpDownloadProbability: 0.06,
                            httpDownloadProbabilityInterval: 1e3,
                            httpDownloadProbabilitySkipIfNoPeers: !0,
                            p2pDownloadMaxPriority: 50,
                            httpFailedSegmentTimeout: 500,
                            simultaneousP2PDownloads: 20,
                            simultaneousHttpDownloads: 2,
                            // httpDownloadInitialTimeout: 12e4,
                            // httpDownloadInitialTimeoutPerSegment: 17e3,
                            httpDownloadInitialTimeout: 0,
                            httpDownloadInitialTimeoutPerSegment: 17e3,
                            httpUseRanges: !0,
                            maxBufferLength: 300,
                            // useP2P: false,
                        },
                    };
                    if (Hls.isSupported() && p2pml.hlsjs.Engine.isSupported()) {
                        var engine = new p2pml.hlsjs.Engine(engine_config);
                        player.setup(objSetup);
                        jwplayer_hls_provider.attach();
                        p2pml.hlsjs.initJwPlayer(player, {
                            liveSyncDurationCount: segments_in_queue, // To have at least 7 segments in queue
                            maxBufferLength: 300,
                            loader: engine.createLoaderClass(),
                        });
                    } else {
                        player.setup(objSetup);
                    }
                } else {
                    player.setup(objSetup);
                }


                const resumeData = 'OPCMS-PlayerPosition-' + id;
                player.on('ready', function () {
                    if (typeof (Storage) !== 'undefined') {
                        if (localStorage[resumeData] == '' || localStorage[resumeData] == 'undefined') {
                            console.log("No cookie for position found");
                            var currentPosition = 0;
                        } else {
                            if (localStorage[resumeData] == "null") {
                                localStorage[resumeData] = 0;
                            } else {
                                var currentPosition = localStorage[resumeData];
                            }
                            console.log("Position cookie found: " + localStorage[resumeData]);
                        }
                        player.once('play', function () {
                            console.log('Checking position cookie!');
                            console.log(Math.abs(player.getDuration() - currentPosition));
                            if (currentPosition > 180 && Math.abs(player.getDuration() - currentPosition) >
                                5) {
                                player.seek(currentPosition);
                            }
                        });
                        window.onunload = function () {
                            localStorage[resumeData] = player.getPosition();
                        }
                    } else {
                        console.log('Your browser is too old!');
                    }
                });

                player.on('complete', function () {
                    if (typeof (Storage) !== 'undefined') {
                        localStorage.removeItem(resumeData);
                    } else {
                        console.log('Your browser is too old!');
                    }
                })

                function formatSeconds(seconds) {
                    var date = new Date(1970, 0, 1);
                    date.setSeconds(seconds);
                    return date.toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");
                }
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const episode = '{{ $episode->id }}';
            let playing = document.querySelector(`[data-id="${episode}"]`);
            if (playing) {
                playing.click();
                return;
            }

            const servers = document.getElementsByClassName('streaming-server');
            if (servers[0]) {
                servers[0].click();
            }
        });
    </script>

    {!! setting('site_scripts_facebook_sdk') !!}
@endpush
