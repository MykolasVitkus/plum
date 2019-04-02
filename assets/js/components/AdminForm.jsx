import React, { Component } from 'react';

class AdminForm extends Component {
    render() {
        return ([
            <form>
                <label>Vardas</label>
                <input placeholder="{{app.user.username}}"/>
                <button>Submit</button>
            </form>
        ]);
    }
}



export default AdminForm;
