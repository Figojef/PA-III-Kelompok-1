import express from "express";
import { 
    createTransaksi, 
    getAllTransaksi, 
    getTransaksiById, 
    updateTransaksi, 
    deleteTransaksi 
} from "../controllers/TransaksiController.js";

import { protectedMiddleware, adminMiddleware } from "../middleware/authMiddleware.js";


const router = express.Router();

router.get("/", protectedMiddleware, getAllTransaksi);

router.post("/", protectedMiddleware, createTransaksi);

router.route("/").post(createTransaksi).get(getAllTransaksi);

router.route("/:id").get(getTransaksiById).put(updateTransaksi).delete(deleteTransaksi);

export default router;