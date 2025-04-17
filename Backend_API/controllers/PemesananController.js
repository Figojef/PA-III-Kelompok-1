import asyncHandler from "../middleware/asyncHandler.js";
import Pemesanan from "../models/pemesananModel.js";
import Jadwal from "../models/jadwalModel.js";
import User from "../models/userModel.js";
import Transaksi from "../models/transaksiModel.js";


// 1. Membuat Pemesanan Baru
export const createPemesanan = asyncHandler(async (req, res) => {
    const { user_id, jadwal_dipesan, total_harga, metode_pembayaran } = req.body;

    // res.json({
    //     info : req.body
    // })
    // Cek apakah user ada
    const user = await User.findById(user_id);
    if (!user) {
        return res.status(404).json({ message: "User tidak ditemukan" });
    }

    // Cek apakah jadwal yang dipilih ada dan tersedia
    const jadwalList = await Jadwal.find({ _id: { $in: jadwal_dipesan } });
    if (jadwalList.length !== jadwal_dipesan.length) {
        return res.status(400).json({ message: "Salah satu jadwal tidak valid" });
    }

    // Cek apakah jadwal yang dipilih tersedia
    const unavailableJadwal = jadwalList.filter(jadwal => jadwal.status === "Tidak Tersedia");
    if (unavailableJadwal.length > 0) {
        return res.status(400).json({ message: "Salah satu jadwal tidak tersedia" });
    }

    // Buat pemesanan baru
    const newPemesanan = await Pemesanan.create({
        user_id,
        jadwal_dipesan,
        total_harga,
        status_pemesanan: "Sedang Dipesan"
    });

    // Update status jadwal yang dipesan menjadi 'Tidak Tersedia'
    await Jadwal.updateMany(
        { _id: { $in: jadwal_dipesan } },
        { $set: { status: "Tidak Tersedia" } }
    );

    // Format tanggal menjadi "YYYY-MM-DD"
    const currentDate = new Date();
    const formattedDate = currentDate.toISOString().split('T')[0];  // "2024-03-24"

    // Buat transaksi baru
    const newTransaksi = await Transaksi.create({
        pemesanan_id: newPemesanan._id,
        metode_pembayaran,
        status_pembayaran: "menunggu",  // Status pembayaran default adalah "menunggu"
        tanggal: formattedDate  // Menggunakan tanggal yang sudah diformat
    });

    res.status(201).json({
        message: "Pemesanan dan transaksi berhasil dibuat",
        data: {
            pemesanan: newPemesanan,
            transaksi: newTransaksi
        }
    });
});


// 2. Mendapatkan Semua Pemesanan
export const getAllPemesanan = asyncHandler(async (req, res) => {
    const pemesanan = await Pemesanan.find().populate("user_id", "name").populate("jadwal_dipesan");
    res.status(200).json(pemesanan);
    // res.send("okeeeeee")
});



// 3. Mendapatkan Detail Pemesanan
export const getPemesananById = asyncHandler(async (req, res) => {
    const pemesanan = await Pemesanan.findById(req.params.id)
        .populate("user_id", "name")
        .populate("jadwal_dipesan");

    if (!pemesanan) {
        return res.status(404).json({ message: "Pemesanan tidak ditemukan" });
    }

    res.status(200).json(pemesanan);
});

// 4. Mengupdate Status Pemesanan
export const updatePemesananStatus = asyncHandler(async (req, res) => {
    const { status_pemesanan } = req.body;

    const pemesanan = await Pemesanan.findById(req.params.id);
    if (!pemesanan) {
        return res.status(404).json({ message: "Pemesanan tidak ditemukan" });
    }

    pemesanan.status_pemesanan = status_pemesanan || pemesanan.status_pemesanan;
    await pemesanan.save();

    res.status(200).json({ message: "Status pemesanan diperbarui", data: pemesanan });
});

// 5. Menghapus Pemesanan
export const deletePemesanan = asyncHandler(async (req, res) => {
    const pemesanan = await Pemesanan.findById(req.params.id);
    if (!pemesanan) {
        return res.status(404).json({ message: "Pemesanan tidak ditemukan" });
    }

    await pemesanan.deleteOne();
    res.status(200).json({ message: "Pemesanan berhasil dihapus" });
}); 


// 6. Mendapatkan Pemesanan Berdasarkan user_id
export const getPemesananByUserId = asyncHandler(async (req, res) => {
    const { user_id } = req.params; // Mengambil user_id dari parameter URL
    
    // Step 1: Get pemesanan (bookings) based on user_id
    const pemesanan = await Pemesanan.find({ user_id })
        .populate("user_id", "name")
        .populate({
            path: "jadwal_dipesan",
            populate: {
                path: "lapangan", // Populate lapangan field inside Jadwal
                select: "name", // Only select the name field from Lapangan
            }
        });

    if (!pemesanan || pemesanan.length === 0) {
        return res.status(404).json({ message: "Pemesanan tidak ditemukan untuk user_id ini." });
    }

    // Step 2: Get related transaksi (transactions) based on pemesanan_id
    const transaksi = await Transaksi.find({
        pemesanan_id: { $in: pemesanan.map(p => p._id) } // Fetch transactions that match the pemesanan_id
    }).select("metode_pembayaran status_pembayaran tanggal pemesanan_id");

    // Step 3: Combine pemesanan and transaksi data
    // Adding transaksi data to each pemesanan
    const pemesananWithTransaksi = pemesanan.map(p => {
        const relatedTransaksi = transaksi.filter(t => t.pemesanan_id.toString() === p._id.toString());
        return {
            ...p.toObject(), // Convert Mongoose document to plain object
            transaksi: relatedTransaksi
        };
    });

    res.status(200).json(pemesananWithTransaksi);
});


export const pesananJadwalBelumLewat = asyncHandler(async (req, res) => {
    const { user_id } = req.params;

    // 1. Cek apakah user ada
    const user = await User.findById(user_id);
    if (!user) {
        return res.status(404).json({ success: false, message: "User tidak ditemukan" });
    }

    // 2. Ambil semua pemesanan oleh user, dan populate jadwal_dipesan
    const pemesananList = await Pemesanan.find({ user_id }).populate("jadwal_dipesan");

    // 3. Ambil waktu sekarang
    const now = new Date();

    // 4. Loop jadwal dan cek apakah masih ada yang belum lewat
    let masihAdaYangBelumLewat = false;

    for (const pemesanan of pemesananList) {
        for (const jadwal of pemesanan.jadwal_dipesan) {
            // Format jam ke 2 digit, misal "8" jadi "08"
            const jamFormatted = jadwal.jam.padStart(2, "0");

            // Gabungkan jadi date time
            const jadwalDateTime = new Date(`${jadwal.tanggal}T${jamFormatted}:00:00`);

            if (jadwalDateTime > now) {
                masihAdaYangBelumLewat = true;
                break;
            }
        }
        if (masihAdaYangBelumLewat) break;
    }

    return res.status(200).json({
        success: true,
        masihAdaJadwalBelumLewat: masihAdaYangBelumLewat
    });
});



