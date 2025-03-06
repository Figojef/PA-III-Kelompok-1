// import React from 'react';
// import { View, Text, StyleSheet, Platform } from 'react-native';

// const Header = () => {
//   return (
//     <View style={styles.header}>
//       <Text style={styles.headerText}>App Header</Text>
//     </View>
//   );
// };

// const styles = StyleSheet.create({
//   header: {
//     position: 'absolute',
//     top: 0,
//     left: 0,
//     right: 0,
//     height: 60,
//     backgroundColor: '#6200ea', // Ganti sesuai kebutuhan
//     justifyContent: 'center',
//     alignItems: 'center',
//     zIndex: 1, // Agar header di atas konten
//     paddingTop: Platform.OS === 'ios' ? 20 : 0, // Menyesuaikan ruang untuk status bar di iOS
//   },
//   headerText: {
//     color: '#fff',
//     fontSize: 20,
//     fontWeight: 'bold',
//   },
// });

// export default Header;

import React from 'react';
import { View, Text, Image, TouchableOpacity, StyleSheet, StatusBar } from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { useDispatch } from 'react-redux';
import { logout } from '../../slices/todoSlice';


const Header = () => {

  const dispatch = useDispatch()

  const handleLogout = () => dispatch(logout())

  return (
    <View style={styles.header}>
            <StatusBar
              barStyle="light-content" // Mengatur warna teks status bar menjadi terang
              backgroundColor="#4a90e2" // Mengatur warna latar belakang status bar agar sesuai dengan warna header
            />
      <View style={styles.logoContainer}>
        <Image 
          source={require('../../../assets/favicon.png')} 
          style={styles.logo}
        />
        <Text style={styles.title}>Ramos Badminton</Text>
      </View>
      <View style={styles.iconContainer}>
        <TouchableOpacity style={styles.iconButton} onPress={() => handleLogout()}>
          <Ionicons name="log-out-outline" size={24} color="black" />
        </TouchableOpacity>
        <TouchableOpacity style={styles.iconButton}>
          <Ionicons name="menu-outline" size={28} color="black" />
        </TouchableOpacity>
      </View>
    </View>
  );
};

const styles = StyleSheet.create({
  header: {
    height: 55,
    backgroundColor: '#f8f8f8',
    paddingHorizontal: 20,
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    borderBottomWidth: 1,
    borderBottomColor: '#ccc',
  },
  logoContainer: {
    flexDirection: 'row',
    alignItems: 'center',
  },
  logo: {
    width: 30,
    height: 30,
    marginRight: 10,
  },
  title: {
    fontSize: 18,
    fontWeight: 'bold',
  },
  iconContainer: {
    flexDirection: 'row',
  },
  iconButton: {
    marginLeft: 15,
  },
});

export default Header;
