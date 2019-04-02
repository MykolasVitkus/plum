import React from 'react';
import ReactDOM from 'react-dom';
import {BrowserRouter, NavLink, Route, Switch} from 'react-router-dom';
import Main from './components/Main'
import Edit from './components/Edit'

require('../css/app.css');


class App extends React.Component {
    render() {
        return (
            <BrowserRouter>
                <ul>
                    <NavLink to="/">Personal Info</NavLink>
                    <NavLink to="/edit">Edit Info</NavLink>
                </ul>
                <Switch>
                    <Route path="/" component={Main}/>
                    <Route path="/edit" component={Edit}/>
                </Switch>
            </BrowserRouter>
        );
    }
}

ReactDOM.render(<App />, document.getElementById('root'));