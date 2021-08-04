import React from "react";
import {Alert, Dimensions, Image, StyleSheet, Text, View} from "react-native";
import {colors} from "../assets/colors";
import CustomButton from "./elements/CustomButton";
import axios from "axios";
import {baseUrl} from "../config";

const {width, height} = Dimensions.get("window");
axios.defaults
const api = axios.create({
    baseURL: baseUrl
})

export default class TeachrCard extends React.Component {
    isMount = false;

    constructor(props) {
        super(props);
        this.retirerFavoris = this.retirerFavoris.bind(this)
        this.ajouterFavoris = this.ajouterFavoris.bind(this)
    }

    componentDidMount() {
        this.isMount = true
    }

    componentWillUnmount() {
        this.isMount = false
    }


    displayImage(source) {
        return (
            <View>

                <Image
                    accessibilityLabel="Photo de profils"
                    style={styles.teachrPhoto}
                    source={source ? {
                        uri: source
                    } : null}/>
            </View>
        )
    }

    async getData() {
        if (this.props.page === "favoris") {
                return await api.put('/teachr/favoris/1');
        } else {
            return await api.get('/teachr/list');

        }
    }

    async retirerFavoris(TeachrID) {
        await api.post('/teachr/delFavoris/1', {
            idTeachr: TeachrID
        })
        let dataObj = await this.getData();
        this.props.stateData.setData(dataObj.data);
        Alert.alert("Notification", "Teach'r retiré de vos favoris")
    }

    async ajouterFavoris(TeachrID) {
        await api.post('/teachr/addFavoris/1', {
            idTeachr: TeachrID
        })
        let dataObj = await this.getData();
        this.props.stateData.setData(dataObj.data);

        Alert.alert("Notification", "Teach'r ajouté à vos favoris")
    }

    displayFavorisButton() {
        if (this.props.isFavoris) {
            return <CustomButton labelText={"Retirer ce teach'r de mes favoris"}
                                 styleButton={{...buttonStyles.dangerButtonStyle}}
                                 styleLabel={{...buttonStyles.dangerStyleLabel}}
                                 action={() => this.retirerFavoris(this.props.id)}
            />
        } else {
            return <CustomButton labelText={"Ajouter ce teach'r à mes favoris"}
                                 styleButton={{...buttonStyles.successButtonStyle}}
                                 styleLabel={{...buttonStyles.successStyleLabel}}
                                 action={() => this.ajouterFavoris(this.props.id)}/>
        }
    }

    render() {
        return (
            <View style={styles.cardBox}>
                <View style={styles.teachrProfilBox}>
                    {this.displayImage(this.props.photo)}
                    <Text style={styles.teachrName}>{this.props.prenom}</Text>
                </View>
                <View style={styles.formationBox}>
                    <Text style={styles.cardLabel}>Formation</Text>
                    <Text style={styles.cardContent}>{this.props.formation}</Text>
                </View>
                <View style={styles.descriptionBox}>
                    <Text style={styles.cardLabel}>Description</Text>
                    <Text style={styles.cardContent}>{this.props.description}</Text>
                </View>
                <CustomButton labelText={"Prendre un cours avec ce teach'r"}
                              styleButton={{...buttonStyles.primaryButtonStyle}}
                              styleLabel={{...buttonStyles.primaryStyleLabel}}
                              action={this.props.actionRdv}/>
                {this.displayFavorisButton()}
            </View>
        )
    }

}

const buttonStyles = StyleSheet.create({
    primaryButtonStyle: {
        backgroundColor: colors.primary,
        flexDirection: "row",
        alignItems: "center",
        justifyContent: "center",
        textAlign: "center",
        minHeight: 50,
        marginVertical: 15,
        borderRadius: 7,
    },
    primaryStyleLabel: {
        color: "white",
        fontSize: 16
    },
    dangerButtonStyle: {
        flexDirection: "row",
        alignItems: "center",
        justifyContent: "center",
        textAlign: "center",
        minHeight: 50,
        borderRadius: 7,
        borderColor: colors.danger,
        borderWidth: 2
    },
    dangerStyleLabel: {
        color: colors.danger,
        fontSize: 16
    },
    successButtonStyle: {
        flexDirection: "row",
        alignItems: "center",
        justifyContent: "center",
        textAlign: "center",
        minHeight: 50,
        borderRadius: 7,
        borderColor: colors.success,
        borderWidth: 2
    },
    successStyleLabel: {
        color: colors.success,
        fontSize: 16
    }
})


const styles = StyleSheet.create({
    cardBox: {
        backgroundColor: colors.lightGray,
        minWidth: width - 150,
        minHeight: height - 200,
        maxHeight: height - 200,
        borderRadius: 20,
        elevation: 10,
        marginHorizontal: "auto",
        paddingHorizontal: 25,
        paddingVertical: 30,
        marginTop: 40
    },
    teachrProfilBox: {
        minWidth: width - 150,
        maxWidth: width - 120,
        flexDirection: "row",
        alignItems: "center",
        marginBottom: 40

    }, teachrPhoto: {
        width: 60,
        height: 60,
        borderRadius: 30,
        marginRight: 20
    },
    teachrName: {
        fontSize: 18,
        fontWeight: "bold"
    },
    formationBox: {
        marginBottom: 40
    },
    cardLabel: {
        fontSize: 15,
        color: "gray",
        marginBottom: 10
    },
    cardContent: {
        fontSize: 14,
        letterSpacing: 0.8
    },
    descriptionBox: {}
})