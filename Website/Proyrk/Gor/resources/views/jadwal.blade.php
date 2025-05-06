@extends('layouts.app')

@section('content')
    <title>Jadwal Bermain</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .jadwal-header {
            background-color: #343a40;
            color: #fff;
            padding: 8px 12px;
        }

        .jadwal-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ddd;
            margin-bottom: 0;
            background-color: #fff;
        }

        .jadwal-table th,
        .jadwal-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .jadwal-table th {
            background-color: #222F37;
            font-weight: bold;
            color: white;
        }

        .jadwal-item {
            color: red;
        }

        .time-slot {
            display: flex;
            align-items: center;
            padding: 5px 10px;
            border-bottom: 1px solid #dee2e6;
        }

        .circle {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .green {
            background-color: green;
        }

        .red {
            background-color: red;
        }

        .grey {
            background-color: grey;
        }

        .blue {
            background-color: blue;
        }

        .orange {
            background-color: orange;
        }

        .legend {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .legend-item {
            display: flex;
            align-items: center;
        }

        .lapangan-header {
            background-color: #343a40;
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px 5px 0 0;
        }

        .lapangan-container {
            margin-bottom: 30px;
            border-radius: 5px;
            overflow: hidden;
        }

        .form-label {
            margin-bottom: 10px;
        }

        .form-control {
            margin-bottom: 20px;
        }

        .expired-row {
            color: #999 ;
        }

    </style>

    <div class="container mt-5">
        <h4>Jadwal bermain</h4>
        <div class="mb-3">
            <label for="tanggal" class="form-label">Pilih Tanggal</label>
            <input type="date" id="tanggal" class="form-control">
        </div>

        <div class="row" id="jadwalContainer">
            <!-- Konten Jadwal Akan Dimanipulasi Lewat JavaScript -->
        </div>

        <div class="legend">
            <div class="legend-item">
                <div class="circle green"></div> Jadwal tersedia
            </div>
            <div class="legend-item">
                <div class="circle red"></div> Jadwal sudah di-booking
            </div>
        <div id="base-url" style="display:none">{{ env('API_BASE_URL') }}</div>
    </div>

    <script>
function renderjadwal(jadwalData, selectedDate = new Date().toISOString().split('T')[0]) {
    console.log("Data diterima di renderjadwal:", jadwalData);

    const container = document.getElementById("jadwalContainer");
    if (!container) {
        console.error("Element jadwalContainer tidak ditemukan di HTML.");
        return;
    }

    container.innerHTML = ""; // Hapus konten lama

    if (!jadwalData || jadwalData.length === 0) {
        container.innerHTML = "<p>Tidak ada jadwal tersedia.</p>";
        return;
    }

    const dateObj = new Date(selectedDate);
    const options = { day: 'numeric', month: 'long', year: 'numeric' };
    const formattedDate = dateObj.toLocaleDateString('id-ID', options);
    const dayOptions = { weekday: 'long' };
    const dayName = dateObj.toLocaleDateString('id-ID', dayOptions);

    const groupedByLapangan = jadwalData.reduce((acc, item) => {
        const lapanganName = item.lapangan?.name || "Tanpa Nama";
        if (!acc[lapanganName]) acc[lapanganName] = [];
        acc[lapanganName].push(item);
        return acc;
    }, {});

    const sortedLapangan = Object.keys(groupedByLapangan).sort();

    sortedLapangan.forEach((lapangan) => {
        const lapanganCol = document.createElement("div");
        lapanganCol.classList.add("col-md-6");

        const lapanganDiv = document.createElement("div");
        lapanganDiv.classList.add("lapangan-container");

        lapanganDiv.innerHTML = `
            <div class="lapangan-header" style="display: flex; justify-content: space-between; align-items: center;">
                <div style="text-align: left;">
                    <h3 style="margin: 0;">${lapangan}</h3>
                    <small style="color: #ccc;">${dayName}</small>
                </div>
                <div style="text-align: right;">
                    <span style="font-size: 1.1em; color: #fff;">${formattedDate}</span>
                </div>
            </div>
        `;

        const jadwalList = groupedByLapangan[lapangan];
        jadwalList.sort((a, b) => a.jam - b.jam);

        const leftColumn = jadwalList.slice(0, 8);
        const rightColumn = jadwalList.slice(8, 16);

        const columnsContainer = document.createElement("div");
        columnsContainer.style.display = "flex";
        columnsContainer.style.gap = "16px";
        columnsContainer.style.flexWrap = "wrap";
        columnsContainer.style.marginTop = "10px";
        columnsContainer.style.justifyContent = "space-between";

        function createJadwalTable(dataSubset) {
            const table = document.createElement("table");
            table.classList.add("jadwal-table");
            table.style.width = "48%";

            const thead = document.createElement("thead");
            const headerRow = document.createElement("tr");
            headerRow.innerHTML = `<th>Jam</th>`;
            thead.appendChild(headerRow);
            table.appendChild(thead);

            const tbody = document.createElement("tbody");

            dataSubset.forEach(item => {
    const row = document.createElement("tr");

    // Cek apakah slot sudah lewat (expired)
    const jam = item.jam.toString().padStart(2, '0');
    const tanggalInput = document.getElementById("tanggal").value;
    const slotDate = new Date(`${tanggalInput}T${jam}:00:00`);
    const now = new Date().toLocaleString("en-US", { timeZone: "Asia/Jakarta" });
    const nowDate = new Date(now);

    if (slotDate <= nowDate) {
        row.classList.add("expired-row");
    }

    const statusJamCell = document.createElement("td");
    statusJamCell.style.display = "flex";
    statusJamCell.style.alignItems = "center";
    statusJamCell.style.justifyContent = "center";
    statusJamCell.style.gap = "8px";

    const status = document.createElement("div");
    let statusClass = "circle";

    if (item.status_booking === "Tersedia") {
        statusClass += " green";
    } else if (item.status_booking === "Tidak Tersedia") {
        statusClass += " red";
    }

    status.className = statusClass;

    const jamCell = document.createElement("span");
    const startHour = jam;
    const endHour = (parseInt(jam) + 1).toString().padStart(2, '0');
    jamCell.textContent = `${startHour}:00 - ${endHour}:00`;

    statusJamCell.appendChild(status);
    statusJamCell.appendChild(jamCell);
    row.appendChild(statusJamCell);
    tbody.appendChild(row);
});


            table.appendChild(tbody);
            return table;
        }

        columnsContainer.appendChild(createJadwalTable(leftColumn));
        columnsContainer.appendChild(createJadwalTable(rightColumn));
        lapanganDiv.appendChild(columnsContainer);
        lapanganCol.appendChild(lapanganDiv);
        container.appendChild(lapanganCol);
    });
}

        async function fetchJadwalByTanggal(tanggal) {
            if (!tanggal) {
                alert('Tanggal belum dipilih.');
                return;
            }

            try {
                const apiBaseUrl = document.getElementById('base-url').textContent;

                if (!apiBaseUrl) {
                    throw new Error('API Base URL tidak ditemukan');
                }

                const response = await fetch(`${apiBaseUrl}jadwal/tanggal/${tanggal}`);

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                console.log(data);

                if (!data || data.length === 0) {
                    alert('Jadwal tidak ditemukan');
                    return;
                }

                renderjadwal(data, tanggal);
            } catch (error) {
                console.error("Error fetching jadwal:", error);
                alert('Jadwal tidak ada.');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('tanggal').value = today;
            fetchJadwalByTanggal(today);
        });

        document.getElementById('tanggal').addEventListener('change', function() {
            fetchJadwalByTanggal(this.value);
        });
    </script>
@endsection
