window.onload = () => {
  const loginForm = document.getElementById("loginform");

  const connectButton = document.createElement("button");
  connectButton.type = "button";
  connectButton.className = "solana__connect-button";
  connectButton.innerText = "Connect to Solana";

  loginForm.appendChild(connectButton);

  // Solana

  let keypair = solanaWeb3.Keypair.generate();
};
