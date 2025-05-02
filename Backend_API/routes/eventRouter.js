import express from "express"
import { protectedMiddleware, adminMiddleware } from "../middleware/authMiddleware.js"
// import { CreateProduct, updateProduct, deleteProduct, AllProduct, fileUpload, detailProduct } from "../controllers/ProductController.js"
import { upload } from "../utils/uploadFileHandler.js"
import { 
    CreateEvent
 } from "../controllers/EventController.js";


 const router = express.Router();

// Route untuk create event dengan upload gambar
router.post("/", upload.single('gambar'),protectedMiddleware,adminMiddleware,CreateEvent);

export default router;