@extends('layouts.app')

@section('content')

<title>Jadwal Bermain</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .schedule-header {
            background-color: #343a40;
            color: #fff;
            padding: 8px 12px;
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
        .green { background-color: green; }
        .red { background-color: red; }
        .grey { background-color: grey; }
        .blue { background-color: blue; }
        .orange { background-color: orange; }
        .legend {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-top: 15px;
        }
        .legend-item {
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h4>Jadwal bermain</h4>
        <div class="mb-3">
            <label for="datePicker" class="form-label">Pilih Tanggal</label>
            <input type="date" id="datePicker" class="form-control">
        </div>

        <div class="row" id="scheduleContainer">
            <!-- Konten Jadwal Akan Dimanipulasi Lewat JavaScript -->
        </div>

        <div class="legend">
            <div class="legend-item"><div class="circle green"></div> Jadwal tersedia</div>
            <div class="legend-item"><div class="circle red"></div> Jadwal sudah di-booking</div>
            <div class="legend-item"><div class="circle blue"></div> Jadwal Dipilih</div>
            <div class="legend-item"><div class="circle grey"></div> Jadwal Tetap</div>
            <div class="legend-item"><div class="circle orange"></div> Jadwal Member</div>
        </div>
    </div>

    <script>
        const scheduleData = {
            "2025-03-03": [
                { time: "06:00 - 07:00", status: "green" },
                { time: "07:00 - 08:00", status: "green" },
                { time: "08:00 - 09:00", status: "green" },
                { time: "09:00 - 10:00", status: "red" },
                { time: "10:00 - 11:00", status: "grey" },
                { time: "11:00 - 12:00", status: "green" }
            ],
            "default": [
                { time: "06:00 - 07:00", status: "grey" },
                { time: "07:00 - 08:00", status: "grey" },
                { time: "08:00 - 09:00", status: "grey" },
                { time: "09:00 - 10:00", status: "grey" },
                { time: "10:00 - 11:00", status: "grey" },
                { time: "11:00 - 12:00", status: "grey" },
                { time: "12:00 - 13:00", status: "grey" },
                { time: "13:00 - 14:00", status: "grey" },
                { time: "14:00 - 15:00", status: "grey" },
                { time: "15:00 - 16:00", status: "grey" },
                { time: "16:00 - 17:00", status: "grey" },
                { time: "17:00 - 18:00", status: "grey" },
                { time: "18:00 - 19:00", status: "grey" },
                { time: "19:00 - 20:00", status: "grey" },
                { time: "20:00 - 21:00", status: "grey" }
            ]
        };

        async function fetchSchedule(date) {
    try {
        const response = await fetch(`/api/jadwal?date=${date}`);
        const data = await response.json();
        renderSchedule(data, date);
    } catch (error) {
        console.error("Error fetching schedule:", error);
    }
}

function renderSchedule(scheduleData, date) {
    const scheduleContainer = document.getElementById('scheduleContainer');
    scheduleContainer.innerHTML = '';

    if (!scheduleData || Object.keys(scheduleData).length === 0) {
        scheduleContainer.innerHTML = '<p class="text-center">Tidak ada jadwal tersedia.</p>';
        return;
    }

    Object.entries(scheduleData).forEach(([lapanganId, jadwal]) => {
        const lapanganDiv = document.createElement('div');
        lapanganDiv.classList.add('col-md-6');
        lapanganDiv.innerHTML = `<div class="schedule-header">Lapangan ${lapanganId} - ${date}</div>` +
            jadwal.map(slot => `
                <div class="time-slot"><div class="circle ${slot.status}"></div> ${slot.time}</div>
            `).join('');
        scheduleContainer.appendChild(lapanganDiv);
    });
}

document.getElementById('datePicker').addEventListener('change', function () {
    fetchSchedule(this.value);
});

// Load default schedule for the initial date
fetchSchedule("2025-03-03");

    </script>

@endsection
