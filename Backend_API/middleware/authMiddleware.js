import jwt from "jsonwebtoken"
import User from "../models/userModel.js"
import asyncHandler from "./asyncHandler.js"

export const protectedMiddleware = asyncHandler(async(req, res, next) => {
    const token = req.cookies.jwt
    if(token){
        try{
            const decode = jwt.verify(token, process.env.JWT_SECRET)

            req.user = await User.findById(decode.id).select('-password')
            next()
        }catch(e){
            res.status(401)
            throw new Error('Not Authorized token fail')
        }
    }else{
        res.status(401)
        throw new Error('Not Authorized, no token')
    }
})

export const adminMiddleware = asyncHandler(
    async (req, res, next) => {
        if(req.user && req.user.role === 'admin'){
            next()
        }else{
            res.status(401)
            throw new Error("Not Authorized as Owner")
        }
    }
)