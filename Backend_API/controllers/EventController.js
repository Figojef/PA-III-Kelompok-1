import asyncHandler from "../middleware/asyncHandler.js";
import { v2 as cloudinary } from "cloudinary";
import streamifier from "streamifier";
import Event from "../models/eventModel.js";

// Controller untuk create event
export const CreateEvent = asyncHandler(async (req, res) => {
  let imageUrl = null;

  // Pastikan file ada yang di-upload
  if (req.file) {
    try {
      // Gunakan Promise untuk memastikan gambar di-upload sebelum lanjut ke penyimpanan event
      imageUrl = await new Promise((resolve, reject) => {
        const stream = cloudinary.uploader.upload_stream(
          {
            folder: "event_images", // Folder di Cloudinary
            allowed_formats: ["jpg", "png"], // Format gambar yang diizinkan
          },
          function (err, result) {
            if (err) {
              console.log("Cloudinary error:", err);
              reject(err); // Reject jika ada error dalam upload
            } else {
              console.log("Cloudinary result:", result);
              resolve(result.secure_url); // Resolve dengan URL jika berhasil
            }
          }
        );

        // Kirim buffer gambar ke Cloudinary
        streamifier.createReadStream(req.file.buffer).pipe(stream);
      });
    } catch (err) {
      console.error("Gagal upload gambar:", err);
      return res.status(500).json({
        message: "Gagal upload gambar",
        error: err,
      });
    }
  }

  // Membuat event baru dengan data yang diterima dari body request
  const newEvent = await Event.create({
    ...req.body, // Deskripsi, tanggal dari body request
    gambar: imageUrl, // Simpan URL gambar yang sudah di-upload
  });

  // Mengirim respons jika event berhasil dibuat
  res.status(201).json({
    message: "Berhasil tambah event",
    data: newEvent,
  });
});
