<?php
/**
* Techt Map Agencies widget.
*
* @package Techt
*/

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Techt_Map_Agencies_1 extends Widget_Base {

    public function get_name() {
        return 'iran_provinces_map_leaflet';
    }

    public function get_title() {
        return __('Iran Provinces Map (Leaflet)', 'petrona');
    }

    public function get_icon() {
        return 'eicon-map-pin';
    }

    public function get_categories() {
        return ['techt-category'];
    }

    public function get_style_depends() {
        return ['leaflet'];
    }

    public function get_script_depends() {
        return ['leaflet'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_settings',
            [
                'label' => __('Settings', 'petrona'),
            ]
        );

        $provinces_list = [
            '01' => 'آذربایجان شرقی',
            '02' => 'آذربایجان غربی',
            '03' => 'اردبیل',
            '04' => 'اصفهان',
            '05' => 'تهران',
            '06' => 'خراسان رضوی',
            '07' => 'فارس',
        ];

        $this->add_control(
            'active_province',
            [
                'label' => __('Active Province (Initial)', 'petrona'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $provinces_list,
                'default' => '05',
            ]
        );

        $agency_repeater = new \Elementor\Repeater();

        $agency_repeater->add_control(
            'agency_name',
            [
                'label' => __('Agency Name', 'petrona'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Agency name', 'petrona'),
                'label_block' => true,
            ]
        );

        $agency_repeater->add_control(
            'agency_address',
            [
                'label' => __('Address', 'petrona'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '',
            ]
        );

        $province_repeater = new \Elementor\Repeater();

        $province_repeater->add_control(
            'province_key',
            [
                'label' => __('Select Province', 'petrona'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $provinces_list,
                'default' => '05',
                'label_block' => true,
            ]
        );

        $province_repeater->add_control(
            'agencies',
            [
                'label' => __('Agencies', 'petrona'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $agency_repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ agency_name }}}',
            ]
        );

        $this->add_control(
            'provinces',
            [
                'label' => __('Provinces with Agencies', 'petrona'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $province_repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ province_key }}}',
            ]
        );

        $this->end_controls_section();
    }

    public function render() {
        $settings = $this->get_settings_for_display();
        $activeProvince = $settings['active_province'];
        $provinces = $settings['provinces'];

        // داده‌های نمایندگی‌ها بر اساس استان
        $agenciesData = [];
        foreach ($provinces as $prov) {
            $key = $prov['province_key'];
            $agenciesData[$key] = [];
            foreach ($prov['agencies'] as $agency) {
                $agenciesData[$key][] = [
                    'name' => sanitize_text_field($agency['agency_name']),
                    'address' => sanitize_textarea_field($agency['agency_address']),
                ];
            }
        }

        // GeoJSON ساده برای نمونه 7 استان (مختصری برای دمو، بهتره فایل دقیق‌تر جایگزین بشه)
        $geojson = json_encode([
            "type" => "FeatureCollection",
            "features" => [
                // نمونه یک استان (تهران) با کلید '05'
                [
                    "type" => "Feature",
                    "id" => "05",
                    "properties" => ["name" => "تهران", "code" => "05"],
                    "geometry" => [
                        "type" => "Polygon",
                        "coordinates" => [[[51.0, 35.5],[51.5, 35.5],[51.5, 35.8],[51.0, 35.8],[51.0, 35.5]]]
                    ]
                ],
                // نمونه یک استان دیگر (اصفهان) '04'
                [
                    "type" => "Feature",
                    "id" => "04",
                    "properties" => ["name" => "اصفهان", "code" => "04"],
                    "geometry" => [
                        "type" => "Polygon",
                        "coordinates" => [[[51.6, 32.5],[52.0, 32.5],[52.0, 33.0],[51.6, 33.0],[51.6, 32.5]]]
                    ]
                ],
                // استان‌های دیگر رو به همین شکل اضافه کن
            ]
        ]);

        $map_container_id = 'iran-map-' . $this->get_id();
        $agency_list_id = 'iran-agencies-' . $this->get_id();

        ?>
        <div style="display:flex; gap:20px; flex-wrap: wrap;">
            <div id="<?php echo esc_attr($map_container_id); ?>" style="width: 65%; height: 600px; min-width: 300px;"></div>
            <div id="<?php echo esc_attr($agency_list_id); ?>" style="width: 30%; max-height: 600px; overflow-y: auto; background: #f9f9f9; border: 1px solid #ddd; padding: 10px;">
                <h3>نمایندگی‌های استان انتخاب شده</h3>
                <div id="agency-list-content-<?php echo esc_attr($this->get_id()); ?>">
                    در حال بارگذاری...
                </div>
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var mapContainer = document.getElementById('<?php echo esc_js($map_container_id); ?>');
            var agencyListContent = document.getElementById('agency-list-content-<?php echo esc_js($this->get_id()); ?>');

            var provincesGeoJson = <?php echo $geojson; ?>;
            var agenciesData = <?php echo wp_json_encode($agenciesData); ?>;
            var activeProvince = '<?php echo esc_js($activeProvince); ?>';

            var map = L.map(mapContainer).setView([32.0, 53.0], 5);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 10,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            function style(feature) {
                var code = feature.properties.code;
                var hasAgencies = agenciesData[code] && agenciesData[code].length > 0;
                var isActive = (code === activeProvince);

                return {
                    fillColor: isActive ? '#d42f2f' : (hasAgencies ? '#2f7ed8' : '#eeeeee'),
                    weight: 2,
                    opacity: 1,
                    color: 'white',
                    dashArray: '3',
                    fillOpacity: 0.7
                };
            }

            function highlightFeature(e) {
                var layer = e.target;
                layer.setStyle({
                    weight: 4,
                    color: '#666',
                    dashArray: '',
                    fillOpacity: 0.9
                });

                if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                    layer.bringToFront();
                }
            }

            function resetHighlight(e) {
                geojson.resetStyle(e.target);
            }

            function zoomToFeature(e) {
                var layer = e.target;
                var code = layer.feature.properties.code;
                if (code === activeProvince) return;

                activeProvince = code;
                geojson.eachLayer(function(layer) {
                    geojson.resetStyle(layer);
                    if (layer.feature.properties.code === activeProvince) {
                        layer.setStyle({
                            fillColor: '#d42f2f'
                        });
                    }
                });
                updateAgencyList(activeProvince);
            }

            function onEachFeature(feature, layer) {
                layer.on({
                    mouseover: highlightFeature,
                    mouseout: resetHighlight,
                    click: zoomToFeature
                });
                layer.bindTooltip(feature.properties.name, {sticky: true});
            }

            function updateAgencyList(provinceKey) {
                if (agenciesData[provinceKey] && agenciesData[provinceKey].length > 0) {
                    var html = '<ul style="padding-right: 20px;">';
                    agenciesData[provinceKey].forEach(function(agency) {
                        html += '<li><strong>' + agency.name + '</strong><br><small>' + agency.address + '</small></li>';
                    });
                    html += '</ul>';
                    agencyListContent.innerHTML = html;
                } else {
                    agencyListContent.innerHTML = '<p>نمایندگی ثبت نشده است.</p>';
                }
            }

            var geojson = L.geoJson(provincesGeoJson, {
                style: style,
                onEachFeature: onEachFeature
            }).addTo(map);

            updateAgencyList(activeProvince);
        });
        </script>
        <?php
    }
}
Plugin::instance()->widgets_manager->register(new Techt_Map_Agencies_1());