function verifyNotfy() {
    
    const req = new XMLHttpRequest; 
    const reqData = new XMLHttpRequest; 

    req.open("POST", "/notfy", true) // Recupera total de notificações.
    reqData.open("POST", "/reqdata", true) // Recupera os dados dos emails para preencher as notificações.
    
    req.onreadystatechange = function() {
        if (req.readyState == 4 && req.status == '200') {
            const tot = req.responseText;

            const route = window.location.href.split("/"); //recuperando dados da linha get.
            if (route[3] === "dashboard") { // Verificando se a rota é igual a dashboard para executar a injeção do valor de totalContacts.
                document.getElementById('TotNotfy').innerHTML = tot;
            } 
            
            document.getElementById('Allerts').innerHTML = tot;            
            if (tot != 0) {
                $("#notif-bullet").html(`<i class='fas fa-envelope-square'></i><span class='notif-bullet'></span>`);
            } 
        }
    }
    req.send();

    reqData.onreadystatechange = function() {
        if (reqData.readyState == 4 && reqData.status == '200') {
            let dados = JSON.parse(reqData.responseText)
            let areaDados = document.getElementById('Notfy-dados').innerHTML = '';

            for (let index = 0; index < dados.length; index++) {

                let taga = document.createElement('a');
                taga.className = "dropdown-item notify-item";
                taga.href = `/alterStatus?acao=alter&id=${dados[index].id}`;
                taga.id = "link-notfy";

                let tagp = document.createElement('p');
                tagp.className = "notify-details";
                
                let tagb = document.createElement('b');
                tagb.innerHTML = dados[index].name;
                tagb.id = "name-notfy";

                let tagspan = document.createElement('span');
                tagspan.innerHTML = dados[index].subject;
                tagspan.id = 'subject-notfy';

                let tagsmall = document.createElement('small');
                tagsmall.className = "text-muted";
                tagsmall.id = "data-system-notfy";
                tagsmall.innerHTML = dados[index].data_system

                taga.appendChild(tagp);
                tagp.appendChild(tagb);
                tagp.appendChild(tagspan);
                tagp.appendChild(tagsmall);

                document.getElementById('Notfy-dados').appendChild(taga);

                if (dados[index] == dados[index] ) {
                    continue
                };
            }
            
        }
    }
    reqData.send();    

}



$(document).ready(() => {
    verifyNotfy()
    
    setInterval(function() {
        verifyNotfy()
    }, 10000);
});

