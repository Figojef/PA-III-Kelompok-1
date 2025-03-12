import { query } from "express";
import asyncHandler from "../middleware/asyncHandler.js";
import Jadwal from "../models/jadwalModel.js";
import Lapangan from "../models/lapanganModel.js";

export const CreateJadwal = asyncHandler(async (req, res) => {
    const { lapanganId, jam, tanggal, harga } = req.body;

    // Cek apakah lapangan ada
    const lapangan = await Lapangan.findById(lapanganId);
    if (!lapangan) {
        return res.status(404).json({ message: "Lapangan tidak ditemukan" });
    }

    // Cek apakah jadwal dengan jam dan tanggal yang sama sudah ada untuk lapangan tersebut
    const existingJadwal = await Jadwal.findOne({ lapangan: lapanganId, jam, tanggal });
    if (existingJadwal) {
        return res.status(400).json({ message: "Jadwal di jam dan tanggal ini sudah ada untuk lapangan tersebut" });
    }

    // Buat jadwal baru
    const newJadwal = await Jadwal.create({
        lapangan: lapanganId,
        jam,
        tanggal,
        harga
    });

    res.status(201).json({
        message: "Berhasil menambahkan jadwal",
        data: newJadwal
    });
});


export const AllJadwal = asyncHandler(async (req, res) => {
    const jadwals = await Jadwal.find();

    console.log("Hasil Query:", jadwals); // Debugging

    if (!jadwals || jadwals.length === 0) {
        return res.status(200).json({ message: "Belum ada jadwal tersedia", data: [] });
    }

    res.status(200).json(jadwals);
});




export const detailJadwal = asyncHandler(async (req, res) => {
    const jadwal = await Jadwal.findById(req.params.id).populate("lapangan");
    if (!jadwal) {
        return res.status(404).json({ message: "Jadwal tidak ditemukan" });
    }
    res.status(200).json(jadwal);
});

export const updateJadwal = asyncHandler(async (req, res) => {
    const { jam, tanggal, harga, status } = req.body;
    const jadwal = await Jadwal.findById(req.params.id);
    if (!jadwal) {
        return res.status(404).json({ message: "Jadwal tidak ditemukan" });
    }

    jadwal.jam = jam || jadwal.jam;
    jadwal.tanggal = tanggal || jadwal.tanggal;
    jadwal.harga = harga || jadwal.harga;
    jadwal.status = status || jadwal.status;

    await jadwal.save();
    res.status(200).json({ message: "Jadwal berhasil diperbarui", data: jadwal });
});

export const deleteJadwal = asyncHandler(async (req, res) => {
    const jadwal = await Jadwal.findById(req.params.id);
    if (!jadwal) {
        return res.status(404).json({ message: "Jadwal tidak ditemukan" });
    }
    await jadwal.deleteOne();
    res.status(200).json({ message: "Jadwal berhasil dihapus" });
});
