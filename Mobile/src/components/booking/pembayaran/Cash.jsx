import { useNavigation } from '@react-navigation/native';
import React from 'react';
import { View, Text, TouchableOpacity, StyleSheet } from 'react-native';
import Icon from 'react-native-vector-icons/Ionicons';

const Cash = () => {
    const navigation = useNavigation()

  return (
    <View style={styles.container}>
      {/* Header */}
      <View style={styles.header}>
        <TouchableOpacity onPress={() => navigation.navigate('TabNavigator')} style={styles.headerTitle}>
        <Icon name="arrow-back" size={24} />
            <Text style={{fontWeight : "bold", fontSize : 18, marginLeft : 10}}>
            Cash
            </Text>
        </TouchableOpacity>
      </View>

      {/* Batas Akhir Pembayaran */}
      {/* <View style={styles.paymentDeadline}>
        <Text style={styles.deadlineText}>Batas Akhir Pembayaran</Text>
        <Text style={styles.deadlineDate}>Selasa, 04 Maret 2025 23:31</Text>
        <Text style={styles.deadlineTime}>23:59:54</Text>
      </View> */}

      {/* Manual Transfer */}
      <Text style={styles.sectionTitle}>Bayar Di Tempat</Text>
      <Text style={styles.label}>Nomor Rekening</Text>
      {/* <View style={styles.accountContainer}>
        <View>
          <Text style={styles.accountNumber}>5626567921</Text>
          <Text style={styles.accountName}>a/n Yakob Simatupang</Text>
        </View>
        <TouchableOpacity style={styles.copyButton}>
          <Text style={styles.copyButtonText}>Salin</Text>
        </TouchableOpacity>
      </View> */}

      {/* Total Pembayaran */}
      <Text style={styles.totalPaymentLabel}>Total Pembayaran</Text>
      <Text style={styles.totalPayment}>Rp 140.000</Text>

      {/* Buttons Container */}
      <View style={styles.buttonsContainer}>
        {/* <TouchableOpacity style={styles.uploadButton}>
          <Text style={styles.buttonText}>Upload Bukti Transfer</Text>
        </TouchableOpacity>
        <TouchableOpacity style={styles.confirmButton}>
          <Text style={styles.buttonText}>Konfirmasi Pembayaran</Text>
        </TouchableOpacity> */}
        <TouchableOpacity onPress={() => navigation.navigate('TabNavigator', {screen : 'Pemesanan'})} style={styles.statusButton}>
          <Text style={styles.statusButtonText}>Cek Status Pesanan</Text>
        </TouchableOpacity>
      </View>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#fff',
    padding: 15,
    flexDirection: 'column',
  },
  header: { flexDirection: 'row', alignItems: 'center', marginBottom: 20 },
  headerTitle: { fontSize: 18, fontWeight: 'bold', marginLeft: 10, flexDirection : 'row' },
  paymentDeadline: { backgroundColor: '#FFEEEE', padding: 10, borderRadius: 5, marginBottom: 20 },
  deadlineText: { color: '#333' },
  deadlineDate: { fontWeight: 'bold', color: '#D00000' },
  deadlineTime: { position: 'absolute', right: 10, color: '#D00000' },
  sectionTitle: { fontSize: 16, fontWeight: 'bold', marginBottom: 10 },
  label: { color: '#555', marginBottom: 5 },
  accountContainer: { flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center', backgroundColor: '#f8f8f8', padding: 10, borderRadius: 5, marginBottom: 15 },
  accountNumber: { fontWeight: 'bold' },
  accountName: { color: '#555' },
  copyButton: { backgroundColor: '#001F3F', padding: 8, borderRadius: 5 },
  copyButtonText: { color: '#fff', fontWeight: 'bold' },
  totalPaymentLabel: { color: '#555', marginBottom: 5 },
  totalPayment: { fontSize: 18, fontWeight: 'bold', color: '#D00000', marginBottom: 20 },
  buttonsContainer: {
    flex: 1,
    justifyContent: 'flex-end', // Ensures buttons stay at the bottom
  },
  uploadButton: { backgroundColor: '#001F3F', padding: 15, borderRadius: 8, alignItems: 'center', marginBottom: 10 },
  confirmButton: { backgroundColor: '#001F3F', padding: 15, borderRadius: 8, alignItems: 'center', marginBottom: 10 },
  buttonText: { color: '#fff', fontWeight: 'bold', fontSize: 16 },
  statusButton: { backgroundColor: '#EEE', padding: 15, borderRadius: 8, alignItems: 'center' },
  statusButtonText: { color: '#333', fontWeight: 'bold', fontSize: 16 },
});

export default Cash;
