import React, { useState, useEffect } from 'react';
import { View, Text, TouchableOpacity, StyleSheet, ScrollView, ActivityIndicator } from 'react-native';
import axios from 'axios';
import { useSelector } from 'react-redux';
import { useNavigation } from '@react-navigation/native';
import Header from '../layouts/Header';
import { SafeAreaView } from 'react-native-safe-area-context';
import { BE_MAIN_URL } from '../../../url';

const Pemesanan = () => {
  const navigation = useNavigation();
    
  const getUser = useSelector(state => state.todo1.user);
  const user = getUser.data;

  // State to store fetched pemesanan data
  const [pemesananData, setPemesananData] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  // Fetch pemesanan data using axios
  useEffect(() => {
    const fetchPemesanan = async () => {
      try {
        console.log(user._id)
        const response = await axios.get(`${BE_MAIN_URL}/pemesanan/user/${user._id}`);
        setPemesananData(response.data); // Set the fetched pemesanan data
        setLoading(false); // Set loading to false after data is fetched
      } catch (err) {
        console.log('fail')
        setError('Pesanan Anda Kosong');
        setLoading(false);
      }
    };

    fetchPemesanan();
  }, [user._id]); // Dependency on user._id to refetch data if user changes

  if (loading) {
    return (
      <SafeAreaView style={{ flex: 1 }}>
        <Header />
        <View style={styles.loadingContainer}>
          <ActivityIndicator size="large" color="#F7B500" />
          <Text style={styles.loadingText}>Loading...</Text>
        </View>
      </SafeAreaView>
    );
  }

  if (error) {
    return (
      <SafeAreaView style={{ flex: 1 }}>
        <Header />
        <View style={styles.errorContainer}>
          <Text style={styles.errorText}>{error}</Text>
        </View>
      </SafeAreaView>
    );
  }

  return (
    <SafeAreaView style={{ flex: 1 }}> {/* Pastikan SafeAreaView mengisi seluruh layar */}
      <Header />
      <ScrollView style={styles.container}>

        {/* Render pemesanan data */}
        {
          pemesananData.length >= 1 ?
          pemesananData.map((pemesanan) => (
            <TouchableOpacity
              key={pemesanan._id}
              onPress={() => navigation.navigate('StatusPemesanan', { pemesanan })}
              style={styles.orderCard}
            >
              <Text style={styles.transactionId}>Pemesanan ID: {pemesanan._id}</Text>

              <Text style={styles.field}>Lapangan : {pemesanan.jadwal_dipesan[0].lapangan.name}</Text>
              <View style={styles.footer}>
                <Text style={styles.total}>Jumlah Pesanan: <Text style={styles.bold}>{pemesanan.jadwal_dipesan.length}</Text></Text>
                <TouchableOpacity style={[styles.statusButton, 
                  {backgroundColor: pemesanan.transaksi[0].status_pembayaran == "menunggu" ? '#F7B500' : 'green'}]}>
                  {/* <Text style={styles.statusText}>{pemesanan.status_pemesanan}</Text> */}
                  <Text style={styles.statusText}>{pemesanan.transaksi[0].status_pembayaran}</Text>
                </TouchableOpacity>
              </View>
            </TouchableOpacity>
          ))
          :
          <SafeAreaView style={{ flex: 1 }}>
          <Header />
          <View style={styles.errorContainer}>
            <Text style={styles.errorText}>Terdapat masalah, coba refresh : </Text>
          </View>
        </SafeAreaView>
        }
      </ScrollView>
    </SafeAreaView>
  );
};

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: '#fff', paddingHorizontal: 15, paddingTop: 10 },
  orderCard: { backgroundColor: '#fff', padding: 15, borderRadius: 10, shadowColor: '#000', shadowOpacity: 0.1, shadowRadius: 5, elevation: 2, marginBottom: 15 },
  transactionId: { color: '#888', fontSize: 12, marginBottom: 5 },
  field: { fontSize: 16, fontWeight: 'bold', marginBottom: 5 },
  date: { fontSize: 14, color: '#555', marginBottom: 3 },
  time: { fontSize: 14, color: '#333' },
  footer: { flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center', marginTop: 10 },
  total: { fontSize: 14, color: '#333' },
  bold: { fontWeight: 'bold' },
  statusButton: { paddingVertical: 5, paddingHorizontal: 15, borderRadius: 20 },
  statusText: { color: '#fff', fontWeight: 'bold' },
  loadingContainer: { flex: 1, justifyContent: 'center', alignItems: 'center', backgroundColor: '#fff' },
  loadingText: { fontSize: 18, color: '#333', marginTop: 10 },
  errorContainer: { flex: 1, justifyContent: 'center', alignItems: 'center', backgroundColor: '#fff' },
  errorText: { fontSize: 18, color: '#e74c3c', marginTop: 10 },
});


export default Pemesanan;
