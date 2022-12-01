let btn = document.getElementById('add-player');

let players = document.querySelector('.players');
let form = document.getElementById('form');

btn.addEventListener('click', createPlayer);

function createPlayer() {
  let input = document.getElementById('player-name').value;
  let inputLname = document.getElementById('player-lname').value;
  let inputPmail = document.getElementById('player-mail').value;
 
  let player = 
  JSON.stringify({
    "nom":inputLname,
    "prenom":input,
    "mail":inputPmail,
   
   });
  //  console.log(player, player.length);
  fetch("http://localhost:4000/joueur",
  {
    //mode:"no-cors",
    method: 'POST',
    body: player ,
    headers: {
      "Content-Type":'application/json',
      "Accept":"*/*",
      "Content-length":player.length,
      connection: 'keep-alive',
    }

  }).then(res => console.log(res))
   .catch(err => console.log(err));

  
  
}

function removePlayer(){
    this.parentElement.remove();
}


//ajouter un eventlistenner quand on envoi le form pour retirer l'atribut disabled sur les inputs//
form.addEventListener('submit', function(event){
  var inputs = form.querySelectorAll('input[name="players[]"]');
  if(inputs.length < 2){
    event.preventDefault()
  }
  for (let index = 0; index < inputs.length; index++) {
    const input = inputs[index];
    input.removeAttribute('disabled');
    
  }
})
















