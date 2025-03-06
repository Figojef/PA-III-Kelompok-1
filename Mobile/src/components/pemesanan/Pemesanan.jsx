import React from 'react';
import { View, Text, TouchableOpacity, StyleSheet, ScrollView } from 'react-native';
import Icon from 'react-native-vector-icons/Ionicons';
import Header from '../layouts/Header';
import { SafeAreaView } from 'react-native-safe-area-context';
import { useNavigation } from '@react-navigation/native';

const Pemesanan = () => {
    const navigation = useNavigation()

  return (
    <SafeAreaView style={{ flex: 1 }}> {/* Pastikan SafeAreaView mengisi seluruh layar */}
      <Header />
      <ScrollView style={styles.container}>
        {/* Tabs */}
        <View style={styles.tabs}>
          <Text style={styles.activeTab}>Sedang Berlangsung</Text>
          <Text style={styles.inactiveTab}>Histori</Text>
        </View>

        {/* Order Card */}
        <TouchableOpacity onPress={() => navigation.navigate('StatusPemesanan')} style={styles.orderCard}>
          <Text style={styles.transactionId}>Transaction ID: INV-287210-42</Text>
          <Text style={styles.field}>Lapangan 2</Text>
          <Text style={styles.date}>Senin, 03 Maret 2025</Text>
          <Text style={styles.time}>20:00 - 21:00</Text>
          <Text style={styles.time}>21:00 - 22:00</Text>
          <View style={styles.footer}>
            <Text style={styles.total}>Jumlah Pesanan: <Text style={styles.bold}>2</Text></Text>
            <TouchableOpacity style={styles.statusButton}>
              <Text style={styles.statusText}>Menunggu</Text>
            </TouchableOpacity>
          </View>
        </TouchableOpacity>
      </ScrollView>
    </SafeAreaView>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#fff',
    paddingHorizontal: 15,
    paddingTop: 10, // Menambahkan padding untuk mencegah konten terlalu dekat dengan bagian atas layar
  },
  tabs: {
    flexDirection: 'row',
    borderBottomWidth: 1,
    borderBottomColor: '#ccc',
    marginBottom: 20,
  },
  activeTab: {
    flex: 1,
    textAlign: 'center',
    fontSize: 16,
    fontWeight: 'bold',
    borderBottomWidth: 2,
    borderBottomColor: 'black',
    paddingBottom: 5,
  },
  inactiveTab: {
    flex: 1,
    textAlign: 'center',
    fontSize: 16,
    color: '#ccc',
    paddingBottom: 5,
  },
  orderCard: {
    backgroundColor: '#fff',
    padding: 15,
    borderRadius: 10,
    shadowColor: '#000',
    shadowOpacity: 0.1,
    shadowRadius: 5,
    elevation: 2,
  },
  transactionId: {
    color: '#888',
    fontSize: 12,
    marginBottom: 5,
  },
  field: {
    fontSize: 16,
    fontWeight: 'bold',
    marginBottom: 5,
  },
  date: {
    fontSize: 14,
    color: '#555',
    marginBottom: 3,
  },
  time: {
    fontSize: 14,
    color: '#333',
  },
  footer: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginTop: 10,
  },
  total: {
    fontSize: 14,
    color: '#333',
  },
  bold: {
    fontWeight: 'bold',
  },
  statusButton: {
    backgroundColor: '#F7B500',
    paddingVertical: 5,
    paddingHorizontal: 15,
    borderRadius: 20,
  },
  statusText: {
    color: '#fff',
    fontWeight: 'bold',
  },
});

export default Pemesanan;
