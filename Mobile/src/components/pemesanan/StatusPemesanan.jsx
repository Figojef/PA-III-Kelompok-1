import React from 'react';
import { View, Text, StyleSheet, TouchableOpacity, ScrollView } from 'react-native';
import { Ionicons } from '@expo/vector-icons'; // Using Ionicons for ChevronLeft and other Icons
import { useNavigation, useRoute } from '@react-navigation/native';

const StatusPemesanan = () => {

  const navigation = useNavigation()

  const route = useRoute()

  const {pemesanan} = route.params;


  function formatJam(jam) {
    // Pastikan jam adalah tipe numerik
    jam = parseInt(jam, 10);
  
    // Menambahkan 0 di depan angka jika jam kurang dari 10
    let jamAwal = jam < 10 ? '0' + jam + ':00' : jam + ':00';
  
    // Menambahkan satu jam ke jam awal (penjumlahan dilakukan setelah memastikan tipe data numerik)
    let jamAkhir = jam + 1;
  
    // Jika jam akhir mencapai 24, reset menjadi 00
    if (jamAkhir === 24) {
      jamAkhir = 0;
    }
  
    // Menambahkan 0 di depan angka jika jam akhir kurang dari 10
    let jamAkhirFormatted = jamAkhir < 10 ? '0' + jamAkhir + ':00' : jamAkhir + ':00';
  
    // Mengembalikan format yang diinginkan
    return jamAwal + ' - ' + jamAkhirFormatted;
  }
  
  
  


  console.log(pemesanan)

  return (
    <ScrollView contentContainerStyle={styles.container}>
      {/* Header */}
      <TouchableOpacity onPress={() => navigation.goBack()} style={styles.header}>
        <Ionicons name="chevron-back" size={24} color="black" />
        <Text style={styles.headerText}>Pesanan</Text>
      </TouchableOpacity>

      {/* Status #fef2c0*/}
      {/* <View style={[styles.status, 
        {backgroundColor: 'green'}]}>
        <Text style={styles.statusText}>{pemesanan.transaksi[0].status_pembayaran}</Text>
      </View> */}

      {pemesanan.transaksi[0].status_pembayaran == "menunggu" ? 
              <View style={[styles.status, 
                {backgroundColor: '#fef2c0'}]}>
                <Text style={[styles.statusText, {color: '#9c6f00'}]}>{pemesanan.transaksi[0].status_pembayaran}</Text>
              </View>
              :
              <View style={[styles.status, 
                {backgroundColor: 'green'}]}>
                <Text style={[styles.statusText, {color: 'white'}]}>{pemesanan.transaksi[0].status_pembayaran} dibayar</Text>
              </View>
      }

      {/* Payment Info */}
      <View style={styles.paymentInfoContainer}>
        <Text style={styles.paymentInfoHeader}>Transaction ID : {pemesanan.transaksi[0]._id}</Text>
        {/* <Text style={styles.paymentInfoSubHeader}>Terminal Sport • Badminton</Text> */}
        <Text style={styles.paymentInfoSubHeader}>GOR Badminton</Text>

        <View style={styles.paymentDetails}>
          <Ionicons name="card" size={24} color="black" />
          {/* <Text>Bank Transfer Manual</Text> */}

         {
          pemesanan.transaksi[0].metode_pembayaran == "bayar_langsung" ?
          <Text>Bayar Langsung Ke Tempat</Text>
          :
          pemesanan.transaksi[0].metode_pembayaran == "transfer_bank" ?
          <Text>Bank Transfer Manual</Text>
          :
          pemesanan.transaksi[0].metode_pembayaran
         }

        </View>
        <View style={styles.timer}>
          <Text>Selesaikan pembayaran anda dalam</Text>
          <Text style={styles.timerText}>06:34:47</Text>
        </View>
        <Text style={styles.paymentInfoFooter}>
          Status bookingan anda akan berubah menjadi DP/Lunas setelah pembayaran sudah terkonfirmasi oleh kasir.
        </Text>
      </View>

      {/* Booking Details */}
      {/* <View style={styles.bookingDetailsContainer}>
        <View style={styles.bookingItem}>
          <Text style={styles.bookingItemTitle}>Badminton 1</Text>
          <Text style={styles.bookingItemTime}>Selasa, 04 Maret 2025 | 17:00 - 18:00</Text>
          <Text style={styles.bookingItemPrice}>Rp 70.000</Text>
        </View>
        <View style={styles.bookingItem}>
          <Text style={styles.bookingItemTitle}>Badminton 1</Text>
          <Text style={styles.bookingItemTime}>Selasa, 04 Maret 2025 | 18:00 - 19:00</Text>
          <Text style={styles.bookingItemPrice}>Rp 70.000</Text>
        </View>
      </View> */}


    <View style={styles.bookingDetailsContainer}>
            {pemesanan.jadwal_dipesan.map((jadwal, index) => (
            <View key={index} style={styles.bookingItem}>
            <Text style={styles.bookingItemTitle}>{jadwal.lapangan.name}</Text>
            <Text style={styles.bookingItemTime}>{jadwal.tanggal} | {formatJam(jadwal.jam)}</Text>
            {console.log(formatJam(jadwal.jam))}
            <Text style={styles.bookingItemPrice}>Rp{jadwal.harga}</Text>
            </View>
            ))}
      </View>

      {/* Order Summary */}
      <View style={styles.orderSummaryContainer}>
        <Text style={styles.orderSummaryTitle}>Order Summary</Text>
        <View style={styles.summaryItem}>
          <Text>Metode Pembayaran</Text>
          {/* <Text style={styles.summaryItemValue}>Bank Transfer Manual</Text> */}
          <Text style={styles.summaryItemValue}>
          {
          pemesanan.transaksi[0].metode_pembayaran == "bayar_langsung" ?
          <Text>Bayar Langsung Ke Tempat</Text>
          :
          pemesanan.transaksi[0].metode_pembayaran == "transfer_bank" ?
          <Text>Bank Transfer Manual</Text>
          :
          pemesanan.transaksi[0].metode_pembayaran
         }
          </Text>
        </View>
        {/* <View style={styles.summaryItem}>
          <Text>Status Pemesanan</Text>
          <Text style={styles.summaryItemValue}>LUNAS</Text>
        </View> */}
        <View style={styles.summaryItem}>
          <Text>Total Harga</Text>
          <Text style={styles.summaryItemValue}>Rp {pemesanan.total_harga}</Text>
        </View>
        <View style={styles.summaryItem}>
          <Text>Promo</Text>
          <Text style={styles.summaryItemValue}>0</Text>
        </View>
        <View style={styles.summaryItem}>
          <Text>Service Charge</Text>
          <Text style={styles.summaryItemValue}>0</Text>
        </View>
        <View style={styles.totalPrice}>
          <Text>Total Pembayaran</Text>
          <Text>Rp.{pemesanan.total_harga}</Text>
        </View>
      </View>

      {/* Action Buttons */}
      {pemesanan.transaksi[0].status_pembayaran == "menunggu" ? 
      <View style={styles.buttonContainer}>
        <TouchableOpacity style={styles.buttonCancel}>
          <Text style={styles.buttonText}>Batalkan</Text>
        </TouchableOpacity>
        {/* <TouchableOpacity onPress={() => navigation.navigate('BankTransfer')} style={styles.buttonPay}>
          <Text style={styles.buttonText}>Bayar</Text>
        </TouchableOpacity> */}
        {
          pemesanan.transaksi[0].metode_pembayaran == "bayar_langsung" ?
          <TouchableOpacity onPress={() => navigation.navigate('Cash', {totalHarga : pemesanan.total_harga})} style={styles.buttonPay}>
          <Text style={styles.buttonText}>Bayar</Text>
        </TouchableOpacity>
          :
          pemesanan.transaksi[0].metode_pembayaran == "transfer_bank" ?
          <TouchableOpacity onPress={() => navigation.navigate('BankTransfer')} style={styles.buttonPay}>
          <Text style={styles.buttonText}>Bayar</Text>
          </TouchableOpacity>
          :
          <TouchableOpacity onPress={() => navigation.navigate('BankTransfer')} style={styles.buttonPay}>
          <Text style={styles.buttonText}>Bayar</Text>
          </TouchableOpacity>
         }
      </View>
    :
     <View></View>
    }
    </ScrollView>
  );
};

