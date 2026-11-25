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
                'label' => __('تنظیمات عمومی', 'elementor-iran-map'),
            ]
        );

        $this->add_control(
            'map_title',
            [
                'label' => __('عنوان نقشه', 'elementor-iran-map'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('نقشه ایران', 'elementor-iran-map'),
            ]
        );

        $this->add_control(
            'map_height',
            [
                'label' => __('ارتفاع نقشه (px)', 'elementor-iran-map'),
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
                'label' => __('عرض نقشه (%)', 'elementor-iran-map'),
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
                'label' => __('استان فعال پیش‌فرض', 'elementor-iran-map'),
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
                'label' => __('تنظیمات رنگ', 'elementor-iran-map'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'normal_color',
            [
                'label' => __('رنگ پیش‌فرض استان‌ها', 'elementor-iran-map'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#90cdf4',
            ]
        );

        $this->add_control(
            'hover_color',
            [
                'label' => __('رنگ هاور', 'elementor-iran-map'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ff7f00',
            ]
        );

        $this->add_control(
            'selected_color',
            [
                'label' => __('رنگ استان انتخاب شده', 'elementor-iran-map'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ff0000',
            ]
        );

        $this->add_control(
            'border_color',
            [
                'label' => __('رنگ حاشیه استان‌ها', 'elementor-iran-map'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
            ]
        );

        $this->add_control(
            'border_width',
            [
                'label' => __('ضخامت حاشیه (px)', 'elementor-iran-map'),
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
                'label' => __('تنظیمات متن', 'elementor-iran-map'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'province_label_color',
            [
                'label' => __('رنگ نام استان‌ها', 'elementor-iran-map'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
            ]
        );

        $this->add_control(
            'province_label_font_size',
            [
                'label' => __('اندازه فونت نام استان‌ها (px)', 'elementor-iran-map'),
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
                'label' => __('رنگ عنوان نمایندگی‌ها', 'elementor-iran-map'),
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
                'label' => __('رنگ متن نمایندگی‌ها', 'elementor-iran-map'),
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
                'label' => __('تایپوگرافی متن نمایندگی‌ها', 'elementor-iran-map'),
                'selector' => '{{WRAPPER}} .iran-map-delegations',
            ]
        );

        $this->end_controls_section();

        // بخش نمایندگی‌ها (مانند قبل باقی می‌ماند)
        $this->start_controls_section(
            'section_delegations',
            [
                'label' => __('نمایندگی‌ها', 'elementor-iran-map'),
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'province',
            [
                'label' => __('استان', 'elementor-iran-map'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_provinces(),
                'default' => 'tehran',
            ]
        );

        $repeater->add_control(
            'name',
            [
                'label' => __('نام نمایندگی', 'elementor-iran-map'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
            ]
        );

        $repeater->add_control(
            'address',
            [
                'label' => __('آدرس', 'elementor-iran-map'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '',
            ]
        );

        $this->add_control(
            'delegations',
            [
                'label' => __('نمایندگی‌ها', 'elementor-iran-map'),
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
                'label' => __('تنظیمات پیشرفته', 'elementor-iran-map'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'delegations_bg',
            [
                'label' => __('رنگ پس‌زمینه لیست نمایندگی‌ها', 'elementor-iran-map'),
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
                'label' => __('حاشیه داخلی لیست نمایندگی‌ها', 'elementor-iran-map'),
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
                'label' => __('شعاع حاشیه نقشه', 'elementor-iran-map'),
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
                'label' => __('سایه نقشه', 'elementor-iran-map'),
                'selector' => '{{WRAPPER}} .iran-map-container',
            ]
        );

        $this->end_controls_section();
    }

    protected function get_provinces() {
        return [
            '' => __('هیچکدام', 'elementor-iran-map'),
            'ir-ea' => __('آذربایجان شرقی', 'elementor-iran-map'),
            'ir-wa' => __('آذربایجان غربی', 'elementor-iran-map'),
            'ir-ar' => __('اردبیل', 'elementor-iran-map'),
            'ir-es' => __('اصفهان', 'elementor-iran-map'),
            'ir-al' => __('البرز', 'elementor-iran-map'),
            'ir-il' => __('ایلام', 'elementor-iran-map'),
            'ir-bs' => __('بوشهر', 'elementor-iran-map'),
            'ir-th' => __('تهران', 'elementor-iran-map'),
            'ir-cm' => __('چهارمحال و بختیاری', 'elementor-iran-map'),
            'ir-kj' => __('خراسان جنوبی', 'elementor-iran-map'),
            'ir-kv' => __('خراسان رضوی', 'elementor-iran-map'),
            'ir-ks' => __('خراسان شمالی', 'elementor-iran-map'),
            'ir-kh' => __('خوزستان', 'elementor-iran-map'),
            'ir-za' => __('زنجان', 'elementor-iran-map'),
            'ir-sm' => __('سمنان', 'elementor-iran-map'),
            'ir-sb' => __('سیستان و بلوچستان', 'elementor-iran-map'),
            'ir-fa' => __('فارس', 'elementor-iran-map'),
            'ir-qz' => __('قزوین', 'elementor-iran-map'),
            'ir-qm' => __('قم', 'elementor-iran-map'),
            'ir-kd' => __('کردستان', 'elementor-iran-map'),
            'ir-ke' => __('کرمان', 'elementor-iran-map'),
            'ir-bk' => __('کرمانشاه', 'elementor-iran-map'),
            'ir-kb' => __('کهگیلویه و بویراحمد', 'elementor-iran-map'),
            'ir-go' => __('گلستان', 'elementor-iran-map'),
            'ir-gi' => __('گیلان', 'elementor-iran-map'),
            'ir-lo' => __('لرستان', 'elementor-iran-map'),
            'ir-mn' => __('مازندران', 'elementor-iran-map'),
            'ir-mk' => __('مرکزی', 'elementor-iran-map'),
            'ir-hg' => __('هرمزگان', 'elementor-iran-map'),
            'ir-hd' => __('همدان', 'elementor-iran-map'),
            'ir-ya' => __('یزد', 'elementor-iran-map'),
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