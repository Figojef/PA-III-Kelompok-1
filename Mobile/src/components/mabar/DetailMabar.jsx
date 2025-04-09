import { View, Text, TouchableOpacity, ScrollView, StyleSheet, Alert } from 'react-native'
import React, { use, useEffect, useState } from 'react'
import { Ionicons } from '@expo/vector-icons'; // Expo already supports Ionicons
import { useNavigation, useRoute } from '@react-navigation/native';
import { FontAwesome5,  MaterialIcons } from '@expo/vector-icons';
import axios from 'axios';
import { BE_MAIN_URL } from '../../../url';
import { useSelector } from 'react-redux';



export default function DetailMabar() {

    const navigation = useNavigation()
    const route = useRoute()
    const getUser = useSelector(state => state.todo1.user)
    const user = getUser.data
    const [joined, setJoined] = useState(null)

    const {dataMabar} = route.params

    // alert(dataMabar.user_pembuat_mabar._id)

    useEffect(() => {
        const fetchIsJoined = async () => {
            try {
                const response = await axios.post(`${BE_MAIN_URL}/mabar/cek-join`, {
                    mabar_id: dataMabar._id,
                    user_id: user._id
                })
                const joinData = response.data
                setJoined(joinData.isJoined)
                // alert(joinData.isJoined)
            } catch (e) {
                alert("Something went wrong : " + e)
            }
        }
        fetchIsJoined()
    }, [])

    const handleJoinMabar = async () => {
        try{
            const response = await axios.post(`${BE_MAIN_URL}/mabar/join`, 
                {
                    mabarId : dataMabar._id,
                    userId : user._id
                }
            )
            // console.log(response.data)
            // navigation.goBack()
            alert("Anda berhasil bergabung")
            navigation.navigate('TabNavigator', {screen : 'Mabar'})
        }catch(e){
            alert(e)
        }
    }
    

    const handleKeluarMabar = async () => {
        try{
            const response = await axios.post(`${BE_MAIN_URL}/mabar/keluar`, 
                {
                    mabarId : dataMabar._id,
                    userId : user._id
                }
            )
            // console.log(response.data)
            // navigation.goBack()
            alert("Anda berhasil keluar")
            navigation.navigate('TabNavigator', {screen : 'Mabar'})
        }catch(e){
            alert(e)
        }   
    }

    const handleHapusMabar = async () => {
        // Menampilkan alert konfirmasi
        Alert.alert(
          "Konfirmasi Penghapusan",
          "Apakah Anda yakin ingin menghapus Mabar ini?", // Pesan konfirmasi
          [
            {
              text: "Batal", // Jika pengguna pilih Batal
              onPress: () => console.log("Penghapusan dibatalkan"),
              style: "cancel",
            },
            {
              text: "Hapus", // Jika pengguna pilih Hapus
              onPress: async () => {
                try {
                  // Mengirim request DELETE
                  const response = await axios.delete(
                    `${BE_MAIN_URL}/mabar/hapus/${dataMabar._id}`,
                    {
                      // Jika diperlukan, bisa tambahkan header seperti Authorization di sini
                      // headers: { Authorization: `Bearer ${token}` }
                    }
                  );
      
                  // Menampilkan alert sukses
                  alert("Berhasil menghapus mabar");
                  // Menavigasi ke screen Mabar
                  navigation.navigate('TabNavigator', { screen: 'Mabar' });
                } catch (e) {
                  // Menangani error
                  alert("Terjadi kesalahan: " + e.message);
                }
              },
            },
          ],
          { cancelable: false } // Menghindari penutupan alert jika pengguna mengklik di luar alert
        );
      };

    // setTimeout(() => {
    //     navigation.jumpTo('Mabar')
    // }, 3000)
    

  return (
    <View style={styles.container}>

    {/* Header */}
    <TouchableOpacity onPress={() => navigation.goBack()} style={styles.header}>
        <Ionicons name="arrow-back" size={24} />
        <Text style={styles.headerTitle}>Detail Mabar</Text>
      </TouchableOpacity>

    <ScrollView style={styles.content}>
    <View style={styles.card}>
            <Text style={styles.title}>seru</Text>
            
            <View style={styles.infoRow}>
                <FontAwesome5 name="table-tennis" size={16} color="#666" />
                <Text style={styles.infoText}> Badminton • Kota</Text>
            </View>
            
            <View style={styles.participantRow}>
                <Text style={styles.participantText}>Peserta ({dataMabar.totalJoined}/{dataMabar.slot_peserta})</Text>
                <TouchableOpacity onPress={() => navigation.navigate('PesertaMabar', {dataMabar})}>
                    <Text style={styles.linkText}>Lihat semua peserta</Text>
                </TouchableOpacity>
            </View>
            {/* <View style={styles.participantRow}>
                <Text style={styles.participantText}>Peserta ({dataMabar.totalJoined}/{dataMabar.slot_peserta})</Text>
                <TouchableOpacity onPress={() => navigation.navigate('TabNavigator', {screen : 'Mabar'})}>
                    
                    <Text style={styles.linkText}>Lihat semua peserta</Text>
                </TouchableOpacity>
            </View> */}
            
            <View style={styles.section}>
                {dataMabar.jadwal.map((item, ind) => 
                <View key={ind} style={styles.infoRow}>
                    <MaterialIcons name="event" size={16} color="#666" />
                    <Text style={styles.infoText}>{item.tanggal} || jam {item.jam}:00</Text>
                </View>
                )}

                <View style={styles.infoRow}>
                    <MaterialIcons name="location-on" size={16} color="#666" />
                    <Text style={styles.infoText}>GOR RAMOS</Text>
                </View>
                <View style={styles.infoRow}>
                    <FontAwesome5 name="money-bill-wave" size={16} color="#666" />
                    <Text style={styles.infoText}>Rp {dataMabar.biaya}</Text>
                </View>
                <View style={styles.infoRow}>
                    <FontAwesome5 name="user" size={16} color="#666" />
                    <Text style={styles.infoText}>{dataMabar.range_umur} tahun</Text>
                </View>
                <View style={styles.infoRow}>
                    <FontAwesome5 name="chart-line" size={16} color="#666" />
                    <Text style={styles.infoText}>{dataMabar.level}</Text>
                </View>
                <View style={styles.infoRow}>
                    <FontAwesome5 name="layer-group" size={16} color="#666" />
                    <Text style={styles.infoText}>{dataMabar.kategori}</Text>
                </View>

                    <View style={styles.divider} />

                <Text style={styles.waText}>Deskripsi : {dataMabar.deskripsi}</Text>
            </View>
            
            <Text style={styles.sectionTitle}>Penyelenggara</Text>
            <View style={styles.organizerRow}>
                <FontAwesome5 name="user-circle" size={32} color="#666" />
                <View style={styles.organizerInfo}>
                    <Text style={styles.host}>{dataMabar.user_pembuat_mabar.name}</Text>
                    <Text style={styles.infoText}>+6208348323923</Text>
                </View>
                <TouchableOpacity>
                    <Ionicons name="logo-whatsapp" size={32} color="#25D366" />
                </TouchableOpacity>
            </View>
            
            {
                joined ? 
                <TouchableOpacity style={styles.cancelButton} onPress={handleKeluarMabar}>
                <Text style={styles.cancelButtonText}>Keluar</Text>
                </TouchableOpacity>
                :
                dataMabar.user_pembuat_mabar._id == user._id ?
                <TouchableOpacity style={styles.cancelButton} onPress={handleHapusMabar}>
                <Text style={styles.cancelButtonText}>Hapus Mabar</Text>
                </TouchableOpacity>
                :
                dataMabar.totalJoined >= dataMabar.slot_peserta ?
                <TouchableOpacity style={styles.cancelButton}>
                <Text style={styles.cancelButtonText}>Sudah Penuh</Text>
                </TouchableOpacity>
                :
                <TouchableOpacity style={styles.cancelButton} onPress={handleJoinMabar}>
                <Text style={styles.cancelButtonText}>Bergabung</Text>
                </TouchableOpacity>
            }
        </View>

    </ScrollView>
    
    </View>
  )
}


