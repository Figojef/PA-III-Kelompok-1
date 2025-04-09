import { createSlice } from '@reduxjs/toolkit';

const initialState = {
  todos: [
    { id: 1, name: 'b1', completed: false },
    { id: 2, name: 'b2', completed: false },
  ],
  testD : 'init',
  login : false,
  user : null,
  keranjangJadwal : []
};

export const todoSlice = createSlice({
  name: 'todo1',
  initialState,
  reducers: {
    // Menambahkan todo baru
    add: (state, action) => {
      const { name } = action.payload;

      const newTodo = {
        id: new Date().getTime(), // generate id menggunakan timestamp
        name,
        completed: false,
      };
      state.todos = [...state.todos, newTodo]
    },

    // Menghapus todo berdasarkan id
    remove: (state, action) => {
      const { id } = action.payload;
      state.todos = state.todos.filter((todo) => todo.id !== id); // filter untuk menghapus todo
    },

    // Toggle status completed todo
    toggleCompleted: (state, action) => {
      const { id } = action.payload;
      state.todos = state.todos.map((todo) =>
        todo.id === id ? { ...todo, completed: !todo.completed } : todo
      ); // toggle completed pada todo yang sesuai dengan id
    },
    removeAll : state => {
        state.todos = []
    },
    testAddD : (state, action) => {
      const {d} = action.payload
      state.testD = d
    },
    enterLogin : (state, action) => {
      const {user} = action.payload
      state.user = user
      state.login = true
    },
    logout : (state, action) => {
      // state.user = null
      state.login = false
    },
    toggleSelectJadwal: (state, action) => {
      const slot = action.payload; // Ambil slot dari payload action

      let exist = false; // Ubah const menjadi let agar bisa dimodifikasi
      
      state.keranjangJadwal.forEach(item => {
        if (item._id === slot._id) {
          exist = true; // Tandai jika sudah ada
          return; // Langsung keluar dari loop jika ditemukan
        }
      });

      console.log(exist)
      if(!exist){
        state.keranjangJadwal = [...state.keranjangJadwal, slot]; // Tambahkan slot baru
        exist = false
      }else if (exist){
        state.keranjangJadwal = state.keranjangJadwal.filter(item => item._id !== slot._id)
        exist = false
      }
    },
    removeSelectedJadwal : (state, action) => {
      state.keranjangJadwal = []
    },
    removeSelectedJadwalById : (state, action) => {
       const {_id} = action.payload
       state.keranjangJadwal = state.keranjangJadwal.filter(jadwal => jadwal._id !== _id)
    },
  },
});

// Ekspor actions dan reducer
export const { add, remove, toggleCompleted, removeAll, 
  testAddD, enterLogin, logout, toggleSelectJadwal,
  removeSelectedJadwal, removeSelectedJadwalById } = todoSlice.actions;
export default todoSlice.reducer;
