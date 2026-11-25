<?php
/**
* Techt Map Agencies widget.
*
* @package Techt
*/

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Techt_Map_Agencies extends Widget_Base {

    public function get_name() {
        return 'techt-map-agencies';
    }

    public function get_title()
	{
		return esc_html__('Map & Agencies', 'petrona');
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

    private function get_provinces_list() {
        return [
            'ir-ea' => 'آذربایجان شرقی',
            'ir-wa' => 'آذربایجان غربی',
            'ir-ar' => 'اردبیل',
            'ir-es' => 'اصفهان',
            'ir-al' => 'البرز',
            'ir-il' => 'ایلام',
            'ir-bs' => 'بوشهر',
            'ir-th' => 'تهران',
            'ir-cm' => 'چهارمحال و بختیاری',
            'ir-kj' => 'خراسان جنوبی',
            'ir-kv' => 'خراسان رضوی',
            'ir-ks' => 'خراسان شمالی',
            'ir-kh' => 'خوزستان',
            'ir-za' => 'زنجان',
            'ir-sm' => 'سمنان',
            'ir-sb' => 'سیستان و بلوچستان',
            'ir-fa' => 'فارس',
            'ir-qz' => 'قزوین',
            'ir-qm' => 'قم',
            'ir-kd' => 'کردستان',
            'ir-ke' => 'کرمان',
            'ir-bk' => 'کرمانشاه',
            'ir-kb' => 'کهگیلویه و بویراحمد',
            'ir-go' => 'گلستان',
            'ir-gi' => 'گیلان',
            'ir-lo' => 'لرستان',
            'ir-mn' => 'مازندران',
            'ir-mk' => 'مرکزی',
            'ir-hg' => 'هرمزگان',
            'ir-hd' => 'همدان',
            'ir-ya' => 'یزد',
        ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_settings',
            [
                'label' => __('Settings', 'plugin-name'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $provinces_list = $this->get_provinces_list();

        $this->add_control(
            'active_province',
            [
                'label' => __('Active Province (Initial)', 'plugin-name'),
                'type' => Controls_Manager::SELECT,
                'options' => $provinces_list,
                'default' => 'ir-th',
            ]
        );

        $agency_repeater = new Repeater();

        $agency_repeater->add_control(
            'agency_name',
            [
                'label' => __('Agency Name', 'plugin-name'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Agency name', 'plugin-name'),
                'label_block' => true,
            ]
        );

        $agency_repeater->add_control(
            'agency_address',
            [
                'label' => __('Address', 'plugin-name'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => '',
            ]
        );

        $province_repeater = new Repeater();

        $province_repeater->add_control(
            'province_key',
            [
                'label' => __('Select Province', 'plugin-name'),
                'type' => Controls_Manager::SELECT,
                'options' => $provinces_list,
                'default' => 'ir-th',
                'label_block' => true,
            ]
        );

        $province_repeater->add_control(
            'agencies',
            [
                'label' => __('Agencies', 'plugin-name'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $agency_repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ agency_name }}}',
            ]
        );

        $this->add_control(
            'provinces',
            [
                'label' => __('Provinces with Agencies', 'plugin-name'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $province_repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ province_key }}}',
            ]
        );

        $this->end_controls_section();
    }

    public function render() {
        $settings = $this->get_settings_for_display();
        $provinces = $settings['provinces'];
        $active_province = $settings['active_province'];
        $provinces_list = $this->get_provinces_list();

        $data_for_map = [];
        $agencies_data = [];

        foreach ($provinces as $prov) {
            $hc_key = sanitize_text_field($prov['province_key']);
            $name = isset($provinces_list[$hc_key]) ? $provinces_list[$hc_key] : 'ناشناخته';

            $agencies = $prov['agencies'];
            $has_agency = (count($agencies) > 0);

            $value = 0;
            if ($hc_key === $active_province) {
                $value = 2;
            } elseif ($has_agency) {
                $value = 1;
            }

            $data_for_map[] = [
                'hc-key' => $hc_key,
                'value' => $value,
                'name' => $name,
            ];

            $agencies_data[$hc_key] = [];

            foreach ($agencies as $agency) {
                $agencies_data[$hc_key][] = [
                    'name' => sanitize_text_field($agency['agency_name']),
                    'address' => sanitize_textarea_field($agency['agency_address']),
                ];
            }
        }

        $map_container_id = 'iran-provinces-map-' . $this->get_id();
        $agencies_container_id = 'iran-agencies-list-' . $this->get_id();
        $agencies_content_id = 'iran-agencies-content-' . $this->get_id();
        // $mapUrl = TECHT_MADULES_URL . '/public/assets/js/ir-all.topo.json';

        ?>
        <div style="display:flex; gap:20px; flex-wrap: wrap;">
            <div id="<?php echo esc_attr($map_container_id); ?>" style="width: 65%; min-width: 300px; height: 600px;"></div>

            <div id="<?php echo esc_attr($agencies_container_id); ?>" style="width: 30%; min-width: 250px; max-height: 600px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; background: #f9f9f9;">
                <h3>نمایندگی‌های استان انتخاب شده</h3>
                <div id="<?php echo esc_attr($agencies_content_id); ?>">
                    <p>در حال بارگذاری نمایندگی‌ها...</p>
                </div>
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var mapData = <?php echo wp_json_encode($data_for_map); ?>;
            var agenciesData = <?php echo wp_json_encode($agencies_data); ?>;
            var activeProvince = '<?php echo esc_js($active_province); ?>';
            var agenciesContent = document.getElementById('<?php echo esc_js($agencies_content_id); ?>');
            
            var colors = {
                0: '#eeeeee',
                1: '#2f7ed8',
                2: '#d42f2f'
            };

            function renderAgencies(provinceKey) {
                if (agenciesData[provinceKey] && agenciesData[provinceKey].length > 0) {
                    var html = '<ul style="padding-right: 20px;">';
                    agenciesData[provinceKey].forEach(function (agency) {
                        html += '<li><strong>' + agency.name + '</strong><br><small>' + agency.address + '</small></li>';
                    });
                    html += '</ul>';
                    agenciesContent.innerHTML = html;
                } else {
                    agenciesContent.innerHTML = '<p>نمایندگی ثبت نشده است.</p>';
                }
            }

            var chart = Highcharts.mapChart('<?php echo esc_js($map_container_id); ?>', {
                chart: {
                    map: 'countries/ir/ir-all'
                },

                title: {
                    text: 'نقشه استان‌های ایران با نمایندگی‌ها'
                },

                mapNavigation: {
                    enabled: true,
                    buttonOptions: {
                        verticalAlign: 'bottom'
                    }
                },

                colorAxis: {
                    dataClasses: [
                        { from: 0, to: 0, color: colors[0], name: 'بدون نمایندگی' },
                        { from: 1, to: 1, color: colors[1], name: 'دارای نمایندگی' },
                        { from: 2, to: 2, color: colors[2], name: 'استان فعال' },
                    ]
                },

                legend: {
                    layout: 'vertical',
                    align: 'left',
                    verticalAlign: 'bottom',
                    floating: true,
                    backgroundColor: 'rgba(255,255,255,0.9)',
                    borderWidth: 1
                },

                tooltip: {
                    formatter: function () {
                        var valName = '';
                        if (this.point.value === 2) valName = ' (استان فعال)';
                        else if (this.point.value === 1) valName = ' (دارای نمایندگی)';
                        else valName = ' (بدون نمایندگی)';
                        return this.point.name + valName;
                    }
                },

                series: [{
                    data: mapData,
                    name: 'استان‌ها',
                    states: {
                        hover: {
                            color: '#a4edba'
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}'
                    },
                    events: {
                        click: function (event) {
                            var clickedKey = event.point['hc-key'];
                            if (clickedKey === activeProvince) return;

                            var prevIndex = this.data.findIndex(p => p['hc-key'] === activeProvince);
                            if (prevIndex !== -1) {
                                var hasAgency = agenciesData[activeProvince] && agenciesData[activeProvince].length > 0;
                                this.data[prevIndex].update({ value: hasAgency ? 1 : 0 });
                            }

                            var clickedIndex = this.data.findIndex(p => p['hc-key'] === clickedKey);
                            if (clickedIndex !== -1) {
                                this.data[clickedIndex].update({ value: 2 });
                            }

                            activeProvince = clickedKey;

                            renderAgencies(activeProvince);
                        }
                    }
                }]
            });

            renderAgencies(activeProvince);
        });
        </script>
        <?php
    }
}
Plugin::instance()->widgets_manager->register(new Techt_Map_Agencies());