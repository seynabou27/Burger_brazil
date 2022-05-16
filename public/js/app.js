panier = document.getElementsByClassName("panier");
taleau = document.getElementById('tableau');

/* panier.addEventListener('click' , ()=>{
    for (let index = 0; index < array.length; index++) {
        const element = array[index];
}) */

compteur  = 0;

for (let index = 0; index < panier.length; index++) {
    panier[index].addEventListener('click',()=>{
        compteur ++
        tableau.innerHTML = compteur

    })
    
}





    
        
    
