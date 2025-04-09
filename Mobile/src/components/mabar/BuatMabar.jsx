import React, { useEffect, useState } from 'react';
import { View, Text, TextInput, TouchableOpacity, StyleSheet, ScrollView, Modal } from 'react-native';
import { FontAwesome } from '@expo/vector-icons';
import axios from 'axios';
import { BE_MAIN_URL } from '../../../url';
import { useSelector } from 'react-redux';
import { useNavigation } from '@react-navigation/native';

export default function BuatMabar() {
    // Utils
    const navigation = useNavigation()

    // Redux Data
    const getUser = useSelector(state => state.todo1.user)
    const user = getUser.data

    // Form
    const [namaEvent, setNamaEvent] = useState('');
    const [biaya, setBiaya] = useState('');
    const [umurMin, setUmurMin] = useState('');
    const [umurMax, setUmurMax] = useState('');
    const [slotPeserta, setSlotPeserta] = useState('');
    const [deskripsi, setDeskripsi] = useState('');
    const [level, setLevel] = useState(null);
    const [kategori, setKategori] = useState(null);
    const [modalVisible, setModalVisible] = useState(false);
    const [modalVisibleKategori, setModalVisibleKategori] = useState(false);
    const [modalVisibleJadwal, setModalVisibleJadwal] = useState(false); // Untuk kontrol modal
    const [selectedOptions, setSelectedOptions] = useState([]); // Menyimpan pilihan yang dipilih
    const [options, setOptions] = useState([]); // Menyimpan pilihan yang diambil dari API


    const handleSelectLevel = (selectedLevel) => {
        setLevel(selectedLevel);
        setModalVisible(false); // Menutup modal setelah memilih level
    };

    const handleSelectKategori = (selectedKategori) => {
        setKategori(selectedKategori);
        setModalVisibleKategori(false); // Menutup modal setelah memilih kategori
    };

    console.log(selectedOptions)

      // Mengambil data pilihan dari API saat komponen dimount
      useEffect(() => {
        const fetchJadwalMabar = async () => {
          try {
            const response = await axios.post(`${BE_MAIN_URL}/mabar/select-jadwal-mabar`, {
              user_id: user._id,
            });
            // Menyimpan objek lengkap dari item dalam options
            let fetchedOptions = response.data.data.map(item => ({
              id: item._id,
              lapangan: item.lapangan.name,
              jam: 'jam ' + item.jam + ':00',
              tanggal: item.tanggal,
            }));
            console.log(fetchedOptions)
            setOptions(fetchedOptions); // Update state options
          } catch (e) {
            console.log(e);
          }
        };
        if (user && user._id) {
          fetchJadwalMabar(); // Memanggil fungsi hanya jika user sudah ada
        }
      }, [user]);

        // Fungsi untuk toggle pilihan (cek atau uncheck)
    const handleOptionPress = (optionId) => {
        setSelectedOptions((prevSelectedOptions) => {
        if (prevSelectedOptions.includes(optionId)) {
            // Jika sudah dipilih, hilangkan dari state
            return prevSelectedOptions.filter((item) => item !== optionId);
        } else {
            // Jika belum dipilih, tambahkan ke state
            return [...prevSelectedOptions, optionId];
        }
        });
    };

    const handleCreateMabar = async () => {
        // Validasi semua input
        if (!namaEvent) {
            alert("Nama Event harus diisi.");
            return;
        }

        if (!biaya) {
            alert("Biaya harus diisi.");
            return;
        }

        if (!umurMin || !umurMax || umurMin === "" || umurMax === "") {
            alert("Rentang umur (Umur Min - Umur Max) harus diisi.");
            return;
        }

        if (!level) {
            alert("Level harus diisi.");
            return;
        }

        if (!kategori) {
            alert("Kategori harus diisi.");
            return;
        }

        if (!slotPeserta) {
            alert("Slot Peserta harus diisi.");
            return;
        }

        if (!deskripsi) {
            alert("Deskripsi harus diisi.");
            return;
        }

        if (selectedOptions.length === 0) {
            alert("Pilih opsi Jadwal Mabar.");
            return;
        }
        try {
            const response = await axios.post(`${BE_MAIN_URL}/mabar`, {
                nama_mabar: namaEvent,
                biaya,
                range_umur: `${umurMin}-${umurMax}`,
                level,
                kategori,
                slot_peserta : slotPeserta,
                deskripsi,
                user_pembuat_mabar : user._id,
                jadwal : selectedOptions
            });
            console.log(response.data)
            navigation.goBack()
        } catch (e) {
            console.error(e);
            alert("Terjadi kesalahan : " + e) 
        }
    };

    // console.log(selectedOptions)

    // useEffect(() => {
    //     setTimeout(() => {
    //         navigation.goBack()
    //     }, 3000)
    // }, [])

    return (
        <ScrollView style={styles.container}>
            <TouchableOpacity style={styles.backButton} onPress={() => navigation.goBack()}>
                <FontAwesome name="arrow-left" size={20} color="black" />
            </TouchableOpacity>
            <Text style={styles.header}>Buat Event</Text>

            <Text style={styles.label}>Nama Event</Text>
            <TextInput
                style={styles.input}
                placeholder="Masukkan nama event"
                value={namaEvent}
                onChangeText={setNamaEvent}
            />

            <Text style={styles.label}>Aktivitas</Text>
            <TextInput style={styles.input} value="Badminton" editable={false} />

            <Text style={styles.label}>Tempat & Waktu</Text>
            <TouchableOpacity 
            style={[{backgroundColor : "#002366", width : 70, borderRadius : 10, alignItems : "center"}]} 
            onPress={() => setModalVisibleJadwal(true)}>
                <Text style={[styles.createButtonText]}>Pilih</Text>
            </TouchableOpacity>
      {/* Modal untuk menampilkan pilihan */}
      <Modal
        animationType="slide"
        transparent={true}
        visible={modalVisibleJadwal}
        onRequestClose={() => setModalVisibleJadwal(false)}
      >
        <View style={styles.modalOverlay}>
          <View style={styles.modalContent}>
            <Text style={styles.modalTitle}>Select Options</Text>

            {/* Menampilkan pilihan menggunakan TouchableOpacity */}
            {options.length > 0 ? (
              options.map((option, index) => (
                <TouchableOpacity
                  key={index}
                  style={[
                    styles.optionContainer,
                    selectedOptions.includes(option.id) && styles.selectedOption,
                  ]}
                  onPress={() => handleOptionPress(option.id)} // Menggunakan ID sebagai nilai
                >
                  <Text style={styles.optionText}>
                    {`${option.lapangan} - ${option.jam} - ${option.tanggal}`}
                  </Text>
                </TouchableOpacity>
              ))
            ) : (
              <Text>Loading options...</Text>
            )}

            <TouchableOpacity
              style={styles.closeButton}
              onPress={() => setModalVisibleJadwal(false)}
            >
              <Text style={styles.closeButtonText}>Terapkan</Text>
            </TouchableOpacity>
          </View>
        </View>
      </Modal>
            

            <Text style={styles.label}>Biaya</Text>
            <TextInput
                style={styles.input}
                placeholder="Rp 100.000"
                keyboardType="numeric"
                value={biaya}
                onChangeText={setBiaya}
            />

            <Text style={styles.label}>Range Umur</Text>
            <View style={styles.row}>
                <TextInput
                    style={[styles.input, styles.smallInput]}
                    placeholder="18"
                    keyboardType="numeric"
                    value={umurMin}
                    onChangeText={setUmurMin}
                />
                <TextInput
                    style={[styles.input, styles.smallInput]}
                    placeholder="30"
                    keyboardType="numeric"
                    value={umurMax}
                    onChangeText={setUmurMax}
                />
            </View>

            <Text style={styles.label}>Level</Text>
            <TouchableOpacity onPress={() => setModalVisible(true)}>
                <TextInput
                    style={styles.input}
                    placeholder="Pilih Level"
                    editable={false}
                    value={level || ''}
                />
            </TouchableOpacity>

            {/* Modal untuk memilih level */}
            <Modal
                animationType="slide"
                transparent={true}
                visible={modalVisible}
                onRequestClose={() => setModalVisible(false)}
            >
                <View style={styles.modalBackground}>
                    <View style={styles.modalContainer}>
                        <TouchableOpacity
                            onPress={() => handleSelectLevel('Pemula')}
                            style={styles.modalItem}
                        >
                            <Text>Pemula</Text>
                        </TouchableOpacity>
                        <TouchableOpacity
                            onPress={() => handleSelectLevel('Menengah')}
                            style={styles.modalItem}
                        >
                            <Text>Menengah</Text>
                        </TouchableOpacity>
                        <TouchableOpacity
                            onPress={() => handleSelectLevel('Profesional')}
                            style={styles.modalItem}
                        >
                            <Text>Profesional</Text>
                        </TouchableOpacity>
                        <TouchableOpacity onPress={() => setModalVisible(false)} style={styles.modalCloseButton}>
                            <Text>Tutup</Text>
                        </TouchableOpacity>
                    </View>
                </View>
            </Modal>

            <Text style={styles.label}>Kategori</Text>
            <TouchableOpacity onPress={() => setModalVisibleKategori(true)}>
                <TextInput
                    style={styles.input}
                    placeholder="Pilih Kategori"
                    editable={false}
                    value={kategori || ''}
                />
            </TouchableOpacity>

            {/* Modal untuk memilih kategori */}
            <Modal
                animationType="slide"
                transparent={true}
                visible={modalVisibleKategori}
                onRequestClose={() => setModalVisibleKategori(false)}
            >
                <View style={styles.modalBackground}>
                    <View style={styles.modalContainer}>
                        <TouchableOpacity
                            onPress={() => handleSelectKategori('Fun')}
                            style={styles.modalItem}
                        >
                            <Text>Fun</Text>
                        </TouchableOpacity>
                        <TouchableOpacity
                            onPress={() => handleSelectKategori('Competitive')}
                            style={styles.modalItem}
                        >
                            <Text>Competitive</Text>
                        </TouchableOpacity>
                        <TouchableOpacity onPress={() => setModalVisibleKategori(false)} style={styles.modalCloseButton}>
                            <Text>Tutup</Text>
                        </TouchableOpacity>
                    </View>
                </View>
            </Modal>

            <Text style={styles.label}>Slot Peserta</Text>
            <TextInput
                style={styles.input}
                placeholder="20"
                keyboardType="numeric"
                value={slotPeserta}
                onChangeText={setSlotPeserta}
            />

            <Text style={styles.label}>Deskripsi</Text>
            <TextInput
                style={[styles.input, styles.textArea]}
                placeholder="Masukkan deskripsi event"
                multiline
                value={deskripsi}
                onChangeText={setDeskripsi}
            />

            <TouchableOpacity style={styles.createButton} onPress={handleCreateMabar}>
                <Text style={styles.createButtonText}>Buat Event</Text>
            </TouchableOpacity>
        </ScrollView>
    );
}

