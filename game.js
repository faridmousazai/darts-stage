 




let table = document.querySelector('table');

//  addRow();
 function addRow(){
    var newRow = table.insertRow(1);
    var cel1 = newRow.insertCell(0);
    var cel2 = newRow.insertCell(1);

    cel1.innerHTML = "1";
    cel2.innerHTML = "2";
 }


 

//  let btn = document.getElementById('add-score');
//  let input = document.getElementById('player-score');

//  btn.addEventListener('click', game);
// function game(){
//     var pscore = input.value;
//    console.log(pscore);
//     //Event listener for the submit button 
//     input.value = '';
//     //Get the value of the input
    

// }



// function nextRound(){
    
// }


// classes

class Player{
    constructor(id, name){
        this.id = id;
        this.name = name;
        this.score = 301;
    }
}


class Round{
    constructor(numberOfPlayer, table){
        this.numberOfPlayer = numberOfPlayer;
        this.table = table;
        this.cellIndex = 0;
        this.headNames = document.querySelectorAll('th');
        console.log(this.headNames);
    }
    addRow(){
        //Ajouter une ligne au tableau
        this.row = this.table.insertRow()
        for(let i = 0; i<this.numberOfPlayer; i++){
            this.row.insertCell(i);
        }
        this.headNames[this.cellIndex].classList.add('name');
    }
    //setScore(player,) insert score into cells of the current row
    setScore(score){
        //Ajouter un score dans une cellule de la ligne courante
        let cells = this.row.cells;
        if(this.cellIndex < this.numberOfPlayer){
            cells[this.cellIndex].innerHTML = score;
            this.headNames[this.cellIndex].classList.remove('name');
            this.cellIndex++;
            if(this.cellIndex < this.numberOfPlayer){
                this.headNames[this.cellIndex].classList.add('name');
            }else{
                this.headNames[0].classList.add('name');
            }
        }else{
            this.cellIndex = 0;
            this.addRow();
            this.setScore(score);
        }
    }

}

// 


class Game{
    constructor(){
        this.players = [];
    }
    init(){


        let btn = document.getElementById('add-score');
        let input = document.getElementById('player-score');

        

        let tableHead = document.querySelector("thead");
        var el = document.createElement('tr');

        

        for(const aPlayer of this.players){
            el.innerHTML += '<th>' + aPlayer.name+'</th>';
        }

        tableHead.prepend(el);

        //INIT ROUND

        const round = new Round(this.players.length, table)

        btn.addEventListener('click', () => {
            let pscore = input.valueAsNumber;

            //recuperer le joueur qui a joué
            let currentPlayerTableHead = table.querySelector('th.name')
            let allPlayersTableHead = table.querySelectorAll('th')
            let curentPlayerId = Array.prototype.indexOf.call(allPlayersTableHead, currentPlayerTableHead);
            let curentPlayer = this.players[curentPlayerId];

            //metre a jour le score de joueur
            let newScore = curentPlayer.score - pscore;
            if(newScore == 0){
                curentPlayer.score = newScore;
                document.getElementById("player-win").innerHTML = '<p>' + curentPlayer.name + ' A gagné </p> <a class="restart" href="index.html">Redémarrer</a>';
                document.querySelector(".flex").style.display = 'none';
            }
            else if(newScore > 0){
                curentPlayer.score = newScore;
            }

            round.setScore(curentPlayer.score);
            input.value = '';
        });
        
        round.addRow();
    }
    // TODO modifier la méthode addPlayer : elle prend en paramètre le nom du joueur. Elle créé directement le Player avec l'id défini selon le nombre de joueurs déjà créé, le nom du joueur, et le score par défaut de 301
    addPlayer(playerName){

        this.players.push(new Player(this.players.length, playerName));
    }
}

const game = new Game();

//https://developer.mozilla.org/en-US/docs/Web/API/URLSearchParams#examples//
//on recupire les informations dans le url puis on boucle sur les jouers pour les ajouter dan la parti game//
const searchParams = new URLSearchParams(window.location.search);

// Iterating the search parameters
for (const [key, value] of searchParams) {
    let player = key;//(key, value);
   
  if(value == "on" ){
    
    game.addPlayer(player);
  }
}



game.init();
console.log(game);