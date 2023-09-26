import { StyleSheet, Text, View, FlatList} from 'react-native';
import { useEffect, useState } from 'react';

// Détails d'un match
export default function Game({navigation, route}) {
    const game = route.params.game;
    const [comments, setComments] = useState([]);
    const [score_1, setScore1] = useState([]);
    const [score_2, setScore2] = useState([]);
    const itemSeparator = () => {
        return <View style={{height: 1, width: '100%', backgroundColor: "black", marginVertical: 10}}></View>
    }
    // Récupération et actualisation des données
      useEffect(() => {
        const fetchData = async () => {
            fetch('http://localhost/api/comments.php', {
                    method: 'POST',
                    headers: {
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        id_game: game.id_game,
                        
                    }),
                })
                .then((response) => response.json())
                .then((json) => {
                    setComments(json['comments']);
                    setScore1(json['score_1']);
                    setScore2(json['score_2']);
                }).catch((error) => {
                    console.error(error);
                });
        };
            
        const id = setInterval(() => {
            fetchData(); 
        }, 30000);

        fetchData();

        return () => clearInterval(id);
    }, [])


    return(
        <View style={{alignItems: "center", marginTop: 20}}>
            <Text>{game.game_date}</Text>
            <Text>Début : {game.start} - Fin : {game.end}</Text>
            <Text>{game.t1_name} vs {game.t2_name}</Text>
            <Text>Mise : {game.amount}$ - {game.t3_name}</Text>
            <Text>Gains : {game.earnings}</Text> 
            <Text>Scores : {score_1.score_1} - {score_2.score_2}</Text>
            <Text style={{textAlign: 'center', marginTop: 10, marginBottom: 5, fontWeight: 'bold'}}>Commentaires :</Text> 
            <FlatList
                data = {comments}
                renderItem = {({item}) => (
                    <Text>{item.text}</Text>
                )}
                ItemSeparatorComponent={itemSeparator}
            />
        </View>
    );
}