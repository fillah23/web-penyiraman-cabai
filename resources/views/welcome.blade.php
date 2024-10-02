@extends('layouts.main')

@section('contents')
@include('layouts.sidebar')

<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <h2>Monitoring Sensor Realtime</h2>

    <!-- Card for Monitoring Sensors -->
    <div class="container mt-5">
        <div class="row text-center">
            <!-- SUHU -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h4>SUHU</h4>
                    </div>
                    <div class="card-body">
                        <div style="font-size: 50px; font-weight:bold;">
                            <span id="suhuBlynk">0</span>
                            <span style="font-size: 24px;">°C</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- HUMIDITY -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h4>HUMIDITY</h4>
                    </div>
                    <div class="card-body">
                        <div style="font-size: 50px; font-weight:bold;">
                            <span id="humidityBlynk">0</span>
                            <span>%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SOIL -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h4>SOIL</h4>
                    </div>
                    <div class="card-body">
                        <div style="font-size: 50px; font-weight:bold;">
                            <span id="soilBlynk">0</span>
                            <span>%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Management Section (Kelola Lahan) -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-info text-white text-center">
                        <h4>KELOLA LAHAN</h4>
                    </div>

                    <form id="penyiramanForm">
                        @csrf
                        @method('PUT')

                        <!-- Pompa Manual -->
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h4>Pompa Manual</h4>
                            <input type="checkbox" name="pompa" id="pompa" data-toggle="toggle" data-on="ON"
                                data-off="OFF" data-onstyle="success" data-offstyle="danger"
                                onchange="updatePenyiraman()">
                        </div>

                        <!-- Penyiraman Otomatis -->
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h4>Perkiraan Penyiraman</h4>
                            <input type="checkbox" name="otomasi" id="otomasi" data-toggle="toggle" data-on="ON"
                                data-off="OFF" data-onstyle="success" data-offstyle="danger"
                                onchange="updatePenyiraman()">
                        </div>

                        <!-- Batas Atas dan Batas Bawah -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <label>Batas Bawah</label>
                                    <input type="range" name="batas_bawah" id="batas_bawah" min="1" max="10" value="1"
                                        onchange="updatePenyiraman()">
                                    <span id="batas_bawah_value">1</span> <!-- Set initial value -->
                                </div>
                                <div class="col">
                                    <label>Batas Atas</label>
                                    <input type="range" name="batas_atas" id="batas_atas" min="1" max="10" value="10"
                                        onchange="updatePenyiraman()">
                                    <span id="batas_atas_value">10</span> <!-- Set initial value -->
                                </div>
                            </div>
                        </div>

                        <!-- Status Penyiraman dan Waktu Penyiraman -->
                        <div class="card-body">
                            <label>Status Penyiraman: <span id="status_penyiraman"></span></label><br>
                            <label>Waktu Penyiraman: <span id="waktu_penyiraman"></span></label>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Irigasi Lahan Section -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h4>IRIGASI LAHAN</h4>
                    </div>
                    <div class="card-body d-flex justify-content-between">
                        <div class="status">
                            <p>Normal <span class="status-indicator bg-success"></span></p>
                            <p>Sedang <span class="status-indicator bg-warning"></span></p>
                            <p>Melebihi Normal <span class="status-indicator bg-danger"></span></p>
                        </div>
                        <div class="controls">
                            <button class="btn btn-primary mb-2" id="toggleOnButton">Nyalakan Pompa</button>
                            <button class="btn btn-danger" id="toggleOffButton">Matikan Pompa</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Fetch initial values
    getBlynkValue('v3');
    getBlynkValue('v4');
    getBlynkValue('v5');
    getBlynkValue('v6');

    // Realtime data
    getBlynkValueString('v0');
    getBlynkValueString('v1');
    getBlynkValueString('v2');
    getBlynkValueString('v7');
    getBlynkValueString('v8');

    // Function to fetch data from Blynk API
    function getBlynkValue(id) {
        const apiUrl = `https://blynk.cloud/external/api/get?token=gRRmgZMZ4OJwUckS0oKJwcvGXYud1Ha3&${id}`;

        fetch(apiUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log(`Blynk API response for ${id}:`, data);
                // Update checkboxes
                if (id === 'v3') {
                    $('#pompa').prop('checked', data ? true : false).change();
                }
                if (id === 'v6') {
                    $('#otomasi').prop('checked', data ? true : false).change();
                }
                // Update range values
                if (id === 'v5') {
                    $("#batas_bawah").val(data);
                    $("#batas_bawah_value").text(data);
                }
                if (id === 'v4') {
                    $("#batas_atas").val(data);
                    $("#batas_atas_value").text(data);
                }
            })
            .catch(error => {
                console.error('Error fetching Blynk API:', error);
            });
    }

    // Function to fetch string data from Blynk API
    // Function to fetch string data from Blynk API
    function getBlynkValueString(id) {
        const apiUrl = `https://blynk.cloud/external/api/get?token=gRRmgZMZ4OJwUckS0oKJwcvGXYud1Ha3&${id}`;

        function fetchDataAndDisplay() {
            fetch(apiUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(data => {
                    console.log(`Raw Blynk API response for ${id}:`, data);
                    // Update sensor values
                    if (id === 'v0') {
                        $('#suhuBlynk').text(data);
                    }
                    if (id === 'v1') {
                        $('#humidityBlynk').text(data);
                    }
                    if (id === 'v2') {
                        $('#soilBlynk').text(data);
                    }
                    if (id === 'v8') {
                        $('#waktu_penyiraman').text(data);
                    }
                    if (id === 'v7') {
                        $('#status_penyiraman').text(data);
                    }

                })
                .catch(error => {
                    console.error('Error fetching Blynk API:', error);
                });
        }

        // Set polling interval
        const pollingInterval = 1000; // 1 second
        setInterval(fetchDataAndDisplay, pollingInterval);
        fetchDataAndDisplay();
    }




    // Function to update Blynk value
    function updateBlynkValue(id, value) {
        const apiUrl = `https://blynk.cloud/external/api/update?token=gRRmgZMZ4OJwUckS0oKJwcvGXYud1Ha3&${id}=${value}`;

        fetch(apiUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Blynk API response:', data);
            })
            .catch(error => {
                console.error('Error updating Blynk API:', error);
            });
    }

    // Function to handle updates for watering system
    function updatePenyiraman() {
        const pompaCheckbox = document.getElementById('pompa');
        const otomasiCheckbox = document.getElementById('otomasi');
        const batasAtasRange = document.getElementById('batas_atas');
        const batasBawahRange = document.getElementById('batas_bawah');

        updateBlynkValue('v3', pompaCheckbox.checked ? 1 : 0);
        updateBlynkValue('v6', otomasiCheckbox.checked ? 1 : 0);
        updateBlynkValue('v4', batasAtasRange.value);
        updateBlynkValue('v5', batasBawahRange.value);

        if (otomasiCheckbox.checked) {
            pompaCheckbox.checked = false;
            pompaCheckbox.disabled = true;
        } else {
            pompaCheckbox.disabled = false;
        }
    }

    function updateSpanValues() {
        const batasBawahRange = document.getElementById('batas_bawah');
        const batasAtasRange = document.getElementById('batas_atas');

        // Update the displayed span values
        document.getElementById('batas_bawah_value').textContent = batasBawahRange.value;
        document.getElementById('batas_atas_value').textContent = batasAtasRange.value;
    }

    document.getElementById('batas_bawah').addEventListener('input', updateSpanValues);
    document.getElementById('batas_atas').addEventListener('input', updateSpanValues);
    // On checkbox change, call the update function
    $('#pompa, #otomasi').change(updatePenyiraman);
</script>

@include('layouts.footer')

@endsection