import { View, Text, StyleSheet, ScrollView, Button, Alert } from 'react-native'
import React, { use, useState } from 'react'
import Header from '../layouts/Header'
import { SafeAreaView } from 'react-native-safe-area-context'
import { useDispatch, useSelector } from 'react-redux'
import axios from 'axios'
import { BE_MAIN_URL } from '../../../url'

export default function Profile() {

  const dispatch = useDispatch()
  const getUser = useSelector(state => state.todo1.user)
  const user = getUser.data

  const [data, setData] = useState([]); // Menyimpan data dari API
  const [loading, setLoading] = useState(false); // Menyimpan status loading

  // Fungsi untuk mendapatkan data dari API
  const fetchData = async () => {
    setLoading(true); // Set loading true saat memulai permintaan
    try {
      const response = await axios.get(`${BE_MAIN_URL}/lapangan`); // Ganti dengan URL API Anda
      setData(response.data); // Menyimpan data ke state
      // console.log(response.data)
      response.data.data.forEach((d) => console.log(d.name))
    } catch (error) {
            Alert.alert('Error', 'Terjadi kesalahan autentikasi.', [{ text: 'OK' }]);

      // console.error('Error fetching data: ', error);
    } finally {
      setLoading(false); // Set loading false setelah permintaan selesai
    }
  };


    return (
        <View style={styles.rootContainer}>
          <Header/>
            <SafeAreaView style={styles.container}>
                <ScrollView 
                    showsVerticalScrollIndicator={false} 
                    contentContainerStyle={styles.scrollContent} 
                    keyboardShouldPersistTaps="handled">
                        <Text>Profile Component</Text>
                        <Text>{user.name}</Text>
                        <Text>{user.email}</Text>
                        <Text>{user.role}</Text>
                        <Text>
                        {/* <Button title="Fetch Data" onPress={fetchData} /> */}
                        
                        </Text>
                </ScrollView>       

                
            </SafeAreaView>
        </View>
      )
}

const styles = StyleSheet.create({
    rootContainer: {
        flex: 1,
    },
    container: {
        flex: 1,
        backgroundColor: '#fdfbe9',
      },
      scrollContent: {
        padding: 20,
        paddingBottom: 90, // Menambahkan padding untuk menghindari konten tertutup oleh bottom navigation
      },
})