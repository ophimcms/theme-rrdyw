<link rel="stylesheet" href="{{ asset('/themes/rrdyw/templets/css/swiper.min.css') }}"
      type="text/css">
<link rel="stylesheet" href="{{ asset('/themes/rrdyw/templets/css/hdp.css') }}" type="text/css">

<script>
    var swiper;
    $(document).ready(function () {
        var swiper = new Swiper('.swiper-container', {
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            paginationType: 'fraction'
        })
    });
</script>

<div class="swiper-container">
    <div class="swiper-wrapper">
        @foreach ($home_page_slider_poster['data'] as $movie)
        <div class="swiper-slide">
            <a class="dymrslide banner"  href="{{$movie->getUrl()}}"
               style="background: url({{$movie->getPosterUrl()}}) center no-repeat; background-size: cover;">
                <div class="focus_leftshode focusleftshode"></div>
                <div class="focus_rightshode focusrightshode"></div>
                <div class="focus_topshode focustopshode"></div>
                <div class="focus_bottomshode focusbottomshode"></div>
                <div class="txt-info">
                    <p class="name">{{$movie->name}}</p>
                    <p class="info">{{$movie->origin_name}}</p></div>
            </a>
        </div>
        @endforeach
    </div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>
