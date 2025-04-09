import React, { use, useState } from 'react';
import { View, Text, TouchableOpacity, StyleSheet, ScrollView, Modal } from 'react-native';
import { Ionicons } from '@expo/vector-icons'; // Expo already supports Ionicons
import { useNavigation } from '@react-navigation/native';
import { useDispatch, useSelector } from 'react-redux';
import { removeSelectedJadwalById, removeSelectedJadwal } from '../../slices/todoSlice';
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


  keranjangJadwal.length >= 1 ?
  keranjangJadwal.forEach((item) => {
    totalHarga = totalHarga + item.harga
  })
  :
  totalHarga = 0

  console.log(totalHarga)

  const handleRemoveJadwalById = (_id) => {
    dispatch(removeSelectedJadwalById({_id}))
  }


  const handleOrder = async () => {
    try {
      // Prepare data for the requests
      const user_id = user._id;
      const jadwal_dipesan = keranjangJadwal.map((item) => item._id);
      const metode_pembayaran = selectedPaymentMethod;
      if(metode_pembayaran == ""){
        alert('Pilih metode pembayaran')
        return
      }
      // console.log('oke')

      const response = await axios.post(`${BE_MAIN_URL}/pemesanan`, {
        user_id,
        jadwal_dipesan,
        total_harga: totalHarga,
        metode_pembayaran
      });
      

      if (response.status === 201) {
        // Successfully created the order and transaction
        const totalHarga2 = totalHarga
        dispatch(removeSelectedJadwal()); // Clear the selected jadwal
        console.log(response.data.info)
        navigation.navigate('Cash', {totalHarga2}); // Navigate to Cash screen
      }
    } catch (error) {
      console.log(0)
      console.error("Error while creating order:", error);
      // You can show an alert or some other feedback to the user
    }
  };

  const user_id = user._id;
  const jadwal_dipesan = keranjangJadwal.map((item) => item._id);
  const metode_pembayaran = selectedPaymentMethod;


  return (
    
    <View style={styles.container}>
      {/* Header */}
      <TouchableOpacity onPress={() => navigation.goBack()} style={styles.header}>
        <Ionicons name="arrow-back" size={24} />
        <Text style={styles.headerTitle}>Detail Pembayaran</Text>
      </TouchableOpacity>

      {/* <TouchableOpacity onPress={handleOrder}>
        <Text>ssssssssssssssssssssssssssssssssssssssssssssssss</Text>
      </TouchableOpacity> */}

      <ScrollView style={styles.content}>
        {/* Detail Pesanan */}
        <Text style={styles.sectionTitle}>Ramos Badminton Center</Text>
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
        <TouchableOpacity onPress={handleOrder} style={styles.payButton}>
          <Text style={styles.payButtonText}>Bayars</Text>
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
              onPress={() => handlePaymentMethodSelect('bayar_langsung')}
            >
              <Text style={styles.modalButtonText}>Cash (Bayar di Tempat)</Text>
            </TouchableOpacity>
            <TouchableOpacity
              style={styles.modalButton}
              onPress={() => handlePaymentMethodSelect('transfer_bank')}
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
