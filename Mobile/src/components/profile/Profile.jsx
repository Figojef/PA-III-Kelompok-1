import { View, Text, StyleSheet, ScrollView, Button, Alert, ActivityIndicator, TouchableOpacity } from 'react-native'
import React, { useState } from 'react'
import Header from '../layouts/Header'
import { SafeAreaView } from 'react-native-safe-area-context'
import { useDispatch, useSelector } from 'react-redux'
import axios from 'axios'
import { logout } from '../../slices/todoSlice';
import { BE_MAIN_URL } from '../../../url'

export default function Profile() {

  const dispatch = useDispatch()
  const getUser = useSelector(state => state.todo1.user)
  const user = getUser.data

  const [data, setData] = useState([]); // Menyimpan data dari API
  const [loading, setLoading] = useState(false); // Menyimpan status loading

  // Fungsi untuk mendapatkan data dari API
  const fetchData = async () => {
    setLoading(true); // Set loading true saat memulai permintaan
    try {
      const response = await axios.get(`${BE_MAIN_URL}/lapangan`); // Ganti dengan URL API Anda
      setData(response.data); // Menyimpan data ke state
      // console.log(response.data)
      response.data.data.forEach((d) => console.log(d.name))
    } catch (error) {
            Alert.alert('Error', 'Terjadi kesalahan autentikasi.', [{ text: 'OK' }]);

      // console.error('Error fetching data: ', error);
    } finally {
      setLoading(false); // Set loading false setelah permintaan selesai
    }
  };

  const handleLogout = async () => {
    try {
      // Mengirim request logout ke backend
      const response = await axios.get(`${BE_MAIN_URL}/auth/logout`, { withCredentials: true });

      // Jika logout berhasil, dispatch logout pada Redux
      dispatch(logout());

      // Menampilkan pesan berhasil logout
      Alert.alert('Logout', response.data.message, [{ text: 'OK' }]);
    } catch (error) {
      console.error(error);
      Alert.alert('Error', 'Terjadi kesalahan saat logout.', [{ text: 'OK' }]);
    }
  };

  return (
    <View style={styles.rootContainer}>
      <Header />
      <SafeAreaView style={styles.container}>
        <ScrollView
          showsVerticalScrollIndicator={false}
          contentContainerStyle={styles.scrollContent}
          keyboardShouldPersistTaps="handled"
        >
          {/* Profile Header */}
          <View style={styles.profileHeader}>
            <Text style={styles.headerText}>Profile</Text>
          </View>

          {/* User Info Cards */}
          <View style={styles.infoCard}>
            <Text style={styles.infoLabel}>Name:</Text>
            <Text style={styles.infoText}>{user.name}</Text>
          </View>

          <View style={styles.infoCard}>
            <Text style={styles.infoLabel}>Email:</Text>
            <Text style={styles.infoText}>{user.email}</Text>
          </View>

          <View style={styles.infoCard}>
            <Text style={styles.infoLabel}>Role:</Text>
            <Text style={styles.infoText}>{user.role}</Text>
          </View>

          {/* Button to fetch data */}
          <View style={styles.buttonContainer}>
        <TouchableOpacity onPress={() => handleLogout()} style={{ backgroundColor: '#001F3F', padding: 12, borderRadius: 8, alignItems: 'center' }}>
          <Text style={{color: '#fff'}}>Logout</Text>
        </TouchableOpacity>            
          </View>

          {/* Loading Indicator */}
          {loading && (
            <View style={styles.loadingContainer}>
              <ActivityIndicator size="large" color="#0066cc" />
            </View>
          )}
        </ScrollView>
      </SafeAreaView>
    </View>
  );
}

const styles = StyleSheet.create({
  rootContainer: {
    flex: 1,
  },
  container: {
    flex: 1,
    backgroundColor: '#fdfbe9',
    padding: 15,
  },
  scrollContent: {
    paddingBottom: 90,
  },
  profileHeader: {
    marginBottom: 20,
    alignItems: 'center',
  },
  headerText: {
    fontSize: 28,
    fontWeight: 'bold',
    color: '#333',
  },
  infoCard: {
    backgroundColor: '#ffffff',
    padding: 15,
    borderRadius: 10,
    marginBottom: 15,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 5,
    elevation: 3,
  },
  infoLabel: {
    fontSize: 16,
    fontWeight: '500',
    color: '#555',
  },
  infoText: {
    fontSize: 18,
    color: '#333',
    marginTop: 5,
  },
  buttonContainer: {
    marginTop: 20,
    marginBottom: 20,
  },
  loadingContainer: {
    alignItems: 'center',
    marginTop: 20,
  },
});
