import React, { useState } from 'react';
import { View, Text, TouchableOpacity, FlatList, StyleSheet } from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { Picker } from '@react-native-picker/picker';
import Header from '../layouts/Header';
import { SafeAreaView } from 'react-native-safe-area-context';

// Helper function to format dates
const formatDate = (date) => {
  return new Date(date).toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
};

// Generate times between 08:00 and 23:00 with 1-hour intervals
const generateTimes = () => {
  const times = [];
  for (let hour = 8; hour <= 23; hour++) {
    const start = `${hour}:00`;
    const end = `${hour + 1}:00`;
    times.push(`${start} - ${end}`);
  }
  return times;
};

// Function to generate the schedule for a given start date
const generateScheduleForWeek = (startDate) => {
  const schedule = [];
  const currentDate = new Date(startDate);
  currentDate.setDate(currentDate.getDate() - currentDate.getDay()); // Set to Sunday

  for (let i = 0; i < 7; i++) {
    const day = new Date(currentDate);
    day.setDate(currentDate.getDate() + i);
    schedule.push({ day: formatDate(day), times: generateTimes() });
  }
  return schedule;
};

const Jadwal = () => {
  const [selectedCourt, setSelectedCourt] = useState('Lapangan 1');
  const [activeTab, setActiveTab] = useState('Daily');
  const [startDate, setStartDate] = useState(new Date());

  const schedules = generateScheduleForWeek(startDate);

  const endDate = new Date(startDate);
  endDate.setDate(startDate.getDate() + 6);

  const navigateWeek = (direction) => {
    const newStartDate = new Date(startDate);
    newStartDate.setDate(startDate.getDate() + direction * 7);
    setStartDate(newStartDate);
  };

  return (
    <SafeAreaView style={{ flex: 1, backgroundColor : '#f8f8f8' }}>
      <Header />
      <FlatList style={{padding:16}}
        data={[{ key: 'header' }, ...schedules]}  // Added header as an item in FlatList
        keyExtractor={(item, index) => item.key || item.day}
        renderItem={({ item }) => {
          if (item.key === 'header') {
            return (
              <View style={styles.container}>
                <Text style={styles.title}>Jadwal Bermain</Text>

                {/* Pilihan Lapangan */}
                <Picker
                  selectedValue={selectedCourt}
                  onValueChange={(itemValue) => setSelectedCourt(itemValue)}
                  style={styles.picker}
                >
                  <Picker.Item label="Lapangan 1" value="Lapangan 1" />
                  <Picker.Item label="Lapangan 2" value="Lapangan 2" />
                </Picker>

                {/* Tab Navigation */}
                <View style={styles.tabContainer}>
                  {['Daily', 'Weekly', 'Monthly'].map((tab) => (
                    <TouchableOpacity
                      key={tab}
                      style={[styles.tabButton, activeTab === tab && styles.activeTab]}
                      onPress={() => setActiveTab(tab)}
                    >
                      <Text style={[styles.tabText, activeTab === tab && styles.activeTabText]}>{tab}</Text>
                    </TouchableOpacity>
                  ))}
                </View>

                {/* Navigasi Mingguan */}
                <Text style={styles.dateRange}>{formatDate(startDate)} - {formatDate(endDate)}</Text>

                <View style={styles.navContainer}>
                  <TouchableOpacity style={styles.navButton} onPress={() => navigateWeek(-1)}>
                    <Ionicons name="chevron-back" size={24} color="white" />
                  </TouchableOpacity>
                  <TouchableOpacity style={styles.navButton} onPress={() => navigateWeek(1)}>
                    <Ionicons name="chevron-forward" size={24} color="white" />
                  </TouchableOpacity>
                </View>
              </View>
            );
          } else {
            return (
              <View style={styles.scheduleContainer}>
                <View style={styles.scheduleHeader}>
                  <Text style={styles.day}>{item.day}</Text>
                </View>
                {item.times.map((time, index) => (
                  <View key={index} style={styles.timeSlot}>
                    <Text style={styles.dot}>•</Text>
                    <Text style={styles.time}>{time}</Text>
                  </View>
                ))}
              </View>
            );
          }
        }}
      />
    </SafeAreaView>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 20,
    backgroundColor: '#f8f8f8',
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    marginBottom: 20,
  },
  picker: {
    backgroundColor: '#e0e0e0',
    marginBottom: 20,
  },
  tabContainer: {
    flexDirection: 'row',
    justifyContent: 'center',
    marginBottom: 20,
  },
  tabButton: {
    paddingVertical: 10,
    paddingHorizontal: 20,
    borderRadius: 5,
    marginRight: 10,
    backgroundColor: '#ddd',
  },
  activeTab: {
    backgroundColor: '#001F3F',
  },
  tabText: {
    color: 'black',
  },
  activeTabText: {
    color: 'white',
    fontWeight: 'bold',
  },
  navContainer: {
    flexDirection: 'row',
    justifyContent: 'flex-end',
    alignItems: 'center',
    marginBottom: 20,
  },
  navButton: {
    backgroundColor: '#001F3F',
    padding: 10,
    borderRadius: 5,
    margin: 5,
  },
  dateRange: {
    fontSize: 16,
    fontWeight: 'bold',
  },
  scheduleContainer: {
    backgroundColor: 'white',
    borderRadius: 10,
    padding: 15,
    marginBottom: 20,
    shadowColor: '#000',
    shadowOpacity: 0.1,
    shadowOffset: { width: 0, height: 2 },
    shadowRadius: 4,
    elevation: 3,
  },
  scheduleHeader: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginBottom: 10,
  },
  day: {
    fontWeight: 'bold',
    fontSize: 16,
  },
  timeSlot: {
    flexDirection: 'row',
    alignItems: 'center',
    paddingVertical: 5,
  },
  dot: {
    color: 'green',
    marginRight: 10,
  },
  time: {
    fontSize: 16,
  },
});

export default Jadwal;
