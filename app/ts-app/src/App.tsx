import * as React from 'react';
import './App.css';

const logo = require('./logo.svg');
const logo2 = require('./logo.1.svg');
const logo3 = require('./logo.2.svg');

class App extends React.Component {
  render() {
    return (
      <div className="App">
        <header className="App-header">
          <div className="preload-juggle">
            <div className="ball">
              <img src={logo} alt="logo" />
            </div>
            <div style={{width: '50px'}}className="ball">
              <img src={logo2} alt="logo" />
            </div>
            <div style={{width: '85px'}}className="ball">
              <img src={logo3} alt="logo" />
            </div>
          </div>
          <h1 className="App-title">Welcome to create-typescript-app PHP!</h1>
        </header>
        <p className="App-intro">
          To get started, edit <code>src/App.tsx</code> and save to reload.
        </p>
      </div>
    );
  }
}

export default App;
