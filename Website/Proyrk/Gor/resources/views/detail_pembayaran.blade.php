@extends('layouts.app')

@section('content')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="">

    <title>Jadwal Bermain</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        #judul {
            display: flex; 
            justify-content: center; 
            align-items: center;
        }

        .informasi1 {
            font-size: 25px;
            font-weight: light;
        }

        .informasi2 {
            font-size: 25px;
            font-weight: light;
            margin-bottom: 25px;
        }

        .tombol {
            color: white;
            font-weight: 700;
            background-color: black;
            width: 100%;       
            height: 40px;      
            border-radius: 10px;      
            font-size: 16px;   
        }

        /* Flexbox container to align payment details and countdown side by side */
        .container-flex {
            display: flex;
            justify-content: space-between; /* This will spread the left and right sections */
            margin-bottom: 20px;
            align-items: center; /* This ensures they align at the same height */
        }

        .left-section {
            flex: 1; /* This ensures that the left section takes up as much space as possible */
        }

        .right-section {
            flex: 0.4; /* This gives the right section 40% of the space */
            display: flex;
            justify-content: flex-end; /* Align countdown to the right */
            align-items: center;
        }

        .deadline {
            display: flex;
            align-items: center;
        }

        .deadline-content {
            display: flex;
            align-items: center;
        }

        .icon-deadline {
            margin-right: 10px;
            cursor: pointer; /* To indicate it's clickable */
        }

        /* Optional: Adjust spacing between countdown and payment info */
        .countdown-container .deadline-content p {
            margin-left: 10px;
        }
    </style>

<body>
    <div class="container mt-4">
        <h2 id="judul">Detail Pembayaran</h2>

        <!-- First <hr> line -->
        <hr style="border: 2px solid #000000; margin: 20px 0;">

        <!-- Flex container holding countdown and payment info -->
        <div class="container-flex">
            <!-- Left Section: Payment Details -->
            <div class="left-section">
                <label class="informasi1">Nomor Rekening</label><br>
                <label class="informasi2" id="rekening">7172 7838 7489234</label> 
                <!-- Salin icon (path updated to public/icons) -->
                <img src="{{ asset('icons/icon_Copy.png') }}" alt="Icon" width="20" height="20" id="copyButton" style="cursor: pointer;" onclick="copyToClipboard()"> <br>

                <label class="informasi1">Atas Nama</label><br>
                <label class="informasi2">Yakop Simatupang</label><br>

                <label class="informasi1">Nominal Transfer</label><br>  
                <label class="informasi2">Rp. 60.000</label><br>

                <form action="/upload_bukti" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="YOUR_CSRF_TOKEN_HERE">
                    <input type="file" name="bukti_transfer" id="upload" class="d-none" accept="image/*,application/pdf" required>





            </div>

            <!-- Right Section: Countdown -->
            <div class="right-section">
                <div class="deadline">
                    <div class="deadline-content">
                        <!-- Deadline icon (path updated to public/icons) -->
                        <img src="{{ asset('icons/icon_Jam.png') }}" alt="Icon" width="30" height="30" class="icon-deadline" onclick="downloadImage()">
                        <p>Batas Akhir Pembayaran <br>
                        <strong id="countdown"></strong></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second <hr> line -->
        <hr style="border: 2px solid #000000; margin: 20px 0;">
        <input type="submit" class="tombol" value="Konfirmasi Pemesanan">
    </div>

    <script>
  // Ambil data deadline dari session Laravel
  const deadlineString = "{{ session('payment_deadline') }}";  // Format: "YYYY-MM-DD HH:MM:SS"
    const deadlineDate = new Date(deadlineString); // Konversi string ke objek Date

    // Fungsi untuk menghitung countdown
    function updateCountdown() {
        const now = new Date().getTime();
        const timeLeft = deadlineDate - now;

        if (timeLeft <= 0) {
            document.getElementById("countdown").innerHTML = "Waktu Habis";
            clearInterval(countdownInterval);
        } else {
            const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
            document.getElementById("countdown").innerHTML = hours + "h " + minutes + "m " + seconds + "s ";
        }
    }

    // Perbarui countdown setiap detik
    const countdownInterval = setInterval(updateCountdown, 1000);

        // Run once to show initial value
        updateCountdown();

        // Function to copy the rekening number to clipboard
        function copyToClipboard() {
            const rekening = document.getElementById("rekening").innerText;
            const copyButton = document.getElementById("copyButton");
            
            // Change the icon to 'copied' icon
            copyButton.src = "{{ asset('icons/icon_Copydone.png') }}"; 

            // Attempt to copy the text to the clipboard
            navigator.clipboard.writeText(rekening).then(() => {
                // Revert the icon after 2 seconds
                setTimeout(() => {
                    copyButton.src = "{{ asset('icons/icon_Copy.png') }}"; // Reset to original icon
                }, 2000);
            }).catch(err => {
            });
        }

        // Function to download the image when the countdown icon is clicked
        function downloadImage() {
            const imageUrl = "{{ asset('icons/icon_Jam.png') }}"; //     URL of the image
            const link = document.createElement("a");
            link.href = imageUrl;
            link.download = "deadline_icon.png"; // Image will be saved as deadline_icon.png
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
@endsection
