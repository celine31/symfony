function detail(id_produit) {
    location = `/produit/detail/${id_produit}`;
}
function redirection() {
     location = `/produit/editer/`;
}
function modifier(evt,id_produit) {
    evt.stopPropagation;
     location = `/produit/editer/$id_produit`;
}

async function supprimerProduit(evt, id_produit) {
    evt.stopPropagation();
    if (confirm("vous êtes sûr de vouloir supprimer")) {
        var reponse = await new AjaxPromise('supprimer.php').send({id_produit: id_produit});
        reponse === 1 ? evt.target.parentElement.parentElement.style.display = 'none' : location.reload();
    }
}
