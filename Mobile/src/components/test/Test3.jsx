import axios from 'axios';
import React, { useEffect, useState } from 'react';
import { View, Text, Modal, TouchableOpacity, StyleSheet, Button } from 'react-native';
import { BE_MAIN_URL } from '../../../url';
import { useSelector } from 'react-redux';

export default function Test3() {
  const [modalVisibleJadwal, setModalVisibleJadwal] = useState(false); // Untuk kontrol modal
  const [selectedOptions, setSelectedOptions] = useState([]); // Menyimpan pilihan yang dipilih
  const [options, setOptions] = useState([]); // Menyimpan pilihan yang diambil dari API
  
  const getUser = useSelector(state => state.todo1.user)
  const user = getUser.data;

  // Mengambil data pilihan dari API saat komponen dimount
  useEffect(() => {
    const fetchJadwalMabar = async () => {
      try {
        const response = await axios.post(`${BE_MAIN_URL}/mabar/select-jadwal-mabar`, {
          user_id: user._id,
        });
        // Menyimpan objek lengkap dari item dalam options
        let fetchedOptions = response.data.data.map(item => ({
          id: item._id,
          lapangan: item.lapangan.name,
          jam: item.jam,
          tanggal: item.tanggal,
        }));
        setOptions(fetchedOptions); // Update state options
      } catch (e) {
        console.log(e);
      }
    };
    if (user && user._id) {
      fetchJadwalMabar(); // Memanggil fungsi hanya jika user sudah ada
    }
  }, [user]); // Pastikan hanya dijalankan ketika user berubah

  // Fungsi untuk toggle pilihan (cek atau uncheck)
  const handleOptionPress = (optionId) => {
    setSelectedOptions((prevSelectedOptions) => {
      if (prevSelectedOptions.includes(optionId)) {
        // Jika sudah dipilih, hilangkan dari state
        return prevSelectedOptions.filter((item) => item !== optionId);
      } else {
        // Jika belum dipilih, tambahkan ke state
        return [...prevSelectedOptions, optionId];
      }
    });
  };

  console.log(selectedOptions)

  return (
    <View style={styles.container}>
      <Text>Selected Options: {selectedOptions.join(', ')}</Text>
      <Button title="Open Modal" onPress={() => setModalVisibleJadwal(true)} />

      {/* Modal untuk menampilkan pilihan */}
      <Modal
        animationType="slide"
        transparent={true}
        visible={modalVisibleJadwal}
        onRequestClose={() => setModalVisibleJadwal(false)}
      >
        <View style={styles.modalOverlay}>
          <View style={styles.modalContent}>
            <Text style={styles.modalTitle}>Select Options</Text>

            {/* Menampilkan pilihan menggunakan TouchableOpacity */}
            {options.length > 0 ? (
              options.map((option, index) => (
                <TouchableOpacity
                  key={index}
                  style={[
                    styles.optionContainer,
                    selectedOptions.includes(option.id) && styles.selectedOption,
                  ]}
                  onPress={() => handleOptionPress(option.id)} // Menggunakan ID sebagai nilai
                >
                  <Text style={styles.optionText}>
                    {`${option.lapangan} - ${option.jam} - ${option.tanggal}`}
                  </Text>
                </TouchableOpacity>
              ))
            ) : (
              <Text>Loading options...</Text>
            )}

            <TouchableOpacity
              style={styles.closeButton}
              onPress={() => setModalVisibleJadwal(false)}
            >
              <Text style={styles.closeButtonText}>Terapkan</Text>
            </TouchableOpacity>
          </View>
        </View>
      </Modal>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    padding: 20,
  },
  modalOverlay: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: 'rgba(0, 0, 0, 0.5)',
  },
  modalContent: {
    backgroundColor: 'white',
    padding: 20,
    borderRadius: 10,
    width: 300,
    alignItems: 'center',
  },
  modalTitle: {
    fontSize: 18,
    marginBottom: 15,
  },
  optionContainer: {
    flexDirection: 'row',
    alignItems: 'center',
    padding: 10,
    marginBottom: 10,
    borderWidth: 1,
    borderRadius: 5,
  },
  selectedOption: {
    backgroundColor: '#cce5ff', // Warna latar belakang untuk opsi yang dipilih
  },
  optionText: {
    fontSize: 16,
  },
  closeButton: {
    marginTop: 15,
    backgroundColor: '#007BFF',
    padding: 10,
    borderRadius: 5,
  },
  closeButtonText: {
    color: 'white',
    fontSize: 16,
  },
});
