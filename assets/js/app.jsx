import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import {BrowserRouter, NavLink, Route, Switch} from 'react-router-dom';
import Main from './components/Main';
import Admin from './components/Admin';

require('../css/app.css');


class App extends Component {
    render() {
        return (
            <BrowserRouter>
                <ul>
                    <NavLink to="/">Personal Info</NavLink>
                    <NavLink to="/admin">Admin Panel</NavLink>
                </ul>
                <Switch>
                    <Route path="/admin" component={Admin}/>
                    <Route path="/" component={Main}/>
                </Switch>
            </BrowserRouter>
        );
    }
}

ReactDOM.render(<App />, document.getElementById('root'));