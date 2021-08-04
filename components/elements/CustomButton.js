import React from "react";
import {Text, TouchableOpacity, View} from "react-native";


export default class CustomButton extends React.Component{
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <TouchableOpacity style={this.props.styleButton} onPress={this.props.action} activeOpacity={0.8}>
                <Text style={this.props.styleLabel}>{this.props.labelText}</Text>
            </TouchableOpacity>
        );
    }

}