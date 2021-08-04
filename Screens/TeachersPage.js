import {Alert, Button, Dimensions, SafeAreaView, Text, TouchableOpacity, View} from "react-native";
import React, {Component} from "react";
import {FontAwesomeIcon} from '@fortawesome/react-native-fontawesome'
import {faChevronLeft, faStar} from '@fortawesome/free-solid-svg-icons'
import axios from "axios";
import TeachrCard from "../components/TeachrCard";
import Carousel from "react-native-snap-carousel";
import {colors} from "../assets/colors";
import {baseUrl} from "../config";

const api = axios.create({
    baseURL: baseUrl
})

export default class TeachersPage extends Component{
    constructor(props) {
        super(props);
        this.state={
            data:[]
        }
        this.getData();
        this.renderItem = this.renderItem.bind(this)
    }
    getData() {
        api.put('/teachr/favoris/1').then(r => {
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
    componentDidUpdate(prevProps, prevState, snapshot) {
        this.getData()
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
                page={'favoris'}

            />
        )

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
                    <TouchableOpacity onPress={()=>{
                        this.props.navigation.navigate("Home")}
                    } style={{
                        position:"absolute",
                        top: -80,
                        left:15,
                        zIndex:2,
                    }}>
                        <Text >
                            <FontAwesomeIcon icon={faChevronLeft} color={"white"} size={25} />
                        </Text>
                    </TouchableOpacity>
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
                        }> Pas de Teachr trouvé </Text>
                       <TouchableOpacity onPress={()=>this.props.navigation.navigate("Home")} activeOpacity={0.8} style={{
                           backgroundColor:colors.primary,
                           marginTop:15,
                           minHeight:50,
                           minWidth:200,
                           justifyContent:"center",
                           alignItems:"center",
                       }}>
                           <Text style={{
                               color:"white",
                               fontSize:17
                           }}>Voir tout les Teach'rs</Text>
                       </TouchableOpacity>
                    </View>
                    <TouchableOpacity onPress={()=>{
                        this.props.navigation.navigate("Home")}
                    } style={{
                        position:"absolute",
                        top: -80,
                        left:15,
                        zIndex:2,
                    }}>
                        <Text >
                            <FontAwesomeIcon icon={faChevronLeft} color={"white"} size={25} />
                        </Text>
                    </TouchableOpacity>
                </SafeAreaView>
            )
        }
    }
}