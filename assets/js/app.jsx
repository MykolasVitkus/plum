import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import {BrowserRouter, NavLink, Route, Switch} from 'react-router-dom';
import AdminForm from './components/AdminForm';
import Home from './components/Home';

require('../css/app.css');

class App extends Component
{
    render() {
        return (
            <BrowserRouter>
                <ul>
                    <NavLink to="/">Personal info</NavLink>
                    <NavLink to="/admin">Admin </NavLink>
                </ul>
                <Switch>
                    <Route path="/admin" component={AdminForm}/>
                    <Route path="/" component={Home}/>
                </Switch>
            </BrowserRouter>
        );
    }
}

ReactDOM.render(<App/>, document.getElementById('root'));