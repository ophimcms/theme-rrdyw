@php
    $logo = setting('site_logo', '');
    $brand = setting('site_brand', '');
    $title = isset($title) ? $title : setting('site_homepage_title', '');
@endphp
<style>
    #result {
        margin-top: 20px;
        background-color: #e0d6d6;
        list-style-type: none;
        width: 500px;
        position: absolute;
        top: 32px;
        z-index: 100;
        padding-left: 0;
    }

    .column {
        float: left;
        padding: 5px;
    }

    .left {
        text-align: center;
        width: 20%;
    }

    .right {
        width: 80%;
    }

    .rowsearch:after {
        content: "";
        display: table;
        clear: both;
    }

    #result .rowsearch {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #result .rowsearch p {
        margin-bottom: 1px;
    }

    .rowsearch:hover {
        background-color: #ece4e4;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #ffffff;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(232, 204, 204, 0.2);
        z-index: 1;
        max-height: 300px;
        overflow: auto;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }
</style>
<header class="stui-header__top clearfix" id="header-top">
    <div class="container">
        <div class="row">
            <div class="stui-header_bd clearfix">
                <div class="stui-header__logo">
                    <a class="" href="/">
                        @if ($logo)
                            {!! $logo !!}
                        @else
                            {!! $brand !!}
                        @endif</a>
                </div>
                <div class="stui-header__side">
                    <div class="stui-header__search">
                        <form action="/" method="get" name="formsearch" id="formsearch">
                            <input type="text" id="wd" name="s" class="sin form-control" value="{{ request('search') }}" autocomplete="off" placeholder="Tìm kiếm...">
                            <input type="submit" id="searchbutton" value="" class="hide">
                            <button class="submit" id="submit" onclick="$('#formsearch').submit();">
                                <i class="icon iconfont icon-search"></i>
                            </button>
                        </form>
                        <div class="" id="result"></div>
                    </div>
                </div>
                <ul class="stui-header__menu type-slide">
                        @foreach ($menu as $item)
                            @if (count($item['children']))
                            <li class="nav-menu-item dropdown has-dropdown">
                                <a href="{{$item['link']}}" title="{{$item['name']}}" >
                                    <span class="nav-menu-item-name">{{$item['name']}}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-content">
                                    @foreach ($item['children'] as $children)
                                    <li>
                                        <a class="dropdown-item" href="{{$children['link']}}"
                                           title="{{$children['name']}}">{{$children['name']}}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @else
                                <li><a href="{{$item['link']}}">{{$item['name']}}</a></li>
                            @endif
                        @endforeach
                </ul>
            </div>
        </div>
    </div>
</header>

<script type="text/javascript">
    $('#wd').on('keyup',function(){
        $("#result").html('');
        $value = $(this).val();
        if(!$value){
            $("#result").html('');
            return;
        }
        $.ajax({
            type: 'get',
            url: '{{ URL::to('search') }}',
            data: {
                'search': $value
            },
            success:function(data){
                $("#result").html('')
                $.each(data, function(key, value){
                    $('#result').append('<a href="'+value.slug+'"><div class="rowsearch"> <div class="column left"> <img src="'+value.image+'" width="50" /> </div> <div class="column right"><p> '+value.title+' ' + '</p><p> '+value.original_title+'| '+value.year+' </p></div> </div></a>' )
                });
            }
        });
    })
    document.body.addEventListener("click", function (event) {
        $("#result").html('');
    });
    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>

<script>
$(function() {
    function isMobile() {
        return window.innerWidth <= 1024;
    }

    // Xử lý click menu dropdown trên mobile
    $('.stui-header__menu .dropdown > a').on('click', function(e) {
        if (isMobile()) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();

            // Xóa dropdown cũ nếu có
            $('#mobile-dropdown-portal').remove();

            var $parent = $(this).parent();
            var $dropdown = $parent.find('.dropdown-content').first().clone();
            var offset = $(this).offset();
            var height = $(this).outerHeight();

            // Tạo dropdown mới ở body
            var $portal = $('<ul id=\"mobile-dropdown-portal\" class=\"dropdown-menu dropdown-content\" style=\"display:block; position:fixed; left:' + offset.left + 'px; top:' + (offset.top + height) + 'px; z-index:99999; background:#fff; min-width:160px; box-shadow:0 8px 16px 0 rgba(0,0,0,0.2);\"></ul>');
            $portal.append($dropdown.children());
            $('body').append($portal);

            // Đóng khi click ra ngoài
            setTimeout(function() {
                $(document).one('touchstart click', function(ev) {
                    if (!$(ev.target).closest('#mobile-dropdown-portal').length) {
                        $('#mobile-dropdown-portal').remove();
                    }
                });
            }, 10);
        }
    });
});
</script>
