import React, { useEffect, useState } from 'react';
import { View, Text, Platform, SafeAreaView, StyleSheet, TouchableOpacity, ScrollView } from 'react-native';
import { Picker } from '@react-native-picker/picker';
import DateTimePicker from '@react-native-community/datetimepicker';
import axios from 'axios';
import { BE_MAIN_URL } from '../../../url';
import Header from '../layouts/Header';

export default function Jadwal() {
  const [lapanganData, setLapanganData] = useState([]);
  const [selectedLapangan, setSelectedLapangan] = useState('');
  const [selectedDate, setSelectedDate] = useState(new Date());
  const [showDatePicker, setShowDatePicker] = useState(false);
  const [jadwalData, setJadwalData] = useState([]);
  const [jadwalError, setJadwalError] = useState(false);

  useEffect(() => {
    axios.get(`${BE_MAIN_URL}/lapangan`)
      .then(response => {
        setLapanganData(response.data.data);
      })
      .catch(error => {
        console.error("Error fetching lapangan data:", error);
      });
  }, []);

  useEffect(() => {
    if (selectedLapangan && selectedDate) {
      const formattedDate = selectedDate.toISOString().split('T')[0];
      axios.get(`${BE_MAIN_URL}/jadwal/tanggal?tanggal=${formattedDate}&lapangan=${selectedLapangan}`)
        .then(response => {
          setJadwalData(response.data);
          setJadwalError(false);
        })
        .catch(error => {
          setJadwalData([]);
          setJadwalError(true);
        });
    }
  }, [selectedLapangan, selectedDate]);

  const handleDateChange = (event, selectedDate) => {
    const currentDate = selectedDate || selectedDate;
    setShowDatePicker(Platform.OS === 'ios' ? true : false);
    setSelectedDate(currentDate);
  };

  return (
    <SafeAreaView style={styles.safeArea}>
      <Header />
      <ScrollView contentContainerStyle={styles.container}>
        <Text style={styles.title}>Jadwal Lapangan</Text>

        {/* Picker untuk memilih lapangan */}
        <View style={styles.pickerContainer}>
          <Text style={styles.label}>Pilih Lapangan:</Text>
          <Picker
            selectedValue={selectedLapangan}
            onValueChange={(itemValue) => setSelectedLapangan(itemValue)}
            style={styles.picker}
          >
            <Picker.Item label="Pilih Lapangan" value="" />
            {lapanganData.map(lapangan => (
              <Picker.Item
                key={lapangan._id}
                label={lapangan.name}
                value={lapangan._id}
              />
            ))}
          </Picker>
        </View>

        {/* Tanggal Picker */}
        <View style={styles.datePickerContainer}>
          <Text style={styles.label}>Pilih Tanggal:</Text>
          <Text style={styles.dateText}>{selectedDate.toISOString().split('T')[0]}</Text>
          <TouchableOpacity onPress={() => setShowDatePicker(true)} style={styles.dateButton}>
            <Text style={styles.dateButtonText}>Pilih Tanggal</Text>
          </TouchableOpacity>

          {showDatePicker && (
            <DateTimePicker
              value={selectedDate}
              mode="date"
              display="default"
              onChange={handleDateChange}
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
                  <View style={styles.statusContainer}>
                    <View style={[styles.statusCircle, {
                      backgroundColor: jadwal.status === 'Tersedia' ? 'green' : 'red'
                    }]} />
                    <Text style={styles.statusText}>
                      {jadwal.status === 'Tersedia' ? 'Tersedia' : 'Tidak Tersedia'}
                    </Text>
                  </View>
                </View>
              ))
            ) : (
              <Text style={styles.noJadwalText}>Jadwal Tidak Ditemukan</Text>
            )
          )}
        </View>
      </ScrollView>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  safeArea: {
    flex: 1,
    backgroundColor: '#f8f8f8',
  },
  container: {
    padding: 20,
    backgroundColor: '#fff',
    flexGrow: 1,
    borderRadius: 10,
    margin: 0,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 5,
    elevation: 5,
  },
  title: {
    fontSize: 28,
    fontWeight: 'bold',
    color: '#333',
    marginBottom: 20,
    textAlign: 'center',
  },
  pickerContainer: {
    marginBottom: 20,
  },
  label: {
    fontSize: 16,
    color: '#555',
  },
  picker: {
    height: 70,
    borderColor: '#ddd',
    borderWidth: 1,
    borderRadius: 5,
  },
  datePickerContainer: {
    marginBottom: 20,
  },
  dateText: {
    fontSize: 18,
    color: '#333',
    marginTop: 8,
    marginBottom: 10,
  },
  dateButton: {
    backgroundColor: '#4CAF50',
    paddingVertical: 10,
    paddingHorizontal: 20,
    borderRadius: 5,
    alignItems: 'center',
  },
  dateButtonText: {
    color: '#fff',
    fontSize: 16,
  },
  jadwalContainer: {
    marginTop: 20,
  },
  jadwalItem: {
    flexDirection: 'row',
    alignItems: 'center',  // This aligns the text and status circle in a row
    marginBottom: 12,
    padding: 10,
    borderRadius: 8,
    backgroundColor: '#f1f1f1',
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 5,
    elevation: 5,
  },
  jadwalText: {
    flex: 1,
    fontSize: 16,
    color: '#333',
  },
  statusContainer: {
    flexDirection: 'row',
    alignItems: 'center', // Aligns the status circle and text in the center
  },
  statusCircle: {
    width: 15,
    height: 15,
    borderRadius: 50,
    marginRight: 10,
  },
  statusText: {
    fontSize: 16,
    color: '#333',
  },
  noJadwalText: {
    fontSize: 18,
    color: '#aaa',
    textAlign: 'center',
  },
});
