import {Alert, Dimensions, SafeAreaView, StyleSheet, Text, TouchableOpacity, View} from "react-native";
import React, {Component} from "react";
import axios from "axios";
import TeachrCard from "../components/TeachrCard";
import Carousel from "react-native-snap-carousel";
import {faStar} from "@fortawesome/free-solid-svg-icons";
import {FontAwesomeIcon} from "@fortawesome/react-native-fontawesome";
import {baseUrl} from "../config";

axios.defaults
const api = axios.create({
    baseURL: baseUrl
})

export default class HomePage extends Component {
    constructor(props) {
        super(props);
        this.state = {
            data: [],
        }
        this.getData();
        this.renderItem = this.renderItem.bind(this)
    }


    renderItem({item, index}) {
        return (
            <TeachrCard
                photo={item.photo}
                prenom={item.prenom}
                formation={item.formation}
                actionRdv={() => Alert.alert('Action RDV')}
                isFavoris={item.isFavoris}
                id={item.id}
                description={item.description}
                stateData={{
                    data: this.state.data,
                    setData: this.setData.bind(this)
                }}
                page={"teach'rs"}

            />
        )

    }

    getData() {
        api.get('/teachr/list').then(r => {
            this.setState({
                data: r.data
            })
        });
    }

    setData = (data) => {
        this.setState({
            data: data
        })
    }


    render() {
        if(this.state.data.length>0){
            return (
                <SafeAreaView>
                    <View style={{minHeight: Dimensions.get("window").height, marginVertical: 20}}>
                        <Carousel
                            layout={"default"}
                            callbackOffsetMargin={10}
                            ref={ref => this.carousel = ref}
                            data={this.state.data}
                            sliderWidth={Dimensions.get("window").width}
                            sliderHeight={Dimensions.get("window").height}
                            itemWidth={300}
                            renderItem={this.renderItem}
                        />

                    </View>
                    <View style={styles.favoris}>
                        <TouchableOpacity onPress={() => this.props.navigation.navigate('Teachers')} activeOpacity={0.8}>
                            <FontAwesomeIcon icon={faStar} color={"white"} size={23}/>
                        </TouchableOpacity>
                    </View>
                </SafeAreaView>
            )
        } else{
            return(
                <SafeAreaView>
                    <View style={{flex:1,marginTop:250,justifyContent: "center",alignItems: "center"}}>
                        <Text style={
                            {
                                fontSize:22,
                                fontWeight:"bold"
                            }
                        }> Aucun teach'r trouvé </Text>
                    </View>
                    <View style={styles.favoris}>
                        <TouchableOpacity onPress={() => this.props.navigation.navigate('Teachers')} activeOpacity={0.8}>
                            <FontAwesomeIcon icon={faStar} color={"white"} size={23}/>
                        </TouchableOpacity>
                    </View>
                </SafeAreaView>
            )
        }
    }
}

const styles = StyleSheet.create({
    favoris: {
        position: "absolute",
        zIndex: 4,
        top: -52,
        right: 7,
        paddingVertical: 15,
        paddingHorizontal: 15,
        justifyContent: "center",
        alignItems: 'center'

    }
})