import React, { useState } from 'react';
import { View, Text, TouchableOpacity, StyleSheet, ScrollView, Modal } from 'react-native';
import { Ionicons } from '@expo/vector-icons'; // Expo already supports Ionicons
import { useNavigation } from '@react-navigation/native';
import { useDispatch, useSelector } from 'react-redux';
import { removeSelectedJadwalById } from '../../slices/todoSlice';
import axios from 'axios';
import { BE_MAIN_URL } from '../../../url';

const DetailPembayaran = () => {
  const navigation = useNavigation();
  const dispatch = useDispatch()


  const [modalVisible, setModalVisible] = useState(false); // state to control modal visibility
  const [selectedPaymentMethod, setSelectedPaymentMethod] = useState('');


    const getUser = useSelector(state => state.todo1.user)
    const user = getUser.data
  
  const keranjangJadwal = useSelector(state => state.todo1.keranjangJadwal)


  const handlePaymentMethodSelect = (method) => {
    setSelectedPaymentMethod(method);
    setModalVisible(false); // close the modal after selection
  };

  console.log(selectedPaymentMethod)

  let totalHarga = 0;
  keranjangJadwal.forEach((item) => {
    totalHarga = totalHarga + item.harga
  })

  const handleRemoveJadwalById = (_id) => {
    dispatch(removeSelectedJadwalById({_id}))
  }

  const handleBayar = async () => {
    try {
      // Siapkan data untuk pemesanan baru
      const pemesananData = {
        user_id: user._id,  // User ID dari user yang sedang login
        jadwal_dipesan: keranjangJadwal.map((item) => item.id),  // Ambil ID jadwal dari keranjang
        total_harga: totalHarga  // Total harga sebagai string
      };
  
      // Kirim request untuk membuat pemesanan
      const pemesananResponse = await axios.post(`${BE_MAIN_URL}/pemesanan`, pemesananData);
  
      if (pemesananResponse.status === 201) {
        console.log('Pemesanan berhasil dibuat:', pemesananResponse.data);
  
        // Setelah pemesanan berhasil, buat transaksi baru
        const transaksiData = {
          pemesanan_id: pemesananResponse.data.data._id,  // Ambil ID pemesanan yang baru dibuat
          metode_pembayaran: 'bayar_langsung',  // Misalnya menggunakan transfer bank
          status_pembayaran: 'menunggu',  // Status pembayaran menunggu
          tanggal: ""  // Tanggal transaksi saat ini
        };
  
        // Kirim request untuk membuat transaksi
        const transaksiResponse = await axios.post(`${BE_MAIN_URL}/transaksi`, transaksiData);
  
        if (transaksiResponse.status === 201) {
          console.log('Transaksi berhasil dibuat:', transaksiResponse.data);
          // Tindakan selanjutnya setelah transaksi berhasil dibuat, seperti redirect ke halaman pembayaran atau status

        } else {
          console.error('Gagal membuat transaksi:', transaksiResponse.data);
        }
      } else {
        console.error('Gagal membuat pemesanan:', pemesananResponse.data);
      }
    } catch (error) {
      console.error('Terjadi kesalahan:', error);
    }
  };

  return (
    <View style={styles.container}>
      {/* Header */}
      <TouchableOpacity onPress={() => navigation.goBack()} style={styles.header}>
        <Ionicons name="arrow-back" size={24} />
        <Text style={styles.headerTitle}>Detail Pembayaran</Text>
      </TouchableOpacity>

      {/* Notifikasi Waktu */}
      {/* <View style={styles.notification}>
        <Text style={styles.notificationText}>
          Silakan periksa detail transaksi anda dan lanjutkan pembayaran anda dalam{' '}
          <Text style={styles.timer}>1:20</Text>
        </Text>
      </View> */}

      <ScrollView style={styles.content}>
        {/* Detail Pesanan */}
        <Text style={styles.sectionTitle}>Ramos Badminton Center</Text>
        {/* <View style={styles.orderItem}>
          <View>
            <Text style={styles.orderText}>🏸 Lapangan 2</Text>
            <Text style={styles.orderDetail}>Senin, 03 Maret 2025, 20:00 - 21:00</Text>
          </View>
          <Text style={styles.price}>Rp 70.000</Text>
          <Ionicons name="trash-outline" size={20} color="red" />
        </View>
        <View style={styles.orderItem}>
          <View>
            <Text style={styles.orderText}>🏸 Lapangan 2</Text>
            <Text style={styles.orderDetail}>Senin, 03 Maret 2025, 21:00 - 22:00</Text>
          </View>
          <Text style={styles.price}>Rp 70.000</Text>
          <Ionicons name="trash-outline" size={20} color="red" />
        </View> */}
        {
          keranjangJadwal.map((item, ind) =>  <View style={styles.orderItem}>
            <View key={ind}>
              <Text style={styles.orderText}>🏸 {item.lapangan.name}</Text>
              <Text style={styles.orderDetail}>{item.tanggal}, jam {item.jam}</Text>
            </View>
            <Text style={styles.price}>Rp {item.harga}</Text>
            <TouchableOpacity>
              {
                keranjangJadwal.length < 2 ? false :  <Ionicons name="trash-outline" size={20} color="red" onPress={() => handleRemoveJadwalById(item._id)}/>

              }
            </TouchableOpacity>
          </View>)
        }
      
        {/* Ringkasan Pesanan */}
        <View style={styles.summaryContainer}>
          <Text style={styles.sectionTitle}>Ringkasan Pesanan</Text>
          <View style={styles.summaryRow}>
            <Text>Total Harga</Text>
            {/* <Text>Rp 140.000</Text> */}
            <Text>Rp {totalHarga}</Text>

          </View>
          <View style={styles.summaryRow}>
            <Text>Promo</Text>
            <Text>-</Text>
          </View>
          <View style={styles.summaryRow}>
            <Text>Biaya Layanan</Text>
            <Text>0</Text>
          </View>
          <View style={styles.summaryTotal}>
            <Text>Total Pembayaran</Text>
            <Text>Rp {totalHarga}</Text>
          </View>
        </View>

        {/* Metode Pembayaran */}
        <View style={styles.paymentContainer}>
          <Text style={styles.sectionTitle}>Detail Pembayaran</Text>
          <Text style={styles.sectionTitle}>Metode Pembayaran : </Text>
          <TouchableOpacity
            style={styles.paymentMethod}
            onPress={() => setModalVisible(true)} // Open modal when clicked
          >
            {/* Adding the money icon next to the text */}
            <Ionicons name="logo-usd" size={20} color="#001F3F" style={styles.icon} />
            <Text style={{marginLeft:-120}}>{selectedPaymentMethod || 'Pilih Metode Pembayaran'}</Text>
            <Ionicons name="chevron-forward" size={20} />
          </TouchableOpacity>
        </View>
      </ScrollView>

      {/* Footer Pembayaran */}
      <View style={styles.footer}>
        <Text style={styles.totalText}>Total Pembayaran</Text>
        <Text style={styles.totalAmount}>Rp {totalHarga}</Text>
        <TouchableOpacity onPress={() => navigation.navigate('Cash')} style={styles.payButton}>
          <Text style={styles.payButtonText}>Bayar</Text>
        </TouchableOpacity>
      </View>

      {/* Modal untuk memilih metode pembayaran */}
      <Modal
        animationType="slide"
        transparent={true}
        visible={modalVisible}
        onRequestClose={() => setModalVisible(false)} // Close modal on back press
      >
        <View style={styles.modalOverlay}>
          <View style={styles.modalContent}>
            <Text style={styles.modalTitle}>Pilih Metode Pembayaran</Text>
            <TouchableOpacity
              style={styles.modalButton}
              onPress={() => handlePaymentMethodSelect('Cash (Bayar di Tempat)')}
            >
              <Text style={styles.modalButtonText}>Cash (Bayar di Tempat)</Text>
            </TouchableOpacity>
            <TouchableOpacity
              style={styles.modalButton}
              onPress={() => handlePaymentMethodSelect('Bank Transfer Manual')}
            >
              <Text style={styles.modalButtonText}>Bank Transfer Manual</Text>
            </TouchableOpacity>
            <TouchableOpacity
              style={styles.modalButton}
              onPress={() => setModalVisible(false)} // Close modal on cancel
            >
              <Text style={styles.modalButtonText}>Batal</Text>
            </TouchableOpacity>
          </View>
        </View>
      </Modal>
    </View>
  );
};

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: '#fff' },
  header: { flexDirection: 'row', alignItems: 'center', padding: 15, borderBottomWidth: 1, borderColor: '#ddd' },
  headerTitle: { fontSize: 18, fontWeight: 'bold', marginLeft: 10 },
  notification: { backgroundColor: '#ddd', padding: 10, margin: 15, borderRadius: 5 },
  notificationText: { color: '#333' },
  timer: { color: 'red', fontWeight: 'bold' },
  content: { flex: 1, padding: 15 },
  sectionTitle: { fontSize: 16, fontWeight: 'bold', marginBottom: 10 },
  orderItem: { flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center', padding: 10, backgroundColor: '#f8f8f8', borderRadius: 5, marginBottom: 10 },
  orderText: { fontWeight: 'bold' },
  orderDetail: { color: '#555' },
  price: { fontWeight: 'bold', color: '#000' },
  summaryContainer: { padding: 15, backgroundColor: '#f8f8f8', borderRadius: 5, marginBottom: 10 },
  summaryRow: { flexDirection: 'row', justifyContent: 'space-between', marginVertical: 5 },
  summaryTotal: { flexDirection: 'row', justifyContent: 'space-between', marginVertical: 10, fontWeight: 'bold' },
  paymentContainer: { padding: 15, backgroundColor: '#f8f8f8', borderRadius: 5, marginBottom: 10 },
  paymentMethod: { flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center', paddingVertical: 10 },
  footer: { padding: 15, backgroundColor: '#f8f8f8', alignItems: 'space-between' },
  totalText: { color: '#555' },
  totalAmount: { fontSize: 18, fontWeight: 'bold', marginVertical: 5 },
  payButton: { backgroundColor: '#001F3F', paddingVertical: 15, width: '100%', alignItems: 'center', borderRadius: 8 },
  payButtonText: { color: '#fff', fontWeight: 'bold', fontSize: 16 },

  // Styles for modal
  modalOverlay: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: 'rgba(0, 0, 0, 0.5)',
  },
  modalContent: {
    backgroundColor: '#fff',
    padding: 20,
    borderRadius: 8,
    width: '80%',
    alignItems: 'center',
  },
  modalTitle: {
    fontSize: 18,
    fontWeight: 'bold',
    marginBottom: 15,
  },
  modalButton: {
    paddingVertical: 10,
    paddingHorizontal: 20,
    backgroundColor: '#f8f8f8',
    borderRadius: 5,
    marginVertical: 5,
    width: '100%',
    alignItems: 'center',
  },
  modalButtonText: {
    fontSize: 16,
    color: '#333',
  },

  // Icon style
  icon: {
    marginRight: 10,
  },
});

export default DetailPembayaran;