const styles = StyleSheet.create({
  container: {
    // paddingBottom: 40,
    padding : 20
     // Ensure enough space for scrollable content
  },
  header: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: 16,
  },
  headerText: {
    fontSize: 18,
    fontWeight: '600',
    marginLeft: 10,
  },
  status: {
    padding: 8,
    borderRadius: 8,
    alignItems: 'center',
    marginBottom: 16,
  },
  statusText: {
    fontWeight: '600',
  },
  paymentInfoContainer: {
    backgroundColor: '#ffffff',
    padding: 16,
    borderRadius: 12,
    marginBottom: 16,
    shadowColor: '#000',
    shadowOpacity: 0.1,
    shadowRadius: 5,
    elevation: 2,
  },
  paymentInfoHeader: {
    fontWeight: '700',
    fontSize: 18,
    marginBottom: 8,
  },
  paymentInfoSubHeader: {
    color: '#6b7280',
  },
  paymentDetails: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 8,
    marginTop: 8,
  },
  timer: {
    backgroundColor: '#e5e7eb',
    padding: 8,
    marginTop: 8,
    borderRadius: 8,
    flexDirection: 'row',
    justifyContent: 'space-between',
  },
  timerText: {
    fontWeight: '600',
  },
  paymentInfoFooter: {
    color: '#6b7280',
    fontSize: 12,
    marginTop: 8,
  },
  bookingDetailsContainer: {
    backgroundColor: '#ffffff',
    padding: 16,
    borderRadius: 12,
    marginBottom: 16,
    shadowColor: '#000',
    shadowOpacity: 0.1,
    shadowRadius: 5,
    elevation: 2,
  },
  bookingItem: {
    borderBottomWidth: 1,
    borderBottomColor: '#e5e7eb',
    paddingBottom: 8,
    marginBottom: 8,
  },
  bookingItemTitle: {
    fontWeight: '600',
  },
  bookingItemTime: {
    fontSize: 12,
  },
  bookingItemPrice: {
    textAlign: 'right',
    fontWeight: '600',
  },
  orderSummaryContainer: {
    backgroundColor: '#ffffff',
    padding: 16,
    borderRadius: 12,
    marginBottom: 16,
    shadowColor: '#000',
    shadowOpacity: 0.1,
    shadowRadius: 5,
    elevation: 2,
  },
  orderSummaryTitle: {
    fontWeight: '700',
    fontSize: 18,
    marginBottom: 8,
  },
  summaryItem: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginBottom: 8,
  },
  summaryItemValue: {
    fontWeight: '600',
  },
  totalPrice: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginTop: 16,
    fontWeight: '700',
    fontSize: 16,
  },
  buttonContainer: {
    flexDirection: 'row',
    gap: 8,
    marginTop: 16,
  },
  buttonCancel: {
    flex: 1,
    paddingVertical: 12,
    borderRadius: 8,
    backgroundColor: 'red',
    // borderColor: '#1d4ed8',
    borderColor : 'red',
    borderWidth: 2,
    alignItems: 'center',
  },
  buttonPay: {
    flex: 1,
    paddingVertical: 12,
    borderRadius: 8,
    backgroundColor: '#1d4ed8',
    alignItems: 'center',
  },
  buttonText: {
    color: '#ffffff',
    fontWeight: '600',
  },
});

export default StatusPemesanan;
