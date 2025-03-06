// import React from 'react';
// import { View, Text, Image, ScrollView, TouchableOpacity, StyleSheet, LogBox } from 'react-native';
// import { Ionicons } from '@expo/vector-icons'; // Expo sudah mendukung Ionicons
// import { useNavigation } from '@react-navigation/native';



// const TerminalSport = () => {

//   const navigation = useNavigation();
  
//   return (
//     <ScrollView style={styles.container}>
//       <View style={{ flexDirection: 'row', alignItems: 'center', paddingLeft: 15 }}>
//         {/* Tombol kembali */}
//         <TouchableOpacity onPress={() => navigation.goBack()} style={{ padding: 10 }}>
//           <Ionicons name="arrow-back-circle" size={24} color="black" />
//         </TouchableOpacity>
//       </View>
      
//       <Image source={require('../../../assets/arena.png')} style={styles.image} /> Pastikan path gambar benar

//       <View style={styles.infoContainer}>
//         <Text style={styles.title}>Terminal Sport</Text>
//         <Text style={styles.subtitle}>Belum ada ulasan</Text>
//         <Text style={styles.text}>
//           <Ionicons name="location-outline" size={16} /> Jl. SMTK Medan No.10, Padang Bulan, Medan
//         </Text>
//         <Text style={styles.text}>
//           <Ionicons name="call-outline" size={16} /> 082167589661
//         </Text>
//         <Text style={styles.text}>
//           <Ionicons name="time-outline" size={16} /> 08:00 - 24:00
//         </Text>
//         <Text style={styles.text}>
//           <Ionicons name="checkmark-circle-outline" size={16} /> Parkir, Toilet, Kantin
//         </Text>
//       </View>

//       <View style={styles.section}>
//         <Text style={styles.sectionTitle}>Pilih Lapangan</Text>
//         {[1, 2, 3].map((item) => (
//           <View key={item} style={styles.card}>
//             <Image source={require('../../../assets/lapangan1.png')} style={styles.cardImage} /> {/* Pastikan path gambar benar */}
//             <View style={styles.cardContent}>
//               <Text style={styles.cardTitle}>Badminton {item}</Text>
//               <Text style={styles.cardText}>Type Indoor, Rumput Sintetis, 6.1 x 13.4m</Text>
//             </View>
//           </View>
//         ))}
//       </View>

//       <View style={styles.section}>
//         <Text style={styles.sectionTitle}>Kebijakan Arena</Text>
//         <Text style={styles.text}>1. Booking DP 50% atau bayar lunas.</Text>
//         <Text style={styles.text}>2. Uang booking tidak dapat dikembalikan.</Text>
//         <Text style={styles.text}>3. Penyewa terlambat tidak dapat tambahan waktu.</Text>
//       </View>

//       <View style={styles.section}>
//         <Text style={styles.sectionTitle}>Club Membership</Text>
//         <Text style={styles.text}>Gabung sebagai member untuk keuntungan eksklusif.</Text>
//         <TouchableOpacity style={styles.button}>
//           <Text style={styles.buttonText}>Gabung Club Member</Text>
//         </TouchableOpacity>
//       </View>
//     </ScrollView>
//   );
// };

// const styles = StyleSheet.create({
//   container: { flex: 1, backgroundColor: '#f8f8f8' },
//   image: { width: '100%', height: 200 },
//   infoContainer: { padding: 15 },
//   title: { fontSize: 22, fontWeight: 'bold' },
//   subtitle: { color: 'gray' },
//   text: { fontSize: 14, marginVertical: 5 },
//   section: { padding: 15 },
//   sectionTitle: { fontSize: 18, fontWeight: 'bold', marginBottom: 10 },
//   card: { flexDirection: 'row', backgroundColor: '#fff', borderRadius: 8, marginBottom: 10, overflow: 'hidden' },
//   cardImage: { width: 100, height: 80 },
//   cardContent: { padding: 10, flex: 1 },
//   cardTitle: { fontSize: 16, fontWeight: 'bold' },
//   cardText: { fontSize: 14, color: 'gray' },
//   button: { backgroundColor: '#001F3F', padding: 12, borderRadius: 8, alignItems: 'center' },
//   buttonText: { color: '#fff', fontSize: 16, fontWeight: 'bold' }
// });

// export default TerminalSport;
