import React, { useEffect, useState } from 'react';
import { View, Text, ScrollView, TouchableOpacity, StyleSheet } from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { useNavigation } from '@react-navigation/native';
import axios from 'axios';
import { BE_MAIN_URL } from '../../../url';
import { useDispatch, useSelector } from 'react-redux';
import { toggleSelectJadwal, removeSelectedJadwal } from '../../slices/todoSlice';

const SelectSchedule = ({ route }) => {
  const navigation = useNavigation();
  const { lapangan, lapangan2 } = route.params;
  const daysOfWeek = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

  // Fungsi untuk menghasilkan daftar tanggal dinamis
  function generateDates() {
    const today = new Date();
    const result = [];

    for (let i = 0; i < 7; i++) {
      const date = new Date(today);
      date.setDate(today.getDate() + i);  // Tambah i hari dari hari ini

      const year = date.getFullYear();
      const month = String(date.getMonth() + 1).padStart(2, '0');  // Tambahkan leading zero pada bulan
      const day = String(date.getDate()).padStart(2, '0');  // Tambahkan leading zero pada tanggal

      const dayOfWeek = daysOfWeek[date.getDay()]; // Mendapatkan nama hari sesuai dengan index
      const formattedDate = `${year}-${month}-${day} ${dayOfWeek}`;
      result.push(formattedDate);
    }

    return result;
  }

  const dates2 = generateDates();

  const [selectedDate, setSelectedDate] = useState(dates2[0]);
  const [selectedCourt, setSelectedCourt] = useState(lapangan);
  const [jadwalItems, setJadwalItems] = useState([]);
  const c1 = "2025-06-20 Min";

  useEffect(() => {
    const fetchJadwal = async () => {
      if (selectedDate) {
        try {
          console.log(selectedDate.split(" ") [0] + ' dan ' + c1.split(" ")[0])
          const response = await axios.get(
            `${BE_MAIN_URL}/jadwal/tanggal?tanggal=${selectedDate.split(" ")[0]}&lapangan=${lapangan2._id}`
          );
          
          // Mengurutkan jadwal berdasarkan jam
          const sortedJadwal = response.data.sort((a, b) => a.jam - b.jam);
  
          setJadwalItems(sortedJadwal);
        } catch (error) {
          // console.log(`Tidak ditemukan jadwal`); 
          setJadwalItems(null);
        }
      }
    };
  
    fetchJadwal();
  }, [selectedDate]);
  

  const dispatch = useDispatch();
  const keranjangJadwal = useSelector((state) => state.todo1.keranjangJadwal);

  // Function to handle the click on a timeslot
  const handleToggleTimeSlot = (slot) => {
    dispatch(toggleSelectJadwal(slot)); // Dispatch the action to update the Redux state
  };

  console.log(keranjangJadwal)

  return (
    <View style={styles.container}>
      {/* Header */}
      <TouchableOpacity onPress={() => navigation.goBack()} style={styles.header}>
        <Ionicons name="arrow-back" size={24} />
      </TouchableOpacity>

      <Text style={{ marginTop: 10, marginBottom: 20, fontWeight: 'bold' }}>Tanggal</Text>

      {/* Tanggal */}
      <View style={{ height: 90 }}>
        <ScrollView horizontal showsHorizontalScrollIndicator={false} style={[styles.dateScroll]}>
          {dates2.map((date) => (
            <TouchableOpacity
              key={date}
              onPress={() => setSelectedDate(date)}
              style={[styles.dateItem, selectedDate === date && styles.dateSelected, { justifyContent: "center" }]}>
              <Text style={selectedDate === date ? styles.dateTextSelected : styles.dateText}>
                {date}
              </Text>
            </TouchableOpacity>
          ))}
        </ScrollView>
      </View>

      <TouchableOpacity
        style={[styles.courtItem, styles.courtSelected, { width: 300, alignItems: "center", alignSelf: "center", marginBottom: 30 }]}>
        <Text style={styles.courtTextSelected}>
          {lapangan2.name}
        </Text>
      </TouchableOpacity>

      {jadwalItems ? (
        <View style={styles.timeContainer}>
{jadwalItems.map((slot, ind) => {
  // Cek apakah slot ada di keranjangJadwal (cart)
  // const isSelected = keranjangJadwal.some((item) => item.time === slot.time);
    let exist = false
    keranjangJadwal.forEach(item => {
      if (item._id === slot._id) {
        exist = true; // Tandai jika sudah ada
        return; // Langsung keluar dari loop jika ditemukan
      }
    });

  return (
    <TouchableOpacity
      key={ind}
      disabled={slot.status !== "Tersedia"}  // Disable jika status bukan "Tersedia"
      onPress={() => handleToggleTimeSlot(slot)} // Toggle selection
      style={[
        styles.timeSlot,
        // isSelected && styles.selected,  // Apply selected style jika slot ada di keranjangJadwal
        {backgroundColor : exist ? "#28a745" : "#ddd"},
        slot.status !== 'Tersedia' && styles.unavailable,  // Beri style jika tidak tersedia
      ]}
    >
      <Text style={styles.timeText}>{slot.jam}</Text>
      <Text style={styles.priceText}>{slot.harga}</Text>
    </TouchableOpacity>
  );
})}

        </View>
      ) : (
        <View style={styles.timeContainer}>
          <Text style={{ fontSize: 30 }}>Jadwal tidak ditemukan</Text>
        </View>
      )}

      {/* Reset & Legend */}
      <View style={styles.legendContainer}>
        <TouchableOpacity style={styles.resetButton} onPress={() => dispatch(removeSelectedJadwal())}>
          <Text style={styles.resetText}>Reset</Text>
        </TouchableOpacity>
        <Text style={styles.legendText}>⬜ Tersedia   🟢 Dipilih   🔴 Tidak Tersedia</Text>
      </View>

      {/* Tombol Keranjang & Lanjutkan */}
      <View style={[styles.buttonContainer, {alignContent : "center"}]}>
        {
          keranjangJadwal.length === 0 ? <Text style={{color : "red", fontSize : 30}}>Silahkan pilih jadwal</Text> 
          :
          <TouchableOpacity style={styles.nextButton} onPress={() => navigation.navigate('DetailPembayaran')}>
          <Text style={styles.buttonText}>Lanjutkan</Text>
        </TouchableOpacity>
        }
      </View>
    </View>
  );
};

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: '#fff', padding: 15 },
  header: { flexDirection: 'row', justifyContent: 'space-between', marginBottom: 10 },
  dateScroll: { flexDirection: 'row' },
  dateItem: { paddingVertical: 8, paddingHorizontal: 12, borderRadius: 8, marginRight: 10, backgroundColor: '#ddd', minWidth: 80, height: 50 },
  dateSelected: { backgroundColor: '#001F3F' },
  dateText: { color: '#000', fontSize: 12 },
  dateTextSelected: { color: '#fff', fontWeight: 'bold' },
  courtContainer: { flexDirection: 'row', justifyContent: 'space-around', marginBottom: 15 },
  courtItem: { padding: 10, borderRadius: 8, backgroundColor: '#ccc' },
  courtSelected: { backgroundColor: '#001F3F' },
  courtText: { color: '#000' },
  courtTextSelected: { color: '#fff', fontWeight: 'bold' },
  timeContainer: { flexDirection: 'row', flexWrap: 'wrap', justifyContent: 'space-between' },
  timeSlot: { width: '22%', padding: 10, marginVertical: 5, alignItems: 'center', borderRadius: 8, backgroundColor: '#ddd' },
  unavailable: { backgroundColor: 'red' },
  selected: { backgroundColor: '#28a745' }, // Green color for selected time slots
  timeText: { fontSize: 14 },
  priceText: { fontSize: 12, color: '#555' },
  legendContainer: { flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center', marginVertical: 15 },
  resetButton: { padding: 10, backgroundColor: '#ff4d4d', borderRadius: 8 },
  resetText: { color: '#fff' },
  legendText: { fontSize: 12, color: '#555' },
  buttonContainer: { flexDirection: 'row', justifyContent: 'space-between' },
  nextButton: { flex: 1, padding: 15, backgroundColor: '#001F3F', borderRadius: 8, alignItems: 'center' },
  buttonText: { color: '#fff', fontWeight: 'bold' },
});

export default SelectSchedule;
