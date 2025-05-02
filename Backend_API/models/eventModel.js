import mongoose from "mongoose";

const { Schema } = mongoose;

const eventSchema = new Schema({
    Deskripsi : {
        type: String,
        required : true,
    },
    tanggal : {
        type: String,
        required : true
    },
    gambar : {
        type: String,
        default: null
    }

})


const Event = mongoose.model("event", eventSchema)

export default Event