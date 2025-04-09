import { View, Text, StyleSheet, ScrollView, TouchableOpacity } from 'react-native';
import React from 'react';
import { FontAwesome } from '@expo/vector-icons';
import { useRoute } from '@react-navigation/native';

// const peserta = [
//     { id: '1', name: 'Ferry Fernando', phone: '082231017447' },
//     { id: '2', name: 'Jamin S', phone: '081775020752' },
// ];

export default function PesertaMabar({ navigation }) {
    const route = useRoute()
    const {dataMabar} = route.params;

    const peserta = dataMabar.user_yang_join

    return (
        <View style={styles.container}>
            <TouchableOpacity style={styles.backButton} onPress={() => navigation.goBack()}>
                <FontAwesome name="arrow-left" size={20} color="black" />
            </TouchableOpacity>
            <Text style={styles.header}>Peserta  ({dataMabar.totalJoined}/{dataMabar.slot_peserta})</Text>

            <ScrollView contentContainerStyle={styles.scrollContainer}>
                    {/* Pemilik Mabar */}
                    <View>
                        <View style={styles.participantCard}>
                            {/* <Image source={require('../assets/avatar.png')} style={styles.avatar} /> */}
                            <View style={styles.info}>
                                <Text style={styles.name}>{dataMabar.user_pembuat_mabar.name} </Text>
                                <Text style={styles.phone}>{dataMabar.user_pembuat_mabar.email}</Text>
                                <Text style={{color : 'green'}}>(HOST)</Text>
                            </View>
                            <TouchableOpacity style={styles.whatsappButton}>
                                <FontAwesome name="whatsapp" size={24} color="#25D366" />
                            </TouchableOpacity>
                        </View>
                        <View style={styles.divider} />
                    </View>

                    {/* Pelanggan yang join */}
                {peserta.map((item, ind) => (
                    <View key={ind}>
                        <View style={styles.participantCard}>
                            {/* <Image source={require('../assets/avatar.png')} style={styles.avatar} /> */}
                            <View style={styles.info}>
                                <Text style={styles.name}>{item.name}</Text>
                                <Text style={styles.phone}>{item.email}</Text>
                            </View>
                            <TouchableOpacity style={styles.whatsappButton}>
                                <FontAwesome name="whatsapp" size={24} color="#25D366" />
                            </TouchableOpacity>
                        </View>
                        <View style={styles.divider} />
                    </View>
                ))}
            </ScrollView>
        </View>
    );
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        backgroundColor: '#fff',
        padding: 16,
    },
    backButton: {
        position: 'absolute',
        top: 16,
        left: 16,
        zIndex: 10,
    },
    header: {
        textAlign: 'center',
        fontSize: 18,
        fontWeight: 'bold',
        marginBottom: 16,
    },
    participantCard: {
        flexDirection: 'row',
        alignItems: 'center',
        paddingVertical: 12,
        paddingHorizontal: 16,
    },
    avatar: {
        width: 40,
        height: 40,
        borderRadius: 20,
        marginRight: 12,
    },
    info: {
        flex: 1,
    },
    name: {
        fontSize: 16,
        fontWeight: 'bold',
    },
    phone: {
        fontSize: 14,
        color: '#666',
    },
    whatsappButton: {
        padding: 8,
    },
    scrollContainer: {
        paddingBottom: 16,  // Adding some bottom padding to avoid content getting cut off
    },
    divider: {
        height: 1,
        backgroundColor: '#ccc',
        marginVertical: 8,  // Reduced margin to ensure divider spacing is consistent
    },
});
