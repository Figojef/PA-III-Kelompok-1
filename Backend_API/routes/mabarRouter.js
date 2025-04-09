import express from "express"
import { protectedMiddleware, adminMiddleware } from "../middleware/authMiddleware.js"
import { CekJoin, CreateMabar, getAllMabar, GetMabarJoined, GetMabarOwn, HapusMabar, JoinMabar, KeluarMabar, SelectJadwalMabar } from "../controllers/mabarController.js"


const router = express.Router()

router.post('/', CreateMabar)

router.post('/join', JoinMabar)

router.post('/keluar', KeluarMabar)

router.delete('/hapus/:mabarId', HapusMabar)

router.get('/', getAllMabar)

router.post('/cek-join', CekJoin)

router.post('/mabar-own', GetMabarOwn)

router.post('/mabar-joined', GetMabarJoined)


router.post('/select-jadwal-mabar', SelectJadwalMabar)

export default router