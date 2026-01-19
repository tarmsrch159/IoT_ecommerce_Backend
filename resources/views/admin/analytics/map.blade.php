@extends('admin.layouts.app')

@section('title')
    Customer Map
@endsection

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">

        <!-- =====================================================
                                         Page Header
                                         แสดงชื่อหน้าและคำอธิบาย
                                    ====================================================== -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-slate-800">
                    Customer Distribution Map
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    แสดงข้อมูลแผนที่ลูกค้าตามจังหวัด
                </p>
            </div>
        </div>

        <!-- =====================================================
                                         Card Container สำหรับ Map
                                    ====================================================== -->
        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-6">
            <!-- Highcharts Map จะถูก render ใน div นี้ -->
            <div id="container" style="height: 600px; min-width: 310px; max-width: 1000px; margin: 0 auto">
            </div>
        </div>
    </div>

    <!-- =====================================================
                                     Highcharts Dependencies
                                     - highmaps.js      : Core Map Engine
                                     - exporting.js    : Export เป็น PNG / PDF
                                     - th-all.js       : GeoJSON แผนที่ประเทศไทย
                                ====================================================== -->
    <script src="https://code.highcharts.com/maps/highmaps.js"></script>
    <script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/mapdata/countries/th/th-all.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /* =====================================================
               1) Backend Data
               -----------------------------------------------------

            ====================================================== */
            const backendData = @json($provinceData);

            /* =====================================================
               2) Load Map Data (Thailand)
               -----------------------------------------------------

            ====================================================== */
            const mapData = Highcharts.maps['countries/th/th-all'];

            /* =====================================================
               3) normalize()
               -----------------------------------------------------

            ====================================================== */
            const normalize = (str) => {
                if (!str) return '';
                return str.toLowerCase()
                    .replace(' province', '')
                    .replace(' metropolis', '')
                    .replace('mueang ', '')
                    .replace(/\s+/g, '')
                    .trim();
            };

            /* =====================================================
               4) Create Map Name → hc-key Dictionary
               -----------------------------------------------------

            ====================================================== */
            const mapNameKeyMap = {};

            if (mapData && mapData.features) {
                mapData.features.forEach(feature => {
                    if (feature.properties) {
                        const name = feature.properties.name;
                        const localName = feature.properties['name-local'];
                        const key = feature.properties['hc-key'];

                        // เก็บชื่อภาษาอังกฤษ
                        if (name) {
                            mapNameKeyMap[normalize(name)] = key;
                        }

                        // เก็บชื่อท้องถิ่น (ถ้ามี)
                        if (localName) {
                            mapNameKeyMap[normalize(localName)] = key;
                        }
                    }
                });
            }

            /* =====================================================
               5) Debug Logs
               -----------------------------------------------------

            ====================================================== */
            console.log("Map Keys Available:", mapNameKeyMap);
            console.log("Backend Data:", backendData);

            /* =====================================================
               6) Transform Backend Data → Highcharts Data
               -----------------------------------------------------

            ====================================================== */
            const data = [];

            backendData.forEach(item => {
                const normBackendName = normalize(item.province);
                let matchedKey = mapNameKeyMap[normBackendName];

                // แก้ชื่อพิเศษที่อาจไม่ตรงกัน
                if (!matchedKey) {
                    if (normBackendName.includes('bangkok')) {
                        matchedKey = mapNameKeyMap['bangkok'];
                    }
                    if (normBackendName.includes('ayutthaya')) {
                        matchedKey = mapNameKeyMap['phranakhonsiayutthaya'];
                    }
                }

                // ถ้า match ได้ → ส่งเข้า Highcharts
                if (matchedKey) {
                    data.push({
                        'hc-key': matchedKey,
                        value: item.count
                    });
                } else {
                    // ถ้าไม่ match จะ log เตือนไว้สำหรับ debug
                    console.warn(
                        `Could not match backend province: "${item.province}"`
                    );
                }
            });

            /* =====================================================
               7) Render Highcharts Map
               -----------------------------------------------------
               ใช้ joinBy: 'hc-key' เพื่อความแม่นยำสูงสุด
            ====================================================== */
            Highcharts.mapChart('container', {
                chart: {
                    map: 'countries/th/th-all'
                },

                title: {
                    text: 'แสดงข้อมูลสินค้าบนแผนที่'
                },

                mapNavigation: {
                    enabled: true,
                    buttonOptions: {
                        verticalAlign: 'bottom'
                    }
                },

                colorAxis: {
                    min: 0,
                    minColor: '#E6F7FF',
                    maxColor: '#0050B3',
                },

                series: [{
                    data: data,
                    joinBy: 'hc-key',
                    name: 'Orders',

                    states: {
                        hover: {
                            color: '#1890FF'
                        }
                    },

                    dataLabels: {
                        enabled: true,
                        format: '{point.name}'
                    },

                    tooltip: {
                        pointFormat:
                            '{point.name}: <b>{point.value}</b> orders'
                    }
                }]
            });
        });
    </script>
@endsection