const styles = StyleSheet.create({
    container: { flex: 1, backgroundColor: '#fff', padding: 16 },
    backButton: { position: 'absolute', top: 16, left: 16, zIndex: 10 },
    header: { textAlign: 'center', fontSize: 18, fontWeight: 'bold', marginBottom: 16 },
    label: { fontSize: 14, fontWeight: 'bold', marginTop: 12 },
    input: { borderWidth: 1, borderColor: '#ccc', borderRadius: 8, padding: 12, marginTop: 6 },
    disabledInput: { backgroundColor: '#f5f5f5', color: '#999' },
    row: { flexDirection: 'row', justifyContent: 'space-between' },
    smallInput: { width: '48%' },
    textArea: { height: 80, textAlignVertical: 'top' },
    createButton: { backgroundColor: '#002366', padding: 16, borderRadius: 8, alignItems: 'center', marginTop: 20, marginBottom: 40 },
    createButtonText: { color: '#fff', fontSize: 16, fontWeight: 'bold' },
    modalBackground: { flex: 1, justifyContent: 'center', alignItems: 'center', backgroundColor: 'rgba(0, 0, 0, 0.5)' },
    modalContainer: { backgroundColor: 'white', padding: 20, borderRadius: 10, width: 250, alignItems: 'center' },
    modalItem: { padding: 10, width: '100%', alignItems: 'center' },
    modalCloseButton: { marginTop: 20, padding: 10, backgroundColor: '#f1f1f1', borderRadius: 5 },
    modalOverlay: { flex: 1, justifyContent: 'center', alignItems: 'center', backgroundColor: 'rgba(0, 0, 0, 0.5)' },
    modalContent: { backgroundColor: 'white', padding: 20, borderRadius: 10, width: 300, alignItems: 'center' },
    modalTitle: { fontSize: 18, marginBottom: 15 },
    optionContainer: { flexDirection: 'row', alignItems: 'center', padding: 10, marginBottom: 10, borderWidth: 1, borderRadius: 5 },
    selectedOption: { backgroundColor: '#cce5ff' },
    optionText: { fontSize: 16 },
    closeButton: { marginTop: 15, backgroundColor: '#007BFF', padding: 10, borderRadius: 5 },
    closeButtonText: { color: 'white', fontSize: 16 },
});
