import React from 'react';
import { View, Text, Image, TouchableOpacity, StyleSheet, ScrollView } from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { SafeAreaView } from 'react-native-safe-area-context';
import Header from '../layouts/Header';
import { useNavigation } from '@react-navigation/native';
import { useDispatch, useSelector } from 'react-redux';
import { BE_MAIN_URL } from '../../../url';


const Home = () => {

  const navigation = useNavigation()
  const dispatch = useDispatch()
  const testD = useSelector(state => state.todo1.testD)



  return (
    <View style={styles.rootContainer}>
      <SafeAreaView style={styles.container}>
      <Header />
        <ScrollView 
          showsVerticalScrollIndicator={false} 
          contentContainerStyle={styles.scrollContent} 
          keyboardShouldPersistTaps="handled"
        >
          {/* Banner */}
          <Image 
            source={require('../../../assets/bm.jpg')} // Pastikan nama file sesuai
            style={styles.banner}
          />

          {/* Fitur Kami */}
          <Text style={styles.title}>Fitur Kami</Text>

          <TouchableOpacity style={styles.card}>
            <Ionicons name="calendar-outline" size={24} style={styles.icon} />
            <View>
              <Text style={styles.cardTitle}>Cek Jadwal Lapangan</Text>
              <Text style={styles.cardSubtitle}>Melihat jadwal yang tersedia untuk lapangan</Text>
            </View>
          </TouchableOpacity>

          <TouchableOpacity style={styles.card} onPress={() => navigation.navigate('Test1')}>
            <Ionicons name="book-outline" size={24} style={styles.icon} />
            <View>
              <Text style={styles.cardTitle}>Booking Lapangan</Text>
              <Text style={styles.cardSubtitle}>Reservasi waktu lapangan yang diinginkan</Text>
            </View>
          </TouchableOpacity>

          <TouchableOpacity style={styles.card}>
            <Ionicons name="people-outline" size={24} style={styles.icon} />
            <View>
              <Text style={styles.cardTitle}>Temukan Partner Bermain</Text>
              <Text style={styles.cardSubtitle}>Terhubung dengan pemain lain</Text>
            </View>
          </TouchableOpacity>

          {/* Tentang Kami */}
          <View style={styles.aboutContainer}>
            <Text style={styles.aboutTitle}>Tentang Kami</Text>
            <Text style={styles.aboutText}>
              Selamat datang di Ramos Badminton Center. Kami menyediakan lapangan profesional untuk para penggemar bulutangkis.
            </Text>
          </View>
          <View>
            <Text></Text>
          </View>
        </ScrollView>
      </SafeAreaView>
    </View>
  );
};

const styles = StyleSheet.create({
  rootContainer: {
    flex: 1,
  },
  container: {
    flex: 1,
    backgroundColor: '#f8f8f8',
  },
  scrollContent: {
    padding: 20,
    paddingBottom: 90, // Menambahkan padding untuk menghindari konten tertutup oleh bottom navigation
  },
  banner: {
    width: '100%',
    height: 200,
    borderRadius: 10,
    marginBottom: 20,
  },
  title: {
    fontSize: 22,
    fontWeight: 'bold',
    marginBottom: 20,
  },
  card: {
    flexDirection: 'row',
    backgroundColor: 'white',
    padding: 20,
    borderRadius: 10,
    marginBottom: 15,
    alignItems: 'center',
    shadowColor: '#000',
    shadowOpacity: 0.1,
    shadowOffset: { width: 0, height: 2 },
    shadowRadius: 4,
    elevation: 3,
  },
  icon: {
    marginRight: 15,
  },
  cardTitle: {
    fontSize: 18,
    fontWeight: 'bold',
  },
  cardSubtitle: {
    fontSize: 14,
    color: '#555',
  },
  aboutContainer: {
    backgroundColor: '#d1d5db',
    padding: 20,
    borderRadius: 10,
    marginTop: 30,
    marginBottom: 30,
  },
  aboutTitle: {
    fontSize: 20,
    fontWeight: 'bold',
    marginBottom: 10,
  },
  aboutText: {
    fontSize: 14,
    color: '#333',
  },
});

export default Home;
