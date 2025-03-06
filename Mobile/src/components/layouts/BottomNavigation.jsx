import React from 'react';
import { View, StyleSheet, Text, SafeAreaView } from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';
import { NavigationContainer } from '@react-navigation/native';
import TodoInput from '../TodoInput';
import Header from './Header';  // Impor Header Component
import Jadwal from '../jadwal/Jadwal';
import Home from '../home/Home';

const HomeScreen = () => (
  <View style={styles.screen}><Text>Home Screen</Text></View>
);

const ScheduleScreen = () => (
  <View style={styles.screen}>
    {/* <TodoInput/> */}
    <Jadwal/>
  </View>
);

const BookingsScreen = () => (
  <View style={styles.screen}><Text>Bookings Screen</Text></View>
);

const ProfileScreen = () => (
  <View style={styles.screen}><Text>Profile Screen</Text></View>
);

const Tab = createBottomTabNavigator();

const BottomNavigation = () => {
  return (
    <NavigationContainer>
      <View style={{ flex: 1 }}>
        {/* SafeAreaView agar konten tidak menabrak status bar */}
        <SafeAreaView style={{ flex: 0, backgroundColor: '#6200ea' }}>
          <Header />
        </SafeAreaView>

        <SafeAreaView style={{ flex: 1 }}>
          <Tab.Navigator
            screenOptions={{
              headerShown: false,
              tabBarStyle: styles.tabBar,
            }}
          >
            <Tab.Screen 
              name="Home" 
              component={Home} 
              options={{ tabBarIcon: ({ color }) => <Ionicons name="home-outline" size={24} color={color} /> }} 
            />
            <Tab.Screen 
              name="Schedule" 
              component={ScheduleScreen} 
              options={{ tabBarIcon: ({ color }) => <Ionicons name="calendar-outline" size={24} color={color} /> }} 
            />
            <Tab.Screen 
              name="Bookings" 
              component={BookingsScreen} 
              options={{ tabBarIcon: ({ color }) => <Ionicons name="book-outline" size={24} color={color} /> }} 
            />
            <Tab.Screen 
              name="Profile" 
              component={ProfileScreen} 
              options={{ tabBarIcon: ({ color }) => <Ionicons name="person-outline" size={24} color={color} /> }} 
            />
          </Tab.Navigator>
        </SafeAreaView>
      </View>
    </NavigationContainer>
  );
};

const styles = StyleSheet.create({
  screen: {
    flex: 1,
    // justifyContent: 'center',
    // alignItems: 'center',
    // marginTop: 60, // Memberikan ruang untuk header
    marginBottom : 80
  },
  tabBar: {
    position: 'absolute',
    bottom: 0,
    left: 0,
    right: 0,
    height: 60,
    backgroundColor: '#fff',
    borderTopWidth: 1,
    borderTopColor: '#ccc',
  },
});

export default BottomNavigation;
