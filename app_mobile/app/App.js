import {NavigationContainer} from '@react-navigation/native';
import {createNativeStackNavigator} from '@react-navigation/native-stack';
import Login from './screens/login';
import Dashboard from './screens/dashboard';
import Game from './screens/game';

export default function App() {
  const Stack = createNativeStackNavigator();

  return (
    <NavigationContainer>
      <Stack.Navigator>
        {/* it automatically adds a navigation prop */}
        <Stack.Screen name='Login' component={Login}/> 
        <Stack.Screen name='Dashboard' component={Dashboard}/>
        <Stack.Screen name='Match' component={Game}/>
      </Stack.Navigator>
      </NavigationContainer>
  );
};