import { View, Text, StyleSheet, ScrollView } from 'react-native'
import React from 'react'
import Header from '../layouts/Header'
import { SafeAreaView } from 'react-native-safe-area-context'

export default function Profile() {
    return (
        <View style={styles.rootContainer}>
          <Header/>
            <SafeAreaView style={styles.container}>
                <ScrollView 
                    showsVerticalScrollIndicator={false} 
                    contentContainerStyle={styles.scrollContent} 
                    keyboardShouldPersistTaps="handled">
                        <Text>Profile Component</Text>
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