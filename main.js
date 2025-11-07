//pega o formulario do index
const form = document.querySelector('form');
const pergunta = document.getElementById("pergunta");
const resposta = document.getElementById("resposta-sapo");

//evento para enviar ao ollama
form.addEventListener('submit', async (evento) => {
    
    evento.preventDefault(); 
    const texto_pergunta = pergunta.value;
    pergunta.value = '';

    // console.log("A pergunta foi:", texto_pergunta);
    
    resposta.innerText = "O Sapo Mago está pensando... (de espaço para ele, ele demora para pensar)";

    try {
        const response = await fetch('api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ pergunta: texto_pergunta })
        });
        const data = await response.json();
        resposta.innerText = data.resposta;

    } catch (erro) {
        console.error("Erro:", error);
        resposta.innerText = "O Sapo Mago não conseguiu responder... Tente novamente.";
    }
});