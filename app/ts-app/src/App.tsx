import * as React from "react";
import "./App.css";

import logo1 from "./logo1.svg";
import logo2 from "./logo2.svg";
import logo3 from "./logo3.svg";

class App extends React.Component {
  public render() {
    return (
      <div className="App">
        <header className="App-header">
          <div className="preload-juggle">
            <div className="ball">
              <img src={logo1} alt="logo" />
            </div>
            <div style={{ width: "50px" }} className="ball">
              <img src={logo2} alt="logo" />
            </div>
            <div style={{ width: "85px" }} className="ball">
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
