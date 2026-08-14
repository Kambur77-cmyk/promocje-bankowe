// public_html/js/auth.js
// Klient JS do obsługi Google Identity Services oraz prostych fetch'y do backendu PHP

// GSI callback
function handleCredentialResponse(response) {
  // response.credential === id_token
  fetch('/php/google_signin.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ id_token: response.credential })
  }).then(r => r.json()).then(data => {
    if (data.ok) {
      window.location.href = '/profile.html';
    } else {
      console.error('Google signin error', data);
      alert(data.error || 'Błąd logowania Google');
    }
  }).catch(err => {
    console.error(err);
    alert('Błąd sieci');
  });
}

// Helpery fetch (opcjonalne)
async function sendRegister(user) {
  const res = await fetch('/php/register.php', {
    method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(user)
  });
  return res.json();
}

async function sendLogin(creds) {
  const res = await fetch('/php/login.php', {
    method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(creds)
  });
  return res.json();
}

// expose to window if needed
if (typeof window !== 'undefined') {
  window.handleCredentialResponse = handleCredentialResponse;
  window.sendRegister = sendRegister;
  window.sendLogin = sendLogin;
}
