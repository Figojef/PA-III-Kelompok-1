import { View, Text, StyleSheet, ScrollView, TouchableOpacity } from 'react-native'
import React, { useEffect, useState } from 'react'
import { useNavigation } from '@react-navigation/native'
import { useDispatch } from 'react-redux'
import { SafeAreaView } from 'react-native-safe-area-context'
import Header from '../layouts/Header'
import axios from 'axios'
import { BE_MAIN_URL } from '../../../url'
import { FontAwesome5, Ionicons, MaterialIcons } from '@expo/vector-icons';
import { useFocusEffect } from '@react-navigation/native'  // Import useFocusEffect

export default function Mabar() {
    const navigation = useNavigation()
    const dispatch = useDispatch()
    const [dataMabar, setDataMabar] = useState(null)
    const [loading, setLoading] = useState(true)
    const [error, setError] = useState(null)

    // Define the function to fetch data
    const fetchAllDataMabar = async () => {
        try {
            const response = await axios.get(`${BE_MAIN_URL}/mabar`)
            setDataMabar(response.data.data)  // Set the data
            setLoading(false)
            console.log("Bukti Render Ulang")
        } catch (e) {
            setError(e)
            setLoading(false)
        }
    }

    // Trigger fetch when screen is focused
    useFocusEffect(
        React.useCallback(() => {
            fetchAllDataMabar()  // Run fetch on focus
        }, [])
    )

    const getDayOfWeek = (dateString) => {
        const date = new Date(dateString);
        const daysOfWeek = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        return daysOfWeek[date.getDay()];
    }

    const capitalizeName = (name) => {
        return name.split(' ')
                   .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
                   .join(' ');
    }

    return (
        <SafeAreaView style={styles.container}>
            <Header />
            <ScrollView contentContainerStyle={styles.scrollViewContent}>
                {/* Add a container for both buttons */}
                <View style={styles.buttonContainer}>
                    <TouchableOpacity style={styles.addMabarButton} onPress={() => navigation.navigate('BuatMabar')}>
                        <Text style={styles.addMabarButtonText}>Tambahkan Mabar</Text>
                    </TouchableOpacity>
                    <TouchableOpacity style={styles.eventAndaButton} onPress={() => navigation.navigate('MabarOwn')}>
                        <Text style={styles.eventAndaButtonText}>Event Mabar Anda</Text>
                    </TouchableOpacity>
                    <TouchableOpacity style={styles.eventAndaButton} onPress={() => navigation.navigate('MabarJoined')}>
                        <Text style={styles.eventAndaButtonText}>Joined</Text>
                    </TouchableOpacity>
                </View>

                {
                    loading ? 
                    <Text>Loading...</Text>
                    :
                    error ? 
                    <Text>{error}</Text>
                    :
                    dataMabar.length >= 1 ? 
                    dataMabar.map((data, ind) => (
                        <View key={ind} style={styles.card}>
                            <View style={{flex: 1, flexDirection: "row"}}>
                                <Ionicons size={18} style={{marginTop : 3, marginRight : 9}} name='person'/>
                                <Text style={[styles.host, {fontSize:18}]}>Penyelenggara : {capitalizeName(`${data.user_pembuat_mabar.name}`)}</Text>
                            </View>
                            <Text style={styles.title}>{data.nama_mabar}</Text>
                            <View style={styles.infoRow}>
                                <MaterialIcons name="event" size={16} color="#666" />
                                <Text style={styles.infoText}>Mulai : {getDayOfWeek(data.jadwal[0].tanggal)}, {data.jadwal[0].tanggal} • {data.jadwal[0].jam}:00</Text>
                            </View>
                            <View style={styles.infoRow}>
                                <MaterialIcons name="location-on" size={16} color="#666" />
                                <Text style={styles.infoText}>GOR Ramos, Sigumpar, Toba, Sumatera Utara</Text>
                            </View>
                            <View style={styles.infoRow}>
                                <FontAwesome5 name="money-bill-wave" size={16} color="#666" />
                                <Text style={styles.infoText}>Rp {data.biaya}/org</Text>
                            </View>
                            <View style={styles.infoRow}>
                                <FontAwesome5 name="table-tennis" size={16} color="#666" />
                                <Text style={styles.infoText}>Badminton</Text>
                            </View>
                            <View style={styles.divider} />
                            <View style={styles.footer}>
                                <Text style={styles.slotText}>{data.totalJoined}/{data.slot_peserta}</Text>
                                <TouchableOpacity onPress={() => navigation.navigate('DetailMabar', {dataMabar : data})}>
                                    <Text style={styles.detailText}>Lihat Detail</Text>
                                </TouchableOpacity>
                            </View> 
                        </View>
                    ))
                    :
                    <View style={{flex:1, justifyContent:"center", alignItems:"center", marginTop : 210}}>
                        <Text style={{fontSize:20}}>Tidak ditemukan data mabar</Text>
                    </View>
                }
            </ScrollView>
        </SafeAreaView>
    )
}


const styles = StyleSheet.create({
    container: { 
        flex: 1, 
        backgroundColor: '#f8f8f8',
        paddingHorizontal: 16, // Add horizontal padding here to affect the entire container
    },
    scrollViewContent: {
        paddingBottom: 20, // Adds padding at the bottom of the scrollview
    },
    card: {
        backgroundColor: '#fff',
        padding: 16,
        borderRadius: 8,
        marginBottom: 16, // Adjusted margin to be consistent with padding
        shadowColor: '#000',
        shadowOpacity: 0.1,
        shadowOffset: { width: 0, height: 2 },
        shadowRadius: 4,
        elevation: 3,
    },
    host: {
        fontSize: 14,
        fontWeight: 'bold',
        marginBottom: 4,
    },
    title: {
        fontSize: 16,
        fontWeight: 'bold',
        marginBottom: 8,
    },
    infoRow: {
        flexDirection: 'row',
        alignItems: 'center',
        marginBottom: 4,
    },
    infoText: {
        marginLeft: 8,
        color: '#666',
    },
    divider: {
        height: 1,
        backgroundColor: '#ccc',
        marginVertical: 10,
    },
    footer: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        alignItems: 'center',
        marginTop: 12,
    },
    slotText: {
        color: 'red',
        fontWeight: 'bold',
    },
    detailText: {
        color: 'blue',
    },
    buttonContainer: {
        flexDirection: 'row',  // Align the buttons horizontally
        justifyContent: 'flex-end',  // Align buttons to the right
        marginTop: 20,  // Space from the top
        marginBottom: 16,  // Bottom margin for spacing
    },
    addMabarButton: {
        backgroundColor: '#28A745',
        paddingVertical: 10,  // Reduced padding for smaller size
        paddingHorizontal: 12, 
        borderRadius: 8,
        alignItems: 'center',
        width: '32%',  // Set width to make buttons smaller
        marginRight: 8, // Add a little margin between the buttons
    },
    eventAndaButton: {
        backgroundColor: '#001F54', 
        paddingVertical: 10,  // Reduced padding for smaller size
        paddingHorizontal: 12, 
        borderRadius: 8,
        alignItems: 'center',
        width: '32%',  // Set width to make buttons smaller
    },
    addMabarButtonText: {
        color: '#fff',
        fontSize: 10,  // Reduced font size for smaller buttons
        fontWeight: 'bold',
    },
    eventAndaButtonText: {
        color: '#fff',
        fontSize: 10,  // Reduced font size for smaller buttons
        fontWeight: 'bold',
    },
})
