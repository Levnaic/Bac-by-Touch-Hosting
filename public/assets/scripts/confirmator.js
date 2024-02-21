
function confirmDelete(id){
    if(confirm("Da li ste sigurni da želite da obrišete ovu stavku?")){
        document.getElementById("deleteForm_" + id).submit();
    }
}

function confirmUpdate(id){
    console.log(id);
    if(confirm("Da li ste sigurni da ažurirate ovu stavku?")){
        console.log(document.getElementById("updateForm_" + id));
        document.getElementById("updateForm_" + id).submit();
    }
}
