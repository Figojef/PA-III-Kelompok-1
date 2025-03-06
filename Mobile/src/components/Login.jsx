// Login.jsx
import React, { useState } from 'react';
import { View, Text, TextInput, TouchableOpacity, StyleSheet } from 'react-native';

const Login = () => {
  const [input, setInput] = useState('');
  const [password, setPassword] = useState('');

  return (
    <View style={styles.container}>
      <Text style={styles.logo}>🏸 Ramos Badminton</Text>
      <TouchableOpacity style={styles.skipButton}>
        <Text style={styles.skipText}>Lewati</Text>
      </TouchableOpacity>

      <Text style={styles.title}>Masuk</Text>
      <Text style={styles.subtitle}>
        Belum punya akun? <Text style={styles.link}>Daftar yuk!</Text>
      </Text>

      <TextInput
        style={styles.input}
        placeholder="Nomor Ponsel atau Email"
        value={input}
        onChangeText={setInput}
      />

      <TextInput
        style={styles.input}
        placeholder="Password"
        value={password}
        onChangeText={setPassword}
        secureTextEntry={true}
      />

      <TouchableOpacity style={styles.nextButton} disabled={!input}>
        <Text style={styles.nextButtonText}>Selanjutnya</Text>
      </TouchableOpacity>

      <View style={styles.footerContainer}>
        <Text style={styles.footer}>
          Dengan masuk kamu menyetujui{' '}
          <Text style={styles.link}>Syarat & Ketentuan</Text> dan{' '}
          <Text style={styles.link}>Kebijakan Privasi</Text> Ramos Badminton.
        </Text>
      </View>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#fdfbe9',
    padding: 20,
  },
  logo: {
    fontSize: 20,
    fontWeight: 'bold',
    marginBottom: 40,
  },
  skipButton: {
    position: 'absolute',
    top: 20,
    right: 20,
  },
  skipText: {
    fontSize: 16,
    color: 'black',
  },
  title: {
    fontSize: 28,
    fontWeight: 'bold',
    marginBottom: 10,
  },
  subtitle: {
    fontSize: 16,
    marginBottom: 20,
  },
  link: {
    color: '#3b82f6',
  },
  input: {
    height: 50,
    borderColor: '#ccc',
    borderWidth: 1,
    borderRadius: 8,
    paddingHorizontal: 15,
    marginBottom: 20,
    backgroundColor: 'white',
  },
  nextButton: {
    height: 50,
    backgroundColor: '#ccc',
    justifyContent: 'center',
    alignItems: 'center',
    borderRadius: 8,
  },
  nextButtonText: {
    fontSize: 16,
    fontWeight: 'bold',
    color: 'white',
  },
  footerContainer: {
    marginTop: 'auto',  // Memastikan footer berada di bagian bawah
    marginBottom: 20,   // Memberikan jarak dari bagian bawah layar
  },
  footer: {
    fontSize: 12,
    textAlign: 'center',
    color: '#555',
  },
});

export default Login;
