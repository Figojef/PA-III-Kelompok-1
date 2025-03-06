import { configureStore } from "@reduxjs/toolkit";
import  todoReducer  from "../src/slices/todoSlice";

const store = configureStore({
    reducer : {
        todo1 : todoReducer
    }   
})

export default store