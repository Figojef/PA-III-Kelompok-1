import React, { useState } from 'react';
import { View, Text, ScrollView, TouchableOpacity, StyleSheet } from 'react-native';
import { Ionicons } from '@expo/vector-icons'; // Expo sudah mendukung Ionicons
import { useNavigation } from '@react-navigation/native';

const dates = [
  '04 Mar Sel', '05 Mar Rab', '06 Mar Kam', '07 Mar Jum', '08 Mar Sab', '09 Mar Min', '10 Mar Sen'
];

// const courts = ['Badminton 1', 'Badminton 2', 'Badminton 3'];
const courts = ['Badminton 1'];

const timeSlots = [];

for (let i = 8; i <= 24; i++) {
  let hour = i < 10 ? `0${i}` : `${i}`;
  let price = i < 17 ? '60K' : '70K'; // Set price based on time
  let available = i !== 19 && i !== 20; // Mark certain hours as unavailable (19:00, 20:00)
  
  timeSlots.push({ time: `${hour}:00`, price: price, available: available });
}

const SelectSchedule = () => {
  const navigation = useNavigation();

  const [selectedDate, setSelectedDate] = useState(dates[0]);
  const [selectedCourt, setSelectedCourt] = useState(courts[0]);
  const [selectedTimes, setSelectedTimes] = useState([]); // Changed to an array for multiple selections

  const handleToggleTimeSlot = (time) => {
    setSelectedTimes((prevSelectedTimes) => {
      if (prevSelectedTimes.includes(time)) {
        return prevSelectedTimes.filter((selectedTime) => selectedTime !== time); // Remove if already selected
      } else {
        return [...prevSelectedTimes, time]; // Add if not selected
      }
    });
  };

  return (
    
    <View style={styles.container}>
      {/* Header */}
      <TouchableOpacity onPress={() => navigation.goBack()} style={styles.header}>
        <Ionicons name="arrow-back" size={24} />
      </TouchableOpacity>

      <Text style={{ marginTop: 10, marginBottom: 20, fontWeight: 'bold' }}>Tanggal</Text>
      {/* Tanggal */}
      <View style={{ height: 80 }}>
        <ScrollView horizontal showsHorizontalScrollIndicator={false} style={styles.dateScroll}>
          {dates.map((date) => (
            <TouchableOpacity
              key={date}
              onPress={() => setSelectedDate(date)}
              style={[styles.dateItem, selectedDate === date && styles.dateSelected]}>
              <Text style={selectedDate === date ? styles.dateTextSelected : styles.dateText}>
                {date}
              </Text>
            </TouchableOpacity>
          ))}
        </ScrollView>
      </View>

      {/* Pilih Lapangan */}
      <View style={styles.courtContainer}>
        {courts.map((court) => (
          <TouchableOpacity
            key={court}
            onPress={() => setSelectedCourt(court)}
            style={[styles.courtItem, selectedCourt === court && styles.courtSelected]}>
            <Text style={selectedCourt === court ? styles.courtTextSelected : styles.courtText}>
              {court}
            </Text>
          </TouchableOpacity>
        ))}
      </View>

      {/* Jam */}
      <View style={styles.timeContainer}>
        {timeSlots.map((slot) => (
          <TouchableOpacity
            key={slot.time}
            disabled={!slot.available}
            onPress={() => handleToggleTimeSlot(slot.time)} // Toggle selection
            style={[
              styles.timeSlot,
              !slot.available ? styles.unavailable : selectedTimes.includes(slot.time) && styles.selected,
            ]}>
            <Text style={styles.timeText}>{slot.time}</Text>
            <Text style={styles.priceText}>{slot.price}</Text>
          </TouchableOpacity>
        ))}
      </View>

      {/* Reset & Legend */}
      <View style={styles.legendContainer}>
        <TouchableOpacity style={styles.resetButton} onPress={() => setSelectedTimes([])}>
          <Text style={styles.resetText}>Reset</Text>
        </TouchableOpacity>
        <Text style={styles.legendText}>⬜ Tersedia   🟢 Dipilih   🔴 Tidak Tersedia</Text>
      </View>

      {/* Tombol Keranjang & Lanjutkan */}
      <View style={styles.buttonContainer}>
        <TouchableOpacity style={styles.nextButton} onPress={() => navigation.navigate('DetailPembayaran')}>
          <Text style={styles.buttonText}>Lanjutkan</Text>
        </TouchableOpacity>
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
