import mongoose from "mongoose";

const {Schema} = mongoose

const lapanganSchema = new Schema({
    name : {
        type : String,
        required : [true, "Nama lapangan harus diisi"],
        unique : [true, "Nama lapangan sudah ada"]
    },
    description : {
        type : String,
        required : [true, 'Deskripsi lapangan harus diisi']
    },
    image : {
        type : String,
        default : null
    },
})

const Lapangan = mongoose.model("Lapangan", lapanganSchema)

export default Lapangan