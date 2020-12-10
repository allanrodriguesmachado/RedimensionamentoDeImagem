<?php

require 'class/Redimensionamento.php';

//Instancia da classe
$imagem = new Redimensionamento();

//Redimensionar
$imagem->imagem = "imagem/teste.png";

//Configura a imagem de destino. Se você for apenas exibir uma imagem temporária, comente esta linha
$imagem->imagem_destino = 'arquivos/nova_imagem.png';

//Se uma largura for definida, você pode deixar a classe calcular o aspect
//ratio da imagem deixando a altura zerada. O mesmo vale para a largura, porém,
//uma altura deverá existir (uma das duas deve ser definida).
$imagem->largura = 520;

// Altura de forma automatica
$imagem->altura = 0;

// Qualidade  0 a 100
$imagem->qualidade = 100;

// Gerar Nova imagem
$nova_imagem = $imagem->executa();

// Imagem Temporaria
if($imagem->imagem_destino && $nova_imagem) {
    echo "<img src='{$nova_imagem}'>";
}

// Mostra os erros que ocorreu
if($imagem->erro) echo $imagem->erro;
