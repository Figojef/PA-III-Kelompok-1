import { View, Text, TextInput, StyleSheet, TouchableOpacity, Button } from 'react-native';
import React, { useState } from 'react';
import { useDispatch } from 'react-redux';
import { add, removeAll } from '../slices/todoSlice';
import { Dialog, Portal, TextInput as PaperInput } from 'react-native-paper';

export default function TodoInput(props) {
  const [input, setInput] = useState('');
  const [visible, setVisible] = useState(false);  // State untuk kontrol dialog
  const { style1 } = props;
  const dispatch = useDispatch();

  const handleAdd = () => {
    if (input.trim()) {
      dispatch(add({ name: input }));
      setInput('');
    } else {
      setVisible(true); // Menampilkan dialog jika input kosong
    }
  };

  const handleRA = () => dispatch(removeAll());

  const hideDialog = () => setVisible(false);

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Todo Input</Text>
      <View style={styles.inputContainer}>
        <TextInput
          style={styles.input}
          onChangeText={(text) => setInput(text)}
          value={input}
          placeholder="Tambahkan Todo"
          onSubmitEditing={handleAdd}
        />
        <TouchableOpacity onPress={handleAdd} style={[styles.button1, style1]}>
          <Text>Tambah</Text>
        </TouchableOpacity>
      </View>

      {/* Tombol Hapus Semua */}
      <TouchableOpacity onPress={handleRA} style={styles.button2}>
        <Text style={{ color: 'white', textAlign: 'center' }}>Hapus Semua</Text>
      </TouchableOpacity>

      {/* Dialog untuk alert custom */}
      <Portal>
        <Dialog visible={visible} onDismiss={hideDialog}>
          <Dialog.Title>Perhatian</Dialog.Title>
          <Dialog.Content>
            <Text>Isi inputan terlebih dahulu!</Text>
          </Dialog.Content>
          <Dialog.Actions>
            <Button style={{ backgroundColor: 'red' }} onPress={hideDialog}>
              <Text style={{ color: 'white' }}>Tutup</Text>
            </Button>
          </Dialog.Actions>
        </Dialog>
      </Portal>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    padding: 16,
  },
  title: {
    fontSize: 18,
    marginBottom: 8,
  },
  inputContainer: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
  },
  button1: {
    margin: 10,
    height: 30,
    alignItems: 'center',
    justifyContent: 'center',
    borderRadius: 10,
  },
  button2: {
    marginTop: 10,
    backgroundColor: 'red',
    height: 40, // Menambah tinggi agar tombol lebih nyaman digunakan
    alignItems: 'center',
    justifyContent: 'center',
    borderRadius: 10,
    width: '100%', // Tombol akan mengambil lebar penuh
  },
  input: {
    borderWidth: 2,
    borderColor: '#4CAF50',
    backgroundColor: '#f0f0f0',
    padding: 12,
    borderRadius: 8,
    fontSize: 16,
    marginBottom: 12,
    width: '70%', // Lebar input tetap responsif
  },
});
