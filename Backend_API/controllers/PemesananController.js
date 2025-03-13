import asyncHandler from "../middleware/asyncHandler.js";
import Pemesanan from "../models/pemesananModel.js";
import Jadwal from "../models/jadwalModel.js";
import User from "../models/userModel.js";

// 1. Membuat Pemesanan Baru
export const createPemesanan = asyncHandler(async (req, res) => {
    const { user_id, jadwal_dipesan, total_harga } = req.body;

    // Cek apakah user ada
    const user = await User.findById(user_id);
    if (!user) {
        return res.status(404).json({ message: "User tidak ditemukan" });
    }

    // Cek apakah jadwal yang dipilih ada
    const jadwalList = await Jadwal.find({ _id: { $in: jadwal_dipesan } });
    if (jadwalList.length !== jadwal_dipesan.length) {
        return res.status(400).json({ message: "Salah satu jadwal tidak valid" });
    }

    // Buat pemesanan baru
    const newPemesanan = await Pemesanan.create({
        user_id,
        jadwal_dipesan,
        total_harga,
        status_pemesanan: "Sedang Dipesan"
    });

    res.status(201).json({
        message: "Pemesanan berhasil dibuat",
        data: newPemesanan
    });
});

// 2. Mendapatkan Semua Pemesanan
export const getAllPemesanan = asyncHandler(async (req, res) => {
    const pemesanan = await Pemesanan.find().populate("user_id", "name").populate("jadwal_dipesan");
    res.status(200).json(pemesanan);
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