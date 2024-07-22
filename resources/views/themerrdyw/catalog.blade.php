@extends('themes::themerrdyw.layout')

@php
    $years = Cache::remember('all_years', \Backpack\Settings\app\Models\Setting::get('site_cache_ttl', 5 * 60), function () {
        return \Ophim\Core\Models\Movie::select('publish_year')
            ->distinct()
            ->pluck('publish_year')
            ->sortDesc();
    });
@endphp

@section('content')
    <div class="row">
        <div class="stui-pannel stui-pannel-bg clearfix">
            <div class="stui-pannel-box">

                <div class="stui-pannel_hd">
                    <div class="stui-pannel__head active bottom-line clearfix">
                        <h3 class="title"><img
                                src="{{ asset('/themes/rrdyw/statics/icon/dIYNSKsIQLBx.png') }}">{{ $section_name ?? 'Danh Sách Phim' }}
                        </h3>
                        <ul class="nav nav-page pull-right">
                        </ul>

                    </div>
                    @include('themes::themerrdyw.inc.catalog_filter')
                </div>
                <div class="stui-pannel_bd">
                    <ul class="stui-vodlist clearfix">
                            @if (count($data))
                                @foreach ($data as $movie)
                                    <li class="col-md-6 col-sm-4 col-xs-3">
                                    @include('themes::themerrdyw.inc.section.movie_card')
                                    </li>
                                @endforeach
                            @else
                                <p class="text-danger">Không có dữ liệu cho mục này</p>
                            @endif
                    </ul>
                </div>
            </div>
        </div>
        <!-- 筛选列表 -->
        <ul class="stui-page text-center cleafix">
            {{ $data->appends(request()->all())->links("themes::themerrdyw.inc.pagination") }}
        </ul>
        <!-- 列表翻页-->
    </div>



@endsection
