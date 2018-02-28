function detail(id_produit) {
    location = `/produit/detail/${id_produit}`;
}
function redirection() {
     location = `/produit/editer`;
}
function editer(evt,id_produit) {
    evt.stopPropagation;
     location = `/produit/editer/${id_produit}`;
}

function supprimerProduit(evt, id_produit) {
    evt.stopPropagation();
    if (confirm("vous êtes sûr de vouloir supprimer")) {
     location =  `/produit/supprimer/${id_produit}`;  
    }
}
