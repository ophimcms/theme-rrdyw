
<div class="stui-vodlist__box">
    <a class="stui-vodlist__thumb lazyload" href="{{$movie->getUrl()}}" title="{{$movie->name}}"
                                  data-original="{{$movie->getThumbUrl()}}">
        <span class="play hidden-xs"></span></a>
    <div class="stui-vodlist__detail">
        <h4 class="title text-overflow">
            <a href="{{$movie->getUrl()}}"  title="{{$movie->name}}">{{$movie->name}}</a>
        </h4>

    </div>
</div>
