import express from "express";
import { protectedMiddleware, adminMiddleware } from "../middleware/authMiddleware.js";
import { AllJadwal, CreateJadwal, DetailJadwal, UpdateJadwal, DeleteJadwal } from "../controllers/JadwalController.js";

const router = express.Router();

// Membuat jadwal baru (hanya admin yang bisa)
router.post("/", CreateJadwal);

// Mendapatkan semua jadwal (hanya user yang login)
router.get("/", protectedMiddleware, AllJadwal);

// Mendapatkan detail jadwal berdasarkan ID
router.get("/:id", protectedMiddleware, DetailJadwal);

// Mengupdate jadwal berdasarkan ID (hanya admin)
router.put("/:id", protectedMiddleware, adminMiddleware, UpdateJadwal);

// Menghapus jadwal berdasarkan ID (hanya admin)
router.delete("/:id", protectedMiddleware, adminMiddleware, DeleteJadwal);

export default router;
