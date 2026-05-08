function helloworld() {
    const gello = "Hello World";
    document.body.appendChild(document.createTextNode(gello));
}
window.addEventListener("load", helloworld);

const pi = 3.14 ;
var tab=[ 5, 8, 96 ];
for( let i=0 ; i < 10; i++ ) { } 

var paraph = document.querySelector("p");
paraph.addEventListener("click", function() {
    paraph.style.color = "red";
});
paraph.insertAdjacentHTML("beforeend", "<p> Hello </p>");
all = document.querySelectorAll("div");

var nbclick = 0;
var btn = document.getElementById("btn");
btn.addEventListener("click", function() {
    nbclick++;
    btn.textContent = "Nombre de clics : " + nbclick;
});

var maison={
    "couleur": "bleu",
    "porte": 3,
    "fenetre": 5,
    "toit": "en pente",
    "jardin": true,
    "inshort": function() {
        return "La maison est de couleur " + this.couleur + ", elle a " + this.porte + " portes, " + this.fenetre + " fenêtres, un toit " + this.toit + " et un jardin : " + this.jardin;
    },
    "toString": function() {
        return "Maison : couleur=" + this.couleur + ", porte=" + this.porte + ", fenetre=" + this.fenetre + ", toit=" + this.toit + ", jardin=" + this.jardin;
    }

}
document.body.appendChild(document.createTextNode(maison.inshort()));

function adresser_maison() {
    console.log(maison.inshort());
    console.log(maison.toString());
}
let adressage = adresser_maison;
console.log(adressage);
let immeuble = JSON.parse('{"couleur": "gris", "porte": 10, "fenetre": 20, "toit": "plat", "jardin": false}');
console.log(immeuble);
adresser_maison();
var heroes_promise=fetch("heroes.json");
function afficher_heroes(reponse) {
    let heroes = reponse.json();
    console.log(heroes);
}

heroes_promise.then(afficher_heroes);
fetch("heroes.json").then(rep => {console.log(rep.json())});

//Fonction qui prenss une promesse et fait deux choses en foonction de si remplie ou rejettée
function handlePromise(promise) {
    promise.then(function(result) {
        console.log("Promise résolue avec succès : " + result);
    }).catch(function(error) {
        console.error("Promise rejetée : " + error);
    });
}
fetch("heroes.json")
    .then( response => {
        if (!response.ok) {
            throw new Error("Erreur HTTP : " + response.status);
        }
        return response.json();
    })
    .then( data => {
        console.log(data);
    })
    .catch( error => {
        console.error("Erreur lors de la récupération des données : " + error);
    });

for (let i = 0; i < 5; i++) {
    setTimeout(function() {
        console.log("Index : " + i);
    }, 1000);
}

array = [1, 2, 3, 4, 5];
array.forEach(element => {
    
});

const recuper_ldata = async () => {
    try {
        const response = await fetch("heroes.json");
        if (!response.ok) {
            throw new Error("Erreur HTTP : " + response.status);
        }
        const data = await response.json();
        console.log(data);
    }
    catch (error) { 
        console.error("Erreur lors de la récupération des données : " + error);
    }
}   
recuper_ldata();
TAB = [{chamlbre : 12, nbperso:99, tel: 1, cage : 21}]


function modifa(chbr) {
    let madiv = document.querySelector("div");
    if (!madiv) {
        console.error("Aucune div trouvée!");
        return;
    }
    madiv.textContent = "";
    
    // Ajouter le titre
    madiv.appendChild(document.createTextNode("liste :"));
    
    // Créer la liste
    let ul = document.createElement("ul");
    
    chbr.forEach(elt => {
        let li = document.createElement("li");
        let texte = `Chambre: ${elt.chamlbre}, Personnes: ${elt.nbperso}, Tel: ${elt.tel}, Cage: ${elt.cage}`;
        li.appendChild(document.createTextNode(texte));
        ul.appendChild(li);
    });
    
    madiv.appendChild(ul);
    return madiv;
}

window.addEventListener("load", function() {
    modifa(TAB);
});