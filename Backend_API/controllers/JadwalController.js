// import { query } from "express";
import asyncHandler from "../middleware/asyncHandler.js";
// import Product from "../models/productModel.js";
// import { v2 as cloudinary } from "cloudinary";
// import streamifier from "streamifier"
import Lapangan from "../models/lapanganModel.js";
import Jadwal from "../models/jadwalModel.js";
import mongoose from 'mongoose';


export const AllJadwal = asyncHandler(async (req, res) => {
    // Fetch all jadwals from the database, populating the 'lapangan' field
    const jadwals = await Jadwal.find()
      .populate("lapangan", "name")  // Populate the lapangan field with only the name of the lapangan
      .sort({ tanggal: 1 });  // Optionally, sort by tanggal (ascending)
  
    // If no jadwals are found, return a 404 response
    if (!jadwals || jadwals.length === 0) {
      return res.status(404).json({
        success: false,
        message: "No jadwals found",
      });
    }
  
    // Respond with the retrieved jadwals data
    res.status(200).json({
      success: true,
      data: jadwals,
    });
  });


  // Fungsi untuk menangani request asinkron
  export const CreateJadwal = asyncHandler(async (req, res) => {
    const { lapangan, jam, tanggal, harga, status } = req.body;
  
    // Validasi jika lapangan, jam, tanggal, dan harga sudah ada
    if (!lapangan || !jam || !tanggal || !harga) {
      res.status(400).json({ message: "Semua field harus diisi" });
      return;
    }
  
    // Mengecek apakah jadwal dengan kombinasi lapangan, tanggal, dan jam sudah ada
    const existingJadwal = await Jadwal.findOne({
      lapangan,
      tanggal,
      jam,
    });
  
    if (existingJadwal) {
      return res.status(400).json({
        message: `Jadwal dengan jam ${jam} pada lapangan ${lapangan} dan tanggal ${tanggal} sudah ada.`,
      });
    }
  
    // Membuat objek Jadwal baru
    const newJadwal = new Jadwal({
      lapangan,
      jam,
      tanggal,
      harga,
      status: status || "Tersedia", // Status default "Tersedia" jika tidak diisi
    });
  
    // Menyimpan jadwal baru ke database
    const savedJadwal = await newJadwal.save();
  
    // Mengirimkan response jika berhasil
    res.status(201).json({
      message: "Jadwal berhasil dibuat",
      data: savedJadwal,
    });
  });
  


  // export const CreateJadwal = asyncHandler(async (req, res) => {

  //   const { lapangan, jam, tanggal, harga, status } = req.body;

  //   // Validate if lapangan is provided
  //   if (!lapangan || !jam || !tanggal || !harga) {
  //     res.status(400).json({ message: "All fields are required" });
  //     return;
  //   }
  
  //   // Create the new Jadwal document
  //   const newJadwal = new Jadwal({
  //     lapangan,
  //     jam,
  //     tanggal,
  //     harga,
  //     status: status || "Trersedia", // Default status to "Tersedia" if not provided
  //   });
  
  //   // Save the new Jadwal to the database
  //   const savedJadwal = await newJadwal.save();
  
  //   // Respond with the created Jadwal
  //   res.status(201).json({
  //     message: "Jadwal created successfully",
  //     data: savedJadwal,
  //   });
  //   // const { lapangan, jam, tanggal, harga, status } = req.body;
  
  //   // // Validate if lapangan is provided
  //   // if (!lapangan || !jam || !tanggal || !harga) {
  //   //   res.status(400).json({ message: "All fields are required" });
  //   //   return;
  //   // }
  
  //   // // Create the new Jadwal document
  //   // const newJadwal = new Jadwal({
  //   //   lapangan,
  //   //   jam,
  //   //   tanggal,
  //   //   harga,
  //   //   status: status || "Tersedia", // Default status to "Tersedia" if not provided
  //   // });
  
  //   // // Save the new Jadwal to the database
  //   // const savedJadwal = await newJadwal.save();
  
  //   // // Respond with the created Jadwal
  //   // res.status(201).json({
  //   //   message: "Jadwal created successfully",
  //   //   data: savedJadwal,
  //   // });
  //   // res.status(201).json({
  //   //   youtData : req.body
  //   // })
  // });

  // CreateJadwal function with validation
