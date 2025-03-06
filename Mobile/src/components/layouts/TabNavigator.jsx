import { createBottomTabNavigator } from "@react-navigation/bottom-tabs"
import { createStackNavigator } from "@react-navigation/stack"
import Home from "../home/Home"
import Jadwal from "../jadwal/Jadwal"
import Booking from "../booking/Booking"
import Profile from "../profile/Profile"
import { Ionicons } from '@expo/vector-icons';
import LoginScreen from "../auth/LoginScreen"
import { useState } from "react"
import { useSelector } from "react-redux"
import RegisterScreen from "../auth/RegisterScreen"
import Pemesanan from "../pemesanan/Pemesanan"


const Stack = createStackNavigator()
const Tab = createBottomTabNavigator()


const TabNavigator = () => {

    const login = useSelector(state => state.todo1.login)

    return (
        login ? 
        <>
        <Tab.Navigator

        >
            <Tab.Screen
                name = "Home"
                component = {Home}
                options = {{
                    tabBarIcon : ({color, size}) => (
                        <Ionicons name = 'home-outline' size={size} color={color}/>
                    ),
                    headerShown : false
                }}
            />
            <Tab.Screen
                name = "Schedule"
                component = {Jadwal}
                options = {{
                    tabBarIcon : ({color, size}) => (
                        <Ionicons name = 'calendar-outline' size={size} color={color}/>
                    ),
                    headerShown : false
                }}
            />
            <Tab.Screen
                name = "Bookings"
                component = {Booking}
                options = {{
                    tabBarIcon : ({color, size}) => (
                        <Ionicons name = 'book-outline' size={size} color={color}/>
                    ),
                    headerShown : false
                }}
            />
            <Tab.Screen
                name = "Pemesanan"
                component = {Pemesanan}
                options = {{
                    tabBarIcon : ({color, size}) => (
                        <Ionicons name = 'cart-outline' size={size} color={color}/>
                    ),
                    headerShown : false
                }}
            />
            <Tab.Screen
                name = "Profile"
                component = {Profile}
                options = {{
                    tabBarIcon : ({color,size}) => (
                        <Ionicons name = 'person-outline' size={size} color={color}/>
                    ),
                    headerShown : false
                }}
            />
        </Tab.Navigator>
    </>
    :
    <>
        <Tab.Navigator
            screenOptions={{
                tabBarLabelStyle: { fontSize: 10, paddingBottom: 10 }, // Adjust label size
                tabBarIconStyle: { paddingBottom: 5 } // Adjust icon size and spacing
            }}
        >
            <Tab.Screen
                name = "Login"
                component={LoginScreen}
                options={{
                    tabBarIcon : ({color, size}) => (
                        <Ionicons name="log-in" color={color} size={size}/>
                    ),
                    headerShown : false
                }}
            />
            <Tab.Screen
                name="register"
                component={RegisterScreen}
                options={{
                    tabBarIcon : ({color, size}) => (
                        <Ionicons name="person-add" color={color} size={size}/>
                    ),
                    headerShown : false
                }}
            />
        </Tab.Navigator>
    </>
    )
}

export default TabNavigator
