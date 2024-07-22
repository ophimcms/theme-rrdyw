@extends('themes::layout')
@php
    $menu = \Ophim\Core\Models\Menu::getTree();
    $tops = Cache::remember('site.movies.tops', setting('site_cache_ttl', 5 * 60), function () {
        $lists = preg_split('/[\n\r]+/', get_theme_option('hotest'));
        $data = [];
        foreach ($lists as $list) {
            if (trim($list)) {
                $list = explode('|', $list);
                [$label, $relation, $field, $val, $sortKey, $alg, $limit, $template] = array_merge($list, ['Phim hot', '', 'type', 'series', 'view_total', 'desc', 4, 'top_thumb']);
                try {
                    $data[] = [
                        'label' => $label,
                        'template' => $template,
                        'data' => \Ophim\Core\Models\Movie::when($relation, function ($query) use ($relation, $field, $val) {
                            $query->whereHas($relation, function ($rel) use ($field, $val) {
                                $rel->where($field, $val);
                            });
                        })
                            ->when(!$relation, function ($query) use ($field, $val) {
                                $query->where($field, $val);
                            })
                            ->orderBy($sortKey, $alg)
                            ->limit($limit)
                            ->get(),
                    ];
                } catch (\Exception $e) {
                    # code
                }
            }
        }
        return $data;
    });
@endphp

@push('header')
    <link rel="stylesheet" href="{{ asset('/themes/rrdyw/statics/font/iconfont.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('/themes/rrdyw/statics/css/stui_block.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('/themes/rrdyw/statics/css/stui_default.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('/themes/rrdyw/statics/css/stui_custom.css') }}" type="text/css">
    <script type="text/javascript" src="{{ asset('/themes/rrdyw/statics/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/themes/rrdyw/statics/js/stui_default.js') }}"></script>
    <script>
        var SitePath = '{{ asset('/themes/rrdyw') }}/',
            SiteAid = '10',
            SiteTid = '',
            SiteId = '';
    </script>
@endpush

@section('body')
    @include('themes::themerrdyw.inc.nav')
    @if (get_theme_option('ads_header'))
        {!! get_theme_option('ads_header') !!}
    @endif
    <div class="container">
    @yield('content')
    </div>
@endsection

@section('footer')
    <div class="container">
    {!! get_theme_option('footer') !!}
    @if (get_theme_option('ads_catfish'))
        {!! get_theme_option('ads_catfish') !!}
    @endif
    {!! setting('site_scripts_google_analytics') !!}
    </div>
@endsection
