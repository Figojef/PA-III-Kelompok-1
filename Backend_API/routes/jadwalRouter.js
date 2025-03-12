import express from "express";
import { protectedMiddleware, adminMiddleware } from "../middleware/authMiddleware.js";
import { AllJadwal, CreateJadwal, detailJadwal, updateJadwal, deleteJadwal } from "../controllers/JadwalController.js";

const router = express.Router();

// Membuat jadwal baru (hanya admin yang bisa)
router.post("/", protectedMiddleware, adminMiddleware, CreateJadwal);

// Mendapatkan semua jadwal (hanya user yang login)
router.get("/", protectedMiddleware, AllJadwal);

// Mendapatkan detail jadwal berdasarkan ID
router.get("/:id", protectedMiddleware, detailJadwal);

// Mengupdate jadwal berdasarkan ID (hanya admin)
router.put("/:id", protectedMiddleware, adminMiddleware, updateJadwal);

// Menghapus jadwal berdasarkan ID (hanya admin)
router.delete("/:id", protectedMiddleware, adminMiddleware, deleteJadwal);

export default router;
