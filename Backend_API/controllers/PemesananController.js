import asyncHandler from "../middleware/asyncHandler.js";
import Pemesanan from "../models/pemesananModel.js";
import Jadwal from "../models/jadwalModel.js";
import User from "../models/userModel.js";
import Transaksi from "../models/transaksiModel.js";


// 1. Membuat Pemesanan Baru
export const createPemesanan = asyncHandler(async (req, res) => {
    const { user_id, jadwal_dipesan, total_harga, metode_pembayaran } = req.body;

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
// export const createPemesanan = asyncHandler(async (req, res) => {
//     const { user_id, jadwal_dipesan, total_harga, metode_pembayaran } = req.body;

//     // Cek apakah user ada
//     const user = await User.findById(user_id);
//     if (!user) {
//         return res.status(404).json({ message: "User tidak ditemukan" });
//     }

//     // Cek apakah jadwal yang dipilih ada dan tersedia
//     const jadwalList = await Jadwal.find({ _id: { $in: jadwal_dipesan } });
//     if (jadwalList.length !== jadwal_dipesan.length) {
//         return res.status(400).json({ message: "Salah satu jadwal tidak valid" });
//     }

//     // Cek apakah jadwal yang dipilih tersedia
//     const unavailableJadwal = jadwalList.filter(jadwal => jadwal.status === "Tidak Tersedia");
//     if (unavailableJadwal.length > 0) {
//         return res.status(400).json({ message: "Salah satu jadwal tidak tersedia" });
//     }

//     // Buat pemesanan baru
//     const newPemesanan = await Pemesanan.create({
//         user_id,
//         jadwal_dipesan,
//         total_harga,
//         status_pemesanan: "Sedang Dipesan"
//     });

//     // Update status jadwal yang dipesan menjadi 'Tidak Tersedia'
//     await Jadwal.updateMany(
//         { _id: { $in: jadwal_dipesan } },
//         { $set: { status: "Tidak Tersedia" } }
//     );

//     res.status(201).json({
//         message: "Pemesanan berhasil dibuat",
//         data: newPemesanan
//     });
// });
// export const createPemesanan = asyncHandler(async (req, res) => {
//     const { user_id, jadwal_dipesan, total_harga } = req.body;

//     // Cek apakah user ada
//     const user = await User.findById(user_id);
//     if (!user) {
//         return res.status(404).json({ message: "User tidak ditemukan" });
//     }

//     // Cek apakah jadwal yang dipilih ada
//     const jadwalList = await Jadwal.find({ _id: { $in: jadwal_dipesan } });
//     if (jadwalList.length !== jadwal_dipesan.length) {
//         return res.status(400).json({ message: "Salah satu jadwal tidak valid" });
//     }

//     // Buat pemesanan baru
//     const newPemesanan = await Pemesanan.create({
//         user_id,
//         jadwal_dipesan,
//         total_harga,
//         status_pemesanan: "Sedang Dipesan"
//     });

//     res.status(201).json({
//         message: "Pemesanan berhasil dibuat",
//         data: newPemesanan
//     });
// });

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
    
    // Mencari pemesanan berdasarkan user_id
    const pemesanan = await Pemesanan.find({ user_id }).populate("user_id", "name").populate("jadwal_dipesan");

    if (!pemesanan || pemesanan.length === 0) {
        return res.status(404).json({ message: "Pemesanan tidak ditemukan untuk user_id ini." });
    }

    res.status(200).json(pemesanan);
});

