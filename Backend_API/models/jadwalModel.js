import mongoose from "mongoose";

const { Schema } = mongoose;

const jadwalSchema = new Schema({
  lapangan: {
    type: mongoose.Schema.Types.ObjectId,
    ref: "Lapangan",
    required: true,
  },
  jam: {
    type: String,
    required: [true, "Jam harus diisi"],
  },
  tanggal: {
    type: String,
    required: [true, "Tanggal harus diisi"],
  },
  harga: {
    type: Number,
    required: [true, "Harga harus diisi"],
  },
  status: {
    type: String,
    enum: ["Tersedia", "Tidak Tersedia"],
    default: "Tersedia",
  }
});

// Membuat composite index yang menggabungkan lapangan, tanggal, dan jam
// Menjamin bahwa duplikasi jam hanya bisa terjadi pada lapangan dan tanggal yang berbeda
jadwalSchema.index({ lapangan: 1, tanggal: 1, jam: 1 }, { unique: true });

// Membuat model
const Jadwal = mongoose.model("Jadwal", jadwalSchema);

export default Jadwal;



// import mongoose from "mongoose";

// const { Schema } = mongoose;

// const jadwalSchema = new Schema({
//   lapangan: {
//     type: mongoose.Schema.Types.ObjectId,
//     ref: "Lapangan",
//     required: true
//   },
//   jam: {
//     type: String,
//     required: [true, "Jam harus diisi"],
//   },
//   tanggal: {
//     type: String,
//     required: [true, "Tanggal harus diisi"]
//   },
//   harga: {
//     type: Number,
//     required: [true, "Harga harus diisi"]
//   },
//   status: {
//     type: String,
//     enum: ["Tersedia", "Tidak Tersedia"],
//     default: "Tersedia"
//   }
// });


// const Jadwal = mongoose.model("Jadwal", jadwalSchema);

// export default Jadwal;


