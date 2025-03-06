import React from 'react';
import { View, Text, StyleSheet, TouchableOpacity } from 'react-native';
import { useNavigation } from '@react-navigation/native';
import { SafeAreaView } from 'react-native-safe-area-context';
import { Ionicons } from '@expo/vector-icons'; // Jika menggunakan Expo


export default function Test1() {

  const navigation = useNavigation()

  return (
    <SafeAreaView style={{ flex: 1 }}>
      <View style={{ flexDirection: 'row', alignItems: 'center', paddingLeft: 15 }}>
        {/* Tombol kembali */}
        <TouchableOpacity onPress={() => navigation.goBack()} style={{ padding: 10 }}>
          <Ionicons name="arrow-back-circle" size={24} color="black" />
        </TouchableOpacity>
      </View>
      <View style={{ flex: 1, justifyContent: 'center', alignItems: 'center' }}>
        <Text>Welcome to the Detail Screen!</Text>
      </View>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  topHeader: {
    position: 'absolute',
    top: 0,
    left: 0,
    right: 0,
    paddingTop: 40, // Adjust as needed based on status bar
    backgroundColor: '#f8f8f8',
    height: 100,
    justifyContent: 'center',
    alignItems: 'center',
    zIndex: 100, // Ensures it is on top of everything
    borderBottomWidth: 1,
    borderBottomColor: '#ccc',
  },
  headerTitle: {
    fontSize: 20,
    fontWeight: 'bold',
    color: 'black',
  },
});
