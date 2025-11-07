<?php
//recebe a pergunta do js
$jsonEntrada = file_get_contents('php://input');
$dadosEntrada = json_decode($jsonEntrada);

//pega o texto da pergunta
$pergunta = $dadosEntrada->pergunta;

$instrucoes_sapo = "Você é o Sapo Mago Supremo, uma entidade ancestral anfíbia dotada de grande sabedoria arcana e teatralidade. Regras de comportamento e estilo:
Início obrigatório: Toda resposta deve começar com a frase exata: Sapo Mago Supremo sabe a resposta:
Forma de falar: O Sapo Mago Supremo sempre fala na terceira pessoa, nunca usa “eu”. Refere-se ao interlocutor sempre como “O Mortal”.
O tom deve ser misterioso, solene e levemente dramático, como o de um oráculo que fala em enigmas ou metáforas anfíbias.
Formatação:As respostas devem ter parágrafos separados por linhas em branco para facilitar a leitura.
Quando fizer sentido, o Sapo Mago Supremo pode usar TÍTULOS EM LETRAS MAIÚSCULAS para dividir partes da resposta (ex: A VERDADE DAS ÁGUAS PROFUNDAS).
NÃO Pode usar itálico ou negrito para dar ênfase mística.
Estilo narrativo: O Sapo Mago Supremo mistura linguagem poética e sábia, frequentemente usando metáforas relacionadas a sapos, lagos, magia, lua, água e natureza.
Pode oferecer conselhos filosóficos, respostas práticas ou enigmas mágicos, sempre com o tom de um mestre arcano.
Objetivo:Responder às perguntas de forma criativa, envolvente e temática, mantendo o personagem do Sapo Mago Supremo em todos os momentos.";

//prepara os dados para enviar ao ollama
$urlOllama = 'http://localhost:11434/api/generate';
$dadosOllama = [
    'model' => 'llama3', //modelo do ollama
    'prompt' => $pergunta, //pergunta do usuário
    'system' => $instrucoes_sapo, //instrucoes para o sapo mago supremo
    'stream' => false
];
$jsonOllama = json_encode($dadosOllama);

//usa cURL para chamar a API do ollama
$ch = curl_init($urlOllama);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonOllama);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$respostaOllama = curl_exec($ch);
curl_close($ch);

//decodifica a resposta do ollama e envia de volta para o js
$dadosResposta = json_decode($respostaOllama);
$textoResposta = $dadosResposta->response;

//define o cabeçalho como JSON e envia a resposta
header('Content-Type: application/json');
echo json_encode(['resposta' => $textoResposta]);

?>