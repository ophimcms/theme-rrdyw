<?php

namespace Ophim\ThemeRrdyw;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class ThemeRrdywServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->setupDefaultThemeCustomizer();
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'themes');

        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('themes/rrdyw')
        ], 'rrdyw-assets');
    }

    protected function setupDefaultThemeCustomizer()
    {
        config(['themes' => array_merge(config('themes', []), [
            'rrdyw' => [
                'name' => 'Theme Rrdyw',
                'author' => 'dev.ohpim.cc',
                'package_name' => 'ophimcms/theme-rrdyw',
                'publishes' => ['rrdyw-assets'],
                'preview_image' => '',
                'options' => [
                    [
                        'name' => 'per_page_limit',
                        'label' => 'Pages limit',
                        'type' => 'number',
                        'value' => 24,
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-4',
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'movie_related_limit',
                        'label' => 'Movies related limit',
                        'type' => 'number',
                        'value' => 14,
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-4',
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'home_page_slider_poster',
                        'label' => 'Home page slider poster',
                        'type' => 'text',
                        'hint' => 'Label|relation|find_by_field|value|sort_by_field|sort_algo|limit',
                        'value' => 'Slide||is_recommended|0|updated_at|desc|10',
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'latest',
                        'label' => 'Home Page',
                        'type' => 'code',
                        'hint' => 'display_label|relation|find_by_field|value|limit|show_more_url|show_template (section_thumb|section_side)',
                        'value' => <<<EOT
                        Phim chiếu rạp||is_shown_in_theater|1|updated_at|desc|16|/danh-sach/phim-chieu-rap|section_thumb
                        Phim bộ mới||type|series|updated_at|desc|14|/danh-sach/phim-bo|section_side
                        Phim lẻ mới||type|single|updated_at|desc|14|/danh-sach/phim-le|section_side
                        Hoạt hình|categories|slug|hoat-hinh|updated_at|desc|14|/the-loai/hoat-hinh|section_side
                        EOT,
                        'attributes' => [
                            'rows' => 5
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'additional_css',
                        'label' => 'Additional CSS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom CSS'
                    ],
                    [
                        'name' => 'body_attributes',
                        'label' => 'Body attributes',
                        'type' => 'text',
                        'value' => "",
                        'tab' => 'Custom CSS'
                    ],
                    [
                        'name' => 'additional_header_js',
                        'label' => 'Header JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'additional_body_js',
                        'label' => 'Body JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'additional_footer_js',
                        'label' => 'Footer JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'footer',
                        'label' => 'Footer',
                        'type' => 'code',
                        'value' => <<<EOT
                        <div class="row">
                            <div class="stui-foot clearfix">
                                <p class="text-muted text-center visible-xs">Copyright © 2008-2018</p>
                                <center>
                                    <p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Tuyên bố trang trọng: Trang web này nhằm mục đích cung cấp một môi trường giao tiếp tốt cho phần lớn những người đam mê phim ảnh và truyền hình. Chúng tôi không đàn áp, sản xuất hoặc lưu trữ bất kỳ tệp âm thanh và video nào. Tất cả các nguồn trên trang web đều được sao chép từ các kênh công cộng trên Internet.</font></font></p>
                                    <p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Nó chỉ dành cho mục đích giao lưu, học hỏi giữa các cư dân mạng và thử nghiệm. Vui lòng không sử dụng nó cho mục đích thương mại. Vui lòng ủng hộ phiên bản chính hãng! Trang web này hoàn toàn là một trang web phúc lợi công cộng và tuân thủ nghiêm ngặt luật pháp và quy định của Trung Quốc đại lục. Email khiếu nại và báo cáo: rrdyw#gmail.COM</font></font></p>
                                </center>
                            </div>
                        </div>
                        EOT,
                        'tab' => 'Custom HTML'
                    ],
                    [
                        'name' => 'ads_header',
                        'label' => 'Ads header',
                        'type' => 'code',
                        'value' => '',
                        'tab' => 'Ads'
                    ],
                    [
                        'name' => 'ads_catfish',
                        'label' => 'Ads catfish',
                        'type' => 'code',
                        'value' => '',
                        'tab' => 'Ads'
                    ]
                ],
            ]
        ])]);
    }
}
