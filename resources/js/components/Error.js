import React,{Component} from 'react';

export default class Error extends Component
{
    constructor(props)
    {
        super(props);
    }

    render()
    {
        return(
            <div className="flexRow r_error">{this.props.error}</div>
        )
    }
}