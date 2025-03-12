import mongoose from "mongoose";

const { Schema } = mongoose;

const pemesananSchema = new Schema({    
    
    user_id: {
        type: Schema.Types.ObjectId,
        ref: "User",
        required: true
    },
    total_harga: {
        type: String,
        required: [true]
    },
    jadwal_dipesan: [
        {
            type: Schema.Types.ObjectId,
            ref: "Jadwal"
        }
    ],

    status_pemesanan: {
        type: String,
        enum: ["Sedang Dipesan", "Berhasil", "Dibatalkan"],
        default: "Sedang Dipesan"
    }   
});

const Pemesanan = mongoose.model("Pemesanan", pemesananSchema);

export default Pemesanan;
