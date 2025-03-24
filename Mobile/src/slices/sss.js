import { createSlice } from '@reduxjs/toolkit';

const initialState = {
  todos: [
    { id: 1, name: 'b1', completed: false },
    { id: 2, name: 'b2', completed: false },
  ],
  testD : 'init',
  login : true
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
      state.login = true
    },
    logout : (state, action) => {
      state.login = false
    }
  },
});

// Ekspor actions dan reducer
export const { add, remove, toggleCompleted, removeAll, testAddD, enterLogin, logout } = todoSlice.actions;
export default todoSlice.reducer;
