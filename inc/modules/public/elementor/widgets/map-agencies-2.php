<?php
/**
* Techt Map Agencies widget.
*
* @package Techt
*/

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Techt_Map_Agencies_2 extends Widget_Base {

    public function get_name() {
        return 'techt-map-agencies-2';
    }

    public function get_title()
	{
		return esc_html__('Map & Agencies 2', 'petrona');
	}

    public function get_icon() {
        return 'eicon-map-pin';
    }

    public function get_categories() {
        return ['techt-category'];
    }

    public function get_script_depends() {
        return ['highcharts', 'highcharts-map', 'highcharts-iran-map'];
    }

    protected function register_controls() {
        // بخش تنظیمات عمومی
        $this->start_controls_section(
            'section_general',
            [
                'label' => __('تنظیمات عمومی', 'petrona'),
            ]
        );

        $this->add_control(
            'map_title',
            [
                'label' => __('عنوان نقشه', 'petrona'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('نقشه ایران', 'petrona'),
            ]
        );

        $this->add_control(
            'map_height',
            [
                'label' => __('ارتفاع نقشه (px)', 'petrona'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 300,
                        'max' => 1200,
                        'step' => 10,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 500,
                ],
                'selectors' => [
                    '{{WRAPPER}} .iran-map-container' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .iran-map, {{WRAPPER}} .iran-map-delegations' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'map_width',
            [
                'label' => __('عرض نقشه (%)', 'petrona'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => [
                    '%' => [
                        'min' => 50,
                        'max' => 80,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 70,
                ],
                'selectors' => [
                    '{{WRAPPER}} .iran-map' => 'flex: 0 0 {{SIZE}}%;',
                    '{{WRAPPER}} .iran-map-delegations' => 'flex: 0 0 calc(100% - {{SIZE}}%);',
                ],
            ]
        );

        $this->add_control(
            'active_province',
            [
                'label' => __('استان فعال پیش‌فرض', 'petrona'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_provinces(),
                'default' => '',
            ]
        );

        $this->end_controls_section();

        // بخش تنظیمات رنگ
        $this->start_controls_section(
            'section_colors',
            [
                'label' => __('تنظیمات رنگ', 'petrona'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'normal_color',
            [
                'label' => __('رنگ پیش‌فرض استان‌ها', 'petrona'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#90cdf4',
            ]
        );

        $this->add_control(
            'hover_color',
            [
                'label' => __('رنگ هاور', 'petrona'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ff7f00',
            ]
        );

        $this->add_control(
            'selected_color',
            [
                'label' => __('رنگ استان انتخاب شده', 'petrona'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ff0000',
            ]
        );

        $this->add_control(
            'border_color',
            [
                'label' => __('رنگ حاشیه استان‌ها', 'petrona'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
            ]
        );

        $this->add_control(
            'border_width',
            [
                'label' => __('ضخامت حاشیه (px)', 'petrona'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.5,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1,
                ],
            ]
        );

        $this->end_controls_section();

        // بخش تنظیمات متن
        $this->start_controls_section(
            'section_text',
            [
                'label' => __('تنظیمات متن', 'petrona'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'province_label_color',
            [
                'label' => __('رنگ نام استان‌ها', 'petrona'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
            ]
        );

        $this->add_control(
            'province_label_font_size',
            [
                'label' => __('اندازه فونت نام استان‌ها (px)', 'petrona'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 8,
                        'max' => 24,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 12,
                ],
            ]
        );

        $this->add_control(
            'delegation_title_color',
            [
                'label' => __('رنگ عنوان نمایندگی‌ها', 'petrona'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#222222',
                'selectors' => [
                    '{{WRAPPER}} .iran-map-delegations h3' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'delegation_text_color',
            [
                'label' => __('رنگ متن نمایندگی‌ها', 'petrona'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#444444',
                'selectors' => [
                    '{{WRAPPER}} .iran-map-delegations' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'delegation_typography',
                'label' => __('تایپوگرافی متن نمایندگی‌ها', 'petrona'),
                'selector' => '{{WRAPPER}} .iran-map-delegations',
            ]
        );

        $this->end_controls_section();

        // بخش نمایندگی‌ها (مانند قبل باقی می‌ماند)
        $this->start_controls_section(
            'section_delegations',
            [
                'label' => __('نمایندگی‌ها', 'petrona'),
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'province',
            [
                'label' => __('استان', 'petrona'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_provinces(),
                'default' => 'tehran',
            ]
        );

        $repeater->add_control(
            'name',
            [
                'label' => __('نام نمایندگی', 'petrona'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
            ]
        );

        $repeater->add_control(
            'address',
            [
                'label' => __('آدرس', 'petrona'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '',
            ]
        );

        $this->add_control(
            'delegations',
            [
                'label' => __('نمایندگی‌ها', 'petrona'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ name }}} - {{{ province }}}',
            ]
        );

        $this->end_controls_section();

        // بخش تنظیمات پیشرفته
        $this->start_controls_section(
            'section_advanced',
            [
                'label' => __('تنظیمات پیشرفته', 'petrona'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'delegations_bg',
            [
                'label' => __('رنگ پس‌زمینه لیست نمایندگی‌ها', 'petrona'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f9f9f9',
                'selectors' => [
                    '{{WRAPPER}} .iran-map-delegations' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'delegations_padding',
            [
                'label' => __('حاشیه داخلی لیست نمایندگی‌ها', 'petrona'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .iran-map-delegations' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => 20,
                    'right' => 20,
                    'bottom' => 20,
                    'left' => 20,
                    'unit' => 'px',
                ],
            ]
        );

        $this->add_control(
            'map_border_radius',
            [
                'label' => __('شعاع حاشیه نقشه', 'petrona'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .iran-map-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .iran-map' => 'border-radius: {{TOP}}{{UNIT}} 0 0 {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .iran-map-delegations' => 'border-radius: 0 {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} 0;',
                ],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'map_shadow',
                'label' => __('سایه نقشه', 'petrona'),
                'selector' => '{{WRAPPER}} .iran-map-container',
            ]
        );

        $this->end_controls_section();
    }

    protected function get_provinces() {
        return [
            '' => __('هیچکدام', 'petrona'),
            'ir-ea' => __('آذربایجان شرقی', 'petrona'),
            'ir-wa' => __('آذربایجان غربی', 'petrona'),
            'ir-ar' => __('اردبیل', 'petrona'),
            'ir-es' => __('اصفهان', 'petrona'),
            'ir-al' => __('البرز', 'petrona'),
            'ir-il' => __('ایلام', 'petrona'),
            'ir-bs' => __('بوشهر', 'petrona'),
            'ir-th' => __('تهران', 'petrona'),
            'ir-cm' => __('چهارمحال و بختیاری', 'petrona'),
            'ir-kj' => __('خراسان جنوبی', 'petrona'),
            'ir-kv' => __('خراسان رضوی', 'petrona'),
            'ir-ks' => __('خراسان شمالی', 'petrona'),
            'ir-kh' => __('خوزستان', 'petrona'),
            'ir-za' => __('زنجان', 'petrona'),
            'ir-sm' => __('سمنان', 'petrona'),
            'ir-sb' => __('سیستان و بلوچستان', 'petrona'),
            'ir-fa' => __('فارس', 'petrona'),
            'ir-qz' => __('قزوین', 'petrona'),
            'ir-qm' => __('قم', 'petrona'),
            'ir-kd' => __('کردستان', 'petrona'),
            'ir-ke' => __('کرمان', 'petrona'),
            'ir-bk' => __('کرمانشاه', 'petrona'),
            'ir-kb' => __('کهگیلویه و بویراحمد', 'petrona'),
            'ir-go' => __('گلستان', 'petrona'),
            'ir-gi' => __('گیلان', 'petrona'),
            'ir-lo' => __('لرستان', 'petrona'),
            'ir-mn' => __('مازندران', 'petrona'),
            'ir-mk' => __('مرکزی', 'petrona'),
            'ir-hg' => __('هرمزگان', 'petrona'),
            'ir-hd' => __('همدان', 'petrona'),
            'ir-ya' => __('یزد', 'petrona'),
        ];
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        // ساختار داده نمایندگی‌ها
        $delegations_data = [];
        foreach ($settings['delegations'] as $delegation) {
            $province = $delegation['province'];
            if (!isset($delegations_data[$province])) {
                $delegations_data[$province] = [];
            }
            
            $delegations_data[$province][] = [
                'name' => $delegation['name'],
                'address' => $delegation['address']
            ];
        }
        
        $provinces = $this->get_provinces();
        $widget_settings = [
            'mapTitle' => $settings['map_title'],
            'activeProvince' => $settings['active_province'],
            'hoverColor' => $settings['hover_color'],
            'selectedColor' => $settings['selected_color'],
            'normalColor' => $settings['normal_color'],
            'borderColor' => $settings['border_color'],
            'borderWidth' => $settings['border_width']['size'],
            'provinceLabelColor' => $settings['province_label_color'],
            'provinceLabelFontSize' => $settings['province_label_font_size']['size'],
            'delegations' => $delegations_data,
            'provinces'   => json_encode($provinces),
        ];
        
        ?>
        <div class="elementor-iran-map-widget" id="iran-map-<?php echo esc_attr($this->get_id()); ?>" 
             data-settings='<?php echo json_encode($widget_settings); ?>'>
            <div class="iran-map-container" style="width: 100%;">
                <div class="iran-map"></div>
                <div class="iran-map-delegations"></div>
            </div>
        </div>
        <?php
    }
}
Plugin::instance()->widgets_manager->register(new Techt_Map_Agencies_2());