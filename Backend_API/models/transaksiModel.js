import mongoose from "mongoose";

const { Schema } = mongoose;

const transaksiSchema = new Schema({    
    
    pemesanan_id: {
        type: Schema.Types.ObjectId,
        ref: "Pemesanan",
        required: true
    },
    metode_pembayaran: {
        type: String,
        enum: ["transfer_bank", "bayar_langsung"],
        required: [true]
    },
    status_pembayaran: {
        type: String,
        enum: ["berhasil", "menunggu"],
        default: "menunggu",
        required: [true]
    },
    tanggal: {
        type: String,
        default : null
    },
    deadline_pembayaran: {
        type: Date,
        required: true
    }
});

const Transaksi = mongoose.model("Transaksi", transaksiSchema);

export default Transaksi;