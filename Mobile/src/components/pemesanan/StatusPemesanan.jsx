import React from 'react';
import { View, Text, StyleSheet, TouchableOpacity, ScrollView } from 'react-native';
import { Ionicons } from '@expo/vector-icons'; // Using Ionicons for ChevronLeft and other Icons
import { useNavigation } from '@react-navigation/native';

const StatusPemesanan = () => {

  const navigation = useNavigation()

  return (
    <ScrollView contentContainerStyle={styles.container}>
      {/* Header */}
      <TouchableOpacity onPress={() => navigation.goBack()} style={styles.header}>
        <Ionicons name="chevron-back" size={24} color="black" />
        <Text style={styles.headerText}>Pesanan</Text>
      </TouchableOpacity>

      {/* Status */}
      <View style={styles.status}>
        <Text style={styles.statusText}>Menunggu</Text>
      </View>

      {/* Payment Info */}
      <View style={styles.paymentInfoContainer}>
        <Text style={styles.paymentInfoHeader}>Payment ID #INV-250304-EFAAKINMR-35</Text>
        <Text style={styles.paymentInfoSubHeader}>Terminal Sport • Badminton</Text>
        <View style={styles.paymentDetails}>
          <Ionicons name="card" size={24} color="black" />
          <Text>Bank Transfer Manual</Text>
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
      <View style={styles.bookingDetailsContainer}>
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
      </View>

      {/* Order Summary */}
      <View style={styles.orderSummaryContainer}>
        <Text style={styles.orderSummaryTitle}>Order Summary</Text>
        <View style={styles.summaryItem}>
          <Text>Metode Pembayaran</Text>
          <Text style={styles.summaryItemValue}>Bank Transfer Manual</Text>
        </View>
        <View style={styles.summaryItem}>
          <Text>Status Pemesanan</Text>
          <Text style={styles.summaryItemValue}>LUNAS</Text>
        </View>
        <View style={styles.summaryItem}>
          <Text>Total Harga</Text>
          <Text style={styles.summaryItemValue}>Rp 140.000</Text>
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
          <Text>Rp 140.000</Text>
        </View>
      </View>

      {/* Action Buttons */}
      <View style={styles.buttonContainer}>
        <TouchableOpacity style={styles.buttonCancel}>
          <Text style={styles.buttonText}>Batalkan</Text>
        </TouchableOpacity>
        <TouchableOpacity onPress={() => navigation.navigate('BankTransfer')} style={styles.buttonPay}>
          <Text style={styles.buttonText}>Bayar</Text>
        </TouchableOpacity>
      </View>
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
    backgroundColor: '#fef2c0',
    padding: 8,
    borderRadius: 8,
    alignItems: 'center',
    marginBottom: 16,
  },
  statusText: {
    color: '#9c6f00',
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
