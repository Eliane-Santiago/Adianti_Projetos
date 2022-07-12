
    var seg=0;
    var min=0;
    var hor=0;
    var intervalo=0;
   

    //Função para o cronometro nesse formato '00:00:00'
    function doisDigitos(digito){

        if(digito<10){
            return('0' + digito);
        }else{
            return(digito);
        }
    }

    function iniciar (){
       intervalo = setInterval(contador, 10);
    }

    function pausar (){
        clearInterval(intervalo);
    }

    function zerar (){
        clearInterval(intervalo);
        seg=0;
        min=0;
        hor=0;

        document.getElementById('temporizador').innerText=doisDigitos(hor)+':'+doisDigitos(min)+':'+doisDigitos(seg)
    }


    function contador(){

        seg=++;

        if(seg==60){
            min++;
            seg=0;
            if(min==60){
                hor++;
                min=0;
            }
        }

        document.getElementById('temporizador').innerText=doisDigitos(hor)+':'+doisDigitos(min)+':'+doisDigitos(seg);

        
    }