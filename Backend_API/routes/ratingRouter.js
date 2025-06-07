import express from "express"
import { protectedMiddleware} from "../middleware/authMiddleware.js"

import { 
    createRating,
    GetMabarAndRatingsByUser,
    GetMabarDetailWithRating,
    ReferensiPenilaianMabar
 } from "../controllers/RatingController.js";


 const router = express.Router();


router.post("/", protectedMiddleware, createRating);

// melihat rating mabar berdasarkan user
router.get('/user/:userId/mabar-ratings', GetMabarAndRatingsByUser);

// melihat rating user berdasarkan mabar
router.get('/:mabarId/detail-with-rating', GetMabarDetailWithRating);

router.get('/penilaian/:user_target_id/:mabar_id', ReferensiPenilaianMabar);

export default router;