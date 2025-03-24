import { View, Text, StyleSheet, ScrollView, Button, TouchableOpacity, Image } from 'react-native'
import React, { useEffect, useState } from 'react'
import Header from '../layouts/Header'
import { SafeAreaView } from 'react-native-safe-area-context'
import { useNavigation } from '@react-navigation/native'
import { Ionicons } from '@expo/vector-icons'; // Expo sudah mendukung Ionicons
import axios from 'axios'
import { BE_MAIN_URL } from '../../../url'


export default function Booking() {

  const navigation = useNavigation()
  const [lapanganData, setLapanganData] = useState([]);  // State untuk menyimpan data lapangan


  useEffect(() => {
    // Mengambil data lapangan dari API
    axios.get(`${BE_MAIN_URL}/lapangan`)
      .then(response => {
        setLapanganData(response.data.data);  // Menyimpan data lapangan ke dalam state
        console.log(lapanganData)
      })
      .catch(error => {
        console.error("Error fetching lapangan data:", error);  // Menangani error jika ada
      });
  }, []);  // Hook useEffect untuk menjalankan sekali saat komponen di-crender


  return (
    <SafeAreaView style={styles.container}>

      <Header/>
        <ScrollView style={styles.container}>

    
      <Image source={require('../../../assets/arena.png')} style={styles.image} /> Pastikan path gambar benar
      <View style={styles.infoContainer}>
        <Text style={styles.title}>Terminal Sport</Text>
        <Text style={styles.subtitle}>Belum ada ulasan</Text>
        <Text style={styles.text}>
          <Ionicons name="location-outline" size={16} /> Desa Sigumpar, Kecamatan Laguboti, Kabupaten Toba
        </Text>
        <Text style={styles.text}>
          <Ionicons name="call-outline" size={16} /> 082167589661
        </Text>
        <Text style={styles.text}>
          <Ionicons name="time-outline" size={16} /> 08:00 - 24:00
        </Text>
        <Text style={styles.text}>
          <Ionicons name="checkmark-circle-outline" size={16} /> Parkir, Toilet, Kantin
        </Text>
      </View>

      <View style={styles.section}>
        <Text style={styles.sectionTitle}>Pilih Lapangan</Text>
        {
          lapanganData ? 
          lapanganData.map((item, ind) => (
            <TouchableOpacity key={ind} style={styles.card} onPress={() => navigation.navigate('SelectSchedule', {lapangan : `Yard ${item.name}`, lapangan2 : item })}>
              <Image source={require('../../../assets/lapangan1.png')} style={styles.cardImage} /> Pastikan path gambar benar
              <TouchableOpacity style={styles.cardContent} onPress={() => navigation.navigate('SelectSchedule', {lapangan : `Yard ${item.name}`, lapangan2 : item })}>
                <Text style={styles.cardTitle}>{item.name}</Text>
                <Text style={styles.cardText}>{item.deskripsi}</Text>
              </TouchableOpacity>
            </TouchableOpacity>
          ))
          :
            <Text>
              Lapangan tidak ditemukan
            </Text>
          //             [1, 2].map((item) => (
          //   <TouchableOpacity key={item} style={styles.card} onPress={() => navigation.navigate('SelectSchedule')}>
          //     <Image source={require('../../../assets/lapangan1.png')} style={styles.cardImage} /> Pastikan path gambar benar
          //     <TouchableOpacity style={styles.cardContent} onPress={() => navigation.navigate('SelectSchedule')}>
          //       <Text style={styles.cardTitle}>Badminton {item}</Text>
          //       <Text style={styles.cardText}>Type Indoor, Rumput Sintetis, 6.1 x 13.4m</Text>
          //     </TouchableOpacity>
          //   </TouchableOpacity>
          // ))
        }
      </View>

      <View style={styles.section}>
        <Text style={styles.sectionTitle}>Kebijakan Arena</Text>
        <Text style={styles.text}>1. Booking dapat dibayar sebelum atau setelah main.</Text>
        <Text style={styles.text}>2. Uang booking tidak dapat dikembalikan.</Text>
        <Text style={styles.text}>3. Penyewa terlambat tidak dapat tambahan waktu.</Text>
      </View>

      <View style={styles.section}>
        <Text style={styles.sectionTitle}>Club Membership</Text>
        <Text style={styles.text}>Gabung sebagai member untuk keuntungan eksklusif.</Text>
        <TouchableOpacity style={styles.button}>
          <Text style={styles.buttonText}>Gabung Club Member</Text>
        </TouchableOpacity>
      </View>
    </ScrollView>
        </SafeAreaView>
  )
}


const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: '#f8f8f8' },
  image: { width: '100%', height: 200 },
  infoContainer: { padding: 15 },
  title: { fontSize: 22, fontWeight: 'bold' },
  subtitle: { color: 'gray' },
  text: { fontSize: 14, marginVertical: 5 },
  section: { padding: 15 },
  sectionTitle: { fontSize: 18, fontWeight: 'bold', marginBottom: 10 },
  card: { flexDirection: 'row', backgroundColor: '#fff', borderRadius: 8, marginBottom: 10, overflow: 'hidden' },
  cardImage: { width: 100, height: 80 },
  cardContent: { padding: 10, flex: 1 },
  cardTitle: { fontSize: 16, fontWeight: 'bold' },
  cardText: { fontSize: 14, color: 'gray' },
  button: { backgroundColor: '#001F3F', padding: 12, borderRadius: 8, alignItems: 'center' },
  buttonText: { color: '#fff', fontSize: 16, fontWeight: 'bold' }
});