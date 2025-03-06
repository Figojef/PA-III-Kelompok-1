import { useState } from "react"
import { StyleSheet, Text, View, Button } from "react-native"
import { useDispatch, useSelector } from "react-redux"
import { testAddD } from "../slices/todoSlice"


const HomeScreen = ({navigation}) => {

    const [data, setData] = useState('data kosong')
    const [loading, setLoading] = useState(false)
    const [error, setError] = useState(null)
    const dispatch = useDispatch()
    
    const d = useSelector(state => state.todo1.testD)

    const getData = () => {
        return new Promise((resolve, reject) => {
            setTimeout(() => {
                const a = true
                if(a){
                    dispatch(testAddD({d : 'wow'}))
                    resolve('Data Cat')
                }else{
                    reject('failed')
                }
            }, 5000)
        })
    }
    
    const fetchData = async () => {
        setLoading(true)
        setError(null)
        
        try{
            const response = await getData()
            setData(data => response)
        }catch(e){
            setError(err => e)
        }finally{
            setLoading(load => false)
        }


    }

    return (
        <View style={styles.container}>
            {
                loading ? <Text style={styles2.loading}>Sedang loading...</Text>
                : error ? <Text style={styles2.failed}>{error}</Text>
                : <Text style={styles2.success}>{data}</Text>
            }
            <Button title="Test Get" onPress={fetchData} />
            <Text>
                Home Screens
            </Text>
            <Button title = "Go To Details" onPress={() => navigation.navigate('Details')} />

            </View>
    )
}

const styles2 = StyleSheet.create({
    success : {
        color : 'green',
        fontSize : 30
    },
    failed : {
        color : 'red',
        fontSize : 30

    },
    loading : {
        color : 'blue',
        fontSize : 30
    }
})

const styles = StyleSheet.create({
    container : {
        flex : 1,
        // justifyContent : "center",
        // alignItems : 'center'
    }
})

export default HomeScreen