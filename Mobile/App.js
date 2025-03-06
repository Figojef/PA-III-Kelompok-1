import React from "react";
import { Platform, StyleSheet, Text } from "react-native";
import { StatusBar } from 'expo-status-bar';
import BottomNavigation from "./src/components/layouts/BottomNavigation";
import { Provider as PaperProvider } from 'react-native-paper'; // Mengimpor Provider dari react-native-paper
import { SafeAreaView } from "react-native-safe-area-context";
import { NavigationContainer } from "@react-navigation/native";
import { createStackNavigator } from "@react-navigation/stack";
import { createBottomTabNavigator } from "@react-navigation/bottom-tabs";
import TabNavigator from "./src/components/layouts/TabNavigator";
import Test1 from "./src/components/test/Test1";
import TerminalSport from "./src/components/booking/TerminalSport";
import SelectSchedule from "./src/components/booking/SelectSchedule";
import DetailPembayaran from "./src/components/booking/DetailPembayaran";
import BankTransfer from "./src/components/booking/pembayaran/BankTransfer";
import StatusPemesanan from "./src/components/pemesanan/StatusPemesanan";

const Stack = createStackNavigator()

export const App = () => {
  return (
    <>
        <NavigationContainer>
          <Stack.Navigator>
            <Stack.Screen 
              name = "TabNavigator" 
              component={TabNavigator} 
              options={{headerShown : false}}
              />

            <Stack.Screen
              name = "Test1"
              component={Test1}
              options={{headerShown : false}}/>

            <Stack.Screen
              name = "SelectSchedule"
              component={SelectSchedule}
              options={{headerShown : false}}/>

            <Stack.Screen
              name = "DetailPembayaran"
              component={DetailPembayaran}
              options={{headerShown : false}}/>

            <Stack.Screen
              name = "BankTransfer"
              component={BankTransfer}
              options={{headerShown : false}}/>
              
              <Stack.Screen
              name = "StatusPemesanan"
              component={StatusPemesanan}
              options={{headerShown : false}}/>

          </Stack.Navigator>

          

          
        </NavigationContainer>
    </>
  );
};



export default App;





