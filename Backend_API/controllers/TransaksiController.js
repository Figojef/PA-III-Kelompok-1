// controllers/transaksiController.js
import asyncHandler from "../middleware/asyncHandler.js";
import Transaksi from "../models/transaksiModel.js";
import Pemesanan from "../models/pemesananModel.js";

// Membuat transaksi baru
export const createTransaksi = asyncHandler(async (req, res) => {
    const { pemesanan_id, metode_pembayaran, status_pembayaran, tanggal } = req.body;

    // Cek apakah pemesanan ada
    const pemesanan = await Pemesanan.findById(pemesanan_id);
    if (!pemesanan) {
        return res.status(404).json({ message: "Pemesanan tidak ditemukan" });
    }

    const transaksi = await Transaksi.create({
        pemesanan_id,
        metode_pembayaran,
        status_pembayaran,
        tanggal
    });

    res.status(201).json({ message: "Transaksi berhasil dibuat", data: transaksi });
});

// Mendapatkan semua transaksi
export const getAllTransaksi = asyncHandler(async (req, res) => {
    const transaksi = await Transaksi.find().populate("pemesanan_id");
    res.json(transaksi);
    // res.send('ookokokokok')
});

// Mendapatkan transaksi berdasarkan ID
export const getTransaksiById = asyncHandler(async (req, res) => {
    const transaksi = await Transaksi.findById(req.params.id).populate("pemesanan_id");
    if (transaksi) {
        res.json(transaksi);
    } else {
        res.status(404).json({ message: "Transaksi tidak ditemukan" });
    }
});

// Mengupdate status pembayaran
export const updateTransaksi = asyncHandler(async (req, res) => {
    // res.send("Berhasil dibayar")
    res.status(200).json({
        message : "Transaksi dengan ID : 16gf76fgwt82g20hca9fi berhasil dibayar"
    })
    // const transaksi = await Transaksi.findById(req.params.id);

    // if (transaksi) {
    //     transaksi.status_pembayaran = req.body.status_pembayaran || transaksi.status_pembayaran;
    //     const updatedTransaksi = await transaksi.save();
    //     res.json({ message: "Transaksi berhasil diperbarui", data: updatedTransaksi });
    // } else {
    //     res.status(404).json({ message: "Transaksi tidak ditemukan" });
    // } 
});

// Menghapus transaksi
export const deleteTransaksi = asyncHandler(async (req, res) => {
    const transaksi = await Transaksi.findById(req.params.id);

    if (transaksi) {
        await transaksi.deleteOne();
        res.json({ message: "Transaksi berhasil dihapus" });
    } else {
        res.status(404).json({ message: "Transaksi tidak ditemukan" });
    }
});