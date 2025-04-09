import { View, Text, TouchableOpacity, StyleSheet, ScrollView, Image } from 'react-native';
import React, { useState } from 'react';
import { Ionicons } from '@expo/vector-icons'; // Expo already supports Ionicons
import { useNavigation } from '@react-navigation/native';

export default function Test4() {
    const [activeTab, setActiveTab] = useState('Sedang Berlangsung'); // Set active tab state
    const navigation = useNavigation();

    return (
        <View style={styles.container}>
            {/* Header */}
            <TouchableOpacity onPress={() => navigation.goBack()} style={styles.header}>
                <Ionicons name="arrow-back" size={24} />
                <Text style={styles.headerTitle}>Kegiatan Mabar Anda</Text>
            </TouchableOpacity>

            <ScrollView style={styles.content}>
                {/* Scrollable Tabs */}
                <View style={styles.tabs}>
                    <TouchableOpacity
                        style={styles.tab}
                        onPress={() => setActiveTab('Sedang Berlangsung')}
                    >
                        <Text style={activeTab === 'Sedang Berlangsung' ? styles.activeTab : styles.inactiveTab}>
                            Sedang Berlangsung
                        </Text>
                    </TouchableOpacity>
                    <TouchableOpacity
                        style={styles.tab}
                        onPress={() => setActiveTab('Histori')}
                    >
                        <Text style={activeTab === 'Histori' ? styles.activeTab : styles.inactiveTab}>
                            Histori
                        </Text>
                    </TouchableOpacity>
                </View>

                {/* Content Based on Active Tab */}
                {activeTab === 'Sedang Berlangsung' ? (
                    <View style={styles.tabContent}>
                        <Text style={styles.tabTitle}>Event 1: "Mabar Bersama Teman"</Text>
                        <Image
                            source={{ uri: 'https://example.com/mabar-image.jpg' }} // Replace with a real image URL
                            style={styles.image}
                        />
                        <Text style={styles.description}>
                            Sedang berlangsung acara Mabar seru bersama teman-teman! Ayo gabung dan rasakan keseruan bermain game bersama!
                        </Text>
                    </View>
                ) : (
                    <View style={styles.tabContent}>
                        <Text style={styles.tabTitle}>Histori Kegiatan</Text>
                        <View style={styles.historyItem}>
                            <Text style={styles.historyText}>Event 1: "Mabar Bersama Teman" - 2 hari yang lalu</Text>
                        </View>
                        <View style={styles.historyItem}>
                            <Text style={styles.historyText}>Event 2: "Turnamen Mabar" - 1 minggu yang lalu</Text>
                        </View>
                    </View>
                )}
            </ScrollView>
        </View>
    );
}

const styles = StyleSheet.create({
    container: { flex: 1, backgroundColor: '#fff' },
    header: { flexDirection: 'row', alignItems: 'center', padding: 15, borderBottomWidth: 1, borderColor: '#ddd' },
    headerTitle: { fontSize: 18, fontWeight: 'bold', marginLeft: 10 },
    content: { flex: 1, padding: 5 },
    tabs: { flexDirection: 'row', borderBottomWidth: 1, borderBottomColor: '#ccc', marginBottom: 20, paddingHorizontal: 10 },
    tab: { flex: 1, alignItems: 'center' },
    activeTab: { fontSize: 16, fontWeight: 'bold', borderBottomWidth: 2, borderBottomColor: 'black', paddingBottom: 5 },
    inactiveTab: { fontSize: 16, color: '#ccc', paddingBottom: 5 },

    // Tab Content Styling
    tabContent: { padding: 15 },
    tabTitle: { fontSize: 18, fontWeight: 'bold', marginBottom: 10 },
    description: { fontSize: 14, color: '#555', marginTop: 10 },
    image: { width: '100%', height: 200, borderRadius: 8, marginVertical: 10 },

    // History Styling
    historyItem: {
        padding: 10,
        backgroundColor: '#f9f9f9',
        borderRadius: 8,
        marginBottom: 10,
        borderWidth: 1,
        borderColor: '#eee',
    },
    historyText: { fontSize: 14, color: '#333' },
});
