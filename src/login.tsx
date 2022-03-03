import "./polyfill";

import React from "react";
import { render } from "react-dom";
import * as web3 from "@solana/web3.js";

const Login: React.FC = () => {
  const [wallet, setWallet] = React.useState(null);

  React.useEffect(() => {
    (window as any).solana
      .connect({ onlyIfTrusted: true })
      .then((response: any) => {
        setWallet(response.publicKey.toString());
      });
  }, []);

  const handleConnect = async () => {
    const response = await (window as any).solana.connect();
    setWallet(response.publicKey.toString());
  };

  const handleDisconnect = async () => {
    await (window as any).solana.disconnect();
    setWallet(null);
  };

  const handleSignIn = async () => {
    const message = `Sign In to Wordpress with Solana`;
    const encodedMessage = new TextEncoder().encode(message);
    const signedMessage = await (window as any).solana.signMessage(
      encodedMessage,
      "utf8"
    );

    const { publicKey, signature } = signedMessage;
  };

  return !wallet ? (
    <button
      className="button button-primary"
      type="button"
      style={{ width: "100%", height: "52px", marginTop: "24px" }}
      onClick={handleConnect}
    >
      Connect to Phantom Wallet
    </button>
  ) : (
    <>
      <button
        className="button button-primary"
        type="button"
        style={{ width: "100%", height: "52px", marginTop: "24px" }}
        onClick={handleSignIn}
      >
        Sign In with Solana
      </button>
      <button
        className="button button-secondary"
        type="button"
        style={{ width: "100%", height: "52px", marginTop: "12px" }}
        onClick={handleDisconnect}
      >
        Disconnect from Phantom Wallet
      </button>
    </>
  );
};

window.onload = () => {
  const login = document.getElementById("loginform");
  const container = document.createElement("div");
  login.appendChild(container);

  render(<Login />, container);
};
