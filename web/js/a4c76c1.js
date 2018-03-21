// Script de index
//Permet la gestion de cookies pour ajouter le type d'oubli actif en cookie
//Permet d'afficher le formulaire de l'oubli actif (et de masquer les autres)
function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
function eraseCookie(name) {
    document.cookie = name+'=; Max-Age=-99999999;';
}

var tabOublis = document.getElementById('tab_oubli_classe_general');

function btnPulse(evt) {
    var btnSave=document.getElementById('form_tabOubliClasse_save');
    btnSave.classList.add('pulse');
}
if (tabOublis !== null){
    tabOublis.addEventListener("click", btnPulse, false);
}

if(typeof nbTypeOublis !== 'undefined'){
    for(var i=1; i<=nbTypeOublis ;i++){
        $('#btn_oubli'+i).click(function(){
            for(var j=1; j<=nbTypeOublis ;j++){
                $('#tab_oubli_classe'+j).addClass('hidden');
                $('#btn_oubli'+j).removeClass('btn-primary');
            }
            var nbBtn=this.id.substr(9,1);
            $('#tab_oubli_classe'+nbBtn).removeClass('hidden');
            $('#btn_oubli'+nbBtn).addClass('btn-primary');
            setCookie('nbBtnOublis',nbBtn,3);
        });
    }

    var nbBtnOublis=getCookie('nbBtnOublis');
    if(nbBtnOublis==null){
        nbBtnOublis=1;
    }
    $('#btn_oubli'+nbBtnOublis).addClass('btn-primary');
    $('#tab_oubli_classe'+nbBtnOublis).removeClass('hidden');
}

