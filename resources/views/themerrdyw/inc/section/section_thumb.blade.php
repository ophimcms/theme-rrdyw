<div class="stui-pannel-box clearfix">
    <div class="stui-pannel_hd">
        <h3 class="title">
            <img src="{{ asset('/themes/rrdyw/statics/icon/icon_6.png') }}">{{$item['label']}}</h3>
    </div>
    <div class="stui-pannel_bd">
        <ul class="stui-vodlist__bd clearfix">
                @foreach ($item['data'] as $movie)
                    <li class="col-md-6 col-sm-4 col-xs-3">
                    @include('themes::themerrdyw.inc.section.movie_card')
                    </li>
                @endforeach
        </ul>
    </div>
</div>