// export const CreateJadwal = asyncHandler(async (req, res) => {
//   const { lapangan, jam, tanggal, harga, status } = req.body;

//   // Check if the schedule already exists for the same lapangan, jam, and tanggal
//   const existingJadwal = await Jadwal.findOne({ lapangan, jam, tanggal });

//   if (existingJadwal) {
//     return res.status(400).json({
//       message: "Jadwal sudah ada untuk lapangan ini pada jam dan tanggal tersebut.",
//     });
//   }

//   // Create the new jadwal
//   const newJadwal = new Jadwal({
//     lapangan,
//     jam,
//     tanggal,
//     harga,
//     status: status || "Tersedia", // Default to "Tersedia" if not provided
//   });

//   await newJadwal.save();

//   // Respond with the newly created jadwal
//   res.status(201).json({
//     message: "Jadwal berhasil dibuat",
//     jadwal: newJadwal,
//   });
// });
  // export const CreateJadwal = asyncHandler(async (req, res) => {
  //   // Mendapatkan data dari body request
  //   const { lapangan, jam, tanggal, harga, status } = req.body;
  
  //   // Validasi data yang diterima
  //   if (!lapangan || !jam || !tanggal || !harga) {
  //     return res.status(400).json({
  //       success: false,
  //       message: "Harap isi semua data yang dibutuhkan: lapangan, jam, tanggal, harga",
  //     });
  //   }
  
  //   // Cek apakah lapangan yang diberikan ada di database
  //   const foundLapangan = await Lapangan.findById(lapangan);
  //   if (!foundLapangan) {
  //     return res.status(404).json({
  //       success: false,
  //       message: "Lapangan tidak ditemukan",
  //     });
  //   }
  
  //   // Cek apakah jam yang dipilih sudah ada untuk lapangan dan tanggal yang sama
  //   const existingJadwal = await Jadwal.findOne({ lapangan, jam, tanggal });
  //   if (existingJadwal) {
  //     return res.status(400).json({
  //       success: false,
  //       message: "Waktu yang dipilih sudah terisi untuk lapangan dan tanggal ini",
  //     });
  //   }
  
  //   // Membuat jadwal baru
  //   const jadwal = await Jadwal.create({
  //     lapangan,
  //     jam,
  //     tanggal,
  //     harga,
  //     status: status || "Tersedia",  // Status default "Tersedia" jika tidak diisi
  //   });
  
  //   // Mengirimkan response dengan jadwal yang baru dibuat
  //   res.status(201).json({
  //     success: true,
  //     data: jadwal,
  //   });
  // });


  
  export const JadwalByDateAndLapangan = asyncHandler(async (req, res) => {
    const { tanggal, lapangan } = req.query;

    if (!tanggal || !lapangan) {
        return res.status(400).json({ message: "Tanggal dan Lapangan harus diisi" });
    }

    if (!mongoose.Types.ObjectId.isValid(lapangan)) {
        return res.status(400).json({ message: "Lapangan ID tidak valid" });
    }

    try {
        const jadwal = await Jadwal.find({
            tanggal, lapangan
        })
        .populate("lapangan");

        if (!jadwal.length) {
            return res.status(404).json({ message: "Jadwal tidak ditemukan" });
        }

        res.status(200).json(jadwal);
    } catch (error) {
        res.status(500).json({ message: "Terjadi kesalahan server", error: error.message });
    }
});


export const JadwalByLapangan = asyncHandler(async (req, res) => {
  const { lapanganId } = req.params;  // Assuming lapanganId is passed as a route param

  // Check if the Lapangan exists
  const lapangan = await Lapangan.findById(lapanganId);
  if (!lapangan) {
      return res.status(404).json({ message: "Lapangan not found" });
  }

    // Fetch jadwal by lapanganId
    const jadwalList = await Jadwal.find({ lapangan: lapanganId });

    // if (jadwalList.length === 0) {
    //     return res.status(404).json({ message: "No jadwal found for this lapangan" });
    // }
  
    // Respond with the list of jadwal for the specified lapangan
    res.status(200).json(jadwalList);


});

  


export const DetailJadwal = asyncHandler(async(req,res) => {
    res.send("Detail Jadwal")
})

export const UpdateJadwal = asyncHandler(async(req,res) => {
    res.send("Update Jadwal")
})

export const DeleteJadwal = asyncHandler(async(req,res) => {
    res.send("Delete Jadwal")
})





