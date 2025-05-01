import { query } from "express";
import asyncHandler from "../middleware/asyncHandler.js";
import { v2 as cloudinary } from "cloudinary";
import streamifier from "streamifier"
import Event from "../models/eventModel.js";

export const CreateEvent = asyncHandler(async(req,res) => {
    // res.send("Create Event")
    const newEvent = await Event.create(req.body)

    res.status(201).json({
        message : "Berhasil tambah event",
        data : newEvent
    })
})

