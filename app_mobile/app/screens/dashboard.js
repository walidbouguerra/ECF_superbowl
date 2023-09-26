import { StyleSheet, Text, View, FlatList, TouchableOpacity } from 'react-native';

export default function Dashboard({navigation, route}) {
    // Affichage d'un match dans la liste
    const oneGame = ({item}) => (
        <TouchableOpacity
            onPress={() => navigation.navigate("Match", {game: item})}
        >
            <View> 
                <Text style={item.gameStatus != "En cours" ? {color: "gray"} : null}>{item.game_date}</Text>
                <Text style={item.gameStatus != "En cours" ? {color: "gray"} : null}>Début : {item.start} - Fin : {item.end}</Text>
                <Text style={item.gameStatus != "En cours" ? {color: "gray"} : null}>{item.t1_name} vs {item.t2_name}</Text>
                <Text style={item.gameStatus != "En cours" ? {color: "gray"} : null}>{item.score_1} - {item.score_2}</Text>
            </View>
        </TouchableOpacity>
    )

    const itemSeparator = () => {
        return <View style={{height: 1, width: '100%', backgroundColor: "black", marginVertical: 10}}></View>
    }

    return(
        <View style={{justifyContent: "center", alignItems: "center"}}>
            <Text style={{fontSize: 24, fontWeight: 'bold', marginVertical: 15}}>Mes Paris</Text>
            <View>
                <FlatList
                    data = {route.params.bets}
                    renderItem = {oneGame}
                    ItemSeparatorComponent={itemSeparator}
                />
            </View>
        </View>
    );
}

const styles = StyleSheet.create({
    textColor: {
      color: "red"
    }
});