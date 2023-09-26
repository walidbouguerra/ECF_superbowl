import { useNavigation } from '@react-navigation/native';
import { useState } from 'react';
import { StyleSheet, Text, View, TextInput, Button } from 'react-native';

// Écran de connexion
export default function Login(){
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [message, setMessage] = useState('');
    const navigation = useNavigation();

    // Vérification des informations de connexion
    const login = () => {
        if(email == "" || password == "") {
            setMessage("E-mail ou mot de passe vides.");
        } else {
            fetch('http://localhost/api/login.php', {
                method: 'POST',
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    email: email,
                    password: password,
                }),
            })
            .then((response) => response.json())
            .then((json) => {
                if(json['success']) {
                    navigation.navigate("Dashboard", {user: json['user'], bets: json['bets']});
                } else {
                    setMessage(json['message']);
                }
            }).catch((error) => {
                console.error(error);
            })
        }
    }

    return (
        <View style={styles.container}>
            <Text style={{
                fontSize: 28,
                fontWeight: "bold",
                marginBottom: 15
            }}>Connexion</Text>
        <View>
            <Text>E-mail</Text>
            <TextInput 
                style={styles.textInput}
                onChangeText={(text) => setEmail(text)}
            />
        </View>
        <View style={{marginBottom: 10}}>
            <Text>Mot de passe</Text>
            <TextInput 
                style={styles.textInput}
                secureTextEntry={true}
                onChangeText={(text)=>setPassword(text)}
            />
        </View>
        <Button 
            title="Se connecter"
            onPress={login}   
        />
        <Text style={{color: "red", marginTop: 10}}>{message}</Text>
        </View>
    );
}


const styles = StyleSheet.create({
    container: {
      flex : 1,
      justifyContent: 'center',
      alignItems: 'center',
    },
    textInput: {
      borderWidth: 1,
      marginBottom: 10
    }
});
  