import React, { useEffect, useState } from 'react';
import { View, Text, Platform, Alert, SafeAreaView, StyleSheet } from 'react-native';
import { Picker } from '@react-native-picker/picker';
import DateTimePicker from '@react-native-community/datetimepicker';
import axios from 'axios';
import { BE_MAIN_URL } from '../../../url';
import Header from '../layouts/Header';

export default function Jadwal() {
  const [lapanganData, setLapanganData] = useState([]);  // State untuk menyimpan data lapangan
  const [selectedLapangan, setSelectedLapangan] = useState('');  // State untuk lapangan yang dipilih
  const [selectedDate, setSelectedDate] = useState(new Date()); // State untuk menyimpan tanggal yang dipilih
  const [showDatePicker, setShowDatePicker] = useState(false);  // State untuk menampilkan/menyembunyikan Date Picker
  const [jadwalData, setJadwalData] = useState([]);  // State untuk menyimpan data jadwal yang dipilih
  const [jadwalError, setJadwalError] = useState(false);  // State untuk menandakan error pengambilan data jadwal

  useEffect(() => {
    // Mengambil data lapangan dari API
    axios.get(`${BE_MAIN_URL}/lapangan`)
      .then(response => {
        setLapanganData(response.data.data);  // Menyimpan data lapangan ke dalam state
      })
      .catch(error => {
        console.error("Error fetching lapangan data:", error);  // Menangani error jika ada
      });
  }, []);  // Hook useEffect untuk menjalankan sekali saat komponen di-render

  // Mengambil jadwal berdasarkan lapangan yang dipilih dan tanggal yang dipilih
  useEffect(() => {
    if (selectedLapangan && selectedDate) {
      const formattedDate = selectedDate.toISOString().split('T')[0];  // Format tanggal: YYYY-MM-DD
      axios.get(`${BE_MAIN_URL}/jadwal/tanggal?tanggal=${formattedDate}&lapangan=${selectedLapangan}`)
        .then(response => {
          setJadwalData(response.data);  // Menyimpan data jadwal ke dalam state
          setJadwalError(false);  // Mengatur error ke false jika data berhasil diambil
        })
        .catch(error => {
          setJadwalData([]);  // Mengosongkan data jadwal
          setJadwalError(true);  // Mengatur status error menjadi true
        });
    }
  }, [selectedLapangan, selectedDate]);  // Hook useEffect untuk menjalankan ketika lapangan atau tanggal yang dipilih berubah

  const handleDateChange = (event, selectedDate) => {
    const currentDate = selectedDate || selectedDate;
    setShowDatePicker(Platform.OS === 'ios' ? true : false); // Menyembunyikan picker di Android setelah memilih
    setSelectedDate(currentDate);
  };

  return (
    <SafeAreaView style={{ flex: 1, backgroundColor: '#f8f8f8' }}>
      <Header /> {/* Komponen Header yang sudah ada */}
      <View style={styles.container}>
        <Text style={styles.title}>Jadwal</Text>

        {/* Picker untuk memilih lapangan */}
        <Picker
          selectedValue={selectedLapangan}
          onValueChange={(itemValue) => setSelectedLapangan(itemValue)} // Mengubah nilai lapangan yang dipilih
        >
          <Picker.Item label="Pilih Lapangan" value="" />
          {lapanganData.map(lapangan => (
            <Picker.Item
              key={lapangan._id}
              label={lapangan.name}   // Menampilkan nama lapangan sebagai label
              value={lapangan._id}    // Menyimpan _id lapangan sebagai value
            />
          ))}
        </Picker>

        {/* Tanggal Picker */}
        <View style={styles.datePickerContainer}>
          <Text>Pilih Tanggal: {selectedDate.toISOString().split('T')[0]}</Text>

          {/* Button untuk membuka date picker */}
          <Text style={styles.datePickerButton} onPress={() => setShowDatePicker(true)}>
            Pilih Tanggal
          </Text>

          {showDatePicker && (
            <DateTimePicker
              value={selectedDate}
              mode="date"
              display="default"
              onChange={handleDateChange}  // Mengubah nilai tanggal yang dipilih
            />
          )}
        </View>

        {/* Menampilkan Jadwal */}
        <View style={styles.jadwalContainer}>
          {jadwalError ? (
            <Text style={styles.noJadwalText}>Jadwal Tidak Tersedia</Text>
          ) : (
            jadwalData.length > 0 ? (
              jadwalData.map((jadwal) => (
                <View key={jadwal._id} style={styles.jadwalItem}>
                  <Text style={styles.jadwalText}>
                    {jadwal.lapangan.name} - Jam {jadwal.jam}:00
                  </Text>
                  <View style={[styles.statusCircle, {
                    backgroundColor: jadwal.status === 'Tersedia' ? 'green' : 'red'
                  }]} />
                  <Text style={styles.statusText}>
                    {jadwal.status === 'Tersedia' ? 'Tersedia' : 'Tidak Tersedia'}
                  </Text>
                </View>
              ))
            ) : (
              <Text style={styles.noJadwalText}>Jadwal Tidak Ditemukan</Text>
            )
          )}
        </View>
      </View>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  container: {
    padding: 16,
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    marginBottom: 16,
  },
  datePickerContainer: {
    marginVertical: 16,
  },
  datePickerButton: {
    color: 'blue',
    textDecorationLine: 'underline',
    marginTop: 8,
  },
  jadwalContainer: {
    marginTop: 20,
  },
  jadwalItem: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: 12,
  },
  jadwalText: {
    flex: 1,
    fontSize: 16,
  },
  statusCircle: {
    width: 15,
    height: 15,
    borderRadius: 50,
    marginRight: 10,
  },
  statusText: {
    fontSize: 16,
  },
  noJadwalText: {
    fontSize: 16,
    color: 'gray',
    textAlign: 'center',
  },
});
