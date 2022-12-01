// function listDejoueurs(){
//     alert("Page is loaded");


function listDejoueurs() {
    fetch("http://localhost:4000/list-joueurs",
    {
      //mode:"no-cors",
      method: 'GET',
      headers: {
        "Content-Type":'application/json',
        "Accept":"*/*",
        connection: 'keep-alive',
      }
  
    }).then(response => {
        response.json()
        .then(listPlayer => {

                // reception liste des joueurs
                let listjoueurs = document.getElementById("form");
                let table = document.createElement("table");
                listjoueurs.append(table);

                let thVide = document.createElement("th");
                table.append(thVide);

                let thNom = document.createElement('th');
                thNom.innerHTML = "Nom";
                table.append(thNom);

                let thPrenom = document.createElement('th');
                thPrenom.innerHTML = "Prenom";
                table.append(thPrenom);

                let thMail = document.createElement('th');
                thMail.innerHTML = "Mail";
                table.append(thMail);

                let i = 0;

                listPlayer.forEach(list=>{
                    let tr = document.createElement("tr");
                    table.append(tr);

                    /*  ici on met les checkbox */
                    let checkbox = document.createElement("input");
                    checkbox.setAttribute("type", "radio");
                    checkbox.setAttribute("id", list.id);
                    checkbox.setAttribute("name", "suppression")
                    tr.append(checkbox);

                    let tdNom = document.createElement("td");
                    tdNom.innerHTML = list.nom;
                    tr.append(tdNom);


                    let tdPrenom = document.createElement("td");
                    tdPrenom.innerHTML = list.prenom;
                    tr.append(tdPrenom);

                    let tdMail = document.createElement("td");
                    tdMail.innerHTML = list.mail;
                    tr.append(tdMail);

                    // listjoueurs.append(prenom);
                    // listjoueurs.append(mail);
                })



               


                form.addEventListener('submit', function(event){
                  var inputs = document.querySelectorAll('input[type=radio]:checked');
              
              
                  // var inputs = form.querySelectorAll('input[name="players[]"]');
                  // if(inputs.length < 2){
                  //   event.preventDefault()
                  // }
                  for (let index = 0; index < inputs.length; index++) {
                    const input = inputs[index];
                    input.removeAttribute('disabled');
                    
                  }
                  // console.log("debut");
                  fetch("http://localhost:4000/joueur/del/"+inputs[0].id,
                  {
                    //mode:"no-cors",
                    method: 'DELETE',
                
                    headers: {
                      "Content-Type":'application/json',
                      "Accept":"*/*",
                      connection: 'keep-alive',
                    }
                
                  }).then(res => console.log(res))
                   .catch(err => console.log(err));
                  
                   
                })
               
                //......
               
                console.log(listPlayer);
            })
        .catch(err => console.log(err))
    }).catch(err => console.log(err));
}
 



