import React, {Component} from 'react';
import {NavigationContainer} from "@react-navigation/native";
import {createStackNavigator} from "@react-navigation/stack";
import HomePage from "./Screens/HomePage";
import TeachersPage from "./Screens/TeachersPage";
import {colors} from "./assets/colors";
import axios from "axios";

const api = axios.create({
    baseURL:"http://192.168.1.62:8000/api"
});

const {Screen, Navigator} = createStackNavigator();
export default class App extends Component {
    constructor(props) {
        super(props);
        api.post("/teachr/setDb").then(r=>{
            console.log(r.data);
        })
    }
    render() {
        return <NavigationContainer>
            <Navigator initialRouteName={"Teachers"} screenOptions={{
                headerStyle: {backgroundColor: colors.primary},
                headerTitleStyle: {
                    color: "white",
                    fontSize: 25
                },
                headerLeft: () => null,
                headerStatusBarHeight: 50,
            }}>
                <Screen name={"Teachers"} component={TeachersPage}
                        options={{
                            headerTitle: "Teach'rs favoris",
                            headerStatusBarHeight: 70,
                        }}
                />
                <Screen name={"Home"} component={HomePage}/>
            </Navigator>
        </NavigationContainer>
    }
}
