import mongoose from "mongoose";

const { Schema } = mongoose;

const jadwalSchema = new Schema({    
    
    lapangan_id: {
        type: Schema.Types.ObjectId,
        ref: "Lapangan",
        required: true
    },
    jam: {
        type: String,
        required: [true, "Jam harus diisi"],
        unique: [true, "Jam sudah ada"]
    },
    tanggal: {
        type: Date,
        required: [true, "Tanggal harus diisi"]
    },
    harga: {
        type: Number, 
        required: [true, "Harga harus diisi"]
    },

    status: {
        type: String,
        enum: ["Tersedia", "Tidak Tersedia"],
        default: "Tersedia"
    }   
});

const Jadwal = mongoose.model("Jadwal", jadwalSchema);

export default Jadwal;