const styles = StyleSheet.create({
    container: { flex: 1, backgroundColor: '#fff' },
    header: { flexDirection: 'row', alignItems: 'center', padding: 15, borderBottomWidth: 1, borderColor: '#ddd' },
    headerTitle: { fontSize: 18, fontWeight: 'bold', marginLeft: 10 },
    content: { flex: 1, padding: 5 },
    card: {
        backgroundColor: '#fff',
        padding: 16,
        borderRadius: 8,
        margin: 16,
        shadowColor: '#000',
        shadowOpacity: 0.1,
        shadowOffset: { width: 0, height: 2 },
        shadowRadius: 4,
        elevation: 3,
    },
    title: {
        fontSize: 18,
        fontWeight: 'bold',
        marginBottom: 8,
    },
    infoRow: {
        flexDirection: 'row',
        alignItems: 'center',
        marginBottom: 24,
    },
    infoText: {
        marginLeft: 8,
        color: '#666',
    },
    participantRow: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        alignItems: 'center',
        marginVertical: 8,
    },
    participantText: {
        fontSize: 14,
        fontWeight: 'bold',
    },
    linkText: {
        color: 'blue',
    },
    section: {
        borderWidth: 1,
        borderColor: '#ccc',
        padding: 12,
        borderRadius: 8,
        marginVertical: 8,
    },
    waText: {
        marginTop: 8,
        fontSize: 14,
        color: '#666',
    },
    sectionTitle: {
        fontSize: 16,
        fontWeight: 'bold',
        marginTop: 16,
    },
    organizerRow: {
        flexDirection: 'row',
        alignItems: 'center',
        backgroundColor: '#f8f8f8',
        padding: 12,
        borderRadius: 8,
        marginVertical: 8,
    },
    organizerInfo: {
        flex: 1,
        marginLeft: 12,
    },
    divider: {
        height: 1,
        backgroundColor: '#ccc',
        marginVertical: 10,
    },
    host: {
        fontSize: 14,
        fontWeight: 'bold',
    },
    cancelButton: {
        backgroundColor: '#001F54',
        padding: 14,
        borderRadius: 8,
        alignItems: 'center',
        marginTop: 12,
    },
    cancelButtonText: {
        color: '#fff',
        fontSize: 16,
        fontWeight: 'bold',
    },
})