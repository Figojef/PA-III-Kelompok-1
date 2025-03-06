import { StyleSheet, Text, View } from "react-native"
import TodoInput from "./TodoInput"
import { useDispatch, useSelector } from "react-redux"
import { Button } from "react-native-paper"
import { remove } from "../slices/todoSlice"


const DetailScreen = () => {

    const dispatch = useDispatch()
    const todos = useSelector(state => state.todo1.todos)

    const handleRemove = id => {
        dispatch(remove({id}))
    }

    const d = useSelector(state => state.todo1.testD)

    // console.log(todos)
    return (
        <View style = {styles.container}>
            <Text>
                Detail Screens {d}
            </Text>
            <TodoInput/>
            {
                todos.map((element, index) => <View style={{flex:1, flexDirection:'column'}} key={index}><Text>{element.name}</Text>
                <Button style={{backgroundColor:'red'}} onPress={() => handleRemove(element.id)}>Delete</Button>
                </View>)
            }
        </View>
    )
}

const styles = StyleSheet.create({
    container : {
        flex : 1,
        justifyContent : 'center',
        alignItems : 'center'
    }
})

export default DetailScreen