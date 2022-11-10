let btn = document.getElementById('add-player');
let input = document.getElementById('player-name');
let players = document.querySelector('.players');
let form = document.getElementById('form');

btn.addEventListener('click', createPlayer);
function createPlayer(){
  
  
    // A LA PLACE DE LA div, Créer un input
    
    var el = document.createElement('input');
    el.setAttribute('name', 'players[]');
   
    el.value = input.value;
      //Désactiver l'input pour empecher l'utilisateur de mettre du texte : https://www.w3schools.com/tags/tryit.asp?filename=tryhtml_input_disabled
      el.setAttribute('disabled', 'disabled');


    //Modifier le CSS pour avoir la même apparence qu'à l'origine
    
    //Modifier le HTML pour que la div players devienne un form, lui attribuer la méthode get : https://www.w3schools.com/tags/tryit.asp?filename=tryhtml_form_method
    // el.innerHTML = '<label>'  + '</label><img src="/logos/x.svg">';
    var label = document.createElement('label');
    label.classList.add('player');
    label.appendChild(el);
    var img = document.createElement('img');
    img.src = "logos/x.svg";
    label.appendChild(img);

    players.append(label);
    input.value = '';
    var img = label.querySelector('img');
    img.addEventListener('click', removePlayer);
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







