import express from "express"

// Router
import authRouter from './routes/authRouter.js'
import productRouter from './routes/productRouter.js'
import lapanganRouter from './routes/lapanganRouter.js'
import jadwalRouter from './routes/jadwalRouter.js'
import pemesananRouter from './routes/pemesananRouter.js'
import transaksiRouter from './routes/transaksiRouter.js'
import mabarRouter from './routes/mabarRouter.js'


import dotenv from "dotenv"
import { notFound, errorHandler } from "./middleware/errorMiddleware.js"
import cookieParser from "cookie-parser"
import helmet from "helmet"
import ExpressMongoSanitize from "express-mongo-sanitize"
import { v2 as cloudinary } from 'cloudinary';
import cors from 'cors';


const app = express()
const port = 3000


app.use(cors());

app.use(cors({
  origin: '*'
}));



// Configuration
cloudinary.config({ 
      cloud_name: "de9cyaoqo", 
      api_key: 193388313656343, 
      api_secret: "qYF6EPlE381NVDneflc7AxHOtmk" // Click 'View API Keys' above to copy your API secret
});


//Middleware
app.use(helmet())
app.use(ExpressMongoSanitize())
app.use(express.json()) // agar request body bisa json
app.use(express.urlencoded({extended : true}))  // memasukkan inputan di urlencoded pada postman
app.use(cookieParser())
app.use(express.static('./public'))


dotenv.config()


app.use('/api/v1/auth', authRouter)
app.use('/api/v1/product', productRouter)
app.use('/api/v1/lapangan', lapanganRouter)
app.use('/api/v1/jadwal', jadwalRouter)
app.use('/api/v1/pemesanan', pemesananRouter)
app.use('/api/v1/transaksi', transaksiRouter)
app.use('/api/v1/mabar', mabarRouter)



app.use(notFound)
app.use(errorHandler)


// import mongoose from "mongoose";

// // Gantilah dengan URI Atlas Anda
// const uri = process.env.DATABASE;

// async function connectToDatabase() {
//   try {
//     // Menghubungkan ke MongoDB Atlas menggunakan Mongoose
//     await mongoose.connect(uri, {
//       useNewUrlParser: true,
//       useUnifiedTopology: true,
//       serverSelectionTimeoutMS: 30000, // Timeout 30 detik
//       socketTimeoutMS: 45000, // Timeout socket 45 detik
//     });
//     console.log("Connected to MongoDB Atlas!");

//     // Memastikan koneksi berhasil dengan melakukan ping
//     const admin = mongoose.connection.db.admin();
//     await admin.ping();
//     console.log("Pinged your deployment. You successfully connected to MongoDB!");
//   } catch (error) {
//     console.error("Error connecting to MongoDB Atlas:", error);
//     process.exit(1); // Keluar dari aplikasi jika koneksi gagal
//   }
// }

// connectToDatabase(); // Jalankan fungsi koneksi

// // Jalankan server
// app.listen(port, () => console.log(`Server up and running at port ${port}`));

import mongoose from "mongoose";

// Gantilah dengan URI Atlas Anda
const uri = process.env.DATABASE;

async function connectToDatabase() {
  try {
    // Menghubungkan ke MongoDB Atlas menggunakan Mongoose
    await mongoose.connect(uri, {
      useNewUrlParser: true,
      useUnifiedTopology: true,
    });
    console.log("Connected to MongoDB Atlas!");

    // Memastikan koneksi berhasil dengan melakukan ping
    const admin = mongoose.connection.db.admin();
    await admin.ping();
    console.log("Pinged your deployment. You successfully connected to MongoDB!");
  } catch (error) {
    console.error("Error connecting to MongoDB Atlas:", error);
    process.exit(1); // Keluar dari aplikasi jika koneksi gagal
  }
}

connectToDatabase(); // Jalankan fungsi koneksi


app.listen(port, () => console.log(`Server up and run at ${port} port`))

