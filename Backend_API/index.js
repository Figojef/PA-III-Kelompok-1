import express from "express"
import authRouter from './routes/authRouter.js'
// import productRouter from './routes/productRouter.js'
// import orderRouter from './routes/orderRouter.js'
import dotenv from "dotenv"
import { notFound, errorHandler } from "./middleware/errorMiddleware.js"
import cookieParser  from "cookie-parser"
import helmet from "helmet"
import ExpressMongoSanitize from "express-mongo-sanitize"
import { v2 as cloudinary } from 'cloudinary';
import lapanganRouter from './routes/lapanganRouter.js'
import jadwalRouter from './routes/jadwalRouter.js'
import pemesananRouter from './routes/pemesananRouter.js'


const app = express()
const port = 3000


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
app.use('/api/v1/lapangan', lapanganRouter)
app.use('/api/v1/jadwal', jadwalRouter)
app.use('/api/v1/pemesanan', pemesananRouter)


app.use(notFound)
app.use(errorHandler)


// const { MongoClient, ServerApiVersion } = require('mongodb');

// import { MongoClient, ServerApiVersion } from "mongodb"

// const uri = "mongodb+srv://benyaminsibarani2406:JIgP6ldWjJuxYIWh@cluster0.qpoml.mongodb.net/Ecommerce_MERN?retryWrites=true&w=majority&appName=Cluster0";

// // Create a MongoClient with a MongoClientOptions object to set the Stable API version
// const client = new MongoClient(uri, {
//   serverApi: {
//     version: ServerApiVersion.v1,
//     strict: true,
//     deprecationErrors: true,
//   }
// });

// async function run() {
//   try {
//     // Connect the client to the server	(optional starting in v4.7)
//     await client.connect();
//     // Send a ping to confirm a successful connection
//     await client.db("admin").command({ ping: 1 });
//     console.log("Pinged your deployment. You successfully connected to MongoDB!");
//   } finally {
//     // Ensures that the client will close when you finish/error
//     await client.close();
//   }
// }
// run().catch(console.dir);

// import mongoose from "mongoose";

// // Gantilah dengan URI Atlas Anda
// const uri = process.env.DATABASE

// async function run() {
//   try {
//     // Menghubungkan ke MongoDB Atlas menggunakan Mongoose
//     await mongoose.connect(uri);
//     console.log("Connected to MongoDB Atlas!");

//     // Memastikan koneksi berhasil dengan melakukan ping
//     const admin = mongoose.connection.db.admin(); 
//     await admin.ping();
//     console.log("Pinged your deployment. You successfully connected to MongoDB!");

//   } catch (error) {
//     console.error("Error connecting to MongoDB Atlas:", error);
//   } finally {
//     // Menutup koneksi setelah operasi selesai
//     await mongoose.disconnect();
//   }
// }

// run().catch(console.dir);

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

